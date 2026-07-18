<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanCuti extends Model
{
    protected $table = 'laporan_cutis';

    protected $fillable = [
        'asn_id',
        'tahun',
        'alokasi_awal_tahun_n',
        'alokasi_awal_tahun_n_1',
        'alokasi_awal_tahun_n_2',
        'total_alokasi_awal',
        'penandatangan_id',
    ];

    public function asn(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'asn_id');
    }

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Asn::class, 'penandatangan_id');
    }

    protected static function booted(): void
    {
        static::saving(function (self $laporanCuti) {
            $laporanCuti->total_alokasi_awal = (int) ($laporanCuti->alokasi_awal_tahun_n ?? 0)
                + (int) ($laporanCuti->alokasi_awal_tahun_n_1 ?? 0)
                + (int) ($laporanCuti->alokasi_awal_tahun_n_2 ?? 0);
        });
    }
}
