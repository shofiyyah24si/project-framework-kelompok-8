<?php
// app/Models/DonasiBencana.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonasiBencana extends Model
{
    use HasFactory;

    protected $table = 'donasi_bencana';
    protected $primaryKey = 'donasi_id';
    
    protected $fillable = [
        'kejadian_id',
        'donatur_nama',
        'jenis',
        'nilai',
        'bukti_donasi',
        'keterangan',
        'tanggal_donasi',
        'metode_pembayaran',
        'status'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'tanggal_donasi' => 'date',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }

    public function getBuktiDonasiUrlAttribute()
    {
        if (!$this->bukti_donasi) {
            return asset('images/no-image.png');
        }
        return asset('storage/' . $this->bukti_donasi);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger'
        ];

        return '<span class="badge bg-' . ($badges[$this->status] ?? 'secondary') . '">' . ucfirst($this->status) . '</span>';
    }
}