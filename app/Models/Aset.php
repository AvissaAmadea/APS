<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'asets';

    protected $fillable = [
        'nama_aset',
        'kategori_id',
        'dinas_id',
        'detail',
        'status_aset',
    ];

    protected $casts = [
        'status_aset' => 'string', // Tipe data enum diubah menjadi string
    ];

    protected $guarded = [
        'id',
    ];

    public function kategoris() {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // one-to-many relationship
    }

    public function dinas() {
        return $this->belongsTo(Dinas::class, 'dinas_id'); // one-to-many relationship
    }

}
