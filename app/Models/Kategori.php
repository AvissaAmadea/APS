<?php

namespace App\Models;

use App\Models\Aset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = ['jenis'];

    protected $guarded = [
        'id',
    ];

    public function asets() {
        return $this->hasMany(Aset::class, 'kat_id');
    }
}
