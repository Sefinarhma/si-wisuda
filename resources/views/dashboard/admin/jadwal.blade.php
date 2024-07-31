@extends('dashboard.main')
@section('content')
<h1 class="">Jadwal Wisuda</h1>

  <div class="d-flex">
    <button class="ms-auto btn btn-primary d-flex align-items-center gap-1"  title="Tambah Data" data-bs-toggle="modal" data-bs-target="#detailModaljadwal">
      <i data-feather="plus" style="width: 1.2em"></i>
      <span>
        Tambah
      </span>
    </button>

  </div>
   <!-- Modal -->
   <div class="modal fade" id="detailModaljadwal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Tambah Pengajuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Add your content here -->
          <form action="/add/jadwal" method="post">
            @csrf
            <div class="form-group">
                <label>Angkatan</label> <br>
                <input class="form-control" name="angkatan_wisuda" id="angkatan_wisuda" type="text" >
            </div>
            <div class="form-group">
                <label>Tanggal Wisuda</label> <br>
                <input class="form-control" name="tgl_wisuda" id="tgl_wisuda" type="date" >
            </div>
            <div class="form-group">
                <label>Tahun</label> <br>
                <input class="form-control" name="tahun" id="tahun" type="text" >
            </div>
            <div class="modal-footer">
              <div class="form-group">
                  <button class="btn btn-success">Submit</button>
              </div>
            </div>
            </form>
          <!-- Add more details as needed -->
        </div>
      </div>
    </div>
  </div>

  <div class="table-wrapper m-3">
    <table class="table table-responsive">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Angkatan</th>
          <th scope="col">Tanggal Wisuda</th>
          <th scope="col">Tahun</th>
          <th scope="col">Action</th>
          </tr>
      </thead>
      <tbody>
        @if (isset($data['status']))
          @if ($data['status'] == 'success')
            @php
              $listJadwal = $data['data']['jadwal_wisuda']
            @endphp
            @foreach ($listJadwal as $jadwal)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $jadwal['angkatan_wisuda'] }}</td>
                <td>{{ $jadwal['tgl_wisuda'] }}</td>
                <td>{{ $jadwal['tahun'] }}</td>
                <th scope="row">
                <button type="button" class="btn btn-primary btn-sm" id="btnEdit" data-toggle="modal" data-target="#detailModaljadwal" 
                data-tgl="{{$jadwal['tgl_wisuda']}}"
                data-angakatan="{{$jadwal['angkatan_wisuda']}}"
                data-tahunAngkatan="{{$jadwal['tahun']}}">
                Edit</button>
                  <form action="/hapus/jadwal" method="post" style="display: inline;">
                    @csrf
                    <input type="hidden" name="jadwalId" value="{{ $jadwal['jadwal_wisuda_id'] ?? '' }}">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="if (confirm('Apakan anda yakin ingin menghapus jadwal wisuda tahun ini ?')) {
                      event.preventDefault();
                      document.getElementById('delete-{{$jadwal['jadwal_wisuda_id'] }}').submit();
                    }else{
                      event.preventDefault();
                    }">
                      Delete
                    </button>
                  </form>
                </th>

              </tr>
            @endforeach
          @endif
        @else
          <tr>
              <td colspan="5" class="text-center">No data available.</td>
          </tr>
          @endif
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    $("#btnEdit").click(function(){
      var d = document.getElementById("btnEdit");
      var tahunAngkatan = d.getAttribute("data-tahunAngkatan");
      var angkatan = d.getAttribute("data-angakatan");
      var tgl = d.getAttribute("data-tgl");

      $("#angkatan_wisuda").val(angkatan);
      $("#tgl_wisuda").val(tgl);
      $("#tahun").val(tahunAngkatan);
      $("#detailModaljadwal").modal('show');
    }); 
});
  </script>
@endsection