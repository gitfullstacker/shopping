<?
/* ============================================================================== */
/* =   PAGE : 결제 결과 출력 PAGE                                               = */
/* = -------------------------------------------------------------------------- = */
/* =   결제 요청 결과값을 출력하는 페이지입니다.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2016   NHN KCP Inc.   All Rights Reserverd.               = */
/* ============================================================================== */
function convertEncode($string)
{
    if (mb_detect_encoding($string, 'EUC-KR', true) !== false) {
        return iconv('EUC-KR', 'UTF-8', $string);
    } else {
        return $string;
    }
}
?>

<?
// 지불 정보
$site_cd          = $_POST["site_cd"];      // 사이트 코드
$req_tx           = $_POST["req_tx"];      // 요청 구분(승인/취소)
$use_pay_method   = $_POST["use_pay_method"];      // 사용 결제 수단
$bSucc            = $_POST["bSucc"];      // 업체 DB 정상처리 완료 여부
// 주문 정보
$amount           = $_POST["amount"];      // KCP 실제 거래 금액
$tno              = $_POST["tno"];      // KCP 거래번호
$ordr_idxx        = $_POST["ordr_idxx"];      // 주문번호
$good_name        = $_POST["good_name"];      // 상품명
$buyr_name        = $_POST["buyr_name"];      // 구매자명
$buyr_tel1        = $_POST["buyr_tel1"];      // 구매자 전화번호
$buyr_tel2        = $_POST["buyr_tel2"];      // 구매자 휴대폰번호
$buyr_mail        = $_POST["buyr_mail"];      // 구매자 E-Mail
// 결과 코드
$res_cd           = $_POST["res_cd"];      // 결과 코드
$res_msg          = convertEncode($_POST["res_msg"]);      // 결과 메시지
$res_msg_bsucc    = "";
// 공통
$app_time         = $_POST["app_time"];      // 승인시간 (공통)
$pnt_issue        = $_POST["pnt_issue"];      // 포인트 서비스사
// 신용카드
$card_cd          = $_POST["card_cd"];      // 카드 코드
$card_name        = convertEncode($_POST["card_name"]);      // 카드명
$app_no           = $_POST["app_no"];      // 승인번호
$noinf            = $_POST["noinf"];      // 무이자 여부
$quota            = $_POST["quota"];      // 할부개월
$partcanc_yn      = $_POST["partcanc_yn"];      // 부분취소 여부
// 계좌이체
$bank_name        = $_POST["bank_name"];      // 은행명
$bank_code        = $_POST["bank_code"];      // 은행코드
// 가상계좌
$bankname         = $_POST["bankname"];      // 입금할 은행
$depositor        = $_POST["depositor"];      // 입금할 계좌 예금주
$account          = $_POST["account"];      // 입금할 계좌 번호
$va_date          = $_POST["va_date"];      // 입금마감시간
// 포인트
$add_pnt          = $_POST["add_pnt"];      // 발생 포인트
$use_pnt          = $_POST["use_pnt"];      // 사용가능 포인트
$rsv_pnt          = $_POST["rsv_pnt"];      // 적립 포인트
$pnt_app_time     = $_POST["pnt_app_time"];      // 승인시간
$pnt_app_no       = $_POST["pnt_app_no"];      // 승인번호
$pnt_amount       = $_POST["pnt_amount"];      // 적립금액 or 사용금액
// 휴대폰
$commid           = $_POST["commid"];      // 통신사 코드
$mobile_no        = $_POST["mobile_no"];      // 휴대폰 번호
// 상품권
$tk_van_code      = $_POST["tk_van_code"];      // 발급사 코드
$tk_app_no        = $_POST["tk_app_no"];      // 승인 번호
// 현금영수증
$cash_yn          = $_POST["cash_yn"];      // 현금 영수증 등록 여부
$cash_authno      = $_POST["cash_authno"];      // 현금 영수증 승인 번호
$cash_tr_code     = $_POST["cash_tr_code"];      // 현금 영수증 발행 구분
$cash_id_info     = $_POST["cash_id_info"];      // 현금 영수증 등록 번호
$cash_no          = $_POST["cash_no"];      //현금영수증 거래 번호 

/* 기타 파라메터 추가 부분 - Start - */
$param_opt_1     = $_POST["param_opt_1"];      // 기타 파라메터 추가 부분
$param_opt_2     = $_POST["param_opt_2"];      // 기타 파라메터 추가 부분
$param_opt_3     = $_POST["param_opt_3"];      // 기타 파라메터 추가 부분
/* 기타 파라메터 추가 부분 - End -   */

$req_tx_name     = "";

if ($req_tx == "pay") {
    $req_tx_name = "지불";
} else if ($req_tx == "mod") {
    $req_tx_name = "취소/매입";
}

/* ============================================================================== */
/* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정                           = */
/* = -------------------------------------------------------------------------- = */

if ($req_tx == "pay") {
    // 업체 DB 처리 실패
    if ($bSucc == "false") {
        if ($res_cd == "0000") {
            $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 쇼핑몰에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 쇼핑몰로 전화하여 확인하시기 바랍니다.";
        } else {
            $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 쇼핑몰에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 쇼핑몰로 전화하여 확인하시기 바랍니다";
        }
    }
}

/* = -------------------------------------------------------------------------- = */
/* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정 끝                        = */
/* ============================================================================== */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>가맹점 결제 샘플페이지</title>

    <!-- 공통: font preload -->
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Regular.woff" type="font/woff" as="font" crossorigin>
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Medium.woff" type="font/woff" as="font" crossorigin>
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Bold.woff" type="font/woff" as="font" crossorigin>
    <!-- //공통: font preload -->

    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <link href="../static/css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
    <script type="text/javascript">
        /* 신용카드 영수증 */
        /* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
        /* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
        function receiptView(tno, ordr_idxx, amount) {
            receiptWin = "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=";
            receiptWin += tno + "&";
            receiptWin += "order_no=" + ordr_idxx + "&";
            receiptWin += "trade_mony=" + amount;

            window.open(receiptWin, "", "width=455, height=815");
        }

        /* 현금 영수증 */
        /* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do" */
        /* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do" */
        function receiptView2(cash_no, ordr_idxx, amount) {
            receiptWin2 = "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=cash_bill&cash_no=";
            receiptWin2 += cash_no + "&";
            receiptWin2 += "order_id=" + ordr_idxx + "&";
            receiptWin2 += "trade_mony=" + amount;

            window.open(receiptWin2, "", "width=370, height=625");
        }

        /* 가상 계좌 모의입금 페이지 호출 */
        /* 테스트시에만 사용가능 */
        /* 실결제시 해당 스크립트 주석처리 */
        function receiptView3() {
            receiptWin3 = "http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti.jsp";
            window.open(receiptWin3, "", "width=520, height=300");
        }

        function sendResult() {
            document.resultForm.submit();
        }
    </script>
</head>

<body onload="sendResult();">
    <form name="resultForm" method="post" action="/m/pay/result_proc.php">
        <input type="hidden" name="res_cd" value="<?= $res_cd ?>">
        <input type="hidden" name="res_msg" value="<?= $res_msg ?>">
        <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
        <input type="hidden" name="card_name" value="<?= $card_name ?>">
    </form>
</body>

</html>