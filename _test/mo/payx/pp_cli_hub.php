<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��û PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserved.                    = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* = ���̺귯�� �� ����Ʈ ���� include                                          = */
    /* = -------------------------------------------------------------------------- = */
?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/kcp/mo/pp_cli_hub_lib.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/kcp/cfg/site_mbconf_inc.php";?>
<?
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   01. ���� ��û ���� ����                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $pay_method = $_POST[ "pay_method" ];  // ���� ���
    $ordr_idxx  = $_POST[ "ordr_idxx"  ];  // �ֹ� ��ȣ
    $good_name  = $_POST[ "good_name"  ];  // ��ǰ ����
    $good_mny   = $_POST[ "good_mny"   ];  // ���� �ݾ�
    $buyr_name  = $_POST[ "buyr_name"  ];  // �ֹ��� �̸�
    $buyr_mail  = $_POST[ "buyr_mail"  ];  // �ֹ��� E-Mail
    $buyr_tel1  = $_POST[ "buyr_tel1"  ];  // �ֹ��� ��ȭ��ȣ
    $buyr_tel2  = $_POST[ "buyr_tel2"  ];  // �ֹ��� �޴�����ȣ
    $req_tx     = $_POST[ "req_tx"     ];  // ��û ����
    $currency   = $_POST[ "currency"   ];  // ȭ����� (WON/USD)
    /* = -------------------------------------------------------------------------- = */
    $mod_type      = $_POST[ "mod_type"     ];                         // ����TYPE(������ҽ� �ʿ�)
    $mod_desc      = $_POST[ "mod_desc"     ];                         // �������
    $amount        = "";                                               // �� �ݾ�
    $panc_mod_mny  = "";                                               // �κ���� ��û�ݾ�
    $panc_rem_mny  = "";                                               // �κ���� ���ɱݾ�
    /* = -------------------------------------------------------------------------- = */
    $tran_cd       = "";                                               // Ʈ����� �ڵ�
    $bSucc         = "";                                               // DB �۾� ���� ����
    /* = -------------------------------------------------------------------------- = */
    $res_cd        = "";                                               // ����ڵ�
    $res_msg       = "";                                               // ����޽���
    $tno           = "";                                               // �ŷ���ȣ
    /* = -------------------------------------------------------------------------- = */
    $card_pay_method = $_POST[ "card_pay_method" ];                    // ī�� ���� ���
    $card_cd         = "";                                             // ī�� �ڵ�
    $card_no         = "";                                             // ī�� ��ȣ
    $card_name       = "";                                             // ī���
    $app_time        = "";                                             // ���νð�
    $app_no          = "";                                             // ���ι�ȣ
    $noinf           = "";                                             // �����ڿ���
    $quota           = "";                                             // �Һΰ���
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. �ν��Ͻ� ���� �� �ʱ�ȭ                                              = */
    /* = -------------------------------------------------------------------------- = */

    $c_PayPlus  = new C_PAYPLUS_CLI;
    $c_PayPlus->mf_clear();
    
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. ó�� ��û ���� ����, ����                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. ���� ��û                                                          = */
    /* = -------------------------------------------------------------------------- = */
    // ��ü ȯ�� ����
    $cust_ip = getenv( "REMOTE_ADDR" ); // ��û IP (�ɼǰ�)

    if ( $req_tx == "pay" )
    {
    $tran_cd = "00100000";

    $common_data_set = "";

    $common_data_set .= $c_PayPlus->mf_set_data_us( "amount",   $good_mny    );
    $common_data_set .= $c_PayPlus->mf_set_data_us( "currency", $currency    );
    $common_data_set .= $c_PayPlus->mf_set_data_us( "cust_ip",  $cust_ip );
    $common_data_set .= $c_PayPlus->mf_set_data_us( "escw_mod", "N"      );

    $c_PayPlus->mf_add_payx_data( "common", $common_data_set );

    // �ֹ� ����
    $c_PayPlus->mf_set_ordr_data( "ordr_idxx", $ordr_idxx );
    $c_PayPlus->mf_set_ordr_data( "good_name", $good_name );
    $c_PayPlus->mf_set_ordr_data( "good_mny",  $good_mny  );
    $c_PayPlus->mf_set_ordr_data( "buyr_name", $buyr_name );
    $c_PayPlus->mf_set_ordr_data( "buyr_tel1", $buyr_tel1 );
    $c_PayPlus->mf_set_ordr_data( "buyr_tel2", $buyr_tel2 );
    $c_PayPlus->mf_set_ordr_data( "buyr_mail", $buyr_mail );

        if ( $pay_method == "CARD" )
        {
            $card_data_set;

            $card_data_set .= $c_PayPlus->mf_set_data_us( "card_mny", $good_mny );        // ���� �ݾ�

                if ( $card_pay_method == "Batch" )
                {
                    $card_data_set .= $c_PayPlus->mf_set_data_us( "card_tx_type",   "11511000" );
                    $card_data_set .= $c_PayPlus->mf_set_data_us( "quota",          $_POST[ "quotaopt"     ] );
                    $card_data_set .= $c_PayPlus->mf_set_data_us( "bt_group_id",    $_POST[ "bt_group_id"  ] );
                    $card_data_set .= $c_PayPlus->mf_set_data_us( "bt_batch_key",   $_POST[ "bt_batch_key" ] );
                }
            $c_PayPlus->mf_add_payx_data( "card", $card_data_set );
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-2. ���/���� ��û                                                     = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {

            $tran_cd = "00200000";

            $c_PayPlus->mf_set_modx_data( "tno",      $_POST[ "tno" ]      );      // KCP ���ŷ� �ŷ���ȣ
            $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type            );      // ���ŷ� ���� ��û ����
            $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip             );      // ���� ��û�� IP
            $c_PayPlus->mf_set_modx_data( "mod_desc", $_POST[ "mod_desc" ] );      // ���� ����

            if ( $mod_type == "STPC" ) // �κ������ ���
            {
                $c_PayPlus->mf_set_modx_data( "mod_mny", $_POST[ "mod_mny" ] ); // ��ҿ�û�ݾ�
                $c_PayPlus->mf_set_modx_data( "rem_mny", $_POST[ "rem_mny" ] ); // ��Ұ����ܾ�
            }
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03-3. ����                                                               = */
    /* ------------------------------------------------------------------------------ */
        if ( $tran_cd != "" )
        {
            $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "",
                                  $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                                  $cust_ip, "3" , 0, 0, $g_conf_key_dir, $g_conf_log_dir); // ���� ���� ó��

            $res_cd  = $c_PayPlus->m_res_cd;  // ��� �ڵ�
            $res_msg = $c_PayPlus->m_res_msg; // ��� �޽���
        }
        else
        {
            $c_PayPlus->m_res_cd  = "9562";
            $c_PayPlus->m_res_msg = "���� ����|Payplus Plugin�� ��ġ���� �ʾҰų� tran_cd���� �������� �ʾҽ��ϴ�.";
        }

    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. ���� ��� ó��                                                       = */
    /* = -------------------------------------------------------------------------- = */
        if ( $req_tx == "pay" )
        {
            if ( $res_cd == "0000" )
            {
                $tno   = $c_PayPlus->mf_get_res_data( "tno"       ); // KCP �ŷ� ���� ��ȣ

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. �ſ�ī�� ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
                if ( $pay_method == "CARD" )
                {
                    $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // ī��� �ڵ�
                    $card_no   = $c_PayPlus->mf_get_res_data( "card_no"   ); // ī�� ��ȣ
                    $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // ī�� ����
                    $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // ���� �ð�
                    $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // ���� ��ȣ
                    $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // ������ ���� ( 'Y' : ������ )
                    $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // �Һ� ���� ��
                }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. ���� ����� ��ü ��ü������ DB ó�� �۾��Ͻô� �κ��Դϴ�.         = */
    /* = -------------------------------------------------------------------------- = */
    /* =         ���� ����� DB �۾� �ϴ� �������� ���������� ���ε� �ǿ� ����      = */
    /* =         DB �۾��� �����Ͽ� DB update �� �Ϸ���� ���� ���, �ڵ�����       = */
    /* =         ���� ��� ��û�� �ϴ� ���μ����� �����Ǿ� �ֽ��ϴ�.                = */
    /* =         DB �۾��� ���� �� ���, bSucc ��� ����(String)�� ���� "false"     = */
    /* =         �� ������ �ֽñ� �ٶ��ϴ�. (DB �۾� ������ ��쿡�� "false" �̿��� = */
    /* =         ���� �����Ͻø� �˴ϴ�.)                                           = */
    /* = -------------------------------------------------------------------------- = */
		    $bSucc = "";             // DB �۾� ������ ��� "false" �� ����

    /* = -------------------------------------------------------------------------- = */
    /* =   04-3. DB �۾� ������ ��� �ڵ� ���� ���                                 = */
    /* = -------------------------------------------------------------------------- = */
            if ( $req_tx == "pay" )
            {
                if( $res_cd == "0000" )
                {
                    if ( $bSucc == "false" )
                    {
                        $c_PayPlus->mf_clear();

                        $tran_cd = "00200000";

                        $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP ���ŷ� �ŷ���ȣ
                        $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // ���ŷ� ���� ��û ����
                        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // ���� ��û�� IP (�ɼǰ�)
                        $c_PayPlus->mf_set_modx_data( "mod_desc", "��� ó�� ���� - �ڵ� ���" );  // ���� ����

                        $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                                              "",  $tran_cd,    "",
                                              $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                                              $ordr_idxx, $cust_ip, "3" ,
                                              0, 0);

                        $res_cd  = $c_PayPlus->m_res_cd;
                        $res_msg = $c_PayPlus->m_res_msg;
                    }
                }
            } // End of [res_cd = "0000"]
            }
        }

    /* ============================================================================== */
    /* =   05. ���/���� ��� ó��                                                  = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {
            if ( $res_cd == "0000" )
            {
                if ( $mod_type == "STPC" )
                {
                $amount       = $c_PayPlus->mf_get_res_data( "amount"       ); // �� �ݾ�
                $panc_mod_mny = $c_PayPlus->mf_get_res_data( "panc_mod_mny" ); // �κ���� ��û�ݾ�
                $panc_rem_mny = $c_PayPlus->mf_get_res_data( "panc_rem_mny" ); // �κ���� ���ɱݾ�
                }
            }
        }
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   06. �� ���� �� ��������� ȣ��                                           = */
    /* ============================================================================== */
?>

    <html>
    <head>
        <script type="text/javascript">
            function goResult()
            {
                document.pay_info.submit();
            }
        </script>
    </head>

    <body onload="goResult();">
        <form name="pay_info" method="post" action="./result.php">
            <input type="hidden" name="req_tx"     value="<?=$req_tx     ?>">  <!-- ��û ���� -->
            <input type="hidden" name="pay_method" value="<?=$pay_method ?>">  <!-- ����� ���� ���� -->
            <input type="hidden" name="bSucc"      value="<?=$bSucc      ?>">  <!-- ���θ� DB ó�� ���� ���� -->
            <input type="hidden" name="mod_type"   value="<?=$mod_type   ?>">
            <input type="hidden" name="amount"     value="<?=$amount     ?>">  <!-- �� �ݾ� -->
            <input type="hidden" name="panc_mod_mny"   value="<?=$panc_mod_mny?>">  <!-- �κ���� ��û�ݾ� -->
            <input type="hidden" name="panc_rem_mny"   value="<?=$panc_rem_mny?>">  <!-- �κ���� ���ɱݾ� -->

            <input type="hidden" name="res_cd"     value="<?=$res_cd     ?>">  <!-- ��� �ڵ� -->
            <input type="hidden" name="res_msg"    value="<?=$res_msg    ?>">  <!-- ��� �޼��� -->
            <input type="hidden" name="ordr_idxx"  value="<?=$ordr_idxx  ?>">  <!-- �ֹ���ȣ -->
            <input type="hidden" name="tno"        value="<?=$tno        ?>">  <!-- KCP �ŷ���ȣ -->
            <input type="hidden" name="good_mny"   value="<?=$good_mny   ?>">  <!-- �����ݾ� -->
            <input type="hidden" name="good_name"  value="<?=$good_name  ?>">  <!-- ��ǰ�� -->
            <input type="hidden" name="buyr_name"  value="<?=$buyr_name  ?>">  <!-- �ֹ��ڸ� -->
            <input type="hidden" name="buyr_tel1"  value="<?=$buyr_tel1  ?>">  <!-- �ֹ��� ��ȭ��ȣ -->
            <input type="hidden" name="buyr_tel2"  value="<?=$buyr_tel2  ?>">  <!-- �ֹ��� �޴�����ȣ -->
            <input type="hidden" name="buyr_mail"  value="<?=$buyr_mail  ?>">  <!-- �ֹ��� E-mail -->

            <input type="hidden" name="card_cd"    value="<?=$card_cd    ?>">  <!-- ī���ڵ� -->
            <input type="hidden" name="card_no"    value="<?=$card_no    ?>">  <!-- ī���ȣ -->
            <input type="hidden" name="card_name"  value="<?=$card_name  ?>">  <!-- ī��� -->
            <input type="hidden" name="app_time"   value="<?=$app_time   ?>">  <!-- ���νð� -->
            <input type="hidden" name="app_no"     value="<?=$app_no     ?>">  <!-- ���ι�ȣ -->
            <input type="hidden" name="quota"      value="<?=$quota      ?>">  <!-- �Һΰ��� -->
            <input type="hidden" name="noinf"      value="<?=$noinf      ?>">  <!-- �����ڿ��� -->

        </form>
    </body>
    </html>
