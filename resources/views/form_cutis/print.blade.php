<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Formulir Permintaan dan Pemberian Cuti</title>
<style>
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 13px;
    color: #000;
    max-width: 850px;
    margin: 30px auto;
    padding: 0 15px;
  }
  h1 {
    text-align: center;
    font-size: 15px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
  }
  .nomor {
    text-align: center;
    font-weight: bold;
    margin-bottom: 14px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  .block {
    margin-bottom: 14px;
  }
  td, th {
    border: 1px solid #000;
    padding: 3px 6px;
    vertical-align: top;
  }
  .section-title {
    font-weight: bold;
  }
  .center { text-align: center; }
  .bold { font-weight: bold; }
  /* ---- Table I ---- */
  .t1 .lbl { width: 14%; }
  .t1 .val { width: 36%; }
  /* ---- Table II ---- */
  .t2 .lbl2 { width: 27%; }
  .t2 .val2 { width: 23%; text-align:center; }
  /* ---- Table IV ---- */
  .t4 td { text-align: center; }
  /* ---- Table V ---- */
  .t5 td { text-align: left; }
  .t5 .r-lbl { width: 30%; }
  .t5 .r-val { width: 10%; text-align:center; }
  /* ---- Table VI ---- */
  .t6-inner td { border: none; padding: 2px 6px; }
  .sign-space { height: 55px; }
  .noborder { border: none; }
  .no-print { margin-top: 20px; text-align: center; }
  @media print {
    .no-print { display: none !important; }
  }
</style>
</head>
<body>

<h1>Formulir Permintaan dan Pemberian Cuti</h1>
<div class="nomor">Nomor. {{ $formCuti->nomor_surat ?: '800.1.11.4/......../2026' }}</div>
<div style="float: inline-end; padding:4px">Tanggal : ..................................</div>

@php
    $p = $formCuti->pegawai;
    $kepalaSekolah = $formCuti->kepalaSekolah;
    $kepalaCabang = $formCuti->kepalaCabang;
    $jenisCuti = $formCuti->jenis_cuti;
    $formattedMulai = $formCuti->tanggal_mulai_cuti ? \App\Http\Controllers\FormCutiController::formatTanggal($formCuti->tanggal_mulai_cuti, '%d/%m/%Y') : '';
    $formattedSelesai = $formCuti->tanggal_selesai_cuti ? \App\Http\Controllers\FormCutiController::formatTanggal($formCuti->tanggal_selesai_cuti, '%d/%m/%Y') : '';
    $masaKerja = \Carbon\Carbon::parse($p?->tmt_pengangkatan ?? now())->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan');
@endphp

<!-- I. DATA PEGAWAI -->
<div class="block">
  <table class="t1">
    <tr><td colspan="4" class="section-title">I. DATA PEGAWAI</td></tr>
    <tr>
      <td class="lbl">Nama</td>
      <td class="val">{{ $p?->nama ?? '-' }}</td>
      <td class="lbl">NIP / GOL</td>
      <td class="val">{{ $p?->nip ?? '-' }} / {{ $p?->pangkat_golongan ?? '-' }}</td>
    </tr>
    <tr>
      <td class="lbl">Jabatan</td>
      <td class="val">{{ $p?->jabatan ?? ($p?->jabatan ?? '-') }}</td>
      <td class="lbl">Masa Kerja</td>
      <td class="val">{{ $masaKerja }}</td>
    </tr>
    <tr>
      <td class="lbl">Unit Kerja</td>
      <td colspan="3">{{ $p?->unit_kerja ?? '-' }}</td>
    </tr>
  </table>
</div>

<!-- II. JENIS CUTI -->
<div class="block">
  <table class="t2">
    <tr><td colspan="4" class="section-title">II. JENIS CUTI YANG DIAMBIL</td></tr>
    <tr>
      <td class="lbl2">1. Cuti Tahunan</td>
      <td class="val2">{!! $jenisCuti === 'Cuti Tahunan' ? '<strong>✓</strong>' : '-' !!}</td>
      <td class="lbl2">2. Cuti Besar</td>
      <td class="val2">{!! $jenisCuti === 'Cuti Besar' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td class="lbl2">3. Cuti Sakit</td>
      <td class="val2">{!! $jenisCuti === 'Cuti Sakit' ? '<strong>✓</strong>' : '-' !!}</td>
      <td class="lbl2">4. Cuti Melahirkan</td>
      <td class="val2">{!! $jenisCuti === 'Cuti Melahirkan' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td class="lbl2">5. Cuti Karena Alasan Penting</td>
      <td class="val2">{!! $jenisCuti === 'Cuti Karena Alasan Penting' ? '<strong>✓</strong>' : '-' !!}</td>
      <td class="lbl2">6. Cuti di Luar Tanggungan</td>
      <td class="val2">{!! $jenisCuti === 'Cuti di Luar Tanggungan Negara' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
  </table>
</div>

<!-- III. ALASAN CUTI -->
<div class="block">
  <table>
    <tr><td class="section-title">III. ALASAN CUTI</td></tr>
    <tr><td>{{ $formCuti->alasan_cuti ?: '-' }}</td></tr>
  </table>
</div>

<!-- IV. LAMANYA CUTI -->
<div class="block">
  <table class="t4">
    <tr><td colspan="6" class="section-title" style="text-align:left;">IV. LAMANYA CUTI</td></tr>
    <tr>
      <td style="width:14%;">Selama</td>
      <td style="width:14%;">{{ $formCuti->jumlah_hari ?: '...' }} Hari</td>
      <td style="width:18%;">Mulai Tanggal</td>
      <td style="width:24%;">{{ $formattedMulai ?: '....................' }}</td>
      <td style="width:6%;">s/d</td>
      <td style="width:24%;">{{ $formattedSelesai ?: '....................' }}</td>
    </tr>
  </table>
</div>

<!-- V. CATATAN CUTI -->
<div class="block">
  <table class="t5">
    <tr><td colspan="5" class="section-title">V. CATATAN CUTI</td></tr>
    <tr>
      <td colspan="2" class="center">1. CUTI TAHUNAN</td>
      <td class="center">{!! $jenisCuti === 'Cuti Tahunan' ? '<strong>✓</strong>' : '-' !!}</td>
      <td class="r-lbl">2. CUTI BESAR</td>
      <td class="r-val">{!! $jenisCuti === 'Cuti Besar' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td style="width:12%;">Tahun</td>
      <td style="width:12%;">Sisa</td>
      <td style="width:16%;">Keterangan</td>
      <td class="r-lbl">3. CUTI SAKIT</td>
      <td class="r-val">{!! $jenisCuti === 'Cuti Sakit' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td>N-2</td>
      <td>&nbsp;</td>
      <td>Sisa:</td>
      <td class="r-lbl">4. CUTI MELAHIRKAN</td>
      <td class="r-val">{!! $jenisCuti === 'Cuti Melahirkan' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td>N-1</td>
      <td>&nbsp;</td>
      <td>Sisa:</td>
      <td class="r-lbl">5. CUTI KARENA ALASAN PENTING</td>
      <td class="r-val">{!! $jenisCuti === 'Cuti Karena Alasan Penting' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
    <tr>
      <td>N</td>
      <td>&nbsp;</td>
      <td>Sisa:</td>
      <td class="r-lbl">6. CUTI DILUAR TANGGUNGAN NEGARA</td>
      <td class="r-val">{!! $jenisCuti === 'Cuti di Luar Tanggungan Negara' ? '<strong>✓</strong>' : '-' !!}</td>
    </tr>
  </table>
</div>

<!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
<div class="block">
  <table>
    <tr><td colspan="2" class="section-title">VI. ALAMAT SELAMA MENJALANKAN CUTI</td></tr>
    <tr>
      <td rowspan="3" style="width:60%; vertical-align: top; padding-top:10px;">{{ $formCuti->alamat_cuti ?: ($p?->alamat_jalan ?: 'Kabupaten Bangka Tengah') }}</td>
      <td style="text-align: center">TELP. &nbsp;&nbsp; {{ $formCuti->telepon ?: ($p?->hp ?: '-') }}</td>
    </tr>
    <tr>
      <td style="padding:0; border-top: none; border-bottom: none">
        <table class="t6-inner">
          <tr><td class="center">Hormat Saya</td></tr>
          <tr><td class="sign-space">&nbsp;</td></tr>
          <tr><td class="center bold" style="border-bottom: none">{{ $p?->nama ?? 'Nama Pegawai' }}</td></tr>
        </table>
      </td>
    </tr>
    <tr>
      {{-- <td>&nbsp;</td> --}}
      <td class="center" style="border-top: none">
        <!-- {{ $p?->pangkat ?? '' }} <br> -->
        NIP. {{ $p?->nip ?? '' }}
      </td>
    </tr>
  </table>
</div>

<!-- VII. PERTIMBANGAN ATASAN LANGSUNG -->
<div class="block">
  <table>
    <tr><td colspan="4" class="section-title">VII. PERTIMBANGAN ATASAN LANGSUNG***</td></tr>
    <tr class="center bold">
      <td style="width:20%;">DISETUJUI</td>
      <td style="width:20%;">PERUBAHAN***</td>
      <td style="width:20%;">DITANGGUHKAN****</td>
      <td style="width:40%;">TIDAK DISETUJUI****</td>
    </tr>
    <tr class="center bold" style="height: 30px;">
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:40%;"><input type="checkbox"></td>
    </tr>
    <tr>
      <td colspan="3" rowspan="5">&nbsp;</td>
      <td class="center" style="border-bottom: none">
        {{ ($formCuti->plt_plh ? $formCuti->plt_plh . ' ' : '') . ucwords(strtolower($kepalaSekolah?->tugas_tambahan ?? ($kepalaSekolah?->jabatan ?? 'Kepala Sekolah'))) }} <br>
        {{ ucwords(strtolower($kepalaSekolah?->unit_kerja ?? 'Dinas Pendidikan Provinsi Kepulauan Bangka Belitung'))}}
      </td>
    </tr>
    <tr>
      <td class="sign-space" style="border-top: none; border-bottom: none">&nbsp;</td>
    </tr>
    <tr>
      <td class="center bold" style="border-top:none;">{{ $kepalaSekolah?->nama ?? '....................' }}
        <br>{{ $kepalaSekolah?->pangkat ?? '....................' }}
        <br>NIP. {{$kepalaSekolah?->nip ?? '....................'}}
      </td>
    </tr>
    <!-- <tr>
      <td class="center">NIP. {{ $kepalaSekolah?->nip ?? '....................' }}</td>
    </tr> -->
  </table>
</div>

<!-- VIII. KEPUTUSAN PEJABAT YANG BERWENANG -->
<div class="block">
  <table>
    <tr><td colspan="4" class="section-title">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI***</td></tr>
    <tr class="center bold">
      <td style="width:20%;">DISETUJUI</td>
      <td style="width:20%;">PERUBAHAN***</td>
      <td style="width:20%;">DITANGGUHKAN****</td>
      <td style="width:40%;">TIDAK DISETUJUI****</td>
    </tr>
    <tr class="center bold" style="height: 30px;">
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:20%;"><input type="checkbox"></td>
      <td style="width:40%;"><input type="checkbox"></td>
    </tr>
    <tr>
      <td colspan="3" rowspan="5">&nbsp;</td>
      <!-- <td class="center">{{ ucwords(strtolower($kepalaCabang?->tugas_tambahan ?? ($kepalaCabang?->jabatan ?? 'Kepala Sekolah'))) }} <br> Provinsi Kepulauan Bangka Belitung</td> -->
      <td class="center" style="border-top: none;border-bottom: none;">{{ ($formCuti->plt_plh_kepala_cabang ? $formCuti->plt_plh_kepala_cabang . ' ' : '') . ($kepalaCabang?->tugas_tambahan ?? ($kepalaCabang?->jabatan ?? 'Kepala Sekolah')) }} <br> Provinsi Kepulauan Bangka Belitung</td>
    </tr>
    <tr>
      <td class="sign-space" style="border-top: none; border-bottom: none">&nbsp;</td>
    </tr>
    <tr>
      <td class="center bold" style="border-top: none">{{ $kepalaCabang?->nama ?? '....................' }}
        <br>{{$kepalaCabang?->pangkat ?? ($kepalaCabang?->pangkat ?? 'Kepala Sekolah')}}
        <br>NIP. {{$kepalaCabang?->nip ?? ($kepalaCabang?->nip ?? 'Kepala Sekolah')}}
      </td>
    </tr>
    <!-- <tr>
      <td class="center">NIP. {{ $kepalaCabang?->nip ?? '....................' }}</td>
    </tr> -->
  </table>
</div>

<div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('form-cutis.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
