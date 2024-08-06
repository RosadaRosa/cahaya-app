<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    private $tabel = "user";

    public function cek_login($username, $password)
    {
        $result = $this->db->where('username', $username)
            ->where('password', $password) 
            ->limit(1)
            ->get('user');

        if ($result->num_rows() > 0) {
            $user_data = $result->row();

            // Update terakhir_login 
            $this->db->where('id_user', $user_data->id_user)
                ->update('user', ['login_terakhir' => date('Y-m-d H:i:s')]);

            return $user_data;
        } else {
            return FALSE;
        }
    }






    // public function cek_login()
    // {
    //     $username = $this->input->post('username'); //mengambil nilai dari inputan username
    //     $password = $this->input->post('password'); //mengambil nilai dari inputan password lalu di enkripsi menggunakan md5    
    //     $cek = $this->db->get_where($this->tabel, ['username' => $username, 'password' => $password]);
    //     //mencari data pengguna berdasarkan username dan password yang diinput
    //     if ($cek->num_rows() > 0) { //jika menghasilkan baris lebih dari 0            
    //         $data_login = $cek->row(); //menampung data pengguna dari login yang berhasil ke variabel $data_login
    //         //cek keterangan akun di tabel pendaftaran pengguna berdasarkan pendaftaran id, apakah sudah diverifikasi atau belum            
    //         if ($data_login->keterangan == "Belum Diverifikasi" || $data_login->keterangan == "Akun Dibatalkan") {
    //             //membuat array bernama return dengan 2 data yaitu status dan pesan, 
    //             $return = ['status' => false, 'pesan' => 'Akun anda belum diverifikasi oleh Operator Kemahasiswaan'];
    //         } else {
    //             //membuat array bernama return dengan 3 data yaitu status, data_login dan nama_lengkap, 
    //             $return = ['status' => true, 'id' => $data_login->id, 'nama_lengkap' => $data_login->nama_lengkap];
    //         }
    //     } else {
    //         //membuat array bernama return dengan 2 data yaitu status dan pesan, 
    //         $return = ['status' => false, 'data_login' => '', 'pesan' => 'Username dan password tidak ditemukan di sistem!'];
    //     }
    //     //mengembalikan array $return ke pemanggil fungsi cek_login ini.
    //     return $return;
    // }
}


/* End of file LoginModel_model.php and path \application\models\LoginModel_model.php */
