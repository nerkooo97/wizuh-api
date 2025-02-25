<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\BuslinesCompany;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAuthController extends BaseController
{
    public function register(Request $request)
    {
        $registerUserData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);
        try {
            $user = User::create([
                'name' => $registerUserData['name'],
                'email' => $registerUserData['email'],
                'password' => Hash::make($registerUserData['password']),
            ]);
            return response()->json([
                'message' => 'User Created ',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User not created', 401
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    public function getBusiness(Request $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = BuslinesCompany::query();
        $query->where('user_id', $request->user()->id);

        $results = $query->get()->first();

        return response()->json(
            $results,
            200
        );
    }

    public function updateUser(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $user->id
        ]);

        if ($request->filled('password') && $request->filled('new_password')) {
            $request->validate([
                'password' => 'required|min:8',
                'new_password' => 'required|min:8'
            ]);

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Nije tačna stara lozinka'
                ], 401);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function updateBusiness(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = BuslinesCompany::query();
        $query->where('user_id', $request->user()->id);

        $results = $query->get()->first();

        $results->update($request->all());
        return response()->json([
            $results
        ]);
    }
}
