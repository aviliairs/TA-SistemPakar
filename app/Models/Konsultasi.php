<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'riwayat_diagnosa';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_user','nama', 'tanggal','hasil',
    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
