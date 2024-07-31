<?php

namespace App\Models;

use App\Models\MyWebService;

class WisudaService extends MyWebService
{
    /**
     * Untuk melihat contoh format payload dan penjelasan lebih lanjut,
     * kunjungi web dokumentasi API STMIK Bandung.
     * Kemudian, pada navbar pilih Web -> Pengajuan Wisuda.
     */
    public function __construct() {
        parent::__construct('wisuda');
    }

    /**
     * Digunakan untuk mendapatkan judul skripsi diajukan pada SIKPS
     * * Target role: mahasiswa
     */
    public function getJudulSkripsiDiajukanByMahasiswa(string $nim) {
        return $this->get(null, "/pengajuan/skripsi/$nim");
    }

    /**
     * Digunakan untuk mengirim pengajuan pendaftaran wisuda oleh mahasiswa
     * * Target role: mahasiswa
     */
    public function addPengajuanByMahasiswa(array $payload) {
        return $this->post($payload, '/pengajuan');
    }

    /**
     * Digunakan untuk mendapatkan detail pengajuan mahasiswa yang login
     *  * Target role: mahasiswa
     */
    public function getDetailPengajuanByMahasiswa(string $nim) {
        return $this->get(null, "/pengajuan/$nim");
    }

    /**
     * Digunakan untuk mendapatkan status pengajuan pendaftaran mahasiswa yang login
     * * Target role: mahasiswa
     */
    public function getDetailStatusPengajuanByMahasiswa(string $nim) {
        return $this->get(null, "/pengajuan/$nim/status");
    }

    /**
     * Digunakan untuk edit pengajuan oleh mahasiswa
     * Mengedit pengajuan akan membuat status pengajuan mahasiswa menjadi menunggu
     * * Target role: mahasiswa
     */
    public function editPengajuanByMahasiswa(array $payload, string $nim) {
        return $this->put($payload, "/pengajuan/$nim/update");
    }

    /**
     * Digunakan untuk get jadwal wisuda yang sedang aktif
     * * Target role: mahasiswa
     */
    public function getJadwalWisudaAktifByMahasiswa() {
        return $this->get(null, '/pengajuan/jadwal/aktif');
    }

    /**
     * Digunakan untuk get semua pengajuan pendaftaran wisuda
     * * Target role: admin
     */
    public function getAllPengajuanMahasiswaByAdmin() {
        return $this->get(null, '/pengajuan/list/pendaftar');
    }

    /**
     * Digunakan untuk get daftar pengajuan yang diterima
     * dan dapat menggunakan filter tahun wisuda
     * * Target role: admin
     */
    public function getListPengajuanDiterimaByAdmin(string $tahun) {
        $query = '/pengajuan/list/pendaftar?kd_status=S';

        return $this->get(null, $query . ($tahun ? "&tahun=$tahun" : ''));
    }

    /**
     * Digunakan untuk get list status yang disediakan
     * * Target role: admin
     */
    public function getListStatusTersediaByAdmin() {
        return $this->get(null, '/pengajuan/list/status-tersedia');
    }

    /**
     * Digunakan untuk get detail pengajuan milik mahasiswa berdasarkan nim
     * * Target role: admin
     */
    public function getDetailPengajuanByAdmin(string $nim) {
        return $this->get(null, "/pengajuan/detail/$nim");
    }

    /**
     * Digunakan untuk edit data pengajuan milik mahasiswa oleh admin
     * * Target role: admin
     */
    public function editPengajuanMahasiswaByAdmin(array $payload, string $nim) {
        return $this->put($payload, "/pengajuan/$nim/update-by-admin");
    }

    /**
     * Digunakan untuk mendapatkan angka total pengajuan pendaftaran wisuda yang diterima
     * * Target role: admin
     */
    public function getStatistikPengajuanByAdmin() {
        return $this->get(null, '/pengajuan/statistik/pendaftaran');
    }

    /**
     * Digunakan untuk verifikasi pengajuan mahasiswa oleh admin
     * * Target role: admin
     */
    public function verifikasiPengajuanByAdmin(array $payload, string $nim) {
        return $this->post($payload, "/pengajuan/$nim/verifikasi");
    }
    public function verifikasiPengajuanByMahasiswa(array $payload) {
        return $this->post($payload, "/pengajuan/verifikasi");
    }

    /**
     * Digunakan untuk get list jadwal dan angkatan wisuda
     * * Target role: admin
     */
    public function getAllJadwalAngkatanWisudaByAdmin() {
        return $this->get(null, '/pengajuan/list/jadwal');
    }

    /**
     * Digunakan untuk add jadwal wisuda baru
     * * Target role: admin
     */
    public function addJadwalAngkatanWisudaByAdmin(array $payload) {
        return $this->post($payload, '/pengajuan/jadwal/add');
    }

    /**
     * Digunakan untuk edit jadwal dan angkatan wisuda
     * * Target role: admin
     */
    public function editJadwalAngkatanWisudaByAdmin(array $payload, string $tahun) {
        return $this->put($payload, "/pengajuan/jadwal/$tahun/update");
    }

    /**
     * Digunakan untuk get jadwal dan angkatan wisuda aktif saat ini
     * * Target role: admin
     */
    public function getJadwalAngkatanWisudaAktifByAdmin() {
        return $this->get(null, '/pengajuan/list/jadwal?aktif=true');
    }

    /**
     * Digunakan untuk menghapus jadwal wisuda berdasarkan tahun
     * * Target role: admin
     */
    public function hapusJadwalAngkatanWisudaByAdmin(array $payload) {

        if (is_null($payload)) {
            throw new \InvalidArgumentException("Parameter 'tahun' tidak boleh null.");
        }
        return $this->delete($payload, "/pengajuan/jadwal/delete");
    }
    
}
