<?php

class ProspekModel extends CI_Model
{

    public function get_data()
    {
        $query = $this->db->query("SELECT 
            DATE_FORMAT(penjualan.tanggal_input, '%Y-%m') as bulan,
            penjualan.id_barang,
            penjualan.jumlah,
            penjualan.total,
            GROUP_CONCAT(barang.harga_beli ORDER BY FIND_IN_SET(barang.id_barang, REPLACE(penjualan.id_barang, '\"', ',')) SEPARATOR ',') as harga_beli_list
        FROM penjualan
        JOIN barang ON FIND_IN_SET(barang.id_barang, REPLACE(penjualan.id_barang, '\"', ',')) > 0
        WHERE penjualan.status = 'Selesai'
        GROUP BY penjualan.id_penjualan, bulan
        ORDER BY bulan ASC ");
    
    return $query->result();
    }
}