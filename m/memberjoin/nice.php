<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$enc_data = Fnc_Om_Conv_Default($_REQUEST['enc_data'], "");
$gubun = Fnc_Om_Conv_Default($_REQUEST['gubun'], "");
exit;
?>
<html>

<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
	<form name="form_chk" method="post">
		<input type="hidden" name="m" id="m" value="checkplusSerivce"> <!-- 필수 데이타로, 누락하시면 안됩니다. -->
		<input type="hidden" name="EncodeData" id="EncodeData" value="<?= $enc_data ?>"> <!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
		<input type="hidden" name="param_r1" id="param_r1" value="<?= $gubun ?>">
		<input type="hidden" name="param_r2" id="param_r2" value="">
		<input type="hidden" name="param_r3" id="param_r3" value="">
	</form>

	<script language="javascript">
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.submit();
	</script>
</body>

</html>