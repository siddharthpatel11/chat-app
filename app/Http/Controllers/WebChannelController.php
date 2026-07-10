<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChannelService;

class WebChannelController extends Controller
{
    protected $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }

    public function uploadAvatar(Request $request)
    {
        return $this->channelService->uploadAvatar($request);
    }
    public function uploadMessageMedia(Request $request)
    {
        return $this->channelService->uploadMessageMedia($request);
    }
    public function createChannel(Request $request)
    {
        return $this->channelService->createChannel($request);
    }
    public function followChannel(Request $request, $channelId)
    {
        return $this->channelService->followChannel($request, $channelId);
    }
    public function unfollowChannel(Request $request, $channelId)
    {
        return $this->channelService->unfollowChannel($request, $channelId);
    }
    public function updateChannel(Request $request, $channelId)
    {
        return $this->channelService->updateChannel($request, $channelId);
    }
    public function inviteAdmins(Request $request, $channelId)
    {
        return $this->channelService->inviteAdmins($request, $channelId);
    }
    public function acceptAdminInvite(Request $request, $channelId)
    {
        return $this->channelService->acceptAdminInvite($request, $channelId);
    }
    public function dismissAdmin(Request $request, $channelId)
    {
        return $this->channelService->dismissAdmin($request, $channelId);
    }
    public function dismissSelfAdmin(Request $request, $channelId)
    {
        return $this->channelService->dismissSelfAdmin($request, $channelId);
    }
    public function deleteChannel(Request $request, $channelId)
    {
        return $this->channelService->deleteChannel($request, $channelId);
    }
    public function removeFollower(Request $request, $channelId)
    {
        return $this->channelService->removeFollower($request, $channelId);
    }
    public function searchMessages(Request $request, $channelId)
    {
        return $this->channelService->searchMessages($request, $channelId);
    }
    public function getMessages(Request $request, $channelId)
    {
        return $this->channelService->getMessages($request, $channelId);
    }
    public function sendMessage(Request $request, $channelId)
    {
        return $this->channelService->sendMessage($request, $channelId);
    }
    public function getUsersDetails(Request $request)
    {
        return $this->channelService->getUsersDetails($request);
    }
    public function toggleMute(Request $request, $channelId)
    {
        return $this->channelService->toggleMute($request, $channelId);
    }
    public function reportChannel(Request $request, $channelId)
    {
        return $this->channelService->reportChannel($request, $channelId);
    }
    public function reactMessage(Request $request, $channelId)
    {
        return $this->channelService->reactMessage($request, $channelId);
    }
    public function deleteMessage(Request $request, $channelId)
    {
        return $this->channelService->deleteMessage($request, $channelId);
    }
    public function deleteMessages(Request $request, $channelId)
    {
        return $this->channelService->deleteMessages($request, $channelId);
    }
}
