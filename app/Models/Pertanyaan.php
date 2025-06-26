<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
       'kode_gejala','pertanyaan', 'kategori','tampilkan_di_user',
    ];
}
