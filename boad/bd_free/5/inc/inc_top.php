<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
switch (Fnc_Om_Conv_Default($_REQUEST[bd],"1")) {
	case  "5" :
		$pageNum="06";
		$subNum="62";
		$stitle1 = "1";
		$stitle2 = "0";
		$stitle3 = "/images/board/title02.jpg";
		$stitle4="게시판 > 자유게시판";
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
