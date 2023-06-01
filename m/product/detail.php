<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/detail.css" rel="stylesheet" type="text/css" id="cssLink" />

<?php
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], '');

$SQL_QUERY = 'UPDATE ' . $Tname . 'comm_goods_master SET INT_VIEW=INT_VIEW + 1 WHERE STR_GOODCODE=' . $str_goodcode;
mysql_query($SQL_QUERY);

if ($arr_Auth[0]) {

    $SQL_QUERY = 'SELECT COUNT(A.INT_NUMBER) AS COUNT FROM ' . $Tname . 'comm_member_seen A WHERE A.STR_USERID="' . $arr_Auth[0] . '" AND A.STR_GOODCODE="' . $str_goodcode . '"';
    $arr_Rlt_Data = mysql_query($SQL_QUERY);

    if ($arr_Rlt_Data) {
        $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

        if ($arr_Data['COUNT'] > 0) {
            $SQL_QUERY = 'UPDATE ' . $Tname . 'comm_member_seen SET DTM_INDATE="' . date("Y-m-d H:i:s") . '" WHERE STR_USERID="' . $arr_Auth[0] . '" AND STR_GOODCODE="' . $str_goodcode . '"';
            mysql_query($SQL_QUERY);
        } else {
            $SQL_QUERY = 'INSERT INTO ' . $Tname . 'comm_member_seen (STR_GOODCODE, STR_USERID, DTM_INDATE) VALUES ("' . $str_goodcode . '", "' . $arr_Auth[0] . '", "' . date("Y-m-d H:i:s") . '")';
            mysql_query($SQL_QUERY);
        }
    }
}

$SQL_QUERY =    'SELECT
                    A.*, B.STR_CODE AS STR_BRAND, (SELECT COUNT(C.STR_GOODCODE) FROM ' . $Tname . 'comm_member_like AS C WHERE A.STR_GOODCODE=C.STR_GOODCODE AND C.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_LIKE, (SELECT COUNT(D.STR_GOODCODE) FROM ' . $Tname . 'comm_member_basket AS D WHERE A.STR_GOODCODE=D.STR_GOODCODE AND D.STR_USERID="' . ($arr_Auth[0] ?: 'NULL') . '") AS IS_BASKET
                FROM 
                    ' . $Tname . 'comm_goods_master AS A
                LEFT JOIN
                    ' . $Tname . 'comm_com_code AS B
                ON
                    A.INT_BRAND=B.INT_NUMBER
                WHERE
                    A.STR_GOODCODE="' . $str_goodcode . '"';

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<!-- 렌트 제품_상세_관련 상품 리뷰 -->
<div class="flex flex-col w-full">
    <!-- 슬라이더 -->
    <div x-data="{
        imageCount: 3,
        slider: 1,
        handleScroll() {
            const containerWidth = this.$refs.sliderContainer.offsetWidth;
            const scrollPosition = this.$refs.sliderContainer.scrollLeft;
            const slider = Math.round(scrollPosition / containerWidth) + 1;

            this.slider = slider;
        },
        init() {
            this.imageCount = this.$refs.sliderContainer.children.length;
        }
    }" class="flex w-full relative">
        <div class="flex overflow-x-auto snap-x snap-mandatory custom-scrollbar" x-ref="sliderContainer" x-on:scroll="handleScroll">
            <?php
            for ($i = 1; $i <= 2; $i++) {
                if ($arr_Data['STR_IMAGE' . $i]) {
            ?>
                    <div class="snap-always snap-center w-screen h-[500px] bg-gray-100">
                        <img class="w-screen" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE' . $i] ?>" onerror="this.style.display='none'" alt="">
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="absolute w-full flex justify-center px-[77px] bottom-[14.45px]">
            <div class="flex w-full bg-[#C6C6C6] h-[1.55px]">
                <div class="h-[1.55px] bg-black" x-bind:class="slider == imageCount ? 'w-full' : 'w-[' + slider/imageCount * 100 + '%]'"></div>
            </div>
        </div>
    </div>

    <!-- 제품정보 -->
    <div class="flex flex-col w-full mt-[30px] px-[14px]">
        <div class="flex justify-between">
            <!-- 타그 -->
            <div class="flex justify-center items-center px-1.5 py-1 bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                <p class="font-normal text-[10px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
            </div>
            <!-- Like -->
            <div onclick="setProductLike('<?= $arr_Data['STR_GOODCODE'] ?>')">
                <svg id="is_like_no" style="<?= $arr_Data['IS_LIKE'] > 0 ? 'display:none;' : '' ?>" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                </svg>
                <svg id="is_like_yes" style="<?= $arr_Data['IS_LIKE'] > 0 ? '' : 'display:none;' ?>" width="20" height="19" viewBox="0 0 20 19" fill="#FF0000" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.78561 16.7712L8.78511 16.7707C6.20323 14.4295 4.0883 12.5088 2.61474 10.706C1.14504 8.90792 0.35 7.26994 0.35 5.5C0.35 2.60372 2.61288 0.35 5.5 0.35C7.13419 0.35 8.70844 1.11256 9.73441 2.30795L10 2.6174L10.2656 2.30795C11.2916 1.11256 12.8658 0.35 14.5 0.35C17.3871 0.35 19.65 2.60372 19.65 5.5C19.65 7.26994 18.855 8.90792 17.3853 10.706C15.9117 12.5088 13.7968 14.4295 11.2149 16.7707L11.2144 16.7712L10 17.8767L8.78561 16.7712Z" stroke="#666666" stroke-width="0.7" />
                </svg>
            </div>
        </div>
        <p class="mt-[9px] font-extrabold text-xs text-[#666666]"><?= $arr_Data['STR_BRAND'] ?></p>
        <p class="mt-[5px] font-extrabold text-lg text-[#333333]"><?= $arr_Data['STR_GOODNAME'] ?></p>
        <?php
        switch ($arr_Data['INT_TYPE']) {
            case 1:
        ?>
                <p class="mt-[15px] font-bold text-xs text-[#666666]">월정액 구독 전용</p>
                <div class="mt-[7px] flex gap-2 items-center">
                    <p class="font-extrabold text-lg text-[#333333]"><span class="text-[#EEAC4C]">월</span> <?= number_format($arr_Data['INT_PRICE']) ?>원</p>
                </div>
            <?php
                break;

            case 2:
            ?>
                <p class="mt-[15px] font-bold text-xs line-through text-[#666666]"><?= $arr_Data['INT_DISCOUNT'] ? ('일 ' . number_format($arr_Data['INT_PRICE']) . '원') : '' ?></p>
                <div class="mt-[7px] flex gap-2 items-center">
                    <p class="font-extrabold text-lg text-[#00402F]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_DISCOUNT']) . '%') : '' ?></p>
                    <p class="font-extrabold text-lg text-[#333333]">일 <?= $arr_Data['INT_DISCOUNT'] ? number_format($arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) : number_format($arr_Data['INT_PRICE']) ?>원</p>
                    <p class="font-bold text-xs text-[#666666]">멤버십 혜택가</p>
                </div>
            <?php
                break;
            case 3:
            ?>
                <p class="mt-[15px] font-bold text-xs line-through text-[#666666]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_PRICE']) . '원') : '' ?></p>
                <div class="mt-[7px] flex gap-2 items-center">
                    <p class="font-extrabold text-lg text-[#7E6B5A]"><?= $arr_Data['INT_DISCOUNT'] ? (number_format($arr_Data['INT_DISCOUNT']) . '%') : '' ?></p>
                    <p class="font-extrabold text-lg text-[#333333]"><?= $arr_Data['INT_DISCOUNT'] ? number_format($arr_Data['INT_PRICE'] * $arr_Data['INT_DISCOUNT'] / 100) : number_format($arr_Data['INT_PRICE']) ?>원</p>
                    <p class="font-bold text-xs text-[#666666]">최대 할인적용가</p>
                </div>
        <?php
                break;
        }
        ?>
    </div>

    <?php
    if ($arr_Data['INT_TYPE'] == 1) {
    ?>
        <!-- 프리미엄 멤버십 (정기결제) -->
        <div class="flex px-[14px] mt-4 w-full">
            <div class="flex flex-col gap-2.5 w-full border-[0.72px] border-solid border-[#DDDDDD] bg-[#FFF3E1] p-[14px]">
                <div x-data="{ checked: false }" class="flex flex-row gap-1.5 items-center" x-on:click="checked = !checked">
                    <div class="flex w-4 h-4">
                        <svg x-show="!checked" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.36" y="0.36" width="15.28" height="15.28" fill="white" stroke="#DDDDDD" stroke-width="0.72" />
                        </svg>
                        <svg x-show="checked" class="w-4 h-4" style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.75556 11.7333L13.0222 5.46667L11.7778 4.22222L6.75556 9.24444L4.22222 6.71111L2.97778 7.95556L6.75556 11.7333ZM0 16V0H16V16H0Z" fill="black" />
                        </svg>
                    </div>
                    <p class="font-extrabold text-[15px] leading-[17px] text-black">프리미엄 멤버십 <span class="font-bold text-xs leading-[13px] text-[#666666]">(정기결제)</span></p>
                </div>
                <button type="button" class="flex justify-center items-center w-full h-10 bg-[#EEAC4C]">
                    <p class="font-bold text-sm leading-4 text-white">정기구독 월 89,000원</p>
                </button>
            </div>
        </div>
    <?php
    }
    ?>


    <!-- 구분선 -->
    <hr class="mt-7 w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

    <?php
    if ($arr_Data['INT_TYPE'] == 3) {
    ?>
        <!-- 할인정보 -->
        <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
            <button class="flex flex-col gap-[3px] justify-center items-center w-full h-[49px] bg-[#7E6B5A] border border-solid border-[#DDDDDD]">
                <span class="flex gap-[1px] items-center">
                    <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.3 0C0.955218 0 0.624558 0.144866 0.380761 0.402728C0.136964 0.660591 0 1.01033 0 1.375V4.125C0.344781 4.125 0.675442 4.26987 0.919239 4.52773C1.16304 4.78559 1.3 5.13533 1.3 5.5C1.3 5.86467 1.16304 6.21441 0.919239 6.47227C0.675442 6.73013 0.344781 6.875 0 6.875V9.625C0 9.98967 0.136964 10.3394 0.380761 10.5973C0.624558 10.8551 0.955218 11 1.3 11H11.7C12.0448 11 12.3754 10.8551 12.6192 10.5973C12.863 10.3394 13 9.98967 13 9.625V6.875C12.6552 6.875 12.3246 6.73013 12.0808 6.47227C11.837 6.21441 11.7 5.86467 11.7 5.5C11.7 5.13533 11.837 4.78559 12.0808 4.52773C12.3246 4.26987 12.6552 4.125 13 4.125V1.375C13 1.01033 12.863 0.660591 12.6192 0.402728C12.3754 0.144866 12.0448 0 11.7 0H1.3ZM8.775 2.0625L9.75 3.09375L4.225 8.9375L3.25 7.90625L8.775 2.0625ZM4.4265 2.09C5.0635 2.09 5.577 2.63313 5.577 3.30688C5.577 3.62961 5.45579 3.93913 5.24003 4.16734C5.02427 4.39554 4.73163 4.52375 4.4265 4.52375C3.7895 4.52375 3.276 3.98063 3.276 3.30688C3.276 2.98414 3.39721 2.67462 3.61297 2.44641C3.82873 2.21821 4.12137 2.09 4.4265 2.09ZM8.5735 6.47625C9.2105 6.47625 9.724 7.01937 9.724 7.69312C9.724 8.01586 9.60279 8.32538 9.38703 8.55359C9.17127 8.78179 8.87863 8.91 8.5735 8.91C7.9365 8.91 7.423 8.36687 7.423 7.69312C7.423 7.37039 7.54421 7.06087 7.75997 6.83266C7.97573 6.60446 8.26837 6.47625 8.5735 6.47625Z" fill="white" />
                    </svg>
                    <span class="font-bold text-[11px] leading-[12px] text-center text-white">기간 한정 추가 할인 쿠폰</span>
                </span>
                <span class="font-bold text-[8px] leading-[9px] text-center text-white">(2023. 02. 30 23:59까지)</span>
            </button>
            <div class="w-full flex flex-col gap-[9px]">
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">상품등급</p>
                    <p class="font-bold text-xs text-[#666666]">UNUSED(하단 상세참조)</p>
                </div>
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">예상적립</p>
                    <p class="font-bold text-xs text-[#666666]">최대 13,000원 적립(실 결제금액에 한함)</p>
                </div>
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">카드혜택</p>
                    <p class="font-bold text-xs text-[#666666]">무이자 할부(최대 12개월)</p>
                </div>
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">배송정보</p>
                    <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-xs text-[#666666]">국내배송(무료배송)</p>
                        <p class="font-bold text-xs text-[#666666]">도서산간 지역 배송비 별도 추가</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 구분선 -->
        <hr class="mt-[15px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

        <!-- 에이블랑 명품감정 -->
        <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
            <img class="w-full" src="images/discount_vintage.png" alt="">
        </div>
    <?php
    } else {
    ?>
        <!-- 할인정보 -->
        <div class="mt-[15px] px-[14px] flex flex-col gap-[15px]">
            <img class="w-full" src="images/discount.png" alt="">
            <div class="w-full flex flex-col gap-[9px]">
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">렌트기간</p>
                    <p class="font-bold text-xs text-[#666666]">최소 3일 ~ 최대 12일</p>
                </div>
                <div class="flex gap-5">
                    <p class="font-bold text-xs text-[#999999]">배송정보</p>
                    <p class="font-bold text-xs text-[#666666]">국내배송(무료배송)</p>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- 구분선 -->
    <hr class="mt-[15px] w-full border-t-[0.5px] border-solid border-[#E0E0E0]" />

    <!-- 최근상태 -->
    <div class="mt-[15px] px-[14px] flex flex-col gap-[13px] w-full">
        <p class="font-extrabold text-sm text-[#666666]">최근 상태를 확인해주세요.</p>
        <div class="flex flex-row gap-[5px] overflow-x-auto scrollbar-hide">
            <?php
            for ($i = 3; $i <= 9; $i++) {
                if ($arr_Data['STR_IMAGE' . $i]) {
            ?>
                    <div class="flex-none flex-grow-0 w-[130px] h-[130px] border border-solid border-[#DDDDDD] bg-gray-100">
                        <img class="w-full h-full object-cover" src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE' . $i] ?>" onerror="this.style.display='none'" alt="">
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- 메뉴 -->
    <div x-data="{ menu: 1 }" class="mt-[15px] flex justify-around bg-white border-t-[0.5px] border-b-[0.5px] border-solid border-[#E0E0E0]">
        <div class="flex justify-center items-center px-[12px] py-2.5" x-bind:class="menu == 1 ? ' text-black border-b border-black' : 'text-[#999999]'" x-on:click="menu = 1">
            <p class="font-bold text-xs text-center" x-on:click="menu = 1">상품정보</p>
        </div>
        <div class="flex justify-center items-center px-[12px] py-2.5" x-bind:class="menu == 2 ? ' text-black border-b border-black' : 'text-[#999999]'" x-on:click="menu = 2">
            <p class="font-bold text-xs text-center">상세후기</p>
        </div>
        <div class="flex justify-center items-center px-[12px] py-2.5" x-bind:class="menu == 3 ? ' text-black border-b border-black' : 'text-[#999999]'" x-on:click="menu = 3">
            <p class="font-bold text-xs text-center">이용안내</p>
        </div>
        <div class="flex justify-center items-center px-[12px] py-2.5" x-bind:class="menu == 4 ? ' text-black border-b border-black' : 'text-[#999999]'" x-on:click="menu = 4">
            <p class="font-bold text-xs text-center">관련상품</p>
        </div>
    </div>

    <!-- 상품정보 -->
    <div class="mt-7 px-[14px] flex flex-col">
        <div class="flex flex-col gap-[15px] px-3 pt-[15px] pb-[19px] bg-[#F5F5F5]">
            <?php
            if ($arr_Data['INT_TYPE'] == 3) {
            ?>
                <!-- 상품등급 -->
                <div class="flex flex-col w-full">
                    <p class="font-extrabold text-xs leading-[14px] text-black">상품등급</p>
                </div>
                <div x-data="{ grade: <?= $arr_Data['INT_GRADE'] ?> }" class="flex flex-col w-full">
                    <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 1 ? 'border-black' : 'border-[#D9D9D9]'">
                        <div x-show="grade == 1" class="absolute top-0 left-0" style="display: none;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                            </svg>
                        </div>
                        <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">PRESERVED</p>
                        </div>
                        <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 1 ? 'border-black' : 'border-[#D9D9D9]'">
                            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">깨끗하게 보존된 새 상품</p>
                        </div>
                    </div>
                    <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 2 ? 'border-black' : 'border-[#D9D9D9]'">
                        <div x-show="grade == 2" class="absolute top-0 left-0" style="display: none;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                            </svg>
                        </div>
                        <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">S CLASS</p>
                        </div>
                        <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 2 ? 'border-black' : 'border-[#D9D9D9]'">
                            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">새 상품과 비슷한 수준의 깨끗한 상품</p>
                        </div>
                    </div>
                    <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 3 ? 'border-black' : 'border-[#D9D9D9]'">
                        <div x-show="grade == 3" class="absolute top-0 left-0" style="display: none;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                            </svg>
                        </div>
                        <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">A CLASS</p>
                        </div>
                        <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 3 ? 'border-black' : 'border-[#D9D9D9]'">
                            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">대체적으로 깨끗한 상품</p>
                        </div>
                    </div>
                    <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 4 ? 'border-black' : 'border-[#D9D9D9]'">
                        <div x-show="grade == 4" class="absolute top-0 left-0" style="display: none;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                            </svg>
                        </div>
                        <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">B CLASS</p>
                        </div>
                        <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 4 ? 'border-black' : 'border-[#D9D9D9]'">
                            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">약한 스크래치·탈색·오염이 있는 상품</p>
                        </div>
                    </div>
                    <div class="relative flex w-full h-8 border border-solid" x-bind:class="grade == 5 ? 'border-black' : 'border-[#D9D9D9]'">
                        <div x-show="grade == 5" class="absolute top-0 left-0" style="display: none;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.22222 7.33333L8.13889 3.41667L7.36111 2.63889L4.22222 5.77778L2.63889 4.19444L1.86111 4.97222L4.22222 7.33333ZM0 10V0H10V10H0Z" fill="black" />
                            </svg>
                        </div>
                        <div class="w-[91px] flex justify-center items-center bg-[#F9F9F9]">
                            <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">C CLASS</p>
                        </div>
                        <div class="grow flex justify-center items-center bg-white border-l" x-bind:class="grade == 5 ? 'border-black' : 'border-[#D9D9D9]'">
                            <p class="font-bold text-[10px] leading-[11px] text-center text-[#666666]">눈에 띄는 스크래치·탈색·오염이 있는 상품</p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <!-- 상품코드 -->
            <div class="flex flex-col gap-1.5">
                <p class="font-extrabold text-xs text-black">상품코드</p>
                <p class="font-bold text-xs text-[#666666]"><?= $arr_Data['STR_BRAND'] ?></p>
            </div>
            <!-- 기본정보 -->
            <div class="flex flex-col gap-1.5">
                <p class="font-extrabold text-xs text-black">기본정보</p>
                <div class="flex flex-row">
                    <div class="w-[55px]">
                        <p class="font-bold text-xs text-[#666666]">소재</p>
                    </div>
                    <p class="font-bold text-xs text-[#666666]"><?= $arr_Data['STR_MATERIAL'] ?></p>
                </div>
                <div class="flex flex-row">
                    <div class="w-[55px]">
                        <p class="font-bold text-xs text-[#666666]">색상</p>
                    </div>
                    <div class="flex flex-row gap-[3px]">
                        <div class="w-3 h-3 bg-<?= $arr_Data['STR_COLOR'] ?>"></div>
                        <p class="font-bold text-xs text-[#666666]"><?= $arr_Data['STR_COLOR'] ?></p>
                    </div>
                </div>
                <div class="flex flex-row">
                    <div class="w-[55px]">
                        <p class="font-bold text-xs text-[#666666]">원산지</p>
                    </div>
                    <p class="font-bold text-xs text-[#666666]"><?= $arr_Data['STR_ORIGIN'] ?></p>
                </div>
            </div>
            <!-- 사이즈정보 -->
            <div class="flex flex-col">
                <p class="mt-1.5 font-extrabold text-xs text-black">사이즈정보</p>
                <div class="mt-1.5 flex flex-col gap-7 justify-center items-center w-full pt-7 pb-[20px] bg-white">
                    <img class="w-[222px] h-[252px]" src="images/product_size.png" alt="size" />
                    <p class="font-bold text-[10px] text-center text-[#999999]">*측정 위치 및 방법에 따라 1~3cm 정도 오차가 생길 수 있습니다.</p>
                </div>

                <div class="mt-2.5 flex flex-col gap-1.5">
                    <?php
                    $dimensions = preg_split('/\s*X\s*/', str_replace('cm', '', $arr_Data['STR_SIZE']));
                    ?>
                    <div class="flex items-center">
                        <div class="w-[65px]">
                            <p class="font-bold text-xs text-[#666666]">A 가로</p>
                        </div>
                        <p class="font-bold text-xs text-[#666666]"><?= $dimensions[0] ?> cm</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-[65px]">
                            <p class="font-bold text-xs text-[#666666]">B 폭</p>
                        </div>
                        <p class="font-bold text-xs text-[#666666]"><?= $dimensions[1] ?> cm</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-[65px]">
                            <p class="font-bold text-xs text-[#666666]">C 높이</p>
                        </div>
                        <p class="font-bold text-xs text-[#666666]"><?= $dimensions[2] ?> cm</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-[65px]">
                            <p class="font-bold text-xs text-[#666666]">D 스트랩</p>
                        </div>
                        <p class="font-bold text-xs text-[#666666]"><?= str_replace('cm', '', $arr_Data['STR_LENGTH']) ?> cm</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- 상품이미지 -->
        <div class="mt-7 flex flex-col w-full">
            <?php
            if ($arr_Data['STR_TIMAGE']) {
            ?>
                <img class="w-full" src="/admincenter/files/good/<?= $arr_Data['STR_TIMAGE'] ?>" alt="related">
            <?php
            }
            ?>
        </div>
        <!-- 더보기 버튼 -->
        <button class="flex justify-center items-center gap-[3px] h-[39px] rounded-[5px] border-[0.72222px] border-solid border-[#DDDDDD] bg-white">
            <span class="font-bold text-[11px] text-black">더보기</span>
            <div class="flex items-center">
                <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.8219 0.990783L4.83245 4.87327C4.78496 4.91935 4.73351 4.95192 4.6781 4.97097C4.62269 4.99032 4.56332 5 4.5 5C4.43668 5 4.37731 4.99032 4.3219 4.97097C4.26649 4.95192 4.21504 4.91935 4.16755 4.87327L0.166227 0.990784C0.0554087 0.883257 -2.07043e-07 0.748848 -2.14898e-07 0.587558C-2.22753e-07 0.426268 0.0593665 0.288019 0.1781 0.172812C0.296834 0.0576043 0.435356 4.59757e-07 0.593667 4.53547e-07C0.751979 4.47336e-07 0.890501 0.0576043 1.00923 0.172811L4.5 3.55991L7.99076 0.172811C8.10158 0.0652844 8.23805 0.011521 8.40016 0.011521C8.56259 0.011521 8.70317 0.0691244 8.8219 0.184332C8.94063 0.299539 9 0.433948 9 0.587557C9 0.741167 8.94063 0.875576 8.8219 0.990783Z" fill="#333333" />
                </svg>
            </div>
        </button>
    </div>

    <!-- 구분선 -->
    <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

    <!-- 리뷰혜택 이미지 -->
    <div class="mt-[15px] flex w-full px-[14px]">
        <img src="images/review.png" alt="">
    </div>

    <!-- 리뷰 -->
    <div x-data="{ menu: 1 }" class="mt-[25px] flex flex-col px-[14px]">
        <!-- 메뉴 -->
        <div class="flex gap-10 justify-center">
            <div class="px-[9px] pb-[3px] flex justify-center" x-bind:class="menu == 1 ? 'border-b border-b-[#6A696C] text-[#6A696C]' : 'text-[#999999]'" x-on:click="menu = 1">
                <p class="font-bold text-[11.9166px] text-center">해당 상품 리뷰</p>
            </div>
            <div class="px-[9px] pb-[3px] flex justify-center" x-bind:class="menu == 2 ? 'border-b border-b-[#6A696C] text-[#6A696C]' : 'text-[#999999]'" x-on:click="menu = 2">
                <p class="font-bold text-[11.9166px] text-center">관련 상품 리뷰</p>
            </div>
        </div>
        <!-- 해당 상품 리뷰목록 -->
        <div x-show="menu == 1" id="own_review_list" class="mt-[27px] flex flex-col gap-7 w-full">
        </div>
        <!-- 관련 상품 리뷰목록 -->
        <div x-show="menu == 2" id="related_review_list" class="mt-[27px] flex flex-col gap-7 w-full">
        </div>
    </div>

    <!-- 구분선 -->
    <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

    <!-- 이용 안내 -->
    <div x-data="{ collapse: false }" class="mt-5 flex flex-col gap-[15px] px-[14px]">
        <div class="flex items-center justify-between">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">이용 안내</p>
            <span x-on:click="collapse = !collapse">
                <svg x-show="collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                </svg>
                <svg x-show="!collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.742365 6.41475L7.18998 0.202768C7.26673 0.129028 7.34988 0.0769254 7.43943 0.0464487C7.52898 0.0154817 7.62493 0 7.72727 0C7.82962 0 7.92556 0.0154817 8.01511 0.0464487C8.10466 0.0769254 8.18782 0.129028 8.26457 0.20276L14.7314 6.41475C14.9105 6.58679 15 6.80184 15 7.05991C15 7.31797 14.9041 7.53917 14.7122 7.7235C14.5203 7.90783 14.2964 8 14.0405 8C13.7847 8 13.5608 7.90783 13.3689 7.7235L7.72727 2.30415L2.08556 7.7235C1.9065 7.89555 1.686 7.98157 1.424 7.98157C1.16154 7.98157 0.934344 7.88941 0.742445 7.70507C0.550552 7.52074 0.454545 7.30569 0.454545 7.05991C0.454545 6.81413 0.550552 6.59908 0.742365 6.41475Z" fill="#333333" />
                </svg>
            </span>
        </div>
        <div x-show="!collapse" class="flex flex-col gap-[9px] p-3 bg-[#F5F5F5]">
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -렌트잇 이용내역과 상품에 따라, 주문 후 별도의 보증금과 고객님의 개인정보를 요청드릴 수 있습니다.
            </p>
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -예약일 전에 상품이 도착한 경우, 해당 기간 만큼 무료로 더 사용 가능합니다.
            </p>
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -반납일로부터 3일(주말/공휴일 제외) 이내 미반납 시 연체료가 발생합니다.
            </p>
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -[렌트내역] > [상세보기] > [렌트 상품 사용감 확인] 페이지에서 보이는 상품 사진과 수령 직후 상품 상태가 다른 경우, 사용 전 에이블랑 고객센터로 알려주시길 바랍니다.
            </p>
        </div>
    </div>

    <!-- 배송 및 교환 -->
    <div x-data="{ collapse: false }" class="mt-5 flex flex-col gap-[15px] px-[14px]">
        <div class="flex items-center justify-between">
            <p class="font-extrabold text-lg leading-5 text-[#333333]">배송 및 교환</p>
            <span x-on:click="collapse = !collapse">
                <svg x-show="collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2576 1.58525L7.81002 7.79723C7.73327 7.87097 7.65012 7.92307 7.56057 7.95355C7.47102 7.98452 7.37507 8 7.27273 8C7.17038 8 7.07444 7.98452 6.98489 7.95355C6.89534 7.92307 6.81218 7.87097 6.73543 7.79724L0.268649 1.58525C0.0895495 1.41321 -2.97318e-07 1.19816 -3.08598e-07 0.940092C-3.19879e-07 0.682027 0.0959459 0.46083 0.287838 0.276498C0.479731 0.0921659 0.703606 -3.07556e-08 0.959462 -4.19394e-08C1.21532 -5.31233e-08 1.43919 0.0921659 1.63109 0.276498L7.27273 5.69585L12.9144 0.276497C13.0935 0.104454 13.314 0.0184325 13.576 0.0184325C13.8385 0.0184325 14.0657 0.110598 14.2576 0.29493C14.4495 0.479262 14.5455 0.694316 14.5455 0.940091C14.5455 1.18587 14.4495 1.40092 14.2576 1.58525Z" fill="#333333" />
                </svg>
                <svg x-show="!collapse" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.742365 6.41475L7.18998 0.202768C7.26673 0.129028 7.34988 0.0769254 7.43943 0.0464487C7.52898 0.0154817 7.62493 0 7.72727 0C7.82962 0 7.92556 0.0154817 8.01511 0.0464487C8.10466 0.0769254 8.18782 0.129028 8.26457 0.20276L14.7314 6.41475C14.9105 6.58679 15 6.80184 15 7.05991C15 7.31797 14.9041 7.53917 14.7122 7.7235C14.5203 7.90783 14.2964 8 14.0405 8C13.7847 8 13.5608 7.90783 13.3689 7.7235L7.72727 2.30415L2.08556 7.7235C1.9065 7.89555 1.686 7.98157 1.424 7.98157C1.16154 7.98157 0.934344 7.88941 0.742445 7.70507C0.550552 7.52074 0.454545 7.30569 0.454545 7.05991C0.454545 6.81413 0.550552 6.59908 0.742365 6.41475Z" fill="#333333" />
                </svg>
            </span>
        </div>
        <div x-show="!collapse" class="flex flex-col gap-[9px] p-3 bg-[#F5F5F5]">
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -배송비는 무료입니다.
            </p>
            <p class="font-normal text-[10px] leading-[140%] text-[#666666]">
                -예약일 2일 전(영업일 기준)
            </p>
        </div>
    </div>

    <!-- 구분선 -->
    <hr class="mt-7 border-t-[0.5px] border-solid border-[#E0E0E0]" />

    <!-- 관련 상품 -->
    <div class="mt-5 flex flex-col gap-5 px-[14px]">
        <p class="font-extrabold text-lg leading-5 text-[#333333]">관련 상품</p>
        <div class="grid grid-cols-2 gap-x-[13.5px] gap-y-[30.45px] w-full">
            <?php
            $SQL_QUERY =    'SELECT 
                                A.*, B.STR_CODE
                            FROM 
                                ' . $Tname . 'comm_goods_master A
                            LEFT JOIN
                                ' . $Tname . 'comm_com_code B
                            ON
                                A.INT_BRAND=B.INT_NUMBER
                            WHERE 
                                (A.STR_SERVICE="Y" OR A.STR_SERVICE="R") 
                                AND A.STR_GOODCODE!="' . $arr_Data['STR_GOODCODE'] . '" 
                                AND A.INT_TYPE=' . $arr_Data['INT_TYPE'] . ' 
                                AND A.INT_BRAND=' . $arr_Data['INT_BRAND'] . ' 
                            ORDER BY A.INT_VIEW DESC
                            LIMIT 4';

            $product_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($product_result)) {
            ?>
                <a href="detail.php?str_goodcode=<?= $row['STR_GOODCODE'] ?>" class="flex flex-col w-full">
                    <div class="w-full flex justify-center items-center relative px-2.5 bg-[#F9F9F9] rounded-[5px] h-[176px]">
                        <!-- 타그 -->
                        <div class="justify-center items-center w-[25px] h-[25px] bg-[#00402F] absolute top-2 left-2 <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>">
                            <p class="font-extrabold text-[9px] text-center text-white"><?= $row['INT_DISCOUNT'] ?>%</p>
                        </div>
                        <img src="/admincenter/files/good/<?= $row['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
                    </div>
                    <p class="mt-[5.52px] font-extrabold text-[9px] text-[#666666]"><?= $row['STR_CODE'] ?></p>
                    <p class="mt-[3.27px] font-bold text-[9px] text-[#333333]"><?= $row['STR_GOODNAME'] ?></p>
                    <div class="mt-[7.87px] flex gap-[3px] items-center">
                        <p class="font-bold text-xs text-black">일 <?= $row['INT_DISCOUNT'] ? number_format($row['INT_PRICE'] * $row['INT_DISCOUNT'] / 100) : number_format($row['INT_PRICE']) ?>원</p>
                        <p class="font-bold text-[10px] line-through text-[#666666] <?= $row['INT_DISCOUNT'] ? 'flex' : 'hidden' ?>"><?= number_format($row['INT_PRICE']) ?>원</p>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- 하단 메뉴 -->
<div class="fixed bottom-0 left-0 w-full flex gap-[5px] px-[5px] py-2 h-[66px] border-t border-[#F4F4F4] bg-white">
    <button type="button" class="w-[50px] h-[50px] flex justify-center items-center border border-solid border-[#D9D9D9] bg-white" onclick="setProductLike('<?= $arr_Data['STR_GOODCODE'] ?>')">
        <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.65129 0C5.76148 0.00304681 4.88214 0.191208 4.06902 0.552599C3.25591 0.91399 2.52697 1.4407 1.92845 2.09914C0.687349 3.47032 0 5.25375 0 7.10321C0 8.95266 0.687349 10.7361 1.92845 12.1073L11.8511 22.8886C11.9368 22.9814 12.0409 23.0555 12.1566 23.1062C12.2724 23.1569 12.3974 23.1831 12.5238 23.1831C12.6501 23.1831 12.7751 23.1569 12.8909 23.1062C13.0066 23.0555 13.1107 22.9814 13.1964 22.8886C16.5056 19.3001 19.8132 15.7095 23.119 12.117C24.361 10.7462 25.0489 8.96261 25.0489 7.1129C25.0489 5.26319 24.361 3.4796 23.119 2.10883C22.5224 1.44993 21.7944 0.923224 20.9818 0.562826C20.1692 0.202427 19.2901 0.0163981 18.4012 0.0163981C17.5122 0.0163981 16.6332 0.202427 15.8207 0.562826C15.0081 0.923224 14.2799 1.44993 13.6833 2.10883L12.5278 3.35862L11.3635 2.09914C10.7669 1.44098 10.0396 0.914317 9.22808 0.552952C8.41656 0.191586 7.53856 0.00344715 6.65023 0.000352648L6.65129 0ZM6.65129 1.78422C7.29012 1.79389 7.92 1.93723 8.50004 2.20511C9.08008 2.47298 9.59748 2.85933 10.0191 3.3394L11.8608 5.33362C11.9465 5.42641 12.0506 5.50039 12.1663 5.55103C12.2821 5.60167 12.4069 5.62773 12.5333 5.62773C12.6596 5.62773 12.7846 5.60167 12.9004 5.55103C13.0161 5.50039 13.1202 5.42641 13.2059 5.33362L15.0378 3.34751C15.4537 2.86082 15.9701 2.47005 16.5515 2.20211C17.1329 1.93417 17.7656 1.79533 18.4057 1.79533C19.0459 1.79533 19.6785 1.93417 20.26 2.20211C20.8414 2.47005 21.3578 2.86082 21.7737 3.34751C22.6957 4.38446 23.2049 5.72373 23.2049 7.11132C23.2049 8.4989 22.6957 9.83817 21.7737 10.8751C18.6905 14.2188 15.609 17.5652 12.5292 20.9141L3.28474 10.8675C2.36304 9.8305 1.85387 8.49135 1.85387 7.10391C1.85387 5.71647 2.36304 4.37732 3.28474 3.34028C3.7064 2.8602 4.22402 2.47369 4.80412 2.20581C5.38422 1.93793 6.01398 1.79459 6.65287 1.78493L6.65129 1.78422Z" fill="black" />
        </svg>
    </button>
    <button type="button" class="w-[50px] h-[50px] flex justify-center items-center border border-solid border-[#D9D9D9] bg-white" onclick="addProductBasket('<?= $arr_Data['STR_GOODCODE'] ?>')">
        <svg width="27" height="23" viewBox="0 0 27 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24.2308 0H2.01923C1.4837 0 0.970098 0.211722 0.591419 0.588589C0.21274 0.965457 0 1.4766 0 2.00957V20.0957C0 20.6287 0.21274 21.1398 0.591419 21.5167C0.970098 21.8935 1.4837 22.1053 2.01923 22.1053H24.2308C24.7663 22.1053 25.2799 21.8935 25.6586 21.5167C26.0373 21.1398 26.25 20.6287 26.25 20.0957V2.00957C26.25 1.4766 26.0373 0.965457 25.6586 0.588589C25.2799 0.211722 24.7663 0 24.2308 0ZM24.2308 20.0957H2.01923V2.00957H24.2308V20.0957ZM19.1827 6.02871C19.1827 7.62762 18.5445 9.16105 17.4084 10.2916C16.2724 11.4223 14.7316 12.0574 13.125 12.0574C11.5184 12.0574 9.9776 11.4223 8.84157 10.2916C7.70553 9.16105 7.06731 7.62762 7.06731 6.02871C7.06731 5.76222 7.17368 5.50665 7.36302 5.31822C7.55236 5.12978 7.80916 5.02392 8.07692 5.02392C8.34469 5.02392 8.60149 5.12978 8.79083 5.31822C8.98017 5.50665 9.08654 5.76222 9.08654 6.02871C9.08654 7.09465 9.51202 8.11693 10.2694 8.87067C11.0267 9.6244 12.0539 10.0478 13.125 10.0478C14.1961 10.0478 15.2233 9.6244 15.9806 8.87067C16.738 8.11693 17.1635 7.09465 17.1635 6.02871C17.1635 5.76222 17.2698 5.50665 17.4592 5.31822C17.6485 5.12978 17.9053 5.02392 18.1731 5.02392C18.4408 5.02392 18.6976 5.12978 18.887 5.31822C19.0763 5.50665 19.1827 5.76222 19.1827 6.02871Z" fill="black" />
        </svg>
    </button>
    <?php
    switch ($arr_Data['INT_TYPE']) {
        case 2:
    ?>
            <a href="/m/pay/index.php?int_type=2&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>" class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]">
                <span class="font-extrabold text-lg text-center text-white">렌트하기</span>
            </a>
        <?php
            break;
        case 1:
        ?>
            <a href="/m/pay/index.php?int_type=1&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>" class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]">
                <span class="font-extrabold text-lg text-center text-white">구독하기</span>
            </a>
        <?php
            break;
        case 3:
        ?>
            <a href="/m/pay/index.php?int_type=3&str_goodcode=<?= $arr_Data['STR_GOODCODE'] ?>" class="grow flex justify-center items-center h-[50px] bg-black border border-solid border-[#D9D9D9]">
                <span class="font-extrabold text-lg text-center text-white">구매하기</span>
            </a>
    <?php
            break;
    }
    ?>

</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer_detail.php"; ?>

<script>
    var is_basket = <?= $arr_Data['IS_BASKET'] ?: 0 ?>;

    $(document).ready(function() {
        searchOwnReview();
        searchRelatedReview();
    });

    function searchOwnReview(page = 0) {
        url = "get_own_review_list.php";
        url += "?page=" + page;
        url += "&str_goodcode=" + <?= $arr_Data['STR_GOODCODE'] ?>;

        $.ajax({
            url: url,
            success: function(result) {
                $("#own_review_list").html(result);
            }
        });
    }

    function searchRelatedReview(page = 0) {
        url = "get_related_review_list.php";
        url += "?page=" + page;
        url += "&str_goodcode=" + <?= $arr_Data['STR_GOODCODE'] ?>;
        url += "&int_good_type=" + <?= $arr_Data['INT_TYPE'] ?>;
        url += "&int_brand=" + <?= $arr_Data['INT_BRAND'] ?>;

        $.ajax({
            url: url,
            success: function(result) {
                $("#related_review_list").html(result);
            }
        });
    }

    function setReviewLike(bd_seq) {
        $.ajax({
            url: "/m/review/set_like.php",
            data: {
                bd_seq: bd_seq
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    $("#like_count_" + bd_seq).html(result['data']);
                }
            }
        });
    }

    function setProductLike(str_goodcode) {
        $.ajax({
            url: "/m/product/set_like.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        $("#is_like_no").hide();
                        $("#is_like_yes").show();
                    }
                    if (result['data'] == false) {
                        $("#is_like_no").show();
                        $("#is_like_yes").hide();
                    }
                }
            }
        });
    }

    function addProductBasket(str_goodcode) {
        if (is_basket) {
            alert("이미 장바구니에 존재합니다.");
            return;
        }
        $.ajax({
            url: "/m/product/set_basket.php",
            data: {
                str_goodcode: str_goodcode
            },
            success: function(resultString) {
                result = JSON.parse(resultString);
                if (result['status'] == 401) {
                    alert('사용자로그인을 하여야 합니다.');
                    return;
                }
                if (result['status'] == 200) {
                    if (result['data'] == true) {
                        is_basket = 1;
                        alert("장바구니에 추가되였습니다.");
                    }
                }
            }
        });
    }
</script>