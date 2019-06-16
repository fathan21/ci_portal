
<!-- Cropic -->
<link href="<?php echo base_url(); ?>public/assets/global/plugins/croppic-master/assets/css/croppic.css" rel="stylesheet">
<!--cropic -->
<script src="<?php echo base_url(); ?>public/assets/global/plugins/croppic-master/assets/js/jquery.mousewheel.min.js"></script>
<script src="<?php echo base_url(); ?>public/assets/global/plugins/croppic-master/croppic.min.js"></script>

<!-- form (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div style="overflow-x: auto;">
        <div class="box box-info" style="min-width:900px">
            
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title?></h3>
            </div><!-- /.box-header -->

            <div class="box-body">
              <!-- BEGIN ALERT BOX -->
              <?php if(isset($msg) && $msg!=""){?>
                <div class="col-md-10 col-md-offset-1">
                  <div class="alert alert-<?=$msg_status?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?=$msg?>
                  </div>
                </div>
              <?php } ?>
              <!-- END ALERT BOX -->

              <!-- form start -->
              <?php echo form_open_multipart($action, 'class="form-horizontal" method="post" data-parsley-validate'); ?>
                  <div class="box-body">
                    
                    <div class="form-group ">
                      <?php echo form_label('Name','Name',array('class'=>'control-label col-sm-2')); ?>
                      <div class="col-sm-5">
                        <?php $form = array("name"=>"name","id"=>"name","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["name"])?$db_data["name"]:"" ) ?>
                        <?php echo form_input($form); ?>
                      </div>
                    </div>

                    <?php if(isset($db_data) && $db_data["image_path"]!="" ){ ?>

                      <div class="form-group ">
                          <?php echo form_label('','',array('class'=>'control-label col-sm-2')); ?>
                          <div class="col-sm-8">
                              <button type="button" class="btn-success btn gambar-sekarang" id="ubah-gambar">Ubah Gambar</button>
                              <button type="button" class="btn-danger btn gambar-baru" id="batal-ubah-gambar" style="<?=isset($db_data)?'display:none;':''?>">Batal Ubah Gambar</button>
                          </div>
                      </div>
                      <div class="form-group gambar-sekarang">
                        <?php echo form_label('','',array('class'=>'control-label col-sm-1')); ?>
                        <div class="col-sm-8">
                          <img src="<?php echo base_url($db_data["image_thumbnail"]) ?>" class="col-md-12" alt="" style="width:780px; height:390px;">
                        </div>
                      </div>
                    <?php } ?>

                    <div class="form-group  gambar-baru" style="<?=isset($db_data)?'display:none;':''?>">
                        <?php echo form_label('','',array('class'=>'control-label col-sm-1')); ?>
                        <div class="col-sm-8">
                          <div id="cropContaineroutput" style="width:780px; height:390px; position: relative; border:1px solid #ccc;"></div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="image_thumbnail" name="image_thumbnail" value="<?=isset($db_data["image_thumbnail"])?$db_data["image_thumbnail"]:""?>">
                    <input type="hidden" class="form-control" id="image_path" name="image_path"  >

                  
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-sm-10 col-sm-offset-2" >
                      <button type="submit" class="btn btn-info ">Submit</button>
                      <a href="<?=base_url($back_link)?>" class="btn btn-default ">Cancel</a>

                    </div>
                  </div><!-- /.box-footer -->
              </form>
            </div>
            
        </div>
      </div>

    </div>
  </div>
<!-- /.form -->

<script type="text/javascript">
    $(".form-horizontal").submit(function  () {
        var image_thumbnail = $("#image_thumbnail").val();
        if(image_thumbnail == ''){
            bootbox.alert(" Belum memilih gambar / belum melakukan crop");
            return false;
        }
    });
    var imgUrl='';
    $("#ubah-gambar").click(function  () {
        $(".gambar-baru").show();
        $(".gambar-sekarang").hide();
        $("#image_thumbnail").val('');
    });
    $("#batal-ubah-gambar").click(function  () {
        $(".gambar-baru").hide();
        $(".gambar-sekarang").show();
        $("#image_thumbnail").val('<?=isset($db_data["image_thumbnail"])?$db_data["image_thumbnail"]:""?>');
        remove_img_temp();
    })

    
    var croppicContaineroutputOptions = {
        uploadUrl:'<?=base_url("nh_admin/galery/save_img")?>',
        cropUrl:'<?=base_url("nh_admin/galery/crop_img")?>', 
        //outputUrlId:'image_thumbnail',
        //loadPicture:'<?=isset($db_data["image_thumbnail"]) && $db_data["image_thumbnail"]!="" ?base_url($db_data["image_thumbnail"]):""  ?>',
        modal:false,
        imgEyecandy:false,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ 

         },
        onAfterImgUpload: function(){

         },
        onImgDrag: function(){ },
        onImgZoom: function(){ },
        onBeforeImgCrop: function(){  },
        onAfterImgCrop:function(data){ 
            document.getElementById('image_path').value = data.image_path;  
            document.getElementById('image_thumbnail').value = data.image_thumbnail; 


        },
        onReset:function(){ 

         },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    
    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

</script>
