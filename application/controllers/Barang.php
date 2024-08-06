<?php

class Barang extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('BarangModel');
    }

    public function get_merk_details()
    {
        $id_merk = $this->input->post('id_merk');
        $data = $this->BarangModel->get_merk_details($id_merk);
        echo json_encode($data);
    }

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level;
        $this->load->model('BarangModel');  //mengambil function di function get_data
        $data['barang'] = $this->BarangModel->get_data();
        $data['kategori_list'] = $this->db->query("SELECT * FROM kategori")->result();
        $data['kategori'] = $this->db->query("SELECT * FROM kategori");
        $data['merk'] = $this->db->query("SELECT * FROM merk");
        $data['suplier'] = $this->db->query("SELECT * FROM suplier");
        $data['title'] = "CAHAYA-APP | Barang";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/barang_tampil', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('BarangModel');
            $this->BarangModel->save_data();
            redirect('barang');
        } else {
            $data['level'] = $level;
            $data['kategori'] = $this->db->query("SELECT * FROM kategori");
            $data['merk'] = $this->db->query("SELECT * FROM merk");
            $data['suplier'] = $this->db->query("SELECT * FROM suplier");
            $data['title'] = "CAHAYA-APP | Tambah Data Barang";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('gudang/barang_tambah', $data); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_barang)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('BarangModel');
        if (isset($_POST['simpan'])) {
            $this->BarangModel->update_data($id_barang);
            redirect('barang');
        } else {
            $data['level'] = $level;
            $data['barang'] = $this->BarangModel->get_data_byid($id_barang);
            $data['kategori'] = $this->db->query("SELECT * FROM kategori");
            $data['merk'] = $this->db->query("SELECT * FROM merk");
            $data['suplier'] = $this->db->query("SELECT * FROM suplier");
            $data['title'] = "CAHAYA-APP | Perbaharui Data barang";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('gudang/barang_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_barang)
    {
        $this->load->model('BarangModel');
        $this->BarangModel->delete_data($id_barang);
        redirect('barang');
    }

    public function fungsi_pengambilan_data()
    {
        $idmerk = $this->input->post('id_merk');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_merk dari database
        $data = $this->db->query("SELECT merk.* FROM merk WHERE id_merk = ?", array($idmerk))->row_array();

        echo json_encode($data);
    }

    public function terapkan_diskon()
{
    $id_barang = $this->input->post('id_barang');
    $diskon = $this->input->post('diskon');
    $harga_setelah_diskon = $this->input->post('harga_setelah_diskon');

    $this->load->model('BarangModel');
    $result = $this->BarangModel->apply_discount($id_barang, $diskon, $harga_setelah_diskon);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

    // public function verify($id_barang)
    // {
    //     // Check if the user has the right level or permission to verify 
    //     // For example, you can check if the user is an admin (level 1) 
    //     $this->load->model('BarangModel');
    //     $level = $this->session->userdata('level');

    //     // Update the verification status in the database 
    //     $this->BarangModel->verify_data($id_barang, $level);

    //     // Redirect or show a success message 
    //     redirect('barang');
    // }

    // public function reject_with_note($id_barang)
    // {
    //     $this->load->model('BarangModel');
    //     $level = $this->session->userdata('level');
    //     $rejectionNote = $this->input->post('rejectionNote');

    //     $this->BarangModel->reject_data_with_note($id_barang, $level, $rejectionNote);
    //     redirect('barang');
    // }
}
