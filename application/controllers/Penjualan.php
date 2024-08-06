<?php

class Penjualan extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenjualanModel');
        $this->load->model('BarangModel');
        $this->load->model('PelangganModel');
        $this->load->model('UserModel');
        $this->load->model('MerkModel');
    }

    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $data['level'] = $level;

        $this->load->model('PenjualanModel');  //mengambil function di function get_data
        $data['penjualan'] = $this->PenjualanModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['pelanggan'] =  $this->PelangganModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Penjualan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/penjualan_tampil', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        if (isset($_POST['simpan'])) {
            $this->load->model('PenjualanModel');
            $this->PenjualanModel->save_data();
            redirect('penjualan');
        } else {
            $data['level'] = $level; // Pass the role to the view
            $data['barang'] = $this->BarangModel->get_data();
            $data['pelanggan'] = $this->PelangganModel->get_data();
           
            $data['title'] = "CAHAYA-APP | Tambah Data Penjualan";
            
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/penjualan_tambah', $data); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_penjualan)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $this->load->model('PenjualanModel');
        if (isset($_POST['simpan'])) {
            $this->PenjualanModel->update_data($id_penjualan);
            redirect('penjualan');
        } else {
            $data['level'] = $level; // Pass the role to the view
            $data['penjualan'] = $this->PenjualanModel->get_data_byid($id_penjualan);
            $data['barang'] = $this->db->query("SELECT * FROM barang");
            $data['pelanggan'] = $this->db->query("SELECT * FROM pelanggan");
            $data['merk'] = $this->db->query("SELECT * FROM merk");
            $data['title'] = "CAHAYA-APP | Perbaharui Data Hotel";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/penjualan_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_penjualan)
    {
        $this->load->model('PenjualanModel');
        $this->PenjualanModel->delete_data($id_penjualan);
        redirect('penjualan');
    }

    public function fungsi_pengambilan_data()
    {
        $idbarang = $this->input->post('id_barang');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_barang dari database
        $data = $this->db->query("SELECT barang.* FROM barang WHERE id_barang = ?", array($idbarang))->row_array();

        echo json_encode($data);
    }

    public function get_sale_data($id_penjualan) {
        $sale = $this->PenjualanModel->get_sale_by_id($id_penjualan);
        $sale_items = $this->PenjualanModel->get_sale_items($id_penjualan);
    
        $data = [
            'id_penjualan' => $sale->id_penjualan,
            'id_pelanggan' => $sale->id_pelanggan,
            'tanggal_input' => $sale->tanggal_input,
            'total_bayar' => $sale->total,
            'items' => $sale_items
        ];
    
        echo json_encode($data);
    }

}
