<?
/* ============================================================================== */
/* =   PAGE : ���� ��û PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   �� �������� ��ǰ�� ���� �Է� �� �ֹ� ������ �Է��ϴ� ������ �Դϴ�.      = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : https://kcp.co.kr/technique.requestcode.do                    = */
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
        // �ֹ���ȣ ���� ����
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
                alert("����Ű ���� ��Ȯ�� �Է��� �ֽñ� �ٶ��ϴ�.");
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

            <h1>[�ſ�ī�� ������� ������û] <span> �ſ�ī�� ������� ������û ���� ������</span></h1>
            <!-- ��� ���� -->
            <div class="sample">
                <p>�� �������� ��û���� ����Ű�� �Է��Ͽ� �ſ�ī�� ���� ��û���ϴ� �������Դϴ�.</br><br>
                    ���� ��û �� ����Ű�� �ټ��� ��� �ش� ��⿡ �����ϴ� ���� Ű ���� ����ڿ� �°� �ݾװ� �Һθ� �����Ͽ��ֽñ� �ٶ��ϴ�.</p>
                <!-- ��� ���̺� End -->

                <!-- �ֹ����� Ÿ��Ʋ -->
                <h2>&sdot; �ֹ� ����</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- ���� ��� -->
                    <tr>
                        <th>���� ���</th>
                        <td><input type="text" name="pay_method" value="CARD" size="13" class="w100" readonly /></td>
                    </tr>
                    <!-- �ֹ� ��ȣ -->
                    <tr>
                        <th>�ֹ� ��ȣ</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value="<?= $_POST['ordr_idxx'] ?>" maxlength="40" /></td>
                    </tr>
                    <!-- ��ǰ�� -->
                    <tr>
                        <th>��ǰ��</th>
                        <td><input type="text" name="good_name" class="w100" value="<?= convertEncode($_POST['good_name']) ?>" /></td>
                    </tr>
                    <!-- ���� �ݾ� -->
                    <tr>
                        <th>���� �ݾ�</th>
                        <td><input type="text" name="good_mny" class="w100" value="<?= $_POST['good_mny'] ?: '0' ?>" maxlength="9" />��(���ڸ� �Է�)</td>
                    </tr>
                    <!-- �ֹ��� �̸� -->
                    <tr>
                        <th>�ֹ��ڸ�</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>" /></td>
                    </tr>
                    <!-- �ֹ��� E-Mail -->
                    <tr>
                        <th>E-mail</th>
                        <td><input type="text" name="buyr_mail" class="w200" value="<?= $_POST['buyr_mail'] ?: '' ?>" maxlength="30" /></td>
                    </tr>
                    <!-- �ֹ��� ��ȭ��ȣ -->
                    <tr>
                        <th>��ȭ��ȣ</th>
                        <td><input type="text" name="buyr_tel1" class="w100" value="<?= $_POST['buyr_tel1'] ?: '' ?>" /></td>
                    </tr>
                    <!-- �ֹ��� �޴�����ȣ -->
                    <tr>
                        <th>�޴�����ȣ</th>
                        <td><input type="text" name="buyr_tel2" class="w100" value="<?= $_POST['buyr_tel2'] ?: '' ?>" /></td>
                    </tr>
                </table>
                <!-- �ֹ� ���� ��� ���̺� End -->

                <!-- ������� ���� ��� ���̺� Start -->
                <h2>&sdot; ������� ����</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- ����Ű -->
                    <tr>
                        <th>����Ű</th>
                        <td><input type="text" name="bt_batch_key" value="<?= $_POST['bt_batch_key'] ?: '' ?>" class="w150" /></td>
                    </tr>
                    <!-- �׷�ID S61861000449 -->
                    <tr>
                        <th>�׷�ID</th>
                        <td><input type="text" name="bt_group_id" value="A7EPQ1001835" class="w100" /></td>
                    </tr>
                    <!-- �Һΰ��� -->
                    <tr>
                        <th>�Һΰ���</th>
                        <td><input type="text" name="quotaopt" value="<?= $_POST['quotaopt'] ?: '00' ?>" size="2" maxlength="2" class="w10" /></td>
                    </tr>
                </table>
                <!-- ������� ���� ��� ���̺� End -->

                <!-- ���� ��ư ���̺� Start -->
                <div class="btnset">
                    <table align="center" cellspacing="0" cellpadding="0" class="margin_top_20">
                        <tr id="show_pay_btn">
                            <td colspan="2" align="center">
                                <input name="" type="submit" class="submit" value="������û" onclick="return jsf__pay(this.form);" alt="������ ��û�մϴ�" /></a>
                                <a href="../index.html" class="home">ó������</a>
                </div>
                </td>
                </tr>
                <!-- ���� ���� ���Դϴ�. �޽��� -->
                <tr id="show_progress" style="display:none">
                    <td colspan="2" class="center red">���� ���� ���Դϴ�. ��ø� ��ٷ� �ֽʽÿ�...</td>
                </tr>
                </table>
            </div>
            <!-- ���� ��ư ���̺� End -->

    </div>
    <div class="footer">
        Copyright (c) KCP INC. All Rights reserved.
    </div>

    <!-- ��û���� ����(pay)/���,����(mod) ��û�� ��� -->
    <input type="hidden" name="req_tx" value="pay" />
    <input type="hidden" name="pay_method" value="CARD" />
    <input type="hidden" name="card_pay_method" value="Batch" />
    <!-- �ʼ� �׸� : ���� �ݾ�/ȭ����� -->
    <input type="hidden" name="currency" value="410" />
    </form>
    </div>
</body>

</html>