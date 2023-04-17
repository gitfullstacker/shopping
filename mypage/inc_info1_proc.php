<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/kcp/cfg/site_bconf_inc.php";?>
<?include_once $_SERVER[DOCUMENT_ROOT] . "/kcp/bill/pp_ax_hub_lib.php";?>
<?
	fnc_Login_Chk();
	
    $int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");
    
	$SQL_QUERY =	" SELECT
					*
				FROM "
					.$Tname."comm_site_info
				WHERE
					INT_NUMBER=1 ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

    /* ============================================================================== */
    /* =   PAGE : 인증 요청 및 결과 처리 PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 인증 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $req_tx      = $_POST[ "req_tx"      ];                  // 요청 종류
    $tran_cd     = $_POST[ "tran_cd"     ];                  // 처리 종류
    $cust_ip     = getenv( "REMOTE_ADDR" );                  // 요청 IP (옵션값)
    /* = -------------------------------------------------------------------------- = */
    $pay_method  = $_POST[ "pay_method"  ];                  // 결제 방법
    $ordr_idxx   = $_POST[ "ordr_idxx"   ];                  // 쇼핑몰 주문번호
    $buyr_name   = $_POST[ "buyr_name"   ];                  // 요청자 이름
    /* = -------------------------------------------------------------------------- = */
    $res_cd      = "";                                       // 결과 코드
    $res_msg     = "";                                       // 결과 메시지
    /* = -------------------------------------------------------------------------- = */
    $card_cd     = "";                                       // 카드 코드
    $batch_key   = "";                                       // 배치 인증키
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 인스턴스 생성 및 초기화                                              = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. 처리 요청 정보 설정, 실행                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. 인증 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ] , $_POST[ "enc_info" ] );

    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. 실행                                                               = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tran_cd != "" )
    {
            $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "",
                                  $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                                  $cust_ip, "3" , 0, 0 ); // 응답 전문 처리
    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "연동 오류";
    }

    $res_cd    = $c_PayPlus->m_res_cd;
    $res_msg   = $c_PayPlus->m_res_msg;
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. 인증 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */
    if( $res_cd == "0000" )
    {
        $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   );
        $batch_key = $c_PayPlus->mf_get_res_data( "batch_key" );

        if ($int_gubun=="1"){
        	$int_price=$arr_Data['INT_PRICE1'];
        }else{
        	$int_price=$arr_Data['INT_PRICE2'];
        }
        $good_mny=  $int_price;  
        
		$arr_Set_Data= Array();
		$arr_Column_Name = Array();
		
		$arr_Column_Name[0]		= "INT_NUMBER";
		$arr_Column_Name[1]		= "STR_USERID";
		$arr_Column_Name[2]		= "STR_PTYPE";
		$arr_Column_Name[3]		= "STR_PAYMETHOD";
		$arr_Column_Name[4]		= "STR_PDATE";
		$arr_Column_Name[5]		= "INT_PRICE";
		$arr_Column_Name[6]		= "STR_PCARDCODE";
		$arr_Column_Name[7]		= "STR_BILLCODE";
		$arr_Column_Name[8]		= "STR_RESCD";
		$arr_Column_Name[9]		= "STR_RESMEG";
		$arr_Column_Name[10]		= "STR_ORDERIDX";
		$arr_Column_Name[11]		= "STR_CARDCODE";
		$arr_Column_Name[12]		= "STR_CARDNAME";
		$arr_Column_Name[13]		= "DTM_INDATE";
		$arr_Column_Name[14]		= "STR_CANCEL";
		$arr_Column_Name[15]		= "STR_PASS";

		$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_member_pay " ;
		$arr_max_Data=mysql_query($SQL_QUERY);
		$lastnumber = mysql_result($arr_max_Data,0,lastnumber);
			
		$arr_Set_Data[0]		= $lastnumber;
		$arr_Set_Data[1]		= $arr_Auth[0];
		$arr_Set_Data[2]		= $int_gubun;
		$arr_Set_Data[3]		= "bill";
		$arr_Set_Data[4]		= date("Y-m-d");
		$arr_Set_Data[5]		= $good_mny;
		$arr_Set_Data[6]		= "";
		$arr_Set_Data[7]		= $batch_key;
		$arr_Set_Data[8]		= $res_cd;
		$arr_Set_Data[9]		= $res_msg;
		$arr_Set_Data[10]		= $ordr_idxx;
		$arr_Set_Data[11]		= $card_cd;
		$arr_Set_Data[12]		= "";
		$arr_Set_Data[13]		= date("Y-m-d H:i:s");
		$arr_Set_Data[14]		= "0";
		$arr_Set_Data[15]		= "0";

		$arr_Sub1 = "";
		$arr_Sub2 = "";
		
		for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

			If  ($int_I != 0) {
				$arr_Sub1 .=  ",";
				$arr_Sub2 .=  ",";
			}
			$arr_Sub1 .=  $arr_Column_Name[$int_I];
			$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";

		}

		$Sql_Query = "INSERT INTO `".$Tname."comm_member_pay` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
		mysql_query($Sql_Query);
        
        
        
        
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */
?>
    <html>
    <head>
    <script>
        function goResult()
        {
        	init_orderid();
            document.pay_info.submit();
        }
    </script>
    
    <script type="text/javascript">

        // 주문번호 생성 예제
        function init_orderid()
        {
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth()+ 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10)
            {
                month = "0" + month;
            }

            var vOrderID = year + "" + month + "" + date + "" + time;

            document.pay_info.ordr_idxx.value = vOrderID;
        }
    </script>
    
    </head>
    <body onload="goResult()">
    <form name="pay_info" method="post" action="inc_info1_1_proc.php">
    	<input type="hidden" name="int_gubun"           value="<?=$int_gubun?>">
    
        <input type="hidden" name="res_cd"      value="<?=$res_cd?>">            <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"     value="<?=$res_msg?>">           <!-- 결과 메세지 -->
        <input type="hidden" name="buyr_name"   value="<?=$buyr_name?>">         <!-- 요청자 이름 -->
        <input type="hidden" name="card_cd"     value="<?=$card_cd?>">           <!-- 카드 코드 -->
        <input type="hidden" name="bt_batch_key"   value="<?=$batch_key?>">         <!-- 배치 인증키 -->
        
        <input type="hidden" name="pay_method" value="CARD" />
        <input type="hidden" name="ordr_idxx"   value="">         <!-- 주문번호 -->
        <input type="hidden" name="good_name" value="멥버쉽정기결제"/>
        <input type="hidden" name="good_mny" value="<?=$good_mny?>" />
        <input type="hidden" name="buyr_mail" value="<?=$arr_Auth[6]?>" />
		<input type="hidden" name="buyr_tel1" value="<?=$arr_Auth[5]?>"/>
		<input type="hidden" name="buyr_tel2" value="<?=$arr_Auth[4]?>"/>
		<input type="hidden" name="bt_group_id" value="A7EPQ1001835" />
		<input type="hidden" name="quotaopt" value="00" />
		
        <input type="hidden" name="req_tx"          value="pay"/>
        <input type="hidden" name="card_pay_method" value="Batch"/>
        <input type="hidden" name="currency" value="410"/>
        <input type="hidden" name="lastnumber" value="<?=$lastnumber?>"/>
        
        
    </form>
    </body>
    </html>
