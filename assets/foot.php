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

    $(function () {


        $('.timepicker').timepicker({
            'timeFormat': 'H:i:a',
            'disableTimeRanges': [
                ['00:00am', '01:00am']
            ]
        });

        $("#event-date-countdown").countdown("<?= @$duration ?>", function(event) {
            $(this).text(
                event.strftime('%D Days : %H: Hrs %M: Mins %S Sec')
            );
        });

        function show_preloading(){
            $(".preloading").removeClass('hide');
        }

        function hide_preloading(){
            $('.preloading').addClass('hide');
        }

        $('#example1').DataTable();
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });

            $("#join").click(function (e) {
                e.preventDefault();
                var event_code = $("#code").val();

                show_preloading();

                $.ajax({
                    url : '<?= base_url('join-event') ?>',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        'join' : '',
                        'code' : event_code
                    },
                    success : function (data) {
                        console.log(data);
                        if (data.error == 0){
                            toastr.error(data.msg);
                            hide_preloading();
                            return;
                        }

                        //toastr.success(data.msg);
                        $(".show-modal").click();
                        hide_preloading();

                        swal({
                            title: "Are you sure?",
                            text: "You want to attend "+data.info.event_title+' \n  Organized By '+data.info.created_by,
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete){

                                show_preloading();

                                $.ajax({
                                    url : '<?= base_url('join-event') ?>',
                                    type : 'post',
                                    dataType : 'json',
                                    data : {
                                        'verify-join-event' : '',
                                        'event_id' : data.info.id
                                    },

                                    success : function (response) {
                                        console.log(response);

                                        if (response.error == 0){
                                            hide_preloading();
                                            toastr.success(response.msg);
                                            return;
                                        }

                                        hide_preloading();
                                        swal("Joinnig!", response.msg, "success");
                                        setTimeout(function(){
                                            location.reload();
                                        }, 1000);
                                    },

                                    error : function(er){
                                        console.log(er.responseText);
                                        toastr.error("No internet connection, try again");
                                    }
                                });

                                return;
                            }

                            swal("Cancelled","cant be deleted","error");
                        });
                    },
                    error : function (err) {
                        console.log(err.responseText);
                        hide_preloading();
                        toastr.error("No internet connection, try again");
                    }
                });
            });

        /* initialize the external events
         -----------------------------------------------------------------*/

        $(document).ajaxStart(function () {
            Pace.restart()
        });

        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label"
        });

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)

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
                                    url   : '<?= base_url('view') ?>',
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

    });
</script>
<script src="//code.tidio.co/lv7otilgv3rzaeaophrlpjxp8r2bxkdo.js" async></script>
</body>
</html>
