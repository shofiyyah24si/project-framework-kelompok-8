<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kejadian extends Model
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
        'media',
    ];
}
