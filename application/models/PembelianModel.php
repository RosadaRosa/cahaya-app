<?php

class PembelianModel extends CI_Model
{
    private $tabel = "pembelian";

    public function get_data()
    {
        $data = $this->db->query("SELECT pembelian.*, suplier.*, merk.*, barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli AS hrg
        , barang.harga_jual, kategori.*, user.* FROM pembelian 
        JOIN suplier ON pembelian.id_suplier=suplier.id_suplier 
      
        JOIN barang ON pembelian.id_barang=barang.id_barang
        JOIN merk ON barang.id_merk=merk.id_merk
        JOIN user ON user.id_user=pembelian.penambah
        JOIN kategori ON barang.id_kategori=kategori.id_kategori");
        return $data->result();
    }

    public function get_data_report($dari_tanggal = NULL, $sampai_tanggal = NULL)
    {
        $this->db->select('pembelian.*, suplier.*, merk.*, barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli AS hrg
        , barang.harga_jual, kategori.*, user.*');
        $this->db->from('pembelian');

        // Filter berdasarkan tanggal jika tanggal disertakan 
        if ($dari_tanggal !== NULL && $sampai_tanggal !== NULL) {
            $this->db->where('pembelian.tanggal_input >=', $dari_tanggal);
            $this->db->where('pembelian.tanggal_input <=', $sampai_tanggal);
        } else {
            // Jika tidak ada rentang tanggal disertakan, gunakan filter tahun ini 
            $this->db->where('pembelian.tanggal_input >=', date('Y-01-01'));
            $this->db->where('pembelian.tanggal_input <=', date('Y-12-31'));
        }

        // // Filter berdasarkan kategori jika kategori disertakan 
        // if ($id_kategori !== NULL) { 
        //     $this->db->where('pembelian.id_kategori', $id_kategori); 
        // } 

        $this->db->join('suplier', 'pembelian.id_suplier = suplier.id_suplier');
        $this->db->join('barang', 'pembelian.id_barang = barang.id_barang');
        $this->db->join('user', 'user.id_user = pembelian.penambah');
        $this->db->join('kategori', 'barang.id_kategori = kategori.id_kategori');
        $this->db->join('merk', 'barang.id_merk = merk.id_merk');
        $query = $this->db->get();

        return $query->result();
    }



    public function get_data_byid($id_pembelian)
    {
        $this->db->select('pembelian.*, suplier.nama_suplier');
        $this->db->from($this->tabel);
        $this->db->join('suplier', 'pembelian.id_suplier = suplier.id_suplier', 'left');
        $this->db->where('pembelian.id_pembelian', $id_pembelian);
        return $this->db->get()->row();
    }

    public function save_data()
    {
        $this->db->trans_start();

        try {
            // Retrieve form inputs
            $id_suplier = $this->input->post('id_suplier', true);
            $total = $this->input->post('total', true);
            $id_barang_array = json_decode($this->input->post('id_barang', true));
            $jumlah_array = json_decode($this->input->post('jumlah', true));
            $harga_beli_array = json_decode($this->input->post('harga_beli', true));

            // File upload configuration
            $config['upload_path'] = './bukti/'; // specify your upload folder
            $config['allowed_types'] = '*'; // specify allowed file types
            $config['max_size'] = 10240; // specify max file size in KB

            $this->load->library('upload', $config);

            // Check if file is selected for upload
            if (!empty($_FILES['bukti']['name'])) {
                if ($this->upload->do_upload('bukti')) {
                    $upload_data = $this->upload->data();
                    $bukti_file_name = $upload_data['file_name']; // save file name
                } else {
                    throw new Exception('File upload failed: ' . $this->upload->display_errors());
                }
            } else {
                throw new Exception('No file selected for upload');
            }

            // Prepare data for insertion
            $id_barang_string = implode('"', $id_barang_array);
            $jumlah_string = implode('"', $jumlah_array);
            $harga_beli_string = implode('"', $harga_beli_array);

            $data_pembelian = [
                'id_suplier' => $id_suplier,
                'id_barang' => $id_barang_string,
                'jumlah' => $jumlah_string,
                'harga_beli' => $harga_beli_string,
                'total' => $total,
                'bukti' => $bukti_file_name,
                'tanggal_input' => date('Y-m-d H:i:s'),
                'penambah' => $this->session->userdata('id_user')
            ];

            // Insert the purchase data
            $this->db->insert($this->tabel, $data_pembelian);

            // Update stock for each item
            foreach ($id_barang_array as $index => $id_barang) {
                $jumlah = $jumlah_array[$index];

                $this->db->where('id_barang', $id_barang);
                $barang = $this->db->get('barang')->row();

                if ($barang) {
                    $new_stok = $barang->stok + $jumlah;
                    $this->db->where('id_barang', $id_barang);
                    $this->db->update('barang', ['stok' => $new_stok]);
                }
            }

            // Complete transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Pembelian Gagal Ditambahkan');
            } else {
                return ['status' => true, 'message' => 'Pembelian Berhasil Ditambahkan'];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }




    public function update_data($id_pembelian)
    {
        $data = [
            'id_suplier' => $this->input->post('id_suplier', true),
            'id_barang' => $this->input->post('id_barang', true),
            'jumlah' => $this->input->post('jumlah', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'total' => $this->input->post('total', true),
            'tanggal_input' => date('Y-m-d H:i:s')
        ];
        $this->db->update($this->tabel, $data, ['id_pembelian' => $id_pembelian]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pembelian Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pembelian Gagal Diperbaharui');
        }
    }

    public function delete_data($id_pembelian)
    {
        $this->db->delete($this->tabel, ['id_pembelian' => $id_pembelian]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pembelian Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pembelian Gagal Dihapus');
        }
    }

    public function verify_data($id_pembelian, $peran)
    {
        if ($peran == "pengawas") {
            $this->db->where('id_pembelian', $id_pembelian);
            $this->db->update('hotel_hal1', array('status' => 0));
        } else {
            // Handle unauthorized access 
            show_error('Unauthorized access', 403);
        }
    }

    public function reject_data_with_note($id_pembelian, $peran, $rejectionNote)
    {
        if ($peran == "pengawas") {
            $this->db->where('id_pembelian', $id_pembelian);
            $this->db->update('hotel_hal1', array('status' => $rejectionNote));
        } else {
            // Handle unauthorized access 
            show_error('Unauthorized access', 403);
        }
    }

    public function getFilteredHotelHal1($bulanFilter, $namaFilter)
    {
        // Sesuaikan query berdasarkan kebutuhan filter
        $query = "SELECT * FROM hotel_hal1 JOIN hotel ON hotel.id_hotel = hotel_hal1.id_hotel WHERE 1 = 1";

        // Tambahkan filter berdasarkan bulan jika bulanFilter tidak kosong
        if (!empty($bulanFilter)) {
            $query .= " AND bulan = '$bulanFilter'";
        }

        // Tambahkan filter berdasarkan nama_hotel jika namaFilter tidak kosong
        if (!empty($namaFilter)) {
            $query .= " AND nama_hotel = ?";
        }

        // Jalankan query dengan menggunakan parameterized statement
        $data = $this->db->query($query, array($namaFilter));

        return $data->result();
    }

    public function getJumlahPembelian()
    {
        return $this->db->count_all('pembelian');
    }
}
