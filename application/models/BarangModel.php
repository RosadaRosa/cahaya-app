<?php

class BarangModel extends CI_Model
{
    private $tabel = "barang";

    public function get_data()
    {
        $this->db->select('barang.*, kategori.*, merk.*, suplier.*');
        $this->db->from('barang');
        $this->db->join('kategori', 'barang.id_kategori = kategori.id_kategori');
        $this->db->join('merk', 'barang.id_merk = merk.id_merk');
        $this->db->join('suplier', 'barang.id_suplier = suplier.id_suplier');
        $query = $this->db->get();
        return $query->result();
    }


    public function getJumlahData()
    {
        return $this->db->count_all($this->tabel);
    }


    public function get_data_byid($id_barang)
    {
        return $this->db->get_where($this->tabel, ['id_barang' => $id_barang])->row();
    }

    public function save_data()
    {
        // Mengambil data dari form
        $data = [
            'id_kategori' => $this->input->post('id_kategori', true),
            'id_merk' => $this->input->post('id_merk', true),
            'id_suplier' => $this->input->post('id_suplier', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'harga_jual' => $this->input->post('harga_jual', true),
            'setelah_diskon' => $this->input->post('harga_jual', true)

        ];



        // Menyimpan data ke dalam database
        $this->db->insert($this->tabel, $data);

        // Memeriksa apakah penyimpanan berhasil atau tidak
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', ' Data Barang Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', ' Data Barang Gagal Ditambahkan');
        }
    }


    public function update_data($id_barang)
    {
        $data = [
            'id_kategori' => $this->input->post('id_kategori', true),
            'id_merk' => $this->input->post('id_merk', true),
            'id_suplier' => $this->input->post('id_suplier', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'harga_jual' => $this->input->post('harga_jual', true)
        ];
        $this->db->update($this->tabel, $data, ['id_barang' => $id_barang]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', ' Data Barang Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', ' Data Barang Gagal Diperbaharui');
        }
    }

    public function delete_data($id_barang)
    {
        $this->db->delete($this->tabel, ['id_barang' => $id_barang]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', ' Data Barang Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', ' Data Barang Gagal Dihapus');
        }
    }

    public function get_merk_details($id_merk)
    {
        $this->db->select('merk, bahan, ukuran');
        $this->db->from($this->tabel);
        $this->db->where('id_merk', $id_merk);
        return $this->db->get()->row_array();
    }
    
    public function apply_discount($id_barang, $diskon, $harga_setelah_diskon)
{
    $data = [
        'setelah_diskon' => $harga_setelah_diskon
    ];

    $this->db->where('id_barang', $id_barang);
    $this->db->update($this->tabel, $data);

    return $this->db->affected_rows() > 0;
}

    // public function verify_data($id_barang, $peran)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_barang', $id_barang);
    //         $this->db->update('barang', array('status' => 0));
    //     } else {
    //         // Handle unauthorized access 
    //         show_error('Unauthorized access', 403);
    //     }
    // }

    // public function reject_data_with_note($id_barang, $peran, $rejectionNote)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_barang', $id_barang);
    //         $this->db->update('barang', array('status' => $rejectionNote));
    //     } else {
    //         // Handle unauthorized access 
    //         show_error('Unauthorized access', 403);
    //     }
    // }
}
