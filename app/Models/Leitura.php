<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leitura extends Model
{
    protected $table = 'leitura';

    protected $fillable = [
        'freezer_id',
        'temperatura',
        'umidade',
        'date_create',
    ];
}
