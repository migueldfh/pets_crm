<?php

namespace App\Http\Controllers;

use App\User;
use App\Seller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
      $users = User::all();
      return response()->json(
          [
              'status' => 'success',
              'users' => $users
          ], 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json(
            [
                'status' => 'success',
                'user' => $user
            ], 200);
    }
}
