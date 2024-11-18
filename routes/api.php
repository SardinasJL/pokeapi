<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::apiResource("pokemons", "App\Http\Controllers\PokemonController");
    Route::apiResource("tipos", "App\Http\Controllers\TipoController");
    Route::post("/logout", "App\Http\Controllers\LoginController@logout")->name("logout");
});

Route::post("/login", "App\Http\Controllers\LoginController@login")->name("login");


