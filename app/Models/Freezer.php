<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freezer extends Model
{
    protected $table = 'freezer';
    protected $fillable = [
        'numero',
        'localizacao',
        'temp_min',
        'temp_max',
        'umid_min',
        'umid_max',
        'codigo_telegram'
    ];

    public function ultimaLeitura()
    {
        return $this->hasOne(Leitura::class)->latestOfMany('created_at');
    }

    public function leituras()
    {
        return $this->hasMany(Leitura::class);
    }
}
