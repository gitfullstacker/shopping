<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">공지사항</p>
    </div>
    <div class="mt-[15px] flex flex-col w-full" id="notification_list">
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    $(document).ready(function() {
        searchNotification();
    });

    function searchNotification(page = 0) {
        url = "get_notification_list.php";
        url += "?page=" + page;

        $.ajax({
            url: url,
            success: function(result) {
                $("#notification_list").html(result);
            }
        });
    }
</script>