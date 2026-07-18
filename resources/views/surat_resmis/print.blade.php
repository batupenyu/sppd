<!DOCTYPE html>
<html>
<head>
    <title>Surat Resmi {{ $suratResmi->nomor }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 2.5cm 2.5cm 2.5cm; /* top right bottom left */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20pt;
        }
        .kop-surat img {
            max-width: 100%;
            height: auto;
        }
        .tempat-tanggal-ditetapkan {
            text-align: right;
            margin-bottom: 20pt;
        }
        .tujuan-surat {
            text-align: left;
            margin-bottom: 10pt;
        }
        .tujuan-surat p {
            margin: 0;
            padding: 0;
        }
        .nomor-sifat-lampiran-perihal {
            margin-bottom: 20pt;
            width: 100%;
        }
        .nomor-sifat-lampiran-perihal table {
            width: 100%;
            border-collapse: collapse;
        }
        .nomor-sifat-lampiran-perihal td {
            padding: 0;
            vertical-align: top;
        }
        .nomor-sifat-lampiran-perihal .label {
            width: 80pt;
            text-align: left;
        }
        .nomor-sifat-lampiran-perihal .colon {
            width: 10pt;
            text-align: center;
        }
        .pembuka-surat, .isi-surat, .penutup-surat {
            text-align: justify;
            text-indent: 1cm;
            margin-bottom: 10pt;
            line-height: 1.5;
        }
        .data-pegawai {
            margin-top: 20pt;
            margin-bottom: 20pt;
        }
        .data-pegawai table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-pegawai td {
            padding: 2pt 0;
            vertical-align: top;
        }
        .data-pegawai .label {
            width: 150px;
            white-space: nowrap;
        }
        .data-pegawai .colon {
            width: 10px;
        }
        .detail-kegiatan {
            margin-bottom: 10pt;
        }
        .detail-kegiatan table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-kegiatan td {
            padding: 2pt 0;
            vertical-align: top;
        }
        .detail-kegiatan .label {
            width: 70px;
            white-space: nowrap;
        }
        .detail-kegiatan .colon {
            width: 20px;
            text-align: center;
        }
        .signature-block {
            margin-top: 20pt;
            text-align: left;
            padding-left: 250pt;
        }
        .signature-block p {
            margin: 0;
            padding: 0;
        }
        .signature-name {
            margin-top: 60pt;
            font-weight: bold;
        }
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    @php
        $fmt = fn ($d, $f = '%d %B %Y') => $d ? \App\Http\Controllers\SuratResmiController::formatTanggal($d, $f) : '...................';
        $penandatangan = $suratResmi->penandatangan;
    @endphp

    @if($kopSuratBase64)
        <div class="kop-surat">
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat">
        </div>
    @endif

    <div class="tempat-tanggal-ditetapkan">
        {{ $suratResmi->tempat_ditetapkan }}, {{ $fmt($suratResmi->tanggal_ditetapkan) }}
    </div>

    <div class="nomor-sifat-lampiran-perihal">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td>{{ $suratResmi->nomor }}</td>
            </tr>
            <tr>
                <td class="label">Sifat</td>
                <td class="colon">:</td>
                <td>{{ $suratResmi->sifat }}</td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td class="colon">:</td>
                <td>{{ $suratResmi->lampiran }}</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td><strong>{{ $suratResmi->perihal }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="tujuan-surat">
        <p>Kepada</p>
        <p>Yth. {{ $suratResmi->pejabat_tujuan_surat }}</p>
        <p>di</p>
        <p><strong>{{ $suratResmi->kota_tujuan_surat }}</strong></p>
    </div>

    <div class="pembuka-surat">
        <p>{!! nl2br(e($suratResmi->pembuka_surat)) !!}</p>
    </div>

    @if($suratResmi->tanggal_kegiatan || $suratResmi->waktu_kegiatan || $suratResmi->tempat_kegiatan)
    <div class="detail-kegiatan">
        <table>
            @if($suratResmi->tanggal_kegiatan)
            <tr>
                <td class="label">Hari/Tanggal</td>
                <td class="colon">:</td>
                <td>{{ $fmt($suratResmi->tanggal_kegiatan, '%A, %d %B %Y') }}</td>
            </tr>
            @endif
            @if($suratResmi->waktu_kegiatan)
            <tr>
                <td class="label">Waktu</td>
                <td class="colon">:</td>
                <td>{{ $suratResmi->waktu_kegiatan }}</td>
            </tr>
            @endif
            @if($suratResmi->tempat_kegiatan)
            <tr>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td>{{ $suratResmi->tempat_kegiatan }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    @if($suratResmi->pegawai->isNotEmpty())
    <div class="data-pegawai">
        <p>Adapun nama pegawai yang dimaksud:</p>
        <table>
            @foreach($suratResmi->pegawai as $pegawai)
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td>{{ $pegawai->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="colon">:</td>
                <td>{{ $pegawai->nip }}</td>
            </tr>
            @if($pegawai->pangkat !== '' && $pegawai->pangkat !== 'IX')
            <tr>
                <td class="label">Pangkat/Gol. Ruang</td>
                <td class="colon">:</td>
                <td>{{ $pegawai->pangkat }}/{{ $pegawai->golongan }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td>{{ $pegawai->jabatan ?? ($pegawai->tugas_tambahan ?: ($pegawai->jenis_ptk ?: '')) }}</td>
            </tr>
            <tr>
                <td class="label">Unit Kerja</td>
                <td class="colon">:</td>
                <td>{{ $pegawai->lembaga_pengangkatan }}</td>
            </tr>
            @if(!$loop->last)
            <tr><td colspan="3"><hr style="border-top: 1px dashed #ccc;"></td></tr>
            @endif
            @endforeach
        </table>
    </div>
    @endif

    <div class="isi-surat">
        <p>{!! nl2br(e($suratResmi->isi_surat)) !!}</p>
    </div>

    <div class="penutup-surat">
        <p>{!! nl2br(e($suratResmi->penutup_surat)) !!}</p>
    </div>

    @if($penandatangan)
    <div class="signature-block">
        <p>{{ $penandatangan->jabatan ?? '' }} <br><br><br><br><br></p>
        <p class="signature-name">{{ $penandatangan->nama ?? '' }} <br>
            @if($penandatangan->pangkat !== '' && $penandatangan->pangkat !== 'IX'){{ $penandatangan->pangkat }},{{ $penandatangan->golongan }}<br>@endif
        </p>
        <p>NIP. {{ $penandatangan->nip ?? '' }}</p>
    </div>
    @endif

    <div class="no-print">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-resmis.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>

</body>
</html>
