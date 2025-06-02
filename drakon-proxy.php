<?php
// drakon-proxy.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$agent_token = 'UmOmbvwaw57e7Zk8nwbJz5wZ7ek1xBXA';
$agent_secret = 'dLFxyvHb86noTHj5ZXFQJUbv9lQKuXv5';
$auth = base64_encode($agent_token . ':' . $agent_secret);

// STEP 1: Auth
$authCurl = curl_init('https://gator.drakon.casino/api/v1/auth/authentication');
curl_setopt($authCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($authCurl, CURLOPT_POST, true);
curl_setopt($authCurl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $auth
]);
$authResponse = curl_exec($authCurl);
curl_close($authCurl);

$authData = json_decode($authResponse, true);
if (!isset($authData['access_token'])) {
    echo json_encode(['error' => 'Auth failed']);
    exit;
}

$accessToken = $authData['access_token'];

// STEP 2: Get games
$gameCurl = curl_init('https://gator.drakon.casino/api/v1/games/all');
curl_setopt($gameCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($gameCurl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken
]);
$gamesResponse = curl_exec($gameCurl);
curl_close($gameCurl);

echo $gamesResponse;
