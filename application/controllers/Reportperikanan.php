<?php

class Reportperikanan extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReportpertaModel');
    }

    public function index()
    {
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['peran'] = $peran;
        $data['title'] = "SIMAHAR-APP | Laporan Perikanan Tangkap";

        // Ambil semua data bulan dan nama dari perta1
        $data['bulanNamaData'] = $this->ReportpertaModel->getBulanNamaData();

        $data['perta1'] = $this->ReportpertaModel->get_data_perta_hal1();
        $data['perta2'] = $this->ReportpertaModel->get_data_perta_hal2();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/perikanan');
        $this->load->view('template/footer');
    }


    public function filterData()
    {
        $filterValue = $this->input->post('filterPertahal1');

        // Pastikan nilai filter tidak kosong sebelum memanggil model
        $peran = $this->session->userdata('peran');

        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        if (!empty($filterValue)) {
            $data['peran'] = $peran;
            // Panggil model dengan parameter filter
            $data['perta1'] = $this->ReportpertaModel->getFilteredDataPertaHal1($filterValue);
            $data['perta2'] = $this->ReportpertaModel->getFilteredDataPertaHal2($filterValue);

            $data['title'] = "SIMAHAR-APP | Laporan Perikanan Tangkap";
            $data['bulanNamaData'] = $this->ReportpertaModel->getBulanNamaData();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/perikanan');
            $this->load->view('template/footer');
        } else {
            // Handle case when filterValue is empty
            // You may redirect to another page or display an error message
            echo "Invalid filter value";
        }
    }
}
