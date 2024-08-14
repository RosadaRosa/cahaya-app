<?php

class PenjualanModel extends CI_Model
{
    private $tabel = "penjualan";


    public function get_data()
    {
        $data = $this->db->query("SELECT penjualan.*, pelanggan.*, merk.*,barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli, barang.harga_jual AS hrg_jual, kategori.*, user.* FROM penjualan 
        JOIN pelanggan ON penjualan.id_pelanggan=pelanggan.id_pelanggan 
        JOIN barang ON penjualan.id_barang=barang.id_barang
        JOIN merk ON barang.id_merk=merk.id_merk
        JOIN user ON user.id_user=penjualan.penambah
        JOIN kategori ON barang.id_kategori=kategori.id_kategori
        WHERE penjualan.status = 'Selesai'");

        return $data->result();
    }

    public function get_data_report($dari_tanggal = NULL, $sampai_tanggal = NULL) 
    { 
        $this->db->select('penjualan.*, pelanggan.*, merk.*,barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli, barang.harga_jual AS hrg_jual, kategori.*, user.*'); 
        $this->db->from('penjualan'); 
 
        // Filter berdasarkan tanggal jika tanggal disertakan 
        if ($dari_tanggal !== NULL && $sampai_tanggal !== NULL) { 
            $this->db->where('penjualan.tanggal_input >=', $dari_tanggal); 
            $this->db->where('penjualan.tanggal_input <=', $sampai_tanggal); 
        } else { 
            // Jika tidak ada rentang tanggal disertakan, gunakan filter tahun ini 
            $this->db->where('penjualan.tanggal_input >=', date('Y-01-01')); 
            $this->db->where('penjualan.tanggal_input <=', date('Y-12-31')); 
        } 
 
        // // Filter berdasarkan kategori jika kategori disertakan 
        // if ($id_kategori !== NULL) { 
        //     $this->db->where('penjualan.id_kategori', $id_kategori); 
        // } 
 
        $this->db->join('pelanggan', 'penjualan.id_pelanggan = pelanggan.id_pelanggan'); 
        $this->db->join('barang', 'penjualan.id_barang = barang.id_barang'); 
        $this->db->join('user', 'user.id_user = penjualan.penambah'); 
        $this->db->join('kategori', 'barang.id_kategori = kategori.id_kategori'); 
        $this->db->join('merk', 'barang.id_merk = merk.id_merk'); 
        $this->db->where('penjualan.status = "Selesai"'); 
        $query = $this->db->get(); 
 
        return $query->result(); 
    }

    public function get_data_draf()
    {
        $data = $this->db->query("SELECT penjualan.*, pelanggan.*, merk.*,barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli, barang.harga_jual, kategori.*, user.* FROM penjualan 
        JOIN pelanggan ON penjualan.id_pelanggan=pelanggan.id_pelanggan 
        JOIN barang ON penjualan.id_barang=barang.id_barang
        JOIN merk ON barang.id_merk=merk.id_merk
        JOIN user ON user.id_user=penjualan.penambah
        JOIN kategori ON barang.id_kategori=kategori.id_kategori
        WHERE penjualan.status = 'Pending'");

        return $data->result();
    }

    public function get_data_byid($id_penjualan)
    {
        $this->db->select('penjualan.*, pelanggan.nama_pelanggan');
        $this->db->from($this->tabel);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left');
        $this->db->where('penjualan.id_penjualan', $id_penjualan);
        return $this->db->get()->row();
    }

    public function save_data()
    {
        $this->db->trans_start();

        try {
            $status = $this->input->post('status', true);

            $data_penjualan = [
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'id_barang' => implode('"', $this->input->post('id_barang', true)),
                'jumlah' => implode('"', $this->input->post('jumlah', true)),
                'harga_jual' => implode('"', $this->input->post('harga_jual', true)),
                'diskon' => $this->input->post('diskon', true),
                'total' => $this->input->post('total', true),
                'bayar' => $this->input->post('bayar', true),
                'kembalian' => $this->input->post('kembalian', true),
                'status' => $status,
                'tanggal_input' => date('Y-m-d H:i:s'),
                'penambah' => $this->session->userdata('id_user')
            ];

            $this->db->insert($this->tabel, $data_penjualan);
            $id_penjualan = $this->db->insert_id();

            if ($status === 'Selesai') {
                // Update stock only if the status is 'Selesai'
                $id_barang_array = $this->input->post('id_barang', true);
                $jumlah_array = $this->input->post('jumlah', true);

                foreach ($id_barang_array as $index => $id_barang) {
                    $jumlah = $jumlah_array[$index];
                    $this->db->set('stok', 'stok - ' . $jumlah, FALSE);
                    $this->db->where('id_barang', $id_barang);
                    $this->db->update('barang');
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Database transaction failed");
            }

            return $id_penjualan;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error in save_data: ' . $e->getMessage());
            return false;
        }
    }


    public function save_data_draf()
    {
        // Validasi input
        if (empty($this->input->post('id_pelanggan')) || empty($this->input->post('total'))) {
            log_message('error', 'Penjualan gagal: Data pelanggan atau total kosong');
            return false;
        }

        $id_pelanggan = $this->input->post('id_pelanggan', true);
        $diskon = $this->input->post('diskon', true);
        $total = $this->input->post('total', true);
        $id_barang_array = $this->input->post('id_barang', true);
        $jumlah_array = $this->input->post('jumlah', true);
        $harga_jual_array = $this->input->post('harga_jual', true);


        if (!is_array($id_barang_array) || !is_array($jumlah_array) || !is_array($harga_jual_array)) {
            log_message('error', 'Penjualan gagal: Data barang tidak valid');
            return false;
        }

        // Proses data seperti sebelumnya
        $id_barang_string = implode('"', $id_barang_array);
        $jumlah_string = implode('"', $jumlah_array);
        $harga_jual_string = implode('"', $harga_jual_array);

        $data_penjualan = [
            'id_pelanggan' => $this->input->post('id_pelanggan', true),
            'id_barang' => implode('"', $this->input->post('id_barang', true)),
            'jumlah' => implode('"', $this->input->post('jumlah', true)),
            'harga_jual' => implode('"', $this->input->post('harga_jual', true)),
            'diskon' => $this->input->post('diskon', true),
            'total' => $this->input->post('total', true),
            'status' => "Pending",
            'tanggal_input' => date('Y-m-d H:i:s'),
            'penambah' => $this->session->userdata('id_user')
        ];

        $this->db->insert($this->tabel, $data_penjualan);
        return $this->db->affected_rows() > 0;
    }


    public function update_data($id_penjualan, $data)
{
    $this->db->where('id_penjualan', $id_penjualan);
    return $this->db->update($this->tabel, $data);

}

    public function delete_data($id_penjualan)
    {
        $this->db->delete($this->tabel, ['id_penjualan' => $id_penjualan]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Penjualan Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Penjualan Gagal Dihapus');
        }
    }

    public function get_sale_by_id($id_penjualan)
    {
        return $this->db->get_where('penjualan', ['id_penjualan' => $id_penjualan])->row();
    }

    public function get_sale_items($id_penjualan)
    {
        $this->db->select('barang.id_barang, barang.id_merk, penjualan.jumlah, barang.harga_jual, penjualan.diskon, penjualan.total, merk.merk, merk.bahan, merk.ukuran');
        $this->db->from('penjualan');
        $this->db->join('barang', 'penjualan.id_barang = barang.id_barang');
        $this->db->join('merk', 'barang.id_merk = merk.id_merk');
        $this->db->where('penjualan.id_penjualan', $id_penjualan);
        return $this->db->get()->result();
    }

    public function get_transaksi($id_penjualan)
    {
        $this->db->select('penjualan.*, pelanggan.nama_pelanggan, user.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'penjualan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('user', 'user.id_user = penjualan.penambah', 'left');
        $this->db->where('penjualan.id_penjualan', $id_penjualan);
        return $this->db->get()->row();
    }


    public function get_transaksi_items($id_penjualan)
    {
        // Ambil data penjualan
        $this->db->select('id_barang, jumlah, harga_jual');
        $this->db->from('penjualan');
        $this->db->where('id_penjualan', $id_penjualan);
        $penjualan = $this->db->get()->row();
    
        // Memproses data barang
        if ($penjualan) {
            // Pisahkan string yang dipisahkan dengan tanda kutip
            $id_barang_array = explode('"', $penjualan->id_barang);
            $jumlah_array = explode('"', $penjualan->jumlah);
            $harga_jual_array = explode('"', $penjualan->harga_jual);
    
            $items = [];
            foreach ($id_barang_array as $index => $id_barang) {
                if (!empty($id_barang)) {
                    // Ambil data barang
                    $this->db->select('barang.*, merk.*, kategori.*');
                    $this->db->from('barang');
                    $this->db->join('merk', 'barang.id_merk = merk.id_merk', 'left');
                    $this->db->join('kategori', 'barang.id_kategori = kategori.id_kategori', 'left');
                    $this->db->where('barang.id_barang', $id_barang);
                    $barang = $this->db->get()->row();
    
                    $items[] = [
                        'barang' => $barang,
                        'jumlah' => isset($jumlah_array[$index]) ? $jumlah_array[$index] : 0,
                        'harga_jual' => isset($harga_jual_array[$index]) ? $harga_jual_array[$index] : 0
                    ];
                }
            }
            
            return $items;
        } else {
            return [];
        }
    }
    


    public function getJumlahPenjualan()
    {
        return $this->db->count_all('penjualan');
    }


    public function get_items($id_penjualan)
    {
        $this->db->select('b.nama_barang, pi.jumlah, pi.harga_jual, pi.total');
        $this->db->from('penjualan_item pi');
        $this->db->join('barang b', 'b.id_barang = pi.id_barang');
        $this->db->where('pi.id_penjualan', $id_penjualan);
        return $this->db->get()->result();
    }
}
