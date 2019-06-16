<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends NS_Controller {

	public function __construct(){		
		parent::__construct();
        $this->is_login_admin();

		$this->company_model 		= new master_model('company');

		$this->data = array();

		$this->controller_name = "nh_admin/company";


        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";

	}

	public function index()
	{
		$this->create();
	}

    /**
     * rendering create page
     */
    public function create(){
        $data = $this->data; //take any data possibly set in construct function
		$data["title"] = "Company";
		$data["action"] = base_url($this->controller_name.'/store');
		$data["breadcrumb"] = array(array("title"=>"Company","link"=>"","active"=>"active"));

		//set data
		$data["db_data"] = $this->company_model->find(1);

		$this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    public function store(){
        if($this->storeValidation()) {
            $crud_data = $this->input_data;
            
			$data["db_data"] = $this->company_model->find(1);

            //update logo
                if( isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ''){
                    $file_name  = "logo";
                    $new_name   = "logo".time();
                    $new_path   = 'public/images/logo/';
                    if($data['db_data']['logo'] != "" || $data['db_data']['logo'] != "NULL" ){
                        $old_file_path = $data['db_data']['logo'];
                    }else{
                        $old_file_path = "";
                    }
                    $image      = upload_handler_2($file_name,$new_name,$new_path, $required = true,$old_file_path,28,22);

                    if($image['status'] == 0){
                        //false
                        $error    = 1;
                        $msg    = $image['error'];
                    }else{
                        //true
                        $crud_data["logo"] = $image['file_path'];
                    }
                }


            //delete logo
                if(isset($crud_data["delete_logo"])){
                    unset($crud_data["delete_logo"]);
                    $old_file_path = $data["db_data"]["logo"];
                
                    if($old_file_path != ""){
                        if(file_exists($old_file_path)){
                            unlink($old_file_path);
                        }
                        $parts = explode(".",$old_file_path);
                        $old_thumb_path = $parts[0]."_thumb.".$parts[1];
                        if(file_exists($old_thumb_path)){
                            unlink($old_thumb_path);
                        }
                    }
                    $crud_data["logo"] = NULL;
                }

            if($data["db_data"]){
            	$this->company_model->update(1,$crud_data);	
            }else{
	            $this->company_model->add($crud_data);
            }
            
            if(!isset($error)){
                $passData['msg'] = "success update data ";
                $passData['msg_status'] = "success";
            }else{
                $passData['msg'] = $msg;
                $passData['msg_status'] = "danger";
            }
            $this->session->set_userdata("temporary_data", $passData);

            redirect($this->controller_name);
        }else{
            $this->create();
        }
    }

    

    /**
     * create form validation
     */
    public function storeValidation(){
        return true;
    }

}
