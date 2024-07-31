<?php

namespace App\Http\Controllers;

use App\Models\WisudaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    protected $service;

    public function __construct() {
        $this->service = new WisudaService();
    }

    public function pendaftaran() {
        $nim = session('profile')['nim'];
        $skripsiDiajukan = $this->service->getJudulSkripsiDiajukanByMahasiswa($nim)->getData('data');

        return view('dashboard.mahasiswa.pendaftaran', [
            'data' => $skripsiDiajukan,
            'title' => 'Pendaftaran'
        ]);
    }

    public function detail() {
        $detailPengajuan = $this->service->getDetailPengajuanByMahasiswa(session('profile')['nim'])->getData('data');

        return view('dashboard.mahasiswa.detail', [
            'data' => $detailPengajuan,
            'title' => 'Detail'
        ]);
    }
    public function editDetail() {
        $detailPengajuan = $this->service->getDetailPengajuanByMahasiswa(session('profile')['nim'])->getData('data');
        // dd($detailPengajuan);
        return view('dashboard.mahasiswa.edit_detail', [
            'data' => $detailPengajuan,
            'title' => 'Detail'
        ]);
    }

    public function store(Request $request)
    {
        // File processing
        $fileKTP = $request->file('ktp');
        $fileBuktiPembayaran = $request->file('bukti_pembayaran');
        $fileBuktiSumbangan = $request->file('bukti_pembayaran_sumbangan');
        $fileijazah = $request -> file('file_ijazah');
    
        // Hash file names
        $hashedFileKTP = Str::random(32) . '.' . $fileKTP->getClientOriginalExtension();
        $hashedFileBuktiPembayaran = Str::random(32) . '.' . $fileBuktiPembayaran->getClientOriginalExtension();
        $hashedFileBuktiSumbangan = Str::random(32) . '.' . $fileBuktiSumbangan->getClientOriginalExtension();
        $hashedfileijazah = Str::random(32) . '.' . $fileijazah->getClientOriginalExtension();
    
        // Store files
        $pathFileKTP = $fileKTP->storeAs('uploads', $hashedFileKTP, 'public');
        $pathFileBuktiPembayaran = $fileBuktiPembayaran->storeAs('uploads', $hashedFileBuktiPembayaran, 'public');
        $pathFileBuktiSumbangan = $fileBuktiSumbangan->storeAs('uploads', $hashedFileBuktiSumbangan, 'public');
        $pathFileijazah = $fileijazah->storeAs('uploads', $hashedfileijazah, 'public');
    
        // Payload data
        $payload = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir)->format('d-m-Y'),
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'file_ijazah' => $pathFileijazah,
            'tgl_sidang_akhir' => Carbon::createFromFormat('Y-m-d', $request->tanggal_sidang_akhir)->format('d-m-Y'),
            'file_bukti_pembayaran' => $pathFileBuktiPembayaran,
            'file_ktp' => $pathFileKTP,
            'file_bukti_pembayaran_sumbangan' => $pathFileBuktiSumbangan,
            'judul_skripsi' => $request->judul_skripsi,  
        ];
        
        // Call service to add data
        $this->service->addPengajuanByMahasiswa($payload);
    
        // Redirect to detail page
        return redirect()->route('pendaftaran.detail');
    }
    public function update(Request $request, $pengajuan)
    {   
        $nim = $request->nim;


        $fileKTP = $request->file('ktp');
        $fileBuktiPembayaran = $request->file('bukti_pembayaran');
        $fileBuktiSumbangan = $request->file('bukti_pembayaran_sumbangan');
        $fileijazah = $request -> file('file_ijazah');
    
        // Hash file names
        $hashedFileKTP = 'Edit'.Str::random(32) . '.' . $fileKTP->getClientOriginalExtension();
        $hashedFileBuktiPembayaran = 'Edit'.Str::random(32) . '.' . $fileBuktiPembayaran->getClientOriginalExtension();
        $hashedFileBuktiSumbangan = 'Edit'.Str::random(32) . '.' . $fileBuktiSumbangan->getClientOriginalExtension();
        $hashedfileijazah = 'Edit'.Str::random(32) . '.' . $fileijazah->getClientOriginalExtension();
    
        // Store files
        $pathFileKTP = $fileKTP->storeAs('uploads', $hashedFileKTP, 'public');
        $pathFileBuktiPembayaran = $fileBuktiPembayaran->storeAs('uploads', $hashedFileBuktiPembayaran, 'public');
        $pathFileBuktiSumbangan = $fileBuktiSumbangan->storeAs('uploads', $hashedFileBuktiSumbangan, 'public');
        $pathFileijazah = $fileijazah->storeAs('uploads', $hashedfileijazah, 'public');
    
        // Payload data
        $payload = [
            'pengajuan_id' => $pengajuan,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir)->format('d-m-Y'),
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'file_ijazah' => $pathFileijazah,
            'tgl_sidang_akhir' => Carbon::createFromFormat('Y-m-d', $request->tanggal_sidang_akhir)->format('d-m-Y'),
            'file_bukti_pembayaran' => $pathFileBuktiPembayaran,
            'file_ktp' => $pathFileKTP,
            'file_bukti_pembayaran_sumbangan' => $pathFileBuktiSumbangan,
            'judul_skripsi' => $request->judul_skripsi,  
            'is_verified' => false
        ];
        
        // Call service to add data
        $this->service->editPengajuanByMahasiswa($payload,$nim);


    
        // Redirect to detail page
        return redirect('/detail');
    }
}    