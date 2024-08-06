<?php

class Reporthotel extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReporthotelModel');
    }

    public function index()
    {

        $peran = $this->session->userdata('peran');
        if (!$peran) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }

        $data['peran'] = $peran;
        $data['title'] = "SIMAHAR-APP | Laporan Hotel";

        // Ambil semua data bulan dan nama dari perta1
        $data['bulanNamaData'] = $this->ReporthotelModel->getBulanNamaData();

        $data['hotel1'] = $this->ReporthotelModel->get_data_hotel_hal1();
        $data['hotel2'] = $this->ReporthotelModel->get_data_hotel_hal2();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/hotel', $data);
        $this->load->view('template/footer');
    }


    public function filterData()
    {
        $filterValue = $this->input->post('filterHotelhal1');

        // Pastikan nilai filter tidak kosong sebelum memanggil model
        if (!empty($filterValue)) {

            $peran = $this->session->userdata('peran');

            if (!$peran) {
                // Redirect to login page if user is not logged in
                redirect('login');
            }

            $data['peran'] = $peran;
            // Panggil model dengan parameter filter
            $data['hotel1'] = $this->ReporthotelModel->getFilteredDataHotelHal1($filterValue);
            $data['hotel2'] = $this->ReporthotelModel->getFilteredDataHotelHal2($filterValue);

            $data['title'] = "SIMAHAR-APP | Laporan Hotel";
            $data['bulanNamaData'] = $this->ReporthotelModel->getBulanNamaData();

            // Pass the selected filter value back to the view
            $data['selectedFilter'] = $filterValue;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/hotel', $data);
            $this->load->view('template/footer');
        } else {
            // Handle case when filterValue is empty
            // You may redirect to another page or display an error message
            echo "Invalid filter value";
        }
    }

    public function resetFilter()
    {
        // Hapus nilai filter dari sesi atau atur nilainya ke default jika diperlukan
        $this->session->unset_userdata('filterHotelhal1');
        // Redirect kembali ke halaman dengan data tanpa filter
        redirect('Reporthotel/index');
    }

    // public function print_data($filterValue = null)
    // {
    //     // Cek peran pengguna
    //     $peran = $this->session->userdata('peran');

    //     if (!$peran) {
    //         // Redirect ke halaman login jika pengguna tidak login
    //         redirect('login');
    //     }

    //     if (!empty($filterValue)) {
    //         // Panggil model dengan parameter filter
    //         $data['hotel1'] = $this->ReporthotelModel->getFilteredDataHotelHal1($filterValue);
    //         $data['hotel2'] = $this->ReporthotelModel->getFilteredDataHotelHal2($filterValue);
    //         $data['bulanNamaData'] = $this->ReporthotelModel->getBulanNamaData();

    //         // ...

    //         // Tampilkan informasi filter pada judul
    //         $data['title'] = "SIMAHAR-APP | Laporan Hotel - Bulan: " . $filterValue;

    //         // Kirim nilai filter ke tampilan
    //         $data['selectedFilter'] = $filterValue;

    //         // Muat tampilan untuk mencetak data
    //         $this->load->view('print/print_hotel', $data);
    //     } else {
    //         // Jika filterValue kosong, redirect atau tampilkan pesan kesalahan
    //         redirect('error_page'); // Gantilah 'error_page' dengan halaman yang sesuai
    //     }
    // }

}
