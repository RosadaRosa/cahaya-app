<?php

class Responden extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/

    public function __construct()
    {
        parent::__construct();
        $this->load->model('RespondenModel');
    }


    public function index()
    {
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('RespondenModel');  //mengambil function di function get_data
        $data['responden'] = $this->RespondenModel->get_data();
        $data['title'] = "SIMAHAR-APP | Responden";
        $data['peran'] = $peran;
        $data['komoditas'] = $this->db->query("SELECT * FROM komoditas")->result();
        $data['bulanNamaData'] = $this->RespondenModel->getBulanNamaData();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('perta/responden_tampil', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        if (isset($_POST['simpan'])) {
            $this->load->model('RespondenModel');
            $this->RespondenModel->save_data();
            redirect('responden');
        } else {
            $data['peran'] = $peran;
            $data['title'] = "SIMAHAR-APP | Responden";
            $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('perta/responden_tambah', $data); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_responden)
    {
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('RespondenModel');
        if (isset($_POST['simpan'])) {
            $this->RespondenModel->update_data($id_responden);
            redirect('responden');
        } else {
            $data['peran'] = $peran;
            $data['responden'] = $this->RespondenModel->get_data_byid($id_responden);
            $data['title'] = "SIMAHAR-APP | Perbaharui Data Perikanan Tangkap";
            $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('perta/responden_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_responden)
    {
        $this->load->model('RespondenModel');
        $this->RespondenModel->delete_data($id_responden);
        redirect('responden');
    }


    public function filterData()
    {
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['peran'] = $peran;
        $filterValue = $this->input->post('filterresponden');


        // Panggil model dengan parameter filter
        $data['responden'] = $this->RespondenModel->getFilteredData($filterValue);

        $data['title'] = "SIMAHAR-APP | Laporan Perikanan Tangkap";
        $data['komoditas'] = $this->db->query("SELECT * FROM komoditas")->result();
        $data['bulanNamaData'] = $this->RespondenModel->getBulanNamaData();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('perta/responden_tampil', $data);
        $this->load->view('template/footer');
    }
}
