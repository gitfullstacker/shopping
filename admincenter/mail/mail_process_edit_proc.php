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
	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_mail_f = Fnc_Om_Conv_Default($_REQUEST[Txt_mail_f],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");
	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");
	
	$str_mailtitle = Fnc_Om_Conv_Default($_REQUEST[str_mailtitle],"");
	$str_mailcode = Fnc_Om_Conv_Default($_REQUEST[str_mailcode],"");
	
	$str_mailname = Fnc_Om_Conv_Default($_REQUEST[str_mailname],"");
	$str_mailemail = Fnc_Om_Conv_Default($_REQUEST[str_mailemail],"");
	$str_mailcontents = unescape(Fnc_Om_Conv_Default($_REQUEST[str_mailcontents],""));
	

	$SQL_QUERY = "select * from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_mail_master
			where
				int_number='".$str_mailcode."' " ;

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	
	$str_mailcontents = $arr_Data['STR_CONTENTS'];

	$chkItem1 = $_REQUEST[chkItem1];

	$Temp_Cnt = 0;

	switch($RetrieveFlag){
     	case "SMAIL" :
     	
			switch($str_mailtype){
		     	case "1" :
		     	
		     		for($i=0;$i<count($chkItem1);$i++) {

		     			$sTemp = explode("|", "$chkItem1[$i]");
		     			
		     			If ($sTemp[2]!="") {
		     			
							$SQL_QUERY="select count(*) from ";
							$SQL_QUERY.=$Tname;
							$SQL_QUERY.="comm_mail_history a where a.int_number='".$str_mailcode."' AND a.str_userId='".$sTemp[0]."' ";
							$result = mysql_query($SQL_QUERY);
						
							if(!result){
							   error("QUERY_ERROR");
							   exit;
							}
							$total_record = mysql_result($result,0,0);
							
							if ($total_record==0) {
								$SQL_QUERY =	"INSERT ".$Tname."comm_mail_history (INT_NUMBER,STR_USERID,STR_READ_F,DTM_INDATE,DTM_RDATE) VALUES ('$str_mailcode','".$sTemp[0]."','N','".date("Y-m-d H:i:s")."','') ";
								$result = mysql_query($SQL_QUERY);
								
								$str_mailcontents2=$str_mailcontents."<IMG Src=http://".$_SERVER["HTTP_HOST"]."/admincenter/mail/mail_check.php?str_mailcode=".$str_mailcode."&str_userid=".$sTemp[0]." width=0 height=0 border=0>";
								Fnc_Om_Sendmail($str_mailtitle, $str_mailcontents2, $str_mailemail, $sTemp[2]);
								
								$Temp_Cnt++;
							}
						
						}
		     		}
		     		break;
		     		
		     	case "2" :
		     	
					If ($Txt_gubun!="") { $Str_Query .= " and a.int_gubun = '$Txt_gubun' ";}
					
					If ($Txt_word!="") {
						switch ($Txt_key) {
							case  "all" :
								$Str_Query = " and (a.str_name like '%$Txt_word%' or a.str_email like '%$Txt_word%') ";
								break;
							case  "str_name" :
								$Str_Query = " and a.str_name like '%$Txt_word%' ";
								break;
							case  "str_email" :
								$Str_Query = " and a.str_email like '%$Txt_word%' ";
								break;
						}
					}
					
					If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
					If ($Txt_mail_f!="") { $Str_Query .= " and a.str_mail_f = '$Txt_mail_f' ";}
				
					if ($Txt_sindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') >= '$Txt_sindate' ";}
					if ($Txt_eindate!="") { $Str_Query .= " and date_format(a.dtm_indate, '%Y-%m-%d') <= '$Txt_eindate' ";}
		     	
					$SQL_QUERY = "select a.* from ";
					$SQL_QUERY.=$Tname;
					$SQL_QUERY.="comm_member a ";
					$SQL_QUERY.="where a.str_userid is not null and a.int_gubun <= 90 ";
					$SQL_QUERY.=$Str_Query;
					$SQL_QUERY.="order by a.dtm_indate desc ";
					$result = mysql_query($SQL_QUERY);
					
					while($row=mysql_fetch_array($result)){
					
						If ($row[STR_EMAIL]!="") {
						
							$SQL_QUERY="select count(*) from ";
							$SQL_QUERY.=$Tname;
							$SQL_QUERY.="comm_mail_history a where a.int_number='".$str_mailcode."' AND a.str_userId='".$row[STR_USERID]."' ";

							$result1 = mysql_query($SQL_QUERY);
						
							if(!result1){
							   error("QUERY_ERROR");
							   exit;
							}
							$total_record = mysql_result($result1,0,0);
						
							if ($total_record==0) {
								$SQL_QUERY =	"INSERT ".$Tname."comm_mail_history (INT_NUMBER,STR_USERID,STR_READ_F,DTM_INDATE,DTM_RDATE) VALUES ('$str_mailcode','".$row[STR_USERID]."','N','".date("Y-m-d H:i:s")."','') ";
								$result2 = mysql_query($SQL_QUERY);
								
								$str_mailcontents2=$str_mailcontents."<IMG Src=http://".$_SERVER["HTTP_HOST"]."/admincenter/mail/mail_check.php?str_mailcode=".$str_mailcode."&str_userid=".$row[STR_USERID]." width=0 height=0 border=0>";
								Fnc_Om_Sendmail($str_mailtitle, $str_mailcontents2, $str_mailemail, $row[STR_EMAIL]);
								
								$Temp_Cnt++;
							}
						
						}
						
					}
	     	
		     		break;
		     		
		    }
     		?>
			<script language="javascript">
				alert("총 <?=$Temp_Cnt?>명의 메일 발송을 성공하였습니다.");
				parent.document.frm.action = "mail_process_list.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			
			</script>		     		
     		<?
			break;
     	case "ADEL" :
     	
			$SQL_QUERY =	"DELETE FROM ".$Tname."comm_mail_history WHERE int_number = '".$str_mailcode."' ";
			$result = mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				alert("초기화에 성공하였습니다.");
				parent.document.frm.action = "mail_process_list.php";
				parent.document.frm.target = "_self";
				parent.document.frm.submit();
			
			</script>
			<?

			break;     	
     }
?>

