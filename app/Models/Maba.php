<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maba extends Model
{
    use HasFactory;

    protected $table = "maba";
    protected $fillable = ['no_pendaftaran', 'nama', 'prodi_1', 'prodi_2', 'nilai', 'telp', 'prodi_lulus', 'pembayaran', 'nim', 'jalur_pendaftaran', 'gelombang', 'rekomendasi', 'nama_perekom', 'telp_perekom', 'file_rekom', 'jenis_pencairan', 'tgl_pengajuan', 'tgl_pencairan', 'tgl_pendaftaran', 'tgl_validasi', 'tgl_lulus', 'tgl_pembayaran', 'tgl_nim'];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
