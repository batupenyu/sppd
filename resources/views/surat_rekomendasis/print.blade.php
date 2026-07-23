<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Rekomendasi Studi Lanjut {{ $suratRekomendasi->nomor_surat }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 1cm;
      }
      body {
        background-color: #525659;
        font-family: "Helvetica", sans-serif;
        font-size: 14pt;
        line-height: 1.2;
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
    @php
      $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratRekomendasiController::formatTanggal($d, '%d %B %Y') : '...................';
      $penandatangan = $suratRekomendasi->penandatangan;
      $pegawai = $suratRekomendasi->pegawai;

      $pertimbanganLines = collect(explode("\n", (string) ($suratRekomendasi->pertimbangan ?? '')))
        ->map(fn ($line) => trim(preg_replace('/^[\d]+\.?\s*/', '', trim($line))))
        ->filter(fn ($line) => $line !== '');
    @endphp

    <div class="page">
    @if($kopSuratBase64)
    <img
      src="{{ $kopSuratBase64 }}"
      style="max-width: 100%; height: auto; display: block; margin-bottom: 20px"
    />
    @endif
    <div class="header" style="text-align: center">
      <p>
        <strong><u>SURAT REKOMENDASI STUDI LANJUT</u></strong><br />
        <strong>Nomor : {{ $suratRekomendasi->nomor_surat }}</strong>
      </p>
    </div>
    <div class="content">
      <p>Yang bertanda tangan di bawah ini:</p>
      <table>
        <tr>
          <td class="label">Nama</td>
          <td class="colon">:</td>
          <td>{{ $penandatangan->nama ?? '' }}</td>
        </tr>
        <tr>
          <td class="label">NIP</td>
          <td class="colon">:</td>
          <td>{{ $penandatangan->nip ?? '' }}</td>
        </tr>
        <tr>
          <td class="label">Jabatan</td>
          <td class="colon">:</td>
          <td>{{ $penandatangan->jabatan ?? ($penandatangan->tugas_tambahan ?: ($penandatangan->jenis_ptk ?: '')) }}</td>
        </tr>
        <tr>
          <td class="label">Instansi</td>
          <td class="colon">:</td>
          <td>{{ $suratRekomendasi->instansi }}</td>
        </tr>
      </table>
      <p>
        Dengan ini memberikan rekomendasi kepada pegawai di bawah ini:
      </p>
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
          <td class="label">Jabatan</td>
          <td class="colon">:</td>
          <td>{{ $pegawai->jabatan ?? ($pegawai->tugas_tambahan ?: ($pegawai->jenis_ptk ?: '')) }}</td>
        </tr>
        <tr>
          <td class="label">Unit Kerja</td>
          <td class="colon">:</td>
          <td>{{ $pegawai->lembaga_pengangkatan }}</td>
        </tr>
      </table>
      @endif
      <p style="text-align: justify">
        Untuk mengikuti program pendidikan Pascasarjana (S2) di
        <strong>{{ $suratRekomendasi->nama_universitas }}</strong> pada program studi
        <strong>{{ $suratRekomendasi->program_studi }}</strong>.
      </p>
      <p><strong>Pertimbangan Rekomendasi:</strong></p>
      <ol class="pertimbangan" style="text-align: justify; line-height: 1.5; margin-top: 0; padding-left: 20pt">
        @forelse($pertimbanganLines as $line)
        <li style="margin-bottom: 0; line-height: 1.5">{{ $line }}</li>
        @empty
        <li style="margin-bottom: 0; line-height: 1.5">-</li>
        @endforelse
      </ol>
      <p style="text-align: justify">
        Pihak instansi mendukung penuh rencana pendidikan yang bersangkutan,
        dengan ketentuan bahwa pendidikan tersebut tidak mengganggu tugas
        kedinasan utama, sesuai dengan peraturan perundang-undangan yang berlaku.
      </p>
      <p style="text-align: justify">
        Demikian surat rekomendasi ini dibuat dengan sebenar-benarnya agar
        dapat dipergunakan sebagaimana mestinya.
      </p>
    </div>
    <div class="signature" style="padding-left: 250pt">
      <p>
        {{ $suratRekomendasi->tempat_ditetapkan }}, {{ $fmt($suratRekomendasi->tanggal_ditetapkan) }} <br />
        {{ $penandatangan->jabatan ?? ($penandatangan->tugas_tambahan ?: ($penandatangan->jabatan ?: '')) }},
      </p>
      <br />
      <p>
        {{ $penandatangan->nama ?? '' }} <br />
        {{ $penandatangan->pangkat }}, {{ $penandatangan->golongan }}
        <br />
        NIP. {{ $penandatangan->nip ?? '' }}
      </p>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-rekomendasis.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
    </div>
  </body>
</html>
