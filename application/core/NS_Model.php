<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NS_Model extends CI_Model {
    protected $tblName;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $user_data = $this->session->userdata("user_data");
        $this->user_id =  $user_data["id"];
    }
   
	protected function query($query){
        return $this->db->query($query);
    }
    public function executeQuery($query){
        $res =  $this->db->query($query);
        return $res;
    }
   protected function readAllRows($table_name, $additional_criteria = "",$data_status = ""){
        $data = array();

        if($data_status == "")
        {   
            $where = " WHERE deleted_at IS NULL";
        }
        else if($data_status == "only_trash"){
            $where = " WHERE deleted_at IS NOT NULL";
        }
        else if($data_status == "with_trash"){
            $where = " WHERE 1";
        }
        
        $where .= $additional_criteria != "" ? $additional_criteria : "";
        $query = "SELECT * FROM " . $table_name . $where;
        
        $rows = $this->executeQuery($query);
        
        foreach ($rows->result_array() as $row) {
            foreach($row as $key=>$val){
                    $row[$key] = $val;
            }
            $data[] = $row;
        }
        
        return $data;
    }
    protected function readRowInfo($table_name, $id, $by = "", $additional_criteria = ""){
        $data = array();
        if ($by == "") $by = "id";
        $where = ($id != "") ? " WHERE $by = '$id'" : "";
        $where .= $additional_criteria != "" ? $additional_criteria : "";
        $query = "SELECT * FROM " . $table_name . $where;
                $rows = $this->executeQuery($query);
                foreach ($rows->result_array() as $row) {
                        $data = $row;
                }
                return $data;
    }
    protected function getInsertId(){
            return $this->db->insert_id();
    }
    protected function insert($tblName,$data,$log = 1){
        /*
        if($this->allow_insert != ""){
            $allow_insert = explode(",", $this->allow_insert);
            
            foreach($data as $key=>$val){
                if(in_array($key, $allow_insert)){
                    if(isset($data[$key])){
                        $insert[$key] = $val;
                    }
                }
            }
        }
        else{
            $insert = $data;
        }
        */
        $insert = $data;
        $insert["created_at"] = date("Y-m-d H:i:s");
        $insert["created_by"] = $this->user_id;
       
        unset($insert["Nh_token"]);
        $this->db->insert($tblName, $insert); 
        $insert_id = $this->db->insert_id();
        $query = $this->db->last_query();
        if($log == 1){
            $this->log($tblName,$data,$insert_id,"insert",$query);
        }
        return $insert_id;
    }
    protected function updateRow($data,$tblName,$id,$by,$log = 1){
        /*
        if($this->allow_update != ""){
            $allow_update = explode(",", $this->allow_update);
            foreach($data as $key=>$val){
                if(in_array($key, $allow_update)){
                    if(isset($data[$key]) || $data[$key] == NULL){
                        $update[$key] = $val;
                    }
                }
            }
        }else{
            $update = $data;
        }
        */
        $update = $data;
        $update["updated_at"] = date("Y-m-d H:i:s");
        $update["updated_by"] = $this->user_id;
        unset($update["Nh_token"]);
        $this->db->where($by,$id);
        $this->db->update($tblName, $update); 

        $query = $this->db->last_query();
        
        if($log == 1){
            $this->log($tblName,$data,$id,"update",$query);
        }
    }

    protected function countRows($table_name, $additional_criteria = "",$data_status = ""){
        if($data_status == "")
        {   
            $where = " WHERE deleted_at IS NULL";
        }
        else if($data_status == "only_trash"){
            $where = " WHERE deleted_at IS NOT NULL";
        }
        else if($data_status == "with_trash"){
            $where = " WHERE 1";
        }
        $where .= $additional_criteria != "" ? $additional_criteria : "";
        $query = "SELECT COUNT(*) as cnt FROM " . $table_name . $where;
        $rows = $this->executeQuery($query);
   
        foreach ($rows->result_array() as $row)
        {
            $count = isset($row['cnt']) ? $row['cnt'] : "";
        }
    
        return $count;
    }
    protected function DeleteRow($tblName,$id,$by,$log = 1){
        $data["deleted_at"] = date("Y-m-d H:i:s");
        $data["deleted_by"] = $this->user_id;
        $this->db->where($by,$id);
        $this->db->update($tblName, $data);

        $query = $this->db->last_query();
        $data = $this->readRowInfo($tblName,$id);
        if($log == 1){
            $this->log($tblName,$data,$id,"deactive",$query);
        }
    }
    protected function restoreRow($tblName,$id,$by,$log = 1){
        $data["deleted_at"] = NULL;
        $data["deleted_by"] = NULL;
        $this->db->where($by,$id);
        $this->db->update($tblName, $data);
        $query = $this->db->last_query();
        $data = $this->readRowInfo($tblName,$id);
        if($log == 1){
            $this->log($tblName,$data,$id,"restore",$query);
        }
    }
    public function realDeleteRow($tblName,$id,$data = NULL,$log = 1){
        $this->db->where('id', $id);
        $data = $this->readRowInfo($tblName,$id);
        $this->db->delete($tblName);
        $query = $this->db->last_query();
        
        if($log == 1){
            $this->log($tblName,$data,$id,"restore",$query);
        }

    }
    protected function log($table,$data,$id,$action,$query){

    }

    public function add($data)
    {
        return $this->insert($this->tblName,$data);
    }

    public function all($custom_where="",$data_status=""){
        $rows = $this->readAllRows($this->tblName,$custom_where,$data_status);
        return $rows;
    }

    public function find($id,$by='id',$custom_where="") 
    {
        $rows = $this->readRowInfo($this->tblName, $id ,$by,$custom_where);
        return $rows;
    }
    public function count($custom_where="")
    {
        $num = $this->countRows($this->tblName, $custom_where);
        return $num;
    }
    public function update($id,$data)
    {
        //$data["updated_at"] = date("Y-m-d H:i:s");
        $this->updateRow($data, $this->tblName,$id,$this->tblId);
        //$this->db->where('id', $id);
        //$this->db->update($this->tblName, $data); 
    }
    public function delete($id){
        $this->deleteRow($this->tblName,$id,$this->tblId);
    }
    public function real_delete($id){
        $this->realDeleteRow($this->tblName,$id,$this->tblId);
    }
    public function soft_delete($id){
        $this->deleteRow($this->tblName,$id,$this->tblId);
    }
    public function restore($id){
        $this->restoreRow($this->tblName,$id,$this->tblId);
    }
}