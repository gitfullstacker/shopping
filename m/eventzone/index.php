<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<!-- 슬라이더 -->
<div class="m_visual">
    <div class="swiper-container1">
        <div class="swiper-wrapper">
            <?
            $SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='6' order by a.int_number asc ";

            $arr_Bann_Data = mysql_query($SQL_QUERY);
            $arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
            ?>
            <?
            for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
            ?>
                <? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
                    <div class="swiper-slide">
                        <? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
                            <a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
                            <? } ?>
                            <img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
                            <? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
                            </a>
                        <? } ?>
                    </div>
                <? } ?>
            <?
            }
            ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
    </div>
    <script>
        var swiper = new Swiper('.swiper-container1', {
            effect: 'fade',
            pagination: '.swiper-pagination',
            paginationClickable: true,
            spaceBetween: 0,
            centeredSlides: true,
            autoplay: 2500,
            autoplayDisableOnInteraction: false,
            loop: true
        });
    </script>
</div>

<!-- NEWS LETTER -->
<div class="news-letter">
    <p class="title">NEWS LETTER</p>
    <div class="top-menu">
        <a class="actived" href="#">
            기획전
        </a>
        <a href="#">
            이벤트
        </a>
    </div>
    <div class="event-list">
        <?php
        for ($i = 0; $i < 5; $i++) {
        ?>
            <div class="item">
                <img src="images/mockup/event1.png" alt="event">
                <p class="title">23 SEASON TREND</p>
                <p class="tag">2023 시즌 패션 트렌드</p>
            </div>
        <?php
        }
        ?>
        <div class="pagination">
            
        </div>
    </div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>