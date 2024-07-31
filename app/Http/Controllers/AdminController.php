<?php

namespace App\Http\Controllers;

use App\Models\WisudaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;


class AdminController extends Controller
{
    protected $service;

    public function __construct() {
        $this->service = new WisudaService();
    }

    public function tabel() {
        $listPengajuan = $this->service->getAllPengajuanMahasiswaByAdmin()->getData('data');
        return view('dashboard.admin.tabel', [
            'title' => 'Tabel',
            'data' => $listPengajuan,
        ]);
    }
    
    public function verifikasi(Request $request)
    {
        $nim = $request->nim;
        // dd($nim);

        // Payload yang diperlukan untuk verifikasi
        $payload = [
            'is_bayar' => true, // Misal, 1 berarti terverifikasi
            'pengajuan_id' => $request->pengajuan_id,
            'nim' => $nim
            
        ];

        // Panggil metode verifikasi dari service
        $response = $this->service->verifikasiPengajuanByAdmin($payload,$nim)->getData('data');

        // dd($response);


        if ($response['status'] == 'success') {
        return redirect()->back()->with('success','Verifikasi Berhasil');
        }
        return response()->json(['status' => 'error', 'message' => 'Pengajuan tidak ditemukan atau gagal diverifikasi']);
    }

    public function verifikasiMahasiswa(Request $request)
    {
        // Payload yang diperlukan untuk verifikasi
        $payload = [
            'is_verified' => true, // Misal, 1 berarti terverifikasi
            'pengajuan_id' => $request->pengajuan_id,
        ];

        // Panggil metode verifikasi dari service
        $response = $this->service->verifikasiPengajuanByMahasiswa($payload)->getData('data');

        // dd($response);


        if ($response['status'] == 'success') {
        return redirect('/home')->with('success','Verifikasi Berhasil');
        }
        return response()->json(['status' => 'error', 'message' => 'Pengajuan tidak ditemukan atau gagal diverifikasi']);
    }

    public function rekap() {
        $Jadwal = $this->service->getAllJadwalAngkatanWisudaByAdmin()->getData('data');
        $listJadwal = $Jadwal['data']['jadwal_wisuda'];
       return view('dashboard.admin.rekap', [
            'title' => 'Rekap',
            'jadwal' =>$listJadwal,
        ]);
    }

    public function rekapByTahun($tahun){
        $listPengajuanDiterima = $this->service->getListPengajuanDiterimaByAdmin($tahun)->getData('data');
        $data = $listPengajuanDiterima['data']['list_pengajuan'];
        // dd($data);
        return $data;
        
    }

    public function jadwal() {
        $listJadwal = $this->service->getAllJadwalAngkatanWisudaByAdmin()->getData('data');
        // dd($listJadwal);

        return view('dashboard.admin.jadwal', [
            'title' => 'Jadwal Wisuda',
            'data' => $listJadwal,
        ]);
    }

    public function tambahjadwal(Request $request)
    {
        $listJadwal = $this->service->getAllJadwalAngkatanWisudaByAdmin()->getData('2024');
        // dd($listJadwal['data']['jadwal_wisuda']);
        $cek ='';
        foreach ($listJadwal['data']['jadwal_wisuda'] as $key => $value) {
            if ($value['tahun'] == $request->tahun) {
                $cek=1;
            }
        }
        // dd($cek);
        if ($cek == 1) {
            $createdAt = Carbon::parse($request->tgl_wisuda);
            $tahun = $request->tahun;
            $payload = [
            'angkatan_wisuda' => $request->angkatan_wisuda,
            'tgl_wisuda' => $createdAt->format('d-m-Y'),
        ];
             $response = $this->service->editJadwalAngkatanWisudaByAdmin($payload,$tahun);
        }elseif($cek == ''){
            $createdAt = Carbon::parse($request->tgl_wisuda);
            $payload = [
                'angkatan_wisuda' => $request->angkatan_wisuda,
                'tgl_wisuda' => $createdAt->format('d-m-Y'),
                'tahun' => $request->tahun,
            ];
            $response = $this->service->addJadwalAngkatanWisudaByAdmin($payload);
        }
        return redirect('/jadwal');

    }

    public function hapusjadwal(Request $request)
    { 
        
        $payload = [
        'jadwal_wisuda_id' => $request->jadwalId,
    ];
        $response = $this->service->hapusJadwalAngkatanWisudaByAdmin($payload);
        // dd($response);

        if ($response->getData('status') == 'success') {
            return redirect('/jadwal')->with('success', 'Jadwal berhasil dihapus');
        }
        return redirect('/jadwal')->with('error', 'Gagal menghapus jadwal');
    }
    public function exportExcel(Request $request)
{
    $tahun = $request->query('tahun');
    $response = $this->service->getListPengajuanDiterimaByAdmin($tahun)->getData('data');
    $data = $response['data']['list_pengajuan'];

    $filePath = storage_path("app/public/rekap_{$tahun}.xlsx");
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile($filePath);

    $header = WriterEntityFactory::createRowFromArray([
        'NIM', 'Nama', 'Jurusan', 'Tanggal Wisuda', 'Tanggal Lahir', 'NIK', 'Tanggal Sidang Akhir', 'Tempat Lahir', 'Email', 'Nomor Handphone', 'Judul Skripsi', 'Bukti Pembayaran', 'KTP', 'Bukti Pembayaran Sumbangan', 'Ijazah'
    ]);
    $writer->addRow($header);

    foreach ($data as $item) {
        if ($item['kd_jur'] == 12) {
            $jurusan = 'TEKNIK INFORMATIKA';
        } else {
            $jurusan = 'SISTEM INFORMASI';
        }
        
        $row = WriterEntityFactory::createRowFromArray([
            $item['nim'], 
            $item['nama'], 
            $jurusan,
            $item['tgl_wisuda'],
            $item['tgl_lahir'], 
            $item['nik'], 
            $item['tgl_sidang_akhir'], 
            $item['tempat_lahir'], 
            $item['email'], 
            $item['no_hp'], 
            $item['judul_skripsi'], 
            "http://localhost:8000/storage/".$item['file_bukti_pembayaran'], 
            "http://localhost:8000/storage/".$item['file_ktp'], 
            "http://localhost:8000/storage/".$item['file_bukti_pembayaran_sumbangan'], 
            "http://localhost:8000/storage/".$item['file_ijazah'] 
        ]);
        $writer->addRow($row);
    }

    $writer->close();

    return response()->download($filePath);
}
}
