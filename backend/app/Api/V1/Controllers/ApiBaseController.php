<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiBaseController extends Controller
{
    public function apiInfo(): JsonResponse
    {
        return response()->json([
            "status_code" => Response::HTTP_OK,
            "message" => "Welcome to api service " . env('APP_NAME'),
            "data" => [
                "api_version" => "1.0.0",
                "application_environment" => "Laravel",
                "application_environment_version" => app()->version()
            ]
        ], Response::HTTP_OK);
    }
}
