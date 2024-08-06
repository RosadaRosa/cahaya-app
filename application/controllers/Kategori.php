<?php

class Kategori extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level; // Pass the role to the view
        $this->load->model('KategoriModel');  //mengambil function di function get_data
        $data['kategori'] = $this->KategoriModel->get_data();
        $data['title'] = "CAHAYA-APP | Data Kategori";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('master/kategori_tambah', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        if (isset($_POST['simpan'])) {
            $this->load->model('KategoriModel');
            $this->KategoriModel->save_data();
            redirect('kategori');
        }
    }

    public function ubah($id_kategori)
    {
        $this->load->model('KategoriModel');
        if (isset($_POST['simpan'])) {
            $this->KategoriModel->update_data($id_kategori);
            redirect('kategori');
        } else {
            $level = $this->session->userdata('level');

            if (!$level) {
                // Redirect to login page if user is not logged in
                redirect('login');
            }

            $data['kategori'] = $this->KategoriModel->get_data_byid($id_kategori);
            $data['title'] = "CAHAYA-APP | Perbaharui Data Kategori";
            $data['level'] = $level; // Pass the role to the view
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('master/kategori_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_kategori)
    {
        $this->load->model('KategoriModel');
        $this->KategoriModel->delete_data($id_kategori);
        redirect('kategori');
    }
}
