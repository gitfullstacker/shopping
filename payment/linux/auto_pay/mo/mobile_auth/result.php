<?
/* ============================================================================== */
/* =   PAGE : ���� ��� ��� PAGE                                               = */
/* = -------------------------------------------------------------------------- = */
/* =   ���� ��û ������� ����ϴ� �������Դϴ�.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : https://kcp.co.kr/technique.requestcode.do 			        = */
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
/* =   ȯ�� ���� ���� Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   �� �ʼ�                                                                  = */
/* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php ������ �����Ͻñ� �ٶ��ϴ�.    = */
/* = -------------------------------------------------------------------------- = */

include "../cfg/site_conf_inc.php";       // ȯ�漳�� ���� include

/* = -------------------------------------------------------------------------- = */
/* =   ȯ�� ���� ���� Include END                                               = */
/* ============================================================================== */
?>
<?
/* ============================================================================== */
/* =   ���� ���                                                                = */
/* = -------------------------------------------------------------------------- = */
// ��� �ڵ�
$res_cd           = $_POST["res_cd"];      // ��� �ڵ�
$res_msg          = convertEncode($_POST["res_msg"]);      // ��� �޽���
/* = -------------------------------------------------------------------------- = */
// �ֹ� ����
$ordr_idxx        = $_POST["ordr_idxx"];      // �ֹ���ȣ
$good_name        = convertEncode($_POST["good_name"]);      // ��ǰ��
$good_mny         = $_POST["good_mny"];      // ���� �ݾ�
$buyr_name        = convertEncode($_POST["buyr_name"]);      // �����ڸ�
/* = -------------------------------------------------------------------------- = */
// �ſ�ī��
$card_cd          = $_POST["card_cd"];      // ī�� �ڵ�
$card_name        = convertEncode($_POST["card_name"]);      // ī���
$batch_key        = $_POST["batch_key"];      // ��ġ ����Ű
/* = -------------------------------------------------------------------------- = */
/* ��Ÿ �Ķ���� �߰� �κ� - Start - */
$param_opt_1     = $_POST["param_opt_1"];       // ��Ÿ �Ķ���� �߰� �κ�
$param_opt_2     = $_POST["param_opt_2"];       // ��Ÿ �Ķ���� �߰� �κ�
$param_opt_3     = $_POST["param_opt_3"];       // ��Ÿ �Ķ���� �߰� �κ�
/* ��Ÿ �Ķ���� �߰� �κ� - End -   */
/* ============================================================================== */

$card_mask_no        = $_POST["card_mask_no"];      // ī�� ��ȣ
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
  <form name="resultForm" method="post" action="/m/mine/payment/result_proc.php">
    <input type="hidden" name="res_cd" value="<?= $res_cd ?>">
    <input type="hidden" name="res_msg" value="<?= $res_msg ?>">
    <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>">
    <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
    <input type="hidden" name="card_name" value="<?= $card_name ?>">
    <input type="hidden" name="batch_key" value="<?= $batch_key ?>">
    <input type="hidden" name="str_userid" value="<?= $param_opt_1 ?>">
    <input type="hidden" name="card_mask_no" value="<?= $card_mask_no ?>">
  </form>
</body>

</html>