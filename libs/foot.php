<!-- Shape Start -->
<!--<div class="position-relative">-->
<!--    <div class="shape overflow-hidden text-footer">-->
<!--        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>-->
<!--        </svg>-->
<!--    </div>-->
<!--</div>-->
<!--Shape End-->

<!-- Footer Start -->
<footer class="footer" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                <p class="mt-4"><?= WEB_TITLE ?>  Event Centre is a modern, tastefully furnished, classy and irresistible Multipurpose Event Hall that was built with your event in mind.</p>
                <ul class="list-unstyled social-icon social mb-0 mt-4">
                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                </ul><!--end icon-->
            </div><!--end col-->

            <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <h4 class="text-light footer-head">Company</h4>
                <ul class="list-unstyled footer-list mt-4">
                    <li><a href="<?= base_url('about-us') ?>" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> About Developer</a></li>
                    <li><a href="<?= base_url('contact-us') ?>" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Contact Us</a></li>
                </ul>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <h4 class="text-light footer-head">Usefull Links</h4>
                <ul class="list-unstyled footer-list mt-4">
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Terms of Services</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right mr-1"></i> Privacy Policy</a></li>
               </ul>
            </div><!--end col-->

            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <h4 class="text-light footer-head">Newsletter</h4>
                <p class="mt-4">Sign up and receive the latest tips via email.</p>
                <form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="foot-subscribe form-group position-relative">
                                <label>Write your email <span class="text-danger">*</span></label>
                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                <input type="email" name="email" id="emailsubscribe" class="form-control pl-5 rounded" placeholder="Your email : " required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" id="submitsubscribe" name="send" class="btn btn-soft-primary btn-block" value="Subscribe">
                        </div>
                    </div>
                </form>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</footer><!--end footer-->
<footer class="footer footer-bar">
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="text-sm-left">
                    <p class="mb-0">&copy; 2020 - <?= date('Y').' '. WEB_TITLE ?></p>
                </div>
            </div><!--end col-->
            <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <ul class="list-unstyled text-sm-right mb-0">
                    <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?= image_url('payments/discover.png') ?>" class="avatar avatar-ex-sm" title="Discover" alt=""></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?= image_url('payments/master-card.png') ?>" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?= image_url('payments/paypal.png') ?>" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?= image_url('payments/visa.png') ?>" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                </ul>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</footer><!--end footer-->
<!-- Footer End -->
<!-- Back to top -->
<a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>
<!-- Back to top -->
<!-- javascript -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/jquery-3.5.1.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/jquery.easing.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/scrollspy.min.js"></script>
<!-- Magnific Popup -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/magnific.init.js"></script>
<!-- SLIDER -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/owl.carousel.min.js "></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/owl.init.js "></script>
<!--FLEX SLIDER-->
<script src="<?= HTML_BASE_TEMPLATE ?>js/jquery.flexslider-min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/flexslider.init.js"></script>
<!-- Datepicker -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/flatpickr.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/flatpickr.init.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/counter.init.js "></script>
<!-- Contact -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/contact.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>lightslider/lightslider.js"></script>
<!-- Comingsoon -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/countdown.init.js"></script>
<!-- Typed -->
<script src="https://cdn.jsdelivr.net/npm/timepicker@1.13.14/jquery.timepicker.min.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/typed.js"></script>
<script src="<?= HTML_BASE_TEMPLATE ?>js/typed.init.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<!-- Icons -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/feather.min.js"></script>
<script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
<script src="<?= HTML_BASE_TEMPLATES ?>dist/js/bootstrap-datepicker.min.js"></script>
<!-- Switcher -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/switcher.js"></script>

<!-- Video -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/jquery.mb.YTPlayer.min.js"></script>
<!-- Main Js -->
<script src="<?= HTML_BASE_TEMPLATE ?>js/app.js"></script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2DEH2fkVZNQx4EAuBqErCi9eNJ_nZjn8&callback=initMap"></script>
<script>
     $(document).ready(function() {

         var all_cities = <?= json_encode($all_cities) ?>;
         var all_areas = <?= json_encode($all_areas); ?>;

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

         function initMap() {

             // Try HTML5 geolocation.
             if (navigator.geolocation) {

                 navigator.geolocation.getCurrentPosition(function(position) {
                     var pos = {
                         lat: position.coords.latitude,
                         lng: position.coords.longitude
                     };

                     window.pos = pos;


                     var directionsService = new google.maps.DirectionsService;
                     var directionsDisplay = new google.maps.DirectionsRenderer;
                     //  ourOrigin = new google.maps.LatLng(pos.lat, pos.lng);
                     var map = new google.maps.Map(document.getElementById('map'), {
                         zoom: 7,
                         center: {lat: pos.lat, lng: pos.lng}
                     });
                     directionsDisplay.setMap(map);

                     calculateAndDisplayRoute(directionsService, directionsDisplay);


                 });
             } else {
                 // Browser doesn't support Geolocation
                 handleLocationError(false, infoWindow, map.getCenter());
             }

         }

         initMap();

         function calculateAndDisplayRoute(directionsService, directionsDisplay) {

             console.log("Testing : "+pos);

             directionsService.route({
                 origin:  new google.maps.LatLng(pos.lat, pos.lng),
                 destination: document.getElementById('end').value,
                 travelMode: 'DRIVING'
             }, function(response, status) {
                 if (status === 'OK') {
                     directionsDisplay.setDirections(response);
                 } else {
                     window.alert('Directions request failed due to ' + status);
                 }
             });
         }

         $('[data-toggle="datepicker"]').datepicker('setStartDate', new Date());

         $('.timepicker').timepicker({
             'timeFormat': 'H:i:a',
             'disableTimeRanges': [
                 ['00:00am', '01:00am']
             ]
         });

      $(".player").mb_YTPlayer();
        $("#content-slider").lightSlider({
            loop:true,
            keyPress:true
        });

        $('#image-gallery').lightSlider({
            gallery:true,
            item:1,
            thumbItem:10,
            slideMargin: 0,
            speed:1000,
            auto:true,
            loop:true,
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }  
        });

        $("#join").click(function (e) {
            e.preventDefault();
            $.ajax({
                url : '<?=  HOME_DIR?>join-event',
                type : 'post',
                dataType : 'json',
                data : {
                    'join' : '',
                    'code' : $("#code").val()
                },
                success : function (res) {
                    console.log(res);
                },

                error : function (err) {
                    console.log(err.responseText);
                }
            })
        });

        // $("#datatables").dataTable({});
    });
    </script>
<!--    <script src="//code.tidio.co/lv7otilgv3rzaeaophrlpjxp8r2bxkdo.js" async></script>-->
</body>
</html>