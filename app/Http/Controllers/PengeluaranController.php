<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /** Bentuk payload JSON rapi untuk satu baris pengeluaran. */
    private function rowPayload(Pengeluaran $row): array
    {
        return [
            'id'      => (int) $row->id,
            'event_id'=> (int) $row->event_id,
            'uraian'  => (string) $row->uraian,
            'jumlah'  => (int) $row->jumlah,
            'created_at' => optional($row->created_at)->toISOString(),
            'updated_at' => optional($row->updated_at)->toISOString(),
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required','exists:events,id'],
            'uraian'   => ['required','string','max:200'],
            'jumlah'   => ['required','integer','min:0'],
        ]);

        $row = Pengeluaran::create($data);

        EventController::recomputeEvent((int) $row->event_id);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'  => true,
                'row' => $this->rowPayload($row->fresh()),
            ]);
        }

        return back()->with('ok','Pengeluaran ditambahkan.');
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        // Rekomendasi: jangan izinkan pindah event di update.
        // Kalau kamu memang perlu, pindahkan validasi event_id ke sini dan set $pengeluaran->event_id = $request->event_id;
        $data = $request->validate([
            'uraian' => ['required','string','max:200'],
            'jumlah' => ['required','integer','min:0'],
        ]);

        $pengeluaran->fill($data)->save();
        $pengeluaran->refresh();

        EventController::recomputeEvent((int) $pengeluaran->event_id);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'  => true,
                'row' => $this->rowPayload($pengeluaran),
            ]);
        }

        return back()->with('ok','Pengeluaran diperbarui.');
    }

    public function destroy(Request $request, Pengeluaran $pengeluaran)
    {
        $eventId = (int) $pengeluaran->event_id;
        $deletedId = (int) $pengeluaran->id;

        $pengeluaran->delete();
        EventController::recomputeEvent($eventId);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'      => true,
                'deleted' => $deletedId,
                'event_id'=> $eventId,
            ]);
        }

        return back()->with('ok','Pengeluaran dihapus.');
    }
}
