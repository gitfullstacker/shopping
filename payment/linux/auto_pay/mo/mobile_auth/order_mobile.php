<?
/* ============================================================================== */
/* =   PAGE : ���� ��û PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   �� �������� Payplus Plug-in�� ���ؼ� �����ڰ� ���� ��û�� �ϴ� ������    = */
/* =   �Դϴ�. �Ʒ��� �� �ʼ�, �� �ɼ� �κа� �Ŵ����� �����ϼż� ������        = */
/* =   �����Ͽ� �ֽñ� �ٶ��ϴ�.                                                = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : https://kcp.co.kr/technique.requestcode.do			        = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* ============================================================================== */
?>
<?
/* ============================================================================== */
/* =   ȯ�� ���� ���� Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   �� �ʼ�                                                                  = */
/* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php ������ �����Ͻñ� �ٶ��ϴ�.    = */
/* = -------------------------------------------------------------------------- = */

include "../cfg/site_conf_inc.php";       // ȯ�漳�� ���� include

?>
<?
/* = -------------------------------------------------------------------------- = */
/* =   ȯ�� ���� ���� Include END                                               = */
/* ============================================================================== */
?>
<?
/* kcp�� ����� kcp �������� ���۵Ǵ� ���� ��û ���� */
$req_tx          = $_POST["req_tx"]; // ��û ����         
$res_cd          = $_POST["res_cd"]; // ���� �ڵ�         
$tran_cd         = $_POST["tran_cd"]; // Ʈ����� �ڵ�     
$ordr_idxx       = $_POST["ordr_idxx"]; // ���θ� �ֹ���ȣ   
$good_name       = $_POST["good_name"]; // ��ǰ��            
$good_mny        = $_POST["good_mny"]; // ���� �ѱݾ�       
$buyr_name       = $_POST["buyr_name"]; // �ֹ��ڸ�          
$buyr_tel1       = $_POST["buyr_tel1"]; // �ֹ��� ��ȭ��ȣ   
$buyr_tel2       = $_POST["buyr_tel2"]; // �ֹ��� �ڵ��� ��ȣ
$buyr_mail       = $_POST["buyr_mail"]; // �ֹ��� E-mail �ּ�
$use_pay_method  = $_POST["use_pay_method"]; // ���� ���  
$enc_info        = $_POST["enc_info"]; // ��ȣȭ ����       
$enc_data        = $_POST["enc_data"]; // ��ȣȭ ������     
$card_mask_no    = $_POST["card_mask_no"]; // ī���ȣ

/* ��Ÿ �Ķ���� �߰� �κ� - Start - */
$param_opt_1    = $_POST["param_opt_1"]; // ��Ÿ �Ķ���� �߰� �κ�
$param_opt_2    = $_POST["param_opt_2"]; // ��Ÿ �Ķ���� �߰� �κ�
$param_opt_3    = $_POST["param_opt_3"]; // ��Ÿ �Ķ���� �߰� �κ�
/* ��Ÿ �Ķ���� �߰� �κ� - End -   */

$tablet_size     = "1.0"; // ȭ�� ������ ����
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

    <!-- �ŷ���� �ϴ� kcp ������ ����� ���� ��ũ��Ʈ-->
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
        /* �ֹ���ȣ ���� ���� */
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

        /* kcp web ����â ȣ�� (����Ұ�) */
        function call_pay_form() {
            var v_frm = document.order_info;

            v_frm.action = PayUrl;

            if (v_frm.Ret_URL.value == "") {
                /* Ret_URL���� �� �������� URL �Դϴ�. */
                alert("������ Ret_URL�� �ݵ�� �����ϼž� �˴ϴ�.");
                return false;
            } else {
                v_frm.submit();
            }
        }

        /* kcp ����� ���� ���� ��ȣȭ ���� üũ �� ���� ��û (����Ұ�) */
        function chk_pay() {
            self.name = "tar_opener";
            var pay_form = document.pay_form;

            if (pay_form.res_cd.value == "3001" || pay_form.res_cd.value == "9999") {
                alert("����ڰ� ����Ͽ����ϴ�.");
                window.location.href = "/m/mine/payment/index.php";
                return;
            }

            if (pay_form.enc_info.value) {
                // console.log(pay_form.card_mask_no);
                pay_form.submit();
                return;
            }

            kcp_AJAX();
        }
    </script>
</head>

<body onload="init_orderid();chk_pay();">
    <div id="sample_wrap">
        <form name="order_info" method="post" style="display: none;">
            <!-- Ÿ��Ʋ -->
            <h1>[������û] <span>�� �������� ������ ��û�ϴ� ����(����) �������Դϴ�.</span></h1>

            <div class="sample">

                <!-- ��� ���� -->
                <p>
                    �� �������� ������ ��û�ϴ� �������Դϴ�
                </p>

                <!-- �ֹ� ���� -->
                <h2>&sdot; �ֹ� ����</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>�ֹ� ��ȣ</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value=""></td>
                    </tr>
                    <tr>
                        <th>��ǰ��</th>
                        <td><input type="text" name="good_name" class="w100" value="<?= convertEncode($_POST['good_name']) ?>"></td>
                    </tr>
                    <tr>
                        <th>���� �ݾ�</th>
                        <td><input type="text" name="good_mny" class="w100" value="<?= $_POST['good_mny'] ?: '0' ?>"></td>
                    </tr>
                    <tr>
                        <th>�ֹ��ڸ�</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>"></td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td><input type="text" name="buyr_mail" class="w200" value="<?= $_POST['buyr_mail'] ?: '' ?>"></td>
                    </tr>
                    <tr>
                        <th>��ȭ��ȣ</th>
                        <td><input type="text" name="buyr_tel1" class="w100" value="<?= $_POST['buyr_tel1'] ?: '' ?>"></td>
                    </tr>
                    <tr>
                        <th>�޴�����ȣ</th>
                        <td><input type="text" name="buyr_tel2" class="w100" value="<?= $_REQUEST['buyr_tel2'] ?: '' ?>"></td>
                    </tr>

                    <!-- ��ġ ����Ű���� �׷���̵�(�����׽�Ʈ�� ���� ��ü�� �׷���̵� �Է�) -->
                    <tr>
                        <th>�׷���̵�</th>
                        <td><input type="text" name="kcp_group_id" class="w100" value="A7EPQ1001835"></td>
                    </tr>
                </table>

                <!-- ���� ��û/ó������ �̹��� -->
                <div class="footer">
                    <b>�� PC���� ������û�� ������ �߻��մϴ�. ��</b>
                </div>
                <div class="btnset" id="display_pay_button" style="display:block">
                    <input name="" type="button" class="submit" value="������û" onclick="kcp_AJAX();">
                    <a href="../index.html" class="home">ó������</a>
                </div>
            </div>
            <!--footer-->
            <div class="footer">
                Copyright (c) KCP INC. All Rights reserved.
            </div>
            <!--//footer-->

            <!-- �������� -->
            <input type="hidden" name="req_tx" value="pay"> <!-- ��û ���� -->
            <input type="hidden" name="shop_name" value="<?= $g_conf_site_name ?>"> <!-- ����Ʈ �̸� -->
            <input type="hidden" name="site_cd" value="<?= $g_conf_site_cd   ?>"> <!-- ����Ʈ Ű -->
            <input type="hidden" name="currency" value="410" /> <!-- ��ȭ �ڵ� -->
            <input type="hidden" name="eng_flag" value="N" /> <!-- �� / �� -->

            <!-- ������� Ű -->
            <input type="hidden" name="approval_key" id="approval">
            <!-- ������ �ʿ��� �Ķ����(����Ұ�)-->
            <input type="hidden" name="escw_used" value="N">
            <input type="hidden" name="pay_method" value="AUTH">
            <input type="hidden" name="ActionResult" value="batch">
            <!-- ���� URL (kcp�� ����� ������ ��û�� �� �ִ� ��ȣȭ �����͸� ���� ���� �������� �ֹ������� URL) -->
            <input type="hidden" name="Ret_URL" value="<?= $url ?>">
            <!-- ȭ�� ũ������ -->
            <input type="hidden" name="tablet_size" value="<?= $tablet_size ?>">

            <!-- �߰� �Ķ���� ( ���������� ������ �����޽� param_opt �� ����Ͽ� �� ���� ) -->
            <input type="hidden" name="param_opt_1" value="<?= $_POST['str_userid'] ?: '' ?>">
            <input type="hidden" name="param_opt_2" value="">
            <input type="hidden" name="param_opt_3" value="">

            <!-- ���� ���� ��Ͻ� ���� Ÿ�� ( �ʵ尡 ���ų� ���� '' �ϰ�� TEXT, ���� XML �Ǵ� JSON ���� -->
            <input type="hidden" name="response_type" value="TEXT" />
            <input type="hidden" name="PayUrl" id="PayUrl" value="" />
            <input type="hidden" name="traceNo" id="traceNo" value="" />

            <!-- ��ġŰ �߱޽� ī���ȣ ���� ���� ���� -->
            <!-- Y : 1234-4567-****-8910 ����, L : 8910 ����(ī���ȣ �� 4�ڸ�) -->
            <input type='hidden' name='batch_cardno_return_yn' value='Y'>
        </form>
    </div>

    <form name="pay_form" method="post" action="pp_cli_hub.php">
        <input type="hidden" name="req_tx" value="<?= $req_tx ?>"> <!-- ��û ����          -->
        <input type="hidden" name="res_cd" value="<?= $res_cd ?>"> <!-- ��� �ڵ�          -->
        <input type="hidden" name="tran_cd" value="<?= $tran_cd ?>"> <!-- Ʈ����� �ڵ�      -->
        <input type="hidden" name="ordr_idxx" value="<?= $ordr_idxx ?>"> <!-- �ֹ���ȣ           -->
        <input type="hidden" name="good_mny" value="<?= $good_mny ?>"> <!-- �޴��� �����ݾ�    -->
        <input type="hidden" name="good_name" value="<?= $good_name ?>"> <!-- ��ǰ��             -->
        <input type="hidden" name="buyr_name" value="<?= $buyr_name ?>"> <!-- �ֹ��ڸ�           -->
        <input type="hidden" name="buyr_tel1" value="<?= $buyr_tel1 ?>"> <!-- �ֹ��� ��ȭ��ȣ    -->
        <input type="hidden" name="buyr_tel2" value="<?= $buyr_tel2 ?>"> <!-- �ֹ��� �޴�����ȣ  -->
        <input type="hidden" name="buyr_mail" value="<?= $buyr_mail ?>"> <!-- �ֹ��� E-mail      -->
        <input type="hidden" name="enc_info" value="<?= $enc_info ?>">
        <input type="hidden" name="enc_data" value="<?= $enc_data ?>">
        <input type="hidden" name="use_pay_method" value="<?= $use_pay_method ?>">

        <!-- �߰� �Ķ���� -->
        <input type="hidden" name="param_opt_1" value="<?= $param_opt_1 ?>">
        <input type="hidden" name="param_opt_2" value="<?= $param_opt_2 ?>">
        <input type="hidden" name="param_opt_3" value="<?= $param_opt_3 ?>">

        <!-- ��ġŰ �߱޽� ī���ȣ ���� ���� ���� -->
        <!-- Y : 1234-4567-****-8910 ����, L : 8910 ����(ī���ȣ �� 4�ڸ�) -->
        <input type='hidden' name='batch_cardno_return_yn' value='Y'>

        <!-- batch_cardno_return_yn ������ ����â���� ���� -->
        <input type='hidden' name='card_mask_no' value='<?= $card_mask_no ?>'>
    </form>
</body>

</html>