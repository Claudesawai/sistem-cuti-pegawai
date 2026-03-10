<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Cuti extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cuti';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan',
        'file_pendukung',
        'status',
        'catatan_atasan',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jumlah_hari' => 'integer',
    ];

    /**
     * Relasi: Cuti dimiliki oleh User (pegawai)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Cuti disetujui oleh User (atasan)
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Hitung jumlah hari cuti otomatis
     */
    public static function hitungJumlahHari($tanggalMulai, $tanggalSelesai): int
    {
        $start = Carbon::parse($tanggalMulai);
        $end = Carbon::parse($tanggalSelesai);
        
        // Hitung selisih hari + 1 (termasuk hari pertama)
        return $start->diffInDays($end) + 1;
    }

    /**
     * Validasi tanggal tidak boleh terbalik
     */
    public static function validasiTanggal($tanggalMulai, $tanggalSelesai): bool
    {
        $start = Carbon::parse($tanggalMulai);
        $end = Carbon::parse($tanggalSelesai);
        
        return $start->lte($end);
    }

    /**
     * Validasi tanggal tidak boleh lampau
     */
    public static function validasiTanggalLampau($tanggalMulai): bool
    {
        $start = Carbon::parse($tanggalMulai);
        $today = Carbon::today();
        
        return $start->gte($today);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan jenis cuti
     */
    public function scopeJenisCuti($query, $jenis)
    {
        return $query->where('jenis_cuti', $jenis);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_mulai', [$startDate, $endDate]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Get jenis cuti label
     */
    public function getJenisCutiLabelAttribute(): string
    {
        return match($this->jenis_cuti) {
            'cuti_tahunan' => 'Cuti Tahunan',
            'cuti_sakit' => 'Cuti Sakit',
            'izin' => 'Izin',
            default => 'Unknown',
        };
    }

    /**
     * Boot method untuk event model
     */
    protected static function boot()
    {
        parent::boot();

        // Hitung jumlah hari otomatis sebelum create
        static::creating(function ($cuti) {
            if (empty($cuti->jumlah_hari)) {
                $cuti->jumlah_hari = self::hitungJumlahHari($cuti->tanggal_mulai, $cuti->tanggal_selesai);
            }
        });

        // Update sisa cuti saat disetujui
        static::updated(function ($cuti) {
            if ($cuti->wasChanged('status')) {
                if ($cuti->status === 'disetujui' && $cuti->jenis_cuti === 'cuti_tahunan') {
                    $user = $cuti->user;
                    if ($user && $user->sisa_cuti >= $cuti->jumlah_hari) {
                        $user->decrement('sisa_cuti', $cuti->jumlah_hari);
                    }
                }
            }
        });
    }
}
