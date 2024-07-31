@extends('dashboard.main')
@section('content')
<div class="container">
<form action="/kirim/edit/{{$data['data']['pengajuan_wisuda']['pengajuan_id']}}" method="POST" enctype="multipart/form-data">
    @csrf
<!-- letakkan field di sini -->
<fieldset style="border: 2px solid #ccc; padding: 20px;">
<legend><h1 style="color: blue;">Formulir Pendaftaran Wisuda</h1></legend>
<table style="width: 100%; border-collapse: collapse;">
<div class="rot">
            <div class="col-md-6">
                <td style="padding: 10px;">NIM Mahasiswa</td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="text" name="nim" value="{{ session('profile')['nim'] }}" style="width: 100%;"/><br /></td>
            </div>
            <div class="col-md-6">
                <td style="padding: 10px;">Tanggal Sidang Akhir</td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="date" name="tanggal_sidang_akhir" value="{{$data['data']['pengajuan_wisuda']['tgl_sidang_akhir']}}" style="width: 100%;"/><br /></td>
            </div>
        </div>

    <tr>
        <td style="padding: 10px;">Nama lengkap</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="nama" value="{{$data['data']['pengajuan_wisuda']['nama']}}" style="width: 100%;"/><br /></td>
        <div class="col-md-6">
                <td style="padding: 10px;">Bukti Pembayaran</td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="file" name="bukti_pembayaran"  value="{{$data['data']['pengajuan_wisuda']['file_bukti_pembayaran']}}" style="width: 100%;"/><br /></td>
            </div>
    </tr>
    <tr>
        <td style="padding: 10px;">NIK</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="nik" value="{{$data['data']['pengajuan_wisuda']['nim']}}" style="width: 100%;"/><br /></td>
        <div class="col-md-6">
                <td style="padding: 10px;">Upload Ijazah SMA/SMK/MA</td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="file" name="file_ijazah" value="{{$data['data']['pengajuan_wisuda']['file_ijazah']}}"style="width: 100%;"/><br /></td>
            </div>
    </tr>
    <tr>
        <td style="padding: 10px;">Tempat lahir</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="tempat_lahir" value="{{$data['data']['pengajuan_wisuda']['tempat_lahir']}}" style="width: 100%;"/><br /></td>
        <div class="col-md-6">
                <td style="padding: 10px;">Upload KTP Asli 
                    *untuk verifikasi Ijazah
                </td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="file" name="ktp" value="{{$data['data']['pengajuan_wisuda']['file_ktp']}}"style="width: 100%;"/><br /></td>
            </div>
    </tr>
    <tr>
        <td style="padding: 10px;">Tanggal Lahir</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="date" name="tanggal_lahir" value="{{$data['data']['pengajuan_wisuda']['tgl_lahir']}}" style="width: 100%;" /></td>
    </tr>
    <tr>
        <td style="padding: 10px;">Email</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="email" name="email" value="{{$data['data']['pengajuan_wisuda']['email']}}" style="width: 100%;"/><br /></td>
    </tr>  
    <tr>
        <td style="padding: 10px;">Nomor Handphone</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="no_hp" value="{{$data['data']['pengajuan_wisuda']['no_hp']}}" style="width: 100%;"/><br /></td>
    </tr>     
    <tr>
        @php
            $skripsiDiajukan = '';
            
            if ($data['status'] == 'success') {
                $skripsiDiajukan = isset($data['data']['skripsi_diajukan']['judul']) ? $data['data']['skripsi_diajukan']['judul'] : '';
            }

        @endphp
        <td style="padding: 10px;">Judul Skripsi</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="judul_skripsi" value="{{$data['data']['pengajuan_wisuda']['judul_skripsi']}}" style="width: 100%;"/><br /></td>
    </tr>
    <tr>
        <td style="padding: 10px;">Jurusan</td>
        <td style="padding: 10px;">:</td>
        <td style="padding: 10px;"><input type="text" name="jurusan" value="{{$data['data']['pengajuan_wisuda']['kd_jur']}}" style="width: 100%;"/><br /></td>
        <div class="col-md-6">
                <td style="padding: 10px;">*NOTES 
                    Bukti Pembayan sumbangan akademik jumlah nominal RP.150.000 per -orang ke NO Rekening TANTRA BANKNYA GATAU
                </td>
                <td style="padding: 10px;">:</td>
                <td style="padding: 10px;"><input type="file" name="bukti_pembayaran_sumbangan" value="{{$data['data']['pengajuan_wisuda']['file_bukti_pembayaran_sumbangan']}}" style="width: 100%;"/><br /></td>
            </div>
    </tr>
    <tr>
        
        <td style="padding: 10px;"><input class="btn btn-primary align-content-cernter" type="submit" name="submit" value="SUBMIT" style="width: 100%;"/></td>

    </tr>
</table>
</fieldset>

</form>


    </div>

@endsection
