<?
/* ============================================================================== */
/* =   PAGE : 결제 요청 PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   이 페이지는 상품권 정보 입력 및 주문 정보를 입력하는 페이지 입니다.      = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>*** KCP Online Payment System [JSP Version] ***</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
    <script type="text/javascript">
        // 주문번호 생성 예제
        function init_orderid() {
            var today = new Date();
            var year = today.getFullYear();
            var month = today.getMonth() + 1;
            var date = today.getDate();
            var time = today.getTime();

            if (parseInt(month) < 10) {
                month = "0" + month;
            }

            var vOrderID = year + "" + month + "" + date + "" + time;

            document.forms[0].ordr_idxx.value = vOrderID;

            document.forms.form_order.submit();
        }

        function jsf__pay(form) {
            if (jsf__chk(form) == true) {
                return true;
            } else {
                return false;
            }
        }

        function jsf__chk(form) {
            if (form.batch_key.value.length != 16) {
                alert("인증키 값을 정확히 입력해 주시기 바랍니다.");
                form.batch_key.focus();
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<?php
function convertEncode($string)
{
    if (mb_detect_encoding($string, 'UTF-8', true) !== false) {
        return iconv('UTF-8', 'EUC-KR', $string);
    } else {
        return $string;
    }
}
?>

<body onload="javascript:document.forms.form_order.submit();">

    <div id="sample_wrap">

        <form name="form_order" method="post" action="./pp_cli_hub.php" style="display: none;">

            <h1>[신용카드 정기과금 결제요청] <span> 신용카드 정기과금 결제요청 샘플 페이지</span></h1>
            <!-- 상단 문구 -->
            <div class="sample">
                <p>이 페이지는 요청자의 인증키를 입력하여 신용카드 결제 요청을하는 페이지입니다.</br><br>
                    결제 요청 할 인증키가 다수인 경우 해당 모듈에 설정하는 인증 키 값을 사용자에 맞게 금액과 할부를 설정하여주시기 바랍니다.</p>
                <!-- 상단 테이블 End -->

                <!-- 주문정보 타이틀 -->
                <h2>&sdot; 주문 정보</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 지불 방법 -->
                    <tr>
                        <th>지불 방법</th>
                        <td><input type="text" name="pay_method" value="CARD" size="13" class="w100" readonly /></td>
                    </tr>
                    <!-- 주문 번호 -->
                    <tr>
                        <th>주문 번호</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value="<?= $_POST['ordr_idxx'] ?>" maxlength="40" /></td>
                    </tr>
                    <!-- 상품명 -->
                    <tr>
                        <th>상품명</th>
                        <td><input type="text" name="good_name" class="w100" value="<?= convertEncode($_POST['good_name']) ?>" /></td>
                    </tr>
                    <!-- 결제 금액 -->
                    <tr>
                        <th>결제 금액</th>
                        <td><input type="text" name="good_mny" class="w100" value="<?= $_POST['good_mny'] ?: '0' ?>" maxlength="9" />원(숫자만 입력)</td>
                    </tr>
                    <!-- 주문자 이름 -->
                    <tr>
                        <th>주문자명</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>" /></td>
                    </tr>
                    <!-- 주문자 E-Mail -->
                    <tr>
                        <th>E-mail</th>
                        <td><input type="text" name="buyr_mail" class="w200" value="<?= $_POST['buyr_mail'] ?: '' ?>" maxlength="30" /></td>
                    </tr>
                    <!-- 주문자 전화번호 -->
                    <tr>
                        <th>전화번호</th>
                        <td><input type="text" name="buyr_tel1" class="w100" value="<?= $_POST['buyr_tel1'] ?: '' ?>" /></td>
                    </tr>
                    <!-- 주문자 휴대폰번호 -->
                    <tr>
                        <th>휴대폰번호</th>
                        <td><input type="text" name="buyr_tel2" class="w100" value="<?= $_POST['buyr_tel2'] ?: '' ?>" /></td>
                    </tr>
                </table>
                <!-- 주문 정보 출력 테이블 End -->

                <!-- 정기과금 정보 출력 테이블 Start -->
                <h2>&sdot; 정기과금 정보</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 인증키 -->
                    <tr>
                        <th>인증키</th>
                        <td><input type="text" name="bt_batch_key" value="<?= $_POST['bt_batch_key'] ?: '' ?>" class="w150" /></td>
                    </tr>
                    <!-- 그룹ID S61861000449 -->
                    <tr>
                        <th>그룹ID</th>
                        <td><input type="text" name="bt_group_id" value="A7EPQ1001835" class="w100" /></td>
                    </tr>
                    <!-- 할부개월 -->
                    <tr>
                        <th>할부개월</th>
                        <td><input type="text" name="quotaopt" value="<?= $_POST['quotaopt'] ?: '00' ?>" size="2" maxlength="2" class="w10" /></td>
                    </tr>
                </table>
                <!-- 정기과금 정보 출력 테이블 End -->

                <!-- 결제 버튼 테이블 Start -->
                <div class="btnset">
                    <table align="center" cellspacing="0" cellpadding="0" class="margin_top_20">
                        <tr id="show_pay_btn">
                            <td colspan="2" align="center">
                                <input name="" type="submit" class="submit" value="결제요청" onclick="return jsf__pay(this.form);" alt="결제를 요청합니다" /></a>
                                <a href="../index.html" class="home">처음으로</a>
                </div>
                </td>
                </tr>
                <!-- 결제 진행 중입니다. 메시지 -->
                <tr id="show_progress" style="display:none">
                    <td colspan="2" class="center red">결제 진행 중입니다. 잠시만 기다려 주십시오...</td>
                </tr>
                </table>
            </div>
            <!-- 결제 버튼 테이블 End -->

    </div>
    <div class="footer">
        Copyright (c) KCP INC. All Rights reserved.
    </div>

    <!-- 요청종류 승인(pay)/취소,매입(mod) 요청시 사용 -->
    <input type="hidden" name="req_tx" value="pay" />
    <input type="hidden" name="pay_method" value="CARD" />
    <input type="hidden" name="card_pay_method" value="Batch" />
    <!-- 필수 항목 : 결제 금액/화폐단위 -->
    <input type="hidden" name="currency" value="410" />
    </form>
    </div>
</body>

</html>