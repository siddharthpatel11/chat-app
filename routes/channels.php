<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $parts = explode('_', str_replace('chat_', '', $chatId));
    return in_array($user->id, $parts);
});
