<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectCollection;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;


class UserController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $showMore = $request->get('showMore');
        $users = User::orderBy('id', 'DESC')->take(15 * $showMore)->orderBy('id', 'DESC')->get();
        return response()->json(new UserCollection($users));
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => new SelectCollection($this->simpleSelect()),
            'subscribed' => new SelectCollection($this->simpleSelect()),
        ]);
    }

    public function show(User $user): \Illuminate\Http\JsonResponse
    {
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
            'status' => new SelectCollection($this->simpleSelect()),
            'subscribed' => new SelectCollection($this->simpleSelect()),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = json_decode($request->value);
        $checkUser = User::where('email', $data->email)->first();

        if (!empty($checkUser)) {
            return response()->json([
                "status" => 400,
                'message' => 'user alredy exist'
            ], 200);
        }
        User::create([
            'name' => $data->name,
            'lastName' => $data->lastName,
            'fatherName' => $data->fatherName ?? null,
            "phone" => $data->phone,
            "email" => $data->email,
            "subscribed" => $data->subscribed->id ?? 0,
            "status" => 1,
            "password" => $data->password,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    public function update(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $data = json_decode($request->value);
        $checkUser = User::where('email', $data->email)->get();

        if (isset($checkUser) and $data->email !== $user->email) {
            return response()->json([
                "status" => 400,
                'message' => 'user alredy exist'
            ], 200);
        }
        if (isset($data->password)) {
            $user->update([
                "password" => $data->password,
            ]);
        }
        $user->update([
            'name' => $data->name,
            'lastName' => $data->lastName,
            'fatherName' => $data->fatherName ?? null,
            "phone" => $data->phone,
            "email" => $data->email,
            "subscribed" => $data->subscribed->id ?? 0,
            "status" => $data->status->id,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }


}
