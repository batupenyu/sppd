<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan Bersedia</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 2cm 1cm 2cm;
        }
        body {
            font-family: "arial", sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            width: 210mm; /* Ukuran A4 */
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .kop-surat {
            text-align: center;
            /* border-bottom: 3px double #000; */
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-surat img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
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
        .identitas-table {
            width: 100%;
            margin-left: 0;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .identitas-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .identitas-table td.label {
            width: 100px;
        }
        .identitas-table td.titik-dua {
            width: 20px;
        }
        .isi-surat {
            text-align: justify;
            text-indent: 40px;
            margin-bottom: 20px;
        }
        .pilihan-status {
            font-weight: bold;
        }
        .tanda-tangan {
            float: right;
            text-align: left;
            width: 250px;
            margin-top: 50px;
            text-align: center;
        }
        .tanda-tangan p {
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .tanda-tangan .nama-pejabat {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clear {
            clear: both;
        }

        /* Pengaturan Cetak */
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Kop Surat -->
        <div class="kop-surat">
            @if($kopSuratBase64)
                <img src="{{ $kopSuratBase64 }}" alt="Kop Surat">
            @else
                <h1 style="margin:0;">Kop Surat</h1>
                <h2 style="margin:5px 0 0 0;">Nama Sekolah / Instansi</h2>
            @endif
        </div>

        <!-- Judul Surat -->
        <div class="judul-surat">SURAT PERNYATAAN</div>
        <div class="nomor-surat">Nomor : {{ $suratBersedia->nomor_surat ?: '___________________________' }}</div>

        <!-- Pembuka -->
        <p class="isi-surat"> Yang bertandatangan di bawah ini:</p>

        <!-- Tabel Identitas -->
        <table class="identitas-table">
            <tr>
                <td class="label">Nama</td>
                <td class="titik-dua">:</td>
                <td>{{ $suratBersedia->penandatangan->nama ?? '__________________________________________________' }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="titik-dua">:</td>
                <td>{{ $suratBersedia->penandatangan->nip ?? '__________________________________________________' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="titik-dua">:</td>
                <td>{{ $suratBersedia->penandatangan->tugas_tambahan ?: ($suratBersedia->penandatangan->jabatan ?? '__________________________________________________') }} {{ $suratBersedia->penandatangan->unit_kerja ?? '' }}</td>
            </tr>
            {{-- <tr>
                <td class="label">Alamat</td>
                <td class="titik-dua">:</td>
                <td>{{ $suratBersedia->penandatangan->alamat_jalan ?? '__________________________________________________' }}</td>
            </tr>
            <tr>
                <td class="label">HP/WA</td>
                <td class="titik-dua">:</td>
                <td>{{ $suratBersedia->penandatangan->hp ?? ($suratBersedia->penandatangan->telepon ?? '__________________________________________________') }}</td>
            </tr> --}}
        </table>

        <!-- Isi Surat -->
        <p class="isi-surat">
            @if($suratBersedia->isi_surat)
                {!! nl2br(e($suratBersedia->isi_surat)) !!}
            @else
                Dengan ini menyatakan
                <span class="pilihan-status">
                    @if($suratBersedia->status === 'bersedia')
                        bersedia menerima
                    @else
                        tidak bersedia menerima
                    @endif
                </span>
                Mahasiswa untuk PPLK II di sekolah yang saya pimpin.
            @endif
        </p>

        <p class="isi-surat">
            @if($suratBersedia->penutup_surat)
                {!! nl2br(e($suratBersedia->penutup_surat)) !!}
            @else
                Demikian pernyataan ini saya buat untuk digunakan sebagaimana mestinya.
            @endif
        </p>

        <!-- Penutup & Tanda Tangan -->
        <div class="tanda-tangan" >
            <p>
                {{ $suratBersedia->tempat_ditetapkan ?: '______________________' }}, {{ \App\Http\Controllers\SuratBersediaController::formatTanggal($suratBersedia->tanggal_ditetapkan, '%d %B %Y') }}<br>
                {{ $suratBersedia->penandatangan->tugas_tambahan ?: ($suratBersedia->penandatangan->jabatan ?? '') }} 
                {{ $suratBersedia->penandatangan->unit_kerja ?? '' }}<br>
                <br>
                <br>
                <br>
                <span class="nama-pejabat">{{ $suratBersedia->penandatangan->nama ?? 'Nama' }}</span><br>
                {{ $suratBersedia->penandatangan->pangkat ?? '' }}<br>
                NIP. {{ $suratBersedia->penandatangan->nip ?? '' }}
            </p>
        </div>

        <div class="clear"></div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-bersedias.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>

</body>
</html>
