      <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12 read-page">
            <div class="content-page">
              <div class="row">
                <!-- BEGIN LEFT SIDEBAR -->            
                <div class="col-md-9 col-sm-9 blog-item">
                  <div class="blog-item-img" >
                    <?php if($data["type"]=="photo"){ ?>
                      <div class="front-carousel">
                              <div id="myCarousel" class="carousel slide">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                  <?php foreach ($img as $key => $value) {?>
                                    <?php $active = $key<1?"active":""; ?>
                                    <div class="item <?=$active?>">
                                      <img width="100%"  class="img-responsive" src="<?=base_url($value["image_thumbnail"])?>" alt="">
                                    </div>
                                  <?php } ?>
                                </div>
                                <!-- Carousel nav -->
                                <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                                  <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="carousel-control right" href="#myCarousel" data-slide="next">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                              </div>                
                      </div>
                    <?php } ?>
                    <?php if($data["type"]=="video"){ ?>
                      <iframe  src="<?=$video["src"]?>" style="width:100%;height: 420px; border:0" allowfullscreen="" ></iframe>
                    <?php } ?>
                  
                  </div>
                  <!--div id="clear-img" ></div-->

                  <div class="title" ><?=$data["title"]?></div>

                  <div  class="date-time">
                      <?=date_time_indo_str(strtotime($data["publish_date"]))?>&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php if(isset($data["view"])){ ?>
                        <span><i class="fa fa-eye"></i> <?=$data["view"]?> Kali</span>
                      <?php } ?>
                      
                  </div>
                  <div class="content">
                    
                    <?=$data["content"]?>
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

                    <li  class="content-sumber">
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

                  <?php if(isset($terbaru) && count($terbaru)>0  ){ ?>
                  <div class="terpopuler-title  margin-bottom-10 margin-top-10">Lainnya</div>

                    <div class="row">
                      <?php foreach ($terbaru as $key => $value) { ?>
                        <div class="col-md-6">
                          <div class="media"> 
                            <div class="media-left"> 
                              <a href="<?=base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower($value["title"])))?>"> 
                                  <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="<?=$value['img']?>" data-holder-rendered="true" style="width: 119px; height: 59px;"> 

                              </a> 
                            </div> 
                            <div class="media-body"> 
                              <h6 class="media-heading">
                                <a href="<?=base_url('galery/read/'.$value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"]))))?>"> <?=$value["title"]?></a>
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
                    <div class="row" >
                        <div class="col-md-12 btn-load-more text-center" style="margin-top:10px;">
                            <a class="btn blue btn-sm dropdown-toggle btn-side-home-grey btn-block" href="<?=$load_more?>">
                              GALERI SELANJUTNYA
                            </a>
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
          /*
          $(function () {
            var heightIMG = $('.blog-item-img').height();
            heightIMG = heightIMG+5;
            $("#clear-img").attr('style','height: '+heightIMG+'px;');
          });
          */
            $('.share_button_fb').click(function(e){
              var caption = " ";
              var title = "<?=isset($data['title'])?$data['title']:''?>";
              var description = "<?=isset($data['content'])?str_replace(array("\r\n","\r"),"",trim(substr(strip_tags($data['content']),0,130))).'....':''?>";

              e.preventDefault();
              FB.ui({
                method: 'feed',
                name: title,
                link: '<?=current_url()?>',
                description:description,
                caption: caption,
                message: ""
              });
            });

            function share_t(type) {
              var url = "";
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
        </script>