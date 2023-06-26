<?php 

require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;

// Creates the API reader object
$reader = new Reader('refdb/GeoIP2-City.mmdb');

// Get information from the IP address
$address = "102.156.31.244"; //$_SERVER['REMOTE_ADDR'];
$record = $reader->city($address);

echo($record->country->name); // 'United States'
echo($record->city->name); // 'Mountain View'
echo($record->location->latitude); // 37.4223
echo($record->location->longitude); // -122.085
