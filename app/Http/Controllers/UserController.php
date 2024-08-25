<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->only(['full_name', 'email', 'password', 'photo']);
            if ($request->has('photo')) {
                $data['photo'] = Storage::disk('public')->put('/user/photo', $data['photo']);
            }
            $user = User::create($data);
            return response()->json([
                "data" => [
                    "user" => [...$user->toArray(),
                        "token" => $user->createToken($request->ip())->plainTextToken]
                ]
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only(["email", "password"]);
        if (!Auth::attempt($data)) {
            throw new \Exception("wrong phone or password");
        }
        $user = \auth()->user();
        return response()->json([
            'data' => [
                "user" => [...$user->toArray(), ...["role" => $user->getRoleNames()->first(),
                    "token" => $user->createToken($request->ip())->plainTextToken]]
            ]
        ], 200);
    }

    public function logout()
    {
        \auth()->user()->tokens()->delete();
        return response()->json(null, 204);
    }
}
