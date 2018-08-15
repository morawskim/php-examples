<?php

const EARTH_RADIUS_IN_METERS = 6372797.560856;

function deg_rad(float $deg) {
    return $deg * M_PI/180;
}

/**
* Calculate distance using haversin great circle distance formula.
* Return distance in meters
*/
function geohashGetDistance(
    float $lon1d,
    float $lat1d,
    float $lon2d,
    float $lat2d
): float {
    $lat1r = deg_rad($lat1d);
    $lon1r = deg_rad($lon1d);
    $lat2r = deg_rad($lat2d);
    $lon2r = deg_rad($lon2d);
    $u = sin(($lat2r - $lat1r) / 2);
    $v = sin(($lon2r - $lon1r) / 2);
    return 2.0 * EARTH_RADIUS_IN_METERS *
           asin(sqrt($u * $u + cos($lat1r) * cos($lat2r) * $v * $v));
}

//distance between plock and warsaw
var_dump(geohashGetDistance(
    52.5400381,
    19.6289084,
    
    52.2326063,
    20.7810086
)/1000);
