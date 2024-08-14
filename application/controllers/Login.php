<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('LoginModel');
    }
    public function index()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Halaman Login";
            $this->load->view('login/login_view', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $cek = $this->LoginModel->cek_login($username, $password);

            if ($cek == FALSE) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                <strong>Username atau Password Salah!</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">&times;</span> 
                </button> 
                </div>');
                redirect('login');
            } else {
                $this->session->set_userdata('level', $cek->level);
                $this->session->set_userdata('id_user', $cek->id_user);
                $this->session->set_userdata('alamat', $cek->alamat);
                $this->session->set_userdata('telepon', $cek->telepon);
                $this->session->set_userdata('nama_lengkap', $cek->nama_lengkap);
                switch ($cek->level) {
                    case "1":
                        redirect('Dashboard');
                        break;
                    case "2":
                        redirect('Dashboard');
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
    }

    // public function index()
    // {
    //     if (isset($_POST['btn_login'])) {
    //         $cek_login = $this->LoginModel->cek_login();
    //         //memanggil fungsi cek_login di LoginModel. cek_login() akan mengirimkan array $return dan array tersebut ditampung di $cek_login
    //         if ($cek_login['status'] == true) { //cek data status dari array $cek_login. jika benar maka login berhasil
    //             //membuat array $data yang digunakan untuk membuat session
    //             $data = [
    //                 'id' => $cek_login['data_login']->id, //membuat session id dari array $cek_login 
    //                 'peran' => $cek_login['data_login']->peran, //membuat session peran dari array $cek_login 
    //                 'nama' => $cek_login['nama_lengkap'] //membuat session nama dari array $cek_login 

    //             ];
    //             //buat session. membuat session dengan CI mengguna set_userdata
    //             $this->session->set_userdata($data);
    //             redirect('dashboard'); //mengarahkan halaman ke controller home
    //         } else {
    //             $this->session->set_flashdata('pesan', $cek_login['pesan']);
    //             $this->session->set_flashdata('status', false);
    //             redirect('login');
    //         }
    //     } else {
    //         $data['title'] = "Halaman Login | Manajemen";
    //         $this->load->view('login/login_view', $data);
    //     }
    // }
}

/* End of file Login.php and path \application\controllers\Login.php */
