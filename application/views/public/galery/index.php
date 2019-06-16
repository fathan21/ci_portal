
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
  <!-- BEGIN CONTENT -->
  <div class="col-md-12 col-sm-12">
    <div class="content-page">
      <div class="row">
        <!-- BEGIN LEFT SIDEBAR -->    
        <div class="col-md-9 col-sm-9">
          <div class="col-md-12 col-sm-12">
            <h1>Galeri</h1>
            <div class="content-page">
              <div class="filter-v1">
                <div class="row mix-grid thumbnails galery_data">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 btn-load-more">
              <div class="content-page text-center">
                <button class="btn blue btn-sm dropdown-toggle btn-side-home-grey btn-block" type="button"  id="btn-load-more">
                  GALERI SELANJUTNYA 
                </button>
              </div>
          </div>
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
$(function () {

    function get_datas (page) {
      $("#btn-load-more").html('Loading');
      $("#btn-load-more").attr('disabled','disabled');
      var url = "<?=base_url('galery/get_datas?page=')?>"+page;
      var result_data = $.api_get(url);

      var data = "";
      if(result_data.load_more == 0){
        $(".btn-load-more").hide();
      }

      for (var i = 0; i < result_data.data.length; i++) {
        data += template_1(result_data.data[i]);
      };
      $(".galery_data").append(data);
      
      $("#btn-load-more").html('GALERI SELANJUTNYA');
      $("#btn-load-more").removeAttr('disabled');

    }

    function template_1 (data) {
      var template = "";

      template+=' <div class="col-md-4 col-sm-6 mix  " style="display: block; opacity: 1;">';
      template+='    <div class="mix-inner">';
      template+='      <img  width="100%" alt="" src="'+data.img+'" class="img-responsive" style="height: 188px;">';
      template+='      <div class="mix-details">';
      template+='<h4></h4>';
      template+='<a class="" href="<?=base_url('galery/read/')?>/'+data.href+'" style="color:#ffffff;">'+data.title+'</a>';
      template+='      </div>';
      template+='      <a class="recent-work-description" href="<?=base_url('galery/read/')?>'+data.href+'">';
      template+='<strong>'+data.title+'</strong>';
      template+='      </a>'; 
      template+='    </div>';       
      template+='  </div>';

      return template;
    }

    function template_2 (data) {
      var template = "";

      template+=' <div class="col-md-4 col-sm-6 mix  " style="display: block; opacity: 1;">';
      template+='    <div class="mix-inner">';
      template+='      <iframe  src="'+data.video+'" style="width:100%; border:0" allowfullscreen="" height="187"></iframe>';
      template+='      <div class="mix-details">';
      template+='<h4></h4>';
      template+='<a class="" href="<?=base_url('galery/read/')?>/'+data.href+'" style="color:#ffffff;">'+data.title+'</a>';
      template+='      </div>';
      template+='      <a class="recent-work-description" href="<?=base_url('galery/read/')?>'+data.href+'">';
      template+='<strong>'+data.title+'</strong>';
      template+='      </a>'; 
      template+='    </div>';       
      template+='  </div>';

      return template;
    };

    var page = 1;
    get_datas(page);

    $("#btn-load-more").click(function() {
        page = page+1;
        get_datas(page);
    });


});

</script>