<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nota Dinas{{ $laporanNodin->tanggal ? ' ' . \App\Http\Controllers\LaporanNodinController::formatTanggal($laporanNodin->tanggal, '%d_%m_%Y') : '' }}</title>
    <style>
        body {
                    background-color: #525659;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 50px 60px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .kop-surat-image {
            width: 100%;
            max-height: 160px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .header .kop {
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .header .title {
            font-size: 20px;
            text-decoration: underline;
            letter-spacing: 2px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 0px 0;
            vertical-align: top;
        }
        .meta-table td.label {
            width: 120px;
        }
        .meta-table td.colon {
            width: 20px;
            text-align: center;
        }
        .line {
            border-top: 2px solid #000000;
            margin-bottom: 30px;
        }
        .content {
            text-align: justify;
            margin-bottom: 30px;
        }
        .section-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .section-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .section-table td.num {
            width: 20px;
        }
        .section-table td.sub-label {
            width: 120px;
        }
        .section-table td.colon {
            width: 20px;
            text-align: center;
        }
        .nested-list {
            margin: 0;
            padding-left: 20px;
        }
        .nested-list li {
            margin-bottom: 10px;
        }
        .footer-section {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .footer-section td {
            width: 50%;
            vertical-align: top;
        }
        .signature-space {
            height: 80px;
        }
        .name-title {
            font-weight: bold;
            text-decoration: underline;
        }

         .peserta-container {
            width: 100%;
        }
        
        .peserta-item {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .peserta-item table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .peserta-item table td {
            padding: 2px 0;
            vertical-align: top;
        }
        
        .peserta-label-cell {
            width: 82px;
            white-space: nowrap;
        }
        
        .peserta-colon-cell {
            width: 20px;
            text-align: center;
        }
        
        .peserta-number {
            display: inline-block;
            width: 30px;
        }
        
        .peserta-label {
            display: inline-block;
        }
        
        .peserta-label-with-number {
            width: 80px;
        }
        
        .peserta-label-no-number {
            width: 80px;
        }
        
        .peserta-value {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        @if($kopSuratBase64)
        <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image" />
        @endif
        <div class="title">NOTA DINAS</div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Kepada</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->kepada ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Dari</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->dari ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->nomor ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->lampiran ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td><strong>{{ $laporanNodin->tanggal ? \App\Http\Controllers\LaporanNodinController::formatTanggal($laporanNodin->tanggal, '%d %B %Y') : '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td><strong>{{ $laporanNodin->perihal ?: '-' }}</strong></td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="content">
        <p>Dengan Hormat, Bersama ini kami sampaikan perihal laporan hasil Perjalanan Dinas mengikuti kegiatan sebagaimana berikut :</p>
    </div>

    <table class="section-table">
        <tr>
            <td class="num">I.</td>
            <td class="sub-label">Dasar Pelaksanaan</td>
            <td class="colon">:</td>
            <td style="text-align: justify;">{{ $laporanNodin->dasar_pelaksanaan ?: '-' }}</td>
        </tr>
        <tr>
            <td class="num">II.</td>
            <td class="sub-label">Tujuan</td>
            <td class="colon">:</td>
            <td style="text-align: justify;">{{ $laporanNodin->tujuan ?: '-' }}</td>
        </tr>
        @php($pesertaList = $laporanNodin->getPeserta())
        <tr>
            <td class="num">III.</td>
            <td class="sub-label">Peserta</td>
            <td class="colon">:</td>
            <td>
                @php($showPesertaIndex = count($pesertaList) > 1)
                
                @forelse($pesertaList as $index => $peserta)
                <div class="peserta-item">
                    <table>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number">{{ $index + 1 }}.</span>
                                    <span class="peserta-label peserta-label-with-number">Nama</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">Nama</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value">{{ $peserta->nama ?: '' }}</td>
                        </tr>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number"></span>
                                    <span class="peserta-label peserta-label-with-number">NIP</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">NIP</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value">{{ $peserta->nip ?: '' }}</td>
                        </tr>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number"></span>
                                    <span class="peserta-label peserta-label-with-number">Jabatan</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">Jabatan</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value">{{ $peserta->tugas_tambahan ?: ($peserta->jenis_ptk ?: ($peserta->jabatan ?: '')) }}</td>
                        </tr>
                    </table>
                </div>
                @empty
                <div class="peserta-item">
                    <table>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number">1.</span>
                                    <span class="peserta-label peserta-label-with-number">Nama</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">Nama</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value"></td>
                        </tr>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number"></span>
                                    <span class="peserta-label peserta-label-with-number">NIP</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">NIP</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value"></td>
                        </tr>
                        <tr>
                            <td class="peserta-label-cell">
                                @if($showPesertaIndex)
                                    <span class="peserta-number"></span>
                                    <span class="peserta-label peserta-label-with-number">Jabatan</span>
                                @else
                                    <span class="peserta-label peserta-label-no-number">Jabatan</span>
                                @endif
                            </td>
                            <td class="peserta-colon-cell">:</td>
                            <td class="peserta-value"></td>
                        </tr>
                    </table>
                </div>
                @endforelse
            </td>
        </tr>
        <!-- Pelaksanaan -->
        <tr>
            <td class="num">IV.</td>
            <td class="sub-label">Pelaksanaan</td>
            <td class="colon">:</td>
            <td>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:80px; padding:2px ;">Tanggal</td>
                        <td style="width:20px; text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->pelaksanaan_tanggal ? \App\Http\Controllers\LaporanNodinController::formatTanggal($laporanNodin->pelaksanaan_tanggal, '%A, %d %B %Y') : '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:0px ;">Jam</td>
                        <td style="text-align:center;padding:0;">:</td>
                        <td style="padding:0;"><strong>{{ $laporanNodin->pelaksanaan_jam ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:0px ;">Tempat</td>
                        <td style="text-align:center;padding:0;">:</td>
                        <td style ="padding:0;"><strong>{{ $laporanNodin->pelaksanaan_tempat ?: '' }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Kesimpulan -->
        <tr>
            <td class="num">V.</td>
            <td class="sub-label" >Kesimpulan</td>
            <td class="colon">:</td>
            <td style="text-align: justify;">
                @php($kesimpulanItems = array_values(array_filter(array_map('trim', explode("\n", $laporanNodin->kesimpulan ?: '')), fn ($i) => $i !== '')))
                @if(count($kesimpulanItems) > 1)
                <ol class="nested-list">
                    @foreach($kesimpulanItems as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ol>
                @elseif(count($kesimpulanItems) === 1)
                <p style="margin:0;">{{ $kesimpulanItems[0] }}</p>
                @else
                <p style="margin:0;">-</p>
                @endif
            </td>
        </tr>
    </table>

    <div class="content" style="margin-top:30px;">
        <p>Demikian disampaikan, atas perkenan bapak diucapkan terima kasih.</p>
    </div>

    <table class="footer-section">
        <tr>
            <td>
                <strong>Mengetahui</strong><br>
                <strong>Kepala Sekolah</strong>
                <div class="signature-space"></div>
                <strong>{{ $laporanNodin->penandatangan->nama ?? '' }}<br>
                NIP.{{ $laporanNodin->penandatangan->nip ?? '' }}</strong>
            </td>
            <td>
                Yang Melaksanakan Tugas,<br>
                <br>
                @forelse($pesertaList as $index => $peserta)
                    @if(count($pesertaList) <= 1)
                        ......................................<br>
                    @else
                        {{ $index + 1 }}. ......................................<br>
                    @endif
                    <strong>{{ $peserta->nama ?: '' }}</strong><br>
                    <br>
                @empty
                    @if(count($pesertaList) <= 1)
                        ......................................<br>
                        <br>
                    @else
                        1. ......................................<br>
                        <br>
                        2. ......................................<br>
                        <br>
                    @endif
                @endforelse
            </td>
        </tr>
    </table>
</div>

<div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('laporan-nodins.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
