	

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>public/assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/moment.min.js"></script>
    <!-- Daterange time picker -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/bootstrap-summernote/summernote.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/iCheck/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>public/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>public/assets/admin/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/assets/admin/plugins/jquery.blockui.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>public/assets/admin/plugins/bootbox/bootbox.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>public/assets/admin/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>public/assets/admin/dist/js/demo.js"></script>


    <script type="text/javascript">


        $(".form-horizontal, .validate").parsley({
            successClass: "has-success",
            errorClass: "has-error",
            classHandler: function (el) {
                return el.$element.closest(".form-group");
            },
            errorsContainer: function (el) {
                return el.$element.closest(".form-group");
            },
            errorsWrapper: "<span class='help-block'></span>",
            errorTemplate: "<span></span>"
        });
        $(function () {
            if ( !CKEDITOR.env.ie || CKEDITOR.env.version > 7 ){
                CKEDITOR.env.isCompatible = true;
            }
            $('[data-tooltip="tooltip"]').tooltip();
            //select2me
            $(".select2me").select2();

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"], input[type="radio"]').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });
            //Datemask dd/mm/yyyy
            $(".datemask-date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $(".datemask2-phone").inputmask("(999) 999-9999-99", {"placeholder": ""});
            //wsywing
            $('.summernote').summernote({height: 200});

            //API:
            //var sHTML = $('#summernote_1').code(); // get code
            //$('#summernote_1').destroy(); // destroy

            $("#galery_btn_open").click(function  () {
              popup("<?=base_url('nh_admin/galery/popup')?>");
            });
            

            $('#share_button_fb').click(function(e){
              var img = "<?=isset($data['img'])?base_url($data['img']):''?>";
              var caption = "<?=isset($data['photo_caption'])?$data['photo_caption']:''?>";
              var title = "<?=isset($data['title'])?$data['title']:''?>";
              e.preventDefault();
              FB.ui({
                method: 'feed',
                name: title,
                link: '<?=current_url()?>',
                picture: img,
                caption: caption,
                description:title,
                message: ""
              });
          });
          $('.date-picker').datepicker({
                autoclose: true,
                todayBtn: 'linked',
                format: "yyyy-mm-dd",
                todayHighlight: true
          });
          $(".form_advance_datetime_later").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                startDate: "<?=date('Y-m-d H:i') ?>",
                pickerPosition:  "top-left",
                minuteStep: 10
            });
            
            
        });

        function popup(page) {
              $("#iframe_modal").attr("");
              $("#iframe_modal").attr('src', page);
              $("#modal_admin").modal("show");
        }
        function get_galery (id,image_path) {
              $("#galery_id").val(id);
              $("#modal_admin").modal("hide");
              $("#image_path").removeAttr("src");
              $("#image_path").attr("src","<?=base_url()?>"+image_path);
              $(".galery_id").show();
        }
        
        $.extend({
            api_post: function(url,data) {
                // local var
                var theResponse = null;
                // jQuery ajax
                data.<?php echo $this->config->item('csrf_token_name'); ?>="<?php echo $this->session->userdata($this->config->item('csrf_token_name')); ?>";
                $.blockUI();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    async: false,
                    success: function(respText) {
                        $.unblockUI();
                        if(respText.error==1){
                            bootbox.alert(respText.msg);
                        }else{
                            theResponse= respText.data;    
                        }
                    },
                    error   : function(respText){
                        console.log(respText.text);
                        $.unblockUI();
                    }
                });
                // Return the response text
                return theResponse;
            },
            api_get: function(url) {
                // local var
                var theResponse = null;
                // jQuery ajax
                $.blockUI();
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: "json",
                    async: false,
                    success: function(respText) {
                        $.unblockUI();
                        if(respText.error==1){
                            bootbox.alert(respText.msg);
                        }else{
                            theResponse= respText.data;    
                        }
                    },
                    error   : function(respText){
                        console.log(respText.text);
                        $.unblockUI();
                    }
                });
                // Return the response text
                return theResponse;
            }
        });
    </script>
