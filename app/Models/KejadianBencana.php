<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KejadianBencana extends Model
{
    use HasFactory;

    protected $table = 'kejadian_bencana';
    protected $primaryKey = 'kejadian_id';

    protected $fillable = [
        'jenis_bencana',
        'tanggal',
        'lokasi_text',
        'rt',
        'rw',
        'dampak',
        'status_kejadian',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected $appends = ['foto_url'];

    // ========== RELASI SESUAI STRUKTUR TABEL ==========
    
    // 1. Relasi ke PoskoBencana (Satu kejadian bisa punya banyak posko)
    public function posko()
    {
        return $this->hasMany(PoskoBencana::class, 'kejadian_id', 'kejadian_id');
    }
    
    // 2. Relasi ke DonasiBencana (Satu kejadian bisa punya banyak donasi)
    public function donasi()
    {
        return $this->hasMany(DonasiBencana::class, 'kejadian_id', 'kejadian_id');
    }
    
    // 3. Relasi ke LogistikBencana (Satu kejadian bisa punya banyak logistik)
    public function logistik()
    {
        return $this->hasMany(LogistikBencana::class, 'kejadian_id', 'kejadian_id');
    }
    
    // 4. Relasi ke DistribusiLogistik (melalui posko)
    // Tidak ada relasi langsung, tapi bisa diakses melalui posko()
    
    // =================================================

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return asset('images/no-image.png');
        }
        return asset('storage/' . $this->foto);
    }

    // Helper untuk status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Dilaporkan' => 'danger',
            'Verifikasi' => 'warning',
            'Selesai' => 'success',
        ];
        
        return '<span class="badge bg-' . ($badges[$this->status_kejadian] ?? 'secondary') . '">' . $this->status_kejadian . '</span>';
    }

    // Helper untuk lokasi lengkap
    public function getLokasiLengkapAttribute()
    {
        $lokasi = $this->lokasi_text;
        if ($this->rt) {
            $lokasi .= ' | RT ' . $this->rt;
        }
        if ($this->rw) {
            $lokasi .= ' / RW ' . $this->rw;
        }
        return $lokasi;
    }
}