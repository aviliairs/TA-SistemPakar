<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = 'rules';
    protected $primaryKey = 'id_rule';
    public $timestamps = false;

    protected $fillable = [
        'kode_rule','kode_gejala', 'kategori', 'kondisi','kesimpulan',
    ];
}
