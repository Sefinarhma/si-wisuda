@extends('dashboard.main')
@section('content')
<H1>Dashboard</H1>
<br>
    <div class="container">

        {{-- Role: Mahahasiswa --}}
        @if (isset(session('role')['is_mhs']))
            @if ($data['status'] == 'success')
                <div class="card">
                    <div class="card-header fw-bold text-center">
                        Mengajukan!
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0 text-center" title="Belum mengajukan pendaftaran wisuda">
                        @if ($data['data']['pengajuan_wisuda']['kd_status'] == 'M')
                            {{-- Status: Menunggu --}}
                            <div class="d-flex gap-2 justify-content-center">
                                <i data-feather="clock"></i>
                                <p class="fs-6">Status pengajuan masih menunggu</p>
                            </div>
                        @endif

                        @if ($data['data']['pengajuan_wisuda']['kd_status'] == 'S')
                            {{-- Status: Disetujui --}}
                            <div class="d-flex gap-2 justify-content-center">
                                <i data-feather="check-circle"></i>
                                <p class="fs-6">Status pengajuan disetujui</p>
                            </div>
                        @endif

                        @if ($data['data']['pengajuan_wisuda']['kd_status'] == 'T')
                            {{-- Status: Ditolak --}}
                            <div class="d-flex gap-2 justify-content-center">
                                <i data-feather="x-circle"></i>
                                <p class="fs-6">Status pengajuan ditolak</p>
                            </div>
                        @endif
                    </blockquote>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header fw-bold text-center">
                        Belum Mengajukan
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0 text-center" title="Belum mengajukan pendaftaran wisuda">
                        <i data-feather="file-minus"></i>
                    </blockquote>
                    </div>
                </div>
            @endif
        @endif

        {{-- Role: Admin --}}
        @if (isset(session('role')['is_admin']))
            @if ($data['status'] == 'success')
                @php
                    $statistikPengajuan = $data['data']['statistik_pengajuan'];
                @endphp

                <div class="row gap-1" style="flex-wrap: nowrap">
                    <div class="card col-lg-4">
                        <div class="card-header fw-bold text-center">
                            Jumlah Wisuda
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0 text-center">
                                <p>
                                    {{ $statistikPengajuan['total_pengajuan_diterima'] }}
                                </p>
                            </blockquote>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <div class="card-header fw-bold text-center">
                            SI
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0 text-center">
                                <p>
                                    {{ $statistikPengajuan['total_pengajuan_jurusan_si_diterima'] }}
                                </p>
                            </blockquote>
                        </div>
                    </div>

                    <div class="card col-lg-4">
                        <div class="card-header fw-bold text-center">
                            IF
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0 text-center">
                                <p>
                                    {{ $statistikPengajuan['total_pengajuan_jurusan_if_diterima'] }}
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
