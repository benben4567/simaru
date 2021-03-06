<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = "periode";
    protected $fillable = ['tahun', 'status'];

    public function maba()
    {
        return $this->hasMany(Maba::class);
    }

    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }
}
