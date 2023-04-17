<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
switch (Fnc_Om_Conv_Default($_REQUEST[bd],"1")) {
	case  "1" :
		$pageNum="02";
		$subNum="22";
		$stitle1 = "2";
		$stitle2 = "0";
		$stitle3 = "/images/information/title02.jpg";
		$stitle4="공연안내 > 공연 사진";
		break;
	case  "2" :
		$pageNum="02";
		$subNum="23";
		$stitle1 = "3";
		$stitle2 = "0";
		$stitle3 = "/images/information/title03.jpg";
		$stitle4="공연안내 > 공연 동영상";
		break;
	case  "3" :
		$pageNum="04";
		$subNum="42";
		$stitle1 = "4";
		$stitle2 = "0";
		$stitle3 = "/images/performance/title02.jpg";
		$stitle4="출장공연 > 출장공연 사진";
		break;
}
?>
<? include_once $_SERVER[DOCUMENT_ROOT] . "/inc/header.php"; ?>

<div id="wrapper_sub">
<? include_once $_SERVER[DOCUMENT_ROOT] . "/inc/top.php"; ?>

<script type="text/javascript">
$(function(){
	$('#lnb').menuModel({
		hightLight:{level_1:<?=$stitle1?>,level_2:<?=$stitle2?>},imgOn:'on.png',imgOff:'.png',target_obj:'#lnb',showOps:{display:'block'},hideOps:{display:'none'}
	});
	$('#lnb ul').css('display','none');
});
</script>

<? include_once $_SERVER[DOCUMENT_ROOT] . "/inc/s_visual.php"; ?>
