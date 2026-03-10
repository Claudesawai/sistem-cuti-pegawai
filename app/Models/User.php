<?php

namespace App\Models;

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
        'nip',
        'name',
        'email',
        'password',
        'role',
        'jabatan',
        'sisa_cuti',
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
        'sisa_cuti' => 'integer',
    ];

    /**
     * Relasi: User memiliki banyak Cuti
     */
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'user_id');
    }

    /**
     * Relasi: User menyetujui banyak Cuti (untuk atasan)
     */
    public function approvedCuti()
    {
        return $this->hasMany(Cuti::class, 'approved_by');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is atasan
     */
    public function isAtasan(): bool
    {
        return $this->role === 'atasan';
    }

    /**
     * Check if user is pegawai
     */
    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    /**
     * Get redirect route based on role
     */
    public function getRedirectRoute(): string
    {
        return match($this->role) {
            'admin' => 'admin.dashboard',
            'atasan' => 'atasan.dashboard',
            'pegawai' => 'pegawai.dashboard',
            default => 'login',
        };
    }
}
