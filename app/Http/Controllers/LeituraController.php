<?php

namespace App\Http\Controllers;

use App\Models\Leitura;                    
use Illuminate\Http\Request;
use App\Http\Requests\StoreLeituraRequest; 
use Carbon\Carbon;                         

class LeituraController extends Controller
{
    /** dashboard web (opcional) */
    public function index(Request $request, $freezerId = 1)
    {
        $leituras = Leitura::where('freezer_id', $freezerId)
                           ->orderByDesc('date_create')
                           ->first();

        return view('dashboard', compact('leituras', 'freezerId'));
    }

    /** endpoint API */
    public function store(StoreLeituraRequest $request)
    {
        $leitura = Leitura::create([
            'freezer_id'  => $request->freezer_id,
            'temperatura' => $request->temperatura,
            'umidade'     => $request->umidade,
        ]);

        return response()->json([
            'status'  => 'ok',
            'leitura' => $leitura,
        ], 201);
    }
}
