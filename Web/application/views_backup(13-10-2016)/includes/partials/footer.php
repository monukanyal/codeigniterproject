
        <footer>
            <div class="">
                <p class="pull-right">Community Scheduling App! <a>Old age</a> event based app. |
                    <span class="lead"> <i class="fa fa-paw"></i> Community Scheduling App!</span>
                </p>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
            
        </div>
        <!-- /page content -->

        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="<?php echo $assets_path; ?>js/bootstrap.min.js"></script>

    <script src="<?php echo $assets_path; ?>js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="<?php echo $assets_path; ?>js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="<?php echo $assets_path; ?>js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo $assets_path; ?>js/custom.js"></script>

        <!-- Datatables -->
        <script src="<?php echo $assets_path; ?>js/datatables/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function () {
                $('input.tableflat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });

            var asInitVals = new Array();
            $(document).ready(function () {
                var oTable = $('#example').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
            ],
                    'iDisplayLength': 12,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo $assets_path; ?>js/datatables/tools/swf/copy_csv_xls_pdf.swf"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });
            });
        </script>

    <?php 
        if(isset($js) && !empty($js))
        {
            foreach($js as $js_val)
            {
            	$jss = $assets_path."js/".$js_val;
                echo '<script type="text/javascript" src="'.$jss.'"></script>';
                echo "\n";
            }
        }

    ?>
<script>

 $(document).ready(function(){
       var successBox = $('.flash.success');
       var errorBox = $('.flash.error');
   // fade $alertBox out after 1 second (1000 ms)
   successBox.delay(3000).fadeOut('slow');
   errorBox.delay(3000).fadeOut('slow');
});

$(document).on("click",".message_message",function(evented){
    $( this ).fadeOut(100);
});
</script>
</body>

</html>