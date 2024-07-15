<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role' => 'required|in:IT,User,Superadmin',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Error', $validator->errors()->toArray());
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success = array(
            'token' => $user->createToken('ITHelpdesk')->plainTextToken,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'id' => $user->id,
        );

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success = array(
                'token' => $user->createToken('ITHelpdesk')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'id' => $user->id,
            );

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return $this->sendResponse([], 'User logged out successfully.');
    }
}
