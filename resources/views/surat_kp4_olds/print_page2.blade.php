<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Halaman 2 - Daftar Anak - {{ $pegawai->nama ?? '' }}</title>
<style>
  @page { size: A4 landscape; margin: 15mm; }
  * { box-sizing: border-box; }
  body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: #111;
    width: 100%;
    margin: 0;
    padding: 0;
    background: #fff;
  }
  .mt-5 { margin-top: 20px; }
  table { width: 100%; }
  @media print {
    body { margin: 0; }
    .no-print { display: none !important; }
  }
</style>
</head>
<body>

@php
    $data = $pegawai;
    $jk = $data->jk === 'L' ? 'Laki-Laki' : ($data->jk === 'P' ? 'Perempuan' : '-');
    $namaAyah = $data->jk === 'L' ? $data->nama : ($data->nama_suami_istri ?? '-');
    $namaIbu = $data->jk === 'L' ? ($data->nama_suami_istri ?? '-') : $data->nama;
    $anakKategori1 = $suratKp4Old->anak->where('kat', 1);
    $anakKategori2 = $suratKp4Old->anak->where('kat', 2);
    $total = $anakKategori1->count();
    $t = $anakKategori2->count();
@endphp

<p class="mt-5">I. Anak Kandung ( Ak ), Anak Tiri ( At ) dan Anak Angkat ( Aa ) yang masih menjadi tanggungan, belum mempunyai penghasilan sendiri dan masuk daftar gaji</p>
<Table border="1" cellpadding="2" cellspasing="2">
<?php $no = 1; ?>
<tr style="text-align:center; background-color:rgb(187, 189, 191)">
    <th style="width: 30px" rowspan="2">&nbsp; <br><br><br><br> No.</th>
    <th style="width: 100px" rowspan="2">&nbsp;<br><br><br><br> Nama</th>
    <th rowspan="2">&nbsp;<br><br><br> Status <br> Anak (ak) <br> (at) (aa)</th>
    <th rowspan="2">&nbsp;<br><br><br><br> Tanggal Lahir</th>
    <th rowspan="2">&nbsp;<br><br><br> Belum <br> Pernah <br> Kawin</th>
    <th rowspan="2">&nbsp;<br><br><br>Bersekolah/ <br> Kuliah pada</th>
    <th rowspan="2">&nbsp;<br><br>Tidak mendapat <br>
        1. Beasiswa/ darmasiswa <br>
        2. Ikatan Dinas
    </th>
    <th colspan="2">Lahir dari Perkawinan</th>
    <th rowspan="2">&nbsp;<br><br>Tanggal Meninggal/ <br> diceraikannya <br> ayah/ibu</th>
    <th rowspan="2">Keterangan <br> diangkat menurut : <br>
        a. Putusan pengadilan <br>
        b. Hukum adopsi bagi <br> keturunan Cina
    </th>
</tr>
<tr style="text-align: center; background-color:rgb(187, 189, 191)">
    <th>&nbsp;<br><br><br>
        Nama Ayah
        {{-- @if ( $data->jk === "Perempuan")
        Nama Ibu
        @else
        Nama Ayah
        @endif --}}
    </th>
    <th>&nbsp;<br><br><br>
        Nama Ibu
        {{-- @if ( $data->jk === "Laki-Laki")
        Nama Ibu
        @else
        Nama Ayah
        @endif --}}
    </th>
</tr>
@if ($total == 0)
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
@endif
    @foreach ($suratKp4Old->anak->where('kat', 1) as $item)
    @if ($item->kat == 1)
    <tr>
        <td style="text-align: center"><?php echo $no++; ?>.</td>
        <td>{{$item->name}}</td>
        <td style="text-align: center">{{$item->anak}}</td>
        <td style="text-align: center">{{ \Carbon\Carbon::parse($item->tgl_lahir)->translatedFormat('d-m-Y ') }}</td>
        <td>{{$item->perkawinan}}</td>
        <td>{{$item->status_sekolah}}</td>
        <td>{{$item->status_beasiswa}}</td>
        <td>{{ $jk == 'Laki-Laki' ? $namaAyah : $namaAyah }}</td>
        <td>{{ $jk == 'Laki-Laki' ? $namaIbu : $namaIbu }}</td>
        <td>{{ $item->tgl_meninggal_cerai ? \Carbon\Carbon::parse($item->tgl_meninggal_cerai)->translatedFormat('d-m-Y ') : '-' }}</td>
        <td></td>
    </tr>
    @endif
    @endforeach
</table>

<P class="mt-5">II. Anak Kandung ( Ak ), Anak Tiri ( At ) dan Anak Angkat ( Aa ) yang masih tanggungan, tetapi tidak masuk dalam daftar gaji</P>
<Table border="1" cellpadding="2" cellspasing="2">
    <tr style="text-align: center; background-color:rgb(187, 189, 191)">
        <th style="width: 30px">&nbsp;<br><br><br>No.</th>
        <th  style="width: 130px">&nbsp;<br><br><br>Nama</th>
        <th>&nbsp;<br><br>Status <br> Anak (ak) <br> (at) (aa)</th>
        <th>&nbsp;<br><br><br>Tanggal Lahir</th>
        <th>&nbsp;<br><br>Belum <br> Pernah <br> Kawin</th>
        <th>&nbsp;<br><br><br>Bersekolah/ <br> Kuliah pada</th>
        <th>&nbsp;<br><br> mendapat <br>
            1. Beasiswa/ darmasiswa <br>
            2. Ikatan Dinas
        </th>
        <th>&nbsp;<br><br><br>bekerja atau <br> tidak bekerja</th>
        <th>Keterangan <br> diangkat menurut : <br>
            a. Putusan pengadilan <br>
            b. Hukum adopsi bagi <br> keturunan Cina
        </th>
    </tr>
    <?php $no = 1; ?>
    @if ($t == 0)
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    @endif
    @foreach ($suratKp4Old->anak->where('kat', 2) as $item)
    @if ($item->kat == 2)
    <tr>
        <td style="text-align: center"><?php echo $no++; ?>.</td>
        <td>{{$item->name}}</td>
        <td style="text-align: center">{{$item->anak}}</td>
        <td style="text-align: center">{{ \Carbon\Carbon::parse($item->tgl_lahir)->translatedFormat('d-m-Y ') }}</td>
        <td style="text-align: center">{{$item->perkawinan}}</td>
        <td style="text-align: center">{{$item->status_sekolah}}</td>
        <td style="text-align: center">{{$item->status_beasiswa}}</td>
        <td style="text-align: center">{{$item->pekerjaan}}</td>
        <td></td>
    </tr>
    @endif
    @endforeach
</table>

<P>A. Supaya dilampirkan salinan Surat Keputusan Pengadilan Negeri yang disahkan <br>B. Supaya diisi jika anak dilahirkan dari istri/suami yang telah meninggal dunia atau diceraikan
</P>

<div class="no-print" style="text-align:center; margin-top:20px;">
<button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak Halaman 2</button>
<a href="{{ route('surat-kp4-olds.print', $suratKp4Old) }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
