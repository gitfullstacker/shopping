<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">평점/리뷰 작성</p>
    </div>

    <div class="flex gap-[11px]">
        <div class="flex justify-center items-center w-[120px] h-[120px] bg-[#F9F9F9] p-2.5">
            <img src="images/mockup/product.png" alt="product">
        </div>
        <div class="grow flex flex-col justify-center">
            <div class="w-[34px] h-[18px] flex justify-center items-center bg-[#00402F]">
                <p class="font-normal text-[10px] leading-[11px] text-center text-white">렌트</p>
            </div>
            <p class="mt-1.5 font-bold text-[15px] leading-[17px] text-black">CHANEL</p>
            <p class="mt-[2px] font-bold text-xs leading-[14px] text-[#666666]">코코핸들 스몰</p>
            <p class="mt-[9px] font-bold text-xs leading-[14px] text-[#999999]">기간: 2023.02.10 ~ 2023.02.13</p>
            <p class="mt-[3px] font-bold text-xs leading-[14px] text-black">156,000원</p>
        </div>
    </div>

    <hr class="mt-[23px] border-t-[0.5px] border-[#E0E0E0]" />

    <div class="mt-[23px] flex flex-col items-center w-full gap-[23px]">
        <div class="flex flex-col items-center w-full gap-2">
            <p class="font-bold text-xs leading-[14px] text-black">별점을 선택해주세요.</p>
            <img src="images/mockup/star.png" class="w-40 h-[25px]" alt="">
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">이용하신 가방에 만족하시나요?</p>
            <div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품의 포장상태에 만족하시나요?</p>
            <div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>
        <div class="flex flex-col items-center w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품의 배송에 만족하시나요?</p>
            <div x-data="{ grade: 1 }" class="mt-[15px] flex gap-8 items-center justify-center">
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 1">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 1 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 1 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 2">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 2 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 2 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
                <div class="flex flex-col items-center gap-1.5" x-on:click="grade = 3">
                    <div class="w-10 h-10 border border-solid flex justify-center items-center rounded-full bg-[#DDDDDD]" x-bind:class="grade == 3 ? 'border-black': 'border-none'">
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33333 12.5333L0 7.2L1.86667 5.33333L5.33333 8.8L14.1333 0L16 1.86667L5.33333 12.5333Z" fill="black" x-bind:fill="grade == 3 ? 'black' : 'white'" />
                        </svg>
                    </div>
                    <p class="font-bold text-xs leading-[14px] text-[#999999]">만족해요</p>
                </div>
            </div>
            <hr class="mt-[27px] w-full border-t-[0.5px] border-[#E0E0E0]" />
        </div>

        <div class="mt-[23px] flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">상품 리뷰를 남겨주세요</p>
            <textarea class="w-full h-[300px] border border-solid border-[#DDDDDD] px-4 py-5 font-bold text-xs leading-[19px] placeholder:text-[#999999]" name="content" id="content" placeholder="꿀팁 가득, 상세한 리뷰를 작성해보세요!
도움수가 올라가면 탑리뷰어가 될 확률도 높아져요!
반품, 환불 관련 내용은 고객센터 1:1 문의로 별도 문의해주세요."></textarea>
        </div>

        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">이미지 첨부</p>
            <div class="flex gap-[5px]">
                <div class="grow flex flex-col gap-2.5">
                    <input type="file" class="hidden" name="image_input" id="image_input" />
                    <input type="text" class="grow h-[45px] border border-solid border-[#DDDDDD] px-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="images" id="images">
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
            <p class="font-bold text-[10px] leading-[16px] text-[#999999]">
                -사진 후기 100원, 글 후기 50원 적립금이 지급됩니다.<br />
                -작성 시 기준에 맞는 적립금이 자동으로 지급됩니다.<br />
                -등급에 따라 차등으로 적립 혜택이 달라질 수 있습니다.<br />
                -주간 베스트 후기로 선정 시 5,000원이 추가로 적립됩니다.<br />
                -후기 작성은 배송완료일로부터 30일 이내 가능합니다.<br />
            </p>
        </div>

        <div class="mt-[30px] flex gap-[5px] w-full">
            <button type="reset" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-white w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">취소</p>
            </button>
            <button type="submit" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-white">작성</p>
            </button>
        </div>
    </div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>