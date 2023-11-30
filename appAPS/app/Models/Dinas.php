<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_dinas',
        'alamat'
    ];

    protected $guarded = [
        'id',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
