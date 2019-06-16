<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends NS_Controller {
	public function __construct(){
		parent::__construct();
        $this->data = array();

        $this->controller_name = "nh_admin/login";

        $this->company_model        = new master_model('company');
        $this->user_model        = new master_model('user');
        $this->company_data 		= $this->company_model->find(1);
        $this->title = "Login";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";

	}
	public function index(){
		$user_data = $this->session->userdata("user_data");
		if(isset($user_data["id"])){
			redirect('nh_admin/dashboard');
		}
		$this->login();
	}
	public function login(){

		$data['title'] = "Login ".$this->company_data["name"];
		$data['action'] = $this->controller_name.'/Login';
		$data["forgot_password"] = base_url($this->controller_name."/forgot_password");
		//$data['company_data'] = $this->company_model->find(1);
		
		if(isset($this->input_data['username'])){
			$crud_data = $this->input_data;
			
			$user_data = $this->user_model->find($crud_data["username"],"username");
			if(isset($user_data["id"])){
				$password = $crud_data["password"].ucwords($crud_data["username"]);
				$password = sha1($password);
				if($user_data["password"]==$password){
					unset($user_data["password"]);
					$this->session->set_userdata("user_data",$user_data);
					redirect('nh_admin/dashboard');
				}else{
					$data["msg"]="Username dan Password Salah";
				}
			}else{
				$data["msg"]="Username dan Password Salah";
			}	
		}

		$this->load->view($this->controller_name."/form",$data,"");
	}
	public function forgot_password(){
		
		$data['title'] = 'Password '.$this->company_data["name"];
		$data['action'] =  base_url($this->controller_name).'/forgot_password';
		$data["login"] = base_url($this->controller_name);
		//$data['company_data'] = $this->company_model->find(1);
		
		if(isset($this->input_data['username'])){
			$input_data = $this->input_data;
			$user_data = $this->user_model->find($input_data["username"],"username");
			if(isset($user_data["id"])){
				$user_data["company_data"]=$this->company_data;
				$user_data["new_password"] = generate_password();
				$this->user_model->update($user_data["id"],array("password"=>sha1($user_data["new_password"].ucwords($user_data["username"]))) );
        		$template = $this->load->view('nh_admin/login/reset_password_mail_template.php',$user_data,TRUE);
        		
        		try {
        			
        			send_mail($user_data["email"],' Reset Password '.$this->company_data["name"],$template);
        			//die;
					$data["msg"]="new password send your email";
					$data["msg_status"]="success";	
        		} catch (Exception $e) {
					$data["msg"]="system internal error";
					$data["msg_status"]="danger";	
        		}
			}else{
				$data["msg"]="Username tidak ditemukan";
					$data["msg_status"]="danger";	
			}
		}

		$this->load->view($this->controller_name."/forgot_password",$data,"");
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect($this->controller_name);
	}

	public function change_password(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "Change Password"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'create';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["user_data"] = $user_data = $this->session->userdata("user_data");
        $data["breadcrumb"] = array(
                                        array("title"=>"Change Password","link"=>base_url($this->controller_name),"active"=>"")
                                    );
        $data['action']= base_url($this->controller_name).'/change_password_proses';
        $this->template->loadView($this->controller_name.'/change_password',$data,'admin');
    }
    public function change_password_proses()
    {
    	$crud_data = $this->input_data;
    	$user_data = $this->session->userdata("user_data");

    	$user_model = $this->user_model->find($user_data["id"]);

    	$password = $crud_data["password"].ucwords($user_data["username"]);
		$password = sha1($password);

		if($user_model["password"]==$password){
			$new_password = $crud_data["new_password"].ucwords($user_data["username"]);
			$new_password = sha1($new_password);

			$this->user_model->update($user_data["id"],array("password"=>$new_password));

	    	$msg["msg"] = "password berhasil di ubah";
	    	$msg["msg_status"] = 'success';

		}else{
	    	$msg["msg"] = "Password Lama Salah";
	    	$msg["msg_status"] = 'danger';			
		}
		
    	$this->session->set_userdata("temporary_data",$msg);
    	redirect($this->controller_name."/change_password");
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */