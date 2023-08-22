<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    use HasFactory;
    protected $table = 'teknisis';
    protected $primaryKey = 'id_teknisi';
    protected $fillable = [
        'fotoprofil',
        'nama_lengkap',
        'username',
        'email',
        'no_telp',
        'password',
        'role',
        'pic_admin',
        'id_status',
    ];
    protected $hidden = [
        'password'
    ];
    protected $casts = [
        'password' => 'hashed'
    ];
}
