<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id','kategori_id','judul', 'penulis', 'penerbit','tahun','isbn','jumlah'
    ];

    public function Kategori():BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
