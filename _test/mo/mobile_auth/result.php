<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��� ��� PAGE                                               = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ���� ��û ������� ����ϴ� �������Դϴ�.                                = */
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

    //include "../cfg/site_conf_inc.php";       // ȯ�漳�� ���� include
    include $_SERVER['DOCUMENT_ROOT'] . "/kcp/cfg/site_mbconf_inc.php";

    /* = -------------------------------------------------------------------------- = */
    /* =   ȯ�� ���� ���� Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   ���� ���                                                                = */
    /* = -------------------------------------------------------------------------- = */
    // ���� ����
    $req_tx           = $_POST[ "req_tx"         ];      // ��û ����(����/���)
    /* = -------------------------------------------------------------------------- = */
    // ��� �ڵ�
    $res_cd           = $_POST[ "res_cd"         ];      // ��� �ڵ�
    $res_msg          = $_POST[ "res_msg"        ];      // ��� �޽���
    /* = -------------------------------------------------------------------------- = */
    // �ֹ� ����
    $ordr_idxx        = $_POST[ "ordr_idxx"      ];      // �ֹ���ȣ
    $good_name        = $_POST[ "good_name"      ];      // ��ǰ��
    $good_mny         = $_POST[ "good_mny"       ];      // ���� �ݾ�
    $buyr_name        = $_POST[ "buyr_name"      ];      // �����ڸ�
    /* = -------------------------------------------------------------------------- = */
    // �ſ�ī��
    $card_cd          = $_POST[ "card_cd"        ];      // ī�� �ڵ�
    $card_name        = $_POST[ "card_name"      ];      // ī���
    $batch_key        = $_POST[ "batch_key"      ];      // ��ġ ����Ű
    /* = -------------------------------------------------------------------------- = */
    /* ��Ÿ �Ķ���� �߰� �κ� - Start - */
    $param_opt_1     = $_POST[ "param_opt_1"    ];       // ��Ÿ �Ķ���� �߰� �κ�
    $param_opt_2     = $_POST[ "param_opt_2"    ];       // ��Ÿ �Ķ���� �߰� �κ�
    $param_opt_3     = $_POST[ "param_opt_3"    ];       // ��Ÿ �Ķ���� �߰� �κ�
    /* ��Ÿ �Ķ���� �߰� �κ� - End -   */
    /* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>*** KCP [AX-HUB Version] ***</title>
<meta name="viewport" content="width=device-width, user-scalable=1.0, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
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

  if( isMobile.any() )
    document.getElementById("cssLink").setAttribute("href", controlCss);
</script>
</head>
<body>
<form name="cancel" method="post">
<div id="sample_wrap">
    <!--Ÿ��Ʋ-->
    <h1>[������] <span>�� �������� ���� ����� ����ϴ� ����(����) �������Դϴ�.</span></h1>
    <!--//Ÿ��Ʋ-->
    <div class="sample">
    <!--��ܹ���-->
    <p>
        ��û ����� ����ϴ� ������ �Դϴ�.<br />
        ��û�� ���������� ó���� ��� ����ڵ�(res_cd)���� 0000���� ǥ�õ˴ϴ�.
    </p>
    <!--//��ܹ���-->

<?
    /* ============================================================================== */
    /* =   ���� ��� �ڵ� �� �޽��� ���(����������� �ݵ�� ������ֽñ� �ٶ��ϴ�.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   ���� ���� : res_cd���� 0000���� �����˴ϴ�.                              = */
    /* =   ���� ���� : res_cd���� 0000�̿��� ������ �����˴ϴ�.                     = */
    /* = -------------------------------------------------------------------------- = */
?>
        <h2>&sdot; ó�� ���</h2>
        <table class="tbl" cellpadding="0" cellspacing="0">
            <!-- ��� �ڵ� -->
            <tr>
              <th>��� �ڵ�</th>
              <td><?=$res_cd?></td>
            </tr>
                  <!-- ��� �޽��� -->
            <tr>
              <th>��� �޼���</th>
              <td><?=$res_msg?></td>
            </tr>
        </table>
<?
    /* ============================================================================== */
    /* =   1. ���� ������ ���� ��� ��� ( res_cd���� 0000�� ���)                  = */
    /* = -------------------------------------------------------------------------- = */
        if ( $res_cd == "0000" )
        {
?>
            <h2>&sdot; �ֹ� ����</h2>
            <table class="tbl" cellpadding="0" cellspacing="0">
                <!-- �ֹ���ȣ -->
                <tr>
                    <th>�ֹ���ȣ</th>
                    <td><?=$ordr_idxx?></td>
                </tr>
                <!-- �ֹ��ڸ� -->
                <tr>
                    <th>�ֹ��ڸ�</th>
                    <td><?=$buyr_name?></td>
                </tr>
                </table>

                <h2>&sdot; ���� ���� ����</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                <!-- ���� ī�� -->
                <tr>
                    <th>����ī���ڵ�</th>
                    <td><?=$card_cd?></td>
                </tr>
                <!-- ���� ī��� -->
                <tr>
                    <th>����ī���</th>
                    <td><?=$card_name?></td>
                </tr>
                <!-- ��ġŰ -->
                <tr>
                    <th>��ġŰ</th>
                    <td><?=$batch_key?></td>
                </tr>
            </table>
<?
        }
?>
                <!-- ó������ �̹��� ��ư -->
                <tr>
                <div class="btnset">
                <a href="../index.html" class="home">ó������</a>
                </div>
                </tr>
              </tr>
            </div>
        <div class="footer">
                Copyright (c) KCP INC. All Rights reserved.
        </div>
    </div>
  </body>
</html>