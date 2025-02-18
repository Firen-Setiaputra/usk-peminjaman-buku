<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['peminjaman_id', 'tgl_pengembalian', 'denda'];
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(peminjaman::class);
    }
}
