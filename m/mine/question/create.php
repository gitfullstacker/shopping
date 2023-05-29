<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<div x-data="{ menu: 1 }" class="mt-[30px] flex flex-col w-full px-[14px]">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-[20px] text-black">1:1 문의</p>
    </div>

    <form class="flex flex-col gap-[15px]">
        <div class="flex flex-col gap-[5px]">
            <p class="font-bold text-xs leading-[14px] text-black">제목</p>
            <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] px-4 font-bold text-xs leading-[14px] placeholder:text-[#999999]" name="title" id="title" placeholder="제목을 입력해주세요">
        </div>
        <div class="flex flex-col gap-[5px]">
            <p class="font-bold text-xs leading-[14px] text-black">상담분류</p>
            <div class="relative w-full">
                <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-bold text-xs leading-[14px] text-[#999999]" name="type" id="type">
                    <option value="0" selected>선택 안함</option>
                </select>
                <span class="absolute top-5 right-[19px]">
                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="flex flex-col gap-[5px]">
            <p class="font-bold text-xs leading-[14px] text-black">문의내용</p>
            <textarea class="w-full h-[300px] border border-solid border-[#DDDDDD] px-4 py-5 font-bold text-xs leading-[19px] placeholder:text-[#999999]" name="content" id="content" placeholder="안녕하세요 고객님. 아래 양식에 맞게 문의글 작성 부탁드립니다.

폭언/욕설/비속어 등이 포함될 경우 답변이 제한되며,
사전 안내없이 무통보 삭제되오니 작성 시 유의 부탁드립니다.

-주문번호: 
-휴대폰: 
-불량/AS 문의일 경우 반드시 사진첨부를 부탁드립니다.
"></textarea>
        </div>
        <div class="flex flex-col gap-[5px]">
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
        <hr class="mt-1.5 border-t-[0.5] border-[#E0E0E0]" />

        <div class="mt-1 flex w-full bg-[#F5F5F5] px-[9px] py-[15px]">
            <p class="font-bold text-[10px] leading-[16px] text-[#999999]">
                -한번 등록한 상담내용은 수정이 불가능합니다.<br />
                -상담 운영시간: 평일 09:00 ~ 17:30 (점심시간 12:00~13:00) 주말 및 공휴일 휴무</p>
        </div>

        <div class="mt-[15px] flex gap-[5px] w-full">
            <button type="reset" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-white w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-[#666666]">취소</p>
            </button>
            <button type="submit" class="flex justify-center items-center border border-solid border-[#DDDDDD] bg-black w-full h-[45px]">
                <p class="font-bold text-xs leading-[14px] text-white">작성</p>
            </button>
        </div>
    </form>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>