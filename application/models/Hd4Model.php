<?php

class Hd4Model extends CI_Model
{
    private $tabel = "master_hd4";

    public function get_data()
    {
        return $this->db->get($this->tabel)->result();
    }

    public function get_data_byid($id)
    {
        return $this->db->get_where($this->tabel, ['id' => $id])->row();
    }

    public function save_data()
    {
        $data = [
            'komoditas' => $this->input->post('komoditas', true),
            'kualitas' => $this->input->post('kualitas', true),
            'satuan' => $this->input->post('satuan', true),
            'kode_kualitas' => $this->input->post('kode_kualitas', true)
        ];
        $this->db->insert($this->tabel, $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Gagal Ditambahkan');
        }
    }

    public function update_data($id)
    {
        $data = [
            'komoditas' => $this->input->post('komoditas', true),
            'kualitas' => $this->input->post('kualitas', true),
            'satuan' => $this->input->post('satuan', true),
            'kode_kualitas' => $this->input->post('kode_kualitas', true)
        ];
        $this->db->update($this->tabel, $data, ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Gagal Diperbaharui');
        }
    }

    public function delete_data($id)
    {
        $this->db->delete($this->tabel, ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data SHPED Peternakan Gagal Dihapus');
        }
    }
}
