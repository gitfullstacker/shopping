<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?

	$str_userid = $_REQUEST[str_userid];
	$str_passwd = $_REQUEST[str_passwd];

	$SQL_QUERY =	" SELECT
					 OM.STR_USERID,
					 OM.INT_GUBUN,
					 OM.STR_NAME,
					 OM.STR_MENU_LEVEL,
					 '' AS STR_HP,
					 OM.STR_TELEP,
					 OM.STR_EMAIL
				 FROM " ;
	$SQL_QUERY .= $Tname;
	$SQL_QUERY .= "comm_member AS OM
				 WHERE
					 OM.STR_USERID='$str_userid'
					 AND
					 OM.STR_PASSWD=password('$str_passwd')
					 AND
					 OM.STR_SERVICE='Y'
					 AND
					 OM.INT_GUBUN>=1";

	$rel=mysql_query($SQL_QUERY);
	$rcd_cnt=mysql_num_rows($rel);

	if(!$rcd_cnt){ ?>
		<script language=javascript>
			{
					alert("\n회원아이디나 비밀번호가 틀립니다\n다시한번 확인해 주세요.")
					window.location="javascript: history.go(-1)"
			}
		</script>
	<?
		exit;
	} else {

		$sTemp=base64_encode(mysql_result($rel,0,STR_USERID))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,INT_GUBUN))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,STR_NAME))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,STR_MENU_LEVEL))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,STR_HP))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,STR_TELEP))."~";
		$sTemp.=base64_encode(mysql_result($rel,0,STR_EMAIL))."~";
		$sTemp.=base64_encode(Fnc_Om_Select_Code("0000000",mysql_result($rel,0,STR_MENU_LEVEL)))."~";

		$_SESSION['COK_USER_INFO_DATA']=$sTemp;
		//setcookie("COK_USER_INFO_DATA",$sTemp,0,"/");

		$SQL_QUERY =	"UPDATE ".$Tname."COMM_MEMBER SET INT_LOGIN=INT_LOGIN+1,DTM_ACDATE='".date("Y-m-d H:i:s")."' WHERE STR_USERiD='$STR_USERID' ";
		$result=mysql_query($SQL_QUERY);


		//Header( "Location: ".Fnc_Om_Select_Url(Fnc_Om_Select_Code("0000000",mysql_result($rel,0,STR_MENU_LEVEL))) );
		Fnc_Om_Move_Link(Fnc_Om_Select_Url(Fnc_Om_Select_Code("0000000",mysql_result($rel,0,STR_MENU_LEVEL))),"","");
		exit;

	}
?>