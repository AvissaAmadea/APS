<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primarykey = 'id';
    protected $guarded = [
        'id',
        'kode_pinjam',
    ];
    protected $fillable = [
        'user_id',
        'aset_id',
        'tgl_pinjam',
        'tgl_kembali',
        'tujuan',
        'surat_pinjam',
        'status_pinjam',
    ];

    protected $casts = [
        'status_pinjam' => 'string', // Tipe data enum diubah menjadi string
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asets() {
        return $this->belongsTo(Aset::class, 'aset_id', 'id');
    }

    public function dinas() {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }
}
