<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
    ];

    // Set timestamps menjadi true
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
           // Set waktu saat ini dalam zona waktu UTC
        $now = Carbon::now('UTC');

        // Ubah zona waktu ke WIB sebelum disimpan
        $now->setTimezone('Asia/Jakarta');

        $peminjaman->created_at = $now;
        $peminjaman->updated_at = null; // Mengatur updated_at menjadi null saat data pertama kali dibuat
        });

        static::updating(function ($peminjaman) {
             // Set waktu saat ini dalam zona waktu UTC
            $now = Carbon::now('UTC');

            // Ubah zona waktu ke WIB sebelum disimpan
            $now->setTimezone('Asia/Jakarta');

            $peminjaman->updated_at = $now; // Mengatur updated_at ketika data diubah
        });
    }

    protected $fillable = [
        'kode_pinjam',
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
