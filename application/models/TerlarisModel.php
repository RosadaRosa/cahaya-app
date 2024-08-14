<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TerlarisModel extends CI_Model
{
    public function get_data($month = null, $year = null)
    {
        $this->db->select('b.id_barang, k.nama_kategori, m.merk, m.bahan, m.ukuran, SUM(p.jumlah) as total_terjual, AVG(p.harga_jual) as harga_jual');
        $this->db->from('penjualan p');
        $this->db->join('barang b', 'p.id_barang = b.id_barang');
        $this->db->join('kategori k', 'b.id_kategori = k.id_kategori');
        $this->db->join('merk m', 'b.id_merk = m.id_merk');
        $this->db->where('p.status', 'Selesai');

        if ($month !== null) {
            $this->db->where('MONTH(p.tanggal_input)', $month);
        }
        if ($year !== null) {
            $this->db->where('YEAR(p.tanggal_input)', $year);
        }

        $this->db->group_by('b.id_barang, k.nama_kategori, m.merk, m.bahan, m.ukuran');
        $this->db->having('(AVG(p.harga_jual) > 100000 AND SUM(p.jumlah) >= 20) OR (AVG(p.harga_jual) <= 100000 AND SUM(p.jumlah) >= 30)');
        $this->db->order_by('total_terjual', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    public function get_monthly_data($year = null)
    {
        $this->db->select('DATE_FORMAT(p.tanggal_input, "%Y-%m") as month, SUM(p.jumlah) as total_terjual');
        $this->db->from('penjualan p');
        $this->db->where('p.status', 'Selesai');

        if ($year !== null) {
            $this->db->where('YEAR(p.tanggal_input)', $year);
        }

        $this->db->group_by('DATE_FORMAT(p.tanggal_input, "%Y-%m")');
        $this->db->order_by('month', 'DESC');
        $this->db->limit(12);

        return $this->db->get()->result();
    }

    public function get_monthly_sales()
    {
        $this->db->select("DATE_FORMAT(tanggal_input, '%M') as month, SUM(jumlah) as total_terjual");
        $this->db->from('penjualan');
        $this->db->group_by("DATE_FORMAT(tanggal_input, '%M')");
        $this->db->order_by("DATE_FORMAT(tanggal_input, '%m')");
        return $this->db->get()->result_array();
    }

    public function get_terlaris_data()
    {
        // Example SQL query to fetch the top-selling products
        // Modify this query based on your actual database schema and requirements
        $this->db->select('merk.merk, merk.bahan, merk.ukuran, SUM(penjualan.jumlah) as total_terjual');
        $this->db->from('penjualan');
        $this->db->join('barang', 'penjualan.id_barang = barang.id_barang');
        $this->db->join('merk', 'barang.id_merk = merk.id_merk');
        $this->db->group_by('merk.merk, merk.bahan, merk.ukuran');
        $this->db->order_by('total_terjual', 'DESC'); // Optional: to sort by total_terjual

        $query = $this->db->get();
        return $query->result_array(); // Fetch result as an associative array
    }

    // You might have other methods for handling data as well

}
