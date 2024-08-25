<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    /*
     * Register a new user
     * validation in Form Request
     * @params(Request $request)
     * @return \Illuminate\Http\Response response()->json()
     * return data with response (tokens from sanctum package and user information)
     */

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
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * /**
     *  Login User already registered
     *  validation in Form Request
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse response()->json()
     *  return data with response (tokens from sanctum package and user information)
     */
    public function login(LoginRequest $request)
    {
        try {

            $data = $request->only(["email", "password"]);
            if (!Auth::attempt($data)) {
                throw new \Exception("wrong phone or password");
            }
            $user = \auth()->user();
            return response()->json([
                'data' => [
                    "user" => [...$user->toArray(),
                        "token" => $user->createToken($request->ip())->plainTextToken]]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * /**
     * Log out the user and delete all tokens
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            \auth()->user()->tokens()->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
