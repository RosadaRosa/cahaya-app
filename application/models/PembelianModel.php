<?php

class PembelianModel extends CI_Model
{
    private $tabel = "pembelian";

    public function get_data()
    {
        $data = $this->db->query("SELECT pembelian.*, suplier.*, merk.*, barang.id_kategori, barang.id_merk,
        barang.id_suplier, barang.harga_beli, barang.harga_jual, kategori.*, user.* FROM pembelian 
        JOIN suplier ON pembelian.id_suplier=suplier.id_suplier 
      
        JOIN barang ON pembelian.id_barang=barang.id_barang
        JOIN merk ON barang.id_merk=merk.id_merk
        JOIN user ON user.id_user=pembelian.penambah
        JOIN kategori ON barang.id_kategori=kategori.id_kategori");
        return $data->result();
    }

    

    public function get_data_byid($id_pembelian)
    {
        return $this->db->get_where($this->tabel, ['id_pembelian' => $id_pembelian])->row();
    }

    public function save_data()
    {
        $id_suplier = $this->input->post('id_suplier', true);
        $total = $this->input->post('total', true);
        $id_barang_array = $this->input->post('id_barang', true);
        $jumlah_array = $this->input->post('jumlah', true);

        // Mengubah array menjadi string dengan pemisah "
        $id_barang_string = implode('"', $id_barang_array);
        $jumlah_string = implode('"', $jumlah_array);

        $data_pembelian = [
            'id_suplier' => $id_suplier,
            'id_barang' => $id_barang_string,
            'jumlah' => $jumlah_string,
            'total' => $total,
            'tanggal_input' => date('Y-m-d H:i:s')
        ];

        // Menentukan nilai penambah berdasarkan id_pengguna pengguna
        $id_user = $this->session->userdata('id_user');
        $data_pembelian['penambah'] = $id_user;

        // Menyimpan data pembelian ke dalam database
        $this->db->insert($this->tabel, $data_pembelian);

        if ($this->db->affected_rows() > 0) {
            // Memperbarui stok barang
            foreach ($id_barang_array as $index => $id_barang) {
                $jumlah = $jumlah_array[$index];

                // Ambil stok barang saat ini
                $this->db->where('id_barang', $id_barang);
                $barang = $this->db->get('barang')->row();

                if ($barang) {
                    // Tambahkan jumlah pembelian ke stok saat ini
                    $new_stok = $barang->stok + $jumlah;

                    // Update stok barang di database
                    $this->db->where('id_barang', $id_barang);
                    $this->db->update('barang', ['stok' => $new_stok]);
                }
            }

            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pembelian Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pembelian Gagal Ditambahkan');
        }
    }


    public function update_data($id_pembelian)
    {
        $data = [
            'id_distributor' => $this->input->post('id_distributor', true),
            'id_barang' => $this->input->post('id_barang', true),
            'jumlah' => $this->input->post('jumlah', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'total' => $this->input->post('total', true),
            'tanggal_input' => $this->input->post('tanggal_input', true)
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

    public function getJumlahPembelian() {
        return $this->db->count_all('pembelian');
    }
}
