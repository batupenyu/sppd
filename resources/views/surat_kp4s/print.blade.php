<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>KP4 - Surat Keterangan Tunjangan Keluarga {{ $suratKp4->nomor_surat }}</title>
    <style>
      @page { size: A4; margin: 1.5cm; }
      body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #000;
        background-color: #525659;
        margin: 0;
      }
      .container { max-width: 800px; margin: 0 auto; }
      .page {
        width: 210mm;
        min-height: 297mm;
        padding: 15mm 18mm;
        margin: 20px auto;
        background: white;
        position: relative;
        box-shadow: 0 0 6px rgba(0,0,0,0.3);
      }
      .text-right { text-align: right; font-weight: bold; margin-bottom: 20px; }
      .header { text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 30px; }
      .header h2 { font-size: 16px; margin: 0 0 5px 0; text-decoration: underline; }
      .header h1 { font-size: 16px; margin: 0; }
      .data-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
      .data-table td { vertical-align: top; padding: 3px 0; }
      .data-table td.num { width: 4%; }
      .data-table td.label { width: 32%; }
      .data-table td.colon { width: 3%; text-align: center; }
      .data-table td.value { width: 61%; }
      .statement { text-align: justify; margin-bottom: 15px; }
      .family-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
      .family-table th, .family-table td { border: 1.5px solid #000; padding: 6px; font-size: 13px; }
      .family-table th { background-color: #e6e6e6; text-align: center; font-weight: bold; }
      .text-center { text-align: center; }
      .footer-table { width: 100%; margin-top: 30px; border-collapse: collapse; }
      .footer-table td { width: 50%; vertical-align: top; }
      .signature-space { height: 90px; }
      .signature-name { font-weight: bold; text-decoration: underline; }
      .no-print { margin-top: 20px; text-align: center; }
      @media print {
        body { background: white; }
        .page {
          box-shadow: none;
          margin: 0;
          page-break-after: always;
        }
        .no-print { display: none !important; }
      }
    </style>
  </head>
  <body>
    @php
      $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratKp4Controller::formatTanggal($d, '%d %B %Y') : '';
      $pegawai = $suratKp4->pegawai;
      $penandatangan = $suratKp4->penandatangan;
    @endphp

    <div class="container page">
      <div class="text-right">KP4</div>

      <div class="header">
        <h2>SURAT KETERANGAN</h2>
        <h1>UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA</h1>
      </div>

      <table class="data-table">
        <tr>
          <td class="num">1.</td>
          <td class="label">Nama Lengkap</td>
          <td class="colon">:</td>
          <td class="value"><strong>{{ $pegawai->nama ?? '' }}</strong></td>
        </tr>
        <tr>
          <td class="num">2.</td>
          <td class="label">NIP/NRK</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->nip ?? '' }}</td>
        </tr>
        <tr>
          <td class="num">3.</td>
          <td class="label">Tempat / Tanggal Lahir</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->tempat_lahir ?? '' }}{{ $pegawai && $pegawai->tanggal_lahir ? '/' . $fmt($pegawai->tanggal_lahir) : '' }}</td>
        </tr>
        <tr>
          <td class="num">4.</td>
          <td class="label">Jenis Kelamin</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->jk === 'L' ? 'Laki-laki' : ($pegawai->jk === 'P' ? 'Perempuan' : ($pegawai->jk ?? '')) }}</td>
        </tr>
        <tr>
          <td class="num">5.</td>
          <td class="label">Agama</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->agama ?? '' }}</td>
        </tr>
        <tr>
          <td class="num">6.</td>
          <td class="label">Status Kepegawaian</td>
          <td class="colon">:</td>
          <td class="value">{{ $suratKp4->status_kepegawaian ?? '' }}</td>
        </tr>
        <tr>
          <td class="num">7.</td>
          <td class="label">Jabatan Struktural/Fungsional</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->jabatan ?? ($pegawai->jabatan ?? '') }}</td>
        </tr>
        <tr>
          <td class="num">8.</td>
          <td class="label">Pangkat/Golongan</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai ? trim(($pegawai->pangkat ?? '') . (($pegawai->golongan ?? '') ? ' / ' . $pegawai->golongan : '')) : '' }}</td>
        </tr>
        <tr>
          <td class="num">9.</td>
          <td class="label">Pada Unit Kerja</td>
          <td class="colon">:</td>
          <td class="value">{{ $pegawai->unit_kerja ?? '' }}</td>
        </tr>
        <tr>
          <td class="num">10.</td>
          <td class="label">Masa Kerja Golongan</td>
          <td class="colon">:</td>
          <td class="value"></td>
          <!-- <td class="value">{{ $suratKp4->masa_kerja_golongan ?? '' }}</td> -->
        </tr>
        <tr>
          <td class="num">11.</td>
          <td class="label">Digaji menurut</td>
          <td class="colon">:</td>
          <td class="value">{{ $suratKp4->digaji_menurut ?? '' }}</td>
        </tr>
        <tr>
          <td class="num">12.</td>
          <td class="label">Alamat / Tempat Tinggal</td>
          <td class="colon">:</td>
          <td class="value">
            {{ $pegawai->alamat_jalan ?? '' }}
            {{ $pegawai->nama_dusun ? ' Dusun ' . $pegawai->nama_dusun : '' }}
            {{ $pegawai->desa_kelurahan ? ' ' . $pegawai->desa_kelurahan : '' }}
            {{ $pegawai->kecamatan ? ' ' . $pegawai->kecamatan : '' }}
          </td>
        </tr>
      </table>

      <div class="statement">
        Menerangkan dengan sesungguhnya bahwa saya mempunyai susunan keluarga sebagai berikut :
      </div>

      <table class="family-table">
        <thead>
          <tr>
            <th rowspan="2" style="width: 5%;">No.</th>
            <th rowspan="2" style="width: 25%;">Nama Istri / Suami<br>Tanggungan</th>
            <th colspan="2" style="width: 30%;">Tanggal</th>
            <th rowspan="2" style="width: 15%;">Pekerjaan</th>
            <th rowspan="2" style="width: 15%;">Keterangan</th>
            <th rowspan="2" style="width: 10%;">Mendapat<br>tunjangan</th>
          </tr>
          <tr>
            <th>Kelahiran</th>
            <th>Perkawinan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($suratKp4->anggotaKeluarga as $index => $anggota)
          <tr>
            <td class="text-center">{{ $index + 1 }}.</td>
            <td>{{ $anggota->nama }}</td>
            <td class="text-center">{{ $anggota->tanggal_kelahiran ? $anggota->tanggal_kelahiran->format('d-m-Y') : '' }}</td>
            <td class="text-center">{{ $anggota->tanggal_perkawinan ? $anggota->tanggal_perkawinan->format('d-m-Y') : '' }}</td>
            <td class="text-center">{{ $anggota->pekerjaan ?? '' }}</td>
            <td class="text-center">{{ $anggota->keterangan ?? '' }}</td>
            <td class="text-center">{!! $anggota->mendapat_tunjangan ? '&#10003;' : '' !!}</td>
          </tr>
          @empty
          <tr><td class="text-center" colspan="7">-</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="statement" style="font-size: 13px;">
        Keterangan ini saya buat dengan sesungguhnya dan apabila keterangan ini ternyata tidak benar (palsu), saya bersedia dituntut dimuka Pengadilan berdasarkan undang-undang yang berlaku, dan bersedia mengembalikan semua uang tunjangan anak yang telah saya terima yang seharusnya bukan menjadi hak saya.
      </div>

      <table class="footer-table">
        <tr>
          <td>
            Mengetahui,<br>
            {{ $penandatangan ? ($penandatangan->tugas_tambahan ?: ($penandatangan->jabatan ?: 'Kepala')) : 'Kepala' }}
            <div class="signature-space"></div>
            <div class="signature-name">{{ $penandatangan->nama ?? '' }}</div>
            @if($penandatangan)NIP. {{ $penandatangan->nip }}@endif
          </td>
          <td>
            {{ $suratKp4->tempat_ditetapkan }}, {{ $fmt($suratKp4->tanggal_ditetapkan) }}<br>
            Yang menerangkan,
            <div class="signature-space"></div>
            <div class="signature-name">{{ $pegawai->nama ?? '' }}</div>
            @if($pegawai)NIP. {{ $pegawai->nip }}@endif
          </td>
        </tr>
      </table>

      <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-kp4s.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
    </div>
  </body>
</html>
