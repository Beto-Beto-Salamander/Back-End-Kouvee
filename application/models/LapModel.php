<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LapModel extends CI_Model{
    
    public function layanan(){
        $this->db->select('DISTINCT YEAR(TGL_TRANSAKSI_LAYANAN) as Tahun')
        ->from('TRANSAKSI_LAYANAN');
            return $this->db->get()->result();
    }
    
    public function produk(){
        $this->db->select('DISTINCT YEAR(TGL_TRANSAKSI) as Tahun')
        ->from('TRANSAKSI_PRODUK');
            return $this->db->get()->result();
    }
    
    public function pengadaan(){
        $this->db->select('DISTINCT YEAR(TANGGAL_PEMESANAN) as Tahun')
        ->from('PEMESANAN');
            return $this->db->get()->result();
    }
    
    public function pendapatan(){
        $this->db->select('DISTINCT YEAR(TGL_TRANSAKSI_LAYANAN) as Tahun')
        ->from('TRANSAKSI_LAYANAN');
            return $this->db->get()->result();
    }
    
    public function layananBulan(){
        $this->db->select('DISTINCT MONTHNAME(TGL_TRANSAKSI_LAYANAN) as Bulan')
        ->from('TRANSAKSI_LAYANAN');
            return $this->db->get()->result();
    }
    
    public function produkBulan(){
        $this->db->select('DISTINCT MONTHNAME(TGL_TRANSAKSI) as Bulan')
        ->from('TRANSAKSI_PRODUK');
            return $this->db->get()->result();
    }
    
    public function pengadaanBulan(){
        $this->db->select('DISTINCT MONTHNAME(TANGGAL_PEMESANAN) as Bulan')
        ->from('PEMESANAN');
            return $this->db->get()->result();
    }
    
    public function pendapatanBulan(){
        $this->db->select('DISTINCT MONTHNAME(TGL_TRANSAKSI_LAYANAN) as Bulan')
        ->from('TRANSAKSI_LAYANAN');
            return $this->db->get()->result();
    }
}
?>