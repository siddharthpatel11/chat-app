<?php

namespace App\Services;

use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Http\HttpClientOptions;

class FirebaseService
{
    protected Database $database;

    protected Messaging $messaging;

    public function __construct()
    {
        $options = HttpClientOptions::default()->withGuzzleConfigOption('verify', false);

        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(config('services.firebase.database_url', env('FIREBASE_DATABASE_URL')))
            ->withHttpClientOptions($options);

        $this->database = $factory->createDatabase();
        $this->messaging = $factory->createMessaging();
    }

    public function database(): Database
    {
        return $this->database;
    }

    public function messaging(): Messaging
    {
        return $this->messaging;
    }
}
