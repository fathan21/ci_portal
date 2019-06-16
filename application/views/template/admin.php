<!DOCTYPE html>
<html>
  <head>
  	<?=$head?>
    
  </head>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '462773900594509',
        xfbml      : true,
        version    : 'v2.5'
      });
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
    
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.5&appId=462773900594509";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
      
    !function(d,s,id){
      var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
      if(!d.getElementById(id)){
        js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js,fjs);
      }}(document, 'script', 'twitter-wjs');
  </script>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

      <header class="main-header">
      	<?=$header?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
      	<?=$sidebar?>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?=$title?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=base_url('nh_admin/dashboard')?>"><i class="fa fa-home"></i> Dashboard</a></li>

            <?php 
              if(isset($breadcrumb)){
                foreach ($breadcrumb as $key => $value) {
                  echo '  <li class="'.$value["active"].'"    ><a href="'.$value["link"].'" > '.$value["title"].' </a></li>';
                }
              }
            ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div id="status">
          </div>
        	<?=$content?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?=$footer?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <?=$foot?>
  </body>
</html>
<div class="modal" id="modal_admin" tabindex="-1" role="dialog" aria-hidden="false">
    <div class=" modal-admin">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body " id="modal_body" width="80%" hieght="500px">
                <iframe style="height:400px" id="iframe_modal" frameborder="0" width="100%" src=""></iframe>
            </div>
            <div class="modal-footer" style="padding-top: 0px;border-top-width: 0px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('#modal_admin').on('shown.bs.modal', function() {
      $(".modal-content").block({ message: 'loading' });
  });
  function unblockModal () {
    $(".modal-content").unblock();
  }
</script>