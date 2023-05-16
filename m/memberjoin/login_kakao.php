<!-- 호출코드 -->

<script>
    // 카카오 로그인 API 호출을 위한 정보
    client_id = "4a0157d4a176c25b8687827537ecd8dd";
    redirect_uri = "http://localhost/m/memberjoin/login_kakao_callback.php";
    state = "1234";

    // URL for the Kakao login page
    var loginUrl = "https://kauth.kakao.com/oauth/authorize";
    loginUrl += "?client_id=" + client_id;
    loginUrl += "&redirect_uri=" + redirect_uri;
    loginUrl += "&response_type=code";

    window.location.href = loginUrl;
</script>