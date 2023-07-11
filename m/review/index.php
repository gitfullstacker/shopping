<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<script language="javascript" src="js/common.js"></script>
<script language="javascript" src="js/index.js"></script>

<div class="flex flex-col items-center w-full pt-[30px]">
    <!-- BEST REVIEW -->
    <div class="flex flex-col w-full items-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">BEST REVIEW</p>
        <div class="mt-[22px] grid grid-cols-2 gap-x-[15px] gap-y-5 px-5 w-full">
            <?php
            $SQL_QUERY =    'SELECT 
                                A.BD_SEQ,
                                A.CONF_SEQ,
                                A.MEM_ID,
                                A.BD_CONT,
                                A.BD_REG_DATE,
                                A.BD_ITEM2,
                                IFNULL(B.IMG_F_NAME, "") AS IMG_F_NAME,
                                C.STR_GOODNAME,
                                C.STR_IMAGE1,
                                C.INT_DISCOUNT,
                                C.INT_PRICE,
                                C.INT_TYPE,
                                D.STR_CODE
                            FROM 
                                `' . $Tname . 'b_bd_data@01` A
                            LEFT JOIN
                                `' . $Tname . 'b_img_data@01` B
                            ON
                                A.CONF_SEQ=B.CONF_SEQ
                                AND
                                A.BD_SEQ=B.BD_SEQ
                                AND
                                B.IMG_ALIGN=1
                            LEFT JOIN
                                ' . $Tname . 'comm_goods_master C
                            ON
                                A.BD_ITEM1=C.STR_GOODCODE
                            LEFT JOIN
                                ' . $Tname . 'comm_com_code D
                            ON
                                C.INT_BRAND=D.INT_NUMBER
                            WHERE 
                                A.CONF_SEQ=2
                                AND A.BD_ID_KEY IS NOT NULL
                                AND A.BD_BEST=1
                                AND (A.BD_HIDE=0 OR A.MEM_ID="' . $arr_Auth[0] . '")
                            ORDER BY A.BD_ITEM2 DESC, A.BD_REG_DATE DESC
                            LIMIT 4';

            $best_review_list_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($best_review_list_result)) {
                if ($row['IMG_F_NAME']) {
                    $image_url = '/admincenter/files/boad/2/' . $row['IMG_F_NAME'];
                } else {
                    $image_url = '/admincenter/files/good/' . $row['STR_IMAGE1'];
                }
            ?>
                <a href="/m/review/detail.php?bd_seq=<?= $row['BD_SEQ'] ?>" class="flex flex-col w-full">
                    <div class="flex relative w-full h-[167px] bg-gray-100">
                        <img class="flex w-full object-cover object-center" src="<?= $image_url ?>" onerror="this.style.display='none'" alt="">
                        <div class="absolute left-0 bottom-0 w-full px-[9px] py-[8px] flex flex-col justify-center gap-[3px] bg-[#F8F8F8] bg-opacity-80">
                            <p class="font-semibold text-xs leading-[14px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                            <p class="font-medium text-xs leading-[14px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                        </div>
                    </div>
                    <p class="mt-[11px] font-extrabold text-xs leading-[14px] text-[#333333]"><?= str_repeat('★', $row['BD_ITEM2']) ?></p>
                    <p class="mt-1.5 font-medium text-[11px] leading-[15px] text-[#333333] line-clamp-2"><?= strip_tags($row['BD_CONT']) ?></p>
                </a>
            <?php
            }
            ?>
        </div>
        <img class="mt-[30px] w-full" src="images/main.png" alt="">
    </div>
    <!-- ALL REVIEW -->
    <div class="mt-[35px] flex flex-col w-full items-center px-[14px]">
        <p class="font-extrabold text-lg leading-[20px] text-black">ALL REVIEW</p>
        <div class="mt-[15px] border-t border-b border-[#E0E0E0] flex justify-between items-center py-3 w-full">
            <p class="font-bold text-[11px] leading-[12px] text-[#666666]"></p>
            <div x-data="{ 
                    showOrderBy: false,
                    selectedValue: 'all',
                    selectedTitle: '전체',
                    orderList: [
                        {
                            value: 'all',
                            title: '전체'
                        },
                        {
                            value: 'rent',
                            title: '렌트'
                        },
                        {
                            value: 'subscription',
                            title: '구독'
                        }
                    ],
                    changeOrderItem(value, title) {
                        this.selectedValue = value;
                        this.selectedTitle = title;
                        this.showOrderBy = false;

                        filter_type = this.selectedValue;
                        searchReview();
                    }
                }" class="flex gap-0.5 items-center cursor-pointer relative">
                <div class="w-[9px] h-[9px]">
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.48906 1H6.51694L3.99797 4.15L1.48906 1ZM0.106392 0.805001C1.12202 2.1 2.99742 4.5 2.99742 4.5V7.5C2.99742 7.775 3.22368 8 3.50021 8H4.50579C4.78232 8 5.00857 7.775 5.00857 7.5V4.5C5.00857 4.5 6.87895 2.1 7.89458 0.805001C7.9522 0.731187 7.98783 0.642764 7.99739 0.549803C8.00696 0.456842 7.99009 0.363077 7.94869 0.279186C7.9073 0.195294 7.84305 0.124647 7.76326 0.0752883C7.68347 0.0259299 7.59134 -0.000156018 7.49738 7.02021e-07H0.503594C0.0862804 7.02021e-07 -0.15003 0.475001 0.106392 0.805001Z" fill="#999999" />
                    </svg>
                </div>
                <p class="font-bold text-[10px] leading-[10px] text-[#999999]" x-text="selectedTitle" x-on:click="showOrderBy = true">인기순</p>
                <div x-show="showOrderBy" class="absolute top-[15px] right-0 flex flex-col gap-0.5 items-center w-20 bg-white shadow-md z-10" style="display: none;" x-on:click.away="showOrderBy = false">
                    <template x-for="item in orderList">
                        <div class="flex justify-center py-1 font-bold text-[10px] leading-[10px] items-center text-[#999999]" x-text="item.title" x-on:click="changeOrderItem(item.value, item.title)">인기순</div>
                    </template>
                </div>
            </div>
        </div>
        <div id="review_list" class="flex flex-col w-full">
        </div>
    </div>
</div>

<?php
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>