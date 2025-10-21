<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $table = 'relawan';
    protected $fillable = ['nama', 'alamat', 'no_hp', 'keahlian'];
}
