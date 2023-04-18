<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
if (!wcs_add) var wcs_add={};
wcs_add["wa"] = "s_43703092bddc";
if (!_nasa) var _nasa={};
wcs.inflow("ablanc.co.kr");
wcs_do(_nasa);
</script>

<script language="javascript">
<?
	$chk_m = rtn_mobile_chk();
	
	if($chk_m == "PC"){
?>
	window.location.href="/main/index.php";
<?}else{?>
	window.location.href="/m/main/index.php";
<?}?>
</script>
