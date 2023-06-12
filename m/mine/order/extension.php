<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_number = Fnc_Om_Conv_Default($_REQUEST['int_number'], '');

$SQL_QUERY =    'SELECT
                    A.*, B.INT_TYPE, B.STR_GOODNAME, B.INT_PRICE AS PRODUCT_PRICE, B.INT_DISCOUNT, C.STR_CODE, D.STR_NAME AS USER_NAME
                FROM 
                    ' . $Tname . 'comm_goods_cart A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master B
                ON
                    A.STR_GOODCODE=B.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code C
                ON
                    B.INT_BRAND=C.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_member D
                ON
                    A.STR_USERID=D.STR_USERID
                WHERE 
                    A.INT_NUMBER=' . $int_number;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <p class="font-extrabold text-lg leading-5 text-black">기간 연장</p>

    <div class="mt-[14px] flex flex-col w-full">
        <!-- 주문상품 -->
        <div class="mt-3 flex flex-row gap-[11px] w-full px-[14px]">
            <div class="w-[120px] h-[120px] flex justify-center items-center p-2 bg-[#F9F9F9]">
                <img class="w-full" src="images/mockup/product.png" alt="">
            </div>
            <div class="flex-1 flex flex-col justify-center w-full">
                <div class="flex justify-center items-center w-[34px] h-[18px] bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A')) ?>]">
                    <p class="font-normal text-[10px] leading-[11px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지')) ?></p>
                </div>
                <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black"><?= $arr_Data['STR_CODE'] ?></p>
                <p class="mt-0.5 font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?></p>
                <?php
                if ($arr_Data['INT_TYPE'] != 3) {
                ?>
                    <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: <?= date('Y.m.d', strtotime($arr_Data['STR_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($arr_Data['STR_EDATE'])) ?></p>
                <?php
                }
                ?>
                <p class="mt-[3px] font-bold text-xs leading-[14px] text-black"><?= number_format($arr_Data['PRODUCT_PRICE']) ?>원</p>
            </div>
        </div>

        <!-- 구분 -->
        <hr class="mt-[23px] border-t-[0.5px] border-[#E0E0E0] w-full" />

        <!-- 반납일 선택 -->
        <div class="mt-[14px] flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">반납일 선택</p>
            <div class="flex flex-row item-center w-full">
                <input type="text" class="flex-1 px-[15px] w-full h-[45px] border-[0.72px] border-solid border-[#DDDDDD] bg-white font-normal text-xs leading-[14px] placeholder-[#999999] text-black" placeholder="반납일을 선택해주세요">
                <button class="w-[45px] h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD]">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 2H15V1C15 0.734784 14.8946 0.48043 14.7071 0.292893C14.5196 0.105357 14.2652 0 14 0C13.7348 0 13.4804 0.105357 13.2929 0.292893C13.1054 0.48043 13 0.734784 13 1V2H7V1C7 0.734784 6.89464 0.48043 6.70711 0.292893C6.51957 0.105357 6.26522 0 6 0C5.73478 0 5.48043 0.105357 5.29289 0.292893C5.10536 0.48043 5 0.734784 5 1V2H3C2.20435 2 1.44129 2.31607 0.87868 2.87868C0.316071 3.44129 0 4.20435 0 5V17C0 17.7956 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H17C17.7956 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7956 20 17V5C20 4.20435 19.6839 3.44129 19.1213 2.87868C18.5587 2.31607 17.7956 2 17 2ZM18 17C18 17.2652 17.8946 17.5196 17.7071 17.7071C17.5196 17.8946 17.2652 18 17 18H3C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V10H18V17ZM18 8H2V5C2 4.73478 2.10536 4.48043 2.29289 4.29289C2.48043 4.10536 2.73478 4 3 4H5V5C5 5.26522 5.10536 5.51957 5.29289 5.70711C5.48043 5.89464 5.73478 6 6 6C6.26522 6 6.51957 5.89464 6.70711 5.70711C6.89464 5.51957 7 5.26522 7 5V4H13V5C13 5.26522 13.1054 5.51957 13.2929 5.70711C13.4804 5.89464 13.7348 6 14 6C14.2652 6 14.5196 5.89464 14.7071 5.70711C14.8946 5.51957 15 5.26522 15 5V4H17C17.2652 4 17.5196 4.10536 17.7071 4.29289C17.8946 4.48043 18 4.73478 18 5V8Z" fill="#949494" />
                    </svg>
                </button>
            </div>

            <div x-data="{
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
                            day: day,
                            status: status   // Disable: 0, Enable: 1, Picked Start: 2, Picked End: 3, Period: 4, Hide: 5, Export: 6, Collect: 7
                        });
                    }

                    this.dates = dates;
                    this.currentYear = year;
                    this.currentMonth = month;
                    this.firstDayOfWeek = firstDayOfWeek;
                },
                selectDate(day, month, year) {
                    if (this.selectedStatus == 0) {
                        this.startDate = new Date(year, month - 1, day);
                        this.exportDate = new Date(year, month - 1, day);
                        this.exportDate.setDate(this.exportDate.getDate() - 2);
                        this.selectedStatus++;
                    } else if (this.selectedStatus == 1) {
                        if (year == this.startDate.getFullYear() && (month - 1) == this.startDate.getMonth() && day == this.startDate.getDate()) {
                            // 시작날짜를 눌렀을때 시작해제
                            this.selectedStatus = 0;
                            this.startDate = null;
                            this.exportDate = null;
                        } else {
                            this.endDate = new Date(year, month - 1, day);
                            this.collectDate = new Date(year, month - 1, day);
                            this.collectDate.setDate(this.collectDate.getDate() + 1);
                            this.selectedStatus++;
                        }
                    } else if (this.selectedStatus == 2) {
                        if (year == this.endDate.getFullYear() && (month - 1) == this.endDate.getMonth() && day == this.endDate.getDate()) {
                            // 마감날짜를 눌렀을때 마감해제
                            this.selectedStatus = 1;
                            this.endDate = null;
                            this.collectDate = null;
                        }
                    }

                    this.generateDates(month, year);
                },
                formatDate(date) {
                    const year = date.getFullYear().toString().slice(-2);
                    const month = (date.getMonth() + 1).toString().padStart(2, '0');
                    const day = date.getDate().toString().padStart(2, '0');
                    
                    return `${year}.${month}.${day}`;
                },
                applyFilter() {
                    showCalendar = false;
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
                },
                showAlert() {
                    this.showCalendarAlert = true;
                    setTimeout(() => this.showCalendarAlert = false, 2000);
                },
                init() {
                    today = new Date();
                    this.generateDates(today.getMonth() + 1, today.getFullYear());
                }
            }" class="mt-[14px] flex flex-col w-full border-[0.72px] border-solid border-[#DDDDDD] bg-white relative">
                <div class="w-3 h-3 border-l-[0.72px] border-t-[0.72px] border-[#DDDDDD] rotate-45 bg-white absolute -top-[7px] right-[15px]"></div>
                <div class="flex flex-col items-center rounded-lg bg-white w-full relative">
                    <div class="flex flex-col items-center justify-center px-7 pt-[26.6px] pb-7">
                        <div class="flex gap-[13px] items-center">
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
                                        <div class="flex justify-center items-center rounded-full w-[38px] h-[38px] z-5 relative" x-bind:class="
                                    date.status == 0 ? 'bg-[#DDDDDD] text-black' : 
                                    date.status == 1 ? 'bg-[#BED2B6] text-black' : 
                                    (date.status == 2 || date.status == 3) ? 'bg-[#00402F] text-white' : 
                                    date.status == 4 ? 'bg-[#E5EAE3] text-black' : 'bg-white text-[#DDDDDD]'" x-on:click="(date.status == 1 || date.status == 2 || date.status == 3) ? selectDate(date.day, currentMonth, currentYear) : showAlert()">
                                            <p class="font-bold text-xs leading-[14px]" x-text="date.day"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-16 z-10">
                        <div x-show="showCalendarAlert" class="flex flex-col justify-center items-center gap-3 px-[50px] py-5 bg-black bg-opacity-90 border border-solid border-[#D9D9D9] rounded-[11px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 0.00023987C17.713 0.00023987 21.2739 1.47517 23.8995 4.10066C26.5251 6.72616 28 10.2873 28 14.0001C28 17.7129 26.5251 21.274 23.8995 23.8996C21.274 26.5251 17.7129 28 14 28C10.2871 28 6.7261 26.5251 4.10046 23.8996C1.47494 21.2741 0 17.7129 0 14.0001C0.00398445 10.2883 1.48034 6.72988 4.1049 4.10486C6.7297 1.48033 10.288 0.00396002 14.0002 0L14 0.00023987ZM14 22.4002C14.3713 22.4002 14.7275 22.2527 14.99 21.99C15.2525 21.7275 15.3999 21.3715 15.3999 21.0002C15.3999 20.6288 15.2525 20.2727 14.99 20.0102C14.7275 19.7477 14.3713 19.6001 14 19.6001C13.6287 19.6001 13.2725 19.7477 13.01 20.0102C12.7475 20.2727 12.6001 20.6288 12.6001 21.0002C12.6001 21.3715 12.7475 21.7275 13.01 21.99C13.2725 22.2527 13.6287 22.4002 14 22.4002ZM12.6001 16.8002C12.6001 17.3004 12.8668 17.7626 13.2999 18.0126C13.733 18.2627 14.2669 18.2627 14.7001 18.0126C15.1332 17.7626 15.3999 17.3004 15.3999 16.8002V6.99976C15.3999 6.4996 15.1332 6.03741 14.7001 5.78733C14.267 5.53725 13.7331 5.53725 13.2999 5.78733C12.8668 6.03741 12.6001 6.4996 12.6001 6.99976V16.8002Z" fill="white" />
                            </svg>
                            <p class="font-medium text-[15px] leading-[17px] text-center text-white">
                                해당 날짜엔 이용 시작이 불가합니다.<br>
                                다른 시작일을 선택해주세요.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-[15px] flex flex-col gap-[7px] w-full px-[9px] py-[15px] bg-[#F5F5F5]">
                <p class="font-bold text-[10px] leading-[14px] text-black">기간 연장 안내</p>
                <p class="font-bold text-[10px] leading-4 text-[#999999]">
                    -구독권 연장은 자동 결제 수단으로 등록된 카드로 자동 결제됩니다.<br>
                    (홈 > 마이페이지 > 에이블랑 결제관리 페이지 참조)<br>
                    -구독권 취소 관련 조항은 아래 문단 확인 부탁드립니다.<br>
                    -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
                    -카드 등록이 안될 시 각 카드사에 문의 부탁드립니다.
                </p>
            </div>

            <!-- 구분 -->
            <hr class="mt-[25px] border-t-[0.5px] border-[#E0E0E0] w-full" />

            <div class="mt-[15px] flex flex-col gap-[15px]">
                <div class="flex flex-row gap-5">
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">이용날짜</p>
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">2023. 02. 10 ~ 2023. 02. 16 <span class="text-black">(3일 연장)</span></p>
                </div>
                <div class="flex flex-col gap-[7px] items-center py-[15px] bg-[#F5F5F5]">
                    <p class="font-bold text-[10px] leading-[14px] text-black">등록하신 카드로 자동 결제됩니다.</p>
                    <p class="font-normal text-[10px] leading-[16px] text-[#999999]">삼성카드 **** **** **** 1234</p>
                </div>
            </div>

            <div class="mt-8 flex flex-row gap-[5px] w-full">
                <button class="w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">취소</p>
                </button>
                <button class="w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-black">
                    <p class="font-bold text-xs leading-[14px] text-white">결제</p>
                </button>
            </div>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>