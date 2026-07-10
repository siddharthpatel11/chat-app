<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommunityService;

class CommunityController extends Controller
{
    use \App\Traits\ApiResponse;

    protected $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    public function createCommunity(Request $request)
    {
        return $this->communityService->createCommunity($request);
    }
    public function addGroups(Request $request, $communityId)
    {
        return $this->communityService->addGroups($request, $communityId);
    }
    public function createGroupInCommunity(Request $request, $communityId)
    {
        return $this->communityService->createGroupInCommunity($request, $communityId);
    }
    public function leaveCommunity(Request $request, $communityId)
    {
        return $this->communityService->leaveCommunity($request, $communityId);
    }
    public function deactivateCommunity(Request $request, $communityId)
    {
        return $this->communityService->deactivateCommunity($request, $communityId);
    }
    public function addMembers(Request $request, $communityId)
    {
        return $this->communityService->addMembers($request, $communityId);
    }
    public function removeMember(Request $request, $communityId)
    {
        return $this->communityService->removeMember($request, $communityId);
    }
    public function toggleAdmin(Request $request, $communityId)
    {
        return $this->communityService->toggleAdmin($request, $communityId);
    }
    public function updateCommunity(Request $request, $communityId)
    {
        return $this->communityService->updateCommunity($request, $communityId);
    }
    public function communityInfo(Request $request, $communityId)
    {
        return $this->communityService->communityInfo($request, $communityId);
    }
    public function removeGroup(Request $request, $communityId)
    {
        return $this->communityService->removeGroup($request, $communityId);
    }
    public function joinGroup(Request $request, $communityId, $groupId)
    {
        return $this->communityService->joinGroup($request, $communityId, $groupId);
    }
    public function sendJoinRequest(Request $request, $communityId, $groupId)
    {
        return $this->communityService->sendJoinRequest($request, $communityId, $groupId);
    }
    public function handleJoinRequest(Request $request, $communityId, $requestId)
    {
        return $this->communityService->handleJoinRequest($request, $communityId, $requestId);
    }
}
