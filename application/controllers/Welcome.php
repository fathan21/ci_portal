<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends NS_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function error_404(){
		$this->output->set_status_header('404');
		$data["title"] = "error";
		$data["code"] = 404;
		
		$this->template->loadView('public/error/index',$data,'public');
	}

	public function error($code){
		$data["title"] = "error";
		$data["code"] = $code;
		$this->template->loadView('nh_admin/error/index',$data,'admin');
	}

	public function counter()
	{
		$input_data = $this->input_data;

		if(!isset($input_data["ip"])){
			die();
		}
		$counter_model = new master_model('counter');
		$counter_hits_model = new master_model('counter_hits');

		$input_s = array();
		$input_s["ip"] = $input_data["ip"];
		$input_s["user_agent"] = $input_data["user_agent"];
		$input_s["date_time"] = date('Y-m-d H:i:s');

		$now = date('Y-m-d');
		$chk = $counter_model->find(trim($input_data["ip"]),"ip"," AND DATE(created_at) = '$now' ");

		if(isset($chk["id"])){
			$counter_model->update($chk["id"],$input_s);
		}else{
			$counter_model->add($input_s);
		}

		$page_data = explode("```", $input_data["page"]);
		
		if(isset($page_data[0]) && $page_data[0]=="galery"){
			
			$page = $page_data[0]!=""?$page_data[0]:"error/home";
			$posts_id= isset($page_data[2]) && $page_data[2]!=""?$page_data[2]:"";

			if($posts_id!=""){
				$posts_id = explode("-", $posts_id);
				$posts_id = $posts_id[0];	
				$posts_id = $posts_id > 0?$posts_id:"";
			}

		}else{
			$page = $page_data[0]!=""?$page_data[0]:"error/home";
			$posts_id= isset($page_data[1]) && $page_data[1]!=""?$page_data[1]:"";

			if($posts_id!=""){
				$posts_id = explode("-", $posts_id);
				$posts_id = $posts_id[0];	
				$posts_id = $posts_id > 0?$posts_id:"";
			}	
		}

		$input_s = array();
		$input_s["page"] = $page;
		$input_s["posts_id"] = $posts_id;
		$input_s["date"] = date('Y-m-d');


		$chk = $counter_hits_model->find($page,"page"," AND date = '$now' AND posts_id = '$posts_id' ");

		if(isset($chk["id"])){
			$input_s["count"]= $chk["count"]+1;
			$counter_hits_model->update($chk["id"],$input_s);
		}else{
			$input_s["count"] = 1;
			$counter_hits_model->add($input_s);
		}
		


		echo json_encode($input_s);
	}

	public function get_popular_news(){
		$posts_model = new master_model('posts');
		$last_30 = date("Y-m-d", strtotime("-14 days"));

		$now = date('Y-m-d');
		$q = " SELECT SUM(a.count) as ctn, a.posts_id
				FROM counter_hits a
				LEFT JOIN posts b ON a.posts_id = b.id
				WHERE 
				a.posts_id != ''
				AND ( b.created_at BETWEEN  '$last_30' AND '$now' )
				GROUP by a.posts_id
				ORDER by ctn DESC
				LIMIT 6
		 ";
		$q = $this->db->query($q)->result_array();
		
		$posts_id = array();
		if(count($q) > 0){

			foreach ($q as $key => $value) {
				$posts_id[] = $value["posts_id"];
			}	
		}else{
			$q = " SELECT SUM(a.count) as ctn, a.posts_id
					FROM counter_hits a
					LEFT JOIN posts b ON a.posts_id = b.id
					WHERE 
					a.posts_id != ''
					GROUP by a.posts_id
					ORDER by ctn DESC
					LIMIT 6
			 ";
			$q = $this->db->query($q)->result_array();

			foreach ($q as $key => $value) {
				$posts_id[] = $value["posts_id"];
			}
		}

		$posts_id = implode(",",$posts_id);

		//$posts = $posts_model->all(" AND id IN ($posts_id) ");
		$posts = $this->db->query(" SELECT id,type,title FROM posts WHERE id IN ($posts_id) ")->result_array();

		$data = array();
		foreach ($posts as $key => $value) {
			$array = $value;
			if($value["type"]=="galery"){
				$array["href"] = base_url('galery/read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))));
			}else{
				$array["href"] = base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))));
			}
			$data[] = $array;
		}

		echo json_encode(array("data"=>$data));
	}

	public function search(){
		$posts_model = new master_model('posts');
		
		$input_data = $this->input_data;	

        if(!isset($input_data["q"])){
            redirect('test');
            die();
        }

        $q = $input_data["q"];
        $where = " AND (title LIKE '%$q%' OR content LIKE '%$q%' ) ";
		$posts = $posts_model->all(" $where ORDER BY created_at DESC LIMIT 100 ");
		$news = array();
		foreach ($posts as $key => $value) {
			$array = $value;
			if($value["type"]=="galery"){
				$array["href"] = base_url('galery/read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))));
			}else{
				$array["href"] = base_url('content/read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))));
			}
			$string = strip_tags($value["content"]);

			if (strlen($string) > 300) {
			    // truncate string
			    $stringCut = substr($string, 0, 300);
			    // make sure it ends in a word so assassinate doesn't become ass...
			    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="'.$array["href"].'" class="link">Read More</a>'; 
			}
			$array["content"] = $string;
			$news[] = $array;
		}
		$data['news_db'] = $news;
		$data['title'] = "Pencarian";

		$this->template->loadView('public/home/search',$data,'public');
	}

	function bacaHTML($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$grab=curl_exec($ch);
		curl_close($ch);
		return $grab;

	}
 	public function cur()
 	{
 		//grab halaman kaskus.co.id;
		$hasil =$this->bacaHTML('http://www.indonesiansc.com/klasemen/isc-a-2016-17');
 		//$hasil = $this->bacaHTML('http://sport.detik.com/sepakbola/klasemen/1/italia');
		//pecah string hasil grabbing ke array match-info is-active
		$pecah = $this->explodeX(array('<table class="table table--default table--club-schedule" >', '</table>'), $hasil);
		//print_r ($pecah);
		echo $pecah[1];
 	}

 	//membuat fungsi explode dengan multiple delimiter (pembatas)
	function explodeX( $delimiters, $string ){
	    return explode( chr( 1 ), str_replace( $delimiters, chr( 1 ), $string ) );
	}


}
