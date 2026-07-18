<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaDispensasi extends Model
{
    protected $table = 'peserta_dispensasis';

    protected $fillable = [
        'surat_dispensasi_id',
        'nama',
        'kelas',
        'ket',
    ];

    public function suratDispensasi(): BelongsTo
    {
        return $this->belongsTo(SuratDispensasi::class);
    }
}
