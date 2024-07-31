@extends('dashboard.main')
@section('content')
<div>
  <h1>Rekap Data</h1>
  <div class="d-flex justify-content-between">
    <span>
      <form action="">
        @csrf
        <select class="form-select form-select-sm" id="cariTahun" aria-label="Small select example">
          <option value="" disabled {{ !request('filter') ? 'selected' : '' }}>Select filter</option>
          @foreach ($jadwal as $item)
              <option value="{{$item['tahun']}}">{{'Angkatan '.$item['angkatan_wisuda'] . ' - ' . $item['tahun']}}</option>
          @endforeach
        </select>
        <button type="button" class="btn btn-success btn-sm" id="btnCari">cari</button>
      </form>
    </span>
  </div>
  <div class="d-flex justify-content-end">
    <button class="btn btn-success btn-sm export-button" onclick="exportToExcel()">Export Exel</button>
  </div>
</div>
<div class="container">
  <table class="table table-sm" id="tableRekapData">
    <thead>
      <tr>
        <th scope="col">NO</th>
        <th scope="col">NIM</th>
        <th scope="col">Nama</th>
        <th scope="col">Jurusan</th>
        <th scope="col">Tanggal Wisuda</th>
      </tr>
    </thead>
    <tbody>
      {{-- @if (isset($data['status']) && $data['status'] == 'success')
        @php
          $listPengajuanDiterima = $data['data']['list_pengajuan'];
        @endphp
        @foreach ($listPengajuanDiterima as $item)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $item['nim'] }}</td>
            <td>{{ $item['nama'] }}</td>
            <td>
              @if ($item['kd_jur'] == 12)
                <span>Teknik Informatika</span>
              @else
                <span>Sistem Informasi</span>
              @endif
            </td>
            <td>{{ $item['tgl_wisuda'] }}</td>
          </tr>
        @endforeach
      @else --}}
        <tr>
          <td colspan="6" class="text-center">No data available.</td>
        </tr>
      {{-- @endif     --}}
    </tbody>
  </table>
</div>

<script>
  $("#btnCari").click(function(){
    // $('#tableRekapData').DataTable().destroy();
    var tahun = $("#cariTahun").val();
    var token = $('input[name="_token"]').val();
    $.ajax({
      type:'POST',
      url:"/rekap/"+tahun,
      data: {_token:token},
      success:function(response,xhr,rows){
        $('#tableRekapData').dataTable({
                    "destroy": true,
                    "aaData": response,
                    "aoColumns": [
                        { 
                            "mData": null,
                            render: function (data, type, row, meta) {
	                        return meta.row + meta.settings._iDisplayStart + 1;}
                        },
                        { data: 'nim' },
                        { data: 'nama' },
                        { "mData": null,
                            render: function (data, type, row, meta) {
                              if (data.kd_jur == 32){
                                return "<span>Sistem Informasi</span>"

                              }else{
                                return "<span>Tehnik Informatika</span>"
                              }}
                        },
                        { data: 'tgl_wisuda' },
                        ],
                        searching:false,
                        page:false

                });
              },
      });
    });
    function exportToExcel() {
    var tahun = $("#cariTahun").val();
    if (tahun) {
        window.location.href = "/export-excel?tahun=" + tahun;
    } else {
        alert("Silakan pilih tahun terlebih dahulu.");
    }
}
</script>
@endsection
