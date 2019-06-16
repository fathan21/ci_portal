<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends NS_Controller {

	public function __construct(){		
		parent::__construct();

        $this->data = array();


        $this->controller_name = "content";
        $this->title = "Content";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
	}

	public function category($menu=""){
        //get menu data
        $menu_model        = new master_model('menu');
        $menu = str_ireplace("_"," ",strtolower($menu));
        $menu_db = $menu_model->find($menu,"LOWER(name)");

        if(!isset($menu_db["id"])){
            redirect('test');
            die();
        }

		$data["title"] = $menu_db["name"];
        $data['menu_id'] = $menu_db['id'];
        //$data["breadcrumb"] = array(array("title"=>$menu_db["name"],"link"=>"#","active"=>"active"));

        //set paging
        $data["page"] = (isset($this->input_data['page'])&&$this->input_data['page']!="") ? $this->input_data['page'] : "1";
        $data["limit"] = 7;
        $data['base_url_pagination'] = current_url();
        $news = $this->news($data["page"],$data["limit"],$menu_db["id"]);
        $data["news_db"] = $news["data"];
        $data["total"] = $news["total"];
        
        if($data["total"]>0){
            $data['pagination'] = generateBootstrapPagination($data['base_url_pagination'],$data["total"],$data["limit"]);
        }else{
            $data["pagination"] = "";
        }
        //set paging
        // check load more
        if($data['total'] > 7){
            $data['load_more'] = 1;
        }


        $data["slide_db"] = $this->get_slide($menu_db["id"]);
		$this->template->loadView('public/home/content',$data,'public');
	}


    public function get_datas(){
        //set paging
        $data["page"] = (isset($this->input_data['page'])&&$this->input_data['page']!="") ? $this->input_data['page'] : "1";
        $data["menu_id"] = (isset($this->input_data['menu_id'])&&$this->input_data['menu_id']!="") ? $this->input_data['menu_id'] : "1";
        $data["limit"] = 7;
        $news = $this->news($data["page"],$data["limit"],$data['menu_id']);
        

        echo json_encode($news);
    }

	public function news($page=1,$limit=7,$menu_id="",$limit_slide=1)
	{

        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');
        $page--;
        $offset = $page * $limit;
        $offset = $offset+$limit_slide; // 3 from slide

        $where = "";
        if($menu_id!=""){
            $menu_db = $menu_model->all(" AND parent= ".$menu_id);
            $menu_id=array();
            foreach ($menu_db as $key => $value) {
                $menu_id[] =$value["id"];
            }

            if(count($menu_id)>0){
                $menu_id = implode(",", $menu_id);
                $where .= " AND a.menu_id  IN ($menu_id) ";
            }   
        }


     	$news_db = " SELECT a.title,c.publish_date, IF(d.image_small IS NULL,d.image_thumbnail,d.image_small ) as img, d.name as alt,b.tags,a.id
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 LEFT JOIN content c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
     				 WHERE 
     				 a.deleted_at IS NULL
                     AND a.status='publish'
     				 $where
                     GROUP BY a.id
     				 ORDER BY c.publish_date DESC
                     LIMIT $offset,$limit
     				 ";
        $total = " SELECT a.title,c.publish_date, d.image_thumbnail as img, d.name as alt,b.tags
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     LEFT JOIN content c ON a.id = c.posts_id
                     LEFT JOIN galery d ON d.id = c.galery_id
                     WHERE 
                     a.deleted_at IS NULL 
                     AND a.status='publish'
                     $where
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
                     ";
     	$news_db = $this->db->query($news_db)->result_array();
        $total = $this->db->query($total)->result_array();

     	$news = array();
     	foreach ($news_db as $key => $value) {
     		$array = $value;
     		$array["date"] = time_elapsed_string($value["publish_date"]);
     		$news[] = $array;
     	}   

        $result = array();
        $result["data"] = $news;
        $result["total"] = count($total);

     	return $result;
	}

	public function get_slide($menu_id="",$limit=1)
	{
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');

        $where = "";
        if($menu_id!=""){
            $menu_db = $menu_model->all(" AND parent= ".$menu_id);
            $menu_id=array();
            foreach ($menu_db as $key => $value) {
                $menu_id[] =$value["id"];
            }

            if(count($menu_id)>0){
                $menu_id = implode(",", $menu_id);
                $where .= " AND a.menu_id  IN ($menu_id) ";
            }   
        }
     	$news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img, d.name as alt,b.tags,a.id
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 LEFT JOIN content c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
     				 WHERE 
     				 a.deleted_at IS NULL
                     AND a.status='publish'
     				 $where
                     GROUP BY a.id
     				 ORDER BY c.publish_date DESC
     				 LIMIT $limit
     				 ";
     	$news = $this->db->query($news_db)->result_array();

     	return $news;
	}


    public function read($title){
        $posts_model        = new master_model('posts');
        //get menu data
        $title = str_ireplace("'","",$title);
        
        $title = explode("-",$title);
        $posts_db = $this->get_read($title[0]);
        $posts_id = $title[0];
        $posts_db = $posts_db["data"];
        if(!isset($posts_db["id"])){
            redirect('test');
            die();
        }

        $data["title"] = $posts_db["title"];
        $data["data"] = $posts_db;
        $data["data"]["view"] = $this->get_counter_post($title[0]);

        //$menu = str_ireplace("_"," ",strtolower($menu));
        //$menu_db = $menu_model->find($menu,"LOWER(name)");

        $data["breadcrumb"] = array(
                                    array("title"=>"<a href='".base_url()."'>Beranda</a>","active"=>""),
                                    array("title"=>"<a href='".base_url()."/".str_ireplace(" ", "_", strtolower($posts_db['category']))."' class='active'>".$posts_db['category']."</a>","link"=>"#","active"=>"active")
                                );
        $data["load_more"] = base_url()."/".str_ireplace(" ", "_", strtolower($posts_db['category']));

        if($data["data"]["terkait"]!=""){
            $terkait = explode(",", $data["data"]["terkait"]);
            $terkait_array = array();
            foreach ($terkait as $key => $value) {
                $terkait_data = $this->get_read($value);
                $terkait_data = $terkait_data['data'];
                $array = $terkait_data;
                $array["title"] = strtoupper($terkait_data["title"]);
                $array["href"] = $terkait_data["id"]."-".str_ireplace(" ",".",strtolower(trim($terkait_data["title"])));
                $terkait_array[] = $array;
            }
            $data["terkait"] = $terkait_array;
        }

        $data["terbaru"] = $this->get_terbaru($data["data"]["menu_id"],$posts_id);
        

        $data['slide_content'] = $this->get_slide_content($posts_id);

        $this->template->loadView('public/page/index',$data,'public');
    }



    public function get_slide_content($id)
    {


        $news_db = " SELECT a.* , b.image_thumbnail as img
                     FROM content_slide a 
                     LEFT JOIN galery b ON a.galery_id = b.id
                     WHERE 
                     a.deleted_at IS NULL
                     AND a.posts_id = '$id'
                     GROUP BY a.id
                     ORDER BY a.display_order ASC

                     ";
        $news = $this->db->query($news_db)->result_array();

        return $news;
    }
    public function get_read($id)
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');

        $where = "";
        if(isset($menu_id) &&$menu_id!=""){
            $menu_db = $menu_model->all(" AND parent= ".$menu_id);
            $menu_id=array();
            foreach ($menu_db as $key => $value) {
                $menu_id[] =$value["id"];
            }

            if(count($menu_id)>0){
                $menu_id = implode(",", $menu_id);
                $where .= " AND a.menu_id  IN ($menu_id) ";
            }   
        }
        $news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img,b.tags,a.id,a.content, a.menu_id, h.name as category,
                     e.full_name as writer_user, 
                     f.full_name as editor_user, d.name as alt,
                     b.*,c.*
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     LEFT JOIN content c ON a.id = c.posts_id
                     LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN user e ON c.writer = e.id
                     LEFT JOIN user f ON c.editor = f.id
                     LEFT JOIN menu g ON g.id = a.menu_id
                     LEFT JOIN menu h ON h.id = g.parent
                     WHERE 
                     a.deleted_at IS NULL
                     AND a.status='publish'
                     AND a.id = '$id'
                     GROUP BY a.id
                     LIMIT 1
                     ";
        $news = $this->db->query($news_db)->row_array();

        $result = array();
        $result["data"] = $news;
        return $result;
    }

    public function get_counter_post($id)
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');


        $counter_db = " SELECT SUM(count) as ctn 
                     FROM counter_hits
                     WHERE posts_id = $id
                     LIMIT 1
                     ";
        $counter = $this->db->query($counter_db)->row_array();

        $result = 2;
        if(isset($counter["ctn"]) && $counter["ctn"] >0 ){
            $result = $counter["ctn"]*2;
        }

        return $result;
    }
    public function get_terbaru($menu_id="",$posts_id)
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');

        $where = "";
        if($menu_id!=""){
            $menu_db = $menu_model->all(" AND parent= ".$menu_id);
            $menu_id=array();
            foreach ($menu_db as $key => $value) {
                $menu_id[] =$value["id"];
            }

            if(count($menu_id)>0){
                $menu_id = implode(",", $menu_id);
                $where .= " AND a.menu_id  IN ($menu_id) ";
            }   
        }
        if($posts_id!=""){
            //$where.= " AND a.id != $posts_id ";
        }
        $news_db = " SELECT a.title,c.publish_date, IF(d.image_small IS NULL,d.image_thumbnail,d.image_small ) as img, d.name as alt,b.tags,a.id
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     LEFT JOIN content c ON a.id = c.posts_id
                     LEFT JOIN galery d ON d.id = c.galery_id
                     WHERE 
                     a.deleted_at IS NULL
                     $where
                     AND a.status='publish'
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
                     LIMIT 4
                     ";
        $news = $this->db->query($news_db)->result_array();

        return $news;
    }


	
}
