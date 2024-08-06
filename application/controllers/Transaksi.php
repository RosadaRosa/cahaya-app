<?php

class Transaksi extends CI_Controller
{

    //url CI = localhost/nama folder project/nama controller/Nama function/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenjualanModel');
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

        $this->load->model('PenjualanModel');  //mengambil function di function get_data
        $data['penjualan'] = $this->PenjualanModel->get_data();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['pelanggan'] =  $this->PelangganModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Penjualan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/transaksi_tampil', $data); //controller ngambil data dari model dikirimkan ke view
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
            $this->load->model('PenjualanModel');
            $this->PenjualanModel->save_data();
            redirect('penjualan');
        } else {
            $data['level'] = $level; // Pass the role to the view
            $data['barang'] = $this->BarangModel->get_data();
            $data['pelanggan'] = $this->PelangganModel->get_data();

            $data['title'] = "CAHAYA-APP | Tambah Data Penjualan";

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/transaksi_tampil', $data); //controller ngambil data dari model dikirimkan ke view
            $this->load->view('template/footer');
        }
    }

    public function ubah($id_penjualan)
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            redirect('login');
        }

        if (isset($_POST['update'])) {
            $this->PenjualanModel->update_data($id_penjualan);
            redirect('transaksi/index');
        } else {

            $data['level'] = $level;
            $data['penjualan'] = $this->PenjualanModel->get_data_byid($id_penjualan);
            $data['barang'] = $this->BarangModel->get_data();
            $data['pelanggan'] = $this->PelangganModel->get_data();
            $data['merk'] =  $this->MerkModel->get_data();

            // Tambahkan ini untuk memastikan id_pelanggan tersedia di view
            $data['selected_pelanggan'] = $this->PelangganModel->get_by_id($data['penjualan']->id_pelanggan);

            // Get sale items for this penjualan
            $data['penjualan_items'] = $this->PenjualanModel->get_sale_items($id_penjualan);

            $processed_items = [];
            foreach ($data['penjualan_items'] as $item) {
                $barang = "{$item->merk} - {$item->bahan} - {$item->ukuran}";
                $processed_items[] = [
                    'barang' => $barang, // Concatenate merk, bahan, and ukuran here
                    'jumlah' => intval($item->jumlah),
                    'harga_jual' => intval($item->harga_jual),
                    'total' => intval($item->jumlah) * intval($item->harga_jual)
                ];
            }

            $data['penjualan']->id_barang_array = explode('"', $data['penjualan']->id_barang);
            $data['penjualan']->jumlah_array = explode('"', $data['penjualan']->jumlah);
            $data['penjualan']->harga_jual_array = explode('"', $data['penjualan']->harga_jual);

            $data['processed_items'] = json_encode($processed_items);

            $data['title'] = "CAHAYA-APP | Perbaharui Data Penjualan";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('transaksi/draf_edit', $data);
            $this->load->view('template/footer');
        }
    }    

    public function hapus($id_penjualan)
    {
        $this->load->model('PenjualanModel');
        $this->PenjualanModel->delete_data($id_penjualan);
        redirect('penjualan');
    }

    public function fungsi_pengambilan_data()
    {
        $idbarang = $this->input->post('id_barang');

        // Gantilah ini dengan logika pengambilan data sesuai dengan id_barang dari database
        $data = $this->db->query("SELECT barang.* FROM barang WHERE id_barang = ?", array($idbarang))->row_array();

        echo json_encode($data);
    }

    public function get_sale_data($id_penjualan)
    {
        $sale = $this->PenjualanModel->get_sale_by_id($id_penjualan);
        $sale_items = $this->PenjualanModel->get_sale_items($id_penjualan);

        $data = [
            'id_penjualan' => $sale->id_penjualan,
            'id_pelanggan' => $sale->id_pelanggan,
            'tanggal_input' => $sale->tanggal_input,
            'total_bayar' => $sale->total,
            'items' => $sale_items
        ];

        echo json_encode($data);
    }

    public function save()
    {
        $this->output->set_content_type('application/json');
        $result = $this->PenjualanModel->save_data();

        if ($result) {
            $this->output->set_output(json_encode(['status' => true, 'message' => 'Transaksi berhasil disimpan']));
        } else {
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Transaksi gagal disimpan. Silakan cek log untuk detailnya.']));
        }
    }

    public function edit($id_penjualan)
    {
        $this->output->set_content_type('application/json');

        $id_barang = $this->input->post('id_barang');
        $jumlah = $this->input->post('jumlah');
        $harga_jual = $this->input->post('harga_jual');

        $data = [
            'id_pelanggan' => $this->input->post('id_pelanggan'),
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'harga_jual' => $harga_jual,
            'diskon' => $this->input->post('diskon'),
            'total' => $this->input->post('total'),
            'status' => $this->input->post('status')
        ];

        $result = $this->PenjualanModel->update_data($id_penjualan, $data);

        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Transaksi berhasil diubah'
            ]));
        } else {
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Transaksi gagal diubah. Silakan cek log untuk detailnya.']));
        }
    }

    private function save_data()
    {
        $this->output->set_content_type('application/json');
        $result = $this->PenjualanModel->save_data();

        if ($result) {
            $this->output->set_output(json_encode(['status' => true, 'message' => 'Transaksi berhasil disimpan']));
        } else {
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Transaksi gagal disimpan. Silakan cek log untuk detailnya.']));
        }
    }

    private function savedraf()
    {
        $this->load->model('PenjualanModel');
        $result = $this->PenjualanModel->save_data_draf();

        if ($result) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['status' => true, 'message' => 'Draft saved successfully']));
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['status' => false, 'message' => 'Failed to save draft']));
        }
    }


    public function draf()
    {
        $level = $this->session->userdata('level');

        if (!$level) {
            // Redirect to login page if user is not logged in
            redirect('login');
        }
        $data['level'] = $level;

        $this->load->model('PenjualanModel');  //mengambil function di function get_data
        $data['penjualan'] = $this->PenjualanModel->get_data_draf();
        $data['barang'] = $this->BarangModel->get_data();
        $data['user'] = $this->UserModel->get_data();
        $data['pelanggan'] =  $this->PelangganModel->get_data();
        $data['merk'] =  $this->MerkModel->get_data();
        $data['title'] = "CAHAYA-APP | Penjualan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('transaksi/draf_tampil', $data); //controller ngambil data dari model dikirimkan ke view
        $this->load->view('template/footer');
    }

    public function get_struk() {
        $id_penjualan = $this->input->get('id_penjualan');
        
        // Ambil data transaksi dan item dari database
        $transaksi = $this->PenjualanModel->get_transaksi($id_penjualan);
        $items = $this->PenjualanModel->get_transaksi_items($id_penjualan);
        
        // Load view struk
        $data['transaksi'] = $transaksi;
        $data['items'] = $items;
        $this->load->view('struk', $data);
    }
}
