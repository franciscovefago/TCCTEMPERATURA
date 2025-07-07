<?php

namespace App\Http\Controllers;

use App\Models\Freezer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // exibe as últimas N leituras de um freezer
    public function index(Request $request, $freezerId = 1)
    {
        $freezers = Freezer::has('ultimaLeitura')->with('ultimaLeitura')->get();

        return view('dashboard', compact('freezers'));
    }
}