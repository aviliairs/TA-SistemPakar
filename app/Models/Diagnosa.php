<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    protected $table = 'diagnosa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_user', 'kode_gejala', 'kategori','kondisi','kesimpulan','created_at','updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
