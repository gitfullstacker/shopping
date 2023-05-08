</div> <!-- //#wrapper -->

<div class="mt-[50px] flex flex-col w-full">
    <div class="flex justify-around py-[17px] border-t border-b border-[#C8C8C8]">
        <a href="#" class="font-medium text-[11px] text-[#595959]">COMPANY</a>
        <a href="#" class="font-medium text-[11px] text-[#595959]">AGREEMENT</a>
        <a href="#" class="font-medium text-[11px] text-[#595959]">PRIVACY POLICY</a>
        <a href="#" class="font-medium text-[11px] text-[#595959]">HELP</a>
        <a href="#" class="font-medium text-[11px] text-[#595959]">PARTNERSHIP</a>
    </div>
    <div class="mt-[15px] flex flex-col px-[14px] pb-[112px]">
        <p class="text-[16.5px] text-black">ABLANC</p>
        <p class="font-bold text-[9px] text-black">(주)에이블랑</p>
        <div class="mt-[10.93px] flex flex-col gap-[6.71px]">
            <p class="font-bold text-[8px] text-[#686868]">주소: 박용훈, 김율희</p>
            <p class="font-bold text-[8px] text-[#686868]">소재지: 서울특별시 서대문구 연희로 27길 16 (연희동) 2층</p>
            <p class="font-bold text-[8px] text-[#686868]">사업자등록번호: 698-86-00719</p>
            <p class="font-bold text-[8px] text-[#686868]">통신판매업신고번호: 2021-서울송파-0251</p>
            <p class="font-bold text-[8px] text-[#686868]">개인정보관리책임자: 박용훈</p>
            <p class="font-bold text-[8px] text-[#686868]">ablancpm@gmail.com I 02-6013-0616</p>
        </div>
        <p class="mt-[42.34px] font-bold text-[7px] text-[#686868]">2021-2023 ABLANC CO. ALL RIGHTS RESERVED</p>
    </div>
</div>

<div id="scroll-top-btn">
    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.92 16.6134H6.92V4.61344L1.42 10.1134L0 8.69344L7.92 0.773438L15.84 8.69344L14.42 10.1134L8.92 4.61344V16.6134Z" fill="#666666" />
    </svg>
</div>
</body>

</html>

<script>
    $(document).ready(function() {
        // Show the scroll-to-top button when the user scrolls down 20px from the top
        $(window).scroll(function() {
            if ($(this).scrollTop() > 20) {
                $('#scroll-top-btn').fadeIn();
            } else {
                $('#scroll-top-btn').fadeOut();
            }
        });

        // Scroll to top when the user clicks the scroll-to-top button
        $('#scroll-top-btn').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
</script>