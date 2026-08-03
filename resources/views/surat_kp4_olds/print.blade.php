<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Tunjangan Keluarga</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
            border: none;
        }
        .logo-cell {
            width: 12%;
            text-align: center;
        }
        .logo-img {
            max-width: 70px;
            height: auto;
        }
        .text-cell {
            text-align: center;
        }
        .text-cell h1 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .text-cell h2 {
            font-size: 13px;
            margin: 2px 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .text-cell h3 {
            font-size: 12px;
            margin: 2px 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .text-cell p {
            margin: 2px 0;
            font-size: 10px;
            font-style: italic;
        }
        .title-area {
            text-align: center;
            margin-bottom: 20px;
        }
        .title-area h2 {
            font-size: 14px;
            text-transform: uppercase;
            margin: 0;
            text-decoration: underline;
            font-weight: bold;
        }
        .title-area h3 {
            font-size: 13px;
            text-transform: uppercase;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .form-table td {
            padding: 4px 2px;
            vertical-align: top;
            border: none;
        }
        .num-col { width: 4%; }
        .label-col { width: 30%; }
        .colon-col { width: 2%; text-align: center; }
        .value-col { width: 64%; }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-left { text-align: left !important; }

        .note-section {
            margin-top: 15px;
            font-size: 11px;
            text-align: justify;
        }
        .note-section ol, .note-section ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        .footer-area {
            width: 100%;
            margin-top: 30px;
            font-size: 11px;
        }
        .footer-area td {
            border: none;
            width: 50%;
            vertical-align: top;
        }
        .signature-space {
            height: 70px;
        }
        .page-break {
            page-break-before: always;
            margin-top: 40px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    @php
        $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratKp4OldController::formatTanggal($d, '%d %B %Y') : '';
        $pegawai = $suratKp4Old->pegawai;
        $penandatangan = $suratKp4Old->penandatangan;
        $pangkat = $pegawai->pangkat ?? '';
        $golongan = $pegawai->golongan ?? '';
    @endphp

<div class="container">
    <!-- HALAMAN 1 -->
    <!-- Kop Surat -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if($kopSuratBase64)
                    <img class="logo-img" src="{{ $kopSuratBase64 }}" alt="Logo">
                @else
                    <img class="logo-img" src="https://wikimedia.org" alt="Logo Bangka Belitung">
                @endif
            </td>
            <td class="text-cell">
                <h1>Pemerintah Provinsi Kepulauan Bangka Belitung</h1>
                <h2>Dinas Pendidikan</h2>
                <h3>Bidang Kepala Dinas Pendidikan</h3>
                <h2>{{ $pegawai->unit_kerja ?? 'Sekolah Luar Biasa' }}</h2>
                <p>{{ $pegawai->alamat_jalan ?? '' }}{{ $pegawai->nama_dusun ? ' Dusun ' . $pegawai->nama_dusun : '' }}{{ $pegawai->desa_kelurahan ? ' ' . $pegawai->desa_kelurahan : '' }}{{ $pegawai->kecamatan ? ' Kec. ' . $pegawai->kecamatan : '' }}</p>
                <p>Email: dinpendidikan@bangkabelitungprov.go.id</p>
            </td>
        </tr>
    </table>

    <!-- Judul Dokumen -->
    <div class="title-area">
        <h2>Surat Keterangan</h2>
        <h3>Untuk Mendapatkan Pembayaran Tunjangan Keluarga</h3>
    </div>

    <p>Menerangkan dengan sesungguhnya bahwa saya :</p>

    <!-- Data Pegawai -->
    <table class="form-table">
        <tr>
            <td class="num-col">1</td>
            <td class="label-col">Nama Lengkap</td>
            <td class="colon-col">:</td>
            <td class="value-col"><strong>{{ $pegawai->nama ?? '' }}</strong></td>
        </tr>
        <tr>
            <td>2</td>
            <td>NIP/NRK</td>
            <td>:</td>
            <td>{{ $pegawai->nip ?? '' }}{{ $pegawai->nuptk ? ' / ' . $pegawai->nuptk : '' }}</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Tempat / Tanggal Lahir</td>
            <td>:</td>
            <td>{{ ($pegawai->tempat_lahir ?? '') }}{{ ($pegawai && $pegawai->tanggal_lahir) ? ', ' . $fmt($pegawai->tanggal_lahir) : '' }}</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $pegawai->jk === 'L' ? 'Laki-laki' : ($pegawai->jk === 'P' ? 'Perempuan' : ($pegawai->jk ?? '-')) }}</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $pegawai->agama ?? '' }}</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Golongan / Status Kepegawaian</td>
            <td>:</td>
            <td>{{ $suratKp4Old->status_kepegawaian ?? '' }}</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Jabatan Struktural/Fungsional</td>
            <td>:</td>
            <td>{{ $pegawai->jabatan ?? '' }}{{ $pegawai->tugas_tambahan ? ' / ' . $pegawai->tugas_tambahan : '' }}</td>
        </tr>
        <tr>
            <td>8</td>
            <td>Pangkat/Golongan</td>
            <td>:</td>
            <td>{{ $pegawai ? trim(($pangkat ?? '') . ($golongan ? ' / ' . $golongan : '')) : '' }}</td>
        </tr>
        <tr>
            <td>9</td>
            <td>Pada Instansi, Dept. Lembaga</td>
            <td>:</td>
            <td>{{ $pegawai->unit_kerja ?? '' }}</td>
        </tr>
        <tr>
            <td>10</td>
            <td>Masa Kerja Golongan</td>
            <td>:</td>
            <td>{{ $suratKp4Old->masa_kerja_golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td>11</td>
            <td>Digaji menurut</td>
            <td>:</td>
            <td>{{ $suratKp4Old->digaji_menurut ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Alamat / Tempat Tinggal</td>
            <td>:</td>
            <td>{{ $pegawai->alamat_jalan ?? '' }}{{ $pegawai->nama_dusun ? ' Dusun ' . $pegawai->nama_dusun : '' }}{{ $pegawai->desa_kelurahan ? ' ' . $pegawai->desa_kelurahan : '' }}{{ $pegawai->kecamatan ? ' Kec. ' . $pegawai->kecamatan : '' }}</td>
        </tr>
    </table>

    <!-- Keterangan Tambahan -->
    <table class="form-table">
        <tr>
            <td class="num-col">a.</td>
            <td style="width: 50%;">Disamping Jabatan Utama tersebut, bekerja pula sebagai</td>
            <td class="colon-col">:</td>
            <td>{{ $suratKp4Old->disamping_jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>dengan mendapat penghasilan sebesar</td>
            <td>:</td>
            <td>Rp {{ $suratKp4Old->penghasilan_disamping ?? '-' }} sebulan</td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Mempunyai Pensiun / Pensiun Janda</td>
            <td>:</td>
            <td>Rp {{ $suratKp4Old->pensiun_janda ?? '-' }} sebulan</td>
        </tr>
        <tr>
            <td>c.</td>
            <td>Kawin sah dengan</td>
            <td>:</td>
            <td>{{ $suratKp4Old->kawin_sah ?? '-' }}</td>
        </tr>
    </table>

    <!-- Tabel Tanggungan Pasangan -->
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 5%;">No.</th>
                <th rowspan="2" style="width: 30%;">Nama Istri / Suami Tanggungan</th>
                <th colspan="2">Tanggal</th>
                <th rowspan="2" style="width: 20%;">Pekerjaan</th>
                <th rowspan="2" style="width: 15%;">Penghasilan Sebulan</th>
                <th rowspan="2" style="width: 15%;">Keterangan</th>
            </tr>
            <tr>
                <th style="width: 12%;">Kelahiran</th>
                <th style="width: 12%;">Perkawinan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratKp4Old->anggotaKeluarga as $index => $anggota)
            <tr>
                <td class="text-center">{{ $index + 1 }}.</td>
                <td class="text-left">{{ $anggota->nama }}</td>
                <td class="text-center">{{ $anggota->tanggal_kelahiran ? $anggota->tanggal_kelahiran->format('d-m-Y') : '-' }}</td>
                <td class="text-center">{{ $anggota->tanggal_perkawinan ? $anggota->tanggal_perkawinan->format('d-m-Y') : '-' }}</td>
                <td class="text-center">{{ $anggota->pekerjaan ?? '-' }}</td>
                <td class="text-center">{{ $anggota->penghasilan_sebulan ? 'Rp ' . $anggota->penghasilan_sebulan : '-' }}</td>
                <td class="text-center">{{ $anggota->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td class="text-center" colspan="7">-</td></tr>
            @endforelse
            @for ($i = 0; $i < 2; $i++)
            <tr>
                <td class="text-center">/</td>
                <td class="text-left">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <!-- Keterangan Anak -->
    <div class="note-section">
        <p>d. Mempunyai anak – anak seperti dalam daftar sebelah ini, yaitu :</p>
        <ul style="list-style-type: none; padding-left: 15px;">
            <li>I. Anak Kandung (Ak) Anak Tiri (At) yang masih menjadi tanggungan, belum mempunyai pekerjaan sendiri dan masuk dalam daftar Gaji.</li>
            <li>II. Anak Angkatan keluarga / Anak Di Tinggalkan.</li>
            <li>III. Anak Yang Duda / Yatim Piatu.</li>
            <li>IV. Nama anak di atas mempunyai kartu keluarga dan masuk dalam sistem gaji atau tidak.</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer-area">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    {{ $penandatangan ? ($penandatangan->tugas_tambahan ?: ($penandatangan->jabatan ?: 'Kepala')) : 'Kepala' }}
                    <div class="signature-space"></div>
                    <div style="font-weight: bold; text-decoration: underline;">{{ $penandatangan->nama ?? '' }}</div>
                    @if($penandatangan)NIP. {{ $penandatangan->nip }}@endif
                </td>
                <td>
                    {{ $suratKp4Old->tempat_ditetapkan ?? '' }}, {{ $fmt($suratKp4Old->tanggal_ditetapkan ?? null) }}<br>
                    Yang menerangkan,
                    <div class="signature-space"></div>
                    <div style="font-weight: bold; text-decoration: underline;">{{ $pegawai->nama ?? '' }}</div>
                    @if($pegawai)NIP. {{ $pegawai->nip }}@endif
                </td>
            </tr>
        </table>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-kp4-olds.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
</div>

</body>
</html>
