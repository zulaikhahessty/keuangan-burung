<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'event_id'    => 'required|integer|exists:events,id',
            'keterangan'  => 'required|string|max:255',
            'jumlah'      => 'required|integer',
        ]);

        $pengeluaran = Pengeluaran::create($data);

        // Recalculate event totals after adding an expense
        EventController::updateTotalsAndBalance($pengeluaran->event);

        return redirect()->back()->with('ok', 'Pengeluaran berhasil ditambahkan.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $event = $pengeluaran->event; // Get the parent event before deletion
        $pengeluaran->delete();

        // Recalculate event totals after deleting an expense
        EventController::updateTotalsAndBalance($event);

        return redirect()->back()->with('ok', 'Pengeluaran berhasil dihapus.');
    }
}