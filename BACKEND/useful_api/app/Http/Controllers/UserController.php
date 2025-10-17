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
                    'name' => 'required|string|max:50',
                    'email' => 'required|string|unique:users|email',
                    'password' => 'required|string|min:8',
                ]);

               $user = User::create([
                    'name' => ($validated['name']),
                    'email' => ($validated['email']),
                    'password' => Hash::make($validated['password'])
                ]);

                    return response()->json ([
                        "id"=>$user->id,
                        "name"=>$user->name,
                        "email"=>$user->email,
                        "created_at"=> $user->created_at,       
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
                'email' => 'required|string|email',
                'password' => 'required',
            ]);
            
            $user = User::where('email', $validated['email'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                return response()->json(["Invalid credentials"], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user_id' => $user->id
            ]);
        }
        catch (ValidationException $e){
            return response()->json($e);                 
        }
    }
}  
