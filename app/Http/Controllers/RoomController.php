<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
{
    $q = (string) $request->query('q', '');
    $showTrashed = $request->boolean('trashed');

    $query = \App\Models\Room::query();

    if ($showTrashed) {
        $query->onlyTrashed();
    }

    if ($q !== '') {
        $query->where(function ($qq) use ($q) {
            $qq->where('name', 'ilike', "%{$q}%")
               ->orWhere('location', 'ilike', "%{$q}%");
        });
    }

    $rooms = $query->orderByDesc('id')
                   ->paginate(10)
                   ->withQueryString();

    return view('rooms.index', compact('rooms', 'q', 'showTrashed'));
}


    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required','string','min:3','max:120','unique:rooms,name'],
            'capacity' => ['required','integer','min:1'],
            'status'   => ['required', Rule::in(['disponible','ocupada','mantenimiento'])],
            'location' => ['nullable','string','max:120'],
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Sala creada correctamente.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name'     => ['required','string','min:3','max:120', Rule::unique('rooms','name')->ignore($room->id)],
            'capacity' => ['required','integer','min:1'],
            'status'   => ['required', Rule::in(['disponible','ocupada','mantenimiento'])],
            'location' => ['nullable','string','max:120'],
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Sala actualizada.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Sala eliminada.');
    }
    public function restore($id)
{
    $room = \App\Models\Room::withTrashed()->findOrFail($id);
    $room->restore();

    return redirect()->route('rooms.index', request()->query())
        ->with('success', 'Sala restaurada.');
}
public function forceDelete($id)
{
    $room = \App\Models\Room::withTrashed()->findOrFail($id);
    $room->forceDelete(); // elimina físicamente

    return redirect()
        ->route('rooms.index', ['trashed' => 1]) // volver a vista de eliminadas
        ->with('success', 'Sala eliminada definitivamente.');
}
}
