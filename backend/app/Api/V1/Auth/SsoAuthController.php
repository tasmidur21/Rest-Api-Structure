<?php

namespace App\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SsoAuthController extends Controller
{
    public function getWso2AccessToken()
    {
        $consumerKey = env('WSO2_CONSUMER_KEY', "IzhArTrVpqkoRBcf7PnK039oHJ8a");
        $consumerSecret = env('WSO2_CONSUMER_SECRET', "oESLrueD6IY_WN72fgi83GfKCuQa");
        $tokenUrl = env("WSO2_AUTH_TOKEN_URL", "https://localhost:9443/oauth2/token");
        $response = Http::withOptions([
            'verify' => false,
            'debug' => false,
            'auth' => [
                $consumerKey,
                $consumerSecret
            ]
        ])->retry(3)
            ->asForm()
            ->post($tokenUrl, [
                'grant_type' => 'client_credentials'
            ]);
        Log::info("WSO2_CONSUMER_AUTH: " . json_encode($response->json()));
        return $response->json('access_token');
    }
}
