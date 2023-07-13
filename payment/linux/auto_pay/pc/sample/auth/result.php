<?
/* ============================================================================== */
/* =   PAGE : 결과 처리 PAGE                                                    = */
/* ============================================================================== */
/* =   결제 요청 결과값을 출력하는 페이지입니다.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.              =*/
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do                    = */
/* ============================================================================== */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* = -------------------------------------------------------------------------- = */

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
/* =   01. 인증 결과                                                            = */
/* = -------------------------------------------------------------------------- = */
$res_cd      = $_POST["res_cd"];                // 결과 코드
$res_msg     = convertEncode($_POST["res_msg"]);                // 결과 메시지
/* = -------------------------------------------------------------------------- = */
$ordr_idxx   = $_POST["ordr_idxx"];                // 주문번호
$buyr_name   = convertEncode($_POST["buyr_name"]);                // 요청자 이름
$card_cd     = $_POST["card_cd"];                // 카드 코드
$batch_key   = $_POST["batch_key"];                // 배치 인증키
/* ============================================================================== */

$card_mask_no   = $_POST["card_mask_no"];                // 카드 번호

/* ============================================================================== */
/* =   02. 결과페이지 폼 구성                                                   = */
/* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http:'www.w3.org/1999/xhtml">

<head>
    <title>*** KCP Payment System ***</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
    <script>
        function sendResult() {
            document.resultForm.submit();
        }
    </script>
</head>

<body onload="sendResult();">
    <form name="resultForm" method="post" action="/m/mine/payment/result_proc.php">
        <input type="hidden" name="res_cd" value="<?= $res_cd ?>">
        <input type="hidden" name="res_msg" value="<?= $res_msg ?>">
        <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>">
        <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
        <input type="hidden" name="card_name" value="">
        <input type="hidden" name="batch_key" value="<?= $batch_key ?>">
        <input type="hidden" name="str_userid" value="">
        <input type="hidden" name="card_mask_no" value="<?= $card_mask_no ?>">
    </form>
</body>

</html>