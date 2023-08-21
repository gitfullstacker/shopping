<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST['RetrieveFlag'], "");
$str_name = Fnc_Om_Conv_Default($_REQUEST['str_name'], "");
$str_hp = Fnc_Om_Conv_Default($_REQUEST['str_hp1'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp2'], "") . "-" . Fnc_Om_Conv_Default($_REQUEST['str_hp3'], "");
$str_userid = Fnc_Om_Conv_Default($_REQUEST['str_userid'], "");
$str_rname = Fnc_Om_Conv_Default($_REQUEST['str_rname'], "");
$str_password = Fnc_Om_Conv_Default($_REQUEST['str_password'], "");

switch ($RetrieveFlag) {
	case "IDCHECK":

		$SQL_QUERY = "select * from ";
		$SQL_QUERY .= $Tname;
		$SQL_QUERY .= "comm_member
					where
						STR_NAME='$str_name'
						AND 
						STR_HP='$str_hp' 
						AND 
						STR_SERVICE='Y' ";

		$arr_sub_Data = mysql_query($SQL_QUERY);
		$user_Data = mysql_fetch_assoc($arr_sub_Data);
		$rcd_cnt = mysql_num_rows($arr_sub_Data);

		if (!($rcd_cnt)) {
?>
			<script language="javascript">
				alert("회원정보가 일치하지 않습니다.");
				window.location.href = "idpw_search.php?menu=1&id_step=1";
			</script>
		<?
		} else {
			// $snoopy = new snoopy;
			// $snoopy->fetch("http://" . $loc_I_Pg_Domain . "/mailing/mailing_id.html?str_name=" . urlencode(mysql_result($arr_sub_Data, 0, STR_NAME)) . "&str_userid=" . urlencode(mysql_result($arr_sub_Data, 0, STR_USERID)));
			// $body = $snoopy->results;

			// Fnc_Om_Sendmail("회원님께서 요청하신 아이디를 알려드립니다.", $body, Fnc_Om_Store_Info(2), mysql_result($arr_sub_Data, 0, STR_EMAIL));
		?>
			<script language="javascript">
				// alert("회원님의 이메일로 아이디를 발송해 드렸습니다.");
				window.location.href = "idpw_search.php?menu=1&id_step=2&user_id=<?= $user_Data['STR_USERID'] ?>";
			</script>
		<?
			exit;
			break;
		}

	case "PWCHECK":
		$SQL_QUERY = "select * from ";
		$SQL_QUERY .= $Tname;
		$SQL_QUERY .= "comm_member
					where
						STR_USERID='$str_userid'
						AND 
						STR_NAME='$str_rname'
						AND 
						STR_HP='$str_hp' ";

		$arr_sub_Data = mysql_query($SQL_QUERY);
		$rcd_cnt = mysql_num_rows($arr_sub_Data);

		if (!($rcd_cnt)) {
		?>
			<script language="javascript">
				alert("회원정보가 일치하지 않습니다.");
				window.location.href = "idpw_search.php?menu=2&id_step=1";
			</script>
		<?
		} else {
		?>
			<script language="javascript">
				window.location.href = "idpw_search.php?menu=2&pwd_step=2&str_userid=<?= $str_userid ?>&str_rname=<?= $str_rname ?>&str_hp=<?= $str_hp ?>";
			</script>
		<?
		}
		exit;
		break;
	case "PWSET":
		
		$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_PASSWD=password('$str_password') WHERE STR_USERID='$str_userid' AND STR_NAME='$str_rname' AND STR_HP='$str_hp'";
		mysql_query($Sql_Query);

		echo 'successful';
		exit;
		break;
}

?>