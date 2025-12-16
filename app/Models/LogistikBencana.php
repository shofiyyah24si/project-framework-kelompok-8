<?php
// app/Models/LogistikBencana.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogistikBencana extends Model
{
    use HasFactory;

    protected $table = 'logistik_bencana';
    protected $primaryKey = 'logistik_id';
    
    protected $fillable = [
        'kejadian_id',
        'nama_barang',
        'satuan',
        'stok',
        'sumber',
        'keterangan',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'status'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'tersedia' => 'success',
            'dipinjam' => 'warning',
            'habis' => 'danger',
            'kadaluarsa' => 'dark'
        ];

        return '<span class="badge bg-' . ($badges[$this->status] ?? 'secondary') . '">' . ucfirst($this->status) . '</span>';
    }

    public function getSisaHariAttribute()
    {
        if (!$this->tanggal_kadaluarsa) {
            return null;
        }

        $now = now();
        $expire = $this->tanggal_kadaluarsa;
        
        return $now->diffInDays($expire, false);
    }
}