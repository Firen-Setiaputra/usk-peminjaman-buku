<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
