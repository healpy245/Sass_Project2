<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
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
            'company_id' => 'exists:companies,id'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => $request->company_id
        ]);
        return response()->json(data: UserDTO::fromModel($user));
    }















    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);


        $user = User::where('email', $request->email)->first();

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
        $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $user->currentAccessToken(), 200]);
    }










    public function index(Request $request)
    {
        $users = $request->user()->company()->users();
        return response()->json(data: UserDTO::collection($users));
    }


    public function show(Request $request, $id)
    {
        $user = $request->user()->company()->users()->findOrFail($id)->first();
        return response()->json(data: UserDTO::fromModel($user));
    }


    public function destroy(Request $request, $id)
    {
        $user = $request->user()->company()->users()->findOrFail($id);
        $user->delete();
    }
}
