<?php

class Labarugi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenjualanModel');
        $this->load->model('PembelianModel');
        $this->load->model('PengeluaranModel');
        $this->load->model('BarangModel');
        $this->load->model('MerkModel');
    }

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $dari_tanggal  = $this->input->post('dari_tanggal'); 
        $sampai_tanggal = $this->input->post('sampai_tanggal'); 
        $data['level'] = $level;
        $this->load->model('LabarugiModel');  //mengambil function di function get_data
        $data['penjualan'] = $this->PenjualanModel->get_data_report($dari_tanggal,$sampai_tanggal);
        $data['pembelian'] = $this->PembelianModel->get_data_report($dari_tanggal,$sampai_tanggal);
        $data['barang'] = $this->BarangModel->get_data();
        $data['pengeluaran'] = $this->PengeluaranModel->get_data_report($dari_tanggal,$sampai_tanggal);
        $data['dari_tanggal'] = $dari_tanggal; 
        $data['sampai_tanggal'] = $sampai_tanggal;
        $data['title'] = "CAHAYA-APP | Barang";
        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/labarugi', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function fungsi_pengambilan_data()
    {
        $idmerk = $this->input->post('id_merk');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_merk dari database
        $data = $this->db->query("SELECT merk.* FROM merk WHERE id_merk = ?", array($idmerk))->row_array();

        echo json_encode($data);
    }

    // public function verify($id_barang)
    // {
    //     // Check if the user has the right level or permission to verify 
    //     // For example, you can check if the user is an admin (level 1) 
    //     $this->load->model('LabarugiModel');
    //     $level = $this->session->userdata('level');

    //     // Update the verification status in the database 
    //     $this->LabarugiModel->verify_data($id_barang, $level);

    //     // Redirect or show a success message 
    //     redirect('barang');
    // }

    // public function reject_with_note($id_barang)
    // {
    //     $this->load->model('LabarugiModel');
    //     $level = $this->session->userdata('level');
    //     $rejectionNote = $this->input->post('rejectionNote');

    //     $this->LabarugiModel->reject_data_with_note($id_barang, $level, $rejectionNote);
    //     redirect('barang');
    // }
}
