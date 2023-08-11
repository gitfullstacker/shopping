<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>
<?php
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], '');
$SQL_QUERY = 'SELECT
                    A.*,B.STR_GOODNAME,B.STR_IMAGE1 AS PRODUCT_IMAGE,B.INT_TYPE,B.INT_PRICE,C.STR_CODE AS STR_BRAND
                FROM 
                    ' . $Tname . 'comm_goods_cart AS A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master AS B
                ON
                    A.STR_GOODCODE=B.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code AS C
                ON
                    B.INT_BRAND=C.INT_NUMBER
                WHERE
                    A.INT_NUMBER=' . $int_cart;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

// 금액정보 얻기
$SQL_QUERY =	" SELECT
						*
                FROM 
                    " . $Tname . "comm_site_info
                WHERE
                    INT_NUMBER=1 ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);
$site_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<form action="edit_proc.php" method="post" class="mt-[30px] flex flex-col w-full px-[14px]" onsubmit="return validateForm()" enctype="multipart/form-data">
    <input type="hidden" name="RetrieveFlag" value="INSERT">
    <input type="hidden" name="str_goodcode" value="<?= $arr_Data['STR_GOODCODE'] ?>">
    <input type="hidden" name="int_cart" value="<?= $int_cart ?>">
    <input type="hidden" name="str_userid" value="<?= $arr_Auth[0] ?>">
    <input type="hidden" name="int_good_type" value="<?= $arr_Data['INT_TYPE'] ?>">

    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">평점/리뷰 작성</p>
    </div>

    <div class="flex gap-[11px]">
        <div class="flex justify-center items-center w-[120px] h-[120px] bg-[#F9F9F9] p-2.5">
            <img src="/admincenter/files/good/<?= $arr_Data['PRODUCT_IMAGE'] ?>" alt="product">
        </div>
        <div class="grow flex flex-col justify-center">
            <div class="w-[34px] h-[18px] flex justify-center items-center bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                <p class="font-normal text-[10px] leading-[11px] text-center text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
            </div>
            <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black"><?= $arr_Data['STR_BRAND'] ?></p>
            <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]"><?= $arr_Data['STR_GOODNAME'] ?></p>
            <p class="mt-[9px] font-medium text-xs leading-[14px] text-[#999999]">기간: <?= $arr_Data['STR_SDATE'] ?> ~ <?= $arr_Data['STR_EDATE'] ?></p>
            <p class="mt-[3px] font-bold text-xs leading-[14px] text-black"><?= number_format($arr_Data['INT_PRICE']) ?>원</p>
        </div>
    </div>

    <hr class="mt-[23px] border-t-[0.5px] border-[#E0E0E0]" />

    <div class="mt-[23px] flex flex-col items-center w-full gap-[23px]">
        <div class="flex flex-col items-center w-full gap-2">
            <p class="font-bold text-xs leading-[14px] text-black">별점을 선택해주세요.</p>
            <div x-data="{ star: 5 }" class="flex justify-center gap-2 items-center">
                <input type="hidden" name="int_star" x-bind:value="star">
                <svg width="162" height="27" viewBox="0 0 162 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="cursor-pointer" d="M17.7482 10.19H28.0382L19.6682 16.4L22.8482 26.24L14.4482 20.33L5.89822 26.24L9.10822 16.4L0.678223 10.19H11.1782L14.4482 0.440002L17.7482 10.19Z" x-bind:fill="star >= 1 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 1" />
                    <path class="cursor-pointer" d="M51.0529 10.19H61.3429L52.9729 16.4L56.1529 26.24L47.7529 20.33L39.2029 26.24L42.4129 16.4L33.9829 10.19H44.4829L47.7529 0.440002L51.0529 10.19Z" x-bind:fill="star >= 2 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 2" />
                    <path class="cursor-pointer" d="M84.3576 10.19H94.6476L86.2776 16.4L89.4576 26.24L81.0576 20.33L72.5076 26.24L75.7176 16.4L67.2876 10.19H77.7876L81.0576 0.440002L84.3576 10.19Z" x-bind:fill="star >= 3 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 3" />
                    <path class="cursor-pointer" d="M117.662 10.19H127.952L119.582 16.4L122.762 26.24L114.362 20.33L105.812 26.24L109.022 16.4L100.592 10.19H111.092L114.362 0.440002L117.662 10.19Z" x-bind:fill="star >= 4 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 4" />
                    <path class="cursor-pointer" d="M150.967 10.19H161.257L152.887 16.4L156.067 26.24L147.667 20.33L139.117 26.24L142.327 16.4L133.897 10.19H144.397L147.667 0.440002L150.967 10.19Z" x-bind:fill="star >= 5 ? '#FFD748' : '#DDDDDD'" x-on:click="star = 5" />
                </svg>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">이용하신 가방에 만족하시나요?</p>
            <div x-data="{ grade: 3 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <input type="hidden" name="int_ustar" x-bind:value="grade">
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">보통이에요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">아쉬워요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품의 포장상태에 만족하시나요?</p>
            <div x-data="{ grade: 3 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <input type="hidden" name="int_pstar" x-bind:value="grade">
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">보통이에요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">아쉬워요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품의 배송에 만족하시나요?</p>
            <div x-data="{ grade: 3 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <input type="hidden" name="int_dstar" x-bind:value="grade">
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">보통이에요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5 cursor-pointer" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">아쉬워요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>

        <div class="mt-[23px] flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품 리뷰를 남겨주세요</p>
            <textarea class="w-full h-[300px] border border-solid border-[#DDDDDD] px-4 py-5 font-normal text-xs leading-[19px] placeholder:text-[#999999]" name="str_content" id="str_content" placeholder="꿀팁 가득, 상세한 리뷰를 작성해보세요!
도움수가 올라가면 탑리뷰어가 될 확률도 높아져요!
반품, 환불 관련 내용은 고객센터 1:1 문의로 별도 문의해주세요."></textarea>
        </div>

        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">이미지 첨부</p>
            <div class="flex gap-[5px]">
                <div class="grow flex flex-col gap-2.5">
                    <input type="file" class="hidden" name="str_image[]" id="image_input" onchange="handleFileChange(event)" accept=".jpg,.png,.gif" multiple />
                    <input type="text" class="grow h-[45px] border border-solid border-[#DDDDDD] px-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" id="image_names" readonly>
                    <p class="font-bold text-[10px] leading-[15px] text-[#999999]">이미지 파일(JPG, PNG, GIF)를 기준으로 최대 10MB이하,
                        최대 3개까지 등록가능합니다.</p>
                </div>
                <div class="flex w-[97px]">
                    <button type="button" class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]" onclick="document.getElementById('image_input').click();">
                        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">사진첨부</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- 구분 -->
        <hr class="mt-1.5 border-t-[0.5] border-[#E0E0E0] w-full" />

        <div class="mt-1 flex w-full bg-[#F5F5F5] px-[9px] py-[15px]">
            <p class="font-bold text-[10px] leading-[14px] text-black"></p>
            <p class="font-normal text-[10px] leading-[16px] text-[#999999]">
                - 사진 후기 <?= number_format($site_Data['INT_STAMP2']) ?>원, 글 후기 <?= number_format($site_Data['INT_STAMP1']) ?>원 적립금이 지급됩니다.<br />
                - 작성 시 기준에 맞는 적립금이 자동으로 지급됩니다.<br />
                - 주간 베스트 후기로 선정 시 <?= number_format($site_Data['INT_STAMP3']) ?>원이 추가로 적립됩니다.<br />
                - 후기 작성은 배송완료일로부터 30일 이내 가능합니다.<br />
            </p>
        </div>

        <div class="mt-[30px] flex gap-[5px] w-full">
            <a href="index.php" type="reset" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-white w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">취소</p>
            </a>
            <button type="submit" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-white">작성</p>
            </button>
        </div>
    </div>
</form>

<script>
    function handleFileChange(event) {
        const image_input = event.target;
        const files = image_input.files;
        const image_names = document.getElementById('image_names');

        image_names.value = '';
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                image_names.value += file.name + ', ';
            }
        }
    }

    function validateForm() {
        var inputValue = document.getElementById("str_content").value;
        if (inputValue === "") {
            alert("리뷰를 남겨주세요.");
            return false;
        }

        // If validation passes, return true to allow the form submission
        return true;
    }
</script>
<style>
    .preview-image {
        max-width: 100%;
        max-height: 100%;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        width: 14px;
        height: 14px;
        background-color: black;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 0.72px solid #DDDDDD;
    }
</style>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>