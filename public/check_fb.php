<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$db = app('firebase.database');

$user = \App\Models\User::first();
auth()->login($user);

$chatId = 'group_1782794555_6a43493be42ff';

$request = \Illuminate\Http\Request::create('/api/v1/settings/disappearing-message-timer', 'POST', [
    'chat_id' => $chatId,
    'duration' => 120
]);

$controller = app(\App\Http\Controllers\Api\SettingsApiController::class);
try {
    $response = $controller->setDisappearingMessageTimer($request);
    print_r($response->getData());
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

echo "\nFirebase value: ";
echo $db->getReference("groups/1782794555_6a43493be42ff/disappearingTimer")->getValue();
