<?php

class Prospek extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenjualanModel');
        $this->load->model('PembelianModel');
        $this->load->model('BarangModel');
        $this->load->model('PelangganModel');
        $this->load->model('UserModel');
        $this->load->model('MerkModel');
    }

    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            redirect('login');
        }
        $data['level'] = $level;

        $this->load->model('ProspekModel');
        $monthly_data = $this->ProspekModel->get_data();

        $processed_data = [];
        foreach ($monthly_data as $row) {
            $bulan = $row->bulan;
            if (!isset($processed_data[$bulan])) {
                $processed_data[$bulan] = [
                    'modal' => 0,
                    'penjualan' => 0
                ];
            }

            $id_barang_array = explode('"', $row->id_barang);
            $jumlah_array = explode('"', $row->jumlah);
            $harga_beli_array = explode(',', $row->harga_beli_list);

            $modal = 0;
            for ($i = 0; $i < count($id_barang_array); $i++) {
                if (isset($jumlah_array[$i]) && isset($harga_beli_array[$i])) {
                    $modal += $jumlah_array[$i] * $harga_beli_array[$i];
                }
            }

            $processed_data[$bulan]['modal'] += $modal;
            $processed_data[$bulan]['penjualan'] += $row->total;
        }

        $data['prospek'] = $processed_data;
        $data['title'] = "CAHAYA-APP | Penjualan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/laporanprospek', $data);
        $this->load->view('template/footer');
    }
}
