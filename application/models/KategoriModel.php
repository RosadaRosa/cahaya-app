<?php

class KategoriModel extends CI_Model
{
    private $tabel = "kategori";

    public function get_data()
    {
        return $this->db->get($this->tabel)->result();
    }

    public function get_data_byid($id_kategori)
    {
        return $this->db->get_where($this->tabel, ['id_kategori' => $id_kategori])->row();
    }

    public function save_data()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true)
        ];
        $this->db->insert($this->tabel, $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data kategori Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data kategori Gagal Ditambahkan');
        }
    }

    public function update_data($id_kategori)
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true)
        ];
        $this->db->update($this->tabel, $data, ['id_kategori' => $id_kategori]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data kategori Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data kategori Gagal Diperbaharui');
        }
    }

    public function delete_data($id_kategori)
    {
        $this->db->delete($this->tabel, ['id_kategori' => $id_kategori]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data kategori Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data kategori Gagal Dihapus');
        }
    }
}
