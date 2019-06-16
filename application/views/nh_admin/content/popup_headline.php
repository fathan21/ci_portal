
<?=$head?>

<!-- form (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
          
          <div class="box-header with-border">
              <h3 class="box-title"><?=$title?></h3>

          </div><!-- /.box-header -->
          <div class="box-body">
            
            <div class="row">
                <div class="btn-group">
                    <a href="#" class="btn btn-success btn-inverse" onclick="parent.save_headline(<?=$headline_id?>,0)" id="select_btn" data="28" data-tooltip="tooltip" title="" data-original-title="Select">
                        Select No headline 
                    </a>
                </div>
            </div>
            <br>
              <!-- BEGIN ALERT BOX -->
              <?php if(isset($msg) && $msg!=""){?>
                  <div class="alert alert-<?=$msg_status?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?=$msg?>
                  </div>
              <?php } ?>
              <!-- END ALERT BOX -->

              <!-- table start -->
                <div class="col-md-12" style="overflow-x: auto;">
                    <table class="dataTable table table-bordered table-hover">
                    </table>
                </div>
        </div>

      </div>
    </div>
  </div>
<!-- /.form -->
<?=$foot?>
<script>
    jQuery(document).ready(function() {
        var selected = new Array();
        oSettings = {
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>r><'row-'>t<'row'<'col-sm-6 align-lg-left 'i><'col-sm-6 align-lg-right'p>>",
            //"dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>r>",
            "language": {
                "lengthMenu": "records per page _MENU_ ",
                "search": "Search..."
            },
            "order": [[ 3, 'desc' ]],
            <?=lengthMenu();?>
            "columns": [
                { "data": "id","title":"No","bSearchable":false, "bSortable":false ,"render": function ( data, type, row,meta ) {
                    var row_number = parseInt(meta.row)+1;
                    //return data +' '+"<span class='label label-default' >"+row_number+"</span>";
                    return "<span class='label label-default' >"+row_number+"</span>";
                    //return row_number;
                }},
                /*
                { "data": "claim_date","title":"[[CLAIM_DATE]]" ,type:"date","render": function ( data, type, row ) {
                                var mydate = new Date(data);
                                
                               var MyDateString = ('0' + mydate.getDate()).slice(-2) + '-'
                                     + ('0' + (mydate.getMonth()+1)).slice(-2) + '-'
                                     + mydate.getFullYear();
                               return MyDateString;
                        
                }},
                */
                { "data": "title","title":"Title" },
                { "data": "section","title":"Section" },
                { "data": "publish_date","title":"Publish Date" ,type:"date","render": function ( data, type, row ) {
                                
                              var d = data.split("-");
                              var mydate = new Date(d[0]+"/"+d[1]+"/"+d[2]);
                                
                               var MyDateString = ('0' + mydate.getDate()).slice(-2) + '/'
                                     + ('0' + (mydate.getMonth()+1)).slice(-2) + '/'
                                     + mydate.getFullYear()+' '+mydate.getHours()+":"+('0' + mydate.getMinutes()).slice(-2);
                               return MyDateString;
                        
                }},
                { "data": "action", "title":"Action", "bSearchable":false, "bSortable":false }
            ],
            "destroy": true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '<?php echo $listener ?>',
                type: 'POST',
                "data": {"<?php echo $this->config->item('csrf_token_name'); ?>":"<?php echo $this->session->userdata($this->config->item('csrf_token_name')); ?>"} // example add param for hock
            
            },
            "initComplete": function (oSettings, json) {
                var currentId = $(this).attr('id');
                if (currentId) {
                    var thisLength = $('#' + currentId + '_length');
                    var thisLengthLabel = $('#' + currentId + '_length label');
                    var thisLengthSelect = $('#' + currentId + '_length label select');

                    var thisFilter = $('#' + currentId + '_filter');
                    var thisFilterLabel = $('#' + currentId + '_filter label');
                    var thisFilterInput = $('#' + currentId + '_filter label input');

                    // Re-arrange the records selection for a form-horizontal layout
                    thisLength.addClass('form-group ');
                    // thisLengthLabel.addClass('control-label col-xs-12 col-sm-7 col-md-6').attr('for', currentId + '_length_select').css('text-align', 'left');
                    thisLengthSelect.addClass('form-control ').attr({'id': currentId + '_length_select', 'data-width': "100px", 'data-style': "btn-default"});
                    thisLengthSelect.prependTo(thisLength).wrap('<div class="col-md-12" />');
                    if (jQuery().selectpicker) {
                        thisLengthSelect.selectpicker();
                    }
                    thisLengthLabel.remove();

                    // Re-arrange the search input for a form-horizontal layout
                    thisFilter.addClass('form-group ');
                    //  thisFilterLabel.addClass('control-label col-xs-4 col-sm-3 col-md-3').attr('for', currentId + '_filter_input');
                    thisFilterInput.addClass('form-control').attr({'id': currentId + '_filter_input', 'placeholder': oSettings.oLanguage.sSearch});
                    //var icongroup = $(' <div class="input-icon"><i class="ico fa fa-search"></i></div>').append(thisFilterInput);
                    var icongroup = $(' <div class="input-icon"></div>').append(thisFilterInput);
                    icongroup.appendTo(thisFilter).wrap('<div class="col-md-12 " />');
                    thisFilterLabel.remove();
                    $('[data-tooltip="tooltip"]').tooltip();
                }
                oTabledata.columns.adjust().draw();
            }
        };
        oTabledata = $('.dataTable').DataTable(oSettings);
        parent.unblockModal();
       
    });
</script>
<!-- END TABLE-->