<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Illuminate\Http\Request;

class ModulesController extends Controller

{

    public function activate($id, Request $request)
    {
        $module = Modules::findOrFail($id);
        $request->user()->modules()->syncWithoutDetaching([$id => ['is_active' => true]]);
        return response()->json(['message' => "Module {$module->name} activé"]);
    }

    public function desactivate($id, Request $request)
    {
        $module = Modules::findOrFail($id);
        $request->user()->modules()->syncWithoutDetaching([$id => ['is_active' => false]]);
        return response()->json(['message' => "Module {$module->name} désactivé"]);
    }
}
