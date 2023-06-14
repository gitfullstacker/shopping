function setLike(bd_seq) {
    $.ajax({
        url: "set_like.php",
        data: {
            bd_seq: bd_seq
        },
        success: function (resultString) {
            result = JSON.parse(resultString);
            if (result['status'] == 401) {
                alert('사용자로그인을 하여야 합니다.');

                const str_url = encodeURIComponent(window.location.pathname + window.location.search);
                document.location.href = "/m/memberjoin/login.php?loc=" + str_url;
            }
            if (result['status'] == 200) {
                $("#like_count_" + bd_seq).html(result['data']);
            }
        }
    });
}