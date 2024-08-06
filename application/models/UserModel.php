<?php


class UserModel extends CI_Model
{
    private $tabel = "user";

    public function get_data()
    {
        return $this->db->get($this->tabel)->result();
    }

    public function get_data_byid($id_user)
    {
        return $this->db->get_where($this->tabel, ['id_user' => $id_user])->row();
    }

    public function save_data()
    {
        $level_input = $this->input->post('level', true);

       

        $data = [
            'username' => $this->input->post('username', true),
            'password' => $this->input->post('password', true),
            'level' => $level_input,
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'alamat' => $this->input->post('alamat', true),
            'telepon' => $this->input->post('telepon', true) 
        ];

        $this->db->insert($this->tabel, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data User Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data User Gagal Ditambahkan');
        }
    }


    public function update_data($id_user)
    {
        $level_input = $this->input->post('level', true);
        $data = [
            'username' => $this->input->post('username', true),
            'password' => $this->input->post('password', true),
            'level' => $level_input,
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'alamat' => $this->input->post('alamat', true),
            'telepon' => $this->input->post('telepon', true) 
        ];
        $this->db->update($this->tabel, $data, ['id_user' => $id_user]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data User Berhasil Diperbaharui');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data User Gagal Diperbaharui');
        }
    }

    public function delete_data($id_user)
    {
        $this->db->delete($this->tabel, ['id_user' => $id_user]);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('status', true);
            $this->session->set_flashdata('pesan', 'Data User Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('status', false);
            $this->session->set_flashdata('pesan', 'Data User Gagal Dihapus');
        }
    }
}
