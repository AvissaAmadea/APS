<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asets';

    protected $fillable = [
        'namaAset',
        'alamat'];

    protected $guarded = [
        'id',
    ];

    public function kategoris() {
        return $this->belongsTo(Kategori::class, 'kat_id'); // one-to-many relationship
    }
}
