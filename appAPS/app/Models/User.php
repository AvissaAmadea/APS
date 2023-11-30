<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'telp',
        'email',
        'password',
        'dinas_id',
        'role_id',
    ];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dinas() {
        return $this->belongsTo(Dinas::class, 'dinas_id'); // one-to-many relationship
    }

    public function roles() {
        return $this->belongsTo(Roles::class, 'role_id'); // many-to-many relationship
    }

     // Query scope to load dinas
     public function scopeWithDinas($query)
     {
         return $query->with('dinas');
     }

     // Query scope to load roles
    public function scopeWithRoles($query)
    {
        return $query->with('roles');
    }

    public function checkRole()
    {
        if ($this->role_id == 1) {
            return "dashboard.superadmin";
        } else if ($this->role_id == 2) {
            return "dashboard.sekda";
        } else if ($this->role_id == 3) {
            return "dashboard.opd";
        } else {
            return "/login";
        }
    }

}
