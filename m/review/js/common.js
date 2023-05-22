function setLike(int_review) {
    $.ajax({
        url: "set_like.php",
        data: {
            int_review: int_review
        },
        success: function(resultString) {
            result = JSON.parse(resultString);
            if (result['status'] == 401) {
                alert('사용자로그인을 하여야 합니다.');
                return;
            }
            if (result['status'] == 200) {
                $("#like_count_" + int_review).html(result['data']);
            }
        }
    });
}