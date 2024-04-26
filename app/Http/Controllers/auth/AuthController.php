<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectCollection;
use App\Mail\RegistrationMail;
use App\Models\Address;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

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
        return response()->json([
            "data" => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'lastName' => $request->user()->lastName,
                'fatherName' => $request->user()->fatherName,
                "phone" => $request->user()->phone,
                "email" => $request->user()->email,
                "subscribed" => $request->user()->subscribed === 0 ? "отключить" : "включено",
                'address'=> $request->user()->address
            ],
        ]);
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


        $token = Str::random(64);

        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
        $content = [
            'subject' => 'Письмо с подтверждением электронной почты',
            'body' => $token
        ];
        Mail::to($user->email)->send(new RegistrationMail($content));

//        Mail::send('emails.registration', ['token' => $token], function($message) use($request){
//            $message->to($request->email);
//            $message->subject('Письмо с подтверждением электронной почты');
//        });
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
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        ///dd($id);
        $validator = Validator::make($request->all(), [
            'email' => 'string|email',
            'phone' => 'string',
            'fatherName' => 'required|string',
            'city' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
        }

        User::find($id)->update([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'fatherName' => $request->fatherName,
            "phone" => $request->phone,
//            "email" => $request->email,
            "dob" => $request->dob,
            "company" => $request->company ?? null,
        ]);
        $check = Address::where('user_id', $id)->get();

        if(count($check)> 0){
            $check[0]->update([
                'name' => $request->name,
                'lastName' => $request->lastName,
                'fatherName' => $request->fatherName ,
                "phone" => $request->phone,
                "email" => $request->email,
                'user_id'=>$id,
                "city" => $request->city,
            ]);
        }else{
           Address::create([
                'name' => $request->name,
                'lastName' => $request->lastName,
                'fatherName' => $request->fatherName,
                "phone" => $request->phone,
                "email" => $request->email,
                'user_id'=>$id,
                "city" => $request->city,
            ]);

        }

        return response()->json([
            "status" => 200,
        ]);
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

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return Redirect::to('https://www.brend-instrument.ru/');

    }
}
