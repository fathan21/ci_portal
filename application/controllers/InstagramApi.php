<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstagramApi extends NS_Controller {

	public function index()
	{
		$data = array();
        $data["title"] = "instagram";


        $this->load->config('meta');
        $company_model =  new master_model('company');
        $user_model =  new master_model('user');
        $company_template = $company_model->find(1);
        $user_data = $this->session->userdata("user_data");
        if($company_template){
            $data["company_data"] = $company_template;
        }
        if(isset($user_data["id"])){
            $data["user_template"] = $user_data;
        }
        $data["company_data"]["twitter_at"] = $this->config->item('twitter');

        $meta["title"]=isset($data["title"])?$data["title"]:$this->config->item('title');
        $meta["fb_app_id"]=$this->config->item('fb_app_id');
        $meta["site_name"]=$this->config->item('site_name');
        $meta["type"]=$this->config->item('type'); //ex. article
        $meta["copyright"]=$this->config->item('copyright');
        $meta["app_name"]=$this->config->item('site_name');
        $meta['twitter'] = $this->config->item('twitter');
        $meta["keywords"]=isset($data["data"]["key_word"])?$data["data"]["key_word"]:$this->config->item('key_word');
        $meta["description"]=isset($data["data"]["description"])?$data["data"]["description"]:$this->config->item('description');
        $meta["tags"]=isset($data["data"]["tags"])?$data["data"]["tags"]:$this->config->item('tags');
        $meta["data"]["content"] = isset($data["data"]["content"])?$data["data"]["content"]:$this->config->item('content');

        $slide_db = $this->get_slide();
        $data["slide_db"] = $slide_db["news"];
        $data["meta"] = $meta;

		//$this->template->loadView('public/instagram/index',$data);
		$this->load->view("template/includes/public-head",$data);
		$this->load->view("public/instagram/index.php",$data);
		$this->load->view("template/includes/public-foot",$data);
	}


	public function get_slide()
	{
        $posts_model        = new master_model('posts');

        

        $where = "";
            $where = ' 
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
             ';
            $limit = ' LIMIT 3 ';
        
     	$news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img,b.tags,a.id
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 JOIN content c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN menu f ON a.menu_id = f.id
                     LEFT JOIN headline g ON a.id = g.posts_id
     				 WHERE 
                     a.deleted_at IS NULL
                     AND f.is_single_page = 0
                     AND a.status='publish'
     				 $where
     				 $limit
     				 ";
     	$news = $this->db->query($news_db)->result_array(); 

        $id = array();
        foreach ($news as $key => $value) {
            $id[] = $value["id"]; 
        }

        $result["news"] = $news;
        $result["id"] = $id;
     	return $result;
	}
}
