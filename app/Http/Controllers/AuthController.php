<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        return User::paginate(10);
    }

    public function showLogin(){
        return "login Please";
    }
    // User Registration
    public function register(Request $request)
    {
        // Validation
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        
        // User Creation
        $user = User::create([
            'name' => $fields['name'],
            'email' =>$fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        
        //Token Generation
        $token = $user->createToken('Install Forecast')->plainTextToken;
        
        //Response
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return Response($response, 201);
    }

    // User Login
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check E-mail
        $user = User::where('email', $fields['email'])->first();
        
        // Check Password
        if( !$user || !Hash::check($fields['password'], $user->password ))
        {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return Response($response, 201);
    }
    
    //Change Password / Update Password
    public function resetPassword(Request $request) {
		$fields = $request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required',
		]);

        $user = User::where('email', $fields['email'])->first();
        if( !$user || !Hash::check($fields['password'], $user->password ))
        {
            return response([
                'message' => 'Old Password is Wrong'
            ], 401);
        }
		
        $user->update([
            'password' => bcrypt($fields['password'])
        ]);

        return 'Password Updated';
	}
    // User Logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }

    public function search($name){    
        $user =  User::where('name', 'like','%'.$name.'%')->get();
        return $user;
    }
}
