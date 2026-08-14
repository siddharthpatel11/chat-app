<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class ManifestController extends Controller
{
    public function index(Request $request, FirebaseService $firebaseService)
    {
        $svgUrl = url('/app-icon.svg');

        return response()->json([
            "name" => "WhatsApp",
            "short_name" => "WhatsApp",
            "start_url" => "/chat",
            "display" => "standalone",
            "background_color" => "#111b21",
            "theme_color" => "#00a884",
            "icons" => [
                [
                    "src" => $svgUrl,
                    "type" => "image/svg+xml",
                    "sizes" => "512x512",
                    "purpose" => "any maskable"
                ],
                [
                    "src" => $svgUrl,
                    "type" => "image/svg+xml",
                    "sizes" => "192x192",
                    "purpose" => "any maskable"
                ]
            ]
        ]);
    }

    public function icon(Request $request, FirebaseService $firebaseService)
    {
        $iconIndex = 0; // Default

        // Try to get user from session
        if (auth()->check()) {
            $userId = auth()->id();
            $settings = $firebaseService->database()->getReference("users/{$userId}/settings/appearance")->getValue();
            if ($settings && isset($settings['app_icon_index'])) {
                $iconIndex = (int) $settings['app_icon_index'];
            }
        }

        // Output SVG dynamically
        $colors = [
            '#00a884', '#4b5563', '#1d4ed8', '#7e22ce', '#be185d', '#1e40af', '#1e3a8a', '#4338ca',
            '#65a30d', '#0f766e', '#115e59', '#451a03', '#ca8a04', '#9a3412', '#9f1239', '#b91c1c'
        ];
        
        $color = $colors[$iconIndex] ?? '#00a884';

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                <rect width="24" height="24" rx="12" fill="' . $color . '" />
                <path d="M17.47,6.5A7.78,7.78,0,0,0,12,4.24a7.83,7.83,0,0,0-6.72,11.7l-.92,3.37,3.46-.91a7.84,7.84,0,0,0,11.91-8.15,7.77,7.77,0,0,0-2.26-3.75Zm-5.46,12.3a6.5,6.5,0,0,1-3.32-.91l-.24-.14-2.47.65.66-2.41-.15-.24a6.52,6.52,0,1,1,10.66-6.42,6.52,6.52,0,0,1-5.14,9.47Z" fill="white" />
                <path d="M15.65,13.62c-.22-.11-1.3-.64-1.5-.72s-.35-.11-.49.11-.56.72-.69.87-.26.17-.48.06a6,6,0,0,1-1.77-1.09,6.58,6.58,0,0,1-1.22-1.52c-.13-.22-.01-.34.1-.45s.22-.26.34-.39a1.64,1.64,0,0,0,.22-.36.39.39,0,0,0-.02-.38c-.06-.11-.49-1.19-.67-1.63s-.36-.37-.49-.38-.27,0-.42,0a.82.82,0,0,0-.59.27,2.47,2.47,0,0,0-.77,1.84A4.3,4.3,0,0,0,8,12.44a9.66,9.66,0,0,0,3.7,3.27,12.42,12.42,0,0,0,1.24.46,3,3,0,0,0,1.38.08,2.26,2.26,0,0,0,1.48-1.05,1.85,1.85,0,0,0,.13-1.05C15.91,13.78,15.76,13.73,15.65,13.62Z" fill="white" />
            </svg>';

        return response($svg)->header('Content-Type', 'image/svg+xml');
    }
}
