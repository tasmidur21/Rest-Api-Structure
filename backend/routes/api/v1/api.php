<?php

use App\Api\V1\Auth\SsoAuthController;
use App\Api\V1\Controllers\ApiBaseController;
use Illuminate\Support\Facades\Route;

/**
 * SSO Auth Token
 */
/** wso2-auth-token */
Route::get("wso2-access-token", [SsoAuthController::class, "getWso2AccessToken"])->name('wso2-access-token');
Route::get('/',[ApiBaseController::class,'apiInfo'])->name("api-info");


