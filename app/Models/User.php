<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function kompensasis()
    {
        return $this->hasMany(Kompensasi::class);
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        /**
     * Cek role user (satu role)
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Cek banyak role (misal: admin atau petugas)
     */
    public function hasAnyRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }

}
