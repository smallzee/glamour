</div>
<footer class="main-footer">
    <!-- <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div> -->
    <span>Copyright &copy; 2020 - <?= date('Y'); ?>  <a href="<?= base_url()  ?>" target="_blank"><?= WEB_TITLE ?></a>.</span> All rights
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
<script src="<?= HTML_BASE_TEMPLATES ?>dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/raphael/raphael.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/morris.js/morris.min.js"></script>
<!-- DataTables -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?= HTML_BASE_TEMPLATES ?>uploading-lib/dist/image-uploader.min.js" ></script>
<!-- Slimscroll -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= HTML_BASE_TEMPLATES?>dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/moment/moment.js"></script>
<script src="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- Page specific script -->
<script type="text/javascript">

  $(function(e){

      $('.select2').select2();

      $('#example1, #datatables').DataTable();
      //$('#datatables').DataTable();
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
