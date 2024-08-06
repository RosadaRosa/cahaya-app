<?php

class Terlaris extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('TerlarisModel');
        $this->load->model('PenjualanModel');
        $this->load->model('BarangModel');
        $this->load->model('MerkModel');
        $this->load->model('KategoriModel');
    }

    public function get_merk_details()
    {
        $id_merk = $this->input->post('id_merk');
        $data = $this->TerlarisModel->get_merk_details($id_merk);
        echo json_encode($data);
    }

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function index()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $selected_month = $this->input->get('month') ? $this->input->get('month') : date('n');
        $selected_year = $this->input->get('year') ? $this->input->get('year') : date('Y');

        // Ambil data barang terlaris
        $terlaris = $this->TerlarisModel->get_monthly_data($selected_month, $selected_year);

        // Hitung total penjualan per bulan hanya untuk barang terlaris
        $monthly_data = [];
        foreach ($terlaris as $item) {
            $month = date('F', strtotime($item->tanggal_input));
            if (!isset($monthly_data[$month])) {
                $monthly_data[$month] = 0;
            }
            $monthly_data[$month] += $item->total_terjual;
        }

        // Konversi ke format yang dibutuhkan oleh Chart.js
        $chart_data = [];
        foreach ($monthly_data as $month => $total) {
            $chart_data[] = [
                'month' => $month,
                'total_terjual' => $total
            ];
        }

        // Kirim data ke view
        $data['monthly_data'] = $chart_data;

        $month = $this->input->get('month') ? $this->input->get('month') : null;
        $year = $this->input->get('year') ? $this->input->get('year') : null;

        $data['level'] = $level;
        $this->load->model('TerlarisModel');  //mengambil function di function get_data
        $data['terlaris'] = $this->TerlarisModel->get_data($month, $year);
        $data['monthly_data'] = $this->TerlarisModel->get_monthly_data($year);
        $data['selected_month'] = $month;
        $data['selected_year'] = $year;
        $data['penjualan'] = $this->PenjualanModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['kategori'] = $this->KategoriModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Barang";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/terlaris', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }



    public function fungsi_pengambilan_data()
    {
        $idmerk = $this->input->post('id_merk');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_merk dari database
        $data = $this->db->query("SELECT merk.* FROM merk WHERE id_merk = ?", array($idmerk))->row_array();

        echo json_encode($data);
    }
}
