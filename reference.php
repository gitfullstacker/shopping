<!-------------------------------------------------- 우편주소 검색 -------------------------------------------------->
<html>

<head>
    <meta charset="UTF-8">
    <title>주소 검색</title>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // 주소 검색 버튼 클릭 이벤트 처리
            $('#search_address').click(function() {
                new daum.Postcode({
                    oncomplete: function(data) {
                        // 선택한 주소의 우편번호와 주소 입력하기
                        $('#postcode').val(data.zonecode);
                        $('#address').val(data.address);
                    }
                }).open();
            });
        });
    </script>
</head>

<body>
    <form action="" method="post">
        <input type="text" id="postcode" name="postcode" placeholder="우편번호">
        <input type="text" id="address" name="address" placeholder="주소">
        <button type="button" id="search_address">검색</button>
    </form>
</body>

</html>

<!-------------------------------------------------- 네이버 SNS인증 -------------------------------------------------->
<!-- 호출코드 -->
<?php
// 네이버 로그인 API 호출을 위한 정보
$client_id = '네이버 애플리케이션 Client ID';
$client_secret = '네이버 애플리케이션 Client Secret';
$redirect_uri = '콜백 URL';

// 네이버 로그인 API를 호출할 URL
$api_url = 'https://nid.naver.com/oauth2.0/authorize';
$api_url .= '?client_id=' . $client_id;
$api_url .= '&redirect_uri=' . urlencode($redirect_uri);
$api_url .= '&response_type=code';

// 네이버 로그인 API 호출
header('Location: ' . $api_url);
exit;
?>



<!-- 콜백코드 -->
<?php
// 네이버 로그인 API를 호출한 후 콜백으로 전달받은 인증 코드
$code = $_GET['code'];
$state = $_GET['state'];

// 네이버 로그인 API를 호출할 때 사용한 정보
$client_id = '네이버 애플리케이션 Client ID';
$client_secret = '네이버 애플리케이션 Client Secret';
$redirect_uri = '콜백 URL';

// 네이버 로그인 API를 호출하여 액세스 토큰 발급받기
$api_url = 'https://nid.naver.com/oauth2.0/token';
$data = array(
    'grant_type' => 'authorization_code',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => $code,
    'state' => $state,
);
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($api_url, false, $context);
$response = json_decode($result, true);

// 액세스 토큰과 리프레시 토큰 저장하기
$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];

// 액세스 토큰으로 사용자 정보 가져오기
$api_url = 'https://openapi.naver.com/v1/nid/me';
$authorization_header = 'Authorization: Bearer ' . $access_token;
$options = array(
    'http' => array(
        'header' => $authorization_header . "\r\n",
        'method' => 'GET',
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($api_url, false, $context);
$response = json_decode($result, true);

// 사용자 정보 출력하기
echo '<pre>';
print_r($response);
echo '</pre>';
?>

<!-------------------------------------------------- 카카오 SNS인증 -------------------------------------------------->
<!-- 호출코드 -->
<?php
// 카카오 로그인 API 호출을 위한 정보
$client_id = '카카오 애플리케이션 REST API 키';
$redirect_uri = '콜백 URL';

// 카카오 로그인 API를 호출할 URL
$api_url = 'https://kauth.kakao.com/oauth/authorize';
$api_url .= '?client_id=' . $client_id;
$api_url .= '&redirect_uri=' . urlencode($redirect_uri);
$api_url .= '&response_type=code';

// 카카오 로그인 API 호출
header('Location: ' . $api_url);
exit;
?>


<!-- 콜백코드 -->
<?php
// 카카오 로그인 API를 호출한 후 콜백으로 전달받은 인증 코드
$code = $_GET['code'];

// 카카오 로그인 API를 호출할 때 사용한 정보
$client_id = '카카오 애플리케이션 REST API 키';
$client_secret = '카카오 애플리케이션 Client Secret';
$redirect_uri = '콜백 URL';

// 카카오 로그인 API를 호출하여 액세스 토큰 발급받기
$api_url = 'https://kauth.kakao.com/oauth/token';
$data = array(
    'grant_type' => 'authorization_code',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => $code,
);
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($api_url, false, $context);
$response = json_decode($result, true);

// 액세스 토큰과 리프레시 토큰 저장하기
$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];

// 액세스 토큰으로 사용자 정보 가져오기
$api_url = 'https://kapi.kakao.com/v2/user/me';
$access_token_type = $response['token_type'];
$authorization_header = 'Authorization: ' . $access_token_type . ' ' . $access_token;
$options = array(
    'http' => array(
        'header' => $authorization_header . "\r\n",
        'method' => 'GET',
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($api_url, false, $context);
$response = json_decode($result, true);

// 사용자 정보 출력하기
echo '<pre>';
print_r($response);
echo '</pre>';
?>