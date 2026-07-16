<?php

namespace App\Http\Controllers;

use App\Models\EventoCalendario;
use Illuminate\Http\Request;

class EventoCalendarioController extends Controller
{
    public function index(Request $request)
    {
        $query = EventoCalendario::query()->orderBy('fecha');

        if ($request->has('mes') && $request->has('anio')) {
            $query->whereMonth('fecha', $request->mes)
                  ->whereYear('fecha', $request->anio);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:capacitacion,acto,feriado,reunion,taller',
            'fecha' => 'required|date',
            'hora' => 'nullable',
            'descripcion' => 'nullable|string',
            'autor_nombre' => 'nullable|string',
            'autor_rol' => 'nullable|string',
        ]);

        $evento = EventoCalendario::create($validated);

        return response()->json($evento, 201);
    }

    public function update(Request $request, EventoCalendario $eventoCalendario)
    {
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|in:capacitacion,acto,feriado,reunion,taller',
            'fecha' => 'sometimes|required|date',
            'hora' => 'nullable',
            'descripcion' => 'nullable|string',
        ]);

        $eventoCalendario->update($validated);

        return response()->json($eventoCalendario);
    }

    public function destroy(EventoCalendario $eventoCalendario)
    {
        $eventoCalendario->delete();

        return response()->json(['message' => 'Evento eliminado'], 200);
    }
}
