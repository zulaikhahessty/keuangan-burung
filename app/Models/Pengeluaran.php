<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'event_id','uraian','jumlah'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
