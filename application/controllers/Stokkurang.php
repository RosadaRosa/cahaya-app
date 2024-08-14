<?php

class Stokkurang extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StokkurangModel');
        $this->load->model('KategoriModel');
    }

    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $data['level'] = $level;
        $this->load->model('StokkurangModel');  //mengambil function di function get_data
        $data['barang'] = $this->StokkurangModel->get_data();
        $data['kategori'] = $this->KategoriModel->get_data();
        $data['stok_kurang'] = $this->StokkurangModel->get_stok_kurang(); // Fetch low stock data
        $data['title'] = "CAHAYA-APP | stokkurang";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/stokkurang', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    
}
