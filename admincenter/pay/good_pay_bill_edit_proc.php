<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/payment/linux/auto_pay/mo/cfg/site_conf_inc.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/payment/linux/auto_pay/mo/payx/pp_cli_hub_lib.php"; ?>
<?
//	fnc_Login_Chk();

$int_gubun = Fnc_Om_Conv_Default($_REQUEST['int_gubun'], "1");
$str_no = Fnc_Om_Conv_Default($_REQUEST['str_no'], "");
$int_type = Fnc_Om_Conv_Default($_REQUEST['int_type'], "");

$str_sdate = Fnc_Om_Conv_Default($_REQUEST['str_sdate'], "");
$str_edate = Fnc_Om_Conv_Default($_REQUEST['str_edate'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
$str_goodcode = Fnc_Om_Conv_Default($_REQUEST['str_goodcode'], "");
$int_cart = Fnc_Om_Conv_Default($_REQUEST['int_cart'], "");

/* ============================================================================== */
/* =   01. 지불 요청 정보 설정                                                  = */
/* = -------------------------------------------------------------------------- = */
$pay_method = $_POST["pay_method"];  // 결제 방법
$ordr_idxx  = $_POST["ordr_idxx"];  // 주문 번호
$good_name  = $_POST["good_name"];  // 상품 정보
$good_mny   = $_POST["good_mny"];  // 결제 금액
$buyr_name  = $_POST["buyr_name"];  // 주문자 이름
$buyr_mail  = $_POST["buyr_mail"];  // 주문자 E-Mail
$buyr_tel1  = $_POST["buyr_tel1"];  // 주문자 전화번호
$buyr_tel2  = $_POST["buyr_tel2"];  // 주문자 휴대폰번호
$req_tx     = $_POST["req_tx"];  // 요청 종류
$currency   = $_POST["currency"];  // 화폐단위 (WON/USD)
/* = -------------------------------------------------------------------------- = */
$mod_type      = $_POST["mod_type"];                         // 변경TYPE(승인취소시 필요)
$mod_desc      = $_POST["mod_desc"];                         // 변경사유
$amount        = "";                                               // 총 금액
$panc_mod_mny  = "";                                               // 부분취소 요청금액
$panc_rem_mny  = "";                                               // 부분취소 가능금액
/* = -------------------------------------------------------------------------- = */
$tran_cd       = "";                                               // 트랜잭션 코드
$bSucc         = "";                                               // DB 작업 성공 여부
/* = -------------------------------------------------------------------------- = */
$res_cd        = "";                                               // 결과코드
$res_msg       = "";                                               // 결과메시지
$tno           = "";                                               // 거래번호
/* = -------------------------------------------------------------------------- = */
$card_pay_method = $_POST["card_pay_method"];                    // 카드 결제 방법
$card_cd         = "";                                             // 카드 코드
$card_no         = "";                                             // 카드 번호
$card_name       = "";                                             // 카드명
$app_time        = "";                                             // 승인시간
$app_no          = "";                                             // 승인번호
$noinf           = "";                                             // 무이자여부
$quota           = "";                                             // 할부개월
/* ============================================================================== */

/* ============================================================================== */
/* =   02. 인스턴스 생성 및 초기화                                              = */
/* = -------------------------------------------------------------------------- = */

$c_PayPlus  = new C_PAYPLUS_CLI;
$c_PayPlus->mf_clear();

/* ============================================================================== */

/* ============================================================================== */
/* =   03. 처리 요청 정보 설정, 실행                                            = */
/* = -------------------------------------------------------------------------- = */

/* = -------------------------------------------------------------------------- = */
/* =   03-1. 승인 요청                                                          = */
/* = -------------------------------------------------------------------------- = */
// 업체 환경 정보
$cust_ip = getenv("REMOTE_ADDR"); // 요청 IP (옵션값)
if ($req_tx == "pay") {
    $tran_cd = "00100000";

    $common_data_set = "";

    $common_data_set .= $c_PayPlus->mf_set_data_us("amount",   $good_mny);
    $common_data_set .= $c_PayPlus->mf_set_data_us("currency", $currency);
    $common_data_set .= $c_PayPlus->mf_set_data_us("cust_ip",  $cust_ip);
    $common_data_set .= $c_PayPlus->mf_set_data_us("escw_mod", "N");

    $c_PayPlus->mf_add_payx_data("common", $common_data_set);

    // 주문 정보
    $c_PayPlus->mf_set_ordr_data("ordr_idxx", $ordr_idxx);
    $c_PayPlus->mf_set_ordr_data("good_name", $good_name);
    $c_PayPlus->mf_set_ordr_data("good_mny",  $good_mny);
    $c_PayPlus->mf_set_ordr_data("buyr_name", $buyr_name);
    $c_PayPlus->mf_set_ordr_data("buyr_tel1", $buyr_tel1);
    $c_PayPlus->mf_set_ordr_data("buyr_tel2", $buyr_tel2);
    $c_PayPlus->mf_set_ordr_data("buyr_mail", $buyr_mail);

    if ($pay_method == "CARD") {
        $card_data_set;

        $card_data_set .= $c_PayPlus->mf_set_data_us("card_mny", $good_mny);        // 결제 금액

        if ($card_pay_method == "Batch") {
            $card_data_set .= $c_PayPlus->mf_set_data_us("card_tx_type",   "11511000");
            $card_data_set .= $c_PayPlus->mf_set_data_us("quota",          $_POST["quotaopt"]);
            $card_data_set .= $c_PayPlus->mf_set_data_us("bt_group_id",    $_POST["bt_group_id"]);
            $card_data_set .= $c_PayPlus->mf_set_data_us("bt_batch_key",   $_POST["bt_batch_key"]);
        }
        $c_PayPlus->mf_add_payx_data("card", $card_data_set);
    }
}

/* = -------------------------------------------------------------------------- = */
/* =   03-2. 취소/매입 요청                                                     = */
/* = -------------------------------------------------------------------------- = */ else if ($req_tx == "mod") {

    $tran_cd = "00200000";

    $c_PayPlus->mf_set_modx_data("tno",      $_POST["tno"]);      // KCP 원거래 거래번호
    $c_PayPlus->mf_set_modx_data("mod_type", $mod_type);      // 원거래 변경 요청 종류
    $c_PayPlus->mf_set_modx_data("mod_ip",   $cust_ip);      // 변경 요청자 IP
    $c_PayPlus->mf_set_modx_data("mod_desc", $_POST["mod_desc"]);      // 변경 사유

    if ($mod_type == "STPC") // 부분취소의 경우
    {
        $c_PayPlus->mf_set_modx_data("mod_mny", $_POST["mod_mny"]); // 취소요청금액
        $c_PayPlus->mf_set_modx_data("rem_mny", $_POST["rem_mny"]); // 취소가능잔액
    }
}
/* ============================================================================== */


/* ============================================================================== */
/* =   03-3. 실행                                                               = */
/* ------------------------------------------------------------------------------ */
if ($tran_cd != "") {
    $c_PayPlus->mf_do_tx(
        $trace_no,
        $g_conf_home_dir,
        $g_conf_site_cd,
        "",
        $tran_cd,
        "",
        $g_conf_gw_url,
        $g_conf_gw_port,
        "payplus_cli_slib",
        $ordr_idxx,
        $cust_ip,
        $g_conf_log_level,
        0,
        0
    ); // 응답 전문 처리

    $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
    $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
} else {
    $c_PayPlus->m_res_cd  = "9562";
    $c_PayPlus->m_res_msg = "연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.";
}

/* ============================================================================== */


/* ============================================================================== */
/* =   04. 승인 결과 처리                                                       = */
/* = -------------------------------------------------------------------------- = */
if ($req_tx == "pay") {
    if ($res_cd == "0000") {
        $tno   = $c_PayPlus->mf_get_res_data("tno"); // KCP 거래 고유 번호

        /* = -------------------------------------------------------------------------- = */
        /* =   04-1. 신용카드 승인 결과 처리                                            = */
        /* = -------------------------------------------------------------------------- = */
        if ($pay_method == "CARD") {
            $card_cd   = $c_PayPlus->mf_get_res_data("card_cd"); // 카드사 코드
            $card_no   = $c_PayPlus->mf_get_res_data("card_no"); // 카드 번호
            $card_name = $c_PayPlus->mf_get_res_data("card_name"); // 카드 종류
            $app_time  = $c_PayPlus->mf_get_res_data("app_time"); // 승인 시간
            $app_no    = $c_PayPlus->mf_get_res_data("app_no"); // 승인 번호
            $noinf     = $c_PayPlus->mf_get_res_data("noinf"); // 무이자 여부 ( 'Y' : 무이자 )
            $quota     = $c_PayPlus->mf_get_res_data("quota"); // 할부 개월 수
        }

        /* = -------------------------------------------------------------------------- = */
        /* =   04-2. 승인 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
        /* = -------------------------------------------------------------------------- = */
        /* =         승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해      = */
        /* =         DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로       = */
        /* =         승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                = */
        /* =         DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"     = */
        /* =         로 세팅해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의 = */
        /* =         값을 세팅하시면 됩니다.)                                           = */
        /* = -------------------------------------------------------------------------- = */
        $bSucc = "";             // DB 작업 실패일 경우 "false" 로 세팅

        /* = -------------------------------------------------------------------------- = */
        /* =   04-3. DB 작업 실패일 경우 자동 승인 취소                                 = */
        /* = -------------------------------------------------------------------------- = */
        if ($req_tx == "pay") {
            if ($res_cd == "0000") {
                if ($bSucc == "false") {
                    $c_PayPlus->mf_clear();

                    $tran_cd = "00200000";

                    $c_PayPlus->mf_set_modx_data("tno",      $tno);  // KCP 원거래 거래번호
                    $c_PayPlus->mf_set_modx_data("mod_type", "STSC");  // 원거래 변경 요청 종류
                    $c_PayPlus->mf_set_modx_data("mod_ip",   $cust_ip);  // 변경 요청자 IP (옵션값)
                    $c_PayPlus->mf_set_modx_data("mod_desc", "결과 처리 오류 - 자동 취소");  // 변경 사유

                    $c_PayPlus->mf_do_tx(
                        $tno,
                        $g_conf_home_dir,
                        $g_conf_site_cd,
                        "",
                        $tran_cd,
                        "",
                        $g_conf_gw_url,
                        $g_conf_gw_port,
                        "payplus_cli_slib",
                        $ordr_idxx,
                        $cust_ip,
                        "3",
                        0,
                        0
                    );

                    $res_cd  = $c_PayPlus->m_res_cd;
                    $res_msg = $c_PayPlus->m_res_msg;
                }
            }
        } // End of [res_cd = "0000"]
    }
}

/* ============================================================================== */
/* =   05. 취소/매입 결과 처리                                                  = */
/* = -------------------------------------------------------------------------- = */ else if ($req_tx == "mod") {
    if ($res_cd == "0000") {
        if ($mod_type == "STPC") {
            $amount       = $c_PayPlus->mf_get_res_data("amount"); // 총 금액
            $panc_mod_mny = $c_PayPlus->mf_get_res_data("panc_mod_mny"); // 부분취소 요청금액
            $panc_rem_mny = $c_PayPlus->mf_get_res_data("panc_rem_mny"); // 부분취소 가능금액
        }
    }
}
/* ============================================================================== */

/* ============================================================================== */
/* =   06. 폼 구성 및 결과페이지 호출                                           = */
/* ============================================================================== */


if ($req_tx == "pay") {
    if ($res_cd == "0000") {
        $arr_Set_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]        = "STR_USERID";
        $arr_Column_Name[1]        = "STR_GOODCODE";
        $arr_Column_Name[2]        = "INT_PRICE";
        $arr_Column_Name[3]        = "STR_RESCD";
        $arr_Column_Name[4]        = "STR_RESMEG";
        $arr_Column_Name[5]        = "STR_ORDERIDX";
        $arr_Column_Name[6]        = "STR_CARDCODE";
        $arr_Column_Name[7]        = "STR_CARDNAME";
        $arr_Column_Name[8]        = "DTM_INDATE";
        $arr_Column_Name[9]        = "INT_CART";

        $arr_Set_Data[0]        = $str_userid;
        $arr_Set_Data[1]        = $str_goodcode;
        $arr_Set_Data[2]        = $good_mny;
        $arr_Set_Data[3]        = $res_cd;
        $arr_Set_Data[4]        = $res_msg;
        $arr_Set_Data[5]        = $ordr_idxx;
        $arr_Set_Data[6]        = $card_cd;
        $arr_Set_Data[7]        = $card_name;
        $arr_Set_Data[8]        = date("Y-m-d H:i:s");
        $arr_Set_Data[9]        = $ordr_idxx;

        $arr_Sub1 = "";
        $arr_Sub2 = "";

        for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

            if ($int_I != 0) {
                $arr_Sub1 .=  ",";
                $arr_Sub2 .=  ",";
            }
            $arr_Sub1 .=  $arr_Column_Name[$int_I];
            $arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";
        }

        $Sql_Query = "INSERT INTO `" . $Tname . "comm_good_pay` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($Sql_Query);

        // 이전 상품주문정보 얻기
        $Sql_Query = "SELECT A.* FROM `" . $Tname . "comm_goods_cart` A WHERE A.INT_NUMBER = " . $int_cart;
        $arr_Rlt_Data = mysql_query($Sql_Query);
        $cart_Data = mysql_fetch_assoc($arr_Rlt_Data);

        // 결제상태 반영
        $arr_Set_Data = array();
        $arr_Column_Name = array();

        $arr_Column_Name[0]        = "INT_NUMBER";
        $arr_Column_Name[1]        = "STR_USERID";
        $arr_Column_Name[2]        = "STR_NAME";
        $arr_Column_Name[3]        = "STR_POST";
        $arr_Column_Name[4]        = "STR_ADDR1";
        $arr_Column_Name[5]        = "STR_ADDR2";
        $arr_Column_Name[6]        = "STR_PLACE1";
        $arr_Column_Name[7]        = "STR_PLACE2";
        $arr_Column_Name[8]        = "STR_MEMO";
        $arr_Column_Name[9]        = "STR_GOODCODE";
        $arr_Column_Name[10]        = "STR_SGOODCODE";
        $arr_Column_Name[11]        = "STR_SDATE";
        $arr_Column_Name[12]        = "STR_EDATE";
        $arr_Column_Name[13]        = "STR_REDATE";
        $arr_Column_Name[14]        = "DTM_INDATE";
        $arr_Column_Name[15]        = "INT_STATE";
        $arr_Column_Name[16]        = "STR_RPOST";
        $arr_Column_Name[17]        = "STR_RADDR1";
        $arr_Column_Name[18]        = "STR_RADDR2";
        $arr_Column_Name[19]        = "STR_METHOD";
        $arr_Column_Name[20]        = "STR_RDATE";
        $arr_Column_Name[21]        = "STR_RMEMO";
        $arr_Column_Name[22]        = "INT_DELICODE";
        $arr_Column_Name[23]        = "STR_DELICODE";
        $arr_Column_Name[24]        = "STR_AMEMO";
        $arr_Column_Name[25]        = "DTM_EDIT_DATE";
        $arr_Column_Name[26]        = "STR_TELEP";
        $arr_Column_Name[27]        = "STR_HP";
        $arr_Column_Name[28]        = "INT_COUNT";
        $arr_Column_Name[29]        = "INT_TPRICE";
        $arr_Column_Name[30]        = "INT_PRICE";
        $arr_Column_Name[31]        = "INT_PDISCOUNT";
        $arr_Column_Name[32]        = "INT_ADISCOUNT";
        $arr_Column_Name[33]        = "INT_MDISCOUNT";
        $arr_Column_Name[34]        = "INT_COUPON";
        $arr_Column_Name[35]        = "INT_CDISCOUNT";
        $arr_Column_Name[36]        = "INT_MILEAGE";

        $arr_Set_Data[0]        = $ordr_idxx;
        $arr_Set_Data[1]        = $cart_Data['STR_USERID'];
        $arr_Set_Data[2]        = $cart_Data['STR_NAME'];
        $arr_Set_Data[3]        = $cart_Data['STR_POST'];
        $arr_Set_Data[4]        = $cart_Data['STR_ADDR1'];
        $arr_Set_Data[5]        = $cart_Data['STR_ADDR2'];
        $arr_Set_Data[6]        = '';
        $arr_Set_Data[7]        = '';
        $arr_Set_Data[8]        = $cart_Data['STR_MEMO'];
        $arr_Set_Data[9]        = $cart_Data['STR_GOODCODE'];
        $arr_Set_Data[10]        = $cart_Data['STR_SGOODCODE'];
        $arr_Set_Data[11]        = $str_sdate;
        $arr_Set_Data[12]        = $str_edate;
        $arr_Set_Data[13]        = '';
        $arr_Set_Data[14]        = date("Y-m-d H:i:s");
        $arr_Set_Data[15]        = "1";
        $arr_Set_Data[16]        = '';
        $arr_Set_Data[17]        = '';
        $arr_Set_Data[18]        = '';
        $arr_Set_Data[19]        = '';
        $arr_Set_Data[20]        = '';
        $arr_Set_Data[21]        = '';
        $arr_Set_Data[22]        = 0;
        $arr_Set_Data[23]        = '';
        $arr_Set_Data[24]        = '';
        $arr_Set_Data[25]        = date("Y-m-d H:i:s");
        $arr_Set_Data[26]        = $cart_Data['STR_TELEP'];
        $arr_Set_Data[27]        = $cart_Data['STR_HP'];
        $arr_Set_Data[28]        = $cart_Data['INT_COUNT'];
        $arr_Set_Data[29]        = $good_mny;
        $arr_Set_Data[30]        = $good_mny;
        $arr_Set_Data[31]        = 0;
        $arr_Set_Data[32]        = 0;
        $arr_Set_Data[33]        = 0;
        $arr_Set_Data[34]        = 0;
        $arr_Set_Data[35]        = 0;
        $arr_Set_Data[36]        = 0;

        $arr_Sub1 = "";
        $arr_Sub2 = "";

        for ($int_I = 0; $int_I < count($arr_Column_Name); $int_I++) {

            if ($int_I != 0) {
                $arr_Sub1 .=  ",";
                $arr_Sub2 .=  ",";
            }
            $arr_Sub1 .=  $arr_Column_Name[$int_I];
            $arr_Sub2 .=  $arr_Set_Data[$int_I] == null ? "NULL" : "'" . $arr_Set_Data[$int_I] . "'";
        }

        $SQL_QUERY = "INSERT INTO `" . $Tname . "comm_goods_cart` (" . $arr_Sub1 . ") VALUES (" . $arr_Sub2 . ") ";
        mysql_query($SQL_QUERY);
    }
}

$res_msg = iconv("EUC-KR", "UTF-8", $res_msg) ? iconv("EUC-KR", "UTF-8", $res_msg) : $res_msg;

?>
<script language="javascript">
    <? if ($res_cd == "0000") { ?>
        alert("처리되었습니다.");
    <? } else { ?>
        alert("<?= $res_msg ?>");
    <? } ?>
    parent.document.frm.submit();
</script>