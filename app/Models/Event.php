<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'tanggal','venue','saldo_awal',
        'total_tiket','total_hadiah','total_operasional','saldo_akhir',
    ];

    protected $casts = [
        'tanggal'           => 'date',
        'saldo_awal'        => 'integer',
        'total_tiket'       => 'integer',
        'total_hadiah'      => 'integer',
        'total_operasional' => 'integer',
        'saldo_akhir'       => 'integer',
    ];

    public function kelasLombas()
    {
        // Tidak ada lagi orderBy sesi_ke
        return $this->hasMany(KelasLomba::class)
                    ->orderBy('nama_kelas', 'asc'); // opsional
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}
