<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';

    protected $fillable = ['no_pendaftaran', 'nama', 'prodi_1', 'prodi_2', 'gelombang', 'bayar_pendaftaran', 'jalur', 'password'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
