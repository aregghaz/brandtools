<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectCollection;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $users = User::orderBy('id', 'DESC')->take(15 * $showMore)->orderBy('id', 'DESC')->get();
        return response()->json(new UserCollection($users));
    }

    public function show(User $user)
    {
        $status = [
            (object)[
                "id" => 1,
                "title" => "enable"
            ],
            (object)[
                "id" => 2,
                "title" => "disable"
            ]
        ];
        return response()->json([
            "data" => [
                'id' => $user->id,
                'name' => $user->name,
                'lastName' => $user->lastName,
                'fatherName' => $user->fatherName,
                "phone" => $user->phone,
                "email" => $user->email,
                "subscribed" => (object)[
                    "id" => $user->subscribed,
                    "value" => $user->subscribed,
                    "name" => $user->subscribed === 0 ? "disable" : "enable",
                    "label" => $user->subscribed === 0 ? "disable" : "enable"
                ],
                "status" => (object)[
                    "id" => $user->status,
                    "value" => $user->status,
                    "name" => $user->status === 0 ? "disable" : "enable",
                    "label" => $user->subscribed === 0 ? "disable" : "enable"
                ],
            ],
            'status' => new SelectCollection($status),
            'subscribed' => new SelectCollection($status),
        ]);

    }
}
