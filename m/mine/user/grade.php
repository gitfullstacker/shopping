<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?
$SQL_QUERY =    " SELECT
					UR.*
				FROM "
    . $Tname . "comm_member AS UR
				WHERE
					UR.STR_USERID='$arr_Auth[0]' ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div x-data="{ grade: '<?= $arr_Data['STR_GRADE'] ?: 'G' ?>' }" class="flex flex-col w-full">
    <!-- 상단정보 -->
    <div class="flex flex-col gap-7 px-[14px] py-[21px] border-b border-[#E0E0E0]">
        <div class="flex gap-[15px]">
            <div class="flex justify-center items-center w-[60px] h-[60px] bg-[#D9D9D9] rounded-full">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 13C11.2125 13 9.68229 12.3635 8.40938 11.0906C7.13646 9.81771 6.5 8.2875 6.5 6.5C6.5 4.7125 7.13646 3.18229 8.40938 1.90938C9.68229 0.636459 11.2125 0 13 0C14.7875 0 16.3177 0.636459 17.5906 1.90938C18.8635 3.18229 19.5 4.7125 19.5 6.5C19.5 8.2875 18.8635 9.81771 17.5906 11.0906C16.3177 12.3635 14.7875 13 13 13ZM0 26V21.45C0 20.5292 0.23725 19.6825 0.71175 18.9101C1.18517 18.1388 1.81458 17.55 2.6 17.1438C4.27917 16.3042 5.98542 15.6742 7.71875 15.2539C9.45208 14.8346 11.2125 14.625 13 14.625C14.7875 14.625 16.5479 14.8346 18.2812 15.2539C20.0146 15.6742 21.7208 16.3042 23.4 17.1438C24.1854 17.55 24.8148 18.1388 25.2882 18.9101C25.7628 19.6825 26 20.5292 26 21.45V26H0Z" fill="white" />
                </svg>
            </div>
            <div class="grow flex flex-col gap-[5px] items-start justify-center">
                <p class="font-bold text-xs leading-[13px] text-black">
                    <span class="font-extrabold text-lg leading-5 text-black"><?= $arr_Data['STR_NAME'] ?></span> 님의 등급
                </p>
                <p class="font-bold text-xs leading-[14px] text-black"><?= $arr_Data['STR_GRADE'] == 'B' ? 'BLACK' : 'GREEN' ?></p>
                <p class="font-bold text-xs leading-[14px] text-black"><?= date('Y.m.d') . ' ~ ' . date('m.d', strtotime('+3 months')) ?></p>
            </div>
        </div>
        <div class="flex flex-col gap-[25px] w-full">
            <div class="grid grid-cols-2 w-full">
                <div class="pt-2.5 flex justify-center border-t-[5px]" x-bind:class="grade == 'G' ? 'border-[#666666]' : 'border-[#D9D9D9]'">
                    <p class="font-bold text-[9px] leading-[10px] text-center" x-bind:class="grade == 'G' ? 'text-[#333333]' : 'text-[#999999]'">GREEN</p>
                </div>
                <div class="pt-2.5 flex justify-center border-t-[5px]" x-bind:class="grade == 'B' ? 'border-[#666666]' : 'border-[#D9D9D9]'">
                    <p class="font-bold text-[9px] leading-[10px] text-center" x-bind:class="grade == 'B' ? 'text-[#333333]' : 'text-[#999999]'">BLACK</p>
                </div>
            </div>
            <?php
            if ($arr_Data['STR_GRADE'] == 'G') {
            ?>
                <div class="flex justify-between items-center">
                    <p class="font-medium text-xs leading-[14px] text-[#666666]">다음달 [블랙] 등급 승급까지 필요한 이용금액</p>
                    <p class="font-bold text-xs leading-[14px] text-[#666666]"><?= number_format(2000000 - $arr_Data['INT_SMONEY']) ?>원</p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="mt-[30px] flex flex-col w-full px-[14px]">
        <!-- 내가 받고 있는 혜택 -->
        <div class=" flex flex-col gap-[14px] w-full">
            <p class="font-extrabold text-lg leading-5 text-black">내가 받고 있는 혜택</p>
            <?php
            switch ($arr_Data['STR_GRADE']) {
                case 'G':
            ?>
                    <div class="grid grid-cols-2 gap-[5px] w-full">
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">5,000원 할인쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">신규 가입 쿠폰 1회 지급</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">생일 5,000원 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급</p>
                        </div>
                    </div>
                    <?php
                    break;
                    ?>
                    <div class="grid grid-cols-2 gap-[5px] w-full">
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">50,000원 VIP 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">VIP 등급 달성 축하 쿠폰 지급</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">생일 50,000원 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급 / 결제액과  무관하게 사용 가능 </p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">적립금 5% 혜택</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">등급 달성 후 모든 결제에 적용</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">빈티지 전용 10% 할인쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급 / 빈티지 카테고리 상품만 적용가능</p>
                        </div>
                    </div>
            <?php
                case 'B':

                    break;
            }
            ?>

        </div>

        <!-- 등급별 혜택 안내 -->
        <div x-data="{ gradeType: grade }" class="mt-[30px] flex flex-col w-full">
            <p class="font-extrabold text-lg leading-5 text-black">등급별 혜택 안내</p>
            <div class="mt-[14px] grid grid-cols-2 w-full">
                <div class="flex flex-col justify-center items-center gap-[5px] h-[90px] bg-white border border-solid" x-bind:class="gradeType == 'G' ? 'border-black' : 'border-[#E0E0E0]'" x-on:click="gradeType = 'G'">
                    <div class="flex justify-center items-center w-[38px] h-[38px] bg-[#BED2B6] border border-solid border-[#D9D9D9] rounded-full">
                        <p class="font-extrabold text-[12.6667px] leading-[14px] text-center text-black">G</p>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-center text-black">GREEN</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-[5px] h-[90px] bg-white border border-solid" x-bind:class="gradeType == 'B' ? 'border-black' : 'border-[#E0E0E0]'" x-on:click="gradeType = 'B'">
                    <div class="flex justify-center items-center w-[38px] h-[38px] bg-black border border-solid border-[#D9D9D9] rounded-full">
                        <p class="font-extrabold text-[12.6667px] leading-[14px] text-center text-white">B</p>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-center text-black">BLACK</p>
                </div>
            </div>

            <!-- 구분 -->
            <hr class="mt-[15px] border-t-[0.5px] border-[#E0E0E0]" />

            <template x-if="gradeType == 'G'">
                <!-- GREEN -->
                <div class="mt-[15px] flex flex-col w-full">
                    <p class="font-extrabold text-lg leading-5 text-black">GREEN</p>
                    <p class="mt-[9px] font-bold text-xs leading-[140%] text-[#666666]">충족 조건 없음</p>

                    <!-- 구분 -->
                    <hr class="mt-[13px] border-t-[0.5px] border-[#E0E0E0]" />

                    <div class="mt-[15px] grid grid-cols-2 gap-[5px] w-full">
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">5,000원 할인쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">신규 가입 쿠폰 1회 지급</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">생일 5,000원 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급</p>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="gradeType == 'B'">
                <!-- BLACK -->
                <div class="mt-[15px] flex flex-col w-full">
                    <p class="font-extrabold text-lg leading-5 text-black">BLACK</p>
                    <p class="mt-[9px] font-bold text-xs leading-[140%] text-[#666666]">누적 결제액 200만원 이상 (1년)</p>

                    <!-- 구분 -->
                    <hr class="mt-[13px] border-t-[0.5px] border-[#E0E0E0]" />

                    <div class="mt-[15px] grid grid-cols-2 gap-[5px] w-full">
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">50,000원 VIP 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">VIP 등급 달성 축하 쿠폰 지급</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">생일 50,000원 쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급 / 결제액과  무관하게 사용 가능 </p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">적립금 5% 혜택</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">등급 달성 후 모든 결제에 적용</p>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-[5px] h-[50px] bg-white border border-solid border-[#DDDDDD]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">빈티지 전용 10% 할인쿠폰</p>
                            <p class="font-medium text-[10px] leading-3 text-center text-[#999999]">연 1회 지급 / 빈티지 카테고리 상품만 적용가능</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- 회원등급정책 -->
        <div class=" mt-[23px] flex flex-col gap-1.5 px-[9px] py-[15px] bg-[#F5F5F5]">
            <p class="font-bold text-xs leading-[14px] text-black">회원등급정책</p>
            <p class="font-normal text-[10px] leading-4 text-[#999999]">
                -자사몰 구매금액/구매횟수 모두 충족시 등급이 조정됩니다.<br />
                -등급은 1월/7월 변경되며 최근 12개월간 실결제 구매금액 합산 기준으로 선정 됩니다.<br />
                -등급 산정시 자사몰 배송완료 기준으로 산정됩니다.<br />
                -구매금액(실결제금액)은 적립금/쿠폰/예치금/반품/등급할인 등을 제외한 배송 완료 기준입니다.<br />
                -산정 기간 내 반품/취소/교환 시 등급이 하락할 수 있습니다.<br />
                -부당한 방법으로 획득한 고객등급은 재조정 될 수 있습니다.<br />
                -등급 조건과 혜택은 운영 정책에 따라 공지 후 변경될 수 있습니다.<br />
            </p>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>