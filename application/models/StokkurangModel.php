<?php

class StokkurangModel extends CI_Model
{
    private $tabel = "barang";

    public function get_data()
{
    $this->db->select('barang.*, kategori.*, merk.*, suplier.*');
    $this->db->from('barang');
    $this->db->join('kategori', 'barang.id_kategori = kategori.id_kategori');
    $this->db->join('merk', 'barang.id_merk = merk.id_merk');
    $this->db->join('suplier', 'barang.id_suplier = suplier.id_suplier');
    $this->db->where('barang.stok <=', 5); // Menambahkan kondisi WHERE untuk stok <= 5
    $query = $this->db->get();
    return $query->result();
}

public function get_stok_kurang($batas_stok = 10)
{
    $this->db->select('barang.*, kategori.nama_kategori');
    $this->db->from('barang');
    $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori');
    $this->db->where('barang.stok <', $batas_stok);
    $this->db->order_by('barang.stok', 'ASC');
    return $this->db->get()->result();
}

    public function getJumlahData()
    {
        return $this->db->count_all($this->tabel);
    }


    public function get_data_byid($id_barang)
    {
        return $this->db->get_where($this->tabel, ['id_barang' => $id_barang])->row();
    }
}
