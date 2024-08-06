<?php
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Mendapatkan nilai 'level' dari sesi 
        $level = $this->session->userdata('level');

        $this->load->model('PenjualanModel');
        $this->load->model('PembelianModel');
        $this->load->model('TerlarisModel');

        // Setelah mendapatkan nilai 'level', cek apakah pengguna sudah login dengan level yang valid 
        if ($level != '1' && $level != '2') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
            <strong>Anda belum login!</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">&times;</span> 
            </button> 
            </div>');
            redirect('login');
        }
    }

    public function index()
    {
        // Check if user is logged in and get the role
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level; // Pass the role to the view
        $data['jumlah_penjualan'] = $this->PenjualanModel->getJumlahPenjualan();
        $data['jumlah_pembelian'] = $this->PembelianModel->getJumlahPembelian();
        $data['monthly_data'] = $this->TerlarisModel->get_monthly_sales();

        $data['title'] = "CAHAYA-APP | Dashboard";

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data); // Pass $data to the sidebar
        $this->load->view('dashboard/dashboard_view', $data);
        $this->load->view('template/footer');
    }
}
