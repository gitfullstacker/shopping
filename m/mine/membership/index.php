<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?php
//구독멤버십정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_membership AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_TYPE=1
                    AND CURDATE() BETWEEN A.DTM_SDATE AND A.DTM_EDATE';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$subscription_Data = mysql_fetch_assoc($arr_Rlt_Data);

//렌트멤버십정보얻기
$SQL_QUERY =    'SELECT
                    A.*
                FROM 
                    ' . $Tname . 'comm_membership AS A
                WHERE
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_TYPE=2
                    AND CURDATE() BETWEEN A.DTM_SDATE AND A.DTM_EDATE';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$rent_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="mt-[30px] flex flex-col items-center w-full px-[14px]">
    <div x-data="{ type: 1 }" class="flex flex-col items-center w-full">
        <p class="font-extrabold text-lg leading-5 text-black">멤버십 관리</p>
        <div class="mt-[14px] flex flex-row gap-10">
            <div class="flex pb-[3px] border-solid border-[#6A696C]" x-bind:class="type == 1 ? 'border-b' : 'border-none'" x-on:click="type = 1">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">블랑 렌트 멤버십</p>
            </div>
            <div class="flex pb-[3px] border-solid border-[#6A696C]" x-bind:class="type == 2 ? 'border-b' : 'border-none'" x-on:click="type = 2">
                <p class="font-bold text-xs leading-[14px] text-[#999999]">구독 멤버십</p>
            </div>
        </div>
        <div x-show="type == 1" class="mt-[15px] flex flex-col items-center w-full">
            <?php
            if ($rent_Data) {
            ?>
                <!-- 가입자인 경우 -->
                <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#BCDDB1] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#BCDDB1" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-black">BLANC RENT CARD</p>
                    <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-black">
                        블랑 렌트 멤버십 혜택이 렌트시 적용됩니다.<br>
                        다음 달 01일에 자동 결제됩니다.
                    </p>
                </div>
                <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">렌트 멤버십 중단</p>
                </button>
                <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-[10px] leading-[140%] text-black">블랑 렌트 멤버십 중단 안내</p>
                    <p class="font-bold text-[10px] leading-[140%] text-[#999999]">
                        -구독권 연장은 자동 결제 수단으로 등록된 카드로 자동 결제됩니다.<br>
                        (홈 > 마이페이지 > 에이블랑 결제관리 페이지 참조)<br>
                        -구독권 취소 관련 조항은 아래 문단 확인 부탁드립니다.<br>
                        -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
                        -카드 등록이 안될 시 각 카드사에 문의 부탁드립니다.
                    </p>
                </div>
            <?php
            } else {
            ?>
                <!-- 미가입자인 경우 -->
                <div class="flex flex-col items-center w-full">
                    <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F5F5F5" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-black">MEMBERSHIP CARD</p>
                        <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-black">
                            프리미엄 멤버십 미가입자입니다.<br>
                            멤버십 가입 후 다양한 가방을 구독해보세요!
                        </p>
                    </div>
                    <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">멤버십 가입하러 가기</p>
                    </button>
                </div>
            <?php
            }
            ?>

        </div>
        <div x-show="type == 2" class="mt-[15px] flex flex-col items-center w-full" style="display: none;">
            <?php
            if ($subscription_Data) {
            ?>
                <!-- 가입자인 경우 -->
                <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#F1D58E] border border-solid border-[#DDDDDD] rounded-[10px]">
                    <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F1D58E" />
                        </svg>
                    </div>
                    <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-black">MEMBERSHIP CARD</p>
                    <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-black">
                        구독권 기간: 2023. 01. 01 ~ 2023. 01. 31<br>
                        프리미엄 구독권 잔여일이 30일 남았습니다.
                    </p>
                </div>
                <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">구독권 연장 신청</p>
                </button>
                <button class="mt-[5px] w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">구독권 취소</p>
                </button>
                <div class="mt-[15px] flex flex-col gap-[7px] w-full bg-[#F5F5F5] px-[9px] py-[15px]">
                    <p class="font-bold text-[10px] leading-[140%] text-black">구독권 연장/취소 안내</p>
                    <p class="font-bold text-[10px] leading-[140%] text-[#999999]">
                        -구독권 연장은 자동 결제 수단으로 등록된 카드로 자동 결제됩니다.<br>
                        (홈 > 마이페이지 > 에이블랑 결제관리 페이지 참조)<br>
                        -구독권 취소 관련 조항은 아래 문단 확인 부탁드립니다.<br>
                        -구독권 정기 결제는 무이자 및 할부 혜택을 받을 수 없습니다.<br>
                        -카드 등록이 안될 시 각 카드사에 문의 부탁드립니다.
                    </p>
                </div>
            <?php
            } else {
            ?>
                <!-- 미가입자인 경우 -->
                <div class="flex flex-col items-center w-full">
                    <div class="w-[210px] h-[140px] flex flex-col justify-center items-center bg-[#F5F5F5] border border-solid border-[#DDDDDD] rounded-[10px]">
                        <div class="w-[42px] h-[42px] flex justify-center items-center bg-white border border-solid border-[#DDDDDD] rounded-full">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12L0 1L5.5 6L9 0L12.5 6L18 1L16 12H2ZM16 15C16 15.6 15.6 16 15 16H3C2.4 16 2 15.6 2 15V14H16V15Z" fill="#F5F5F5" />
                            </svg>
                        </div>
                        <p class="mt-[15px] font-extrabold text-[11px] leading-3 text-center text-black">MEMBERSHIP CARD</p>
                        <p class="mt-2 font-bold text-[8px] leading-[10px] text-center text-black">
                            프리미엄 멤버십 미가입자입니다.<br>
                            멤버십 가입 후 다양한 가방을 구독해보세요!
                        </p>
                    </div>
                    <button class="mt-8 w-full h-[45px] flex justify-center items-center border-[0.72px] border-solid border-[#DDDDDD] bg-white">
                        <p class="font-bold text-xs leading-[14px] text-[#666666]">멤버십 가입하러 가기</p>
                    </button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>



<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>