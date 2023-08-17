<?
/* ============================================================================== */
/* =   PAGE : ���� ��û PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   �ſ�ī�� �ڵ����� ������ ��û �ϴ� �������Դϴ�.                         = */
/* = -------------------------------------------------------------------------- = */
/* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
/* =   ���� �ּ� : https://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* ============================================================================== */

/* ============================================================================== */
/* =   ȯ�� ���� ���� Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   �� ���� ��                                                               = */
/* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php������ �����Ͻñ� �ٶ��ϴ�.     = */
/* = -------------------------------------------------------------------------- = */

function convertEncode($string)
{
    if (mb_detect_encoding($string, 'UTF-8', true) !== false) {
        return iconv('UTF-8', 'EUC-KR', $string);
    } else {
        return $string;
    }
}
?>

<? include "../../cfg/site_conf_inc.php"; ?>

<?
/* = -------------------------------------------------------------------------- = */
/* =   ȯ�� ���� ���� Include End                                               = */
/* ============================================================================== */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

    <script type="text/javascript">
        /****************************************************************/
        /* m_Completepayment  ����                                      */
        /****************************************************************/
        /* �����Ϸ�� ��� �Լ�                                         */
        /* �ش� �Լ����� ���� �����ϸ� �ȵ˴ϴ�.                        */
        /* �ش� �Լ��� ��ġ�� payplus.js ���ٸ��� ����Ǿ �մϴ�.    */
        /* Web ����� ��� ���� ���� form ���� �Ѿ��                   */
        /* EXE ����� ��� ���� ���� json ���� �Ѿ��                   */
        /****************************************************************/
        function m_Completepayment(FormOrJson, closeEvent) {
            var frm = document.formOrder;

            /********************************************************************/
            /* FormOrJson�� ������ ���� Ȱ�� ����                               */
            /* frm ���� FormOrJson ���� ���� �� frm ������ Ȱ�� �ϼž� �˴ϴ�.  */
            /* FormOrJson ���� Ȱ�� �Ͻ÷��� ������������� ���ǹٶ��ϴ�.       */
            /********************************************************************/
            GetField(frm, FormOrJson);


            if (frm.res_cd.value == "0000") {
                /*
                    ������ ���ϰ� ó�� ����
                */

                frm.submit();
            } else {
                alert("[" + frm.res_cd.value + "] " + frm.res_msg.value);

                closeEvent();

                window.location.href = "/m/mine/payment/index.php";
            }
        }
    </script>

    <?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php ������ �����Ͻñ� �ٶ��ϴ�.    = */
    /* = -------------------------------------------------------------------------- = */
    ?>
    <script type="text/javascript" src="<?= $g_conf_js_url ?>"></script>
    <?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
    ?>
    <script type="text/javascript">
        /* Payplus.js ���� */
        function jsf__pay(form) {
            try {
                KCP_Pay_Execute(form);
            } catch (e) {
                /* IE ���� ���� ��������� throw�� ��ũ��Ʈ ���� */
            }
        }

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

            document.formOrder.ordr_idxx.value = order_idxx;
        }
    </script>
</head>

<body onload="init_orderid();jsf__pay(document.formOrder);">

    <div id="sample_wrap">

        <form name="formOrder" method="post" action="pp_cli_hub.php" style="display: none;">

            <h1>[�ſ�ī�� �������] <span> �ſ�ī�� ������� ������û ���� ������</span></h1>
            <!-- ��� ���� -->
            <div class="sample">
                <p>�� �������� ��û���� �ſ������� �ſ�ī�� ������ �Է��Ͽ�, �ſ�ī���� ������ ��û�ϴ� �������Դϴ�.</br>
                    ��û���� �ſ������� �ֹε�� ��ȣ�� ī��翡 ��ϵ� �ſ������� ��ġ���α��� ������ ���, ������ ��û �� �� �ִ� ����Ű�� ���ϵ˴ϴ�.</br></br>
                    ���ϵ� ����Ű�� ������û �������� ���� ������� ������ ��û �� �� �ֽ��ϴ�.</p>
                <!-- ��� ���̺� End -->

                <!-- ���� ���� Ÿ��Ʋ -->
                <h2>&sdot; ���� ����</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">

                    <!-- �ֹ� ��ȣ -->
                    <tr>
                        <th>�ֹ� ��ȣ</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value="" maxlength="40" /></td>
                    </tr>
                    <!-- �ֹ��� �̸� -->
                    <tr>
                        <th>�ֹ��ڸ�</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>" /></td>
                    </tr>
                    <!-- �׷���̵� : �׽�Ʈ ������ ���� �� ���� ����, ���� ������ ������ ���� �׷���̵� �Է� -->
                    <tr>
                        <th>�׷� ���̵�</th>
                        <td><input type="text" name="kcpgroup_id" value="A7EPQ1001835" class="w100" /></td>
                    </tr>
                </table>

                <!-- ���� ��û/ó������ �̹��� -->
                <div class="btnset" id="display_pay_button" style="display:block">
                    <input name="" type="button" class="submit" value="������û" onclick="jsf__pay(this.form);" />
                    <a href="../index.html" class="home">ó������</a>
                </div>

            </div>
            <div class="footer">
                Copyright (c) KCP INC. All Rights reserved.
            </div>

            <!-- �ʼ� �׸� : ��û���� -->
            <input type="hidden" name="req_tx" value="pay" />
            <input type="hidden" name="site_cd" value="<?= $g_conf_site_cd   ?>" />
            <input type="hidden" name="site_name" value="<?= $g_conf_site_name ?>" />

            <!-- ���� ��� : ����Ű ��û(AUTH:CARD) -->
            <input type='hidden' name='pay_method' value='AUTH:CARD'>

            <!-- ���� ��� : ��������(BCERT) -->
            <input type='hidden' name='card_cert_type' value='BATCH'>

            <!-- �ʼ� �׸� : PULGIN ���� ���� �������� ������ -->
            <input type='hidden' name='module_type' value='01'>

            <!-- �ʼ� �׸� : PLUGIN���� ���� �����ϴ� �κ����� �ݵ�� ���ԵǾ�� �մϴ�. �ؼ������� ���ʽÿ�.-->
            <input type='hidden' name='res_cd' value=''>
            <input type='hidden' name='res_msg' value=''>
            <input type='hidden' name='trace_no' value=''>
            <input type='hidden' name='enc_info' value=''>
            <input type='hidden' name='enc_data' value=''>
            <input type='hidden' name='tran_cd' value=''>

            <!-- ��ġŰ �߱޽� �ֹι�ȣ �Է��� ����â �ȿ��� ���� -->
            <input type='hidden' name='batch_soc' value='Y'>

            <!-- ��ǰ�����Ⱓ ���� -->
            <input type='hidden' name='good_expr' value='2:1m'>


            <!-- �ֹι�ȣ S / ����ڹ�ȣ C �Ƚ� ���� -->
            <!-- <input type='hidden' name='batch_soc_choice' value='' /> -->

            <!-- ��ġŰ �߱޽� ī���ȣ ���� ���� ���� -->
            <!-- Y : 1234-4567-****-8910 ����, L : 8910 ����(ī���ȣ �� 4�ڸ�) -->
            <input type='hidden' name='batch_cardno_return_yn' value='Y'>

            <!-- batch_cardno_return_yn ������ ����â���� ���� -->
            <input type='hidden' name='card_mask_no' value=''>

        </form>
    </div>
</body>

</html>