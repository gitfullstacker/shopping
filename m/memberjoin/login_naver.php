<!-- 호출코드 -->
<script>
    // 네이버 로그인 API를 호출하기 위한 클라이언트 ID와 시크릿 키 값
    client_id = "jcs1GgEIyTrIaYrnffvx";
    client_secret = "pE18Auqzs9";
    redirect_uri = window.location.origin + "/m/memberjoin/login_naver_callback.php";
    alert(redirect_uri);
    return;
    state = "1234";

    // URL for the Naver login page
    var loginUrl = "https://nid.naver.com/oauth2.0/authorize?response_type=code";
    loginUrl += "&client_id=" + client_id;
    loginUrl += "&redirect_uri=" + redirect_uri;
    loginUrl += "&state=" + state;

    window.location.href = loginUrl;
</script>