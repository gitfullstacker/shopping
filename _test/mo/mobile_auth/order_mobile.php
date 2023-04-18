<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��û PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �������� Payplus Plug-in�� ���ؼ� �����ڰ� ���� ��û�� �ϴ� ������    = */
    /* =   �Դϴ�. �Ʒ��� �� �ʼ�, �� �ɼ� �κа� �Ŵ����� �����ϼż� ������        = */
    /* =   �����Ͽ� �ֽñ� �ٶ��ϴ�.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://kcp.co.kr/technique.requestcode.do			        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   ȯ�� ���� ���� Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.jsp ������ �����Ͻñ� �ٶ��ϴ�.    = */
    /* = -------------------------------------------------------------------------- = */
?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/kcp/cfg/site_mbconf_inc.php";?>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   ȯ�� ���� ���� Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* kcp�� ����� kcp �������� ���۵Ǵ� ���� ��û ���� */
    $req_tx          = $_POST[ "req_tx"         ]; // ��û ����         
    $res_cd          = $_POST[ "res_cd"         ]; // ���� �ڵ�         
    $tran_cd         = $_POST[ "tran_cd"        ]; // Ʈ����� �ڵ�     
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // ���θ� �ֹ���ȣ   
    $buyr_name       = $_POST[ "buyr_name"      ]; // �ֹ��ڸ�          
    $enc_info        = $_POST[ "enc_info"       ]; // ��ȣȭ ����       
    $enc_data        = $_POST[ "enc_data"       ]; // ��ȣȭ ������     
    /* ��Ÿ �Ķ���� �߰� �κ� - Start - */
    $param_opt_1    = $_POST[ "param_opt_1"     ]; // ��Ÿ �Ķ���� �߰� �κ�
    $param_opt_2    = $_POST[ "param_opt_2"     ]; // ��Ÿ �Ķ���� �߰� �κ�
    $param_opt_3    = $_POST[ "param_opt_3"     ]; // ��Ÿ �Ķ���� �߰� �κ�
    /* ��Ÿ �Ķ���� �߰� �κ� - End -   */

  $tablet_size     = "1.0"; // ȭ�� ������ ����
  $url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>*** KCP [AX-HUB Version] ***</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta http-equiv="Cache-Control" content="No-Cache">
<meta http-equiv="Pragma" content="No-Cache">

<meta name="viewport" content="width=device-width, user-scalable=<?=$tablet_size?>, initial-scale=<?=$tablet_size?>, maximum-scale=<?=$tablet_size?>, minimum-scale=<?=$tablet_size?>">

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>

<!-- �ŷ���� �ϴ� kcp ������ ����� ���� ��ũ��Ʈ-->
<script type="text/javascript" src="js/approval_key.js"></script>

<script type="text/javascript">

    var controlCss = "css/style_mobile.css";
    var isMobile = {
        Android: function()
        {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function()
        {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function()
        {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function()
        {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function()
        {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function()
        {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    if( isMobile.any() )
    {
        document.getElementById("cssLink").setAttribute("href", controlCss);
    }
</script>
<script type="text/javascript">
    /* �ֹ���ȣ ���� ���� */
    function init_orderid()
    {
        var today = new Date();
        var year  = today.getFullYear();
        var month = today.getMonth() + 1;
        var date  = today.getDate();
        var time  = today.getTime();

        if (parseInt(month) < 10)
        {
            month = "0" + month;
        }

        if (parseInt(date) < 10)
        {
            date  = "0" + date;
        }

        var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

        document.order_info.ordr_idxx.value = order_idxx;
    }

    /* kcp web ����â ȣ�� (����Ұ�) */
    function call_pay_form()
    {
        var v_frm = document.order_info;

        document.getElementById("sample_wrap").style.display = "none";
        document.getElementById("layer_all").style.display  = "block";

        v_frm.target = "frm_all";
        v_frm.action = PayUrl;

        if (v_frm.Ret_URL.value == "")
        {
            /* Ret_URL���� �� �������� URL �Դϴ�. */
            alert("������ Ret_URL�� �ݵ�� �����ϼž� �˴ϴ�.");
            return false;
        }
        else
        {
            v_frm.submit();
        }
    }

    /* kcp ����� ���� ���� ��ȣȭ ���� üũ �� ���� ��û (����Ұ�) */
    function chk_pay()
    {
        self.name = "tar_opener";
        var pay_form = document.pay_form;

        if (pay_form.res_cd.value == "3001" )
        {
            alert("����ڰ� ����Ͽ����ϴ�.");
            pay_form.res_cd.value = "";
        }

        document.getElementById("sample_wrap").style.display = "block";
        document.getElementById("layer_all").style.display  = "none";

        if (pay_form.enc_info.value)
        {
            pay_form.submit();
        }
    }
</script>
</head>

<body onload="init_orderid();chk_pay();">
<div id="sample_wrap">
<form name="order_info" method="post">
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
            <th>�ֹ��ڸ�</th>
            <td><input type="text" name="buyr_name" class="w100" value="ȫ�浿"></td>
        </tr>
        <tr>
            <th>�׷� ���̵�</th>
            <td><input type="text" name="kcp_group_id" class="w100" value="A7EPQ1001835"></td> <!-- BA001 : BA0011000348 -->
        </tr>
        <tr>
            <th>���� �ݾ�</th>
            <td><input type="text" name="good_mny" class="w100" value="1004"></td>
        </tr>
        <tr>
            <th>��ǰ��</th>
            <td><input type="text" name="good_name" class="w100" value="�ڵ���"></td>
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
    <input type="hidden" name="req_tx"          value="pay">                           <!-- ��û ���� -->
    <input type="hidden" name="shop_name"       value="<?=$g_conf_site_name ?>">       <!-- ����Ʈ �̸� --> 
    <input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd   ?>">       <!-- ����Ʈ Ű -->
    <input type="hidden" name="currency"        value="410"/>                          <!-- ��ȭ �ڵ� -->
    <input type="hidden" name="eng_flag"        value="N"/>                            <!-- �� / �� -->
    <input type="hidden" name='kcp_cert_flag'   value="N"/>
    <input type="text" name="kcp_bath_info_view"     value="Y"> ��ǰ�� �����Ķ���� </br>

    <!-- ������� Ű -->
    <input type="hidden" name="approval_key"    id="approval">
    <!-- ������ �ʿ��� �Ķ����(����Ұ�)-->
    <input type="hidden" name="escw_used"       value="N">
    <input type="hidden" name="pay_method"      value="AUTH">
    <input type="hidden" name="ActionResult"    value="batch">
    <!-- ���� URL (kcp�� ����� ������ ��û�� �� �ִ� ��ȣȭ �����͸� ���� ���� �������� �ֹ������� URL) -->
    <input type="hidden" name="Ret_URL"         value="<?=$url?>">
    <!-- ȭ�� ũ������ -->
    <input type="hidden" name="tablet_size"     value="<?=$tablet_size?>">

    <!-- �߰� �Ķ���� ( ���������� ������ �����޽� param_opt �� ����Ͽ� �� ���� ) -->
    <input type="hidden" name="param_opt_1"     value="">
    <input type="hidden" name="param_opt_2"     value="">
    <input type="hidden" name="param_opt_3"     value="">

    <!-- ���� ���� ��Ͻ� ���� Ÿ�� ( �ʵ尡 ���ų� ���� '' �ϰ�� TEXT, ���� XML �Ǵ� JSON ���� -->
    <input type="hidden" name="response_type"  value="TEXT"/>
    <input type="hidden" name="PayUrl"   id="PayUrl"   value=""/>
    <input type="hidden" name="traceNo"  id="traceNo"  value=""/>
</form>
</div>

<!-- ����Ʈ������ KCP ����â�� ���̾� ���·� ����-->
<div id="layer_all" style="position:absolute; left:0px; top:0px; width:100%;height:100%; z-index:1; display:none;">
    <table height="100%" width="100%" border="-" cellspacing="0" cellpadding="0" style="text-align:center">
        <tr height="100%" width="100%">
            <td>
                <iframe name="frm_all" frameborder="0" marginheight="0" marginwidth="0" border="0" width="100%" height="100%" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
<form name="pay_form" method="post" action="pp_cli_hub.php">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">               <!-- ��û ����          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">               <!-- ��� �ڵ�          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">              <!-- Ʈ����� �ڵ�      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">            <!-- �ֹ���ȣ           -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">            <!-- �ֹ��ڸ�           -->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">

    <!-- �߰� �Ķ���� -->
    <input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
    <input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
    <input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">
</form>
</body>
</html>
