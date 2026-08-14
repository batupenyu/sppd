<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Persetujuan Mahasiswa Magang</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 20mm 20mm 25mm;
            box-sizing: border-box;
            margin: 0 auto;
        }
        .tanggal-atas {
            text-align: right;
            margin-bottom: 20px;
        }
        .meta-surat {
            width: 100%;
            margin-bottom: 25px;
        }
        .meta-surat td {
            vertical-align: top;
            padding-bottom: 5px;
        }
        .tujuan-surat {
            margin-bottom: 30px;
        }
        .isi-surat {
            text-align: justify;
            margin-bottom: 20px;
        }
        .identitas-smk {
            margin: 15px 0 15px 30px;
        }
        .identitas-smk td {
            padding: 3px 5px;
        }
        .tabel-mahasiswa {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .tabel-mahasiswa th, .tabel-mahasiswa td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .tabel-mahasiswa th {
            background-color: #f2f2f2;
        }
        .tanda-tangan {
            margin-top: 50px;
            float: right;
            text-align: left;
            width: 300px;
        }
        .ruang-ttd {
            height: 80px;
        }

        @media print {
            body {
                background-color: #fff;
            }
            .container {
                width: auto;
                height: auto;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $fmt = fn ($d) => $d ? \App\Http\Controllers\PersetujuanMagangController::formatTanggal($d, '%d %B %Y') : '...................';
            $penandatangan = $persetujuanMagang->penandatangan;
        @endphp

        <div class="tanggal-atas">
            {{ $persetujuanMagang->tempat_ditetapkan ?: '[Kota SMK]' }}, {{ $fmt($persetujuanMagang->tanggal_ditetapkan) }}
        </div>

        <table class="meta-surat">
            <tr>
                <td style="width: 15%;">Nomor</td>
                <td style="width: 2%;">:</td>
                <td>{{ $persetujuanMagang->nomor_surat ?: '.../SMK.../PKL/.../2026' }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>{{ $persetujuanMagang->sifat ?: 'Penting / Biasa' }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{{ $persetujuanMagang->lampiran ?: '- / 1 Berkas' }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong>{{ $persetujuanMagang->perihal ?: 'Persetujuan / Penerimaan Mahasiswa Magang' }}</strong></td>
            </tr>
        </table>

        <div class="tujuan-surat">
            Kepada Yth.<br>
            <strong>{{ $persetujuanMagang->tujuan_surat ?: 'Pimpinan / Ketua Program Studi ...' }}</strong><br>
            Universitas / Perguruan Tinggi ...<br>
            di Tempat
        </div>

        <div class="isi-surat">
            Dengan hormat,<br><br>
            Menindaklanjuti surat permohonan izin magang dari Saudara nomor <strong>{{ $persetujuanMagang->nomor_surat_kampus ?: '[Nomor Surat dari Kampus]' }}</strong> tanggal <strong>{{ $fmt($persetujuanMagang->tanggal_surat_kampus) }}</strong>, maka dengan ini unit/lembaga kami:
        </div>

        <table class="identitas-smk">
            <tr>
                <td style="width: 150px;">Nama Instansi/Unit</td>
                <td>:</td>
                <td><strong>{{ $persetujuanMagang->nama_instansi ?: 'SMK Negeri / Swasta ...' }}</strong></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $persetujuanMagang->alamat_instansi ?: '[Alamat Lengkap SMK]' }}</td>
            </tr>
        </table>

        <div class="isi-surat">
            Menyatakan <strong>BERSEDIA MENERIMA / MEMBERIKAN PERSETUJUAN</strong> kepada mahasiswa berikut untuk melaksanakan kegiatan magang/praktik kerja di lingkungan unit kerja kami:
        </div>

        <table class="tabel-mahasiswa">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">Nama Mahasiswa</th>
                    <th style="width: 25%;">NIM</th>
                    <th style="width: 35%;">Program Studi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $mahasiswas = $persetujuanMagang->mahasiswas ?? [];
                @endphp
                @if(count($mahasiswas) > 0)
                    @foreach($mahasiswas as $index => $mahasiswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mahasiswa['nama'] ?? '' }}</td>
                        <td>{{ $mahasiswa['nim'] ?? '' }}</td>
                        <td>{{ $mahasiswa['program_studi'] ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>1</td>
                        <td>[Nama Mahasiswa 1]</td>
                        <td>[...]</td>
                        <td>[...]</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="isi-surat">
            Adapun pelaksanaan magang akan dimulai pada tanggal <strong>{{ $fmt($persetujuanMagang->tanggal_mulai) }}</strong> sampai dengan <strong>{{ $fmt($persetujuanMagang->tanggal_selesai) }}</strong>. Selama kegiatan berlangsung, para mahasiswa yang bersangkutan wajib mematuhi seluruh tata tertib dan peraturan kerja yang berlaku di lingkungan SMK kami.
        </div>

        <div class="isi-surat">
            Demikian surat persetujuan ini kami buat agar dapat dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </div>

        <div class="tanda-tangan">
            Kepala / Ketua Unit Hubungan Industri,<br>
            <div class="ruang-ttd"></div>
            <strong><u>{{ $penandatangan->nama ?? '[Nama Penandatangan, Gelar]' }}</u></strong><br>
            NIP. {{ $penandatangan->nip ?? '[Nomor Induk Pegawai]' }}
        </div>

        <div style="clear: both;"></div>

        <div style="margin-top: 50px; text-align: center;">
            <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
            <a href="{{ route('persetujuan-magangs.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
        </div>
    </div>
</body>
</html>
