<?
/* ============================================================================== */
/* =   PAGE : 결제 결과 출력 PAGE                                               = */
/* = -------------------------------------------------------------------------- = */
/* =   결제 요청 결과값을 출력하는 페이지입니다.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do 			        = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2023   NHN KCP Inc.   All Rights Reserverd.                   = */
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
/* =   환경 설정 파일 Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   ※ 필수                                                                  = */
/* =   테스트 및 실결제 연동시 site_conf_inc.php 파일을 수정하시기 바랍니다.    = */
/* = -------------------------------------------------------------------------- = */

include "../cfg/site_conf_inc.php";       // 환경설정 파일 include

/* = -------------------------------------------------------------------------- = */
/* =   환경 설정 파일 Include END                                               = */
/* ============================================================================== */
?>
<?
/* ============================================================================== */
/* =   지불 결과                                                                = */
/* = -------------------------------------------------------------------------- = */
// 결과 코드
$res_cd           = $_POST["res_cd"];      // 결과 코드
$res_msg          = convertEncode($_POST["res_msg"]);      // 결과 메시지
/* = -------------------------------------------------------------------------- = */
// 주문 정보
$ordr_idxx        = $_POST["ordr_idxx"];      // 주문번호
$good_name        = convertEncode($_POST["good_name"]);      // 상품명
$good_mny         = $_POST["good_mny"];      // 결제 금액
$buyr_name        = convertEncode($_POST["buyr_name"]);      // 구매자명
/* = -------------------------------------------------------------------------- = */
// 신용카드
$card_cd          = $_POST["card_cd"];      // 카드 코드
$card_name        = convertEncode($_POST["card_name"]);      // 카드명
$batch_key        = $_POST["batch_key"];      // 배치 인증키
/* = -------------------------------------------------------------------------- = */
/* 기타 파라메터 추가 부분 - Start - */
$param_opt_1     = $_POST["param_opt_1"];       // 기타 파라메터 추가 부분
$param_opt_2     = $_POST["param_opt_2"];       // 기타 파라메터 추가 부분
$param_opt_3     = $_POST["param_opt_3"];       // 기타 파라메터 추가 부분
/* 기타 파라메터 추가 부분 - End -   */
/* ============================================================================== */


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>*** NHN KCP [AX-HUB Version] ***</title>
  <meta name="viewport" content="width=device-width, user-scalable=1.0, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
  <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
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

    if (isMobile.any())
      document.getElementById("cssLink").setAttribute("href", controlCss);

    function sendResult() {
      document.resultForm.submit();
    }
  </script>
</head>

<body onload="sendResult();">
  <form name="resultForm" method="post" action="<?= $_SERVER['DOCUMENT_ROOT'] ?>/m/mine/payment/result_proc.php">
    <input type="hidden" name="res_cd" value="<?= $res_cd ?>">
    <input type="hidden" name="res_msg" value="<?= $res_msg ?>">
    <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>">
    <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
    <input type="hidden" name="card_name" value="<?= $card_name ?>">
    <input type="hidden" name="batch_key" value="<?= $batch_key ?>">
    <input type="hidden" name="str_userid" value="<?= $param_opt_1 ?>">
  </form>
</body>

</html>