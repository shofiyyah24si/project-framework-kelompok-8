<?php
// app/Models/DistribusiLogistik.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiLogistik extends Model
{
    use HasFactory;

    protected $table = 'distribusi_logistik';
    protected $primaryKey = 'distribusi_id';
    protected $fillable = [
        'logistik_id',
        'posko_id',
        'tanggal',
        'jumlah',
        'penerima',
        'bukti_distribusi',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer'
    ];

    // Relasi ke LogistikBencana
    public function logistik()
    {
        return $this->belongsTo(LogistikBencana::class, 'logistik_id', 'logistik_id');
    }

    // Relasi ke PoskoBencana (DIPERBAIKI)
    public function posko()
    {
        return $this->belongsTo(PoskoBencana::class, 'posko_id', 'posko_id');
    }

    // Format tanggal
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : '';
    }
}