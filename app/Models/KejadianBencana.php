<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KejadianBencana extends Model
{
    use HasFactory, SoftDeletes;

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
        'foto', // Foto utama kejadian
    ];

    protected $dates = [
        'tanggal',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * RELASI: 1 Kejadian → Banyak Posko
     */
    public function posko()
    {
        return $this->hasMany(PoskoBencana::class, 'kejadian_id');
    }

    /**
     * RELASI: 1 Kejadian → Banyak File Dokumentasi
     */
    public function files()
    {
        return $this->hasMany(KejadianFile::class, 'kejadian_id');
    }

    /**
     * Accessor: URL Foto Utama
     */
    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return asset('images/no-image.png'); // fallback jika tidak ada foto
        }

        return asset('storage/' . $this->foto);
    }
}
