<?php

class Returnbarang extends CI_Controller

{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReturnbarangModel');
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
        $this->load->model('ReturnbarangModel');  //mengambil function di function get_data
        $data['returnbarang'] = $this->ReturnbarangModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['pelanggan'] =  $this->PelangganModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | return";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/returnbarang_tampil', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('ReturnbarangModel');
            $this->ReturnbarangModel->save_data();
            redirect('returnbarang');
        } else {
            $data['level'] = $level;
            $data['barang'] = $this->BarangModel->get_data();
            $data['user'] = $this->UserModel->get_data();
            $data['pelanggan'] =  $this->PelangganModel->get_data();
            $data['merk'] =  $this->MerkModel->get_data();
            $data['title'] = "CAHAYA-APP | Tambah Data return";
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            // $data['perta_hal1'] = $this->db->query("SELECT * FROM perta_hal1");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/returnbarang_tambah', $data);
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_returnbarang)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('ReturnbarangModel');
        if (isset($_POST['simpan'])) {
            $this->ReturnbarangModel->update_data($id_returnbarang);
            redirect('returnbarang');
        } else {
            $data['level'] = $level;
            $data['returnbarang'] = $this->ReturnbarangModel->get_data_byid($id_returnbarang);
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            $data['title'] = "CAHAYA-APP | Perbaharui Data return";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/returnbarang_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_returnbarang)
    {
        $this->load->model('ReturnbarangModel');
        $this->ReturnbarangModel->delete_data($id_returnbarang);
        redirect('returnbarang');
    }

    // public function fungsi_pengambilan_data()
    // {
    //     $idKomoditas = $this->input->post('id_komoditas');

    //     // Gantilah ini dengan logika pengambilan data sesuai dengan id_komoditas dari database
    //     $data = $this->db->query("SELECT kualitas, satuan, kode_kualitas FROM komoditas WHERE id_komoditas = ?", array($idKomoditas))->row_array();

    //     echo json_encode($data);
    // }

    // public function verify($id_returnbarang)
    // {
    //     // Check if the user has the right level or permission to verify 
    //     // For example, you can check if the user is an admin (level 1) 
    //     $this->load->model('ReturnbarangModel');
    //     $level = $this->session->userdata('level');

    //     // Update the verification status in the database 
    //     $this->ReturnbarangModel->verify_data($id_returnbarang, $level);

    //     // Redirect or show a success message 
    //     redirect('return');
    // }

    // public function reject_with_note($id_returnbarang)
    // {
    //     $this->load->model('ReturnbarangModel');
    //     $level = $this->session->userdata('level');
    //     $rejectionNote = $this->input->post('rejectionNote');

    //     $this->ReturnbarangModel->reject_data_with_note($id_returnbarang, $level, $rejectionNote);
    //     redirect('return');
    // }

    // public function resetFilter()
    // {
    //     // Hapus nilai filter dari sesi atau atur nilainya ke default jika diperlukan
    //     $this->session->unset_userdata('filterBulan');
    //     $this->session->unset_userdata('filterNama');
    //     $this->session->unset_userdata('filterKomoditas');
    //     // Redirect kembali ke halaman dengan data tanpa filter
    //     redirect('return/index');
    // }

    // public function filterData()
    // {
    //     // Ambil nilai dari filterBulan dan filterNama
    //     $filterBulan = $this->input->post('filterBulan');
    //     $filterNama = $this->input->post('filterNama');
    //     $filterKomoditas = $this->input->post('filterKomoditas');

    //     // Set nilai filter ke sesi untuk digunakan nanti
    //     $this->session->set_userdata('filterBulan', $filterBulan);
    //     $this->session->set_userdata('filterNama', $filterNama);
    //     $this->session->set_userdata('filterKomoditas', $filterKomoditas);

    //     $level = $this->session->userdata('level');

    //     if (!$level) {
    //         // Redirect to login page if user is not logged in
    //         redirect('login');
    //     }

    //     $data['level'] = $level;
    //     $data['title'] = "CAHAYA-APP | Hotel";

    //     // Panggil model dengan parameter filter
    //     $filterBulanSession = $this->session->userdata('filterBulan');
    //     $filterNamaSession = $this->session->userdata('filterNama');
    //     $filterKomoditasSession = $this->session->userdata('filterKomoditas');
    //     $data['return'] = $this->ReturnbarangModel->getFilteredPertaHal2($filterBulanSession, $filterNamaSession,  $filterKomoditasSession);

    //     // Pass the selected filter value back to the view
    //     $data['selectedFilterBulan'] = $filterBulanSession;
    //     $data['selectedFilterNama'] = $filterNamaSession;
    //     $data['selectedFilterKomoditas'] = $filterKomoditasSession;

    //     $this->load->view('template/header', $data);
    //     $this->load->view('template/sidebar', $data);
    //     $this->load->view('perta/halaman2_tampil', $data);
    //     $this->load->view('template/footer');
    // }
}
