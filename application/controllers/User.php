<?php

class User extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
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
        $this->load->model('UserModel');  //mengambil function di function get_data
        $data['User'] = $this->UserModel->get_data();
        $data['title'] = "CAHAYA-APP | Data User";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('user/tampil_data', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('UserModel');
            $this->UserModel->save_data();
            redirect('User');
        } else {
            $data['level'] = $level;
            $data['title'] = "CAHAYA-APP | Tambah Data User";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('user/tambah_data'); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_user)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('UserModel');
        if (isset($_POST['simpan'])) {
            $this->UserModel->update_data($id_user);
            redirect('User');
        } else {
            $data['level'] = $level;
            $data['User'] = $this->UserModel->get_data_byid($id_user);
            $data['title'] = "SIMTAWA-APP | Perbaharui Data User Prestasi";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('user/ubah_data', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_user)
    {
        $this->load->model('UserModel');
        $this->UserModel->delete_data($id_user);
        redirect('user');
    }

    public function getById($id_user)
    {
        $this->load->model('UserModel');
        $user = $this->UserModel->get_data_byid($id_user);
        echo json_encode($user);
    }

    public function verify($id_user)
    {
        $this->load->model('UserModel');
        $level = $this->session->userdata('level');

        $this->UserModel->verify_data($id_user, $level);

        redirect('User');
    }

    public function reject($id_user)
    {
        $this->load->model('UserModel');
        $level = $this->session->userdata('level');

        $this->UserModel->reject_data($id_user, $level);
        redirect('User');
    }
}
