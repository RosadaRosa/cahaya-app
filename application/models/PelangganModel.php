<?php

class PelangganModel extends CI_Model
{
    private $tabel = "pelanggan";

    public function get_data()
    {

        return $this->db->get($this->tabel)->result();
    }

    public function getJumlahData()
    {
        return $this->db->count_all($this->tabel);
    }

    public function get_data_byid($id_pelanggan)
    {
        return $this->db->get_where($this->tabel, ['id_pelanggan' => $id_pelanggan])->row();
    }

    public function save_data()
    {
        $data = [
            'nama_pelanggan' => $this->input->post('nama_pelanggan', true),
            'alamat' => $this->input->post('alamat', true),
            'telepon' => $this->input->post('telepon', true),
            'email' => $this->input->post('email', true)
        ];


        // $id_pengguna = $this->session->userdata('id_pengguna');
        // $data['penambah'] = $id_pengguna;

        // $config['upload_path'] = './bukti/'; // specify your upload folder
        // $config['allowed_types'] = '*'; // specify allowed file types
        // $config['max_size'] = 10240; // specify max file size in KB

        // $this->load->library('upload', $config);

        // if ($this->upload->do_upload('bukti')) {
        //     $upload_data = $this->upload->data();
        //     $data['bukti'] = $upload_data['file_name']; // save file name to database
        // } else {
        //     $this->session->set_flashdata('status', false);
        //     $this->session->set_flashdata('pesan', 'File upload failed');
        //     // handle error if file upload fails
        // }

        // // Menyimpan data ke dalam database
        $this->db->insert($this->tabel, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pelanggan Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pelanggan Gagal Ditambahkan');
        }
    }


    public function update_data($id_pelanggan, $data)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->update($this->tabel, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data Pelanggan Berhasil Diperbarui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data Pelanggan Gagal Diperbarui');
        }
    }

    public function delete_data($id_pelanggan)
    {
        $this->db->delete($this->tabel, ['id_pelanggan' => $id_pelanggan]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pelanggan Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pelanggan Gagal Dihapus');
        }
    }

    public function get_by_id($id_pelanggan)
    {
        return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    }

    // public function verify_data($id_pelanggan, $peran)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_pelanggan', $id_pelanggan);
    //         $this->db->update('pelanggan', array('status' => 0));
    //     } else {
    //         // Handle unauthorized access 
    //         show_error('Unauthorized access', 403);
    //     }
    // }

    // public function reject_data_with_note($id_pelanggan, $peran, $rejectionNote)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_pelanggan', $id_pelanggan);
    //         $this->db->update('pelanggan', array('status' => $rejectionNote));
    //     } else {
    //         // Handle unauthorized access 
    //         show_error('Unauthorized access', 403);
    //     }
    // }

    // public function getFilteredPertaHal2($bulanFilter, $namaFilter, $komoditasFilter)
    // {
    //     // Sesuaikan query berdasarkan kebutuhan filter
    //     $query = "SELECT komoditas.id_komoditas, komoditas.komoditas, komoditas.kualitas, komoditas.satuan, komoditas.kode_kualitas, perta_hal1.id_perta_hal1, perta_hal1.bulan, perta_hal1.provinsi, perta_hal1.kabupaten, perta_hal1.kecamatan, 
    // perta_hal1.nama, perta_hal1.nip, perta_hal1.tanggal, perta_hal2.id_perta_hal2, perta_hal2.id_komoditas, perta_hal2.responden,
    // perta_hal2.harga_saat, perta_hal2.harga_sebelum, perta_hal2.`status` FROM perta_hal2 JOIN komoditas ON komoditas.id_komoditas = perta_hal2.id_komoditas JOIN perta_hal1 ON perta_hal1.id_perta_hal1 = perta_hal2.id_perta_hal1 WHERE 1 = 1";

    //     // Tambahkan filter berdasarkan bulan jika bulanFilter tidak kosong
    //     if (!empty($bulanFilter)) {
    //         $query .= " AND perta_hal1.bulan = '$bulanFilter'";
    //     }

    //     // Tambahkan filter berdasarkan nama_hotel jika namaFilter tidak kosong
    //     if (!empty($namaFilter)) {
    //         $query .= " AND perta_hal1.nama = ?";
    //     }

    //     // Tambahkan filter berdasarkan komoditas jika komoditasFilter tidak kosong
    //     if (!empty($komoditasFilter)) {
    //         $query .= " AND komoditas.komoditas = ?";
    //     }

    //     // Jalankan query dengan menggunakan parameterized statement
    //     $params = array();

    //     if (!empty($namaFilter)) {
    //         $params[] = $namaFilter;
    //     }

    //     if (!empty($komoditasFilter)) {
    //         $params[] = $komoditasFilter;
    //     }

    //     $data = $this->db->query($query, $params);

    //     return $data->result();
    // }
}
