<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetilTransaksiLayananModel extends CI_Model{
    private $detil ='DETIL_TRANSAKSI_LAYANAN';
    private $trans ='TRANSAKSI_LAYANAN';
    private $layanan ='LAYANAN';
    //id_transaksi_produk,id_pegawai= cs, peg_id_pegawai=kasir, id_hewan,status_transaksi_produk,tgl_transaksi_produk,subtotal_transaksi_produk
    //,total_transaksi_produk,diskon_produk
    public $id_transaksi_layanan;
    public $id_layanan;
    public $sub_total_layanan;
    public $jumlah_detil_layanan;

    public $rule=[
        [
            'field'=>'id_transaksi_layanan',
            'label'=>'id_transaksi_layanan',
            'rules'=>'required'
        ],
        [
            'field'=>'id_layanan',
            'label'=>'id_layanan',
            'rules'=>'required|numeric'
        ],
        [
            'field'=>'jumlah_detil_layanan',
            'label'=>'jumlah_detil_layanan',
            'rules'=>'required|numeric'
        ],
    ];
    public function Rules(){return $this->rule;}
    public function getall($id_trans){
        if($id_trans==null){
            $this->db->select('DETIL_TRANSAKSI_LAYANAN.ID_DETILTRANSAKSI_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.ID_TRANSAKSI_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.ID_LAYANAN, 
            LAYANAN.NAMA_LAYANAN,
            LAYANAN.ID_UKURAN,
            UKURAN.UKURAN,
            LAYANAN.ID_JENISHEWAN,
            JENIS_HEWAN.JENISHEWAN,
            LAYANAN.HARGA_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.SUB_TOTAL_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.JUMLAH_DETIL_LAYANAN')
                    ->from('DETIL_TRANSAKSI_LAYANAN')
                    ->join('LAYANAN','DETIL_TRANSAKSI_LAYANAN.ID_LAYANAN = LAYANAN.ID_LAYANAN')
                    ->join('UKURAN','LAYANAN.ID_UKURAN = UKURAN.ID_UKURAN')
                    ->join('JENIS_HEWAN','LAYANAN.ID_JENISHEWAN = JENIS_HEWAN.ID_JENISHEWAN');
            return $this->db->get()->result();
        }else{
            $this->db->select('DETIL_TRANSAKSI_LAYANAN.ID_DETILTRANSAKSI_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.ID_TRANSAKSI_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.ID_LAYANAN, 
            LAYANAN.NAMA_LAYANAN,
            LAYANAN.ID_UKURAN,
            UKURAN.UKURAN,
            LAYANAN.ID_JENISHEWAN,
            JENIS_HEWAN.JENISHEWAN,
            LAYANAN.HARGA_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.SUB_TOTAL_LAYANAN,
            DETIL_TRANSAKSI_LAYANAN.JUMLAH_DETIL_LAYANAN')
                    ->from('DETIL_TRANSAKSI_LAYANAN')
                    ->join('LAYANAN','DETIL_TRANSAKSI_LAYANAN.ID_LAYANAN = LAYANAN.ID_LAYANAN')
                    ->join('UKURAN','LAYANAN.ID_UKURAN = UKURAN.ID_UKURAN')
                    ->join('JENIS_HEWAN','LAYANAN.ID_JENISHEWAN = JENIS_HEWAN.ID_JENISHEWAN')
                    ->like('DETIL_TRANSAKSI_LAYANAN.ID_TRANSAKSI_LAYANAN',$id_trans);
            return $this->db->get()->result();
        }
    }
    public function store($request) { 
        date_default_timezone_set('Asia/Jakarta');
        //conn
        $conn = mysqli_connect('localhost', $this->db->username, $this->db->password,$this->db->database);
        
        $this->id_transaksi_layanan = $request->id_transaksi_layanan;
        $this->id_layanan = $request->id_layanan;
        $this->jumlah_detil_layanan = $request->jumlah_detil_layanan;
        
        //cek apakah udah ada
        $result =  mysqli_query($conn,"SELECT COUNT(DISTINCT id_layanan) as cnt FROM $this->detil WHERE id_layanan = '$request->id_layanan' AND id_transaksi_layanan = '$request->id_transaksi_layanan'");
        $dup = mysqli_fetch_row($result);
        
        //ambil harga jual dari tabel produk
        $result = mysqli_query($conn,"SELECT harga_layanan FROM $this->layanan WHERE id_layanan = '$request->id_layanan' ");
        $harga = mysqli_fetch_row($result);
        
        //hitung subtotal dari jumlah * harga
        $this->sub_total_layanan = $harga[0]*$request->jumlah_detil_layanan;
        
           if ( $dup[0] == 0){
               if($this->db->insert($this->detil, $this)){
                 //hitung sub total dari detil
                $result = mysqli_query($conn,"SELECT SUM(sub_total_layanan) FROM $this->detil WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                $sub = mysqli_fetch_row($result);
               
                
                //update subtotal di transaksi 
                mysqli_query($conn,"UPDATE $this->trans SET subtotal_transaksi_layanan = '$sub[0]' WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                
                //update total di transaksi
                mysqli_query($conn,"UPDATE $this->trans SET total_transaksi_layanan = subtotal_transaksi_layanan - diskon_layanan WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                return ['msg'=>'Berhasil Menambahkan Data','error'=>false];
               }
           }else if ( $dup[0] != 0){
                mysqli_query($conn,"UPDATE $this->detil SET jumlah_detil_layanan = '$request->jumlah_detil_layanan' WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' AND id_layanan = '$request->id_layanan' ");
                
                mysqli_query($conn,"UPDATE $this->detil SET sub_total_layanan = '$this->sub_total_layanan' WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' AND id_layanan = '$request->id_layanan' ");
                
                $result = mysqli_query($conn,"SELECT SUM(sub_total_layanan) FROM $this->detil WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                $sub = mysqli_fetch_row($result);
                
                
                //update subtotal di transaksi 
                mysqli_query($conn,"UPDATE $this->trans SET subtotal_transaksi_layanan = '$sub[0]' WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                
                //update total di transaksi
                mysqli_query($conn,"UPDATE $this->trans SET total_transaksi_layanan = subtotal_transaksi_layanan - diskon_layanan WHERE id_transaksi_layanan = '$request->id_transaksi_layanan' ");
                return ['msg'=>'Berhasil Menambahkan Data','error'=>false];
           }
        
        return ['msg'=>'Gagal','error'=>true];
    }
    
    public function update($request,$id) { 
        $conn = mysqli_connect('localhost', $this->db->username, $this->db->password,$this->db->database);
        
        //ambil id trans
        $result = mysqli_query($conn,"SELECT id_transaksi_layanan FROM $this->detil WHERE id_detiltransaksi_layanan = '$id' ");
        $idTrans = mysqli_fetch_row($result);
        
        //ambil harga dari tabel produk
        $result = mysqli_query($conn,"SELECT harga_layanan FROM $this->layanan WHERE id_layanan = '$request->id_layanan' ");
        $harga = mysqli_fetch_row($result);
        
        //ambil id produk sebelum
        $result = mysqli_query($conn,"SELECT id_layanan FROM $this->detil WHERE id_detiltransaksi_layanan = '$id' ");
        $idSebelum = mysqli_fetch_row($result);
        
        $updateData = [
        'id_layanan'=>$request->id_layanan,
        'jumlah_detil_layanan' => $request->jumlah_detil_layanan,
        'sub_total_layanan' => $harga[0] * $request->jumlah_detil_layanan];
        if($this->db->where('id_detiltransaksi_layanan',$id)->update($this->detil, $updateData)){
            
            //hitung subtotal detil
            $result = mysqli_query($conn,"SELECT SUM(sub_total_layanan) FROM $this->detil WHERE id_transaksi_layanan = '$idTrans[0]' ");
            $sub = mysqli_fetch_row($result);
            
            //update subtotal di transaksi 
            mysqli_query($conn,"UPDATE $this->trans SET subtotal_transaksi_layanan = '$sub[0]' WHERE id_transaksi_layanan = '$idTrans[0]' ");
        
            //update total di transaksi
            mysqli_query($conn,"UPDATE $this->trans SET total_transaksi_layanan = subtotal_transaksi_layanan - diskon_layanan WHERE id_transaksi_layanan = '$idTrans[0]' ");
            
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($id){
        $conn = mysqli_connect('localhost', $this->db->username, $this->db->password,$this->db->database);
        
        $result = mysqli_query($conn,"SELECT id_transaksi_layanan FROM $this->detil WHERE id_detiltransaksi_layanan = '$id' ");
        $idTrans = mysqli_fetch_row($result);
        
        //ambil id produk sebelum
        $result = mysqli_query($conn,"SELECT id_layanan FROM $this->detil WHERE id_detiltransaksi_layanan = '$id' ");
        $idSebelum = mysqli_fetch_row($result);
        
        //ambil jumlah produk sebelum
        $result = mysqli_query($conn,"SELECT jumlah_detil_layanan FROM $this->detil WHERE id_detiltransaksi_layanan = '$id' ");
        $jmlSebelum = mysqli_fetch_row($result);
        
        
        if($this->db->where('id_detiltransaksi_layanan',$id)->delete($this->detil)){
            $result = mysqli_query($conn,"SELECT SUM(sub_total_layanan) FROM $this->detil WHERE id_transaksi_layanan = '$idTrans[0]' ");
            $sub = mysqli_fetch_row($result);
            
            if ($sub[0] == null){
                $sub[0] = 0;
            }
            //update subtotal di transaksi 
            mysqli_query($conn,"UPDATE $this->trans SET subtotal_transaksi_layanan = '$sub[0]' WHERE id_transaksi_layanan = '$idTrans[0]' ");
        
            //update total di transaksi
            mysqli_query($conn,"UPDATE $this->trans SET total_transaksi_layanan = subtotal_transaksi_layanan - diskon_layanan WHERE id_transaksi_layanan = '$idTrans[0]' ");
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>