<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$topmenu = 5;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$menu = Fnc_Om_Conv_Default($_REQUEST['menu'], "plan");
?>

<!-- 슬라이더 -->
<div class="slider-section">
    <?php
    $SQL_QUERY =     'SELECT 
						A.*
					FROM 
						' . $Tname . 'comm_banner A
					WHERE 
						A.STR_SERVICE="Y"
						AND A.INT_GUBUN=9
					ORDER BY A.DTM_INDATE DESC';

    $home_banner_list_result = mysql_query($SQL_QUERY);
    ?>
    <?php
    while ($row = mysql_fetch_assoc($home_banner_list_result)) {
    ?>
        <a href="<?= $row['STR_URL1'] ?: '#' ?>">
            <img class="min-w-full max-w-full w-full h-[467px]" src="/admincenter/files/bann/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display='none'" alt="">
        </a>
    <?php
    }
    ?>
</div>

<!-- NEWS LETTER -->
<div x-data="{ menu: '<?= $menu ?>' }" class="mt-[50px] flex flex-col items-center w-full">
    <p class="font-extrabold text-xl leading-[22px] text-[#333333]">NEWS LETTER</p>
    <div class="mt-[26px] flex flex-row gap-[70px] items-center justify-center">
        <div class="flex flex-col gap-[3px] items-center px-[3px] border-[#6A696C]" x-bind:class="menu == 'plan' ? 'border-b' : 'border-none'" x-on:click="menu = 'plan'">
            <p class="font-bold text-sm leading-[16px]" x-bind:class="menu == 'plan' ? 'text-[#6A696C]' : 'text-[#999999]'">기획전</p>
        </div>
        <div class="flex flex-col gap-[3px] items-center px-[3px] border-[#6A696C]" x-bind:class="menu == 'event' ? 'border-b' : 'border-none'" x-on:click="menu = 'event'">
            <p class="font-bold text-sm leading-[16px]" x-bind:class="menu == 'event' ? 'text-[#6A696C]' : 'text-[#999999]'">이벤트</p>
        </div>
    </div>
    <div class="mt-[33px] flex flex-col w-full">
        <!-- Plan -->
        <div x-show="menu == 'plan'" class="flex flex-col w-full" id="plan_list">
        </div>
        <!-- Event -->
        <div x-show="menu == 'event'" class="flex flex-col w-full" id="event_list">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        searchEvent(0, 1);
        searchEvent(0, 2);

        $('.slider-section').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true
        });
    });

    function searchEvent(page = 0, type) {
        url = "get_event_list.php";
        url += "?page=" + page;
        url += "&int_type=" + type;

        $.ajax({
            url: url,
            success: function(result) {
                switch (type) {
                    case 1:
                        $("#event_list").html(result);
                        break;
                    case 2:
                        $("#plan_list").html(result);
                        break;
                }

            }
        });
    }
</script>

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>