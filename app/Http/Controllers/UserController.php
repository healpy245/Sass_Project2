<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{





    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|exists:companies,name',
            'role' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => Company::where('name', $request->company_name)->first()->id,
            'role' => $request->role
        ]);
        return response()->json(UserDTO::fromModel($user));
    }















    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);


        $user = User::where('email', $request->email)->firstOrFail();

        if (!$user) {
            return response()->json(['message' => 'Email Do Not Exist.'], 404);
        }


        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Token')->plainTextToken;
            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        }


        return response()->json([
            'message' => 'failed',
        ], 200);
    }







    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logout successful'], 200);
    }






    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }










    public function index(Request $request)
    {
        $users = $request->user()->company->users;

        if (!$users) {
            return response()->json(['message' => 'No Users Found.'], 404);
        }

        return response()->json(data: UserDTO::collection($users));
    }


    public function show(Request $request, $id)
    {
        $user = $request->user()->company->users->findOrFail($id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found in your company.'], 404);
        }

        return response()->json(UserDTO::fromModel($user));
    }


    public function destroy(Request $request, $id)
    {
        $user = $request->user()->company->users->findOrFail($id);

        if (!$user) {
            return response()->json(['message' => 'User not found in your company.'], 404);
        }

        $user->delete();
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
            'role' => 'required'
        ]);
        $user = $request->user()->company->users()->where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found in your company.'], 404);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json(UserDTO::fromModel($user->fresh()));
    }
}
