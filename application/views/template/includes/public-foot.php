
    <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>   
    <script src="<?php echo base_url(); ?>public/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js" type="text/javascript" ></script><!-- slider for products -->
    <!--script src="<?php echo base_url(); ?>public/assets/global/plugins/slick-master/slick/slick.min.js" type="text/javascript"></script--><!-- slider for products -->
    <script src="<?php echo base_url(); ?>public/assets/frontend/layout/scripts/layout.js?ver=0.0.1" type="text/javascript" ></script>
    <script type="text/javascript">
        $(function () {
            Layout.init();    
            Layout.initOWL();
            Layout.initNavScrolling(); 
            Layout.initFixHeaderScrollUp();

            $(".btn-open-search").click(function () {
                $(".input-search-nav").val("");
                $(".btn-open-search").hide();
                $(".search-box-menu-desktop-form").show();
                $(".input-search-nav").focus();
            });
            $(".btn-close-search").click(function () {
                $(".btn-open-search").show();
                $(".search-box-menu-desktop-form").hide();
            });
            $('.carousel').carousel({
              interval: 1700
            });
            function counter_post () {
                var ip = "<?=get_ip()?>";
                var user_agent = "<?=$_SERVER['HTTP_USER_AGENT']?>";
                var page = "<?=$this->uri->segment(1)?>"+'```'+"<?=$this->uri->segment(2)?>"+'```'+"<?=$this->uri->segment(3)?>";
                var url = "<?=base_url('welcome/counter')?>";
                var parameter = {
                                    ip:ip,
                                    page:page,
                                    user_agent:user_agent,
                                };

                var data = $.api_post(url,parameter);
            }
            function get_popular_news () {
                var url = "<?=base_url('welcome/get_popular_news')?>";
                var data = $.api_get(url);

                var html = '';
                for (var i = 0; i < data.length; i++) {
                        
                        html +='<div class="row terpopuler">';
                        html +='  <div class="col-md-12 ">';
                        html +='    <a class="terpopuler-text" href="'+data[i].href+'">'+data[i].title+'</a> <hr class="blog-post-sep-2">';
                        html +='  </div>';                        
                        html +='</div>';
                };

                $(".terpopuler").html(html);
            }
            counter_post();
            get_popular_news();
            
            $("iframe#twitter-widget-0").waitUntilExists(function(){
                $("iframe#twitter-widget-0").contents().find('head').append('<style>::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);border-radius: 10px;background-color: #F5F5F5;}::-webkit-scrollbar{width: 8px;background-color: #B22222;} ::-webkit-scrollbar-thumb{border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);background-color: #D62929;}</style>');
            });
        });
        $.extend({
            api_post: function(url,data) {
                var theResponse = null;
                data.<?php echo $this->config->item('csrf_token_name'); ?>="<?php echo $this->session->userdata($this->config->item('csrf_token_name')); ?>";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    async: false,
                    success: function(respText) {
                        if(respText.error==1){
                            bootbox.alert(respText.msg);
                        }else{
                            theResponse= respText.data;    
                        }
                    },
                    error   : function(respText){
                        console.log(respText.text);
                    }
                });
                return theResponse;
            },
            api_get: function(url) {
                var theResponse = null;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: "json",
                    async: false,
                    success: function(respText) {
                        if(respText.error==1){
                            bootbox.alert(respText.msg);
                        }else{
                            theResponse= respText.data;    
                        }
                    },
                    error   : function(respText){
                        console.log(respText.text);
                    }
                });
                return theResponse;
            }
        });
        $.fn.waitUntilExists    = function (handler, shouldRunHandlerOnce, isChild) {
                var found   = 'found';
                var $this   = $(this.selector);
                var $elements   = $this.not(function () { return $(this).data(found); }).each(handler).data(found, true);
                
                if (!isChild)
                {
                    (window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
                        window.setInterval(function () { $this.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 500)
                    ;
                }
                else if (shouldRunHandlerOnce && $elements.length)
                {
                    window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
                }
            return $this;
        }


    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->