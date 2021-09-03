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

      var all_cities = <?= json_encode($all_cities) ?>;
      var all_areas = <?= json_encode($all_areas); ?>;
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


      $('#calendar').fullCalendar({
          header    : {
              left  : 'prev,next today',
              center: 'title',
              right : 'month,agendaWeek,agendaDay'
          },
          buttonText: {
              today: 'today',
              month: 'month',
              week : 'week',
              day  : 'day'
          },
          //Random default events
          events    : [
              <?php
              $get_current_date = date('M d Y');
              if (is_array($data) and count($data) > 0) {
              foreach ($data as  $value) {
                  ?>
                  {
                      title : '<?= $value['event_title'] ?>',
                      start : '<?= $value['event_date'].' '.$value['event_time'] ?>',//'Sun Sep 13 2020 22:00:00'
                      url   : '<?= VIEW_EVENT.$value['event_id']; ?>',
                      backgroundColor: '<?= ($value['event_date'] >= $get_current_date) ? '#0073b7' : '#f56954'?>', //aqua
                      borderColor    : '<?= ($value['event_date'] >= $get_current_date) ? '#0073b7' : '#f56954'?>' //aqua
                  },
                  <?php
                  }
              }
              ?>

          ],
          editable  : true,
          droppable : true, // this allows things to be dropped onto the calendar !!!
          drop      : function (date, allDay) { // this function is called when something is dropped

              // retrieve the dropped element's stored Event Object
              var originalEventObject = $(this).data('eventObject')

              // we need to copy it, so that multiple events don't have a reference to the same object
              var copiedEventObject = $.extend({}, originalEventObject)

              // assign it the date that was reported
              copiedEventObject.start           = date
              copiedEventObject.allDay          = allDay
              copiedEventObject.backgroundColor = $(this).css('background-color')
              copiedEventObject.borderColor     = $(this).css('border-color')

              // render the event on the calendar
              // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
              $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

              // is the "remove after drop" checkbox checked?
              if ($('#drop-remove').is(':checked')) {
                  // if so, remove the element from the "Draggable Events" list
                  $(this).remove()
              }

          }
      });


    $("#state").change(function(e){

        var city = '<option value="" disabled selected>Select</option>';
        var area = '<option value="" disabled selected>Select</option>';

        $("#area").html(area);
        $("#city").html(city);

        for(var ii =0; ii < all_cities.length; ii++){
            var state_id = all_cities[ii].state_id;

            if ($(this).val() == state_id){
               $("#city").append('<option value='+all_cities[ii].id+' >'+all_cities[ii].name+'</option>');
            }
        }

    });

    $("#city").change(function(e){
          var area = '<option value="" disabled selected>Select</option>';
          $("#area").html(area);
          for(var ii =0; ii < all_areas.length; ii++){
              var city_id = all_areas[ii].city_id;

              if ($(this).val() == city_id){
                  $("#area").append('<option value='+all_areas[ii].id+' >'+all_areas[ii].name+'</option>');
              }
          }
      });

    $(".request").click(function(e){
      if ($(this).val() == 0) {
          $(".hidden-1").show();
          $(".hidden-2").hide();
          return;
      }

      $(".hidden-2").show();
      $(".hidden-1").hide();
    });

    $('.input-images-1').imageUploader({
        maxSize : 2 * 1024 * 1024,
        label : 'Drag & Drop files here or click to browse'
    });

    $('[data-toggle="datepicker"]').datepicker('setStartDate', new Date());
  });

</script>
</body>
</html>
