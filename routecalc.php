<!DOCTYPE html>
<html>
<head>
	<title>Distance Calculator</title>

</head>
<body>
	

<?php

//specify long and lat of two points
$latFrom = '14.3915605';
$longFrom = '120.9984441';
$latTo = '14.3913595';
$longTo = '120.9977847';

$theta = $longFrom - $longTo;
$disto = sin(deg2rad($latFrom)) * sin(deg2rad($latTo)) + cos(deg2rad($latFrom)) * cos(deg2rad($latTo)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;


$distance = round($miles * 1.609344, 6).' km';
$distToMeters = $distance * 1000;

//----------2nd test distance calculation
$secondDist = rad2deg(acos(sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($longFrom-$longTo)));
//d=acos(sin(lat1)*sin(lat2)+cos(lat1)*cos(lat2)*cos(lon.1-lon2))

echo "distance: " . $distToMeters . " m";
echo "<br>";
echo "test disto: " . $disto;
?>



</body>
</html>