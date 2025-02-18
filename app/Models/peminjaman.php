<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class peminjaman extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'peminjaman'; // Perbarui nama tabel di model

    protected $fillable = [
        'buku_id','user_id','tgl_pinjam','tgl_kembali','status'
    ];


    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
