<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RegisteredUserController extends Controller
{
    protected $successCode = ResponseCode::HTTP_OK;
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $message = 'generic.successfully_created';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_type_id' => ['nullable', 'integer', 'min:1'],
            'role_id' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'user_type_id' => $request->user_type_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $auth = Auth::user();

        return response()->json(responseBuilder($this->successCode, $message, $auth), $this->successCode);
    }
}
