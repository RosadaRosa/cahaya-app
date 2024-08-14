<?php

class PengeluaranModel extends CI_Model
{
    private $tabel = "pengeluaran";

    public function get_data()
{
    $this->db->select('pengeluaran.*, user.nama_lengkap as penambah');
    $this->db->from('pengeluaran');
    $this->db->join('user', 'user.id_user = pengeluaran.penambah');
    $query = $this->db->get();
    return $query->result();
}

public function get_data_report($dari_tanggal = NULL, $sampai_tanggal = NULL) 
{ 
    $this->db->select('pengeluaran.*, user.nama_lengkap as penambah'); 
    $this->db->from('pengeluaran'); 

    // Filter berdasarkan tanggal jika tanggal disertakan 
    if ($dari_tanggal !== NULL && $sampai_tanggal !== NULL) { 
        $this->db->where('pengeluaran.tgl_input >=', $dari_tanggal); 
        $this->db->where('pengeluaran.tgl_input <=', $sampai_tanggal); 
    } else { 
        // Jika tidak ada rentang tanggal disertakan, gunakan filter tahun ini 
        $this->db->where('pengeluaran.tgl_input >=', date('Y-01-01')); 
        $this->db->where('pengeluaran.tgl_input <=', date('Y-12-31')); 
    } 

    // // Filter berdasarkan kategori jika kategori disertakan 
    // if ($id_kategori !== NULL) { 
    //     $this->db->where('pengeluaran.id_kategori', $id_kategori); 
    // } 

    
    $this->db->join('user', 'user.id_user = pengeluaran.penambah'); 
   
    $query = $this->db->get(); 

    return $query->result(); 
}


    public function getJumlahData()
    {
        return $this->db->count_all($this->tabel);
    }

    public function get_data_byid($id_pengeluaran)
    {
        return $this->db->get_where($this->tabel, ['id_pengeluaran' => $id_pengeluaran])->row();
    }

    public function save_data()
    {
        $data = [
            'keterangan' => $this->input->post('keterangan', true),
            'harga' => $this->input->post('harga', true),
            'tgl_input' => date('Y-m-d H:i:s'),
            'penambah' => $this->session->userdata('id_user')
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

        $id_user = $this->session->userdata('id_user');
        $data_pengeluaran['penambah'] = $id_user;

        // // Menyimpan data ke dalam database
        $this->db->insert($this->tabel, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pengeluaran Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pengeluaran Gagal Ditambahkan');
        }
    }

    public function update_data($id_pengeluaran)
    {
        $data = [
            'keterangan' => $this->input->post('keterangan', true),
            'harga' => $this->input->post('harga', true),
            'tgl_input' => $this->input->post('tgl_input', true),
            'penambah' => $this->session->userdata('id_user')
        ];
        $this->db->update($this->tabel, $data, ['id_pengeluaran' => $id_pengeluaran]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pengeluaran Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pengeluaran Gagal Diperbaharui');
        }
    }

    public function delete_data($id_pengeluaran)
    {
        $this->db->delete($this->tabel, ['id_pengeluaran' => $id_pengeluaran]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Pengeluaran Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Pengeluaran Gagal Dihapus');
        }
    }

    // public function verify_data($id_pengeluaran, $peran)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_pengeluaran', $id_pengeluaran);
    //         $this->db->update('Pengeluaran', array('status' => 0));
    //     } else {
    //         // Handle unauthorized access 
    //         show_error('Unauthorized access', 403);
    //     }
    // }

    // public function reject_data_with_note($id_pengeluaran, $peran, $rejectionNote)
    // {
    //     if ($peran == "pengawas") {
    //         $this->db->where('id_pengeluaran', $id_pengeluaran);
    //         $this->db->update('Pengeluaran', array('status' => $rejectionNote));
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
