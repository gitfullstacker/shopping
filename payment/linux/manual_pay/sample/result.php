<?
/* ============================================================================== */
/* =   PAGE : ��� ó�� PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   pp_cli_hub.php ���Ͽ��� ó���� ������� ����ϴ� �������Դϴ�.            = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : http://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
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
$site_cd          = $_POST["site_cd"];      // ����Ʈ�ڵ�
$req_tx           = $_POST["req_tx"];      // ��û ����(����/���)
$use_pay_method   = $_POST["use_pay_method"];      // ��� ���� ����
$bSucc            = $_POST["bSucc"];      // ��ü DB ����ó�� �Ϸ� ����
/* = -------------------------------------------------------------------------- = */
$res_cd           = $_POST["res_cd"];      // ����ڵ�
$res_msg          = convertEncode($_POST["res_msg"]);      // ����޽���
$res_msg_bsucc    = "";
/* = -------------------------------------------------------------------------- = */
$amount           = $_POST["amount"];      // KCP ���� �ŷ� �ݾ�
$ordr_idxx        = $_POST["ordr_idxx"];      // �ֹ���ȣ
$tno              = $_POST["tno"];      // KCP �ŷ���ȣ
$good_name        = $_POST["good_name"];      // ��ǰ��
$buyr_name        = $_POST["buyr_name"];      // �����ڸ�
$buyr_tel1        = $_POST["buyr_tel1"];      // ������ ��ȭ��ȣ
$buyr_tel2        = $_POST["buyr_tel2"];      // ������ �޴�����ȣ
$buyr_mail        = $_POST["buyr_mail"];      // ������ E-Mail
/* = -------------------------------------------------------------------------- = */
// ����
$pnt_issue        = $_POST["pnt_issue"];      // ����Ʈ ���񽺻�
$app_time         = $_POST["app_time"];      // ���νð� (����)
/* = -------------------------------------------------------------------------- = */
// �ſ�ī��
$card_cd          = $_POST["card_cd"];      // ī���ڵ�
$card_name        = convertEncode($_POST["card_name"]);      // ī���
$noinf            = $_POST["noinf"];      // ������ ����
$quota            = $_POST["quota"];      // �Һΰ���
$app_no           = $_POST["app_no"];      // ���ι�ȣ
/* = -------------------------------------------------------------------------- = */
// ������ü
$bank_name        = $_POST["bank_name"];      // �����
$bank_code        = $_POST["bank_code"];      // �����ڵ�
/* = -------------------------------------------------------------------------- = */
// �������
$bankname         = $_POST["bankname"];      // �Ա��� ����
$depositor        = $_POST["depositor"];      // �Ա��� ���� ������
$account          = $_POST["account"];      // �Ա��� ���� ��ȣ
$va_date          = $_POST["va_date"];      // ������� �Աݸ����ð�
/* = -------------------------------------------------------------------------- = */
// ����Ʈ
$add_pnt          = $_POST["add_pnt"];      // �߻� ����Ʈ
$use_pnt          = $_POST["use_pnt"];      // ��밡�� ����Ʈ
$rsv_pnt          = $_POST["rsv_pnt"];      // �� ���� ����Ʈ
$pnt_app_time     = $_POST["pnt_app_time"];      // ���νð�
$pnt_app_no       = $_POST["pnt_app_no"];      // ���ι�ȣ
$pnt_amount       = $_POST["pnt_amount"];      // �����ݾ� or ���ݾ�
/* = -------------------------------------------------------------------------- = */
//��ǰ��
$tk_van_code      = $_POST["tk_van_code"];      // �߱޻� �ڵ�
$tk_app_no        = $_POST["tk_app_no"];      // ���� ��ȣ
/* = -------------------------------------------------------------------------- = */
//�޴���
$commid           = $_POST["commid"];      // ��Ż� �ڵ�
$mobile_no        = $_POST["mobile_no"];      // �޴��� ��ȣ
/* = -------------------------------------------------------------------------- = */
// ���ݿ�����
$cash_yn          = $_POST["cash_yn"];      //���ݿ����� ��� ����
$cash_authno      = $_POST["cash_authno"];      //���ݿ����� ���� ��ȣ
$cash_tr_code     = $_POST["cash_tr_code"];      //���ݿ����� ���� ����
$cash_id_info     = $_POST["cash_id_info"];      //���ݿ����� ��� ��ȣ
$cash_no          = $_POST["cash_no"];      //���ݿ����� �ŷ� ��ȣ    
/* = -------------------------------------------------------------------------- = */

$req_tx_name = "";

if ($req_tx == "pay") {
    $req_tx_name = "����";
} else if ($req_tx == "mod") {
    $req_tx_name = "����/���";
}

/* ============================================================================== */
/* =   ������ �� DB ó�� ���н� �� ��� �޽��� ����                           = */
/* = -------------------------------------------------------------------------- = */

if ($req_tx == "pay") {
    //��ü DB ó�� ����
    if ($bSucc == "false") {
        if ($res_cd == "0000") {
            $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ����ϴ�. <br> ��ü�� �����Ͽ� Ȯ���Ͻñ� �ٶ��ϴ�.";
        } else {
            $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ�����, <br> <b>��Ұ� ���� �Ǿ����ϴ�.</b><br> ��ü�� �����Ͽ� Ȯ���Ͻñ� �ٶ��ϴ�.";
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
    <title>������ ���� ����������</title>

    <!-- ����: font preload -->
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Regular.woff" type="font/woff" as="font" crossorigin>
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Medium.woff" type="font/woff" as="font" crossorigin>
    <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Bold.woff" type="font/woff" as="font" crossorigin>
    <!-- //����: font preload -->

    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <link href="../static/css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
    <script type="text/javascript">
        /* �ſ�ī�� ������ */
        /* �ǰ����� : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
        /* �׽�Ʈ�� : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
        function receiptView(tno, ordr_idxx, amount) {
            receiptWin = "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=";
            receiptWin += tno + "&";
            receiptWin += "order_no=" + ordr_idxx + "&";
            receiptWin += "trade_mony=" + amount;

            window.open(receiptWin, "", "width=455, height=815");
        }

        /* ���� ������ */
        /* �ǰ����� : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do" */
        /* �׽�Ʈ�� : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do" */
        function receiptView2(cash_no, ordr_idxx, amount) {
            receiptWin2 = "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=cash_bill&cash_no=";
            receiptWin2 += cash_no + "&";
            receiptWin2 += "order_id=" + ordr_idxx + "&";
            receiptWin2 += "trade_mony=" + amount;

            window.open(receiptWin2, "", "width=370, height=625");
        }

        /* ���� ���� �����Ա� ������ ȣ�� */
        /* �׽�Ʈ�ÿ��� ��밡�� */
        /* �ǰ����� �ش� ��ũ��Ʈ �ּ�ó�� */
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
        <input type="hidden" name="good_mny" value="<?= $amount ?>">
        <input type="hidden" name="card_cd" value="<?= $card_cd ?>">
        <input type="hidden" name="card_name" value="<?= $card_name ?>">
    </form>
</body>

</html>