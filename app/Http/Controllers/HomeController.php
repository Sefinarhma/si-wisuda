<?php

namespace App\Http\Controllers;

use App\Models\WisudaService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $service;

    public function __construct() {
        $this->service = new WisudaService();
    }

    public function index() {
        $data = null;

        if (isset(session('role')['is_admin'])) {
            /**
             * jika yang login adalah admin maka get statistik pengajuan
             */
            $data = $this->service->getStatistikPengajuanByAdmin()->getData('data');
        } else {
            /**
             * jika yang login adalah mahasiswa maka get status pengajuannya
             */
            $nim = session('profile')['nim'];
            $data = $this->service->getDetailStatusPengajuanByMahasiswa($nim)->getData('data');
        }

        return view('dashboard.home', [
            'data' => $data,
            'title' => 'Home'
        ]);
    }
}
