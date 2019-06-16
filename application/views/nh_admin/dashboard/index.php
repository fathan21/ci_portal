
<section class="content">
  
  <div class="row">
    <section class="col-lg-9">
      <div clas="col-md-12">
      
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Berita Utama</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Update By</th>
                    <th>Update At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($headline as $key => $value) {?>
                    <tr>
                      <td>
                        <?=$key+1?>
                      </td>
                      <td>
                        <?=$value["title"]?>
                      </td>
                      <td>
                        <?=$value["update_by"]?>
                      </td>
                      <td>
                        <?=date('d/m/Y H:i', strtotime($value["updated_at"]))?>
                      </td>
                      <td>
                        <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left btn-headline-edit" data="<?=$value['id']?>">Edit</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
          </div><!-- /.box-footer -->
        </div>

      </div>
    </section>

    <section class="col-lg-3">

        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Statistik Pengunjung</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">

                <table class="table">
                    <tr>
                      <td>
                        Pengunjung Hari Ini
                      </td>
                      <td>
                        : <?=$counter['today']?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Pengunjung Kemarin
                      </td>
                      <td>
                        : <?=$counter['yesterday']?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Pengunjung Bulan Ini
                      </td>
                      <td>
                        : <?=$counter['month']?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Pengunjung Tahun Ini
                      </td>
                      <td>
                        : <?=$counter['year']?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Total
                      </td>
                      <td>
                        : <?=$counter['all']?>
                      </td>
                    </tr>
                </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div>
    </section>
  </div>

</section>

<script type="text/javascript">
  
  $(function () {
    
    $(".btn-headline-edit").click(function  () {
        var id = $(this).attr('data');
        console.log(id);

        popup("<?=base_url('nh_admin/content/popup_headline')?>/"+id);
    });


  });    

  function save_headline(headline_id,posts_id) {
        $("#modal_admin").modal("hide");
        var url = "<?=base_url('nh_admin/dashboard/update_headline/')?>/"+headline_id+"/"+posts_id;
        var data = $.api_get(url);

        window.location.reload();
  }

</script>