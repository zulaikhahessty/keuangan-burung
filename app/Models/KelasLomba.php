<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasLomba extends Model
{
    protected $fillable = [
        'event_id',
        'nama_kelas',
        'harga_tiket',
        'jumlah_peserta',
        'hadiah_1','hadiah_2','hadiah_3','hadiah_4','hadiah_5',
        'hadiah_6','hadiah_7','hadiah_8','hadiah_9','hadiah_10',
        'jumlah_piala',
        'total_tiket',
        'total_hadiah',
        'laba_bersih',
    ];

    protected $casts = [
        'event_id'       => 'integer',
        'harga_tiket'    => 'integer',
        'jumlah_peserta' => 'integer',
        'jumlah_piala'   => 'integer',
        'total_tiket'    => 'integer',
        'total_hadiah'   => 'integer',
        'laba_bersih'    => 'integer',
        'hadiah_1'       => 'integer',
        'hadiah_2'       => 'integer',
        'hadiah_3'       => 'integer',
        'hadiah_4'       => 'integer',
        'hadiah_5'       => 'integer',
        'hadiah_6'       => 'integer',
        'hadiah_7'       => 'integer',
        'hadiah_8'       => 'integer',
        'hadiah_9'       => 'integer',
        'hadiah_10'      => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /** Hitung ulang total tiket/hadiah & laba. Panggil ini sebelum save. */
    public function recomputeTotals(): void
    {
        $this->total_tiket = (int) $this->harga_tiket * (int) $this->jumlah_peserta;

        $hadiah = 0;
        for ($i = 1; $i <= 10; $i++) {
            $hadiah += (int) ($this->{"hadiah_{$i}"} ?? 0);
        }
        $this->total_hadiah = $hadiah;
        $this->laba_bersih  = (int) $this->total_tiket - (int) $this->total_hadiah;
    }

    /** JSON untuk AJAX (view) */
    public function toAjaxRow(): array
    {
        $row = $this->only([
            'id','event_id','nama_kelas','harga_tiket','jumlah_peserta',
            'jumlah_piala','total_tiket','total_hadiah','laba_bersih',
            'hadiah_1','hadiah_2','hadiah_3','hadiah_4','hadiah_5',
            'hadiah_6','hadiah_7','hadiah_8','hadiah_9','hadiah_10',
        ]);

        foreach ([
            'harga_tiket','jumlah_peserta','jumlah_piala','total_tiket','total_hadiah','laba_bersih',
            'hadiah_1','hadiah_2','hadiah_3','hadiah_4','hadiah_5',
            'hadiah_6','hadiah_7','hadiah_8','hadiah_9','hadiah_10'
        ] as $k) {
            $row[$k] = (int) ($row[$k] ?? 0);
        }

        return $row;
    }
}
