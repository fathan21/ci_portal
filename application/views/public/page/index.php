      <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12 ">
            <div class="content-page">
              <div class="row">
                <!-- BEGIN LEFT SIDEBAR -->            
                <div class="col-md-9 col-sm-9 blog-item">
                  <div class="blog-item-img">
                      <img  width="100%" class="img-responsive" src="<?=base_url($data["img"])?>" alt="<?=isset($data["alt"])?$data["alt"]:""?>" title="<?=isset($data["alt"])?$data["alt"]:""?>">  
                      <div class="photo-caption"><?=$data["photo_caption"]?></div>
                  </div>
                  <div class="title" ><?=$data["title"]?></div>

                  <div  class="date-time">
                      <?=date_time_indo_str(strtotime($data["publish_date"]))?>&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php if(isset($data["view"])){ ?>
                        <span><i class="fa fa-eye"></i> <?=$data["view"]?> Kali</span>
                      <?php } ?>
                  </div>
                  <div  class="blog-content content">
                    <?php if(count($slide_content) >0 ){ ?>
                      <div class="conten-slide" data-slide-content="0">
                        <div class="clearfix text-center content-slide-controll" >
                          <div class="pull-left">
                          </div>
                          <div class="pull-right">
                            <button type="button" class="btn btn-side-home btn-lg btn-slide-controll" data-slide-url="1">
                              MULAI SLIDESHOW
                            </button>
                          </div>
                        </div>
                        <div class="clearfix content-slide-content" >
                            <?php if($data["lead"]!=""){ ?>
                              <blockquote>
                                <?=$data["lead"]?>
                              </blockquote>             
                            <?php } ?>   
                            <?=$data["content"]?>
                        </div>
                      </div>

                      <?php foreach ($slide_content as $key => $value) { ?>
                        <div class="conten-slide" data-slide-content="<?=$key+1?>" style="display:none;">
                          <div class="clearfix text-center content-slide-controll" >
                            <div class="pull-left">
                              <button type="button" data-slide-url="0" class="btn red-sunglo btn-lg btn-side-home btn-slide-controll btn-slide-controll-icon"><i class="fa fa-angle-double-left"></i></button>
                              <button type="button" data-slide-url="<?=$key?>" class="btn red-sunglo btn-lg btn-side-home btn-slide-controll">KEMBALI</button>
                            </div>
                                <?=$key+1?> / <?=count($slide_content)?>
                                
                            <div class="pull-right">
                              <?php if($key+1 < count($slide_content)){ ?>
                                <button type="button" class="btn btn-side-home btn-lg btn-slide-controll"  data-slide-url="<?=$key+2?>">
                                  LANJUT 
                                </button>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="clearfix content-slide-title" >
                            <?=$value['display_order']?>. <?=$value['title']?>
                          </div>
                          <div class="clearfix content-slide-content" >
                              <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                  <img  width="100%" class="img-responsive" src="<?=base_url($value["img"])?>" alt="<?=isset($data["alt"])?$data["alt"]:""?>" title="<?=isset($data["alt"])?$data["alt"]:""?>">  
                                </div>
                              </div>
                              <?=$value['content']?>
                          </div>
                        </div>
                      <?php } ?>

                    <?php }else{ ?>

                      <?php if($data["lead"]!=""){ ?>
                        <blockquote>
                          <?=$data["lead"]?>
                        </blockquote>             
                      <?php } ?>   
                      <?=$data["content"]?>
                    
                    <?php } ?>

                  </div>

                  <ul class="blog-info" >
                    <li>
                      <span  class="content-label">Penulis :  </span>
                      <span  class="content-info"><?=$data["writer_user"]!=''?ucwords($data["writer_user"]):"-"?></span>
                    </li>

                    <?php if(isset($data["sumber"]) && $data["sumber"]!="" ){ ?>
                      <li class="content-sumber">
                        <span  class="conten-label">Sumber :  </span>
                        <span  class="content-info"><?=$data["sumber"]!=''?ucwords($data["sumber"]):"-"?></span>
                      </li>
                    <?php } ?>

                    <li class="content-sumber">
                      <span  class="content-label">Tags :  </span>
                      <span  class="content-info"><?=$data["tags"]!=''?ucwords($data["tags"]):"-"?></span>
                    </li>
                  </ul>
                  <div class="clearfix"><h6>Sebarkan:</h6></div>
                  <div class="clearfix share-div-desktop" >
                      <button type="button" class="btn btn-sm blue share_button_fb" id="share_button_fb"  data-href="<?=current_url()?>">
                         <i class="fa fa-facebook"></i>  Share
                      </button>
                      <button type="button" class="btn btn-sm btn-info" onclick="share_t('twitter')" style="color:#fff">
                        <i class="fa fa-twitter"></i> Share
                      </button>
                      <button type="button" class="btn btn-sm btn-danger" onclick="share_t('google')" style="color:#fff">
                        <i class="fa fa-google"></i> Share
                      </button>
                  </div>
                  <div class="clearfix share-div-mobile" >
                      <button type="button" class="btn-fb share_button_fb" >
                      </button>
                      <button type="button" class="btn-twitter" onclick="share_t('twitter')">
                      </button>
                      <button type="button" class="  btn-google" onclick="share_t('google')">
                      </button>
                      <button class="btn-line" onclick="share_line()">
                      </button>
                      <button type="button" class=" btn-wa" onclick="share_wa()" >
                      </button>
                  </div>
                  <div class="comments">
                    <!-- facebook plugin -->
                    <div class="fb-comments " data-href="<?=current_url() ?>" data-width="100%" data-num-posts="10"></div>
                  </div>
                  
                  <?php if(isset($terkait) && count($terkait)>0  ){ ?>
                  <div class="terpopuler-title  margin-bottom-10 margin-top-10">Terkait</div>
                    <div class="row">
                      <?php foreach ($terkait as $key => $value) { ?>                      
                          <div class="col-md-6">
                            <div class="media"> 
                              <div class="media-left"> 
                                <a href="<?=base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower($value["title"])))?>"> 
                                  <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="<?=base_url($value['img'])?>" data-holder-rendered="true" style="width: 119px; height: 59px;"> 
                                </a> 
                              </div> 
                              <div class="media-body"> 
                                <h6 class="media-heading">
                                  <a href="<?=$value["href"]?>"> <?=$value["title"]?></a>
                                </h6> 
                                <div class="media-info">
                                  <?=time_elapsed_string($value["publish_date"])?>
                                </div>
                              </div> 
                            </div>
                            <hr class="blog-post-sep" style="margin-bottom: 0px;margin-top: 5px;">
                          </div>
                      <?php } ?>
                    </div>
                  <?php } ?>

                  <?php  if(isset($terbaru) && count($terbaru)>0  ){ ?>
                    <div class="terpopuler-title margin-bottom-10 margin-top-10">Terbaru</div>
                    <div class="row terbaru">
                      <?php foreach ($terbaru as $key => $value) { ?>
                        <div class="col-md-6">
                          <div class="media"> 
                            <div class="media-left"> 
                              <a href="<?=base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower($value["title"])))?>"> 
                                <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="<?=base_url($value['img'])?>" data-holder-rendered="true" style="width: 119px; height: 59px;"> 
                              </a> 
                            </div> 
                            <div class="media-body"> 
                              <h6 class="media-heading">
                                <a href="<?=base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))))?>"> <?=$value["title"]?></a>
                              </h6> 
                              <div class="media-info">
                                <?=time_elapsed_string($value["publish_date"])?>
                              </div>
                            </div> 
                          </div>
                          <hr class="blog-post-sep" style="margin-bottom: 0px;margin-top: 5px;">
                        </div>
                      <?php } ?>
                    </div>
                    <div class="row loading" >
                        <div class="col-md-12 btn-load-more text-center" style="margin-top:10px;">
                            <button class="btn blue btn-block btn-sm dropdown-toggle btn-side-home-grey" type="button"  id="btn-load-more">
                              BERITA SELANJUTNYA
                            </button>
                        </div>
                    </div>
                  <?php } ?>

                </div>
                <!-- END LEFT SIDEBAR -->
                <!-- BEGIN RIGHT SIDEBAR -->            
                <div class="col-md-3 col-sm-3 blog-sidebar">
                  <?=$side_content?>
                </div>
                <!-- END RIGHT SIDEBAR -->       
              </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
        <script type="text/javascript">
          var page = 1;
          var limit = 4;
          /*
          $(function () {
            var heightIMG = $('.blog-item-img').height();
            heightIMG = heightIMG+5;
            $("#clear-img").attr('style','height: '+heightIMG+'px;');
          });
          */
          $(document).ready(function(){
              $("#btn-load-more").click(function() {
                  page = page+1;
                  get_datas(page,limit);
              });
              $('.share_button_fb').click(function(e){
                var img = "<?=isset($data['img'])?base_url($data['img']):''?>";
                var caption = " ";
                var title = "<?=isset($data['title'])?$data['title']:''?>";
                var description = "<?=isset($data['content'])?str_replace(array("\r\n","\r"),"",trim(substr(strip_tags($data['content']),0,130))).'....':''?>";

                e.preventDefault();
                FB.ui({
                  method: 'feed',
                  name: title,
                  link: current_url,
                  picture: img,
                  caption: caption,
                  description:description,
                  message: ""
                });
              });

              $(".blog-content").find("img").addClass('img-responsive');
              $(".blog-content").find("img").removeAttr('style');
              $(".blog-content").find("img").attr('style','width:100%;');

              $(".btn-slide-controll").on('click',function  () {
                  var that = $(this);
                  var url = that.attr('data-slide-url');
                  $(".conten-slide").hide();
                  $(".blog-content > [data-slide-content='"+url+"']").show();
              });
           });
            function share_t(type) {
              var url = '';
              if(type=="twitter"){

                  var shortUrl = get_url_short();
                  var title = "<?=isset($data['title'])?$data['title']:''?>";
                  url +="http://twitter.com/intent/tweet?original_referer="+current_url;
                  url +='&url='+shortUrl+'&text=' + title + '';
              }
              if(type=="google"){
                  url +="https://plus.google.com/share?url=";
                  url +=current_url;
              
              }
              var title = "<?=isset($data['title'])?$data['title']:''?>";
              var h = 400;
              var w = 500;
              var left = (screen.width/2)-(w/2);
              var top = (screen.height/2)-(h/2);
              return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

            }
            function share_wa () {
              var title = encodeURIComponent("<?=$data['title']?>");
              var url = encodeURIComponent("<?=current_url()?>");
              window.location.href = "whatsapp://send?text="+title+" "+url;
            }
            function share_line () {
              var title = encodeURIComponent("<?=$data['title']?>");
              var url = encodeURIComponent("<?=current_url()?>");
              window.location.href = "http://line.me/R/msg/text/?"+title+" "+url;
            }

            function get_datas (page,limit) {
              $("#btn-load-more").html('Loading');
              $("#btn-load-more").attr('disabled','disabled');
              var url = "<?=base_url('home/get_datas?page=')?>"+page+"&limit="+limit;
              var result_data = $.api_get(url);
              var data = "";              

              for (var i = 0; i < result_data.length; i++) {
                  data += template(result_data[i]);
              };

              $(".terbaru").append(data);
              $("#btn-load-more").html('BERITA SELANJUTNYA');
              $("#btn-load-more").removeAttr('disabled');
              $("#btn-load-more").blur();
              
            }

            function template (data) {
              var template = "";
              var base_url = '<?=base_url()?>';
              var title = String(data.title);
              var title_link = title.split(' ');
                  title_link = title_link.join('.');
              var href = base_url+'read/'+data.id+'-'+title_link; 
              var img = base_url+data.img;

              template +='<div class="col-md-6">';
              template +='<div class="media-home">'; 
              template +='  <div class="media-left">'; 
              template +='    <a href="'+href+'"> ';
              template +='      <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="'+img+'" data-holder-rendered="true" style="width: 119px; height: 59px;">'; 
              template +='    </a>'; 
              template +='  </div> ';
              template +='  <div class="media-body">'; 
              template +='    <h6 class="media-heading">';
              template +='      <a href="'+href+'">'+data.title+'</a>';
              template +='    </h6>'; 
              template +='    <div class="media-info">';
              template +=       data.date;
              template +='    </div>';
              template +='  </div> ';
              template +='</div>';
              template +='<hr class="blog-post-sep" style="margin-bottom: 0px;margin-top: 5px;">';
              template +='</div>';
              return template;
            }
        </script>