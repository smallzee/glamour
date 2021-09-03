<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 8/8/2020
 * Time: 9:44 PM
 */

$header = getallheaders();
$header['Authorization'] = base64_encode("he");

var_dump($header);

// Get lat and long by address
/*$dlocation = "iwo road";
$address = $dlocation; // Google HQ
$prepAddr = str_replace(' ','+',$address);
$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
$output= json_decode($geocode);
var_dump($output);
exit();*/
//$latitude = $output->results[0]->geometry->location->lat;
//$longitude = $output->results[0]->geometry->location->lng;

$address = 'iwo road'; // Address
$apiKey = 'AIzaSyB5J13A59ZvXXBb5Z3DrPOrY_Le34rgncA'; // Google maps now requires an API key.
// Get JSON results from this request
$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
$geo = json_decode($geo, true); // Convert the JSON to an array
//
var_dump($geo);
exit();

if (isset($geo['status']) && ($geo['status'] == 'OK')) {
    $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
    $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
}

?>

