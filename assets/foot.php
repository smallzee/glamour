</div>
 <footer class="main-footer">
    <!-- <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div> -->
    <span>Copyright &copy; 2020 <?= date('Y'); ?>  <a href="<?= base_url()  ?>" target="_blank"><?= WEB_TITLE ?></a>.</span> All rights
    reserved.
  </footer>
</div>

  <!-- /.control-sidebar -->
<!-- jQuery 3 -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- PACE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/PACE/pace.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/raphael/raphael.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/morris.js/morris.min.js"></script>
<!-- DataTables -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- Slimscroll -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/timepicker@1.13.14/jquery.timepicker.min.js"></script>
<!-- FastClick -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/jquery.countdown.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/adminlte.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/bootstrap-tagsinput.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/demo.js"></script>

<script type="text/javascript" src="<?= HTML_BASE_TEMPLATES ?>dist/js/preview.js"></script>
<script type="text/javascript" src="<?= HTML_BASE_TEMPLATES ?>dist/js/uploadpreview.js"></script>
<!-- fullCalendar -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/moment/moment.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- Page specific script -->
<script>

    let event_type = JSON.parse('<?= json_encode($event_type_data) ?>');

    $(function () {

        $('.timepicker').timepicker({
            'timeFormat': 'H:i:a',
            'disableTimeRanges': [
                ['00:00am', '01:00am']
            ]
        });

        $("#event_type").change(function (e) {
           for (var i =0; i < event_type.length; i++){
               if ($(this).val() == event_type[i].id){
                   $("#budget").val(event_type[i].price);
               }
           }
        });

        $('#example1').DataTable();
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });


    });
</script>
</body>
</html>
