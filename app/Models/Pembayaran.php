<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
    ];

    // Set timestamps menjadi true
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengembalian) {
           // Set waktu saat ini dalam zona waktu UTC
        $now = Carbon::now('UTC');

        // Ubah zona waktu ke WIB sebelum disimpan
        $now->setTimezone('Asia/Jakarta');

        $pengembalian->created_at = $now;
        $pengembalian->updated_at = null; // Mengatur updated_at menjadi null saat data pertama kali dibuat
        });

        static::updating(function ($pengembalian) {
             // Set waktu saat ini dalam zona waktu UTC
            $now = Carbon::now('UTC');

            // Ubah zona waktu ke WIB sebelum disimpan
            $now->setTimezone('Asia/Jakarta');

            $pengembalian->updated_at = $now; // Mengatur updated_at ketika data diubah
        });
    }

    protected $fillable = [
        'sanksi',
        'bukti_pelunasan',
        'status_pelunasan',
    ];

    protected $casts = [
        'status_pelunasan' => 'string', // Tipe data enum diubah menjadi string
    ];

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class, 'kode_pinjam','kode_pinjam');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
