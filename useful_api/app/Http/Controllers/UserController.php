<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    // méthode pour créer un utilisateur
    public function register(Request $request){
        {
            try{
                $validated= $request->validate([
                    'name' => 'required|string|min:3|max:20',
                    'email' => 'required|unique:users|email',
                    'password' => 'required|string|min:8',
                ]);

               $user = User::create([
                    'name' => ($validated['name']),
                    'email' => ($validated['email']),
                    'password' => Hash::make($validated['password'])
                ]);

           $token = $user->createToken('auth_token')->plainTextToken;

                    return response()->json ([
                    "status"=>"true",
                    "message"=> "User created succesfully",
                    "user"=>$user
                    ],201);
            }
            catch (ValidationException $e){
                return response()->json($e);                 
            }
        }
    }
    
    //liste des utilisateurs
    public function getUsers(){
        $users=User::all();
        return response()->json($users);
    }

    //méthode pour se connecter
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            $user = User::where('email', $validated['email'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials.'],
                ]);
            }
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'=> "success",
                'message'=> "Connected",
                'user' => $user,
                'token' => $token
            ]);
        }
        catch (ValidationException $e){
            return response()->json($e);                 
        }
    }
}  
