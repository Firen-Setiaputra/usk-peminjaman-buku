<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['borowing_id', 'tanggal_pengembalian', 'denda','status'];
    public function Borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public static function Hitungdenda($tgl_pengembalian, $tgl_jatuh_tempo)
    {
        $terlambat = max(0, strtotime($tgl_pengembalian) - strtotime($tgl_jatuh_tempo));
        $hari_terlambat = floor($terlambat / (60 * 60 * 24));
        return $hari_terlambat > 0 ? $hari_terlambat * 5000 : 0;
    }
}
