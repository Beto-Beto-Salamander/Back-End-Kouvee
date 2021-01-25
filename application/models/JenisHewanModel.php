<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisHewanModel extends CI_Model{
    private $table='JENIS_HEWAN';

    public $id_jenishewan;
    public $id_pegawai;
    public $jenishewan;

    public $rule=[
        [
            'field'=>'id_pegawai',
            'label'=>'id_pegawai',
            'rules'=>'required'
        ],
        [
            'field'=>'jenishewan',
            'label'=>'jenishewan',
            'rules'=>'required|is_unique[JENIS_HEWAN.jenishewan]|alpha'
        ]
    ];
    public function Rules(){return $this->rule;}
    public function getall($id){
        if($id==null){
            $this->db->select('JENIS_HEWAN.ID_JENISHEWAN,JENIS_HEWAN.JENISHEWAN,PEGAWAI.NAMA_PEGAWAI,JENIS_HEWAN.CREATE_AT_JHEWAN,JENIS_HEWAN.UPDATE_AT_JHEWAN,JENIS_HEWAN.DELETE_AT_JHEWAN')
                    ->from('JENIS_HEWAN')
                    ->join('PEGAWAI','JENIS_HEWAN.ID_PEGAWAI = PEGAWAI.ID_PEGAWAI');
            return $this->db->get()->result();
        }else{
            $this->db->select('JENIS_HEWAN.ID_JENISHEWAN,JENIS_HEWAN.JENISHEWAN,PEGAWAI.NAMA_PEGAWAI,JENIS_HEWAN.CREATE_AT_JHEWAN,JENIS_HEWAN.UPDATE_AT_JHEWAN,JENIS_HEWAN.DELETE_AT_JHEWAN')
                    ->from('JENIS_HEWAN')
                    ->join('PEGAWAI','JENIS_HEWAN.ID_PEGAWAI = PEGAWAI.ID_PEGAWAI')
                    ->like('ID_JENISHEWAN',$id);
            return $this->db->get()->result();
        }
    }
    public function store($request) { 
        $this->id_pegawai = $request->id_pegawai;
        $this->jenishewan = $request->jenishewan;
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = [
        'jenishewan' => $request->jenishewan,
        'id_pegawai'=>$request->id_pegawai];
        if($this->db->where('id_jenishewan',$id)->update($this->table, $updateData)){
            return ['msg'=>'Data Berhasil Di Ubah','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function delete($time,$id){
        $delet=[
            'delete_at_jhewan'=>$time
        ];
        if($this->db->where('ID_JENISHEWAN',$id)->update($this->table, $delet)){
            return ['msg'=>'Data Berhasil Di Hapus','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>