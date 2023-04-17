<?
    /* ============================================================================== */
    /* =   PAGE : 결제 정보 환경 설정 PAGE                                          = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   ※ 주의 ※                                                               = */
    /* = -------------------------------------------------------------------------- = */
    /* =  실결제 변경시 아래의 값들을 반드시 변경해 주십시오.                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =  g_conf_gw_url   : testpaygw.kcp.co.kr -> paygw.kcp.co.kr로 변경           = */
    /* =  g_conf_site_cd  : KCP에서 발급한 사이트코드                               = */
    /* =  g_conf_site_key : KCP에서 발급한 사이트키                                 = */
    /* = -------------------------------------------------------------------------- = */


    /* ============================================================================== */
    /* =   01. 지불 데이터 셋업 (업체에 맞게 수정)                                  = */
    /* = -------------------------------------------------------------------------- = */
    /* = ※ 주의 ※                                                                 = */
    /* = * g_conf_gw_url 설정                                                       = */
    /* =    테스트 시 : g_conf_gw_url = "testpaygw.kcp.co.kr" ;                     = */
    /* =    실결제 시 : g_conf_gw_url = "paygw.kcp.co.kr" ;                         = */
    /* =                                                                            = */
    /* = * g_conf_home_dir 설정                                                     = */
    /* =    샘플 소스를 보시면 bin 디렉토리 아래에 pp_cli 파일이 존재합니다.        = */
    /* =    /(root) 디렉토리에서 bin 디렉토리 전까지의 절대경로로 설정합니다.       = */
    /* = -------------------------------------------------------------------------- = */

    $g_conf_gw_url    = "testpaygw.kcp.co.kr";
    //$g_conf_home_dir  = "/home/kcpuser/pgsample/USER/pjh/KCP_Batch_linux_php";
    $g_conf_home_dir  = $_SERVER[DOCUMENT_ROOT]."/_test";

    /* ============================================================================== */
    /* = ※ 주의 ※                                                                 = */
    /* = * g_conf_js_url 설정                                                       = */
    /* =----------------------------------------------------------------------------= */
    /* = 테스트 시 : src="http://testpay.kcp.co.kr/plugin/payplus_web.jsp"              = */
    /* =             src="https://testpay.kcp.co.kr/plugin/payplus_web.jsp"             = */
    /* = 실결제 시 : src="http://pay.kcp.co.kr/plugin/payplus_web.jsp"              = */
    /* =             src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"                  = */
    /* =                                                                            = */
    /* = 테스트 시(UTF-8) : src="http://pay.kcp.co.kr/plugin/payplus_test_un.js"    = */
    /* =                    src="https://pay.kcp.co.kr/plugin/payplus_test_un.js"   = */
    /* = 실결제 시(UTF-8) : src="http://pay.kcp.co.kr/plugin/payplus_un.js"         = */
    /* =                    src="https://pay.kcp.co.kr/plugin/payplus_un.js"        = */
    /* ============================================================================== */

    $g_conf_js_url    = "https://testpay.kcp.co.kr/plugin/payplus_web.jsp";

    /* = -------------------------------------------------------------------------- = */
    /* =  이 부분은 수정하지 마십시오.                                              = */
    /* = -------------------------------------------------------------------------- = */

    $g_conf_log_level = "3";
    $g_conf_gw_port   = "8090";

    /* ============================================================================== */


    /* = -------------------------------------------------------------------------- = */
    /* =     02. 쇼핑몰 지불 필수 정보 설정(업체에 맞게 수정)                       = */
    /* = -------------------------------------------------------------------------- = */
    /* = ※ 주의 ※                                                                 = */
    /* =                                                                            = */
    /* = * g_conf_gw_url 설정                                                       = */
    /* =     테스트 시 : testpaygw.kcp.co.kr                                        = */
    /* =     실결제 시 : paygw.kcp.co.kr                                            = */
    /* =                                                                            = */
    /* = * g_conf_site_cd, g_conf_site_key 설정                                     = */
    /* =     실결제 시 :                                                            = */
    /* =         KCP에서 발급한 사이트코드(site_cd), 사이트키(site_key)를 반드시    = */
    /* =         변경해 주셔야 결제가 정상적으로 진행됩니다.                        = */
    /* =                                                                            = */
    /* =   테스트 시 :                                                              = */
    /* =         사이트코드(g_conf_site_cd) : BA001                                 = */
    /* =         사이트키(g_conf_site_key)  : 2T5.LgLrH--wbufUOvCqSNT__             = */
    /* =   실결제 시 :                                                              = */
    /* =         사이트코드(g_conf_site_cd) : KCP에서 발급한 사이트코드(site_cd)    = */
    /* =         사이트키(g_conf_site_key)  : KCP에서 발급한 사이트키(site_key)     = */
    /* =                                                                            = */
    /* = * g_conf_site_name 설정                                                    = */
    /* = 사이트명 설정(한글 불가) : Payplus Plugin 오른쪽 상단에 표기되는 값입니다. = */
    /* =                           반드시 영문자로 설정하여 주시기 바랍니다.        = */
    /* =                                                                            = */
    /* = -------------------------------------------------------------------------- = */

    $g_conf_site_cd   = "BA001";
    $g_conf_site_key  = "2T5.LgLrH--wbufUOvCqSNT__";
    $g_conf_site_name = "TEST MALL";

    /* ============================================================================== */
?>