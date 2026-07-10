<?php

namespace App\Constants;

class FirebasePaths
{
    /**
     * Get the base path for a chat.
     */
    public static function chat($chatId)
    {
        return "chats/{$chatId}";
    }

    /**
     * Get the path for chat messages.
     */
    public static function chatMessages($chatId)
    {
        return self::chat($chatId) . "/messages";
    }

    /**
     * Get the path for chat settings of a specific user.
     */
    public static function chatSettings($chatId, $userId)
    {
        return self::chat($chatId) . "/settings/{$userId}";
    }

    /**
     * Get the base path for a group.
     */
    public static function group($groupId)
    {
        return "groups/{$groupId}";
    }

    /**
     * Get the path for a specific user's status.
     */
    public static function userStatus($userId)
    {
        return "statuses/{$userId}";
    }

    /**
     * Get the path for a specific user's info.
     */
    public static function user($userId)
    {
        return "users/{$userId}";
    }

    /**
     * Get the path for a specific user's blocked users list.
     */
    public static function userBlocked($userId, $blockedId)
    {
        return self::user($userId) . "/blocked/{$blockedId}";
    }

    /**
     * Get the path for a specific user's hide chat settings.
     */
    public static function userHideChatSettings($userId)
    {
        return self::user($userId) . "/hide_chat_settings";
    }

    /**
     * Get the path for a specific report.
     */
    public static function report($reportId)
    {
        return "reports/{$reportId}";
    }
}
