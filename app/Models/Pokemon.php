<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = "pokemons";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function relTipo()
    {
        return $this->belongsTo(Tipo::class, "tipos_id", "id");
    }
}
