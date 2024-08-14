<?php

class Pembelian extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['PembelianModel', 'BarangModel', 'SuplierModel', 'UserModel', 'MerkModel']);
    }


    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level;
        $this->load->model('PembelianModel');  //mengambil function di function get_data
        $data['pembelian'] = $this->PembelianModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['suplier'] =  $this->SuplierModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Pembelian";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/pembelian_tampil', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function report()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level;
        $this->load->model('PembelianModel');  //mengambil function di function get_data
        $data['pembelian'] = $this->PembelianModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['suplier'] =  $this->SuplierModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Pembelian";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/laporanpembelian', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('PembelianModel');
            $this->PembelianModel->save_data();
            redirect('pembelian');
        } else {
            $data['level'] = $level;
            $data['pembelian'] = $this->PembelianModel->get_data();
            $data['barang'] = $this->BarangModel->get_data();
            $data['suplier'] =  $this->SuplierModel->get_data();

            $data['title'] = "CAHAYA-APP | Tambah Data Pembelian";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/pembelian_tambah', $data); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function save()
    {
        // Pastikan semua output adalah JSON
        $this->output->set_content_type('application/json');

        // Tangkap semua output yang mungkin terjadi
        ob_start();

        try {
            $result = $this->PembelianModel->save_data(); // Hanya memanggil save_data tanpa memproses ID

            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Transaksi berhasil disimpan'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Transaksi gagal disimpan. Silakan cek log untuk detailnya.'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }

        // Bersihkan output buffer
        ob_end_clean();

        // Kirimkan respons dalam format JSON
        echo json_encode($response);
    }


    public function ubah($id_pembelian)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $this->load->model('PembelianModel');
        if (isset($_POST['simpan'])) {
            $this->PembelianModel->update_data($id_pembelian);
            redirect('pembelian');
        } else {
            $data['level'] = $level;
            $data['pembelian'] = $this->PembelianModel->get_data_byid($id_pembelian);
            $data['barang'] = $this->BarangModel->get_data();
            $data['user'] = $this->UserModel->get_data();
            $data['suplier'] =  $this->SuplierModel->get_data();
            $data['merk'] =  $this->MerkModel->get_data();
            $data['title'] = "CAHAYA-APP | Perbaharui Data Pembelian";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/pembelian_ubah', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id_pembelian)
    {
        $this->load->model('PembelianModel');
        $this->PembelianModel->delete_data($id_pembelian);
        redirect('pembelian');
    }

    public function fungsi_pengambilan_data()
    {
        $idbarang = $this->input->post('id_barang');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_barang dari database
        $data = $this->db->query("SELECT barang.id_merk, barang.harga_beli AS hrg FROM barang WHERE id_barang = ?", array($idbarang))->row_array();

        echo json_encode($data);
    }

    public function fungsi_pengambilan()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->db->get_where('barang', ['id_barang' => $id_barang])->row();
        
        if ($barang) {
            echo json_encode(['hrg' => $barang->hrg]);
        } else {
            echo json_encode(['error' => 'Barang tidak ditemukan']);
        }
    }


    public function verify($id_pembelian)
    {
        // Check if the user has the right level or permission to verify 
        // For example, you can check if the user is an admin (level 1) 
        $this->load->model('PembelianModel');
        $level = $this->session->userdata('level');

        // Update the verification status in the database 
        $this->PembelianModel->verify_data($id_pembelian, $level);

        // Redirect or show a success message 
        redirect('pembelian');
    }

    public function reject_with_note($id_pembelian)
    {
        $this->load->model('PembelianModel');
        $level = $this->session->userdata('level');
        $rejectionNote = $this->input->post('rejectionNote');

        $this->PembelianModel->reject_data_with_note($id_pembelian, $level, $rejectionNote);
        redirect('pembelian');
    }

    public function resetFilter()
    {
        // Hapus nilai filter dari sesi atau atur nilainya ke default jika diperlukan
        $this->session->unset_userdata('filterBulan');
        $this->session->unset_userdata('filterNama');
        // Redirect kembali ke halaman dengan data tanpa filter
        redirect('pembelian/index');
    }

    public function filterData()
    {
        // Ambil nilai dari filterBulan dan filterNama
        $filterBulan = $this->input->post('filterBulan');
        $filterNama = $this->input->post('filterNama');

        // Set nilai filter ke sesi untuk digunakan nanti
        $this->session->set_userdata('filterBulan', $filterBulan);
        $this->session->set_userdata('filterNama', $filterNama);

        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['level'] = $level;
        $data['title'] = "CAHAYA-APP | Pembelian";

        // Panggil model dengan parameter filter
        $filterBulanSession = $this->session->userdata('filterBulan');
        $filterNamaSession = $this->session->userdata('filterNama');
        $data['pembelian'] = $this->PembelianModel->getFilteredHotelHal2($filterBulanSession, $filterNamaSession);

        // Pass the selected filter value back to the view
        $data['selectedFilterBulan'] = $filterBulanSession;
        $data['selectedFilterNama'] = $filterNamaSession;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/pembelian_tampil', $data);
        $this->load->view('template/footer');
    }
}
