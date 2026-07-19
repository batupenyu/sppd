<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Keterangan {{ $suratKeterangan->nomor_surat }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 1.5cm 0.5cm 1.5cm;
      }
      body {
                  background-color: #525659;
        font-family: "Helvetica", sans-serif;
        font-size: 11pt;
        line-height: 1.5;
        color: #000;
      }
      td.label {
        width: 150px;
        white-space: nowrap;
      }
      td.value {
        white-space: nowrap;
      }
      td.colon {
        width: 15px;
      }
      .page {
        width: 210mm;
        min-height: 297mm;
        padding: 15mm 18mm;
        margin: 20px auto;
        background: white;
        position: relative;
        box-shadow: 0 0 6px rgba(0,0,0,0.3);
      }
      .no-print {
        margin-top: 20px;
        text-align: center;
      }
      @media print {
        body { background: white; }
        .page {
          box-shadow: none;
          margin: 0;
          page-break-after: always;
        }
        .no-print {
          display: none !important;
        }
      }
    </style>
  </head>
  <body>
    <div class="page">
    @php
      $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratKeteranganController::formatTanggal($d, '%d %B %Y') : '...................';
      $pegawai = $suratKeterangan->pegawai;
      $siswa = $suratKeterangan->siswa;
      $penandatangan = $suratKeterangan->penandatangan;
    @endphp

    @if($kopSuratBase64)
    <img
      src="{{ $kopSuratBase64 }}"
      style="max-width: 100%; height: auto; display: block; margin-bottom: 20px"
    />
    @endif

    <div class="header" style="text-align: center">
      <p>
        <strong>SURAT KETERANGAN</strong><br />
        <strong>Nomor : {{ $suratKeterangan->nomor_surat }}</strong>
      </p>
    </div>
    <br />
    <div class="content">
      <p>Yang bertanda tangan di bawah ini:</p>
      <table>
        <tr>
          <td class="label">Nama</td>
          <td class="colon">:</td>
          <td>{{ $penandatangan->nama ?? '' }}</td>
        </tr>
        <tr>
          <td class="label">Jabatan</td>
          <td class="colon">:</td>
          <td>{{ $penandatangan ? ($penandatangan->tugas_tambahan ?: ($penandatangan->jenis_ptk ?: '')) : '' }}</td>
        </tr>
      </table>
      <br />
      <p>dengan ini menerangkan bahwa:</p>
      @if($pegawai)
      <table>
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
        <tr>
          <td class="label">Pangkat/Golongan</td>
          <td class="colon">:</td>
          <td>{{ $pegawai->pangkat }} / {{ $pegawai->golongan }}</td>
        </tr>
        <tr>
          <td class="label">Jabatan</td>
          <td class="colon">:</td>
          <td>{{ $pegawai->tugas_tambahan ?: ($pegawai->jenis_ptk ?: '') }}</td>
        </tr>
        <tr>
          <td class="label">Unit Kerja</td>
          <td class="colon">:</td>
          <td>{{ $pegawai->lembaga_pengangkatan }}</td>
        </tr>
      </table>
      @elseif($siswa)
      <table>
        <tr>
          <td class="label">Nama</td>
          <td class="colon">:</td>
          <td>{{ $siswa->nama }}</td>
        </tr>
        <tr>
          <td class="label">NIS</td>
          <td class="colon">:</td>
          <td>{{ $siswa->nis }}</td>
        </tr>
        <tr>
          <td class="label">NISN</td>
          <td class="colon">:</td>
          <td>{{ $siswa->nisn }}</td>
        </tr>
        <tr>
          <td class="label">Kelas</td>
          <td class="colon">:</td>
          <td>{{ $siswa->kelas }}</td>
        </tr>
        <tr>
          <td class="label">Alamat</td>
          <td class="colon">:</td>
          <td>{{ $siswa->alamat }}</td>
        </tr>
      </table>
      @endif
    </div>
    <br />
    <div class="isi-surat-content" style="text-align: justify; text-indent: 1cm">
      {!! nl2br(e($suratKeterangan->isi_surat)) !!}
    </div>
    <br />
    <div class="signature" style="padding-left: 250pt">
      <p>
        {{ $suratKeterangan->tempat_ditetapkan }}, {{ $fmt($suratKeterangan->tanggal_ditetapkan) }} <br />
        {{ $penandatangan ? ($penandatangan->tugas_tambahan ?: ($penandatangan->jenis_ptk ?: '')) : '' }},
      </p>
      <br />
      <br />
      <br />
      <p>
        {{ $penandatangan->nama ?? '' }} <br />
        {{ $penandatangan->pangkat_golongan ?? '' }}
        <br />
        NIP. {{ $penandatangan->nip ?? '' }}
      </p>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-keterangans.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
    </div>
  </body>
</html>
