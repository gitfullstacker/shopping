<?
    /* ============================================================================== */
    /* =   PAGE : ���� ���� ȯ�� ���� PAGE                                          = */
    /* =----------------------------------------------------------------------------= */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://kcp.co.kr/technique.requestcode.do                    = */
    /* =----------------------------------------------------------------------------= */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* = �� ���� ��                                                                 = */
    /* = * g_conf_home_dir ���� ����                                                = */
    /* =----------------------------------------------------------------------------= */
    /* =   BIN ���� ��� �Է� (bin������ ����                                       = */
    /* ============================================================================== */
    //$g_conf_home_dir  = "/data1/newpg/pay/kimhj/ax_hub_linux_jsp_add";       // BIN ������ �Է� (bin������) 
    $g_conf_home_dir  = $_SERVER['DOCUMENT_ROOT']."/kcp";

    /* ============================================================================== */
    /* = �� ���� ��                                                                 = */
    /* = * g_conf_log_path ���� ����                                                = */
    /* =----------------------------------------------------------------------------= */
    /* =   log ��� ����                                                            = */
    /* ============================================================================== */
    //$g_conf_log_path = "/data1/newpg/pay/kimhj/ax_hub_linux_jsp/bin/log";
    $g_conf_log_path  = $_SERVER['DOCUMENT_ROOT']."/kcp/log";

    /* ============================================================================== */
    /* = �� ���� ��                                                                 = */
    /* = * g_conf_gw_url ����                                                       = */
    /* =----------------------------------------------------------------------------= */
    /* = �׽�Ʈ �� : testpaygw.kcp.co.kr�� ������ �ֽʽÿ�.                         = */
    /* = �ǰ��� �� : paygw.kcp.co.kr�� ������ �ֽʽÿ�.                             = */
    /* ============================================================================== */
    //$g_conf_gw_url    = "testpaygw.kcp.co.kr";
    $g_conf_gw_url    = "paygw.kcp.co.kr";

    /* ============================================================================== */
    /* = �� ���� ��                                                                 = */
    /* = * g_conf_js_url ����                                                       = */
    /* =----------------------------------------------------------------------------= */
    /* = �׽�Ʈ �� : src="http://pay.kcp.co.kr/plugin/payplus_test.js"              = */
    /* =             src="https://pay.kcp.co.kr/plugin/payplus_test.js"             = */
    /* = �ǰ��� �� : src="http://pay.kcp.co.kr/plugin/payplus.js"                   = */
    /* =             src="https://pay.kcp.co.kr/plugin/payplus.js"                  = */
    /* =                                                                            = */
    /* = �׽�Ʈ ��(UTF-8) : src="http://pay.kcp.co.kr/plugin/payplus_test_un.js"    = */
    /* =                    src="https://pay.kcp.co.kr/plugin/payplus_test_un.js"   = */
    /* = �ǰ��� ��(UTF-8) : src="http://pay.kcp.co.kr/plugin/payplus_un.js"         = */
    /* =                    src="https://pay.kcp.co.kr/plugin/payplus_un.js"        = */
    /* ============================================================================== */
    //$g_conf_js_url    = "https://pay.kcp.co.kr/plugin/payplus_test.js";
    $g_conf_js_url    = "http://pay.kcp.co.kr/plugin/payplus_un.js";

    /* ============================================================================== */
    /* = ����Ʈ�� SOAP ��� ����                                                     = */
    /* =----------------------------------------------------------------------------= */
    /* = �׽�Ʈ �� : KCPPaymentService.wsdl                                         = */
    /* = �ǰ��� �� : real_KCPPaymentService.wsdl                                    = */
    /* ============================================================================== */
    //$g_wsdl           = "KCPPaymentService.wsdl";
    $g_wsdl           = "real_KCPPaymentService.wsdl";

    /* ============================================================================== */
    /* = g_conf_site_cd, g_conf_site_key ����                                       = */
    /* = �ǰ����� KCP���� �߱��� ����Ʈ�ڵ�(site_cd), ����ƮŰ(site_key)�� �ݵ��   = */
    /* = ������ �ּž� ������ ���������� ����˴ϴ�.                                = */
    /* =----------------------------------------------------------------------------= */
    /* = �׽�Ʈ �� : ����Ʈ�ڵ�(T0000)�� ����ƮŰ(3grptw1.zW0GSo4PQdaGvsF__)��      = */
    /* =            ������ �ֽʽÿ�.                                                = */
    /* = �ǰ��� �� : �ݵ�� KCP���� �߱��� ����Ʈ�ڵ�(site_cd)�� ����ƮŰ(site_key) = */
    /* =            �� ������ �ֽʽÿ�.                                             = */
    /* ============================================================================== */
    //$g_conf_site_cd   = "T0000";
    //$g_conf_site_key  = "3grptw1.zW0GSo4PQdaGvsF__";
    
    $g_conf_site_cd   = "A7EPP";
    $g_conf_site_key  = "2sk-EJKJJJwQQQRbGXgu.R1__";

    /* ============================================================================== */
    /* = g_conf_site_name ����                                                      = */
    /* =----------------------------------------------------------------------------= */
    /* = ����Ʈ�� ����(�ѱ� �Ұ�) : �ݵ�� �����ڷ� �����Ͽ� �ֽñ� �ٶ��ϴ�.       = */
    /* ============================================================================== */
    //$g_conf_site_name = "KCP TEST SHOP";
    $g_conf_site_name = "ABLANC";

    /* ============================================================================== */
    /* = ���� ������ �¾� (���� �Ұ�)                                               = */
    /* ============================================================================== */
    $g_conf_log_level = "3";
    $g_conf_gw_port   = "8090";        // ��Ʈ��ȣ(����Ұ�)
    $module_type      = "01";          // ����Ұ�
?>
