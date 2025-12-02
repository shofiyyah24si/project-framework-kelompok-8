<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    protected $fillable = [
        'nama', 'nik', 'alamat', 'rt', 'rw', 'no_hp'
    ];
}
