<?php

class MerkModel extends CI_Model
{
    private $tabel = "merk";

    public function get_data()
    {
        return $this->db->get($this->tabel)->result();
    }

    public function get_data_byid($id_merk)
    {
        return $this->db->get_where($this->tabel, ['id_merk' => $id_merk])->row();
    }

    public function save_data()
    {
        $data = [
            'merk' => $this->input->post('merk', true),
            'bahan' => $this->input->post('bahan', true),
            'ukuran' => $this->input->post('ukuran', true)
        ];
        $this->db->insert($this->tabel, $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data Merk Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data Merk Gagal Ditambahkan');
        }
    }

    public function update_data($id_merk)
    {
        $data = [
            'merk' => $this->input->post('merk', true),
            'bahan' => $this->input->post('bahan', true),
            'ukuran' => $this->input->post('ukuran', true)
        ];
        $this->db->update($this->tabel, $data, ['id_merk' => $id_merk]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data Merk Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data Merk Gagal Diperbaharui');
        }
    }

    public function delete_data($id_merk)
    {
        $this->db->delete($this->tabel, ['id_merk' => $id_merk]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data Merk Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data Merk Gagal Dihapus');
        }
    }
}
