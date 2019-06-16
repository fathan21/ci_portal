<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->user_model        = new master_model('user');
        $this->user_group_model        = new master_model('user_group');

        $this->data = array();

        $this->controller_name = "nh_admin/user";


        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
        $this->data["user_group_selector"] = $this->user_group_model->all();
        //crypt()sha1(str) 
    }

    /**
     * index page, for showing list of data
     */
    public function index(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User"; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener/';
        $data['delete_route'] = base_url($this->controller_name).'/destroy/';
        $data['add_new_link'] = $this->controller_name."/create"; // anchor link for add new data for this module
        $data["breadcrumb"] = array(array("title"=>"User","link"=>"","active"=>"active"));

        $this->template->loadView($this->controller_name.'/index',$data,'admin');
    }

    /**
     * rendering create page
     */
    public function create(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Create"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'create';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>"User","link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>"User Create","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/store';
        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * store input data to db
     */
    public function store(){
        if($this->storeValidation()) {
            $crud_data = array();
            $crud_data = $this->input_data;

            $crud_data["password"] = sha1($crud_data["password"].ucwords($crud_data["username"]));

            unset($crud_data["password_1"]);
            $this->user_model->add($crud_data);
            redirect($this->controller_name);
        }else{
            $this->create();
        }
    }

    /**
     * rendering read page
     * @param int $id data id
     */
   

    /**
     * rendering update page
     * @param int $id data id
     */
    public function edit($id){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Edit"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'Edit';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>"User","link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>"User Edit","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/update/'.$id;
        $data["db_data"] = $this->user_model->find($id);
        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * update data in db with id
     * @param int $id data id
     */
    public function update($id){
        if($this->updateValidation()){
            $data["db_data"] = $this->user_model->find($id);
            $crud_data = array();
            $crud_data = $this->input_data;

            if($crud_data["password"] != "")            
                $crud_data["password"] = sha1($crud_data["password"].ucwords($crud_data["username"]));
            else
                unset($crud_data["password"]);
            
            unset($crud_data["password_1"]);
            $this->user_model->update($id,$crud_data);
            redirect($this->controller_name);
        }else{
            $this->edit($id);
        }
    }

    /**
     * delete data in db with id
     * @param $id
     */
    public function destroy($id){
        try {
            $this->user_model->real_delete($id);
            return 0;
        }catch (Exception $e){
            return 1;
        }
    }

    /**
     * create form validation
     */
    public function storeValidation(){
        return true;
    }

    /**
     * update form validation
     */
    public function updateValidation(){
        return true;
    }

    /**
     * datatable listener
     */
    public function listener(){
        $datatables = $this->datatables;

        $data = $datatables
            ->select("a.id, a.username, a.email,a.phone, b.name as group")
            ->from('user a')
            ->join('user_group b', 'b.id = a.user_group_id',"left")
            ->where('a.deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/user',id)")
            ->generate();
        echo $data;
    }
    
    public function duplikat(){
        $input_data = $this->input_data;
        $out["msg"] = 1;
        
        if(isset($input_data["username"])){
            if($input_data["id"] != "")
                $user = $this->user_model->find($input_data["username"],"username"," AND id !=  '".$input_data["id"]."'");
            else
                $user = $this->user_model->find($input_data["username"],"username");    
            
            if(!$user)
                $out["msg"] = 0;
        }
        echo json_encode($out);
    }


}