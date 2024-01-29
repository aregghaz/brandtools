<?php

namespace App\Http\Controllers;

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
}
