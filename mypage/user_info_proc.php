<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_opasswd = Fnc_Om_Conv_Default($_REQUEST[str_opasswd],"");
	$str_passwd = Fnc_Om_Conv_Default($_REQUEST[str_passwd1],"");
	
	$str_hp = Fnc_Om_Conv_Default($_REQUEST[str_hp1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_hp2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_hp3],"");
	$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email1],"")."@".Fnc_Om_Conv_Default($_REQUEST[str_email2],"");
	$str_post = Fnc_Om_Conv_Default($_REQUEST[str_post],"");
	$str_addr1 = Fnc_Om_Conv_Default($_REQUEST[str_addr1],"");
	$str_addr2 = Fnc_Om_Conv_Default($_REQUEST[str_addr2],"");
	$str_mail_f = Fnc_Om_Conv_Default($_REQUEST[str_mail_f],"N");

	switch($RetrieveFlag){
		case "PUPDATE" :
	
			$SQL_QUERY = "select * from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_member
					where
						STR_USERID='".$arr_Auth[0]."'
						AND STR_PASSWD=password('$str_opasswd') ";

			$arr_sub_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_sub_Data);

			if(!($rcd_cnt)){
			?>
			<script language="javascript">
				alert("기존 비밀번호가 일치하지 않습니다.");
			</script>
			<?
			exit;
			break;		
			}
			
			$SQL_QUERY = " UPDATE ".$Tname."comm_member SET ";
					$SQL_QUERY .= "STR_PASSWD=password('$str_passwd') ";
								$SQL_QUERY .= " WHERE
									STR_USERID='$arr_Auth[0]' ";

			$result=mysql_query($SQL_QUERY);
			
			?>
			<script language="javascript">
				alert("정상 수정되었습니다.");
				parent.window.location.href="user_info.php";
			</script>
			<?
			exit;
			break;	
		case "UPDATE" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_POST";
			$arr_Column_Name[1]		= "STR_ADDR1";
			$arr_Column_Name[2]		= "STR_ADDR2";
			$arr_Column_Name[3]		= "STR_EMAIL";
			$arr_Column_Name[4]		= "STR_MAIL_F";
			
			$arr_Set_Data[0]		= $str_post;
			$arr_Set_Data[1]		= $str_addr1;
			$arr_Set_Data[2]		= $str_addr2;			
			$arr_Set_Data[3]		= $str_email;
			$arr_Set_Data[4]		= $str_mail_f;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
 
			}

			$Sql_Query = "UPDATE `".$Tname."comm_member` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_USERID='".$arr_Auth[0]."' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				alert("정상 수정되었습니다.");
				parent.window.location.href="user_info.php";
			</script>
			<?
			exit;
			break;
			
		case "CERT" :
		
		    $authtype = "";      	// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드
		    	
			$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
			$customize 	= "";			//없으면 기본 웹페이지 / Mobile : 모바일페이지
		    
		    $reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
		                                    // 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
		    $reqseq = `$cb_encode_path SEQ $sitecode`;
		    
		    // CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
		    $returnurl = "http://".$_SERVER["HTTP_HOST"]."/mypage/checkplus_success.php";	// 성공시 이동될 URL
		    $errorurl = "http://".$_SERVER["HTTP_HOST"]."/mypage/checkplus_fail.php";		// 실패시 이동될 URL
			
		    // reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.
		    
		    $_SESSION["REQ_SEQ"] = $reqseq;
		
		    // 입력될 plain 데이타를 만든다.
		    $plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
					    			  "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
					    			  "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
					    			  "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
					    			  "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
					    			  "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
					    			  "9:CUSTOMIZE" . strlen($customize) . ":" . $customize ;
		    
		    $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;
		    
		    echo $enc_data;
		
		    if( $enc_data == -1 )
		    {
		        $returnMsg = "암/복호화 시스템 오류입니다.";
		        $enc_data = "";
		    }
		    else if( $enc_data== -2 )
		    {
		        $returnMsg = "암호화 처리 오류입니다.";
		        $enc_data = "";
		    }
		    else if( $enc_data== -3 )
		    {
		        $returnMsg = "암호화 데이터 오류 입니다.";
		        $enc_data = "";
		    }
		    else if( $enc_data== -9 )
		    {
		        $returnMsg = "입력값 오류 입니다.";
		        $enc_data = "";
		    }
		
			exit;
			break;		
	}

?>
