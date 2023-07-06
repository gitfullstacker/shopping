<?
/* ============================================================================== */
/* =   PAGE : 결과 처리 PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   결제 요청 결과값을 출력하는 페이지입니다.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
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
/* ============================================================================== */
/* =   지불 결과                                                                = */
/* = -------------------------------------------------------------------------- = */
$req_tx           = $_POST["req_tx"];      // 요청 구분(승인/취소)
$pay_method       = $_POST["pay_method"];      // 사용 결제 수단
$bSucc            = $_POST["bSucc"];      // 업체 DB 정상처리 완료 여부
/* = -------------------------------------------------------------------------- = */
$res_cd           = $_POST["res_cd"];      // 결과 코드
$res_msg          = convertEncode($_POST["res_msg"]);      // 결과 메시지
$res_msg_bsucc    = "";
$amount           = $_POST["amount"];      // 총금액
$panc_mod_mny     = $_POST["panc_mod_mny"];      // 부분취소 요청금액
$panc_rem_mny     = $_POST["panc_rem_mny"];      // 부분취소 가능금액
$mod_type         = $_POST["mod_type"];
/* = -------------------------------------------------------------------------- = */
$ordr_idxx        = $_POST["ordr_idxx"];      // 주문번호
$tno              = $_POST["tno"];      // KCP 거래번호
$good_mny         = $_POST["good_mny"];      // 결제 금액
$good_name        = convertEncode($_POST["good_name"]);      // 상품명
$buyr_name        = convertEncode($_POST["buyr_name"]);      // 구매자명
$buyr_tel1        = $_POST["buyr_tel1"];      // 구매자 전화번호
$buyr_tel2        = $_POST["buyr_tel2"];      // 구매자 휴대폰번호
$buyr_mail        = $_POST["buyr_mail"];      // 구매자 E-Mail
/* = -------------------------------------------------------------------------- = */
// 신용카드
$card_cd          = $_POST["card_cd"];      // 카드 코드
$card_no          = $_POST["card_no"];      // 카드 번호
$card_name        = convertEncode($_POST["card_name"]);      // 카드명
$app_time         = $_POST["app_time"];      // 승인시간 (공통)
$app_no           = $_POST["app_no"];      // 승인번호
$quota            = $_POST["quota"];      // 할부개월
$noinf            = $_POST["noinf"];      // 무이자여부
/* = -------------------------------------------------------------------------- = */

/* ============================================================================== */
/* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정                           = */
/* = -------------------------------------------------------------------------- = */

if ($req_tx == "pay") {
  //업체 DB 처리 실패
  if ($bSucc == "false") {
    if ($res_cd == "0000") {
      $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 쇼핑몰로 문의하여주시기 바랍니다.";
    } else {
      $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 쇼핑몰로 문의하여주시기 바랍니다.";
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript">
    // 신용카드 영수증 연동 스크립트
    function receiptView(tno) {
      receiptWin = "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" + tno;
      // 실결제시 "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" 적용
      window.open(receiptWin, "", "width=460, height=820");
    }

    function sendResult() {
      document.resultForm.submit();
    }
  </script>
</head>

<body onload="sendResult();">
  <?php
  if ($_POST["good_name"] == '구독멤버십' || $_POST["good_name"] == '렌트멥버십') {
    $action_url = '/m/mine/membership/result_proc.php';
  } else {
    $action_url = '/m/pay/result_proc.php';
  }
  ?>
  <form name="resultForm" method="post" action="<?= $action_url ?>">
    <input type="hidden" name="res_cd" value="<?= $res_cd ?>">
    <input type="hidden" name="res_msg" value="<?= $res_msg ?>">
    <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>">
    <input type="hidden" name="good_mny" value="<?= $good_mny ?>">
    <input type="hidden" name="good_name" value="<?= $good_name ?>">
    <input type="hidden" name="buyr_name" value="<?= $buyr_name ?>">
    <input type="hidden" name="buyr_mail" value="<?= $buyr_mail ?>">
    <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
    <input type="hidden" name="card_name" value="<?= $card_name ?>">
  </form>
</body>

</html>