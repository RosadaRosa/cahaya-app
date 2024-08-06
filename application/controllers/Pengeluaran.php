<?php

class Pengeluaran extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PengeluaranModel');
    }

    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $data['level'] = $level;
        $this->load->model('PengeluaranModel');  //mengambil function di function get_data
        $data['pengeluaran'] = $this->PengeluaranModel->get_data();
        $data['title'] = "CAHAYA-APP | pengeluaran";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/pengeluaran_tampil', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('PengeluaranModel');
            $this->PengeluaranModel->save_data();
            redirect('pengeluaran');
        } else {
            $data['level'] = $level;
            $data['title'] = "CAHAYA-APP | Tambah Data pengeluaran";
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            // $data['perta_hal1'] = $this->db->query("SELECT * FROM perta_hal1");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/pengeluaran_tambah', $data);
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_pengeluaran)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('PengeluaranModel');
        if (isset($_POST['simpan'])) {
            $this->PengeluaranModel->update_data($id_pengeluaran);
            redirect('pengeluaran');
        } else {
            $data['level'] = $level;
            $data['pengeluaran'] = $this->PengeluaranModel->get_data_byid($id_pengeluaran);
            // $data['komoditas'] = $this->db->query("SELECT * FROM komoditas");
            $data['title'] = "CAHAYA-APP | Perbaharui Data pengeluaran";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/pengeluaran_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_pengeluaran)
    {
        $this->load->model('PengeluaranModel');
        $this->PengeluaranModel->delete_data($id_pengeluaran);
        redirect('pengeluaran');
    }
    public function get_pengeluaran_data()
    {
        $this->load->model('PengeluaranModel');
        $data = $this->PengeluaranModel->get_data();
        echo json_encode($data);
    }

    // public function fungsi_pengambilan_data()
    // {
    //     $idKomoditas = $this->input->post('id_komoditas');

    //     // Gantilah ini dengan logika pengambilan data sesuai dengan id_komoditas dari database
    //     $data = $this->db->query("SELECT kualitas, satuan, kode_kualitas FROM komoditas WHERE id_komoditas = ?", array($idKomoditas))->row_array();

    //     echo json_encode($data);
    // }

    // public function verify($id_pengeluaran)
    // {
    //     // Check if the user has the right level or permission to verify 
    //     // For example, you can check if the user is an admin (level 1) 
    //     $this->load->model('PengeluaranModel');
    //     $level = $this->session->userdata('level');

    //     // Update the verification status in the database 
    //     $this->PengeluaranModel->verify_data($id_pengeluaran, $level);

    //     // Redirect or show a success message 
    //     redirect('pengeluaran');
    // }

    // public function reject_with_note($id_pengeluaran)
    // {
    //     $this->load->model('PengeluaranModel');
    //     $level = $this->session->userdata('level');
    //     $rejectionNote = $this->input->post('rejectionNote');

    //     $this->PengeluaranModel->reject_data_with_note($id_pengeluaran, $level, $rejectionNote);
    //     redirect('pengeluaran');
    // }

    // public function resetFilter()
    // {
    //     // Hapus nilai filter dari sesi atau atur nilainya ke default jika diperlukan
    //     $this->session->unset_userdata('filterBulan');
    //     $this->session->unset_userdata('filterNama');
    //     $this->session->unset_userdata('filterKomoditas');
    //     // Redirect kembali ke halaman dengan data tanpa filter
    //     redirect('transaksi/index');
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
    //     $data['pengeluaran'] = $this->PengeluaranModel->getFilteredPertaHal2($filterBulanSession, $filterNamaSession,  $filterKomoditasSession);

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
