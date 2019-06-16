<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//template





class Template

{



	public function loadView($bodypath,$data,$type)
    {
        $ci =& get_instance();
        $ci->load->config('meta');
        $company_model =  new master_model('company');
        $user_model =  new master_model('user');
        $company_template = $company_model->find(1);
        $user_data = $ci->session->userdata("user_data");
        if($company_template){
            $data["company_data"] = $company_template;
        }
        if(isset($user_data["id"])){
            $data["user_template"] = $user_data;
        }
        $data["company_data"]["twitter_at"] = $ci->config->item('twitter');

        $meta["title"]=isset($data["title"])?$data["title"]:$ci->config->item('title');
        $meta["fb_app_id"]=$ci->config->item('fb_app_id');
        $meta["site_name"]=$ci->config->item('site_name');
        $meta["type"]=$ci->config->item('type'); //ex. article
        $meta["copyright"]=$ci->config->item('copyright');
        $meta["app_name"]=$ci->config->item('site_name');
        $meta['twitter'] = $ci->config->item('twitter');
        $meta["keywords"]=isset($data["data"]["key_word"])?$data["data"]["key_word"]:$ci->config->item('key_word');
        $meta["description"]=isset($data["data"]["description"])?$data["data"]["description"]:$ci->config->item('description');
        $meta["tags"]=isset($data["data"]["tags"])?$data["data"]["tags"]:$ci->config->item('tags');
        $data["data"]["content"] = isset($data["data"]["content"])?$data["data"]["content"]:$ci->config->item('content');
        
        //print_r($meta);
          $string = strip_tags($data["data"]["content"]);
          if (strlen($string) > 200) {
              $stringCut = substr($string, 0, 200);
              $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
          }
        $meta["content"]=$string;
        
        $data["meta"] = $meta;

        if($type == "admin")
        {
            $data["meta"] = isset($data["meta"]) && count($data["meta"])>0?$data["meta"]:array();
            $data['head'] = $ci->load->view("template/includes/".$type."-head",$data,TRUE);
            $data['header'] = $ci->load->view("template/includes/".$type."-header",$data,TRUE);
            $data['sidebar'] = $ci->load->view("template/includes/".$type."-sidebar",$data,TRUE);
            $data['footer'] = $ci->load->view("template/includes/".$type."-footer",$data,TRUE);
            $data['foot'] = $ci->load->view("template/includes/".$type."-foot",$data,TRUE);
            $data['content'] = $ci->load->view($bodypath,$data,TRUE);
            $view = $ci->load->view("template/admin.php",$data,TRUE);

        }
        else if($type == "public")
        {
            $data["meta"] = isset($data["meta"]) && count($data["meta"])>0?$data["meta"]:array();
            $data['head'] = $ci->load->view("template/includes/".$type."-head",$data,TRUE);
            $data['header'] = $ci->load->view("template/includes/".$type."-header",$data,TRUE);
            $data['side_content'] = $ci->load->view("template/includes/".$type."-side-content",$data,TRUE);
            $data['content'] = $ci->load->view($bodypath,$data,TRUE);
            $data['foot'] = $ci->load->view("template/includes/".$type."-foot",$data,TRUE);
            $data['footer'] = $ci->load->view("template/includes/".$type."-footer",$data,TRUE);
            $view = $ci->load->view("template/public.php",$data,TRUE);
            $view = trim(preg_replace('~[\r\n]+~', ' ', $view));
        }
        else
        {
            $view = $ci->load->view($bodypath,$data,TRUE);
        }

        $ci->load->config('config');
        // Inject into form
        $view = preg_replace('/(<(form|FORM)[^>]*(method|METHOD)="(post|POST)"[^>]*>)/',
                               '$0<input type="hidden" name="' . $ci->config->item('csrf_token_name') . '" value="' . $ci->session->userdata($ci->config->item('csrf_token_name')). '">', 
                               $view);
        
        // Inject into <head>
        $view = preg_replace('/(<\/head>)/',
                               '<meta name="csrf-name" content="' . $ci->config->item('csrf_token_name') . '">' . "\n" . '<meta name="csrf-token" content="' . $ci->session->userdata($ci->config->item('csrf_token_name')) . '">' . "\n" . '$0', 
                               $view);
        //$view = str_replace(PHP_EOL, '', $view);
        $view = rtrim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $view));
        
        echo $view;
    }


}

