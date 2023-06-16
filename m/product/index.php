<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$product_type = Fnc_Om_Conv_Default($_REQUEST['product_type'], 1);

$topmenu = 2;
switch ($product_type) {
    case 2:
        $topmenu = 2;
        break;
    case 1:
        $topmenu = 3;
        break;
    case 3:
        $topmenu = 4;
        break;
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php";
?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<?php
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

//구독멤버십 여부확인
$is_sub_membership = fnc_sub_member_info() > 0 ? true : false;
?>

<!-- Body -->
<div x-data="{
        showCalendar: false,
        showOption: 0,
        rentDate: {
            start: null,
            end: null
        }
    }" class="main-body">
    <!-- 브랜드검색 -->
    <div x-data="{ 
        pick: 0, 
        scroll(index) {
            this.pick = index;
            $refs.scrollPanel.scrollLeft = $refs.scrollItem.offsetWidth * index;
        }
    }" class="flex flex-col w-full gap-5">
        <?php
        $where_query = "";
        switch ($product_type) {
            case 1:
                $where_query = "AND STR_SHOW_MAIN = 'Y'";
                break;
            case 2:
                $where_query = "AND STR_SHOW_REN = 'Y'";
                break;
            case 3:
                $where_query = "AND STR_SHOW_VIN = 'Y'";
                break;
        }

        $query =    "SELECT * 
                        FROM " . $Tname . "comm_com_code 
                    WHERE 
                        str_service = 'Y' 
                        " . $where_query . "
                        AND int_gubun = 2";
        $top_brand_list_result = mysql_query($query);
        ?>
        <div class="flex items-start gap-4 px-[16px] pb-1 overflow-x-auto">
            <?php
            $index = 0;
            while ($row = mysql_fetch_assoc($top_brand_list_result)) {
            ?>
                <?php
                $mini_banner = '';
                switch ($product_type) {
                    case 2:
                        $mini_banner = $row['STR_BANNER2'];
                        break;
                    case 1:
                        $mini_banner = $row['STR_BANNER4'];
                        break;
                    case 3:
                        $mini_banner = $row['STR_BANNER6'];
                        break;
                }
                ?>
                <div class="flex flex-col gap-[9px] items-center justify-start" x-on:click="scroll(<?= $index ?>);">
                    <div class="flex justify-center items-center w-[77px] h-[77px] rounded-full bg-gray-100 <?= $mini_banner ?: 'animate-pulse' ?>" x-bind:class="pick == <?= $index ?> ? 'border border-solid border-black' : 'border-none'">
                        <img class="w-full h-full rounded-full" src="/admincenter/files/com/<?= $mini_banner ?>" onerror="this.style.display = 'none'" alt="category" />
                    </div>
                    <p class="font-bold text-[13px] leading-[14px] text-center" x-bind:class="pick == <?= $index ?> ? 'text-black' : 'text-[#444444]'"><?= $row['STR_CODE'] ?></p>
                </div>
            <?
                $index++;
            }
            ?>
        </div>
        <div x-ref="scrollPanel" class="snap-mandatory snap-x flex overflow-x-hidden pb-1 scroll-smooth">
            <?php
            if (mysql_num_rows($top_brand_list_result) > 0) {
                mysql_data_seek($top_brand_list_result, 0);
            }
            while ($row = mysql_fetch_assoc($top_brand_list_result)) {
            ?>
                <?php
                $main_banner = '';
                switch ($product_type) {
                    case 2:
                        $main_banner = $row['STR_BANNER3'];
                        break;
                    case 1:
                        $main_banner = $row['STR_BANNER5'];
                        break;
                    case 3:
                        $main_banner = $row['STR_BANNER7'];
                        break;
                }
                ?>
                <div x-ref="scrollItem" class="snap-center flex-none flex flex-col gap-3 w-full">
                    <div class="flex w-full h-[302px] bg-gray-100 <?= $main_banner ?: 'animate-pulse' ?>">
                        <img class="object-cover object-center min-w-full" src="/admincenter/files/com/<?= $main_banner ?>" onerror="this.style.display = 'none'" alt="" />
                    </div>
                    <div class="snap-x">
                        <div class="grid grid-cols-3 gap-1.5 px-[14px]">
                            <?php
                            $where_query = "";
                            switch ($product_type) {
                                case 1:
                                    $where_query = "AND (A.STR_GOODCODE = '" . $row['STR_SUB_GOOD1'] . "' OR A.STR_GOODCODE = '" . $row['STR_SUB_GOOD2'] . "' OR A.STR_GOODCODE = '" . $row['STR_SUB_GOOD3'] . "')";
                                    break;
                                case 2:
                                    $where_query = "AND (A.STR_GOODCODE = '" . $row['STR_REN_GOOD1'] . "' OR A.STR_GOODCODE = '" . $row['STR_REN_GOOD2'] . "' OR A.STR_GOODCODE = '" . $row['STR_REN_GOOD3'] . "')";
                                    break;
                                case 3:
                                    $where_query = "AND (A.STR_GOODCODE = '" . $row['STR_VIN_GOOD1'] . "' OR A.STR_GOODCODE = '" . $row['STR_VIN_GOOD2'] . "' OR A.STR_GOODCODE = '" . $row['STR_VIN_GOOD3'] . "')";
                                    break;
                            }

                            $query =    "SELECT * 
                                        FROM 
                                            " . $Tname . "comm_goods_master A
                                        WHERE A.STR_GOODCODE IS NOT NULL
                                            " . $where_query;

                            $brand_product_list = mysql_query($query);

                            while ($product_row = mysql_fetch_assoc($brand_product_list)) {
                            ?>
                                <a href="/m/product/detail.php?str_goodcode=<?= $product_row['STR_GOODCODE'] ?>" class="flex flex-col <?= $product_row ?: 'animate-pulse' ?>">
                                    <div class="w-[118px] h-[118px] flex justify-center items-center p-2 bg-[#F9F9F9] rounded-md">
                                        <img class="w-full" src="/admincenter/files/good/<?= $product_row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                                    </div>
                                    <p class="mt-2 font-extrabold text-xs leading-3 text-[#333333] line-clamp-1"><?= $product_row['STR_GOODNAME'] ?: '' ?></p>
                                    <div class="mt-1 flex gap-[3px] items-center">
                                        <?php
                                        switch ($product_type) {
                                            case 1:
                                        ?>
                                                <p class="font-bold text-[13px] leading-[14px] text-black">
                                                    <span class="font-medium text-[#EEAC4C]">월</span> <?= number_format($site_Data['INT_OPRICE1']) ?>원
                                                </p>
                                            <?php
                                                break;
                                            case 2:
                                            ?>
                                                <p class="font-extrabold text-[13px] leading-[14px] text-[#00402F] <?= $product_row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
                                                    <?= $product_row['INT_DISCOUNT'] ?>%
                                                </p>
                                                <p class="font-bold text-[13px] leading-[14px] text-black">
                                                    <span class="font-medium">일</span> <?= number_format($product_row['INT_PRICE'] - $product_row['INT_PRICE'] * $product_row['INT_DISCOUNT'] / 100) ?>원
                                                </p>
                                            <?php
                                                break;
                                            case 3:
                                            ?>
                                                <p class="font-extrabold text-[13px] leading-[14px] text-[#7E6B5A] <?= $product_row['INT_DISCOUNT'] ? '' : 'hidden' ?>">
                                                    <?= $product_row['INT_DISCOUNT'] ?>%
                                                </p>
                                                <p class="font-bold text-[13px] leading-[14px] text-black">
                                                    <?= number_format($product_row['INT_PRICE'] - $product_row['INT_PRICE'] * $product_row['INT_DISCOUNT'] / 100) ?>원
                                                </p>
                                        <?php
                                                break;
                                        }
                                        ?>
                                    </div>
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- ABLANC RENT -->
    <div class="ablanc-rent">
        <?php
        switch ($product_type) {
            case 2:
        ?>
                <p class="title">ABLANC RENT</p>
                <div class="filter-section">
                    <p class="description">이용하고 싶은 날짜를 선택해주세요!</p>
                    <button class="select-btn" x-on:click="showCalendar = true" x-text="(rentDate.start != null && rentDate.end != null) ? (rentDate.start + ' ~ ' + rentDate.end) : '시작 날짜 선택'">시작 날짜 선택</button>
                    <div class="filter-list">
                        <button class="item-btn" x-on:click="showOption = 1">브랜드</button>
                        <button class="item-btn" x-on:click="showOption = 2">사이즈</button>
                        <button class="item-btn" x-on:click="showOption = 3">스타일</button>
                    </div>
                </div>
            <?php
                break;
            case 1:
            ?>
                <p class="title">CHOICE IT BAG</p>
                <div class="filter-section">
                    <p class="description">월 1회 무료교환으로 다양한 가방을 사용해보세요.</p>
                    <div class="filter-list">
                        <button class="item-btn" x-on:click="showOption = 1">브랜드</button>
                        <button class="item-btn" x-on:click="showOption = 2">사이즈</button>
                        <button class="item-btn" x-on:click="showOption = 3">스타일</button>
                    </div>
                </div>
            <?php
                break;
            case 3:
            ?>
                <p class="title">CHOICE IT BAG</p>
                <div class="filter-section">
                    <p class="description">월 1회 무료교환으로 다양한 가방을 사용해보세요.</p>
                    <div class="filter-list">
                        <button class="item-btn" x-on:click="showOption = 1">브랜드</button>
                        <button class="item-btn" x-on:click="showOption = 2">사이즈</button>
                        <button class="item-btn" x-on:click="showOption = 3">스타일</button>
                    </div>
                </div>
        <?php
                break;
        }
        ?>
        <div class="product-section">
            <div class="top-section">
                <?php
                if ($product_type == 1) {
                ?>
                    <div x-data="{ 
                    filterSubscription: false,
                    toogleSubscription() {
                        this.filterSubscription = !this.filterSubscription;
                        filter_subscription = this.filterSubscription;
                        searchProduct();
                    }
                }" class="discount-view" x-on:click="toogleSubscription()">
                        <div class="w-[22.87px] h-[13.24px] p-[1px] rounded-[13.24px] flex items-center" x-bind:class="filterSubscription ? 'bg-[#4BCA36] justify-end' : 'bg-[#DDDDDD] justify-start'">
                            <div class="w-[10.97px] h-[10.97px] rounded-full bg-white"></div>
                        </div>
                        <p>구독 가능</p>
                    </div>
                <?php
                } else {
                ?>
                    <div x-data="{ 
                    filterDiscount: false,
                    toogleDiscount() {
                        this.filterDiscount = !this.filterDiscount;
                        filter_discount = this.filterDiscount;
                        searchProduct();
                    }
                }" class="discount-view" x-on:click="toogleDiscount()">
                        <div class="w-[22.87px] h-[13.24px] p-[1px] rounded-[13.24px] flex items-center" x-bind:class="filterDiscount ? 'bg-[#4BCA36] justify-end' : 'bg-[#DDDDDD] justify-start'">
                            <div class="w-[10.97px] h-[10.97px] rounded-full bg-white"></div>
                        </div>
                        <p>할인 상품보기</p>
                    </div>
                <?php
                }
                ?>

                <div x-data="{ 
                    showOrderBy: false,
                    selectedValue: 'favorite',
                    selectedTitle: '인기순',
                    orderList: [
                        {
                            value: 'favorite',
                            title: '인기순'
                        },
                        {
                            value: 'new',
                            title: '신상품순'
                        },
                        {
                            value: 'recommend',
                            title: '추천순'
                        },
                        {
                            value: 'price_low',
                            title: '낮은가격순'
                        },
                        {
                            value: 'price_high',
                            title: '높은가격순'
                        }
                    ],
                    changeOrderItem(value, title) {
                        this.selectedValue = value;
                        this.selectedTitle = title;
                        this.showOrderBy = false;

                        order_by = this.selectedValue;
                        searchProduct();
                    }
                }" class="flex gap-0.5 items-center relative">
                    <div class="w-[9px] h-[9px] flex justify-center items-center">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.48906 1H6.51694L3.99797 4.15L1.48906 1ZM0.106392 0.805001C1.12202 2.1 2.99742 4.5 2.99742 4.5V7.5C2.99742 7.775 3.22368 8 3.50021 8H4.50579C4.78232 8 5.00857 7.775 5.00857 7.5V4.5C5.00857 4.5 6.87895 2.1 7.89458 0.805001C7.9522 0.731187 7.98783 0.642764 7.99739 0.549803C8.00696 0.456842 7.99009 0.363077 7.94869 0.279186C7.9073 0.195294 7.84305 0.124647 7.76326 0.0752883C7.68347 0.0259299 7.59134 -0.000156018 7.49738 7.02021e-07H0.503594C0.0862804 7.02021e-07 -0.15003 0.475001 0.106392 0.805001Z" fill="#999999" />
                        </svg>
                    </div>
                    <p class="font-bold text-[10px] leading-[10px] text-[#999999]" x-text="selectedTitle" x-on:click="showOrderBy = true">인기순</p>
                    <div x-show="showOrderBy" class="absolute top-[15px] right-0 flex flex-col gap-0.5 items-center w-20 bg-white shadow-md z-10" style="display: none;" x-on:click.away="showOrderBy = false">
                        <template x-for="item in orderList">
                            <div class="flex justify-center py-2 font-bold text-[10px] leading-[10px] items-center text-[#999999]" x-text="item.title" x-on:click="changeOrderItem(item.value, item.title)">인기순</div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="product-list" id="product_list">
            </div>
            <div class="see-more-section">
                <button class="see-more-btn" onclick="seeMoreClick()">
                    <span>더보기</span>
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.14661 1.33063L5.15716 5.21312C5.10967 5.2592 5.05822 5.29176 5.00281 5.31081C4.9474 5.33017 4.88803 5.33984 4.82471 5.33984C4.76138 5.33984 4.70202 5.33017 4.64661 5.31081C4.5912 5.29176 4.53975 5.2592 4.49225 5.21312L0.490934 1.33063C0.380116 1.2231 0.324707 1.08869 0.324707 0.927402C0.324707 0.766111 0.384074 0.627863 0.502807 0.512655C0.621541 0.397448 0.760063 0.339844 0.918374 0.339844C1.07669 0.339844 1.21521 0.397448 1.33394 0.512655L4.82471 3.89975L8.31547 0.512655C8.42629 0.405128 8.56275 0.351365 8.72486 0.351365C8.88729 0.351365 9.02787 0.408968 9.14661 0.524176C9.26534 0.639383 9.32471 0.773791 9.32471 0.927401C9.32471 1.08101 9.26534 1.21542 9.14661 1.33063Z" fill="#333333" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Review -->
    <div class="review">
        <div class="top-section">
            <div class="left-section">
                <p class="title">REVIEW</p>
                <p class="description">실시간 리뷰</p>
            </div>
            <a href="/m/review/index.php" class="right-section">
                <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.56897 1.12354L14.1346 6.05335L8.56897 10.7839" stroke="black" stroke-width="1.08333" stroke-miterlimit="10" />
                    <path d="M14.1347 6.05322H0.212161" stroke="black" stroke-width="1.08333" stroke-miterlimit="10" />
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-2 gap-x-[15px] gap-y-5 w-full">
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
                                AND C.INT_TYPE=' . $product_type . '
                            ORDER BY A.BD_ORDER DESC
                            LIMIT 4';

            $review_list_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($review_list_result)) {
                if ($row['IMG_F_NAME']) {
                    $image_url = '/admincenter/files/boad/2/' . $row['IMG_F_NAME'];
                } else {
                    $image_url = '/admincenter/files/good/' . $row['STR_IMAGE1'];
                }
            ?>
                <a href="/m/review/detail.php?bd_seq=<?= $row['BD_SEQ'] ?>" class="flex flex-col w-full">
                    <div class="flex relative w-full h-[167px] bg-gray-100">
                        <img class="flex w-full object-cover object-center" src="<?= $image_url ?>" onerror="this.style.display = 'none'" alt="">
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
    </div>

    <div x-show="showCalendar" x-transition x-data="{
        currentYear: null,
        currentMonth: null,
        firstDayOfWeek: 0,
        dates: [],
        selectedStatus: 0,
        startDate: null,
        endDate: null,
        selectedDates: [],
        showCalendarAlert: false,

        generateDates(month, year) {
            year = month == 0 ? year - 1 : month == 13 ? year + 1 : year;
            month = month == 0 ? 12 : month == 13 ? 1 : month;
            const firstDayOfWeek = new Date(year, month - 1, 1).getDay();
            const daysInMonth = new Date(year, month, 0).getDate();
            const dates = [];
            
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month - 1, day);

                status = 1;

                if (this.selectedStatus == 0) {
                    const today = new Date();
                    today.setDate(today.getDate() + 2);

                    if (date < today) {
                        status = 0;
                    } else if (date.getDay() === 1 || date.getDay() === 2) {
                        // Monday: 1, Tuesday: 2
                        status = 0;
                    }
                } else if (this.selectedStatus == 1) {
                    const disableEndDay = new Date(this.startDate);
                    disableEndDay.setDate(disableEndDay.getDate() + 2);

                    const finalEndday = new Date(this.startDate);
                    finalEndday.setDate(finalEndday.getDate() + 14);

                    if (date.getFullYear() == this.startDate.getFullYear() && date.getMonth() == this.startDate.getMonth() && date.getDate() == this.startDate.getDate()) {
                        status = 2;
                    } else if (date > finalEndday) {
                        status = 0;
                    } else if (date.getDay() === 5 || date.getDay() === 6) {
                        // Friday: 1, Saturday: 2
                        status = 0;
                    } else if (date > disableEndDay) {
                        status = 1;
                    } else {
                        status = 0;
                    }
                } else {
                    status = 0;
                    if (date.getFullYear() == this.startDate.getFullYear() && date.getMonth() == this.startDate.getMonth() && date.getDate() == this.startDate.getDate()) {
                        status = 2;
                    } else if (date.getFullYear() == this.endDate.getFullYear() && date.getMonth() == this.endDate.getMonth() && date.getDate() == this.endDate.getDate()) {
                        status = 3;
                    } else if (date >= this.startDate && date <= this.endDate) {
                        status = 4;
                    } else if (date > this.endDate) {
                        status = 5;
                    }
                }

                dates.push({
                    date: date,
                    day: day,
                    status: status   // Disable: 0, Enable: 1, Picked Start: 2, Picked End: 3, Period: 4, Hide: 5, Export: 6, Collect: 7
                });
            }

            this.dates = dates;
            this.currentYear = year;
            this.currentMonth = month;
            this.firstDayOfWeek = firstDayOfWeek;
        },
        selectDate(date) {
            var selectedDate = date.date;

            if (this.selectedStatus == 0) {
                this.startDate = new Date(selectedDate);
                this.selectedStatus++;
            } else if (this.selectedStatus == 1) {
                if (selectedDate.getTime() == this.startDate.getTime()) {
                    // 시작날짜를 눌렀을때 시작해제
                    this.selectedStatus = 0;
                    this.startDate = null;
                } else {
                    this.endDate = new Date(selectedDate);
                    this.selectedStatus++;
                }
            } else if (this.selectedStatus == 2) {
                if (selectedDate.getTime() == this.endDate.getTime()) {
                    // 마감날짜를 눌렀을때 마감해제
                    this.selectedStatus = 1;
                    this.endDate = null;
                }
            }

            this.generateDates(selectedDate.getMonth() + 1, selectedDate.getFullYear());
        },
        formatDate(date) {
            const year = date.getFullYear().toString().slice(-2);
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            
            return `${year}.${month}.${day}`;
        },
        formatDateWithWeek(date) {
            const weekdays = ['일', '월', '화', '수', '목', '금', '토'];
            const year = date.getFullYear().toString().slice(-2);
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const weekday = weekdays[date.getDay()];
            
            return `${year}. ${month}. ${day} (${weekday})`;
        },
        applyFilter() {
            showCalendar = false;
            start_date = this.startDate;
            end_date = this.endDate;
            rentDate.start = start_date ? this.formatDateWithWeek(start_date) : null;
            rentDate.end = end_date ? this.formatDateWithWeek(end_date) : null;
            searchProduct();
        },
        initDate() {
            this.selectedStatus = 0;
            this.startDate = null;
            this.endDate = null;
            this.selectedDates = [];
            this.generateDates(this.currentMonth, this.currentYear);
            start_date = null;
            end_date = null;
            rentDate.start = null;
            rentDate.end = null;
        },
        showAlert() {
            this.showCalendarAlert = true;
            setTimeout(() => this.showCalendarAlert = false, 2000);
        },
        init() {
            today = new Date();
            this.generateDates(today.getMonth() + 1, today.getFullYear());
        }
    }" class="w-full h-full bg-black bg-opacity-60 fixed top-0 z-50 flex justify-center items-center max-w-[410px]" style="display: none;">
        <div class="flex flex-col items-center rounded-lg bg-white w-[95%] relative">
            <div class="flex flex-row pt-3 pb-2.5 px-[26px] justify-between items-center w-full">
                <p class="font-extrabold text-xs leading-[14px] text-black">예약</p>
                <button class="w-2.5 h-2.5" x-on:click="showCalendar = false">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                    </svg>
                </button>
            </div>
            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
            <div class="flex flex-col items-center w-full overflow-auto h-[450px] pb-[35px] ">
                <div class="flex flex-col items-center justify-center px-8 pt-[34px] pb-7">
                    <p class="font-medium text-base leading-[18px] text-black">예약날짜 설정하기</p>
                    <div class="mt-[17px] flex gap-[13px] items-center">
                        <div class="flex gap-[1.4px] items-center">
                            <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#BED2B6]"></div>
                            <label for="calendar_available" class="font-bold text-[11px] leading-[11px] text-[#666666]">선택가능</label>
                        </div>
                        <div class="flex gap-[1.4px] items-center">
                            <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#E5EAE3]"></div>
                            <label for="calendar_use" class="font-bold text-[11px] leading-[11px] text-[#666666]">이용기간</label>
                        </div>
                        <div class="flex gap-[1.4px] items-center">
                            <div class="w-[12.56px] h-[12.56px] rounded-full bg-[#DDDDDD]"></div>
                            <label for="calendar_no_use" class="font-bold text-[11px] leading-[11px] text-[#666666]">이용불가</label>
                        </div>
                    </div>
                    <div class="flex flex-col w-full">
                        <div class="mt-[27px] relative flex justify-center items-end w-full">
                            <p class="font-extrabold text-[13px] leading-[15px] text-black" x-text="currentYear + '.' + (currentMonth > 9 ? currentMonth : '0' + currentMonth)">2023.01</p>
                            <button id="previous_month" class="absolute left-0 bottom-0" x-on:click="generateDates(currentMonth - 1, currentYear)">
                                <svg width="7" height="9" viewBox="0 0 7 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.19892 4.51706L6.67092 6.74006V8.39106L0.378921 5.14106V3.85406L6.67092 0.604062V2.24206L2.19892 4.43906V4.51706Z" fill="black" />
                                </svg>
                            </button>
                            <button id="next_month" class="absolute right-0 bottom-0" x-on:click="generateDates(currentMonth + 1, currentYear)">
                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.23103 4.43906L0.759028 2.24206V0.604062L7.05103 3.85406V5.14106L0.759028 8.39106V6.74006L5.23103 4.51706V4.43906Z" fill="black" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-[17px] flex gap-[9px] justify-between items-center">
                            <?php
                            $daysOfWeek = array("일", "월", "화", "수", "목", "금", "토");
                            for ($i = 0; $i < count($daysOfWeek); $i++) {
                            ?>
                                <div class="flex-1 flex justify-center items-center">
                                    <p class="font-bold text-xs leading-[14px] text-[#898989]"><?= $daysOfWeek[$i] ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <hr class="mt-[19px] border-t-[0.5px] border-[#E0E0E0]" />
                        <div class="mt-[13px] grid grid-cols-7 gap-y-[5px] place-content-between place-items-center w-full">
                            <template x-for="i in firstDayOfWeek">
                                <div class="flex justify-center items-center rounded-full w-[38px] h-[38px]"></div>
                            </template>
                            <template x-for="date in dates">
                                <div class="flex justify-center items-center px-1.5" x-bind:class="
                                date.status == 1 ? '' :
                                (date.status == 2 && selectedStatus == 2) ? 'bg-[#E5EAE3] rounded-l-full ml-1.5 pl-0' :
                                date.status == 3 ? 'bg-[#E5EAE3] rounded-r-full mr-1.5 pr-0' :
                                date.status == 4 ? 'bg-[#E5EAE3]' : 'bg-white'">
                                    <div class="flex justify-center items-center rounded-full w-[38px] h-[38px] z-10 relative" x-bind:class="
                                    date.status == 0 ? 'bg-[#DDDDDD] text-black' : 
                                    date.status == 1 ? 'bg-[#BED2B6] text-black' : 
                                    (date.status == 2 || date.status == 3) ? 'bg-[#00402F] text-white' : 
                                    date.status == 4 ? 'bg-[#E5EAE3] text-black' : 'bg-white text-[#DDDDDD]'" x-on:click="(date.status == 1 || date.status == 2 || date.status == 3) ? selectDate(date) : showAlert()">
                                        <p class="font-bold text-xs leading-[14px]" x-text="date.day"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
                <div class="mt-[15px] flex flex-col items-center w-full px-[13px]">
                    <div class="flex justify-center items-center px-2.5 py-[5px] bg-[#F5F5F5] rounded-[10px]">
                        <p class="font-bold text-xs leading-[14px] text-black">렌트 가격 할인 TIP!</p>
                    </div>
                    <p class="mt-2 font-bold text-[11px] leading-[13px] text-[#666666]">기간이 길어질수록 1일 렌트가가 내려갑니다.</p>
                    <div class="mt-[26px] flex flex-col w-full px-7 relative">
                        <div class="w-full px-[23px] mt-5">
                            <img class="min-w-full" src="images/rent_discount.png" alt="">
                        </div>
                        <div class="flex justify-between absolute left-0 w-full px-[19px]">
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666]"><?= $site_Data['INT_DISCOUNT1'] ? $site_Data['INT_DISCOUNT1'] . '% 할인' : '할인혜택 없음' ?></p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] mt-4"><?= $site_Data['INT_DISCOUNT2'] ? $site_Data['INT_DISCOUNT2'] . '% 할인' : '할인혜택 없음' ?></p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] mt-8"><?= $site_Data['INT_DISCOUNT3'] ? $site_Data['INT_DISCOUNT3'] . '% 할인' : '할인혜택 없음' ?></p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] mt-12"><?= $site_Data['INT_DISCOUNT4'] ? $site_Data['INT_DISCOUNT4'] . '% 할인' : '할인혜택 없음' ?></p>
                        </div>
                        <hr class="mt-5 border-t-[0.5px] border-[#E0E0E0] w-full" />
                        <div class="mt-2 flex justify-between w-full px-[7px]">
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART1'] ?>일~<?= $site_Data['INT_DEND1'] ?>일</p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART2'] ?>~<?= $site_Data['INT_DEND2'] ?>일</p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART3'] ?>일~<?= $site_Data['INT_DEND3'] ?></p>
                            <p class="font-bold text-[10px] leading-[11px] text-[#666666] text-center w-[50px]"><?= $site_Data['INT_DSTART4'] ?>일~<?= $site_Data['INT_DEND4'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
            <div class="flex gap-[7px] items-center justify-start flex-wrap px-[14px] py-[7px] w-full">
                <template x-if="startDate != null && endDate != null">
                    <div class="flex justify-center items-center gap-[1px] px-2 py-[3px] bg-[#666666] rounded-md">
                        <p class="font-bold text-[11px] leading-[12px] text-white" x-text="formatDate(startDate) + '~' + formatDate(endDate)">23.01.15</p>
                        <button class="flex justify-center items-center" x-on:click="initDate()">
                            <p class="font-bold text-sm leading-[14px] text-white">×</p>
                        </button>
                    </div>
                </template>
            </div>
            <div class="flex items-center gap-[5px] px-[14px] pb-[13px] w-full">
                <button class="flex justify-center items-center bg-white rounded-md w-32 h-[39px] border-[0.3px] border-solid border-[#E0E0E0]" x-on:click="initDate()">
                    <p class="font-bold text-xs leading-3 text-[#666666]">초기화</p>
                </button>
                <button class="grow flex justify-center items-center bg-black rounded-md h-[39px]" x-on:click="applyFilter()">
                    <p class="font-bold text-xs leading-3 text-white">적용</p>
                </button>
            </div>

            <div class="absolute bottom-16">
                <div x-show="showCalendarAlert" class="flex flex-col justify-center items-center gap-3 px-[50px] py-5 bg-black bg-opacity-80 border border-solid border-[#D9D9D9] rounded-[11px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0.00023987C17.713 0.00023987 21.2739 1.47517 23.8995 4.10066C26.5251 6.72616 28 10.2873 28 14.0001C28 17.7129 26.5251 21.274 23.8995 23.8996C21.274 26.5251 17.7129 28 14 28C10.2871 28 6.7261 26.5251 4.10046 23.8996C1.47494 21.2741 0 17.7129 0 14.0001C0.00398445 10.2883 1.48034 6.72988 4.1049 4.10486C6.7297 1.48033 10.288 0.00396002 14.0002 0L14 0.00023987ZM14 22.4002C14.3713 22.4002 14.7275 22.2527 14.99 21.99C15.2525 21.7275 15.3999 21.3715 15.3999 21.0002C15.3999 20.6288 15.2525 20.2727 14.99 20.0102C14.7275 19.7477 14.3713 19.6001 14 19.6001C13.6287 19.6001 13.2725 19.7477 13.01 20.0102C12.7475 20.2727 12.6001 20.6288 12.6001 21.0002C12.6001 21.3715 12.7475 21.7275 13.01 21.99C13.2725 22.2527 13.6287 22.4002 14 22.4002ZM12.6001 16.8002C12.6001 17.3004 12.8668 17.7626 13.2999 18.0126C13.733 18.2627 14.2669 18.2627 14.7001 18.0126C15.1332 17.7626 15.3999 17.3004 15.3999 16.8002V6.99976C15.3999 6.4996 15.1332 6.03741 14.7001 5.78733C14.267 5.53725 13.7331 5.53725 13.2999 5.78733C12.8668 6.03741 12.6001 6.4996 12.6001 6.99976V16.8002Z" fill="white" />
                    </svg>
                    <p class="font-medium text-[15px] leading-[17px] text-center text-white">
                        해당 날짜엔 이용이 불가합니다.<br>
                        다른 일을 선택해주세요.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showOption != 0" x-transition class="w-full h-full bg-black bg-opacity-60 fixed top-0 z-50 flex justify-center items-center max-w-[410px]" style="display: none;">
        <div x-data="{
            content: [
                {
                    searchKey: '',
                    list: []
                },
                {
                    searchKey: '',
                    list: [
                        <?php
                        $query =    "SELECT * 
                                        FROM " . $Tname . "comm_com_code 
                                    WHERE 
                                        str_service = 'Y' 
                                        AND int_gubun = 2";
                        $brand_list_result = mysql_query($query);
                        while ($row = mysql_fetch_assoc($brand_list_result)) {
                        ?>
                            {
                                value: <?= $row['INT_NUMBER'] ?>,
                                title: '<?= $row['STR_CODE'] ?>',
                                ktitle: '<?= $row['STR_KCODE'] ?>',
                                checked: false
                            },
                        <?php
                        }
                        ?>
                    ]
                },
                {
                    searchKey: '',
                    list: [
                        {
                            value: 'mini',
                            title: 'MINI',
                            ktitle: '미니',
                            checked: false
                        },
                        {
                            value: 'small',
                            title: 'SMALL',
                            ktitle: '스몰',
                            checked: false
                        },
                        {
                            value: 'medium',
                            title: 'MEDIUM',
                            ktitle: '미듐',
                            checked: false
                        },
                        {
                            value: 'large',
                            title: 'LARGE',
                            ktitle: '라지',
                            checked: false
                        },
                        {
                            value: 'clutch',
                            title: 'CLUTCH',
                            ktitle: '클러치',
                            checked: false
                        }
                    ]
                },
                {
                    searchKey: '',
                    list: [
                        {
                            value: 'tote',
                            title: 'TOTE BAG',
                            ktitle: '토트백',
                            checked: false
                        },
                        {
                            value: 'shoulder',
                            title: 'SHOULDER BAG',
                            ktitle: '숄더백',
                            checked: false
                        },
                        {
                            value: 'top',
                            title: 'TOP HANDLE BAG',
                            ktitle: '탑 핸들백',
                            checked: false
                        },
                        {
                            value: 'bucket',
                            title: 'BUCKET BAG',
                            ktitle: '버킷백',
                            checked: false
                        },
                        {
                            value: 'hobo',
                            title: 'HOBO BAG',
                            ktitle: '호보백',
                            checked: false
                        },
                    ]
                }
            ],
            selectItem(index) {
                this.content[showOption].list[index].checked = !this.content[showOption].list[index].checked;

                if (this.content[showOption].list[index].checked) {
                    switch (showOption) {
                        case 1:
                            window.filter_brands.push(this.content[showOption].list[index].value);
                            break;
                        case 2:
                            window.filter_sizes.push(this.content[showOption].list[index].value);
                            break;
                        case 3:
                            window.filter_styles.push(this.content[showOption].list[index].value);
                            break;
                    }
                } else {
                    switch (showOption) {
                        case 1:
                            window.filter_brands = window.filter_brands.filter(item => item !== this.content[showOption].list[index].value);
                            break;
                        case 2:
                            window.filter_sizes = window.filter_sizes.filter(item => item !== this.content[showOption].list[index].value);
                            break;
                        case 3:
                            window.filter_styles = window.filter_styles.filter(item => item !== this.content[showOption].list[index].value);
                            break;
                    }
                }
            },
            removeSelectedItem(index) {
                this.content[showOption].list[index].checked = false;
            },
            applyFilter() {
                showOption = 0;
                searchProduct();
            },
            initSelectedItem() {
                filter_brands = [];
                filter_sizes = [];
                filter_styles = [];
                for (var i = 1; i <= 3; i++) {
                    this.content[i].list.forEach(function(item) {
                        item.checked = false;
                    });
                }
            }
        }" class="flex flex-col items-center rounded-lg bg-white w-[80%]">
            <div class="flex flex-row pt-3 pb-2.5 px-[27px] justify-between items-center w-full">
                <div class="flex items-center gap-[13px]">
                    <p class="text-xs leading-[14px]" x-bind:class="showOption == 1 ? 'font-extrabold text-black' : 'font-bold text-[#6A696C]'" x-on:click="showOption = 1">브랜드</p>
                    <p class="text-xs leading-[14px]" x-bind:class="showOption == 2 ? 'font-extrabold text-black' : 'font-bold text-[#6A696C]'" x-on:click="showOption = 2">사이즈</p>
                    <p class="text-xs leading-[14px]" x-bind:class="showOption == 3 ? 'font-extrabold text-black' : 'font-bold text-[#6A696C]'" x-on:click="showOption = 3">스타일</p>
                </div>
                <button class="w-2.5 h-2.5" x-on:click="showOption = 0">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                    </svg>
                </button>
            </div>
            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
            <div class="flex flex-col px-[27px] py-[14px] w-full">
                <template x-if="showOption == 1">
                    <div class="relative w-full mb-[15px]">
                        <input type="text" class="w-full h-[38px] bg-[#F8F8F8] border border-solid border-[#E0E0E0] rounded-[4px] pl-3 pr-7 font-medium text-xs leading-[14px] placeholder:text-[#C4C4C4]" placeholder="브랜드 검색" x-model="content[showOption].searchKey">
                        <button type="button" class="absolute top-2.5 right-[10.5px]">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.2675 17.4201L12.6013 11.7539C13.6807 10.4566 14.2184 8.79307 14.1027 7.10939C13.987 5.42571 13.2268 3.85142 11.9801 2.71388C10.7334 1.57635 9.09628 0.963123 7.40908 1.00172C5.72187 1.04031 4.11446 1.72776 2.92111 2.92111C1.72776 4.11446 1.04031 5.72186 1.00172 7.40907C0.963123 9.09627 1.57636 10.7334 2.71389 11.9801C3.85143 13.2268 5.42571 13.987 7.10939 14.1027C8.79307 14.2184 10.4566 13.6807 11.7539 12.6013L17.4815 18.3289C17.5946 18.437 17.7457 18.4966 17.9022 18.4949C18.0587 18.4931 18.2084 18.4301 18.3191 18.3194C18.4298 18.2087 18.4928 18.0591 18.4945 17.9025C18.4963 17.746 18.4367 17.595 18.3285 17.4818L18.2675 17.4201ZM3.76748 11.3483C2.90084 10.4625 2.36777 9.30397 2.25891 8.06957C2.15005 6.83517 2.47212 5.60117 3.17038 4.57744C3.86863 3.5537 4.89994 2.80345 6.08891 2.45425C7.27788 2.10506 8.5511 2.1785 9.69204 2.66207C10.833 3.14565 11.7712 4.00951 12.3471 5.10673C12.923 6.20396 13.1011 7.46679 12.851 8.68049C12.601 9.89419 11.9382 10.9838 10.9755 11.764C10.0128 12.5442 8.80951 12.9669 7.57034 12.9601C6.86139 12.9562 6.16024 12.8117 5.50748 12.535C4.85473 12.2584 4.26331 11.855 3.76748 11.3483Z" fill="black" stroke="black" stroke-width="0.247219" stroke-miterlimit="10" />
                            </svg>
                        </button>
                    </div>
                </template>
                <div class="flex flex-col py-0.5 w-full h-[344px] overflow-y-auto">
                    <div class="flex flex-col gap-[15px] w-full">
                        <div class="flex flex-col w-full">
                            <div class="flex items-center px-1.5 pb-[7px] border-b-[0.5px] border-[#E0E0E0]">
                                <p class="font-extrabold text-xs leading-[14px] text-black" x-text="showOption == 2 ? '사이즈' : showOption == 3 ? '스타일' : ''">A - C</p>
                            </div>
                            <div class="mt-[9px] flex flex-col w-full gap-[11px] px-1.5">
                                <template x-for="(item, index) in content[showOption].list">
                                    <template x-if="item.title.toLowerCase().includes(content[showOption].searchKey.toLowerCase()) || item.ktitle.toLowerCase().includes(content[showOption].searchKey.toLowerCase())">
                                        <div class="flex gap-[9.4px] items-center w-full" x-on:click="selectItem(index);">
                                            <div class="w-4 h-4 rounded-full border-[0.4px] border-solid border-[#E0E0E0]" x-bind:class="item.checked ? 'bg-black' : 'bg-[#F8F8F8]'"></div>
                                            <div class="flex flex-col gap-[1.7px]">
                                                <p class="font-bold text-xs leading-[14px] text-black" x-text="item.title">ACNE STUDIOS</p>
                                                <p class="font-semibold text-[10px] leading-[11px] text-[#898989]" x-text="item.ktitle">아크네 스튜디오</p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-t-[0.5px] border-[#E0E0E0] w-full" />
            <div class="flex gap-[7px] items-center justify-start flex-wrap px-[14px] py-[7px] w-full">
                <template x-for="(contentItem, contentIndex) in content">
                    <template x-for="(item, index) in contentItem.list">
                        <template x-if="item.checked">
                            <div class="flex justify-center items-center gap-[1px] px-2 py-[3px] bg-[#666666] rounded-md">
                                <p class="font-bold text-xs leading-3 text-white" x-text="item.title">BALENCIA</p>
                                <button type="button" class="flex justify-center items-center" x-on:click="removeSelectedItem(index)">
                                    <p class="font-bold text-sm leading-[14px] text-white">×</p>
                                </button>
                            </div>
                        </template>
                    </template>
                </template>
            </div>
            <div class="flex items-center gap-[5px] px-[14px] pb-[13px] w-full">
                <button type="button" class="flex justify-center items-center bg-white rounded-md w-32 h-[39px] border-[0.3px] border-solid border-[#E0E0E0]" x-on:click="initSelectedItem()">
                    <p class="font-bold text-xs leading-3 text-[#666666]">초기화</p>
                </button>
                <button type="button" class="grow flex justify-center items-center bg-black rounded-md h-[39px]" x-on:click="applyFilter()">
                    <p class="font-bold text-xs leading-3 text-white">적용</p>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$show_footer_hbutton = true;
$show_footer_sbutton = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    current_page = 1;
    window.filter_discount = false;
    window.filter_subscription = false;
    window.filter_brands = [];
    window.filter_sizes = [];
    window.filter_styles = [];
    window.start_date = null;
    window.end_date = null;
    order_by = 'favorite';

    $(document).ready(function() {
        searchProduct();
    });

    function searchProduct(append = false) {
        var start_date_str = '';
        if (start_date) {
            start_date_str = start_date.getFullYear().toString() + '-' + (start_date.getMonth() + 1).toString().padStart(2, '0') + '-' + start_date.getDate().toString().padStart(2, '0');
        }
        var end_date_str = '';
        if (end_date) {
            end_date_str = end_date.getFullYear().toString() + '-' + (end_date.getMonth() + 1).toString().padStart(2, '0') + '-' + end_date.getDate().toString().padStart(2, '0');
        }

        url = "get_product_list.php";
        url += "?page=" + current_page;
        url += "&filter_discount=" + filter_discount;
        url += "&filter_subscription=" + filter_subscription;
        url += "&filter_brands=" + encodeURIComponent(JSON.stringify(filter_brands));
        url += "&filter_sizes=" + encodeURIComponent(JSON.stringify(filter_sizes));
        url += "&filter_styles=" + encodeURIComponent(JSON.stringify(filter_styles));
        url += "&start_date=" + start_date_str;
        url += "&end_date=" + end_date_str;
        url += "&order_by=" + order_by;
        url += "&product_type=" + <?= $product_type ?>;
        url += "&is_sub_membership=" + '<?= $is_sub_membership ?: '' ?>';

        $.ajax({
            url: url,
            success: function(result) {
                if (append) {
                    $("#product_list").append(result);
                } else {
                    $("#product_list").html(result);
                }
            }
        });
    }

    function seeMoreClick() {
        current_page++;

        searchProduct(true);
    }
</script>