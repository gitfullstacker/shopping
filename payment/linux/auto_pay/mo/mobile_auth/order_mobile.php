<?
/* ============================================================================== */
/* =   PAGE : 결제 요청 PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   이 페이지는 Payplus Plug-in을 통해서 결제자가 결제 요청을 하는 페이지    = */
/* =   입니다. 아래의 ※ 필수, ※ 옵션 부분과 매뉴얼을 참조하셔서 연동을        = */
/* =   진행하여 주시기 바랍니다.                                                = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do			        = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* ============================================================================== */
?>
<?
/* ============================================================================== */
/* =   환경 설정 파일 Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   ※ 필수                                                                  = */
/* =   테스트 및 실결제 연동시 site_conf_inc.php 파일을 수정하시기 바랍니다.    = */
/* = -------------------------------------------------------------------------- = */

include "../cfg/site_conf_inc.php";       // 환경설정 파일 include

?>
<?
/* = -------------------------------------------------------------------------- = */
/* =   환경 설정 파일 Include END                                               = */
/* ============================================================================== */
?>
<?
/* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
$req_tx          = $_POST["req_tx"]; // 요청 종류         
$res_cd          = $_POST["res_cd"]; // 응답 코드         
$tran_cd         = $_POST["tran_cd"]; // 트랜잭션 코드     
$ordr_idxx       = $_POST["ordr_idxx"]; // 쇼핑몰 주문번호   
$good_name       = $_POST["good_name"]; // 상품명            
$good_mny        = $_POST["good_mny"]; // 결제 총금액       
$buyr_name       = $_POST["buyr_name"]; // 주문자명          
$buyr_tel1       = $_POST["buyr_tel1"]; // 주문자 전화번호   
$buyr_tel2       = $_POST["buyr_tel2"]; // 주문자 핸드폰 번호
$buyr_mail       = $_POST["buyr_mail"]; // 주문자 E-mail 주소
$use_pay_method  = $_POST["use_pay_method"]; // 결제 방법  
$enc_info        = $_POST["enc_info"]; // 암호화 정보       
$enc_data        = $_POST["enc_data"]; // 암호화 데이터     
$card_mask_no    = $_POST["card_mask_no"]; // 카드번호

/* 기타 파라메터 추가 부분 - Start - */
$param_opt_1    = $_POST["param_opt_1"]; // 기타 파라메터 추가 부분
$param_opt_2    = $_POST["param_opt_2"]; // 기타 파라메터 추가 부분
$param_opt_3    = $_POST["param_opt_3"]; // 기타 파라메터 추가 부분
/* 기타 파라메터 추가 부분 - End -   */

$tablet_size     = "1.0"; // 화면 사이즈 고정
$url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

function convertEncode($string)
{
    if (mb_detect_encoding($string, 'UTF-8', true) !== false) {
        return iconv('UTF-8', 'EUC-KR', $string);
    } else {
        return $string;
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">

<head>
    <title>*** KCP [AX-HUB Version] ***</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <meta http-equiv="Cache-Control" content="No-Cache">
    <meta http-equiv="Pragma" content="No-Cache">

    <meta name="viewport" content="width=device-width, user-scalable=<?= $tablet_size ?>, initial-scale=<?= $tablet_size ?>, maximum-scale=<?= $tablet_size ?>, minimum-scale=<?= $tablet_size ?>">

    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

    <!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
    <script type="text/javascript" src="js/approval_key.js"></script>

    <script type="text/javascript">
        var controlCss = "css/style_mobile.css";
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        if (isMobile.any()) {
            document.getElementById("cssLink").setAttribute("href", controlCss);
        }
    </script>
    <script type="text/javascript">
        /* 주문번호 생성 예제 */
        function init_orderid() {
            var today = new Date();
            var year = today.getFullYear();
            var month = today.getMonth() + 1;
            var date = today.getDate();
            var time = today.getTime();

            if (parseInt(month) < 10) {
                month = "0" + month;
            }

            if (parseInt(date) < 10) {
                date = "0" + date;
            }

            var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

            document.order_info.ordr_idxx.value = order_idxx;
        }

        /* kcp web 결제창 호츨 (변경불가) */
        function call_pay_form() {
            var v_frm = document.order_info;

            v_frm.action = PayUrl;

            if (v_frm.Ret_URL.value == "") {
                /* Ret_URL값은 현 페이지의 URL 입니다. */
                alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
                return false;
            } else {
                v_frm.submit();
            }
        }

        /* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
        function chk_pay() {
            self.name = "tar_opener";
            var pay_form = document.pay_form;

            if (pay_form.res_cd.value == "3001" || pay_form.res_cd.value == "9999") {
                alert("사용자가 취소하였습니다.");
                window.location.href = "/m/mine/payment/index.php";
                return;
            }

            if (pay_form.enc_info.value) {
                console.log(pay_form.card_mask_no);
                // pay_form.submit();
                return;
            }

            kcp_AJAX();
        }
    </script>
</head>

<body onload="init_orderid();chk_pay();">
    <div id="sample_wrap">
        <form name="order_info" method="post" style="display: none;">
            <!-- 타이틀 -->
            <h1>[결제요청] <span>이 페이지는 결제를 요청하는 샘플(예시) 페이지입니다.</span></h1>

            <div class="sample">

                <!-- 상단 문구 -->
                <p>
                    이 페이지는 결제를 요청하는 페이지입니다
                </p>

                <!-- 주문 정보 -->
                <h2>&sdot; 주문 정보</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>주문 번호</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value=""></td>
                    </tr>
                    <tr>
                        <th>상품명</th>
                        <td><input type="text" name="good_name" class="w100" value="<?= convertEncode($_POST['good_name']) ?>"></td>
                    </tr>
                    <tr>
                        <th>결제 금액</th>
                        <td><input type="text" name="good_mny" class="w100" value="<?= $_POST['good_mny'] ?: '0' ?>"></td>
                    </tr>
                    <tr>
                        <th>주문자명</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>"></td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td><input type="text" name="buyr_mail" class="w200" value="<?= $_POST['buyr_mail'] ?: '' ?>"></td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><input type="text" name="buyr_tel1" class="w100" value="<?= $_POST['buyr_tel1'] ?: '' ?>"></td>
                    </tr>
                    <tr>
                        <th>휴대폰번호</th>
                        <td><input type="text" name="buyr_tel2" class="w100" value="<?= $_REQUEST['buyr_tel2'] ?: '' ?>"></td>
                    </tr>

                    <!-- 배치 인증키생성 그룹아이디(리얼테스트시 실제 업체의 그룹아이디 입력) -->
                    <tr>
                        <th>그룹아이디</th>
                        <td><input type="text" name="kcp_group_id" class="w100" value="A52Q71000489"></td>
                    </tr>
                </table>

                <!-- 결제 요청/처음으로 이미지 -->
                <div class="footer">
                    <b>※ PC에서 결제요청시 오류가 발생합니다. ※</b>
                </div>
                <div class="btnset" id="display_pay_button" style="display:block">
                    <input name="" type="button" class="submit" value="결제요청" onclick="kcp_AJAX();">
                    <a href="../index.html" class="home">처음으로</a>
                </div>
            </div>
            <!--footer-->
            <div class="footer">
                Copyright (c) KCP INC. All Rights reserved.
            </div>
            <!--//footer-->

            <!-- 공통정보 -->
            <input type="hidden" name="req_tx" value="pay"> <!-- 요청 구분 -->
            <input type="hidden" name="shop_name" value="<?= $g_conf_site_name ?>"> <!-- 사이트 이름 -->
            <input type="hidden" name="site_cd" value="<?= $g_conf_site_cd   ?>"> <!-- 사이트 키 -->
            <input type="hidden" name="currency" value="410" /> <!-- 통화 코드 -->
            <input type="hidden" name="eng_flag" value="N" /> <!-- 한 / 영 -->

            <!-- 결제등록 키 -->
            <input type="hidden" name="approval_key" id="approval">
            <!-- 인증시 필요한 파라미터(변경불가)-->
            <input type="hidden" name="escw_used" value="N">
            <input type="hidden" name="pay_method" value="AUTH">
            <input type="hidden" name="ActionResult" value="batch">
            <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
            <input type="hidden" name="Ret_URL" value="<?= $url ?>">
            <!-- 화면 크기조정 -->
            <input type="hidden" name="tablet_size" value="<?= $tablet_size ?>">

            <!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
            <input type="hidden" name="param_opt_1" value="<?= $_POST['str_userid'] ?: '' ?>">
            <input type="hidden" name="param_opt_2" value="">
            <input type="hidden" name="param_opt_3" value="">

            <!-- 결제 정보 등록시 응답 타입 ( 필드가 없거나 값이 '' 일경우 TEXT, 값이 XML 또는 JSON 지원 -->
            <input type="hidden" name="response_type" value="TEXT" />
            <input type="hidden" name="PayUrl" id="PayUrl" value="" />
            <input type="hidden" name="traceNo" id="traceNo" value="" />
        </form>
    </div>

    <form name="pay_form" method="post" action="pp_cli_hub.php">
        <input type="hidden" name="req_tx" value="<?= $req_tx ?>"> <!-- 요청 구분          -->
        <input type="hidden" name="res_cd" value="<?= $res_cd ?>"> <!-- 결과 코드          -->
        <input type="hidden" name="tran_cd" value="<?= $tran_cd ?>"> <!-- 트랜잭션 코드      -->
        <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>"> <!-- 주문번호           -->
        <input type="hidden" name="good_mny" value="<?= $good_mny ?>"> <!-- 휴대폰 결제금액    -->
        <input type="hidden" name="good_name" value="<?= $good_name ?>"> <!-- 상품명             -->
        <input type="hidden" name="buyr_name" value="<?= $buyr_name ?>"> <!-- 주문자명           -->
        <input type="hidden" name="buyr_tel1" value="<?= $buyr_tel1 ?>"> <!-- 주문자 전화번호    -->
        <input type="hidden" name="buyr_tel2" value="<?= $buyr_tel2 ?>"> <!-- 주문자 휴대폰번호  -->
        <input type="hidden" name="buyr_mail" value="<?= $buyr_mail ?>"> <!-- 주문자 E-mail      -->
        <input type="hidden" name="enc_info" value="<?= $enc_info ?>">
        <input type="hidden" name="enc_data" value="<?= $enc_data ?>">
        <input type="hidden" name="use_pay_method" value="<?= $use_pay_method ?>">

        <!-- 추가 파라미터 -->
        <input type="hidden" name="param_opt_1" value="<?= $param_opt_1 ?>">
        <input type="hidden" name="param_opt_2" value="<?= $param_opt_2 ?>">
        <input type="hidden" name="param_opt_3" value="<?= $param_opt_3 ?>">

        <!-- 배치키 발급시 카드번호 리턴 여부 설정 -->
        <!-- Y : 1234-4567-****-8910 형식, L : 8910 형식(카드번호 끝 4자리) -->
        <input type='hidden' name='batch_cardno_return_yn' value='Y'>

        <!-- batch_cardno_return_yn 설정시 결제창에서 리턴 -->
        <input type='hidden' name='card_mask_no' value='<?= $card_mask_no ?>'>
    </form>
</body>

</html>