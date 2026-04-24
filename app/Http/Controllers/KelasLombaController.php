<?php

namespace App\Http\Controllers;

use App\Models\KelasLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasLombaController extends Controller
{
    // ==== Helpers ====

    /** Hitung turunan total_tiket, total_hadiah, laba_bersih dari instance (in-place). */
    private function recomputeDerived(KelasLomba $row): KelasLomba
    {
        // total tiket
        $row->total_tiket = (int) $row->harga_tiket * (int) $row->jumlah_peserta;

        // total hadiah (hadiah_1..hadiah_10)
        $totalHadiah = 0;
        for ($i = 1; $i <= 10; $i++) {
            $v = (int) ($row->{"hadiah_{$i}"} ?? 0);
            $row->{"hadiah_{$i}"} = $v; // normalisasi supaya tidak null
            $totalHadiah += $v;
        }
        $row->total_hadiah = $totalHadiah;

        // biaya piala: sekarang dianggap nominal (pengeluaran)
        $biayaPiala = (int) ($row->jumlah_piala ?? 0);

        // laba = pemasukan - (hadiah + piala)
        $row->laba_bersih  = (int) $row->total_tiket - (int) $row->total_hadiah - $biayaPiala;

        return $row;
    }

    /** Kembalikan payload JSON standar untuk baris kelas. */
    private function rowPayload(KelasLomba $row): array
    {
        // Pastikan nilai terbaru
        $row = $this->recomputeDerived($row);

        return [
            'id'             => (int) $row->id,
            'event_id'       => (int) $row->event_id,
            'nama_kelas'     => (string) $row->nama_kelas,
            'harga_tiket'    => (int) $row->harga_tiket,
            'jumlah_peserta' => (int) $row->jumlah_peserta,
            'total_tiket'    => (int) $row->total_tiket,

            'hadiah_1'       => (int) ($row->hadiah_1 ?? 0),
            'hadiah_2'       => (int) ($row->hadiah_2 ?? 0),
            'hadiah_3'       => (int) ($row->hadiah_3 ?? 0),
            'hadiah_4'       => (int) ($row->hadiah_4 ?? 0),
            'hadiah_5'       => (int) ($row->hadiah_5 ?? 0),
            'hadiah_6'       => (int) ($row->hadiah_6 ?? 0),
            'hadiah_7'       => (int) ($row->hadiah_7 ?? 0),
            'hadiah_8'       => (int) ($row->hadiah_8 ?? 0),
            'hadiah_9'       => (int) ($row->hadiah_9 ?? 0),
            'hadiah_10'      => (int) ($row->hadiah_10 ?? 0),

            'total_hadiah'   => (int) $row->total_hadiah,

            // Tetap pakai nama field lama, tapi maknanya: biaya piala (Rp)
            'jumlah_piala'   => (int) ($row->jumlah_piala ?? 0),

            'laba_bersih'    => (int) $row->laba_bersih,
            'created_at'     => optional($row->created_at)->toISOString(),
            'updated_at'     => optional($row->updated_at)->toISOString(),
        ];
    }

    // ==== Actions ====

    public function store(Request $r)
    {
        $data = $r->validate([
            'event_id'       => 'required|exists:events,id',
            'nama_kelas'     => 'required|string|max:100',
            'harga_tiket'    => 'required|integer|min:0',
            'jumlah_peserta' => 'required|integer|min:0',

            'hadiah_1'       => 'nullable|integer|min:0',
            'hadiah_2'       => 'nullable|integer|min:0',
            'hadiah_3'       => 'nullable|integer|min:0',
            'hadiah_4'       => 'nullable|integer|min:0',
            'hadiah_5'       => 'nullable|integer|min:0',
            'hadiah_6'       => 'nullable|integer|min:0',
            'hadiah_7'       => 'nullable|integer|min:0',
            'hadiah_8'       => 'nullable|integer|min:0',
            'hadiah_9'       => 'nullable|integer|min:0',
            'hadiah_10'      => 'nullable|integer|min:0',

            // sekarang dianggap nominal biaya piala
            'jumlah_piala'   => 'nullable|integer|min:0',
        ]);

        return DB::transaction(function () use ($data, $r) {
            $row = new KelasLomba($data);
            $this->recomputeDerived($row);
            $row->save();

            // Hitung ulang agregat event
            EventController::recomputeEvent((int) $row->event_id);

            if ($r->expectsJson()) {
                return response()->json([
                    'ok'  => true,
                    'row' => $this->rowPayload($row->fresh()),
                ]);
            }

            return back()->with('ok', 'Kelas lomba berhasil ditambahkan.');
        });
    }

    public function edit($id)
    {
        $kelasLomba = KelasLomba::findOrFail($id);
        return view('kelas-lomba.edit', compact('kelasLomba'));
    }

    public function update(Request $r, $id)
    {
        $row = KelasLomba::findOrFail($id);

        $data = $r->validate([
            'nama_kelas'     => 'required|string|max:100',
            'harga_tiket'    => 'required|integer|min:0',
            'jumlah_peserta' => 'required|integer|min:0',

            'hadiah_1'       => 'nullable|integer|min:0',
            'hadiah_2'       => 'nullable|integer|min:0',
            'hadiah_3'       => 'nullable|integer|min:0',
            'hadiah_4'       => 'nullable|integer|min:0',
            'hadiah_5'       => 'nullable|integer|min:0',
            'hadiah_6'       => 'nullable|integer|min:0',
            'hadiah_7'       => 'nullable|integer|min:0',
            'hadiah_8'       => 'nullable|integer|min:0',
            'hadiah_9'       => 'nullable|integer|min:0',
            'hadiah_10'      => 'nullable|integer|min:0',

            // sekarang dianggap nominal biaya piala
            'jumlah_piala'   => 'nullable|integer|min:0',
        ]);

        return DB::transaction(function () use ($row, $data, $r) {
            $row->fill($data);
            $this->recomputeDerived($row);
            $row->save();

            EventController::recomputeEvent((int) $row->event_id);

            if ($r->expectsJson()) {
                return response()->json([
                    'ok'  => true,
                    'row' => $this->rowPayload($row->fresh()),
                ]);
            }

            return back()->with('ok', 'Kelas lomba berhasil diperbarui.');
        });
    }

    public function destroy(Request $r, $id)
    {
        $row = KelasLomba::findOrFail($id);

        return DB::transaction(function () use ($row, $r) {
            $eventId = (int) $row->event_id;
            $rowId   = (int) $row->id;

            $row->delete();
            EventController::recomputeEvent($eventId);

            if ($r->expectsJson()) {
                return response()->json([
                    'ok'       => true,
                    'deleted'  => $rowId,
                    'event_id' => $eventId,
                ]);
            }

            return back()->with('ok', 'Kelas lomba dihapus.');
        });
    }
}
