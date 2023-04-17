<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$str_passwd = Fnc_Om_Conv_Default($_REQUEST[str_passwd],"");
	$str_escecode = Fnc_Om_Conv_Default($_REQUEST[str_escecode],"");
	$str_drcontents = Fnc_Om_Conv_Default($_REQUEST[str_drcontents],"");

	switch($RetrieveFlag){
		case "ESC" :
	
			$SQL_QUERY = "select * from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "comm_member
					where
						STR_USERID='".$arr_Auth[0]."'
						AND STR_PASSWD=password('$str_passwd') ";

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
					$SQL_QUERY .= "STR_SERVICE='E' ";
					$SQL_QUERY .= ",STR_ESCECODE='$str_escecode' ";
					$SQL_QUERY .= ",STR_DRCONTENTS='$str_drcontents' ";
								$SQL_QUERY .= " WHERE
									STR_USERID='".$arr_Auth[0]."' ";

			mysql_query($SQL_QUERY);
			
			$str_email = $arr_Auth[6];
			

			$SQL_QUERY = " DELETE FROM ".$Tname."comm_member_alarm WHERE STR_USERID='".$arr_Auth[0]."' ";
			mysql_query($SQL_QUERY);

			session_destroy();
			
			//$subject="DOUBLEWIN 웹사이트의 회원 탈퇴 완료.";
			//$str_Mail_Tag = $_SERVER[DOCUMENT_ROOT]."/mail/mail4.php";
			//$mail_con = load_file ($str_Mail_Tag);
			//$mail_con = str_replace("domain",$_SERVER["HTTP_HOST"],$mail_con);
			//Fnc_Om_Sendmail($subject, $mail_con, Fnc_Om_Store_Info(2), $str_email);
			?>
			<script language="javascript">
				alert("탈퇴가 정상적으로 처리되었습니다.\n그동안 에이블랑을 이용해 주셔서 감사합니다.");
				parent.window.location.href="/main/index.php";
			</script>
			<?

			exit;
			break;	
	}

?>
