<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' =>  'required|email',
                'password' =>  'required'
            ]
        );
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return response()->json(['code' => 400, 'message' => 'User not found'], 200);
        }
        if ($validator->fails())
            return response()->json(['code' => 400, 'message' => 'Bad Request']);

        if (!Hash::check($request->password, $user->password))
            return response()->json(['message' => 'Do not match our records!!'], 200);

        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'code' => 200,
            'token' => $tokenResult,
            'message' => 'good',
            'type' => $user->role
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'code' => 200,
            'msg' => 'token deleted successfully'
        ], 200);
    }
    public function signUp(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' =>  'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (isset($user)) {
            return response()->json(['code' => 400, 'message' => 'this email already in use.'], 200);
        }
        if ($valid->fails())
            return response()->json(['code' => 400, 'message' => 'Bad Request'], 200);
        $user = User::create([
            'f_name' => $request->first_name,
            'l_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);
        $cart = Cart::create([
            'user_id' => $user->id
        ]);
        if (isset($user)) {
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'code' => 200,
                'message' => "user created successfully",
                'token' => $tokenResult,
                'type' => 'user',
            ], 200);
        } else {
            return response()->json([
                'code' => 300,
                'message' => "user can't be created now."
            ], 200);
        }
    }
}
