<?php
// 네이버 로그인 API를 호출한 후 콜백으로 전달받은 인증 코드
$code = $_GET['code'];
$state = $_GET['state'];

// 네이버 로그인 API를 호출할 때 사용한 정보
$client_id = 'jcs1GgEIyTrIaYrnffvx';
$client_secret = 'pE18Auqzs9';
$redirect_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] + '/m/memberjoin/login_naver_callback.php';

// 네이버 로그인 API를 호출하여 액세스 토큰 발급받기
$api_url = 'https://nid.naver.com/oauth2.0/token?grant_type=authorization_code'
    . '&client_id=' . $client_id
    . '&client_secret=' . $client_secret
    . '&redirect_uri=' . urlencode($redirect_uri)
    . '&code=' . $code
    . '&state=' . $state;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
$response = json_decode($result, true);
curl_close($curl);

// 액세스 토큰과 리프레시 토큰 저장하기
$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];

// 액세스 토큰으로 사용자 정보 가져오기
$api_url = 'https://openapi.naver.com/v1/nid/me';
$authorization_header = 'Authorization: Bearer ' . $access_token;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array($authorization_header));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
$response = json_decode($result, true);
curl_close($curl);

// encode user information in JSON format
$user_info = json_encode($response);

header("Location: /m/memberjoin/login_sns_proc.php?type=naver&user_info=" . urlencode($user_info));