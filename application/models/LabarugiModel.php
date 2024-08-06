<?php

class LabarugiModel extends CI_Model
{
    public function get_data()
    {
        $data = $this->db->query("SELECT 
        penjualan.id_penjualan,
        penjualan.id_barang AS penjualan_id_barang,
        penjualan.total AS penjualan_total,
        penjualan.tanggal_input AS pj,
        pembelian.id_pembelian,
        pembelian.id_barang AS pembelian_id_barang,
        pembelian.total AS pembelian_total,
        pembelian.tanggal_input AS pb,
        pengeluaran.id_pengeluaran,
        pengeluaran.keterangan,
        pengeluaran.harga,
        pengeluaran.tgl_input AS pl,
        barang.id_barang,
        barang.id_kategori,
        barang.id_merk,
        merk.*,
        kategori.*
    FROM 
        penjualan
    JOIN 
        barang ON barang.id_barang = penjualan.id_barang
    JOIN 
        pembelian ON pembelian.id_barang = barang.id_barang
    JOIN 
        pengeluaran ON pengeluaran.id_pengeluaran = penjualan.id_penjualan
    JOIN 
        merk ON barang.id_merk = merk.id_merk
    JOIN 
        kategori ON barang.id_kategori = kategori.id_kategori;
    ");
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
