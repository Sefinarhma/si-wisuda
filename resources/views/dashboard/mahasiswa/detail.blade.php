@extends('dashboard.main')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  @if ($data['status'] == 'success' && isset($data['data']['pengajuan_wisuda']['pengajuan_id']))
  <div class="card">
    <div class="card-header">
      <h1>Detail Pengajuan Wisuda</h1>
    </div>
    <div class="card-body">
      @php
        $detail = $data['data']['pengajuan_wisuda'];
      @endphp
      <div class="table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
              <th>NIM</th>
              <td>{{ $detail['nim'] }}</td>
            </tr>
            <tr>
              <th>Tanggal Sidang Akhir</th>
              <td>{{ $detail['tgl_sidang_akhir'] }}</td>
            </tr>
            <tr>
              <th>Nama Lengkap</th>
              <td>{{ $detail['nama'] }}</td>
            </tr>
            <tr>
              <th>NIK</th>
              <td>{{ $detail['nik'] }}</td>
            </tr>
            <tr>
              <th>Tempat Lahir</th>
              <td>{{ $detail['tempat_lahir'] }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ $detail['tgl_lahir'] }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $detail['email'] }}</td>
            </tr>
            <tr>
              <th>Nomor Handphone</th>
              <td>{{ $detail['no_hp'] }}</td>
            </tr>
            <tr>
              <th>Judul Skripsi</th>
              <td>{{ $detail['judul_skripsi'] }}</td>
            </tr>
            <tr>
              <th>Jurusan</th>
              <td>
                @if ( $detail['kd_jur'] == 12)
                  <span>TEKNIK INFORMATIKA</span>
                @elseif( $detail['kd_jur'] == 32)
                <span>SISTEM INFORMASI</span>
                @endif</td>
            </tr>
            <tr>
              <th>Bukti Pembayaran</th>
              <td><a href="{{ Storage::url($detail['file_bukti_pembayaran']) }}" class="btn btn-link">Download</a></td>
            </tr>
            <tr>
              <th>KTP</th>
              <td><a href="{{ Storage::url($detail['file_ktp']) }}" class="btn btn-link">Download</a></td>
            </tr>
            <tr>
              <th>Bukti Pembayaran Sumbangan</th>
              <td><a href="{{ Storage::url($detail['file_bukti_pembayaran_sumbangan']) }}" class="btn btn-link">Download</a></td>
            </tr>
            <tr>
              <th>Ijazah</th>
              <td><a href="{{ Storage::url($detail['file_ijazah']) }}" class="btn btn-link">Download</a></td>
            </tr>
            <tr>
              @if ($detail['is_verified'] == true)
              <td colspan="2"><a class="btn btn-primary disabled">Edit</a></td>
              <td colspan="2"><a class="btn btn-success disabled">Verifikasi</a></td>
              <span style="color: green">SUDAH TERVERIFIKASI</span>
              @else
              <td colspan="2"><a href="/edit/pengajuan/mahsiswa/{{$detail['pengajuan_id']}}" class="btn btn-primary">Edit</a></td>
              <td colspan="2">
                <form action="{{ route("verifikasiMahasiswa") }}" method="post">
                  @csrf
                  {{-- {{$item}} --}}
                  <input type="hidden" value="{{ $detail['pengajuan_id']  }}" name="pengajuan_id">
                  <button type="submit" class="btn btn-success">Verifikasi</button>
                </form>
                <span style="color: red">*jika data sudah benar klik verifikasi <br> dan jika sudah klik button verifikasi tidak dapat di ubah</span>
              </td>
              @endif
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @else
    <div class="alert alert-warning" role="alert">
      Belum mengajukan pendaftaran wisuda.
    </div>
  @endif
</div>
@endsection
