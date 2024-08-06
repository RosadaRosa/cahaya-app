<?php

class Merk extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level;

        $this->load->model('MerkModel');  //mengambil function di function get_data
        $data['merk'] = $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Data Merk";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('master/merk_tambah', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        if (isset($_POST['simpan'])) {
            $this->load->model('MerkModel');
            $this->MerkModel->save_data();
            redirect('merk');
        }
    }

    public function ubah($id_merk)
    {
        $this->load->model('MerkModel');
        $level = $this->session->userdata('level');
        if (isset($_POST['simpan'])) {
            $this->MerkModel->update_data($id_merk);
            redirect('merk');

            $level = $this->session->userdata('level');

            if (!$level) {
                // Redirect to login page if user is not logged in
                redirect('login');
            }
        } else {
            $data['level'] = $level; // Pass the role to the view
            $data['merk'] = $this->MerkModel->get_data_byid($id_merk);
            $data['title'] = "CAHAYA-APP | Perbaharui Data merk";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('master/merk_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_merk)
    {
        $this->load->model('MerkModel');
        $this->MerkModel->delete_data($id_merk);
        redirect('merk');
    }
}
