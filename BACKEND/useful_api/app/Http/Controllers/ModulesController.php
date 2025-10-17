<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Illuminate\Http\Request;

class ModulesController extends Controller

{
    public function index()
    {
        $modules = Modules::select('id', 'name', 'description')->get();

        return response()->json($modules, 200);
    }

    public function activate($id, Request $request)
    {
        //chercher le module
        $module = Modules::find($id);

        //vérifier si le module existe
        if (!$module){
            return response()->json(["message"=>"Module not found"], 404);
        }
        //permet d'associer le module à l'utilisateur
        $request->user()->modules()->syncWithoutDetaching([
            $module->id => ['is_active' => true]
        ]);

        return response()->json(['message' => "Module {$module->name} activated"]);
    }

    public function desactivate($id, Request $request)
    {
        $module = Modules::findOrFail($id);

        if (!$module){
            return response()->json(["message"=> "Module not found"], 404);
        }


        $request->user()->modules()->syncWithoutDetaching([
            $module->id => ['is_active' => false]
        ]);
        
        return response()->json(['message' => "Module {$module->name} désactivated"]);
    }
}
