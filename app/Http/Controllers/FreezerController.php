<?php

namespace App\Http\Controllers;

use App\Models\Freezer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FreezerController extends Controller
{
    public function index()
    {
        $freezers = Freezer::all();
        return view('freezers.index', compact('freezers'));
    }

    public function create()
    {
        return view('freezers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'temp_min' => 'required|numeric|min:-50|max:50',
            'temp_max' => 'required|numeric|min:-50|max:50|gte:temp_min',
            'umid_min' => 'required|numeric|min:0|max:100',
            'umid_max' => 'required|numeric|min:0|max:100|gte:umid_min',
        ]);

        Freezer::create($request->all());
        return redirect()->route('freezers.index')->with('success', 'Freezer criado com sucesso.');
    }

    public function show(Freezer $freezer, Request $request)
{
    // Datas padrão: mês atual
    $startDate = Carbon::parse($request->input('start_date', Carbon::now()))
        ->startOfDay();

    $endDate = Carbon::parse($request->input('end_date', Carbon::now()))
        ->endOfDay();

    // Define ponto inicial customizado (ex: 06:36)
    $inicio = $startDate->copy()->setTimeFromTimeString('06:36');
    if ($inicio->lt($startDate)) {
        $inicio = $inicio->addMinutes(10); // pula para o próximo intervalo se antes do startDate
    }

    $leiturasFiltradas = [];

    for ($momento = $inicio->copy(); $momento->lte($endDate); $momento->addMinutes(10)) {
        $proxima = $momento->copy()->addMinutes(10);

        $leitura = $freezer->leituras()
            ->whereBetween('created_at', [$momento, $proxima])
            ->orderBy('created_at')
            ->first();

        if ($leitura) {
            $leiturasFiltradas[] = $leitura;
        }
    }

    // Preparar dados do gráfico com as leituras filtradas
    $labels = collect($leiturasFiltradas)->pluck('created_at')->map->format('d/m/Y H:i');
    $temperaturas = collect($leiturasFiltradas)->pluck('temperatura');
    $umidades = collect($leiturasFiltradas)->pluck('umidade');

    return view('freezers.show', compact(
        'freezer',
        'startDate',
        'endDate',
        'labels',
        'temperaturas',
        'umidades'
    ));
}


    public function edit(Freezer $freezer)
    {
        return view('freezers.edit', compact('freezer'));
    }

    public function update(Request $request, Freezer $freezer)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'temp_min' => 'required|numeric|min:-50|max:50',
            'temp_max' => 'required|numeric|min:-50|max:50|gte:temp_min',
            'umid_min' => 'required|numeric|min:0|max:100',
            'umid_max' => 'required|numeric|min:0|max:100|gte:umid_min',
        ]);

        $freezer->update($request->all());
        return redirect()->route('freezers.index')->with('success', 'Freezer atualizado com sucesso.');
    }

    public function destroy(Freezer $freezer)
    {
        $freezer->delete();
        return redirect()->route('freezers.index')->with('success', 'Freezer removido com sucesso.');
    }
}
