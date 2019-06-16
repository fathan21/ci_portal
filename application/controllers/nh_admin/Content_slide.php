<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_slide extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->menu_model        = new master_model('menu');
        $this->user_model        = new master_model('user');
        $this->posts_model        = new master_model('posts');
        $this->galery_model        = new master_model('galery');
        $this->posts_meta_model        = new master_model('posts_meta');
        $this->content_model        = new master_model('content');
        $this->content_slide_model        = new master_model('content_slide');

        $this->data = array();

        $this->controller_name = "nh_admin/content_slide";
        $this->title = "Content Slide";

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
    public function index($content_id){
        $this->edit($content_id);
    }

    
    /**
     * rendering update page
     * @param int $id data id
     */
    public function edit($id){


        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title." "; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'Edit';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>'Content',"link"=>base_url('nh_admin/content'),"active"=>""),
                                        array("title"=>$this->title." ","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/update/'.$id;
        
        $data["db_data"] = $this->posts_model->find($id);

        $db_slide = array();
        $content_slide = $this->content_slide_model->all(" AND posts_id = $id ORDER BY display_order ASC ");
        if(count($content_slide) <= 0 ){
            $content_slide =  array(array(),array(),array());
        }else{
            foreach ($content_slide as $key => $value) {
                $galery_data = $this->galery_model->find($value["galery_id"]);
                $content_slide[$key]["image_thumbnail"] = base_url($galery_data["image_thumbnail"]);
            }
        }

        $data["db_slide"] = $content_slide;
        //$data['db_data']["image_thumbnail"] = isset($galery['image_thumbnail'])?base_url($galery['image_thumbnail']):"";

        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * update data in db with id
     * @param int $id data id
     */
    public function update($id){
        if($this->updateValidation($id)){

            $crud_data = array();
            $crud_data = $this->input_data;

            $this->db->query(" DELETE FROM content_slide WHERE posts_id = $id ");

            foreach ($crud_data["display_order"] as $key => $value) {
                $input_data = array();
                $input_data["title"] = $crud_data["title"][$key];
                $input_data["galery_id"] = $crud_data["galery_id"][$key];
                $input_data["content"] = $crud_data["lead"][$key];
                $input_data["display_order"] = $value;
                $input_data["posts_id"] = $id;

                $this->content_slide_model->add($input_data);
            }


            $posts_data = $this->posts_model->find($id);

            $passData['msg'] = "success update slide ".$posts_data["title"];
            $passData['msg_status'] = "success";
            $this->session->set_userdata("temporary_data",$passData);

            redirect('nh_admin/content');
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
            $this->posts_model->delete($id);
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
    public function updateValidation($id){
        $crud_data = $this->input_data;
        if(!isset($crud_data['display_order'])){
            $passData['msg'] = "gagal simpan data, data tidak di temukan ";
            $passData['msg_status'] = "error";
            $this->session->set_userdata("temporary_data",$passData); 
            redirect($this->controller_name.'/'.$id);
            return false;           
        }
        return true;
    }

    /**
     * datatable listener
     */
    public function listener(){
        $datatables = $this->datatables;

        $menu_id[] = 1;
        $menu_data = $this->menu_model->all(" AND parent = 1 ");
        foreach ($menu_data as $key => $value) {
            $menu_id[]=$value["id"];
            $second = $this->menu_model->all(" AND parent =  ".$value["id"]);
            foreach ($second as $key_1 => $value_1) {
                $menu_id[]=$value_1["id"];
            }
        }
        $menu_id = implode(",", $menu_id);

        $data = $datatables
            ->select(" a.id, a.title, writer.full_name as writer, editor.full_name as editor, c.full_name as created_by, kategori.name as kategori,
                section.name as section, b.publish_date as publish_date, a.status ",false)
            ->from('posts a')
            ->join('content b', 'b.posts_id = a.id',"left")
            ->join('user c', 'c.id = a.created_by',"left")
            ->join('user writer', 'writer.id = b.writer',"left")
            ->join('user editor', 'editor.id = b.editor',"left")
            ->join('menu kategori', 'kategori.id = a.menu_id',"left")
            ->join('menu section', 'section.id = kategori.parent',"left")
            ->where(' a.menu_id IN ('.$menu_id.') ',NULL,false)
            ->where('a.type','article')
            ->where('a.deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/content',id)")
            ->generate();
        echo $data;
    }

    public function get_menu($id)
    {
        $menu_data = $this->menu_model->all(" AND parent = $id ");
        $data = "";

        $data .= '<option value=""></option>';
        foreach ($menu_data as $key => $value) {
            $data .= '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
        }

        $result["data"] = $data;
        $result["msg"] = "success";
        $result["error"] = 0;

        echo json_encode($result);

    }
    public function popup(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener_popup/';
        $data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));

        $data["foot"]=$this->load->view("template/includes/admin-foot", "", TRUE);
        $data["head"] = $this->load->view("template/includes/admin-head","", TRUE);
        $this->template->loadView($this->controller_name.'/popup',$data,'');
    }

    /**
     * datatable listener
     */
    public function listener_popup(){
        $datatables = $this->datatables;

        $menu_id[] = 1;
        $menu_data = $this->menu_model->all(" AND parent = 1 ");
        foreach ($menu_data as $key => $value) {
            $menu_id[]=$value["id"];
            $second = $this->menu_model->all(" AND parent =  ".$value["id"]);
            foreach ($second as $key_1 => $value_1) {
                $menu_id[]=$value_1["id"];
            }
        }
        $menu_id = implode(",", $menu_id);

        $data = $datatables
            ->select(" a.id, a.title, writer.full_name as writer, editor.full_name as editor, c.full_name as created_by, kategori.name as kategori,
                section.name as section, b.publish_date as publish_date, a.status ",false)
            ->from('posts a')
            ->join('content b', 'b.posts_id = a.id',"left")
            ->join('user c', 'c.id = a.created_by',"left")
            ->join('user writer', 'writer.id = b.writer',"left")
            ->join('user editor', 'editor.id = b.editor',"left")
            ->join('menu kategori', 'kategori.id = a.menu_id',"left")
            ->join('menu section', 'section.id = kategori.parent',"left")
            ->where(' a.menu_id IN ('.$menu_id.') ',NULL,false)
            ->where('a.deleted_at',NULL)
            ->edit_column("id", "$1", "select_content(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/content',id)")
            ->generate();
        
        echo $data;
    }
    

    public function publish($id)
    {
            $crud_data = array();
            $crud_data = $this->input_data;
            $meta = $this->posts_meta_model->find($id,"posts_id");
            $content = $this->content_model->find($id,"posts_id");
          
            $input_posts = array();
            $input_posts["status"] = "publish";

            $posts_id = $this->posts_model->update($id,$input_posts);
            
            $input_content = array();
            $input_content["publish_date"] = date('Y-m-d H:i:s');

            $this->content_model->update($content["id"],$input_content);

            $content_data= $this->content_model->find($content["id"]);
            
            $passData['msg'] = "success publish  content ".$content_data["title"];
            $passData['msg_status'] = "success";
            $this->session->set_userdata("temporary_data",$passData);
            redirect($this->controller_name);

    }

    public function popup_headline($headline_id=""){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener_popup_headline/'.$headline_id;
        $data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));
        $data["headline_id"] = $headline_id;
        $data["foot"]=$this->load->view("template/includes/admin-foot", "", TRUE);
        $data["head"] = $this->load->view("template/includes/admin-head","", TRUE);
        $this->template->loadView($this->controller_name.'/popup_headline',$data,'');
    }

    /**
     * datatable listener
     */
    public function listener_popup_headline($headline_id){
        $datatables = $this->datatables;

        $menu_id[] = 1;
        $menu_data = $this->menu_model->all(" AND parent = 1 ");
        foreach ($menu_data as $key => $value) {
            $menu_id[]=$value["id"];
            $second = $this->menu_model->all(" AND parent =  ".$value["id"]);
            foreach ($second as $key_1 => $value_1) {
                $menu_id[]=$value_1["id"];
            }
        }
        $menu_id = implode(",", $menu_id);

        $data = $datatables
            ->select(" a.id, a.title, writer.full_name as writer, editor.full_name as editor, c.full_name as created_by, kategori.name as kategori,
                section.name as section, b.publish_date as publish_date, a.status ",false)
            ->from('posts a')
            ->join('content b', 'b.posts_id = a.id',"left")
            ->join('user c', 'c.id = a.created_by',"left")
            ->join('user writer', 'writer.id = b.writer',"left")
            ->join('user editor', 'editor.id = b.editor',"left")
            ->join('menu kategori', 'kategori.id = a.menu_id',"left")
            ->join('menu section', 'section.id = kategori.parent',"left")
            ->where(' a.menu_id IN ('.$menu_id.') ',NULL,false)
            ->where('a.deleted_at',NULL)
            ->add_column("action", "$1", "action_helper('nh_admin/galery',id,".$headline_id.",'headline')")
            ->generate();
        echo $data;
    }



}