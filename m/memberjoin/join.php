<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script language="javascript" src="js/join.js"></script>

<?php
$_SESSION['PHONE_VERIFY'] = 'JOIN';

$authtype = "M";          // 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드

$popgubun     = "N";        //Y : 취소버튼 있음 / N : 취소버튼 없음
$customize     = "Mobile";            //없으면 기본 웹페이지 / Mobile : 모바일페이지

$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
$reqseq = `$cb_encode_path SEQ $sitecode`;

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
$returnurl = "//" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_success.php";    // 성공시 이동될 URL
$errorurl = "//" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_fail.php";        // 실패시 이동될 URL

// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

$_SESSION["REQ_SEQ"] = $reqseq;

// 입력될 plain 데이타를 만든다.
$plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
    "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
    "9:AUTH_TYPE" . strlen($authtype) . ":" . $authtype .
    "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
    "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
    "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
    "9:CUSTOMIZE" . strlen($customize) . ":" . $customize;

$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

if ($enc_data == -1) {
    $returnMsg = "암/복호화 시스템 오류입니다.";
    $enc_data = "";
} else if ($enc_data == -2) {
    $returnMsg = "암호화 처리 오류입니다.";
    $enc_data = "";
} else if ($enc_data == -3) {
    $returnMsg = "암호화 데이터 오류 입니다.";
    $enc_data = "";
} else if ($enc_data == -9) {
    $returnMsg = "입력값 오류 입니다.";
    $enc_data = "";
}
?>

<form class="mt-[30px] flex flex-col w-full px-[14px]" name="frm" method="post" enctype="multipart/form-data">
    <div class="flex justify-center">
        <p class="font-extrabold text-lg leading-5 text-center text-black">회원가입</p>
    </div>

    <!-- 계정 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-sm leading-4 text-black">계정 정보 <span class="text-[#DA2727]">*</span></p>
        <div class="flex flex-col gap-[15px] w-full">
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">아이디</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_userid" id="str_userid" placeholder="아이디" onKeyUp="fnc_idcheck();str_userid_check2();">
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="idView_Proc"></span>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">비밀번호</p>
                <input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_passwd1" maxlength="20" onKeyUp="pass_check();" placeholder="영문, 숫자, 특수문자, 8-20자 이내로 입력해 주세요">
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_password1"></span>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">비밀번호 확인</p>
                <input type="password" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_passwd2" maxlength="20" onKeyUp="pass_con_check();" placeholder="비밀번호를 다시 입력해 주세요">
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_password2"></span>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">이메일</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_email" placeholder="이메일">
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_email"></span>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
                <div class="grid grid-cols-3 gap-[5px]">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp1" name="str_hp1" maxlength="3" placeholder="010" readonly>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp2" name="str_hp2" maxlength="4" placeholder="1234" readonly>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp3" name="str_hp3" maxlength="4" placeholder="5678" readonly>
                </div>
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_hp"></span>
                <button type="button" id="phone_verify_btn" class="flex justify-center items-center w-full h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]" onclick="verifyPhone()">
                    <p class="font-bold text-xs leading-[14px] text-center text-[#666666]"><?= $str_hp ? '인증됨' : '인증' ?></p>
                </button>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 배송지 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-sm leading-4 text-black">배송지 정보</p>
        <div class="flex flex-col gap-[15px] w-full">
            <div x-data="{ checked: false }" class="flex gap-[5px] items-center">
                <input type="checkbox" class="w-[14px] h-[14px] accent-black" name="same_account" id="same_account" value="1" onchange="setSameDeliveryInfo()">
                <label for="same_account" class="font-normal text-xs leading-[14px] text-[#666666]">회원정보와 동일</label>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">이름</p>
                <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_name" id="str_name" placeholder="에이블랑">
                <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_name"></span>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <p class="font-bold text-xs leading-[14px] text-black">연락처</p>
                <div class="grid grid-cols-3 gap-[5px]">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_shp1" name="str_shp1" maxlength="3" placeholder="010" readonly>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_shp2" name="str_shp2" maxlength="4" placeholder="1234" readonly>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_shp3" name="str_shp3" maxlength="4" placeholder="5678" readonly>
                </div>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <div id="layer" style="display:none;border:5px solid;position:fixed;width:300px;height:400px;left:50%;margin-left:-155px;top:50%;margin-top:-145px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:2000000000000000000000">
                    <img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1;width:20px;height:20px;" onclick="closeDaumPostcode()" alt="닫기 버튼">
                </div>

                <script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                <script>
                    // 우편번호 찾기 화면을 넣을 element
                    var element_layer = document.getElementById('layer');

                    function closeDaumPostcode() {
                        // iframe을 넣은 element를 안보이게 한다.
                        element_layer.style.display = 'none';
                    }

                    function execDaumPostcode() {
                        new daum.Postcode({
                            oncomplete: function(data) {
                                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                var fullAddr = data.address; // 최종 주소 변수
                                var extraAddr = ''; // 조합형 주소 변수

                                // 기본 주소가 도로명 타입일때 조합한다.
                                if (data.addressType === 'R') {
                                    //법정동명이 있을 경우 추가한다.
                                    if (data.bname !== '') {
                                        extraAddr += data.bname;
                                    }
                                    // 건물명이 있을 경우 추가한다.
                                    if (data.buildingName !== '') {
                                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                    }
                                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                    fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                                }

                                // 우편번호와 주소 및 영문주소 정보를 해당 필드에 넣는다.
                                document.getElementById('str_spost').value = data.zonecode;
                                document.getElementById('str_saddr1').value = fullAddr;
                                document.getElementById('str_saddr2').focus();

                                // iframe을 넣은 element를 안보이게 한다.
                                element_layer.style.display = 'none';
                            },
                            width: '100%',
                            height: '100%'
                        }).embed(element_layer);

                        // iframe을 넣은 element를 보이게 한다.
                        element_layer.style.display = 'block';
                    }
                </script>
                <p class="font-bold text-xs leading-[14px] text-black">주소</p>
                <div class="flex gap-[5px] items-center">
                    <div class="grow">
                        <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_spost" id="str_spost" placeholder="우편번호" readonly>
                    </div>
                    <a href="javascript:execDaumPostcode();" class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]">
                        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">검색</p>
                    </a>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_saddr1" id="str_saddr1" placeholder="기본주소" readonly>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_saddr2" id="str_saddr2" placeholder="상세 주소를 입력해 주세요">
                </div>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 추가 정보 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-sm leading-4 text-black">추가 정보</p>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">성별</p>
            <div class="flex gap-[15px] items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="radio" class="w-[14px] h-[14px] accent-black" name="str_sex" value="2">
                    <label for="woman" class="font-normal text-xs leading-[14px] text-[#666666]">여성</label>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="radio" class="w-[14px] h-[14px] accent-black" name="str_sex" value="1">
                    <label for="man" class="font-normal text-xs leading-[14px] text-[#666666]">남성</label>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-[5px] w-full">
            <p class="font-bold text-xs leading-[14px] text-black">생년월일</p>
            <div class="grid grid-cols-3 gap-[5px] items-center">
                <input type="text" class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_year" id="str_birth_year" placeholder="1900" readonly>
                <input type="text" class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_month" id="str_birth_month" placeholder="01" readonly>
                <input type="text" class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_day" id="str_birth_day" placeholder="01" readonly>
            </div>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 약관동의 -->
    <div class="mt-4 flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-sm leading-4 text-black">약관동의 <span class="text-[#DA2727]">*</span></p>
        <div class="flex flex-col gap-2.5 w-full">
            <div class="flex justify-between items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" name="agree_terms" id="agree_terms" class="w-[14px] h-[14px] accent-black">
                    <label for="agree_terms" class="font-bold text-xs leading-[14px] text-[#666666]">보증금 약관 동의하기</label>
                </div>
                <a href="/m/help/deposit_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" name="agree_payment" id="agree_payment" class="w-[14px] h-[14px] accent-black">
                    <label for="agree_payment" class="font-bold text-xs leading-[14px] text-[#666666]">약관 및 개인정보 제 3자 제공사항 결제 동의하기</label>
                </div>
                <a href="/m/help/privacy_agree.php" class="font-medium text-[10px] leading-3 text-right underline text-[#666666]">약관보기</a>
            </div>
            <span class="font-bold text-xs leading-[14px] text-[#DA2727]" id="alert_agree"></span>
        </div>
    </div>

    <!-- 구분 -->
    <hr class="mt-[30px] mb-[20px] border-t-[0.5px] border-[#E0E0E0]" />

    <!-- 수신동의 -->
    <div class="flex flex-col gap-[19px] w-full">
        <p class="font-extrabold text-sm leading-4 text-black">수신동의</p>
        <div class="flex flex-col gap-2.5 w-full">
            <p class="font-bold text-xs leading-[14px] text-black">마케팅 수신동의</p>
            <div class="flex gap-[18px] items-center">
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" class="w-[14px] h-[14px] accent-black" name="str_mail_f" id="str_mail_f" value="Y">
                    <label for="str_mail_f" class="font-normal text-xs leading-[14px] text-[#666666]">이메일 수신동의</label>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="checkbox" class="w-[14px] h-[14px] accent-black" name="str_sms_f" id="str_sms_f" value="Y">
                    <label for="str_sms_f" class="font-normal text-xs leading-[14px] text-[#666666]">SMS 수신동의</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-[15px] px-[9px] py-[15px] bg-[#F5F5F5] w-full">
        <p class="font-normal text-[10px] leading-[160%] text-[#999999]">
            수신동의를 하시면 에이블랑에서 제공하는 다양한 할인 혜택과 <br />이벤트/신상품 등의 정보를 만나실 수 있습니다.
        </p>
        <p class="font-normal text-[10px] leading-[160%] text-black">
            주문 및 배송관련 SMS는 수신동의와 상관없이 자동 발송됩니다.
        </p>
    </div>

    <a href="javascript:Save_Click();" class="mt-[30px] flex justify-center items-center w-full h-[45px] bg-black border-[0.72px] border-solid border-[#DDDDDD]">
        <p class="font-bold text-xs leading-[14px] text-center text-white">가입하기</p>
    </a>
</form>

<form name="form_chk" method="post">
    <input type="hidden" name="m" id="m" value="checkplusSerivce"> <!-- 필수 데이타로, 누락하시면 안됩니다. -->
    <input type="hidden" name="EncodeData" id="EncodeData" value="<?= $enc_data ?>"> <!-- 위에서 업체정보를 암호화 한 데이타입니다. -->

    <!-- 업체에서 응답받기 원하는 데이타를 설정하기 위해 사용할 수 있으며, 인증결과 응답시 해당 값을 그대로 송신합니다.
			    	 해당 파라미터는 추가하실 수 없습니다. -->
    <input type="hidden" name="param_r1" id="param_r1" value="">
    <input type="hidden" name="param_r2" id="param_r2" value="">
    <input type="hidden" name="param_r3" id="param_r3" value="">
</form>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>