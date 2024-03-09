<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @param \Illuminate\Http\Request $request
     * @return [json] user object
     */
    public function user(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->user());
    }

    public function registration(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastName' => 'required|string',
            'fatherName' => 'string',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'subscribed' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->fatherName = $request->fatherName;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->subscribed = $request->subscribed;

        if (!$user->save()) {
            return response()->json([
                'success' => '0',
                'type' => 'forbidden',
            ], 403);
        }
//        $user->notify(
//            new UserCreateNotification($user)
//        );
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            return response()->json([
                'email' => 'success'
            ]);
        } else {
            return response()->json([
                'email' => 'false'
            ]);
        }

    }

    public function resetPassword(Request $request)
    {
        $id = $request->user()->id;
        $user = User::find($id);
        $user->update([
            'password' => $request->password
        ]);
        return response()->json([
            'user' => $user,
        ]);
    }
}
