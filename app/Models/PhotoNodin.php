<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoNodin extends Model
{
    protected $fillable = [
        'surat_nodin_id',
        'caption',
        'mime',
        'image',
    ];

    public function suratNodin(): BelongsTo
    {
        return $this->belongsTo(SuratNodin::class);
    }
}
