<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AuthenticatedSessionController extends Controller
{
    protected $successCode = ResponseCode::HTTP_OK;

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = User::where(['email' => $request->email])->first();
        Hash::check($request->password, $user->password);

        Auth::login($user);


        return response()->json(responseBuilder($this->successCode, 'User Login successful', []), $this->successCode);
        /*return response()->noContent();*/
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(responseBuilder($this->successCode, 'User logout successful', []), $this->successCode);
        /*return response()->noContent();*/
    }
}
