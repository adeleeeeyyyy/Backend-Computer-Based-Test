<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $input = $request->all();
        $input['user_id'] = uniqid('user_'); 
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken('be-sabirudev')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Berhasil daftar',
            'data' => $success,
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('be-cbt')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'Berhasil Login');
        }
        else{
            return $this->sendError('Credential tidak valid', ['error'=>'Unauthorised']);
        }
    }

    public function getId(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'success',
            'user_id' => $user->user_id,
        ]);
    }
}
