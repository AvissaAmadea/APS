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
        return $this->hasMany(Dinas::class); // one-to-many relationship
    }

    public function roles() {
        return $this->belongsToMany(Roles::class); // many-to-many relationship
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
        switch ($this->role_id) {
            case 1:
                return route("superadmin.dashboard");
            case 2:
                return route("sekda.dashboard");
            case 3:
                return route("opd.dashboard");
            default:
                return "/login";
        }
    }
}
