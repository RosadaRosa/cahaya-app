<?php

class Pelanggan extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PelangganModel');
    }

    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $data['level'] = $level;
        $this->load->model('PelangganModel');  //mengambil function di function get_data
        $data['pelanggan'] = $this->PelangganModel->get_data();
        $data['title'] = "CAHAYA-APP | Pelanggan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('pelanggan/pelanggan_tampil', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('PelangganModel');
            $this->PelangganModel->save_data();
            redirect('pelanggan');
        } else {
            $data['level'] = $level;
            $data['title'] = "CAHAYA-APP | Tambah Data Pelanggan";
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            // $data['perta_hal1'] = $this->db->query("SELECT * FROM perta_hal1");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('pelanggan/pelanggan_tambah', $data);
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_pelanggan)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('PelangganModel');
        if (isset($_POST['simpan'])) {
            $this->PelangganModel->update_data($id_pelanggan);
            redirect('pelanggan');
        } else {
            $data['level'] = $level;
            $data['pelanggan'] = $this->PelangganModel->get_data_byid($id_pelanggan);
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            $data['title'] = "CAHAYA-APP | Perbaharui Data Pelanggan";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('pelanggan/pelanggan_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_pelanggan)
    {
        $this->load->model('PelangganModel');
        $this->PelangganModel->delete_data($id_pelanggan);
        redirect('pelanggan');
    }

    // public function fungsi_pengambilan_data()
    // {
    //     $idKomoditas = $this->input->post('id_komoditas');

    //     // Gantilah ini dengan logika pengambilan data sesuai dengan id_komoditas dari database
    //     $data = $this->db->query("SELECT kualitas, satuan, kode_kualitas FROM komoditas WHERE id_komoditas = ?", array($idKomoditas))->row_array();

    //     echo json_encode($data);
    // }

    // public function verify($id_pelanggan)
    // {
    //     // Check if the user has the right level or permission to verify 
    //     // For example, you can check if the user is an admin (level 1) 
    //     $this->load->model('PelangganModel');
    //     $level = $this->session->userdata('level');

    //     // Update the verification status in the database 
    //     $this->PelangganModel->verify_data($id_pelanggan, $level);

    //     // Redirect or show a success message 
    //     redirect('pelanggan');
    // }

    // public function reject_with_note($id_pelanggan)
    // {
    //     $this->load->model('PelangganModel');
    //     $level = $this->session->userdata('level');
    //     $rejectionNote = $this->input->post('rejectionNote');

    //     $this->PelangganModel->reject_data_with_note($id_pelanggan, $level, $rejectionNote);
    //     redirect('pelanggan');
    // }

    // public function resetFilter()
    // {
    //     // Hapus nilai filter dari sesi atau atur nilainya ke default jika diperlukan
    //     $this->session->unset_userdata('filterBulan');
    //     $this->session->unset_userdata('filterNama');
    //     $this->session->unset_userdata('filterKomoditas');
    //     // Redirect kembali ke halaman dengan data tanpa filter
    //     redirect('pelanggan/index');
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
    //     $data['pelanggan'] = $this->PelangganModel->getFilteredPertaHal2($filterBulanSession, $filterNamaSession,  $filterKomoditasSession);

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
