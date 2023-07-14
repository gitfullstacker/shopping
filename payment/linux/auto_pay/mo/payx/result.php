<?
/* ============================================================================== */
/* =   PAGE : ��� ó�� PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   ���� ��û ������� ����ϴ� �������Դϴ�.                                = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : https://kcp.co.kr/technique.requestcode.do                    = */
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
/* =   ���� ���                                                                = */
/* = -------------------------------------------------------------------------- = */
$req_tx           = $_POST["req_tx"];      // ��û ����(����/���)
$pay_method       = $_POST["pay_method"];      // ��� ���� ����
$bSucc            = $_POST["bSucc"];      // ��ü DB ����ó�� �Ϸ� ����
/* = -------------------------------------------------------------------------- = */
$res_cd           = $_POST["res_cd"];      // ��� �ڵ�
$res_msg          = convertEncode($_POST["res_msg"]);      // ��� �޽���
$res_msg_bsucc    = "";
$amount           = $_POST["amount"];      // �ѱݾ�
$panc_mod_mny     = $_POST["panc_mod_mny"];      // �κ���� ��û�ݾ�
$panc_rem_mny     = $_POST["panc_rem_mny"];      // �κ���� ���ɱݾ�
$mod_type         = $_POST["mod_type"];
/* = -------------------------------------------------------------------------- = */
$ordr_idxx        = $_POST["ordr_idxx"];      // �ֹ���ȣ
$tno              = $_POST["tno"];      // KCP �ŷ���ȣ
$good_mny         = $_POST["good_mny"];      // ���� �ݾ�
$good_name        = convertEncode($_POST["good_name"]);      // ��ǰ��
$buyr_name        = convertEncode($_POST["buyr_name"]);      // �����ڸ�
$buyr_tel1        = $_POST["buyr_tel1"];      // ������ ��ȭ��ȣ
$buyr_tel2        = $_POST["buyr_tel2"];      // ������ �޴�����ȣ
$buyr_mail        = $_POST["buyr_mail"];      // ������ E-Mail
/* = -------------------------------------------------------------------------- = */
// �ſ�ī��
$card_cd          = $_POST["card_cd"];      // ī�� �ڵ�
$card_no          = $_POST["card_no"];      // ī�� ��ȣ
$card_name        = convertEncode($_POST["card_name"]);      // ī���
$app_time         = $_POST["app_time"];      // ���νð� (����)
$app_no           = $_POST["app_no"];      // ���ι�ȣ
$quota            = $_POST["quota"];      // �Һΰ���
$noinf            = $_POST["noinf"];      // �����ڿ���
/* = -------------------------------------------------------------------------- = */

/* ============================================================================== */
/* =   ������ �� DB ó�� ���н� �� ��� �޽��� ����                           = */
/* = -------------------------------------------------------------------------- = */

if ($req_tx == "pay") {
  //��ü DB ó�� ����
  if ($bSucc == "false") {
    if ($res_cd == "0000") {
      $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ����ϴ�. <br> ���θ��� �����Ͽ��ֽñ� �ٶ��ϴ�.";
    } else {
      $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ�����, <br> <b>��Ұ� ���� �Ǿ����ϴ�.</b><br> ���θ��� �����Ͽ��ֽñ� �ٶ��ϴ�.";
    }
  }
}

/* = -------------------------------------------------------------------------- = */
/* =   ������ �� DB ó�� ���н� �� ��� �޽��� ���� ��                        = */
/* ============================================================================== */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript">
    // �ſ�ī�� ������ ���� ��ũ��Ʈ
    function receiptView(tno) {
      receiptWin = "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" + tno;
      // �ǰ����� "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" ����
      window.open(receiptWin, "", "width=460, height=820");
    }

    function sendResult() {
      document.resultForm.submit();
    }
  </script>
</head>

<body onload="sendResult();">
  <?php
  if ($_POST["good_name"] == '���������' || $_POST["good_name"] == '��Ʈ�����') {
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