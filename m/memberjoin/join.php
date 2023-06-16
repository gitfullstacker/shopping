<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script language="javascript" src="js/join.js"></script>

<?php
$_SESSION['PHONE_VERIFY'] = 'JOIN';

$authtype = "";          // 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드

$popgubun     = "N";        //Y : 취소버튼 있음 / N : 취소버튼 없음
$customize     = "";            //없으면 기본 웹페이지 / Mobile : 모바일페이지

$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
$reqseq = `$cb_encode_path SEQ $sitecode`;

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
$returnurl = "http://" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_success.php";    // 성공시 이동될 URL
$errorurl = "http://" . $_SERVER["HTTP_HOST"] . "/m/memberjoin/checkplus_fail.php";        // 실패시 이동될 URL

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

$str_cert = Fnc_Om_Conv_Default($_REQUEST['str_cert'], $_SESSION['USERJ_CERT']);
$str_name = Fnc_Om_Conv_Default($_REQUEST['str_name'], $_SESSION['USERJ_NAME']);
$str_hp = Fnc_Om_Conv_Default($_REQUEST['str_hp'], $_SESSION['USERJ_HP']);
$str_birth = Fnc_Om_Conv_Default($_REQUEST['str_birth'], $_SESSION['USERJ_BIRTH']);
$str_sex = Fnc_Om_Conv_Default($_REQUEST['str_sex'], $_SESSION['USERJ_SEX']);
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
                    <?php
                    if ($str_hp) {
                        $sTemp = Split("-", Fnc_Om_Conv_Default($str_hp, "--"));
                    }
                    ?>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp1" name="str_hp1" value="<?= $sTemp[0] ?>" maxlength="3" placeholder="010" disabled>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp2" name="str_hp2" value="<?= $sTemp[1] ?>" maxlength="4" placeholder="1234" disabled>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" id="str_hp3" name="str_hp3" value="<?= $sTemp[2] ?>" maxlength="4" placeholder="5678" disabled>
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
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_telep1" id="str_telep1">
                        <option value="010">010</option>
                        <option value="011">011</option>
                        <option value="016">016</option>
                        <option value="017">017</option>
                        <option value="018">018</option>
                        <option value="019">019</option>
                    </select>
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_telep2" id="str_telep2" placeholder="1234">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_telep3" id="str_telep3" placeholder="5678">
                </div>
            </div>
            <div class="flex flex-col gap-[5px] w-full">
                <div id="layer" style="display:none;border:5px solid;position:fixed;width:300px;height:400px;left:50%;margin-left:-155px;top:50%;margin-top:-145px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:2000000000000000000000">
                    <img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1;width:20px;height:20px;" onclick="closeDaumPostcode()" alt="닫기 버튼">
                </div>

                <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
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
                                //document.getElementById('str_post').value = data.postcode1+data.postcode2;
                                document.getElementById('str_post').value = data.zonecode;
                                //document.getElementById('str_post2').value = data.postcode2;
                                document.getElementById('str_addr1').value = fullAddr;
                                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;
                                document.getElementById('str_addr2').focus();

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
                        <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_post" id="str_post" placeholder="우편번호" disabled>
                    </div>
                    <a href="javascript:execDaumPostcode();" class="flex justify-center items-center w-[97px] h-[45px] bg-[#EBEBEB] border border-solid border-[#DDDDDD]">
                        <p class="font-bold text-xs leading-[14px] text-center text-[#666666]">검색</p>
                    </a>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_addr1" id="str_addr1" placeholder="기본주소" disabled>
                </div>
                <div class="flex gap-[5px] items-center">
                    <input type="text" class="w-full h-[45px] border border-solid border-[#DDDDDD] pl-4 font-normal text-xs leading-[14px] placeholder:text-[#999999]" name="str_addr2" id="str_addr2" placeholder="상세 주소를 입력해 주세요">
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
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_year">
                        <?php
                        for ($i = 0; $i < 150; $i++) {
                        ?>
                            <option value="<?= $i + 1900 ?>" <?= $i == 50 ? 'selected' : '' ?>><?= $i + 1900 ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_month">
                        <?php
                        for ($i = 0; $i < 12; $i++) {
                        ?>
                            <option value="<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
                <div class="relative w-full">
                    <select class="w-full h-[45px] px-[15px] bg-white border border-solid border-[#DDDDDD] font-normal text-xs leading-[14px] text-[#999999]" name="str_birth_day">
                        <?php
                        for ($i = 0; $i < 31; $i++) {
                        ?>
                            <option value="<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="absolute top-5 right-[19px]">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6932 1.18894L5.85752 5.84793C5.79995 5.90323 5.73759 5.9423 5.67042 5.96516C5.60326 5.98839 5.5313 6 5.45455 6C5.37779 6 5.30583 5.98839 5.23867 5.96516C5.1715 5.9423 5.10914 5.90323 5.05157 5.84793L0.201487 1.18894C0.0671621 1.05991 -2.22989e-07 0.898617 -2.31449e-07 0.705069C-2.39909e-07 0.51152 0.0719594 0.345622 0.215879 0.207373C0.359798 0.0691242 0.527704 -4.99904e-07 0.719597 -5.08292e-07C0.911489 -5.1668e-07 1.0794 0.0691242 1.22331 0.207373L5.45454 4.27189L9.68578 0.207373C9.8201 0.0783406 9.98551 0.013824 10.182 0.013824C10.3789 0.013824 10.5493 0.0829482 10.6932 0.221197C10.8371 0.359446 10.9091 0.520736 10.9091 0.705068C10.9091 0.8894 10.8371 1.05069 10.6932 1.18894Z" fill="#333333" />
                        </svg>
                    </span>
                </div>
            </div>
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