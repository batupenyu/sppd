<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Aktif Mengajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }
        .page {
            /* max-width: 210mm;
            margin: 0 auto;
            padding: 2cm; */
            max-width: 210mm;
            margin: 1cm auto 0 auto; /* top margin 1cm */
            padding: 0 2cm 2cm 2cm; /* padding kiri/kanan/bawah */
        }
        .kop-surat {
            width: auto;
            margin: 0 -2cm 30px -2cm; /* negatif margin untuk keluar dari padding */
            padding: 0 2cm 10px 2cm;
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            /* border-bottom: 3px double #000; */
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            margin-bottom: 5px;
        }
        .nomor-surat {
            text-align: center;
            margin-bottom: 30px;
        }
        .paragraf {
            text-align: justify;
            margin-bottom: 15px;
            text-indent: 0;
        }
        .data-table {
            width: 100%;
            margin-left: 30px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .data-table td.label {
            width: 120px;
        }
        .data-table td.colon {
            width: 20px;
            text-align: center;
        }
        .ttd-container {
            margin-top: 40px;
            float: right;
            width: 320px;
            text-align: left;
        }
        .ttd-space {
            height: 100px;
        }
        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }
        .clear {
            clear: both;
        }

        @media print {
            body {
                padding: 0;
            }
            .page {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="kop-surat">
            @if($kopSuratBase64)
            <img src="{{ $kopSuratBase64 }}" style="max-height: 120px; margin-bottom: 0px; width:95%" />
            @endif
        </div>

        <div class="judul-surat">SURAT KETERANGAN AKTIF MENGAJAR</div>
        <div class="nomor-surat">Nomor: {{ $suratAktifMengajar->nomor_surat ?: '…………………………………' }}</div>

        <div class="paragraf">Yang bertanda tangan dibawah ini:</div>

        <table class="data-table">
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->penandatangan->nama ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->penandatangan->nip ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->penandatangan->tugas_tambahan ?: ($suratAktifMengajar->penandatangan->jabatan ?: '') }}</td>
            </tr>
            {{-- <tr>
                <td class="label">Unit kerja</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->penandatangan->unit_kerja ?: 'SMK Negeri 1 Koba' }}</td>
            </tr> --}}
        </table>

        <div class="paragraf">menyatakan dengan sebenarnya bahwa:</div>

        <table class="data-table">
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->pegawai->nama ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->pegawai->nik ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td>Guru {{ $suratAktifMengajar->pegawai->jabatan ?: ($suratAktifMengajar->pegawai->tugas_tambahan ?: ($suratAktifMengajar->pegawai->jenis_ptk ?: '')) }}</td>
            </tr>
            <tr>
                <td class="label">Unit Kerja</td>
                <td class="colon">:</td>
                <td>{{ $suratAktifMengajar->pegawai->unit_kerja ?: '' }}</td>
            </tr>
            <tr>
                <td class="label">Instansi</td>
                <td class="colon">:</td>
                <td>Pemerintah Provinsi Kepulauan Bangka Belitung</td>
            </tr>
        </table>

        <div class="paragraf">
            Yang bersangkutan benar-benar terdaftar dan aktif mengajar sebagai Guru {{ $suratAktifMengajar->pegawai->tugas_tambahan ?: '' }} pada unit kerja dimaksud.
        </div>

        <div class="paragraf">
            Demikian surat keterangan aktif mengajar ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.
        </div>

        <div class="ttd-container">
            <div>{{ $suratAktifMengajar->tempat_ditetapkan ?: '....................' }}, {{ \App\Http\Controllers\SuratAktifMengajarController::formatTanggal($suratAktifMengajar->tanggal_ditetapkan) }}</div>
            <div style="font-weight: bold; margin-bottom: 15px;">{{ $suratAktifMengajar->penandatangan->tugas_tambahan ?: ($suratAktifMengajar->penandatangan->jabatan ?: '') }}</div>

            <div class="ttd-space"></div>

            <div class="nama-pejabat">{{ $suratAktifMengajar->penandatangan->nama ?? '' }}</div>
            <div>{{ $suratAktifMengajar->penandatangan->pangkat ?? '' }} {{ $suratAktifMengajar->penandatangan->golongan ?? '' }}</div>
            <div>Nip. {{ $suratAktifMengajar->penandatangan->nip ?? '' }}</div>
        </div>

        <div class="clear"></div>

        <div style="margin-top: 50px; text-align: center;">
            <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
            <a href="{{ route('surat-aktif-mengajars.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
        </div>
    </div>

</body>
</html>
