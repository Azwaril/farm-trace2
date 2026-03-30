<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[0-9]/',
                'no_hp' => 'required',
                'alamat' => 'required'
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.regex' => 'Password harus mengandung huruf kecil dan angka',
                'no_hp.required' => 'Nomor HP wajib diisi',
                'alamat.required' => 'Alamat wajib diisi'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'konsumen',
            'no_hp'=>$request->no_hp,
            'alamat'=>$request->alamat
        ]);

        return response()->json([
            'status' => true,
            'message'=>'Register berhasil',
            'data'=>$user
        ],201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'=>'required|email',
                'password'=>'required|min:8'
            ],
            [
                'email.required'=>'Email wajib diisi',
                'email.email'=>'Format email tidak valid',
                'password.required'=>'Password wajib diisi',
                'password.min'=>'Password minimal 8 karakter'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email','password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ],401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json([
            'status' => true,
            'data' => auth('api')->user()
        ]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'status' => true,
            'message'=>'Logout berhasil'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth('api')->factory()->getTTL() * 60
        ]);
    }
}