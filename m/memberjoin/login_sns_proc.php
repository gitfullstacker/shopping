<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/Snoopy.class.php"; ?>
<?
// retrieve encoded user information from URL parameter
$type = $_GET['type'];
$user_info = $_GET['user_info'];

// decode user information from JSON format
$user = json_decode($user_info, true);

$str_userid = '';
$str_email = '';
$str_photo = '';
$str_sex = '0';
$str_hp = '';
$str_name = '';
$str_birth = '';

switch ($type) {
	case 'naver':
		$str_userid = $user['response']['nickname'];
		$str_email = $user['response']['email'];
		$str_photo = $user['response']['profile_image'];
		$str_sex = $user['response']['gender'] == "M" ? "1" : ($user['response']['gender'] == "F" ? "2" : "0");
		$str_hp = $user['response']['mobile'];
		$str_name = $user['response']['name'];
		$str_birth = $user['response']['birthyear'] . str_replace('-', '', $user['response']['birthday']);
		break;
	case 'kakao':
		$str_userid = $user['kakao_account']['profile']['nickname'];
		$str_email = $user['kakao_account']['email'];
		$str_photo = $user['kakao_account']['profile']['thumbnail_image_url'];
		$str_sex = $user['kakao_account']['gender'] == "male" ? "1" : ($user['kakao_account']['gender'] == "female" ? "2" : "0");
		// $str_hp = $user['kakao_account']['profile']['mobile'];
		// $str_name = $user['kakao_account']['profile']['name'];
		// $str_birth = $user['kakao_account']['birthday'];
		break;
}

$idsave = "0";
$idsession = "0";

$SQL_QUERY =	" SELECT
					 OM.STR_USERID,
					 OM.INT_GUBUN,
					 OM.STR_NAME,
					 OM.STR_MENU_LEVEL,
					 OM.STR_HP,
					 OM.STR_TELEP,
					 OM.STR_EMAIL,
					 '' AS STR_LEV
				 FROM ";
$SQL_QUERY .= $Tname;
$SQL_QUERY .= "comm_member AS OM
				 WHERE
					 OM.STR_EMAIL='$str_email'
					 AND
					 OM.STR_USERID='$str_userid'
					 AND
					 OM.STR_SERVICE='Y'
					 AND
					 OM.INT_GUBUN<=91";

$rel = mysql_query($SQL_QUERY);
$rcd_cnt = mysql_num_rows($rel);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNS PROC</title>
</head>

<body>
	<form name="join_frm" action="/m/memberjoin/join_proc.php" method="post">
		<input type="hidden" name="join_type" value="sns">
		<input type="hidden" name="str_userid" value="<?= $str_userid ?>">
		<input type="hidden" name="str_email" value="<?= $str_email ?>">
		<input type="hidden" name="str_sex" value="<?= $str_sex ?>">
		<input type="hidden" name="str_hp" value="<?= $str_hp ?>">
		<input type="hidden" name="str_name" value="<?= $str_name ?>">
		<input type="hidden" name="str_birth" value="<?= $str_birth ?>">
	</form>
	<form name="login_frm" action="/m/memberjoin/login_proc.php" method="post">
		<input type="hidden" name="login_type" value="sns">
		<input type="hidden" name="str_email" value="<?= $str_email ?>">
		<input type="hidden" name="str_userid" value="<?= $str_userid ?>">
	</form>
	<?php
	if (!$rcd_cnt) {
	?>
		<script language="javascript">
			document.join_frm.submit();
		</script>
	<?
	} else {
	?>
		<script language=javascript>
			document.login_frm.submit();
		</script>
	<?
	}
	?>
</body>

</html>