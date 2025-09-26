<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        // puedes paginar si quieres: ->paginate(12)
        $rooms = Room::orderBy('created_at', 'desc')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'capacity'    => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        $data['occupancy'] = 0;
        Room::create($data);

        return redirect()->route('rooms.index')->with('ok', 'Sala creada.');
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'capacity'    => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        // Ajusta ocupación si quedó mayor a nueva capacidad
        if ($room->occupancy > $data['capacity']) {
            $data['occupancy'] = $data['capacity'];
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('ok', 'Sala actualizada.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('ok', 'Sala eliminada.');
    }

    public function checkin(Request $request, Room $room)
    {
        // +1 persona (o n si envías 'count')
        $count = (int) $request->input('count', 1);
        if ($count < 1) $count = 1;

        $new = $room->occupancy + $count;
        if ($new > $room->capacity) {
            return redirect()->route('rooms.index')->with('error', 'Capacidad excedida.');
        }

        $room->update(['occupancy' => $new]);

        return redirect()->route('rooms.index')->with('ok', 'Ingreso registrado.');
    }

    public function checkout(Request $request, Room $room)
    {
        // -1 persona (o n si envías 'count')
        $count = (int) $request->input('count', 1);
        if ($count < 1) $count = 1;

        $new = max(0, $room->occupancy - $count);
        $room->update(['occupancy' => $new]);

        return redirect()->route('rooms.index')->with('ok', 'Egreso registrado.');
    }
}
