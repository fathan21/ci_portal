
<!-- form (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
          
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
                    <?php echo form_label('Judul Berita*','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-8">
                      <?php $form = array("name"=>"title","id"=>"title","class"=>"form-control","type"=>"text","readonly"=>"readonly","required"=>"required","value"=>isset($db_data["title"])?$db_data["title"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>

                  <hr>

                  <div class="form-group ">
                    <div class="col-sm-2">
                      <button class="btn btn-info" type="button" id="tambah-slide">Tambah Slide</button> 
                    </div>
                    <div class="col-sm-10 ">
                      <div class="pull-right">
                        <table width="80%" class="table text-center table-bordered table-striped">
                          <tr>
                            <td>
                                Maksimal Slide
                            </td>
                            <td>
                                Minimal Slide
                            </td>
                            <td>
                                Jumlah Slide
                            </td>
                          </tr>
                          <tr>
                            <td>
                              10
                            </td>
                            <td>  
                                3
                            </td>
                            <td>
                              <span id="jumlah-slide"><?=count($db_slide)?></span>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                      <div class="slide_content">
                        <?php foreach ($db_slide as $key => $value) { ?>

                                    <div class="row row_<?=$key?> slide_row" >
                                      <div class="col-md-10 col-md-offset-2">
                                          <div class="form-group ">
                                            <div class="col-sm-1">
                                              <?php $form = array("name"=>"display_order[]","id"=>"display_order_".$key,"class"=>"form-control","type"=>"text","readonly"=>"readonly","value"=>isset($value["display_order"])?$value["display_order"]:$key+1 ) ?>
                                              <?php echo form_input($form); ?>
                                            </div>
                                            <div class="col-sm-9">
                                              <?php $form = array("name"=>"title[]","id"=>"title_","class"=>"form-control","type"=>"text","value"=>isset($value["title"])?$value["title"]:"" ) ?>
                                              <?php echo form_input($form); ?>
                                            </div>
                                            <div class="col-sm-1">
                                              <button type="button" class="btn btn-xs btn-danger delete_row" >Hapus</button>
                                            </div>
                                          </div>

                                          <div class="form-group ">
                                            <?php echo form_label('','',array('class'=>'control-label col-sm-1')); ?>
                                            <div class="col-sm-4">
                                              <button class="btn btn-primary galery_btn_open" type="button" data="<?=$key?>" name="button[]" >Buka Photo </button>
                                              <input type="hidden" name="galery_id[]" id="galery_id_<?=$key?>" value="<?php echo isset($value["galery_id"])?$value["galery_id"]:"";  ?>">
                                            </div>
                                          </div>

                                          <div id="galery_div_<?=$key?>" class="form-group galery_div" <?php echo isset($value["galery_id"]) && $value["galery_id"] !=""?'':'style="display:none;"'; ?> >
                                            <?php echo form_label('','',array('class'=>'control-label col-sm-1')); ?>
                                            <div class="col-sm-10"  >
                                              <img style="" class="col-md-12 responsive img-responsive center-block" id="image_thumbnail_<?=$key?>" src="<?php echo isset($value["image_thumbnail"]) && $value["image_thumbnail"] !=""?$value["image_thumbnail"]:'' ?>"  alt="">
                                            </div>
                                          </div>

                                          <div class="form-group ">
                                            <?php echo form_label('','',array('class'=>'control-label col-sm-1')); ?><div class="col-sm-10">
                                              <textarea class=" form-control " name="lead[]" id="mini_<?=$key?>"><?=isset($value["content"])?$value["content"]:""?></textarea>
                                            </div>
                                          </div>

                                      </div>
                                    </div>

                        <?php } ?>
                      </div>

                  <hr>



                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-2 col-sm-offset-2" >
                    <button type="submit" class="btn btn-info ">Submit</button>
                    <a href="<?=base_url($back_link)?>" class="btn btn-default ">Cancel</a>

                  </div>
                </div><!-- /.box-footer -->
            </form>
          </div>
          
      </div>
    </div>
  </div>
<!-- /.form -->
<script type="text/javascript">
  $(function () {
    
    if ( !CKEDITOR.env.ie || CKEDITOR.env.version > 7 ){
          CKEDITOR.env.isCompatible = true;
    }
    <?php foreach ($db_slide as $key => $value) { ?>

      CKEDITOR.replace( 'mini_'+"<?=$key?>", {
              toolbar: [
                [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
                [ 'FontSize', 'TextColor', 'BGColor' ]
              ]
      });
    <?php } ?>

    $("#tambah-slide").click(function  () {
        var key = $(".slide_row").length;
        var key_1 = key + 1;

        if(key_1 > 10){

          bootbox.alert(" Maksimal 10 slide ");
          return false;
        }

        row = '';

        row+='<div class="row row_'+key+' slide_row">';
        row+='  <div class="col-md-10 col-md-offset-2">';
        row+='      <div class="form-group ">';
        row+='        <div class="col-sm-1">';
        row+='          <input type="text" name="display_order[]" value="'+key_1+'" id="display_order_'+key+'" class="form-control" readonly="readonly"  >';
        row+='        </div>';
        row+='        <div class="col-sm-9">';
        row+='          <input type="text" name="title[]" value="" id="title_" class="form-control" >';
        row+='        </div>';
        row+='        <div class="col-sm-1">';
        row+='          <button type="button" class="btn btn-xs btn-danger delete_row" >Hapus</button>';
        row+='        </div>';
        row+='      </div>';

        row+='      <div class="form-group ">';
        row+='        <?php echo form_label("","",array("class"=>"control-label col-sm-1")); ?>';
        row+='        <div class="col-sm-4">';
        row+='          <button class="btn btn-primary galery_btn_open" name="button[]" type="button" data="'+key+'" >Buka Photo </button>';
        row+='          <input type="hidden" name="galery_id[]" id="galery_id_'+key+'" value="">';
        row+='        </div>';
        row+='      </div>';

        row+='      <div id="galery_div_'+key+'" class="form-group  galery_div" style="display:none;" >';
        row+='        <?php echo form_label("","",array("class"=>"control-label col-sm-1")); ?>';
        row+='        <div class="col-sm-10"  >';
        row+='          <img style="" class="col-md-12 responsive img-responsive center-block" id="image_thumbnail_'+key+'" src=""  alt="">';
        row+='        </div>';
        row+='      </div>';

        row+='      <div class="form-group ">';
        row+='        <?php echo form_label("","",array("class"=>"control-label col-sm-1")); ?>';
        row+='       <div class="col-sm-10">';
        row+='          <textarea class=" form-control " name="lead[]" id="mini_'+key+'"></textarea>';
        row+='        </div>';
        row+='      </div>';

        row+='  </div>';
        row+='</div>';


        $(".slide_content").append(row);

        $("#jumlah-slide").html(key_1);


        CKEDITOR.replace( 'mini_'+key, {
                toolbar: [
                  [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
                  [ 'FontSize', 'TextColor', 'BGColor' ]
                ]
        });

    });
    
    $(".delete_row").live('click' ,function  () {

          var key = $(".slide_row").length;
          key = key;
          if(key <= 3){
            bootbox.alert(" Minimal 3 slide ");
            return false;
          }
          var data = $(this).parent('div').parent('div').parent('div').parent('div');
          data.remove();

          var key = $(".slide_row").length;
          key = key;
          $("#jumlah-slide").html(key);
    
          $('.slide_row').each(function(i, obj) {
                var that = $(this);
                
                that.removeAttr('class');
                that.attr('class','row row_'+i+' slide_row');

                i_1 = i+1;
                that.find('[name="display_order[]"]').val(i_1);
                that.find('[name="display_order[]"]').removeAttr('id');
                that.find('[name="display_order[]"]').attr('id','display_order_'+i);

                that.find('[name="button[]"]').removeAttr('data');
                that.find('[name="button[]"]').attr('data',i);


                that.find('[name="galery_id[]"]').removeAttr('id');
                that.find('[name="galery_id[]"]').attr('id','galery_id_'+i);

                that.find('div .galery_div').removeAttr('id');
                that.find('div .galery_div').attr('id','galery_div_'+i);

                that.find('img ').removeAttr('id');
                that.find('img ').attr('id','image_thumbnail_'+i);

                that.find('textarea ').removeAttr('id');
                that.find('textarea ').attr('id','mini_'+i);

          });
    });

    $(".galery_btn_open").live('click' ,function  () {
          var data = $(this).attr('data');
          console.log(data);
          popup("<?=base_url('nh_admin/galery/popup/slide')?>/"+data);
    });

  });

  function get_galery_slide (id,image_path,image_thumbnail,slide_num) {
              console.log(id);
              console.log(image_path);
              console.log(image_thumbnail);
              console.log(slide_num);

              
              $("#galery_id_"+slide_num).val(id);
              $("#modal_admin").modal("hide");
              $("#image_thumbnail_"+slide_num).removeAttr("src");
              $("#image_thumbnail_"+slide_num).attr("src","<?=base_url()?>"+image_thumbnail);
              $("#galery_div_"+slide_num).show();
  }

    

</script>


