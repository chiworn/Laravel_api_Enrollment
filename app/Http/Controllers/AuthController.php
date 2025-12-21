<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message'=>'success']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required',
            'password'=>'required|min:6',
            'role'=>'required'
         ]);

         $register = User::create($data);
             if($register){
                return response()->json([
                    'status' => 200,
                    'message' => 'Register successfully',
                    'data' => $register
                ], 200);

        }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Cannot register',
                    'data' => null
                ], 500);
             }
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
       $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
         }
         $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
