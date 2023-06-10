<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$topmenu = 5;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<?php
$menu = Fnc_Om_Conv_Default($_REQUEST['menu'], "plan");
?>

<!-- 슬라이더 -->
<div class="flex w-full overflow-hidden">
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
    <div x-data="{
        imageCount: 3,
        slider: 1,
        containerWidth: 0,
        handleScroll() {
            const scrollPosition = this.$refs.sliderContainer.scrollLeft;
            const slider = Math.round(scrollPosition / this.containerWidth) + 1;

            this.slider = slider;
        },
        init() {
            this.imageCount = this.$refs.sliderContainer.children.length;
            this.containerWidth = this.$refs.sliderContainer.offsetWidth;

            setInterval(() => {
                this.slider++;
                if (this.slider > this.imageCount) {
                    this.slider = 1;
                }
                this.$refs.sliderContainer.scrollTo({
                    left: (this.slider - 1) * this.containerWidth,
                    behavior: 'smooth'
                });
            }, 3000);
        }
    }" class="flex w-full relative">
        <div class="flex overflow-x-auto snap-x snap-mandatory custom-scrollbar" x-ref="sliderContainer" x-on:scroll="handleScroll">
            <?php
            while ($row = mysql_fetch_assoc($home_banner_list_result)) {
            ?>
                <a href="<?= $row['STR_URL1'] ?>" class="flex-none snap-always snap-center w-screen h-[467px] bg-gray-100">
                    <img class="w-screen h-full object-cover" src="/admincenter/files/bann/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display='none'" alt="">
                </a>
            <?php
            }
            ?>
        </div>
        <div class="absolute w-full flex justify-center px-[77px] bottom-[14.45px]">
            <div class="flex w-full bg-[#C6C6C6] h-[1.55px]">
                <div class="h-[1.55px] bg-black" x-bind:class="slider == imageCount ? 'w-full' : 'w-[' + slider/imageCount * 100 + '%]'"></div>
            </div>
        </div>
    </div>
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

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>


<script>
    $(document).ready(function() {
        searchEvent(0, 1);
        searchEvent(0, 2);
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