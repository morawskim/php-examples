<?php

if ($argc != 3) {
    fprintf(STDERR, "USAGE: ${argv[0]} ORIGIN DESTINATION");
    exit(1);
}

$key = urlencode(getenv('GOOGLE_MAPS_DISTANCE_MATRIX_KEY'));
if (empty($key)) {
    fprintf(STDERR, "ENV GOOGLE_MAPS_DISTANCE_MATRIX_KEY can't be empty");
    exit(1);
}

$origin = urlencode($argv[1]);
$destination = urlencode($argv[2]);

#more info about params: https://developers.google.com/maps/documentation/distance-matrix/intro
$baseUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&mode=driving&key=${key}";
$url = "${baseUrl}&origins=${origin}&destinations=${destination}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

print_r($response);
