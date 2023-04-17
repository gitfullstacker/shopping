<?
    /* ============================================================================== */
    /* =   PAGE : 지불 요청 및 결과 처리 PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do			        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   환경 설정 파일 Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/kcp/cfg/site_mbconf_inc.php";?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/_test/mo/mobile_auth/pp_cli_hub_lib.php";?>
<?
    /* ============================================================================== */
    /* =   POST 형식 체크부분                                                       = */
    /* = -------------------------------------------------------------------------- = */
    if ( $_SERVER['REQUEST_METHOD'] != "POST" )
    {
        echo("잘못된 경로로 접속하였습니다.");
        exit;
    }
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   01. 지불 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
    /* = -------------------------------------------------------------------------- = */
    $req_tx         = $_POST[ "req_tx"         ]; // 요청 종류
    $tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류
    /* = -------------------------------------------------------------------------- = */
    $ordr_idxx      = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호
    $good_name      = $_POST[ "good_name"      ]; // 상품명
    $good_mny       = $_POST[ "good_mny"       ]; // 결제 총금액
    $buyr_name      = $_POST[ "buyr_name"      ]; // 주문자명
    /* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                                                     // 응답코드
    $res_msg        = "";                                                     // 응답 메세지
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                                                     // 신용카드 코드
    $card_name      = "";                                                     // 신용카드 명
    $batch_key      = "";                                                     // 배치 인증키
    /* = -------------------------------------------------------------------------- = */
    $param_opt_1    = $_POST[ "param_opt_1" ];
    $param_opt_2    = $_POST[ "param_opt_2" ];
    $param_opt_3    = $_POST[ "param_opt_3" ];
    /* ============================================================================== */
    /* =   01. 지불 요청 정보 설정 END                                              = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 인스턴스 생성 및 초기화                                              = */
    /* = -------------------------------------------------------------------------- = */
    /* =       결제에 필요한 인스턴스를 생성하고 초기화 합니다.                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();
    /* ------------------------------------------------------------------------------ */
    /* =   02. 인스턴스 생성 및 초기화 END                                          = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 처리 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 승인 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
            /* 1004원은 실제로 업체에서 결제하셔야 될 원 금액을 넣어주셔야 합니다. 결제금액 유효성 검증 */
            /* $c_PayPlus->mf_set_ordr_data( "ordr_mony",  "1004" );                                    */

            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
    }
    /* ------------------------------------------------------------------------------ */
    /* =   03.  처리 요청 정보 설정 END                                             = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. 실행                                                                 = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tran_cd != "" )
    {
        $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, $g_conf_site_key, $tran_cd, "",
                              $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                              $cust_ip, $g_conf_log_level, 0, 0, $g_conf_log_path ); // 응답 전문 처리

        $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
        $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "연동 오류|tran_cd값이 설정되지 않았습니다.";
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04. 실행 END                                                             = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   05. 인증 결과 값 추출                                                    = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if ( $res_cd == "0000" )
        {
            $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   );       // 카드 코드
            $card_name = $c_PayPlus->mf_get_res_data( "card_name" );       // 카드명
            $batch_key = $c_PayPlus->mf_get_res_data( "batch_key" );       // 배치 인증키
        }
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   05. 인증 결과 처리 END                                                   = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. 승인 및 실패 결과 DB처리                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =       결과를 업체 자체적으로 DB처리 작업하시는 부분입니다.                 = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   06. 승인 및 실패 결과 DB처리                                             = */
    /* ============================================================================== */
        else if ( $res_cd != "0000" )
        {
        }
    }

    /* ============================================================================== */
    /* =   07. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */
?>
    <html>
    <head>
        <title>스마트폰 웹 결제창</title>
        <script type="text/javascript">
            function goResult()
            {
                document.pay_info.submit()
            }

            // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
            function noRefresh()
            {
                /* CTRL + N키 막음. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 번키 막음. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }
            document.onkeydown = noRefresh ;
        </script>
    </head>

    <body onload="goResult()">
    <form name="pay_info" method="post" action="./result.php">
        <input type="hidden" name="res_cd"          value="<?= $res_cd           ?>">    <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"         value="<?= $res_msg          ?>">    <!-- 결과 메세지 -->
        <input type="hidden" name="ordr_idxx"       value="<?= $ordr_idxx        ?>">    <!-- 주문번호 -->
        <input type="hidden" name="good_mny"        value="<?= $good_mny         ?>">    <!-- 결제금액 -->
        <input type="hidden" name="good_name"       value="<?= $good_name        ?>">    <!-- 상품명 -->
        <input type="hidden" name="buyr_name"       value="<?= $buyr_name        ?>">    <!-- 주문자명 -->

        <!-- 신용카드 정보 -->
        <input type="hidden" name="card_cd"         value="<?= $card_cd          ?>">    <!-- 카드코드 -->
        <input type="hidden" name="card_name"       value="<?= $card_name        ?>">    <!-- 카드이름 -->
        <input type="hidden" name="batch_key"       value="<?= $batch_key        ?>">    <!-- 배치 인증키 -->

        <input type="hidden" name="param_opt_1"     value="<?= $param_opt_1 ?>">
        <input type="hidden" name="param_opt_2"     value="<?= $param_opt_2 ?>">
        <input type="hidden" name="param_opt_3"     value="<?= $param_opt_3 ?>">
    </form>
    </body>
    </html>
