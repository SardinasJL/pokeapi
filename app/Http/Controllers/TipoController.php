<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Tipo;
use http\Env\Response;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function validarForm(Request $request)
    {
        $request->validate([
            "descripcion" => "required|alpha|min:3|max:50"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = Tipo::all();
        return response()->json($tipos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request);
        $tipo = Tipo::create($request->all());
        return response()->json($tipo, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = Tipo::findOrFail($id);
        return response()->json($tipo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request);
        $tipo = Tipo::findOrFail($id);
        $tipo->update($request->all());
        return response()->json($tipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = Tipo::findOrFail($id);
        if (count($tipo->relPokemon) > 0)
            return response()->json(["error" => "El tipo tiene pokemones asociados. Borre los pokemones primero"], 400);
        $tipo->delete();
        return response()->json($tipo, 200);
    }
}
