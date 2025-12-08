<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KejadianFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kejadian_files';

    protected $fillable = [
        'kejadian_id',
        'nama_file',
        'tipe',
    ];

    /**
     * RELASI: File milik 1 Kejadian
     */
    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }

    /**
     * Accessor: URL file dokumentasi
     */
    public function getUrlAttribute()
    {
        return asset('storage/kejadian/dokumentasi/' . $this->nama_file);
    }

    /**
     * Accessor: Cek apakah file berupa image
     */
    public function getIsImageAttribute()
    {
        return in_array(strtolower($this->tipe), ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Accessor: Cek apakah file berupa video
     */
    public function getIsVideoAttribute()
    {
        return in_array(strtolower($this->tipe), ['mp4', 'avi', 'mov']);
    }

    /**
     * Accessor: Cek apakah file berupa dokumen
     */
    public function getIsDocumentAttribute()
    {
        return in_array(strtolower($this->tipe), ['pdf', 'doc', 'docx']);
    }
}
