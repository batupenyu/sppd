<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $table = 'data_siswa';

    protected $fillable = [
        'nama',
        'nisn',
        'nis',
        'tgl_lahir',
        'kelas',
        'alamat',
    ];
}
