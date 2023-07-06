<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], 2);

//구독멤버십정보얻기
$SQL_QUERY =    'SELECT 
                    A.*
                FROM 
                    `' . $Tname . 'comm_membership` A
                WHERE 
                    A.STR_USERID = "' . $arr_Auth[0] . '"
					AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
					AND A.INT_TYPE = 1
                    AND A.STR_PASS = "0"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$subscription_Data = mysql_fetch_assoc($arr_Rlt_Data);

//렌트멤버십정보얻기
$SQL_QUERY =    'SELECT 
                    A.*
                FROM 
                    `' . $Tname . 'comm_membership` A
                WHERE 
                    A.STR_USERID = "' . $arr_Auth[0] . '"
                    AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
                    AND A.INT_TYPE = 2
                    AND A.STR_PASS = "0"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$rent_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 금액정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_site_info AS A
                WHERE
                    A.INT_NUMBER=1';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 사용자정보 얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_member AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$user_Data = mysql_fetch_assoc($arr_Rlt_Data);

//카드정보얻기
$SQL_QUERY =    "SELECT 
                    A.STR_BILLCODE, A.INT_NUMBER
                FROM 
                    `" . $Tname . "comm_member_pay` AS A
                WHERE
                    A.STR_PASS='0' 
                    AND A.STR_USERID='$arr_Auth[0]'
                ORDER BY DTM_INDATE
                LIMIT 1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$card_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <div x-data="{ type: <?= $int_type == 2 ? '1' : '2' ?> }" class="flex flex-col items-center w-full">
        <p class="font-extrabold text-lg leading-5 text-black">멤버십 관리</p>
        <div class="mt-[14px] flex flex-row gap-10">
            <?php
            $sub_menu_color = $subscription_Data['STR_CANCEL'] == '0' ? '#EDA02F' : '#6A696C';
            $ren_menu_color = $rent_Data['STR_CANCEL'] == '0' ? '#00402F' : '#6A696C';
            ?>
            <div class="flex pb-[3px] px-[3px] border-solid border-[<?= $ren_menu_color ?>]" x-bind:class="type == 1 ? 'border-b' : 'border-none'" x-on:click="type = 1">
                <p class="font-bold text-sm leading-4" x-bind:class="type == 1 ? 'text-[<?= $ren_menu_color ?>]' : 'text-[#999999]'">블랑 렌트 멤버십</p>
            </div>
            <div class="flex pb-[3px] px-[3px] border-solid border-[<?= $sub_menu_color ?>]" x-bind:class="type == 2 ? 'border-b' : 'border-none'" x-on:click="type = 2">
                <p class="font-bold text-sm leading-4" x-bind:class="type == 2 ? 'text-[<?= $sub_menu_color ?>]' : 'text-[#999999]'">구독 멤버십</p>
            </div>
        </div>
        <div x-show="type == 1" class="mt-[15px] flex flex-col items-center w-full">
            <?php
            if ($rent_Data) {
                // 가입자인 경우
                if ($rent_Data['STR_CANCEL'] == '0') {
            ?>
                    <!-- 장기 이용 -->
                    <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#BCDDB1] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#BCDDB1" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-black">BLANC RENT CARD</p>
                        <p class="mt-2 font-medium text-xs leading-[14px] text-center text-black">
                            블랑 렌트 멤버십 기간: <span class="font-bold underline"><?= date('Y.m.d', strtotime($rent_Data['DTM_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($rent_Data['DTM_EDATE'])) ?></span><br>
                            *다음달 <span class="font-bold underline"><?= date('d', strtotime($rent_Data['DTM_EDATE'] . '+1 days')) ?>일</span>에 자동 결제됩니다.
                        </p>
                    </div>
                    <a href="/m/mine/membership/cancel.php?int_type=2" class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">블랑 렌트 멤버십 해지</p>
                    </a>
                    <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                        <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 해지 안내</p>
                        <p class="font-normal text-[10px] leading-4 text-[#999999]">
                            -블랑 렌트 멤버십에 가입할 경우 에이블랑의 RENT 전용 상품들을<br>
                            30% 할인된 가격에 이용할 수 있습니다.<br>
                            -멤버십을 해지할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                            종료일 이후 자동결제가 이루어지지 않습니다.<br>
                            -멤버십 해지 이후 재가입을 원하실 경우 [멤버십 관리] 페이지를 이용해주세요.<br>
                        </p>
                    </div>
                <?php
                } else {
                ?>
                    <!-- 해지 신청됨 -->
                    <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-[#666666]">BLANC RENT CARD</p>
                        <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">
                            블랑 렌트 멤버십 기간: <span class="font-bold underline"><?= date('Y.m.d', strtotime($rent_Data['DTM_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($rent_Data['DTM_EDATE'])) ?></span><br>
                            *멤버십 해지신청 완료되었으며<br>
                            기간 종료 후 자동결제가 이루어지지 않습니다.<br>
                        </p>
                    </div>
                    <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white" onclick="showRestoreConfirm(2)">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">해지 신청 취소</p>
                    </button>
                    <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                        <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 안내</p>
                        <p class="font-normal text-[10px] leading-4 text-[#999999]">
                            -블랑 렌트 멤버십에 가입할 경우 에이블랑의 RENT 전용 상품들을<br>
                            30% 할인된 가격에 이용할 수 있습니다.<br>
                            -멤버십 기간은 1개월이며 자동 결제 수단으로 등록된 카드로 자동 연장 결제됩니다.<br>
                            -멤버십 기간 내 해지를 신청할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                            종료일 이후 자동결제가 이루어지지 않습니다.<br>
                            -구독권 정기 결제는 무이자 및 할부 혜택 적용이 불가합니다.<br>
                            -카드 등록이 안될 시 해당 카드사에 문의 부탁드립니다.<br>
                        </p>
                    </div>
                <?php
                }
            } else {
                ?>
                <!-- 미가입자인 경우 -->
                <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-[#666666]">BLANC RENT CARD</p>
                    <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">
                        블랑 렌트 멤버십 미가입자입니다.<br>
                        멤버십 가입 후 할인 된 가격으로 렌트해보세요!
                    </p>
                </div>
                <a href="pay.php?int_type=2" class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">멤버십 가입하러 가기</p>
                </a>
                <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-xs leading-[14px] text-black">블랑 렌트 멤버십 안내</p>
                    <p class="font-normal text-[10px] leading-4 text-[#999999]">
                        -블랑 렌트 멤버십에 가입할 경우 에이블랑의 RENT 전용 상품들을<br>
                        30% 할인된 가격에 이용할 수 있습니다.<br>
                        -멤버십 기간은 1개월이며 자동 결제 수단으로 등록된 카드로 자동 연장 결제됩니다.<br>
                        -멤버십 기간 내 해지를 신청할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                        종료일 이후 자동결제가 이루어지지 않습니다.<br>
                        -구독권 정기 결제는 무이자 및 할부 혜택 적용이 불가합니다.<br>
                        -카드 등록이 안될 시 해당 카드사에 문의 부탁드립니다.<br>
                    </p>
                </div>
            <?php
            }
            ?>

        </div>
        <div x-show="type == 2" class="mt-[15px] flex flex-col items-center w-full" style="display: none;">
            <?php
            if ($subscription_Data) {
                // 가입자인 경우
                if ($subscription_Data['STR_CANCEL'] == '0') {
                    $end_date = $subscription_Data['DTM_EDATE']; // Replace with your actual end date

                    $sub_datetime1 = new DateTime();
                    $sub_datetime2 = new DateTime($end_date);
                    $sub_interval = $sub_datetime1->diff($sub_datetime2);

                    $sub_days_left = $sub_interval->format('%d');
            ?>
                    <!-- 장기 이용 -->
                    <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F1D58E] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F1D58E" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-black">MEMBERSHIP CARD</p>
                        <p class="mt-2 font-medium text-xs leading-[14px] text-center text-black">
                            구독 멤버십 잔여일이 <span class="font-bold underline"><?= $sub_days_left ?>일</span> 남았습니다.<br>
                            *다음달 <span class="font-bold underline"><?= date('d', strtotime($subscription_Data['DTM_EDATE'] . '+1 days')) ?>일</span>에 자동 결제됩니다.
                        </p>
                    </div>
                    <a href="/m/mine/membership/cancel.php?int_type=1" class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">구독 멤버십 해지</p>
                    </a>
                    <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                        <p class="font-bold text-xs leading-[14px] text-black">구독 멤버십 해지 안내</p>
                        <p class="font-normal text-[10px] leading-4 text-[#999999]">
                            -구독 멤버십에 가입할 경우 에이블랑 구독 전용 상품들을 월 89,000원으로<br>
                            교환 횟수 제한 없이 이용할 수 있습니다.<br>
                            -멤버십을 해지할 경우 기간 종료일까지는 현재 이용중인 상품의 이용이 가능하며<br>
                            종료일 이후 자동결제가 이루어지지 않습니다.<br>
                            -구독 멤버십을 해지할 경우 멤버십 종료일에 맞추어 이용중인 상품의<br>
                            반납신청을 별도로 해주셔야 합니다.<br>
                            -멤버십 해지 이후 재가입을 원하실 경우 [멤버십 관리] 페이지를 이용해주세요.<br>
                        </p>
                    </div>
                <?php
                } else {
                ?>
                    <!-- 해지 신청됨 -->
                    <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-[#666666]">MEMBERSHIP CARD</p>
                        <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">
                            구독 멤버십 기간: <span class="font-bold underline"><?= date('Y.m.d', strtotime($subscription_Data['DTM_SDATE'])) ?> ~ <?= date('Y.m.d', strtotime($subscription_Data['DTM_EDATE'])) ?></span><br>
                            *멤버십 해지신청 완료되었으며<br>
                            기간 종료 후 자동결제가 이루어지지 않습니다.<br>
                        </p>
                    </div>
                    <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white" onclick="showRestoreConfirm(1)">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">해지 신청 취소</p>
                    </button>
                    <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                        <p class="font-bold text-xs leading-[14px] text-black">구독 멤버십 안내</p>
                        <p class="font-normal text-[10px] leading-4 text-[#999999]">
                            -구독 멤버십에 가입할 경우 에이블랑 구독 전용 상품들을 월 89,000원으로<br>
                            교환 횟수 제한 없이 이용할 수 있습니다.<br>
                            -멤버십 기간은 1개월이며 자동 결제 수단으로 등록된 카드로 자동 연장 결제됩니다.<br>
                            -멤버십 기간 내 해지를 신청할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                            종료일 이후 자동결제가 이루어지지 않습니다.<br>
                            (홈>마이페이지>에이블랑 결제관리 페이지 참조)<br>
                            -구독권 정기 결제는 무이자 및 할부 혜택 적용이 불가합니다.<br>
                            -카드 등록이 안될 시 해당 카드사에 문의 부탁드립니다.<br>
                        </p>
                    </div>
                <?php
                }
            } else {
                ?>
                <!-- 미가입자인 경우 -->
                <div class="w-[280px] h-[165px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#D9D9D9" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-sm leading-4 text-center text-[#666666]">MEMBERSHIP CARD</p>
                    <p class="mt-2 font-medium text-xs leading-[14px] text-center text-[#666666]">
                        구독 멤버십 미가입자입니다.<br>
                        멤버십 가입 후 다양한 가방을 구독해보세요!
                    </p>
                </div>
                <a href="pay.php?int_type=1" type="button" class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">멤버십 가입하러 가기</p>
                </a>
                <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-xs leading-[14px] text-black">구독 멤버십 안내</p>
                    <p class="font-normal text-[10px] leading-4 text-[#999999]">
                        -구독 멤버십에 가입할 경우 에이블랑 구독 전용 상품들을 월 89,000원으로<br>
                        교환 횟수 제한 없이 이용할 수 있습니다.<br>
                        -멤버십 기간은 1개월이며 자동 결제 수단으로 등록된 카드로 자동 연장 결제됩니다.<br>
                        -멤버십 기간 내 해지를 신청할 경우 기간 종료일까지는 멤버십 혜택이 적용되며,<br>
                        종료일 이후 자동결제가 이루어지지 않습니다.<br>
                        (홈>마이페이지>에이블랑 결제관리 페이지 참조)<br>
                        -구독권 정기 결제는 무이자 및 할부 혜택 적용이 불가합니다.<br>
                        -카드 등록이 안될 시 해당 카드사에 문의 부탁드립니다.<br>
                    </p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div id="confirm_dialog" class="w-full bg-black bg-opacity-60 fixed bottom-[66px] z-50 flex justify-center items-start max-w-[410px] hidden" style="height: calc(100vh - 66px);">
    <div class="mt-[60%] flex flex-col items-center justify-center rounded-lg bg-white w-[80%] relative px-4 py-[35px]">
        <button class="absolute top-[15px] right-[21px]" onclick="document.getElementById('confirm_dialog').classList.add('hidden');">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
            </svg>
        </button>
        <p class="font-bold text-xs leading-[18px] text-[#666666] text-center">
            해지 신청을 취소하실 경우 기존 멤버십이<br>
            유지되며 다음 결제일에 자동 연장 결제됩니다.<br>
            해지 신청을 취소하시겠습니까?<br>
        </p>
        <div class="mt-[11px] flex justify-center gap-[5px]">
            <button class="flex justify-center items-center gap-[4.69px] w-[90px] h-[30px] bg-white border-[0.84px] border-solid border-[#D9D9D9]" onclick="document.getElementById('confirm_dialog').classList.add('hidden');">
                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.05856 9.0481L0.128288 4.95636C0.0816375 4.90765 0.0486715 4.85488 0.0293895 4.79805C0.0097964 4.74122 0 4.68033 0 4.61538C0 4.55044 0.0097964 4.48955 0.0293895 4.43272C0.0486715 4.37589 0.0816375 4.32312 0.128288 4.27441L4.05856 0.170489C4.16741 0.0568296 4.30347 0 4.46675 0C4.63002 0 4.76998 0.060889 4.8866 0.182667C5.00323 0.304445 5.06154 0.446519 5.06154 0.60889C5.06154 0.77126 5.00323 0.913335 4.8866 1.03511L1.45782 4.61538L4.8866 8.19566C4.99545 8.30932 5.04988 8.44928 5.04988 8.61555C5.04988 8.78214 4.99156 8.92632 4.87494 9.0481C4.75831 9.16988 4.62225 9.23077 4.46675 9.23077C4.31125 9.23077 4.17519 9.16988 4.05856 9.0481Z" fill="#666666" />
                </svg>
                <p class="font-bold text-[10px] leading-[11px] text-[#666666]">돌아가기</p>
            </button>
            <button class="flex justify-center items-center w-[90px] h-[30px] bg-black border-[0.84px] border-solid border-[#D9D9D9]" onclick="restoreMembership();">
                <p class="font-bold text-[10px] leading-[11px] text-white">해지 신청 취소</p>
            </button>
        </div>
    </div>
</div>

<?php
// 주문번호 생성
$today = new DateTime();
$year = $today->format('Y');
$month = $today->format('m');
$date = $today->format('d');
$time = $today->getTimestamp();

if (intval($month) < 10) {
    $month = $month;
}

if (intval($date) < 10) {
    $date = $date;
}

$order_idxx = $year . "" . $month . "" . $date . "" . $time;
?>

<form name="join_membership" action="sub_process.php" method="post">
    <input type="hidden" name="ordr_idxx" value="<?= $order_idxx ?>">
    <input type="hidden" name="good_name" value="">
    <input type="hidden" name="good_mny" value="0">
    <input type="hidden" name="buyr_name" value="<?= $user_Data['STR_NAME'] ?>">
    <input type="hidden" name="buyr_mail" value="<?= $user_Data['STR_EMAIL'] ?>">
    <input type="hidden" name="buyr_tel1" value="<?= $user_Data['STR_TELEP'] ?>">
    <input type="hidden" name="buyr_tel2" value="<?= $user_Data['STR_HP'] ?>">
    <input type="hidden" name="bt_batch_key" value="<?= $card_Data['STR_BILLCODE'] ?>">
    <input type="hidden" name="quotaopt" value="00">
</form>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>

<script>
    var restore_int_type;

    function showRestoreConfirm(int_type) {
        restore_int_type = int_type;
        document.getElementById('confirm_dialog').classList.remove('hidden');
    }

    function restoreMembership() {
        url = "membership_proc.php";
        url += "?RetrieveFlag=RESTORE";
        url += "&int_type=" + restore_int_type;
        url += "&int_number=<?= $card_Data['INT_NUMBER'] ?>";

        $.ajax({
            url: url,
            success: function(result) {
                window.location.href = 'index.php?int_type=' + restore_int_type;
            }
        });
    }

    function joinMembership(int_type) {
        if (<?= $card_Data ? 'true' : 'false' ?>) {
            switch (int_type) {
                case 1:
                    document.forms.join_membership.good_name.value = '구독멤버십';
                    document.forms.join_membership.good_mny.value = <?= $site_Data['INT_PRICE1'] ?: 0 ?>;
                    break;
                case 2:
                    document.forms.join_membership.good_name.value = '렌트멥버십';
                    document.forms.join_membership.good_mny.value = <?= $site_Data['INT_PRICE2'] ?: 0 ?>;
                    break;
            }
            document.forms.join_membership.int_type.value = int_type;
            document.forms.join_membership.submit();
        } else {
            window.location.href = '/m/mine/payment/index.php';
        }
    }
</script>