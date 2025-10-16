<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

           // $token = $user->createToken('auth_token')->plainTextToken;

                    return response()->json ([
                    "status"=>"true",
                    "message"=> "User created succesfully",
                    "user"=>$user
                    ],201);
                    //redirect ('/login');
            }
            catch (ValidationException $e){
                return response()->json($e);                 
            }
        }
    }
    
    public function getUsers(Request $request){
        $users=User::all();
        return response()->json($users);
    }
    public function login (Request $request){

    }


}  
