<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//helper
    function generateSearchString($search,$sort_by = "",$order = "",$page = 1,$limit = ""){
        $str = "";
        $page--;
        $start = $page * $limit;
        $str .= " AND ( ";
        
        foreach($search as $key=>$val){
            if($key != 0){
                $str .= " OR ";
            }
            
            $str .= " ".$val[1]." ".$val[2]." '".$val[0]."'";
            
        }
        $str .= " ) ";
        if($sort_by != ""){
            $str .= " ORDER BY $sort_by $order";
        }
        if($limit != ""){
            $str .= " limit $start,$limit";
        }
    
        return $str;
    }
    function search_access_array($id, $array) {
        if(count($array)>0){
            foreach ($array as $key => $val) {
                if ($val['id'] === $id) {
                   return $val;
                }
            }
        }
       return null;
    }
    function generateBootstrapPagination($base_url,$total,$limit){
        //BEGIN PAGINATION
            $ci =& get_instance(); 
            $ci->load->library("pagination");
            $config['base_url'] = $base_url;
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $config['query_string_segment'] = "page";
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            $ci->pagination->initialize($config);
            return $ci->pagination->create_links();
        //END PAGINATION
    }
    function ismobile()
        {
            $mobile_browser = '0';
            if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                    $mobile_browser++;
            }
            if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                    $mobile_browser++;
            }
            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
            $mobile_agents = array(
                            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                            'wapr','webc','winw','winw','xda ','xda-');
            if (in_array($mobile_ua,$mobile_agents)) {
                    $mobile_browser++;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
                    $mobile_browser = 0;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'mac') > 0) {
                    $mobile_browser = 0;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ios') > 0) {
                    $mobile_browser = 1;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') > 0) {
                    $mobile_browser = 1;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows phone') > 0) {
                    $mobile_browser = 1;
            }   
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone os') > 0) {
                    $mobile_browser = 1;
            }
            return $mobile_browser;
    }
    function getPrefixNo($id)
    {
        
        $ci =& get_instance(); 
        $ci->load->model("prefix_model");
        $ci->load->database();
        $structure = $ci->db->query("SELECT * FROM prefix WHERE id = '$id' ORDER BY running_number DESC LIMIT 1")->row_array();
        
        $intial = $structure['prefix'];
        $length = $structure['length'];
        if ($structure['running_number'] >= 1)
        {
            $number = intval($structure['running_number']);
        }else{
            $number = 0;
        }
        $number++;
        $tmp= "";
        for ($i=0; $i < ($length-strlen($number)) ; $i++)
        {
            $tmp = $tmp."0";
        }
        $ci->prefix_model->update($id,array('running_number'=>$number));
        //return generate ID
        return strval($intial.$tmp.$number);
    }
    
    function upload_handler($file_name,$new_name,$new_path, $required = true,$old_file_path = "",$width_thumb=780,$height_thumb=390){
        $ci =& get_instance();
        $returnData = array();
        $config['upload_path'] = $new_path;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '1024';
        //$config['max_width']  = '1024';
        //$config['max_height']  = '1024';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $new_name;
        $ci->load->library('upload', $config);
        if(isset($_FILES[$file_name]))
        {
            if (!$ci->upload->do_upload($file_name))
            {
                
                $returnData['error'] =  $ci->upload->display_errors();
                $returnData['status'] = 0;
            }
            else
            {
             
                $upload_data = $ci->upload->data();
                $returnData['file_path'] = $new_path.$upload_data['raw_name'].$upload_data['file_ext'];
           
                $parts = explode(".",$upload_data['full_path']);
                $ci->load->library('image_lib');
                    /* read the source image */
                    if($upload_data['file_type'] == "image/jpeg" || $upload_data['file_type'] == "image/jpg"){
                         $source_image = imagecreatefromjpeg($upload_data['full_path']);
                    }
                    else if($upload_data['file_type'] == "image/png"){
                        $source_image = imagecreatefrompng($upload_data['full_path']);
                    }
                    else if($upload_data['file_type'] == "image/gif"){
                        $source_image = imagecreatefromgif($upload_data['full_path']);
                    }
                    $x=$width_thumb; $y=$height_thumb; // my final thumb
                    $ratio_thumb=$x/$y; // ratio thumb
                    list($xx, $yy) = getimagesize($upload_data["full_path"]); // original size
                    $ratio_original=$xx/$yy; // ratio original
                    if ($ratio_original>=$ratio_thumb) {
                        $yo=$yy; 
                        $xo=ceil(($yo*$x)/$y);
                        $xo_ini=ceil(($xx-$xo)/2);
                        $xy_ini=0;
                    } else {
                        $xo=$xx; 
                        $yo=ceil(($xo*$y)/$x);
                        $xy_ini=ceil(($yy-$yo)/2);
                        $xo_ini=0;
                    }
                    $virtual_image = imagecreatetruecolor($width_thumb, $height_thumb);
                    imagecopyresampled($virtual_image, $source_image, 0, 0, $xo_ini, $xy_ini, $x, $y, $xo, $yo);
                
                    /* create the physical thumbnail image to its destination */
                    $thumbnail_path = $upload_data['file_path']."/".$upload_data['raw_name']."_thumb".$upload_data['file_ext'];
                    $returnData['thumbnail_path'] = $new_path."".$upload_data['raw_name']."_thumb".$upload_data['file_ext'];
                    if($upload_data['file_type'] == "image/jpeg" || $upload_data['file_type'] == "image/jpg"){
                         imagejpeg($virtual_image, $thumbnail_path);
                    }
                    else if($upload_data['file_type'] == "image/png"){
                         imagepng($virtual_image, $thumbnail_path);
                    }
                    else if($upload_data['file_type'] == "image/gif"){
                         imagegif($virtual_image, $thumbnail_path);
                    }
                  $returnData['status'] = 1;
                //END CREATING THUMBNAILS
                //BEGIN DELETE OLD FILE
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
                //END DELETE OLD FILE
            }
        }
        else{
            if($required){
                $returnData['status'] = 1;
            }
            else{
                $returnData['status'] = 0;
            }
        }
        
        return $returnData;
    }
    function upload_handler_2($file_name,$new_name,$new_path, $required = true,$old_file_path = "",$thumbnail_size=28){
        $ci =& get_instance();
        $returnData = array();
        $config['upload_path'] = $new_path;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '1024';
        //$config['max_width']  = '1024';
        //$config['max_height']  = '1024';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $new_name;
        $ci->load->library('upload', $config);
        if(isset($_FILES[$file_name]))
        {
            if (!$ci->upload->do_upload($file_name))
            {
                
                $returnData['error'] =  $ci->upload->display_errors();
                $returnData['status'] = 0;
            }
            else
            {
             
                $upload_data = $ci->upload->data();
                $returnData['file_path'] = $new_path.$upload_data['raw_name'].$upload_data['file_ext'];
           
                $parts = explode(".",$upload_data['full_path']);
                $ci->load->library('image_lib');
                    /* read the source image */
                    if($upload_data['file_type'] == "image/jpeg" || $upload_data['file_type'] == "image/jpg"){
                         $source_image = imagecreatefromjpeg($upload_data['full_path']);
                    }
                    else if($upload_data['file_type'] == "image/png"){
                        $source_image = imagecreatefrompng($upload_data['full_path']);
                    }
                    else if($upload_data['file_type'] == "image/gif"){
                        $source_image = imagecreatefromgif($upload_data['full_path']);
                    }
                    $width = imagesx($source_image);
                    $height = imagesy($source_image);
                    /* create a new, "virtual" image */
                  
                    
                    // first resize the image 
                    $thumbnail_size = 28;
                    $thumbnail_size = $thumbnail_size;
                    if ($width < $height){
                        $desired_width = $thumbnail_size;
                        $desired_height = round($height * ($desired_width / $width));
                        $w_start = 0;
                        $h_start = $desired_height / 2 - ($thumbnail_size/2);
                    }else{
                        $desired_height = $thumbnail_size;
                        $desired_width = round($width * ($desired_height / $height));
                        $w_start = $desired_width / 2 - ($thumbnail_size/2);
                        $h_start = 0;
                    }
                    /* copy source image at a resized size based on the shortest length */
                    $virtual_image = imagecreatetruecolor(22, 28);
                    //imagecopyresampled($virtual_image, $source_image, -$w_start, -$h_start, 0, 0, $desired_width, $desired_height, $width, $height);
                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, 28, 22, $width, $height);
                
                    /* create the physical thumbnail image to its destination */
                    $thumbnail_path = $upload_data['file_path']."/".$upload_data['raw_name']."_thumb".$upload_data['file_ext'];
                    $returnData['thumbnail_path'] = $new_path."".$upload_data['raw_name']."_thumb".$upload_data['file_ext'];
                    if($upload_data['file_type'] == "image/jpeg" || $upload_data['file_type'] == "image/jpg"){
                         imagejpeg($virtual_image, $thumbnail_path);
                    }
                    else if($upload_data['file_type'] == "image/png"){
                         imagepng($virtual_image, $thumbnail_path);
                    }
                    else if($upload_data['file_type'] == "image/gif"){
                         imagegif($virtual_image, $thumbnail_path);
                    }
                  $returnData['status'] = 1;
                //END CREATING THUMBNAILS
                //BEGIN DELETE OLD FILE
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
                //END DELETE OLD FILE
            }
        }
        else{
            if($required){
                $returnData['status'] = 1;
            }
            else{
                $returnData['status'] = 0;
            }
        }
   
        return $returnData;
    }
    function preprocess_date($date_data){
        if($date_data == "" || $date_data == "0000-00-00"){
            $ret_data = NULL;
        }else{
            $ret_data = date("Y-m-d",strtotime($date_data));
        }
        return $ret_data;
    }
    function view_date($date_data){
   
        if($date_data == "" || $date_data == "0000-00-00"){
            $date_data = "";
        }else{
            $date_data = date("d-m-Y",strtotime($date_data));
        }
        return $date_data;
    }
    function date_indo_str($date){
        $name = date('N', $date);
        $date_num = date('d', $date);
        $date_month = date('m', $date);
        $date_year = date('Y', $date);
        $array_day_name = array('Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
        $array_month = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
        $day_name = $array_day_name[(Int)$name-1];
        $date_month = $array_month[(Int)$date_month-1];
        return  $day_name.", ".$date_num." ".$date_month." ".$date_year ;
    }
    function date_time_indo_str($date){
        $name = date('N', $date);
        $date_num = date('d', $date);
        $date_month = date('m', $date);
        $date_year = date('Y', $date);
        $hour = date('H', $date);
        $minute = date('i', $date);
        $array_day_name = array('Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
        $array_month = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
        $day_name = $array_day_name[(Int)$name-1];
        $date_month = $array_month[(Int)$date_month-1];
        return  $day_name.", ".$date_num." ".$date_month." ".$date_year." | ".$hour.":".$minute ;
    }
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full){
          $string = array_slice($string, 0, 1);  
        }
        if(isset($string["s"]) || isset($string["i"]) || isset($string["h"])){
            return $string ? implode(', ', $string) . ' lalu' : 'sekarang';
        }else{
            return date_indo_str(strtotime($datetime));
        }
    }
    function get_ip() {
    $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    function send_mail($to="",$subject="",$message="",$attac_file=""){ 
        $ci =& get_instance();        
        $ci->load->config('email');
        $ci->load->library('email');
        $ci->email->clear(TRUE);
        $ci->email->set_newline("\r\n");
        $ci->email->from("iagus048@gmail.com");
        //$to = "mft.aang@gmail.com";
        
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($message);
        if($attac_file!=""){
            $ci->email->attach($attac_file);
        }
        $smtp_pass = $ci->config->item('smtp_pass');
        if($smtp_pass == ""){
            return 1;
        }
        try {
            $ci->email->send();
            //$email_debug = $ci->email->print_debugger();
            
            if($attac_file!=""){
                unlink("./".$attac_file);
            }
            return 0; 
        } catch (Exception $e) {
            return 1;;
        }
        
    }
    function generate_password(){ 
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($i = 0; $i < 8; $i++)
            $result .= $characters[mt_rand(0, 61)];
        return $result;
    }
    function cur_klasmen_tsc(){
        $ci =& get_instance(); 
        $ci->load->helper('simple_html_dom_helper');
        
        try {
            
            $html =file_get_html('http://www.indonesiansc.com/klasemen/torabika-soccer-championship');
            
            $table = $html->find('table[class=table table--default table--club-schedule]', 0);
            $posisi = array();
            $klub = array();
            $main = array();
            $poin = array();
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                foreach($row->find('td') as $key=>$cell) {
                    // push the cell's text to the array
                    switch ($key) {
                        case 0:
                            $posisi[]=$cell->plaintext;
                            break;
                        case 1:
                            $klub[]=$cell->plaintext;
                            break;
                        case 2:
                            $main[]=$cell->plaintext;
                            break;
                        case 9:
                            $poin[]=$cell->plaintext;
                            break;
                        default:
                            break;
                    }
                }
            }
            return array('klub'=>$klub,'main'=>$main,'poin'=>$poin);
        } catch (Exception $e) {
            cur_klasmen_tsc();
        }
    }
    function cur_top_score_tsc(){
        $ci =& get_instance(); 
        $ci->load->helper('simple_html_dom_helper');
        
        try {
            
            $html =file_get_html('http://www.indonesiansc.com/klasemen/torabika-soccer-championship');
            
            $table = $html->find('table[class=table table--default]', 0);
            $posisi = array();
            $nama = array();
            $asist = array();
            $gol = array();
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                foreach($row->find('td') as $key=>$cell) {
                    // push the cell's text to the array
                    switch ($key) {
                        case 0:
                            $posisi[]=$cell->plaintext;
                            break;
                        case 1:
                            $nama[]=$cell->plaintext;
                            break;
                        case 2:
                            $asist[]=$cell->plaintext;
                            break;
                        case 3:
                            $gol[]=$cell->plaintext;
                            break;
                        default:
                            break;
                    }
                }
            }
            return array('nama'=>$nama,'asist'=>$asist,'gol'=>$gol);
        } catch (Exception $e) {
            cur_top_score_tsc();
        }
    }
    function get_klasmen_tsc_3()
    {
        $data = '';
        $data = cur_klasmen_tsc();
               // table-scrollable scroll-style
            
            $template = '  
                <div class="portlet klasmen-box">
                  <div class="portlet-title">
                    <button type="botton" class="btn btn-block caption btn-side-home-title">
                        Klasemen TSC
                    </button>
                  </div>
                  <div class="portlet-body">
                    <div class="">
                      <table class="table  table-striped table-condensed " >
                          <thead >
                              <tr>
                                <th>Posisi
                                </th>
                                <th>Klub
                                </th>
                                <th>Main
                                </th>
                                <th>Poin
                                </th>
                              </tr>
                          </thead>
                          <tbody>
            ';
            foreach ($data['klub'] as $key => $value) {
                $no = $key+1;
                $value = strlen($value)>19?substr($value, 0,17)."...":$value;
                $template .='
                          <tr>
                                <td class="text-center">
                                  '.$no.'
                                </td>
                                <td>
                                    '.$value.'
                                </td>
                                <td class="text-center">
                                    '.$data['main'][$key].'
                                </td>
                                <td class="text-center">
                                    '.$data['poin'][$key].'
                                </td>
                          </tr>
                ';
            }
            $template .='
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            ';
            
        return $template;
    }

    function get_klasmen_tsc()
    {
        return '';
        $data = '';

        $url = @file_get_contents("http://www.indonesiansc.com/klasemen/torabika-soccer-championship");
        if ($url) {
            $data = cur_klasmen_tsc();
            $top_score = cur_top_score_tsc();
        }else{
            $data = array();
            return '';
        }
               // table-scrollable scroll-style
        $template = '

        ';

            $template .= '  
                <div class="portlet klasmen-box">
                  <div class="portlet-title">
                    <button type="botton" class="btn btn-block btn-side-home">
                        TSC 2016
                    </button>
                  </div>
                  <div class="portlet-body">
                    <div class="">


                      <div class="tab-style-1">
                          <ul class="nav nav-tabs ">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Klasemen</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Top Skor</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Jadwal</a></li>
                          </ul>
                          <div class="tab-content">
                            <div id="tab-1" class="tab-pane  fade active in">

                              <table class="table  table-striped table-condensed " >
                                  <thead >
                                      <tr>
                                        <th>Posisi
                                        </th>
                                        <th>Klub
                                        </th>
                                        <th>Main
                                        </th>
                                        <th>Poin
                                        </th>
                                      </tr>
                                  </thead>
                                  <tbody>
            ';

            if(count($data) > 0 ){
                foreach ($data['klub'] as $key => $value) {
                    $no = $key+1;
                    //$value = strlen($value)>19?substr($value, 0,18)."...":$value;
                    $klub = strtolower($value) == "persija"?"<span style='font-weight:900'>".$value."</span>":$value;
                    $no = strtolower($value) == "persija"?"<span style='font-weight:900'>".$no."</span>":$no;
                    $data['main'][$key] = strtolower($value) == "persija"?"<span style='font-weight:900'>".$data['main'][$key]."</span>":$data['main'][$key];
                    $data['poin'][$key] = strtolower($value) == "persija"?"<span style='font-weight:900'>".$data['poin'][$key]."</span>":$data['poin'][$key];
                    
                    $template .='
                              <tr>
                                    <td class="text-center">
                                      '.$no.'
                                    </td>
                                    <td>
                                        '.$klub.'
                                    </td>
                                    <td class="text-center">
                                        '.$data['main'][$key].'
                                    </td>
                                    <td class="text-center">
                                        '.$data['poin'][$key].'
                                    </td>
                              </tr>
                    ';
                }
            }

            $template .='
                          </tbody>
                      </table>

                        </div>

                        <div id="tab-2" class="tab-pane fade">
                            <table class="table  table-striped table-condensed " >
                                <thead >
                                      <tr>
                                        <th>Nama
                                        </th>
                                        <!--th>Assist
                                        </th-->
                                        <th>Gol
                                        </th>
                                      </tr>
                                </thead>
                                <tbody>
                                ';

            if(count($data) > 0 ){
                foreach ($top_score['nama'] as $key => $value) {
                    $no = $key+1;

                    //$value = strlen($value)>19?substr($value, 0,18)."...":$value;
                    $template .='
                              <tr>
                                    <td>
                                        '.$value.'
                                    </td>
                                    <!--td class="text-center">
                                        '.$top_score['asist'][$key].'
                                    </td-->
                                    <td class="text-center">
                                        '.$top_score['gol'][$key].'
                                    </td>
                              </tr>
                    ';
                }
            }
            $template .='
                                </tbody>
                          </table>
                        </div>


                        <div id="tab-3" class="tab-pane fade">
                            <table class="table  table-striped table-condensed " >
                                <thead >
                                    <tr>
                                        <th>Tanggal
                                        </th>
                                        <th>Pertandingan
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>04/09/2016
                                        </td>
                                        <td>Semen Padang vs <span style="font-weight:900">Persija</span> 
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>09/09/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Persipura
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16/09/2016
                                        </td>
                                        <td>Persela vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>02/10/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Perseru 
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>09/10/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Barito Putera
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>14/10/2016
                                        </td>
                                        <td>PS TNI vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>19/10/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Arema Cronus
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>23/10/2016
                                        </td>
                                        <td>Sriwijaya FC vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>30/10/2016
                                        </td>
                                        <td>Borneo FC vs <span style="font-weight:900">Persija</span> 
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>05/11/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Persib
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13/11/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Persiba
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>20/11/2016
                                        </td>
                                        <td>Madura United vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>27/11/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs SU Bhayangkara
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>01/12/2016
                                        </td>
                                        <td>Mitra Kukar vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>07/12/2016
                                        </td>
                                        <td><span style="font-weight:900">Persija</span> vs Gresik United 
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10/12/2016
                                        </td>
                                        <td>PSM vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>18/12/2016
                                        </td>
                                        <td>Bali United vs <span style="font-weight:900">Persija</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>

                                </tbody>
                          </table>
                        </div>

                      </div>
                    </div>

                    </div>
                  </div>
                </div>
            ';

            

        return $template;

    }


    function resize_image($file, $w, $h,$new_path){
        $ci =& get_instance();
        $returnData = array();

        $info = getimagesize($file);
        $file_ext = image_type_to_extension($info[2]);
        $mime   = $info['mime'];

        $name = explode(".",$file);
        $name = explode("/", $name[0]);
        $name = end($name);
        $name = str_ireplace('_thumb','',$name);

        list($width, $height) = getimagesize($file);
        $r = $width / $height;


        if($mime == "image/jpeg" || $mime == "image/jpg"){
            $source_image = imagecreatefromjpeg($file);
        }
        else if($mime == "image/png"){
            $source_image = imagecreatefrompng($file);
        }
        else if($mime == "image/gif"){
            $source_image = imagecreatefromgif($file);
        }
        $thumbnail_path = '';
        /* copy source image at a resized size based on the shortest length */
        $virtual_image = imagecreatetruecolor($w, $h);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $w, $h, $width, $height);
        
        /* create the physical thumbnail image to its destination */
        $thumbnail_path = $new_path."".$name."_small".$file_ext;
        
        if($mime == "image/jpeg" || $mime == "image/jpg"){
             imagejpeg($virtual_image, $thumbnail_path);
        }
        else if($mime == "image/png"){
             imagepng($virtual_image, $thumbnail_path);
        }
        else if($mime == "image/gif"){
             imagegif($virtual_image, $thumbnail_path);
        }

        return $thumbnail_path;
    }

