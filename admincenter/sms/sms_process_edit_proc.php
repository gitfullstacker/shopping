<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
	Fnc_Acc_Admin();
	//Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_mailtype = Fnc_Om_Conv_Default($_REQUEST[str_mailtype],"1");

	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
	$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun],"");

	$Txt_name = Fnc_Om_Conv_Default($_REQUEST[Txt_name],"");
	$Txt_pass = Fnc_Om_Conv_Default($_REQUEST[Txt_pass],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	
	$str_mailtitle = Fnc_Om_Conv_Default($_REQUEST[str_mailtitle],"");
	$str_mailcode = Fnc_Om_Conv_Default($_REQUEST[str_mailcode],"");
	
	$str_mailname = Fnc_Om_Conv_Default($_REQUEST[str_mailname],"");
	$str_mailemail = Fnc_Om_Conv_Default($_REQUEST[str_mailemail],"");
	$str_mailcontents = unescape(Fnc_Om_Conv_Default($_REQUEST[str_mailcontents],""));
	

	$SQL_QUERY = "select * from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_sms_master
			where
				int_number='".$str_mailcode."' " ;

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	$str_mailshp = $arr_Data['STR_SHP'];
	$str_mailcontents = $arr_Data['STR_CONTENTS'];



	$chkItem1 = $_REQUEST[chkItem1];

	$Temp_Cnt = 0;

	switch($RetrieveFlag){
     	case "SMAIL" :
     	
			switch($str_mailtype){
		     	case "1" :
		     	
		     		for($i=0;$i<count($chkItem1);$i++) {

		     			$sTemp = explode("|", "$chkItem1[$i]");
		     			
		     			If ($sTemp[1]!="--") {
		     			
							$SQL_QUERY="select count(*) from ";
							$SQL_QUERY.=$Tname;
							$SQL_QUERY.="comm_sms_history a where a.int_number='".$str_mailcode."' AND a.int_mnumber='".$sTemp[0]."' ";
							$result = mysql_query($SQL_QUERY);
						
							if(!result){
							   error("QUERY_ERROR");
							   exit;
							}
							$total_record = mysql_result($result,0,0);
							
							if ($total_record==0) {
								$SQL_QUERY =	"INSERT ".$Tname."comm_sms_history (INT_NUMBER,INT_MNUMBER,DTM_INDATE) VALUES ('$str_mailcode','".$sTemp[0]."','".date("Y-m-d H:i:s")."') ";
								$result = mysql_query($SQL_QUERY);
								
								

								
								fnc_sms_Send($str_mailshp,$sTemp[1], $str_mailcontents);

								//$str_mailcontents2=$str_mailcontents."<IMG Src=http://".$_SERVER["HTTP_HOST"]."/admincenter/mail/mail_check.php?str_mailcode=".$str_mailcode."&str_userid=".$sTemp[0]." width=0 height=0 border=0>";
								//Fnc_Om_Sendmail($str_mailtitle, $str_mailcontents2, $str_mailemail, $sTemp[2]);
								
								$Temp_Cnt++;
							}
						
						}
		     		}
		     		break;
		     		
		     	case "2" :
		     	
					If ($Txt_gubun!="") { $Str_Query .= " and a.str_gubun = '$Txt_gubun' ";}
					If ($Txt_name!="") { $Str_Query .= " and a.str_name like '%$Txt_name%' ";}
					If ($Txt_pass!="") { $Str_Query .= " and a.str_pass = '$Txt_pass' ";}
				
					if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
					if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}
		     	
					$SQL_QUERY = "select a.* from ";
					$SQL_QUERY.=$Tname;
					$SQL_QUERY.="comm_requ a ";
					$SQL_QUERY.="where a.int_number is not null and a.str_pass in ('2','3') ";
					$SQL_QUERY.=$Str_Query;
					$SQL_QUERY.="order by a.dtm_indate desc ";
					$result = mysql_query($SQL_QUERY);
					
					while($row=mysql_fetch_array($result)){
					
						If ($row[STR_TELEP]!="--") {
						
							$SQL_QUERY="select count(*) from ";
							$SQL_QUERY.=$Tname;
							$SQL_QUERY.="comm_sms_history a where a.int_number='".$str_mailcode."' AND a.int_mnumber='".$row[INT_NUMBER]."' ";

							$result1 = mysql_query($SQL_QUERY);
						
							if(!result1){
							   error("QUERY_ERROR");
							   exit;
							}
							$total_record = mysql_result($result1,0,0);
						
							if ($total_record==0) {
								$SQL_QUERY =	"INSERT ".$Tname."comm_sms_history (INT_NUMBER,INT_MNUMBER,DTM_INDATE) VALUES ('$str_mailcode','".$row[INT_NUMBER]."','".date("Y-m-d H:i:s")."') ";
								$result2 = mysql_query($SQL_QUERY);
								
								//$str_mailcontents2=$str_mailcontents."<IMG Src=http://".$_SERVER["HTTP_HOST"]."/admincenter/mail/mail_check.php?str_mailcode=".$str_mailcode."&str_userid=".$row[STR_USERID]." width=0 height=0 border=0>";
								//Fnc_Om_Sendmail($str_mailtitle, $str_mailcontents2, $str_mailemail, $row[STR_EMAIL]);
								
								$Temp_Cnt++;
							}
						
						}
						
					}
	     	
		     		break;
		     		
		    }
     		?>
			<script language="javascript">
				alert("총 <?=$Temp_Cnt?>명의 문자 발송을 성공하였습니다.");
				parent.document.frm.action = "sms_process_list.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			
			</script>		     		
     		<?
			break;
     	case "ADEL" :
     	
			$SQL_QUERY =	"DELETE FROM ".$Tname."comm_sms_history WHERE int_number = '".$str_mailcode."' ";
			$result = mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				alert("초기화에 성공하였습니다.");
				parent.document.frm.action = "sms_process_list.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			
			</script>
			<?

			break;     	
     }
?>

