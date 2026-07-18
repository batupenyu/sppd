<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Melaksanakan Tugas</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; }
        .center { text-align: center; }
        .left { text-align: left; }
        .justify { text-align: justify; }
        .signature { padding-left: 250pt; }
        table { border-collapse: collapse; width: 100%; }
        td { vertical-align: top; }
        .label { width: 150px; }
        .colon { width: 10px; }
        .kop-surat-container {
            text-align: center;
            margin-bottom: 10px;
            margin-left: -2cm;
            margin-right: -2cm;
        }
        .kop-surat-image {
            width: 80%;
            max-width: 21cm;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }
        @page {
            size: A4;
            margin: 1cm 2cm 0.5cm 2cm;
        }
    </style>
</head>
<body>
@php
    $fmt = [\App\Http\Controllers\DrhSatyalancanaController::class, 'formatTanggal'];
@endphp
    <div class="kop-surat-container">
        @if ($kopSuratBase64)
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
        @endif
    </div>
    <div class="center">
        <p><b><u>SURAT PERINTAH MELAKSANAKAN TUGAS</u></b><br>
           Nomor : {{ $spmt->nomor_surat ?: '' }}</p>
    </div>
    <br>
    <p class="justify">Yang bertanda tangan di bawah ini:</p>
    <table>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $spmt->penandatangan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="colon">:</td>
            <td>{{ $spmt->penandatangan->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Pangkat/Golongan</td>
            <td class="colon">:</td>
            <td>{{ $spmt->penandatangan->pangkat_golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $spmt->penandatangan->tugas_tambahan ?? ($spmt->penandatangan->jenis_ptk ?? ($spmt->penandatangan->pangkat_golongan ?? '-')) }}</td>
        </tr>
    </table>
    <p class="left">dengan ini menyatakan dengan sesungguhnya bahwa:</p>
    <table>
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $spmt->pegawai->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="colon">:</td>
            <td>{{ $spmt->pegawai->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Pangkat/Golongan</td>
            <td class="colon">:</td>
            <td>{{ $spmt->pegawai->pangkat_golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $spmt->pegawai->tugas_tambahan ?? ($spmt->pegawai->jenis_ptk ?? ($spmt->pegawai->pangkat_golongan ?? '-')) }}</td>
        </tr>
    </table>
    <p class="justify">
        Yang diangkat berdasarkan {{ $spmt->peraturan ?: '...........................' }} Nomor {{ $spmt->nomor_peraturan ?: '...........................' }} Tahun {{ $spmt->tahun_peraturan ?: '.................' }} tentang {{ $spmt->tentang ?: '...........................' }}, terhitung mulai tanggal {{ $spmt->tanggal_terhitung ? $fmt($spmt->tanggal_terhitung, '%d %B %Y') : '....................' }} telah nyata menjalankan tugas sebagai {{ $spmt->sebagai ?: '...........................' }} di {{ $spmt->tempat_tugas ?: '...........................' }}.
    </p>
    <p class="justify">
        Demikian surat pernyataan melaksanakan tugas ini saya buat dengan sesungguhnya dengan mengingat sumpah jabatan/pegawai negeri sipil dan apabila dikemudian hari isi surat pernyataan ini ternyata tidak benar yang berakibat kerugian bagi negara maka saya bersedia menanggung kerugian tersebut.
    </p>
    <br>
    <div class="signature">
        <p>{{ $spmt->tempat_ditetapkan ?: '.................' }}, {{ $spmt->tanggal_surat ? $fmt($spmt->tanggal_surat, '%d %B %Y') : '....................' }} <br>{{ $spmt->penandatangan->tugas_tambahan ?? ($spmt->penandatangan->jenis_ptk ?? ($spmt->penandatangan->pangkat_golongan ?? 'Jabatan')) }}</p>
        <br><br><br>
        <p><strong>{{ $spmt->penandatangan->nama ?? 'Nama' }}</strong><br>
            {{ $spmt->penandatangan->pangkat_golongan ?? 'Pangkat/Golongan' }}<br>
            NIP. {{ $spmt->penandatangan->nip ?? 'NIP' }}</p>
    </div>

    <div class="no-print" style="margin-top:20px; text-align:center;">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('spmts.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
</body>
</html>
