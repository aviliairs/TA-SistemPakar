<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakar extends Model
{
    protected $table = 'pakar';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama_pakar', 'email_pakar', 'jabatan', 'jenis_kelamin',
    ];
}
