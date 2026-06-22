<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class CommunityController extends Controller
{
    protected $db;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->db = $factory->createDatabase();
    }

    // 1. Create Community
    public function createCommunity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:2048',
        ]);

        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('communities', 'public');
            $avatarUrl = url('storage/'.$path);
        }

        $communityId = 'community_'.time().'_'.uniqid();
        $announcementGroupId = 'group_'.time().'_announcement_'.uniqid();
        $generalGroupId = 'group_'.time().'_general_'.uniqid();

        // 1. Create Announcement Group
        $announceData = [
            'id' => $announcementGroupId,
            'isGroup' => true,
            'is_group' => true,
            'is_announcement' => true,
            'name' => 'Announcements',
            'community_name' => $request->name,
            'avatar' => $avatarUrl,
            'users' => [$userId],
            'admins' => [$userId],
            'createdBy' => $userId,
            'created_by' => $userId,
            'createdAt' => now()->timestamp,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'last_message' => 'Welcome to your community!',
            'last_message_time' => now()->timestamp,
            'disappearingTimer' => 0,
            'community_id' => $communityId,
            'permissions' => [
                'editSettings' => false,
                'sendMessages' => false,
                'addMembers' => false,
            ],
        ];

        // Write groups to Realtime DB
        $this->db->getReference("groups/$announcementGroupId")->set($announceData);

        // Push initial messages
        $this->db->getReference("groups/$announcementGroupId/messages")->push([
            'text' => 'Welcome to your community!',
            'sender_id' => $userId,
            'time' => now()->timestamp,
            'type' => 'text',
            'status' => 'read',
        ]);

        // 2. Create General Group
        $generalData = [
            'id' => $generalGroupId,
            'isGroup' => true,
            'is_group' => true,
            'is_general' => true,
            'name' => 'General',
            'community_name' => $request->name,
            'avatar' => $avatarUrl,
            'users' => [$userId],
            'admins' => [$userId],
            'createdBy' => $userId,
            'created_by' => $userId,
            'createdAt' => now()->timestamp,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'last_message' => 'Welcome to the General group!',
            'last_message_time' => now()->timestamp,
            'disappearingTimer' => 0,
            'community_id' => $communityId,
            'permissions' => [
                'send_messages' => 'all',
                'edit_group_info' => 'admins',
            ],
        ];

        // Write groups to Realtime DB
        $this->db->getReference("groups/$generalGroupId")->set($generalData);

        // Push initial messages
        $this->db->getReference("groups/$generalGroupId/messages")->push([
            'text' => 'Welcome to the General group!',
            'sender_id' => $userId,
            'time' => now()->timestamp,
            'type' => 'text',
            'status' => 'read',
        ]);

        // 3. Create Community Meta Info
        $communityData = [
            'id' => $communityId,
            'name' => $request->name,
            'description' => $request->description ?? '',
            'avatar' => $avatarUrl,
            'created_by' => $userId,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'announcement_group_id' => $announcementGroupId,
            'groups' => [$announcementGroupId, $generalGroupId],
            'users' => [$userId],
            'admins' => [$userId],
        ];

        $this->db->getReference("communities/$communityId")->set($communityData);

        return response()->json([
            'status' => true,
            'message' => 'Community created successfully',
            'community_id' => $communityId,
            'data' => $communityData,
        ]);
    }

    // 2. Add Existing Groups to Community
    public function addGroups(Request $request, $communityId)
    {
        $request->validate([
            'group_ids' => 'required|array',
        ]);

        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        // Validate admin rights
        $admins = $community['admins'] ?? [];
        if (! in_array($userId, $admins)) {
            return response()->json(['status' => false, 'message' => 'Only community admins can add groups'], 403);
        }

        $communityGroups = $community['groups'] ?? [];
        $communityUsers = $community['users'] ?? [];

        $announcementGroupId = $community['announcement_group_id'];

        foreach ($request->group_ids as $groupId) {
            $groupRef = $this->db->getReference("groups/$groupId");
            $group = $groupRef->getValue();

            if ($group) {
                // Attach community_id to the group
                $groupRef->update(['community_id' => $communityId]);

                if (! in_array($groupId, $communityGroups)) {
                    $communityGroups[] = $groupId;
                }

                // Add group users to community users
                $groupUsers = $group['users'] ?? [];
                $communityUsers = array_merge($communityUsers, $groupUsers);

                // Push message to the added group: community_added type
                $this->db->getReference("groups/$groupId/messages")->push([
                    'text' => 'Group added to community',
                    'sender_id' => $userId,
                    'sender_name' => auth()->user()->name ?? 'Admin',
                    'time' => now()->timestamp,
                    'type' => 'community_added',
                    'status' => 'read',
                    'community_id' => $communityId,
                    'community_name' => $community['name'],
                ]);

                // Push welcome_announcement to Announcement group
                $this->db->getReference("groups/$announcementGroupId/messages")->push([
                    'text' => 'Welcome to the community!',
                    'sender_id' => $userId,
                    'sender_name' => auth()->user()->name ?? 'Admin',
                    'time' => now()->timestamp,
                    'type' => 'welcome_announcement',
                    'status' => 'read',
                    'community_id' => $communityId,
                    'community_name' => $community['name'],
                ]);

                // Push group_link_announcement to Announcement group
                $this->db->getReference("groups/$announcementGroupId/messages")->push([
                    'text' => (auth()->user()->name ?? 'Admin') . " added the group '" . ($group['name'] ?? 'Group') . "'",
                    'sender_id' => $userId,
                    'sender_name' => auth()->user()->name ?? 'Admin',
                    'time' => now()->timestamp,
                    'type' => 'group_link_announcement',
                    'status' => 'read',
                    'group_id' => $groupId,
                    'group_name' => $group['name'] ?? 'Group',
                ]);
            }
        }

        $communityUsers = array_values(array_unique($communityUsers));
        $communityGroups = array_values(array_unique($communityGroups));

        // Update community in Realtime DB
        $communityRef->update([
            'groups' => $communityGroups,
            'users' => $communityUsers,
            'updated_at' => now()->timestamp,
        ]);

        // Also add all community users to the Announcement group
        $this->db->getReference("groups/$announcementGroupId")->update([
            'users' => $communityUsers,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Groups added successfully',
        ]);
    }

    // 3. Create New Group inside Community
    public function createGroupInCommunity(Request $request, $communityId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $groupId = 'group_'.time().'_'.uniqid();

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('groups', 'public');
            $avatarUrl = url('storage/'.$path);
        }

        $newGroupData = [
            'id' => $groupId,
            'isGroup' => true,
            'is_group' => true,
            'name' => $request->name,
            'avatar' => $avatarUrl,
            'description' => $request->description ?? '',
            'users' => [$userId],
            'admins' => [$userId],
            'createdBy' => $userId,
            'created_by' => $userId,
            'createdAt' => now()->timestamp,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'last_message' => 'Group created in community',
            'last_message_time' => now()->timestamp,
            'disappearingTimer' => 0,
            'community_id' => $communityId,
            'permissions' => [
                'send_messages' => 'all',
                'edit_group_info' => 'admins',
            ],
        ];

        // Save group
        $this->db->getReference("groups/$groupId")->set($newGroupData);
        
        // Push message to the new group: community_added type
        $this->db->getReference("groups/$groupId/messages")->push([
            'text' => 'Group added to community',
            'sender_id' => $userId,
            'sender_name' => auth()->user()->name ?? 'Admin',
            'time' => now()->timestamp,
            'type' => 'community_added',
            'status' => 'read',
            'community_id' => $communityId,
            'community_name' => $community['name'],
        ]);

        $announcementGroupId = $community['announcement_group_id'] ?? null;
        if ($announcementGroupId) {
            // Push welcome_announcement to Announcement group
            $this->db->getReference("groups/$announcementGroupId/messages")->push([
                'text' => 'Welcome to the community!',
                'sender_id' => $userId,
                'sender_name' => auth()->user()->name ?? 'Admin',
                'time' => now()->timestamp,
                'type' => 'welcome_announcement',
                'status' => 'read',
                'community_id' => $communityId,
                'community_name' => $community['name'],
            ]);

            // Push group_link_announcement to Announcement group
            $this->db->getReference("groups/$announcementGroupId/messages")->push([
                'text' => (auth()->user()->name ?? 'Admin') . " added the group '" . $request->name . "'",
                'sender_id' => $userId,
                'sender_name' => auth()->user()->name ?? 'Admin',
                'time' => now()->timestamp,
                'type' => 'group_link_announcement',
                'status' => 'read',
                'group_id' => $groupId,
                'group_name' => $request->name,
            ]);
        }

        // Add to community groups list
        $communityGroups = $community['groups'] ?? [];
        if (! in_array($groupId, $communityGroups)) {
            $communityGroups[] = $groupId;
            $communityRef->update([
                'groups' => array_values($communityGroups),
                'updated_at' => now()->timestamp,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Group created in community successfully',
            'group_id' => $groupId,
            'data' => $newGroupData,
        ]);
    }

    // 4. Leave Community
    public function leaveCommunity(Request $request, $communityId)
    {
        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $communityUsers = $community['users'] ?? [];
        $communityAdmins = $community['admins'] ?? [];
        $communityGroups = $community['groups'] ?? [];

        // Remove from community members and admins lists
        $communityUsers = array_filter($communityUsers, function ($uid) use ($userId) {
            return $uid != $userId;
        });
        $communityAdmins = array_filter($communityAdmins, function ($uid) use ($userId) {
            return $uid != $userId;
        });

        // Update community info
        $communityRef->update([
            'users' => array_values($communityUsers),
            'admins' => array_values($communityAdmins),
            'updated_at' => now()->timestamp,
        ]);

        // Remove from all groups inside this community
        foreach ($communityGroups as $groupId) {
            $groupRef = $this->db->getReference("groups/$groupId");
            $group = $groupRef->getValue();
            if ($group) {
                $groupUsers = $group['users'] ?? [];
                $groupAdmins = $group['admins'] ?? [];

                $groupUsers = array_filter($groupUsers, function ($uid) use ($userId) {
                    return $uid != $userId;
                });
                $groupAdmins = array_filter($groupAdmins, function ($uid) use ($userId) {
                    return $uid != $userId;
                });

                $groupRef->update([
                    'users' => array_values($groupUsers),
                    'admins' => array_values($groupAdmins),
                    'updated_at' => now()->timestamp,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully left the community',
        ]);
    }

    // 5. Deactivate/Delete Community
    public function deactivateCommunity(Request $request, $communityId)
    {
        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        if ((string) $community['created_by'] !== (string) $userId) {
            return response()->json(['status' => false, 'message' => 'Only the owner can deactivate the community'], 403);
        }

        $communityGroups = $community['groups'] ?? [];

        // Delete the Announcement group and General group
        $announcementGroupId = $community['announcement_group_id'];
        $this->db->getReference("groups/$announcementGroupId")->remove();

        // Detach community_id from other groups
        foreach ($communityGroups as $groupId) {
            if ($groupId !== $announcementGroupId) {
                $groupRef = $this->db->getReference("groups/$groupId");
                $group = $groupRef->getValue();
                if ($group) {
                    if (isset($group['is_general']) && $group['is_general']) {
                        $groupRef->remove();
                    } else {
                        $this->db->getReference("groups/$groupId/community_id")->remove();
                    }
                }
            }
        }

        // Remove the community meta info
        $communityRef->remove();

        return response()->json([
            'status' => true,
            'message' => 'Community deactivated successfully',
        ]);
    }

    // 6. Add Members to Community
    public function addMembers(Request $request, $communityId)
    {
        $request->validate([
            'users' => 'required|array',
        ]);

        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $admins = $community['admins'] ?? [];
        if (! in_array($userId, $admins)) {
            return response()->json(['status' => false, 'message' => 'Only admins can add members to the community'], 403);
        }

        $communityUsers = $community['users'] ?? [];
        $newUsers = array_merge($communityUsers, $request->users);
        $newUsers = array_values(array_unique($newUsers));

        // Update community users list
        $communityRef->update([
            'users' => $newUsers,
            'updated_at' => now()->timestamp,
        ]);

        // Auto add them to Announcement and General groups
        $announcementGroupId = $community['announcement_group_id'];
        $this->db->getReference("groups/$announcementGroupId")->update([
            'users' => $newUsers,
        ]);

        // General group
        $communityGroups = $community['groups'] ?? [];
        foreach ($communityGroups as $groupId) {
            $groupRef = $this->db->getReference("groups/$groupId");
            $gData = $groupRef->getValue();
            if ($gData && isset($gData['is_general']) && $gData['is_general']) {
                $groupRef->update(['users' => $newUsers]);
                break;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Members added successfully',
        ]);
    }

    // 7. Remove Member from Community
    public function removeMember(Request $request, $communityId)
    {
        $request->validate([
            'remove_user_id' => 'required',
        ]);

        $userId = auth()->id();
        $removeUserId = $request->remove_user_id;

        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $admins = $community['admins'] ?? [];
        if (! in_array($userId, $admins)) {
            return response()->json(['status' => false, 'message' => 'Only admins can remove members'], 403);
        }

        // Cannot remove community owner unless deactivating
        if ((string) $community['created_by'] === (string) $removeUserId) {
            return response()->json(['status' => false, 'message' => 'Cannot remove the community owner'], 400);
        }

        $communityUsers = $community['users'] ?? [];
        $communityAdmins = $community['admins'] ?? [];

        $communityUsers = array_filter($communityUsers, function ($uid) use ($removeUserId) {
            return $uid != $removeUserId;
        });
        $communityAdmins = array_filter($communityAdmins, function ($uid) use ($removeUserId) {
            return $uid != $removeUserId;
        });

        $communityRef->update([
            'users' => array_values($communityUsers),
            'admins' => array_values($communityAdmins),
            'updated_at' => now()->timestamp,
        ]);

        // Remove from all groups inside this community
        $communityGroups = $community['groups'] ?? [];
        foreach ($communityGroups as $groupId) {
            $groupRef = $this->db->getReference("groups/$groupId");
            $group = $groupRef->getValue();
            if ($group) {
                $groupUsers = $group['users'] ?? [];
                $groupAdmins = $group['admins'] ?? [];

                $groupUsers = array_filter($groupUsers, function ($uid) use ($removeUserId) {
                    return $uid != $removeUserId;
                });
                $groupAdmins = array_filter($groupAdmins, function ($uid) use ($removeUserId) {
                    return $uid != $removeUserId;
                });

                $groupRef->update([
                    'users' => array_values($groupUsers),
                    'admins' => array_values($groupAdmins),
                    'updated_at' => now()->timestamp,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Member removed successfully',
        ]);
    }

    // 8. Promote/Demote Community Admin
    public function toggleAdmin(Request $request, $communityId)
    {
        $request->validate([
            'target_user_id' => 'required',
            'action' => 'required|in:promote,demote',
        ]);

        $userId = auth()->id();
        $targetUserId = $request->target_user_id;
        $action = $request->action;

        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        // Only owner can promote/demote admins
        if ((string) $community['created_by'] !== (string) $userId) {
            return response()->json(['status' => false, 'message' => 'Only the community owner can manage admins'], 403);
        }

        $admins = $community['admins'] ?? [];

        if ($action === 'promote') {
            if (! in_array($targetUserId, $admins)) {
                $admins[] = $targetUserId;
            }
        } else {
            // Cannot demote owner
            if ((string) $community['created_by'] === (string) $targetUserId) {
                return response()->json(['status' => false, 'message' => 'Cannot demote the owner'], 400);
            }
            $admins = array_filter($admins, function ($uid) use ($targetUserId) {
                return $uid != $targetUserId;
            });
        }

        $communityRef->update([
            'admins' => array_values($admins),
            'updated_at' => now()->timestamp,
        ]);

        // Also make them admin of announcement group
        $announcementGroupId = $community['announcement_group_id'];
        $this->db->getReference("groups/$announcementGroupId")->update([
            'admins' => array_values($admins),
        ]);

        return response()->json([
            'status' => true,
            'message' => $action === 'promote' ? 'User promoted to Admin' : 'User demoted',
        ]);
    }

    // 9. Update Community Details
    public function updateCommunity(Request $request, $communityId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:2048',
        ]);

        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $admins = $community['admins'] ?? [];
        if (! in_array($userId, $admins)) {
            return response()->json(['status' => false, 'message' => 'Only admins can edit community details'], 403);
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'updated_at' => now()->timestamp,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('communities', 'public');
            $updateData['avatar'] = url('storage/'.$path);
        }

        $communityRef->update($updateData);

        // Also update community_name in announcement group so sidebar stays in sync
        $announcementGroupId = $community['announcement_group_id'] ?? null;
        if ($announcementGroupId && isset($updateData['name'])) {
            $this->db->getReference("groups/$announcementGroupId")->update([
                'community_name' => $updateData['name'],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Community details updated successfully',
            'data' => $updateData,
        ]);
    }

    // 10. Community Info / Details (Includes members and groups list)
    public function communityInfo(Request $request, $communityId)
    {
        $community = $this->db->getReference("communities/$communityId")->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        // Fetch users details
        $userIds = $community['users'] ?? [];
        $users = User::whereIn('id', $userIds)->get(['id', 'name', 'avatar', 'phone']);
        $community['members_details'] = $users;

        // Fetch groups details
        $groupList = [];
        $groupIds = $community['groups'] ?? [];
        foreach ($groupIds as $gid) {
            $gData = $this->db->getReference("groups/$gid")->getValue();
            if ($gData) {
                unset($gData['messages']);
                $groupList[] = $gData;
            }
        }
        $community['groups_details'] = $groupList;

        return response()->json([
            'status' => true,
            'data' => $community,
        ]);
    }

    // 11. Remove Group from Community
    public function removeGroup(Request $request, $communityId)
    {
        $request->validate([
            'group_id' => 'required',
        ]);

        $userId = auth()->id();
        $groupId = $request->group_id;

        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();

        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $admins = $community['admins'] ?? [];
        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();
        $isGroupOwner = false;

        if ($group) {
            $groupAdmins = $group['admins'] ?? [];
            if (!is_array($groupAdmins)) {
                $groupAdmins = [$groupAdmins];
            }
            $isGroupOwner = (isset($group['createdBy']) && $group['createdBy'] == $userId) || 
                            (isset($group['created_by']) && $group['created_by'] == $userId) ||
                            in_array($userId, $groupAdmins);
        }

        if (! in_array($userId, $admins) && !$isGroupOwner) {
            return response()->json(['status' => false, 'message' => 'Only community admins or the group owner can remove this group'], 403);
        }

        $communityGroups = $community['groups'] ?? [];
        if ($groupId === ($community['announcement_group_id'] ?? null)) {
            return response()->json(['status' => false, 'message' => 'Cannot remove the announcement group'], 400);
        }

        $communityGroups = array_filter($communityGroups, function ($gid) use ($groupId) {
            return $gid !== $groupId;
        });

        // Update group community_id reference
        $this->db->getReference("groups/$groupId/community_id")->remove();

        $communityRef->update([
            'groups' => array_values($communityGroups),
            'updated_at' => now()->timestamp,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Group removed from community',
        ]);
    }

    // 12. Join Community Group
    public function joinGroup(Request $request, $communityId, $groupId)
    {
        $userId = auth()->id();
        $community = $this->db->getReference("communities/$communityId")->getValue();
        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        // Ensure user is part of the community
        $communityUsers = $community['users'] ?? [];
        if (! in_array($userId, $communityUsers)) {
            $communityUsers[] = $userId;
            $this->db->getReference("communities/$communityId")->update([
                'users' => array_values($communityUsers),
            ]);
            // Add to announcement group
            $announcementGroupId = $community['announcement_group_id'];
            $announceRef = $this->db->getReference("groups/$announcementGroupId");
            $announceUsers = $announceRef->getValue()['users'] ?? [];
            if (! in_array($userId, $announceUsers)) {
                $announceUsers[] = $userId;
                $announceRef->update(['users' => array_values($announceUsers)]);
            }
        }

        // Add user to target group
        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();
        if (! $group || ! isset($group['community_id']) || $group['community_id'] !== $communityId) {
            return response()->json(['status' => false, 'message' => 'Group not found in this community'], 404);
        }

        $groupUsers = $group['users'] ?? [];
        if (! in_array($userId, $groupUsers)) {
            $groupUsers[] = $userId;
            $groupRef->update([
                'users' => array_values($groupUsers),
                'updated_at' => now()->timestamp,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully joined group',
        ]);
    }

    // 13. Send Join Request to Community Group
    public function sendJoinRequest(Request $request, $communityId, $groupId)
    {
        $userId = auth()->id();
        $community = $this->db->getReference("communities/$communityId")->getValue();
        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        $group = $this->db->getReference("groups/$groupId")->getValue();
        if (! $group || ! isset($group['community_id']) || $group['community_id'] !== $communityId) {
            return response()->json(['status' => false, 'message' => 'Group not found in this community'], 404);
        }

        $groupUsers = $group['users'] ?? [];
        if (in_array($userId, $groupUsers)) {
            return response()->json(['status' => false, 'message' => 'You are already a member of this group'], 400);
        }

        // Check if pending request already exists
        $requests = $this->db->getReference("communities/$communityId/join_requests")->getValue() ?? [];
        foreach ($requests as $req) {
            if (isset($req['group_id']) && $req['group_id'] === $groupId && isset($req['user_id']) && $req['user_id'] == $userId && isset($req['status']) && $req['status'] === 'pending') {
                return response()->json([
                    'status' => true,
                    'message' => 'Join request is already pending approval',
                ]);
            }
        }

        $requestId = 'req_'.time().'_'.uniqid();
        $user = auth()->user();
        $this->db->getReference("communities/$communityId/join_requests/$requestId")->set([
            'id' => $requestId,
            'group_id' => $groupId,
            'group_name' => $group['name'],
            'user_id' => $userId,
            'user_name' => $user->name ?? 'User',
            'user_avatar' => $user->avatar ?? '',
            'status' => 'pending',
            'created_at' => now()->timestamp,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Join request sent successfully',
        ]);
    }

    // 14. Handle Join Request (Accept / Reject)
    public function handleJoinRequest(Request $request, $communityId, $requestId)
    {
        $request->validate([
            'action' => 'required|string|in:accept,reject',
        ]);

        $userId = auth()->id();
        $communityRef = $this->db->getReference("communities/$communityId");
        $community = $communityRef->getValue();
        if (! $community) {
            return response()->json(['status' => false, 'message' => 'Community not found'], 404);
        }

        // Validate admin rights for handling requests
        $admins = $community['admins'] ?? [];
        if (! in_array($userId, $admins)) {
            return response()->json(['status' => false, 'message' => 'Only community admins can handle join requests'], 403);
        }

        $reqRef = $this->db->getReference("communities/$communityId/join_requests/$requestId");
        $joinReq = $reqRef->getValue();
        if (! $joinReq) {
            return response()->json(['status' => false, 'message' => 'Join request not found'], 404);
        }

        $targetGroupId = $joinReq['group_id'];
        $targetUserId = $joinReq['user_id'];

        if ($request->action === 'accept') {
            // Add user to community users if not present
            $communityUsers = $community['users'] ?? [];
            if (! in_array($targetUserId, $communityUsers)) {
                $communityUsers[] = $targetUserId;
                $communityRef->update([
                    'users' => array_values($communityUsers),
                ]);
                
                // Add to announcement group
                $announcementGroupId = $community['announcement_group_id'];
                $announceRef = $this->db->getReference("groups/$announcementGroupId");
                $announceUsers = $announceRef->getValue()['users'] ?? [];
                if (! in_array($targetUserId, $announceUsers)) {
                    $announceUsers[] = $targetUserId;
                    $announceRef->update(['users' => array_values($announceUsers)]);
                }
            }

            // Add user to target group
            $groupRef = $this->db->getReference("groups/$targetGroupId");
            $group = $groupRef->getValue();
            if ($group) {
                $groupUsers = $group['users'] ?? [];
                if (! in_array($targetUserId, $groupUsers)) {
                    $groupUsers[] = $targetUserId;
                    $groupRef->update([
                        'users' => array_values($groupUsers),
                        'updated_at' => now()->timestamp,
                    ]);
                }
            }
        }

        // Remove request
        $reqRef->remove();

        return response()->json([
            'status' => true,
            'message' => $request->action === 'accept' ? 'Request accepted successfully' : 'Request rejected successfully',
        ]);
    }
}
