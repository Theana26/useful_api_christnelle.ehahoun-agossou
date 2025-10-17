<?php

use App\Http\Controllers\ModulesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Acceuil API
Route:: get ('/', function(){
    return [
        "success" => true,
        "titre" => "USEFUL_API",
        "version" => "1.0.0",
    ];
});

//route pour créer un utilisateur
Route::post('/register', [UserController::class, "register"]);

//liste des utilisateurs
Route::get('/users', [UserController::class, "getUsers"]);

//route pour se connecter
Route::post('/login', [UserController::class, "login"]);

Route::middleware('auth:sanctum')->group(function () {
    //liste des modules
    Route::get('/modules', [ModulesController::class, 'index']);

    //activer un module
    Route::post('/modules/{id}/activate', [ModulesController::class, 'activate']);

    //désactiver un module
    Route::post('/modules/{id}/desactivate', [ModulesController::class, 'desactivate']);
});