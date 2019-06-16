
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
                    <?php echo form_label('Liga','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-8">
                      <?php $form = array("name"=>"title","id"=>"title","class"=>"form-control","type"=>"text","readonly"=>"readonly","required"=>"required","value"=>isset($db_data["name"])?$db_data["name"]." ".$db_data["year"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>

                  <hr>

                  <div class="form-group ">
                    <div class="col-sm-2">
                      <button class="btn btn-info" type="button" id="tambah-jadawal">Tambah Jadawal</button> 
                    </div>
                  </div>

                  <div class="slide_content">
                    <table class="dataTable table table-bordered table-hover no-footer table-jadwal">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Tanggal
                                </th>
                                <th width="13%">
                                    Waktu
                                </th>
                                <th>
                                    Klub Tuan Rumah
                                </th>
                                <th>
                                    Klub Tamu
                                </th>
                                <th>
                                    Stadiun
                                </th>
                                <th width="10%">
                                    Skor Tuan Rumah
                                </th>
                                <th  width="10%">
                                    Skor Tamu
                                </th>
                                <th>
                                    Hapus
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                          <?php foreach ($db_jadwal as $key => $value) { ?>
                            <tr class="row_<?=$key?>">
                                <td>
                                    <?=$key+1?>    
                                </td>
                                <td>
                                    <input type="text" name="date[]" class="form-control date-picker" value="<?=$value["date"]?>" >
                                </td>
                                <td>
                                    <input type="text" name="time[]" class="form-control "  value="<?=$value["time"]?>">
                                </td>
                                <td>
                                    <input type="text" name="home[]" class="form-control"  value="<?=$value["home"]?>">
                                </td>
                                <td>
                                    <input type="text" name="away[]" class="form-control"  value="<?=$value["away"]?>">
                                </td>
                                <td>
                                    <input type="text" name="stadiun[]" class="form-control"  value="<?=$value["stadiun"]?>">
                                </td>
                                <td>
                                    <input type="text" name="home_skor[]" class="form-control"  value="<?=$value["home_skor"]?>">
                                </td>
                                <td>
                                    <input type="text" name="away_skor[]" class="form-control"  value="<?=$value["away_skor"]?>">
                                </td>
                                <td>
                                    <button type="button" class="delete_row btn btn-danger btn-xs" data="<?=$key?>" >Hapus</button>
                                </td>
                            </tr>

                          <?php } ?>
                        </tbody>
                    </table>
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
      

    $("#tambah-jadawal").click(function  () {
        var key = $(".table-jadwal >tbody >tr").length;
        
        var no =key+1;
        tr = '';
        
        tr +='<tr>';
        tr +='    <td>';
        tr +='        '+no;
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="date[]" class="form-control date-picker"  >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="time[]" class="form-control "  >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="home[]" class="form-control" >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="away[]" class="form-control" >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="stadiun[]" class="form-control" >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="home_skor[]" class="form-control" >';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <input type="text" name="away_skor[]" class="form-control" ';
        tr +='    </td>';
        tr +='    <td>';
        tr +='        <button type="button" class="delete_row btn btn-danger btn-xs" data="'+key+'" >Hapus</button>';
        tr +='    </td>';
        tr +='</tr>';
        
        $(".table-jadwal tbody").append(tr);
        
        $('.date-picker').datepicker({
                autoclose: true,
                todayBtn: 'linked',
                format: "yyyy-mm-dd",
                todayHighlight: true
        });
        
    });
    
    $(".delete_row").live('click' ,function  () {
        
        var that = $(this);
        var data = $(this).parent('td').parent('tr');
        
        data.remove();

        var table = document.getElementById('table-jadwal');
        var i = 1;
        $('.table-jadwal > tbody  > tr').each(function() {
            $(this).find("td:first").html(i);
            i++;
        });
        
    });
      

  });

   

</script>


