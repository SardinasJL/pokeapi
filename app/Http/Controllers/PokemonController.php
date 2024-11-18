<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function validarForm(Request $request, bool $isUpdate)
    {
        $request->validate([
            "nombre" => "required|alpha|min:3|max:50",
            "peso" => "required|numeric|min:0|max:99999999",
            "altura" => "required|numeric|min:0|max:99999999",
            "foto" => $isUpdate ? "image|mimes:jpg,jpeg,png|max:2048" : "required|image|mimes:jpg,jpeg,png|max:2048",
            "tipos_id" => "required|numeric|min:0"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pokemons = Pokemon::with(["relTipo"])->where("nombre", "like", "%$request->nombre%")
            ->paginate(10);
        return response()->json($pokemons, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request, false);
        if ($foto = $request->file("foto")) {
            $input = $request->all();
            $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
            $fotoRuta = "fotos";
            $foto->move($fotoRuta, $fotoNombre);
            $input["foto"] = $fotoNombre;
            $pokemon = Pokemon::create($input);
        } else
            $pokemon = Pokemon::create($request->all());
        return response()->json($pokemon, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pokemon = Pokemon::findOrFail($id);
        return response()->json($pokemon, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request, true);
        $pokemon = Pokemon::findOrFail($id);
        if ($foto = $request->file("foto")) {
            $archivoAEliminar = "fotos/$pokemon->foto";
            if (file_exists($archivoAEliminar))
                unlink($archivoAEliminar);
            $input = $request->all();
            $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
            $fotoRuta = "fotos";
            $foto->move($fotoRuta, $fotoNombre);
            $input["foto"] = $fotoNombre;
            $pokemon->update($input);
        } else
            $pokemon->update($request->all());
        return response()->json($pokemon, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pokemon = Pokemon::findOrFail($id);
        $archivoAEliminar = "fotos/$pokemon->foto";
        if (file_exists($archivoAEliminar))
            unlink($archivoAEliminar);
        $pokemon->delete();
        return response()->json($pokemon, 200);
    }
}
