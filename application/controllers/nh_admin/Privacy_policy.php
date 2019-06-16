<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy_policy extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->menu_model        = new master_model('menu');
        $this->user_model        = new master_model('user');
        $this->posts_model        = new master_model('posts');
        $this->galery_model        = new master_model('galery');
        $this->posts_meta_model        = new master_model('posts_meta');
        $this->content_model        = new master_model('content');

        $this->data = array();

        $this->controller_name = "nh_admin/privacy_policy";
        $this->title = "Privacy Policy";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
        $this->data["menu_parent_selector"] = $this->menu_model->all(" AND parent = 1 ");
        $this->data["menu_selector"] = array();
        $this->data["user_selector"] = $this->user_model->all("  ");
        $this->data["boolean_selector"] = array("NO","YES");
        //crypt()sha1(str) 
    }

    /**
     * index page, for showing list of data
     */
    public function index(){
        $this->create();
    }

    /**
     * rendering create page
     */
    public function create(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'create';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>$this->title,"link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/store';


        
        $db_data1 = $this->posts_model->find(10,"menu_id");
        if(isset($db_data1["id"])){
            $id=$db_data1["id"];
            $db_data2 = $this->posts_meta_model->find($id,"posts_id");
            $db_data3 = $this->content_model->find($id,"posts_id");

            $kategori = $this->menu_model->find($db_data1["menu_id"]);
            if(isset($db_data3["galery_id"])){
                $galery = $this->galery_model->find($db_data3["galery_id"]);   
            }

            $data["db_data"]  = $db_data1+$db_data2+$db_data3;
            $data['db_data']["image_path"] = isset($galery['image_path'])?base_url($galery['image_path']):"";
        }

        $this->template->loadView('nh_admin/about/form',$data,'admin');
    }

    /**
     * store input data to db
     */
    public function store(){
        if($this->storeValidation()) {
            $crud_data = array();
            $crud_data = $this->input_data;

            $db_data1 = $this->posts_model->find(10,"menu_id");


            $input_posts = array();
            $input_posts["menu_id"] = 10;
            $input_posts["title"] = $crud_data["title"];
            $input_posts["content"] = $crud_data["content"];
            $input_posts["status"] = isset($crud_data["publish_date"]) && $crud_data["publish_date"] == 1?"publish":"pending";

            if(isset($db_data1["id"])){
                $posts_id = $this->posts_model->update($db_data1["id"],$input_posts);
                $posts_id = $db_data1["id"];


                $meta = $this->posts_meta_model->find($posts_id,"posts_id");
                $content = $this->content_model->find($posts_id,"posts_id");
                $input_content = array();
                $input_content["posts_id"] = $posts_id;
                $input_content["galery_id"] = $crud_data["galery_id"];
                $input_content["publish_date"] = isset($crud_data["publish_date"]) && $crud_data["publish_date"]==1?date('Y-m-d'):date('Y-m-d');

                $this->content_model->update($content["id"],$input_content);

                $input_meta = array();
                $input_meta["posts_id"] = $posts_id;
                $input_meta["tags"] = $crud_data["tags"];
                $input_meta["key_word"] = $crud_data["key_word"];
                $input_meta["description"] = $crud_data["description"];

                $this->posts_meta_model->update($meta["id"],$input_meta);
            }else{
                $posts_id = $this->posts_model->add($input_posts);

                $input_content = array();
                $input_content["posts_id"] = $posts_id;
                $input_content["galery_id"] = $crud_data["galery_id"];
                $input_content["publish_date"] = isset($crud_data["publish_date"]) && $crud_data["publish_date"]==1?date('Y-m-d'):date('Y-m-d');

                $this->content_model->add($input_content);

                $input_meta = array();
                $input_meta["posts_id"] = $posts_id;
                $input_meta["tags"] = $crud_data["tags"];
                $input_meta["key_word"] = $crud_data["key_word"];
                $input_meta["description"] = $crud_data["description"];

                $this->posts_meta_model->add($input_meta);
            }
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
    




}