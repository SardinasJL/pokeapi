<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = "tipos";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function relPokemon()
    {
        return $this->hasMany(Pokemon::class, "tipos_id", "id");
    }
}
