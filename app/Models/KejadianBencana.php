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

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return asset('images/no-image.png');
        }
        return asset('storage/' . $this->foto);
    }

    // HAPUS RELASI files() SELURUHNYA
    // public function files()
    // {
    //     return $this->hasMany(KejadianFile::class, 'kejadian_id');
    // }
    
    // HAPUS relasi posko() jika tidak dibutuhkan
    // public function posko()
    // {
    //     return $this->hasMany(PoskoBencana::class, 'kejadian_id');
    // }
}