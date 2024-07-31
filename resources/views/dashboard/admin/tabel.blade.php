@extends('dashboard.main')
@section('content')
  <div class="table-wrapper m-3">
    <table class="table table-responsive">
      <h1 class="">List Jadwal</h1>
      <thead>
        <tr>
          <th scope="col">NO</th>
          <th scope="col">NIM</th>
          <th scope="col">Nama</th>
          <th scope="col">Tanggal Lahir</th>
          <th scope="col">Tanggal Wisuda</th>
          <th scope="col">Verifikasi</th>
          <th scope="col">status</th>
          <th scope="col" class="text-center">Detail</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($data['status']) && $data['status'] == 'success')
          @php
            $listPengajuan = $data['data']['list_pengajuan'];
          @endphp
          @foreach ($listPengajuan as $item)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $item['nim'] }}</td>
              <td>{{ $item['nama'] }}</td>
              <td>{{ $item['tgl_lahir'] }}</td>
              <td>{{ $item['tgl_wisuda'] }}</td>
              <td>{{ is_null($item['is_bayar']) ? 'Belum Diverifikasi' : 'Verifikasi' }}</td>
              <td>{{ is_null($item['is_ditolak']) ? '-' : ($item['is_ditolak'] ? 'Selesai' : 'Diterima') }}</td>
              <td class="text-center">
                @if ($item['is_verified'] == true)
                  
                <a href="#" class="text-decoration-none text-dark" title="Detail Pengajuan" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loop->iteration }}">
                  <i data-feather="info"></i>
                </a>
                @else
                <span>

                  <i data-feather="info"></i>
                </span>
                @endif
               <!-- Modal -->
<div class="modal fade" id="detailModal{{ $loop->iteration }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $loop->iteration }}" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailModalLabel{{ $loop->iteration }}">Detail Pengajuan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>NIM:</strong> {{ $item['nim'] }}</p>
            <p><strong>Nama:</strong> {{ $item['nama'] }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $item['tgl_lahir'] }}</p>
            <p><strong>Tanggal Wisuda:</strong> {{ $item['tgl_wisuda'] }}</p>
            <p><strong>NIK:</strong> {{ $item['nik'] }}</p>
            <p><strong>Tanggal Sidang Akhir:</strong> {{ $item['tgl_sidang_akhir'] }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Tempat Lahir:</strong> {{ $item['tempat_lahir'] }}</p>
            <p><strong>Email:</strong> {{ $item['email'] }}</p>
            <p><strong>Nomor Handphone:</strong> {{ $item['no_hp'] }}</p>
            <p><strong>Judul Skripsi:</strong> {{ $item['judul_skripsi'] }}</p>
            <p><strong>Jurusan:</strong>
              @if ($item['kd_jur'] == 12) 
                <span>TEKNIK INFORMATIKA</span>
              @else 
                  <span>SISTEM INFORMASI</span>
              @endif</p>
          </div>
        </div>
        <hr>
        <div class="text-center">
          <p><strong>File:</strong></p>
          <p>
            <a href="{{ Storage::url($item['file_bukti_pembayaran']) }}" class="btn btn-primary btn-sm" target="_blank">Bukti Pembayaran</a>
            <a href="{{ Storage::url($item['file_ktp']) }}" class="btn btn-primary btn-sm" target="_blank">KTP</a>
            <a href="{{ Storage::url($item['file_bukti_pembayaran_sumbangan']) }}" class="btn btn-primary btn-sm" target="_blank">Bukti Pembayaran Sumbangan</a>
            <a href="{{ Storage::url($item['file_ijazah']) }}" class="btn btn-primary btn-sm" target="_blank">Ijazah</a>
          </p>
        </div>
      </div>
      <form action="{{ route("verifikasi") }}" method="post">
        @csrf
        {{-- {{$item}} --}}
        <input type="hidden" value="{{ $item['pengajuan_id'] }}" name="pengajuan_id">
        <input type="hidden" value="{{ $item['nim'] }}" name="nim">
        <input type="hidden" value="{{ $item['nim'] }}" name="nim">
        <input type="hidden" value="{{ $item['nama'] }}" name="nama">
        <input type="hidden" value="{{ $item['nik'] }}" name="nik">
        <input type="hidden" value="{{ $item['tgl_lahir'] }}" name="tgl_lahir">
        <input type="hidden" value="{{ $item['tgl_wisuda'] }}" name="tgl_wisuda">
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Verifikasi</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </form>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>
</div>

                      </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="8" class="text-center">No data available.</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
  $('#btn-verifikasi').click(function() {
    alert(32);
    var nim = $(this).attr('nim');
    // Kirim permintaan verifikasi ke server
    $.ajax({
      url: '{{ route("verifikasi") }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}', // Sertakan token CSRF
        nim: $("#btn-verifikasi").data("nim"),
        nama: $("#btn-verifikasi").data("nama"),
        tgl_lahir: $("#btn-verifikasi").data("tgl_lahir"),
        tgl_wisuda: $("#btn-verifikasi").data("tgl_wisuda"),
        nik: $("#btn-verifikasi").data("nik"),
      },
      success: function(response) {
        if (response.status === 'success') {
          alert('Verifikasi berhasil');
          // Perbarui status di baris tabel setelah berhasil diverifikasi
          $('#verifikasi-' + nim).text('Verifikasi');
          $('#status-' + nim).text('Diterima');
        } else {
          alert('Verifikasi gagal: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        alert('Terjadi kesalahan: ' + xhr.responseText);
      }
    });
  });
});
</script>
@endsection