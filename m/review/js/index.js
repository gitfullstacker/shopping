window.filter_type = 'all';

$(document).ready(function () {
    searchReview();
});

function searchReview(page = 0) {
    url = "get_review_list.php";
    url += "?page=" + page;
    url += "&filter_type=" + filter_type;

    $.ajax({
        url: url,
        success: function (result) {
            $("#review_list").html(result);
            if (page > 0) {
                $('html, body').animate({
                    scrollTop: $("#review_list").offset().top - 150
                }, 500);
            }
        }
    });
}