<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
switch (Fnc_Om_Conv_Default($_REQUEST[bd],"1")) {
	case  "1" :
		$pageNum="02";
		$subNum="21";
		$subNums="211";
		$stitle1 = "2";
		$stitle2 = "1";
		$stitle3 = "submenu1";
		$stitle4="/kor/images/product/title01_01.jpg";
		$stitle5="Memory Group (Own Products) > SSD Tester";
		break;
	case  "2" :
		$pageNum="02";
		$subNum="21";
		$subNums="212";
		$stitle1 = "2";
		$stitle2 = "1";
		$stitle3 = "submenu1";
		$stitle4="/kor/images/product/title01_02.jpg";
		$stitle5="Memory Group (Own Products) > Mobile Memory Tester";
		break;
	case  "3" :
		$pageNum="02";
		$subNum="21";
		$subNums="213";
		$stitle1 = "2";
		$stitle2 = "1";
		$stitle3 = "submenu1";
		$stitle4="/kor/images/product/title01_03.jpg";
		$stitle5="Memory Group (Own Products) > Test BI Tester (TBT)";
		break;
	case  "4" :
		$pageNum="02";
		$subNum="22";
		$subNums="221";
		$stitle1 = "2";
		$stitle2 = "2";
		$stitle3 = "submenu2";
		$stitle4="/kor/images/product/title02_01.jpg";
		$stitle5="Systems Group (Distribution Biz) > UIC";
		break;
	case  "5" :
		$pageNum="02";
		$subNum="22";
		$subNums="222";
		$stitle1 = "2";
		$stitle2 = "2";
		$stitle3 = "submenu2";
		$stitle4="/kor/images/product/title02_02.jpg";
		$stitle5="Systems Group (Distribution Biz) > LTXC";
		break;
	case  "6" :
		$pageNum="02";
		$subNum="22";
		$subNums="223";
		$stitle1 = "2";
		$stitle2 = "2";
		$stitle3 = "submenu2";
		$stitle4="/kor/images/product/title02_03.jpg";
		$stitle5="Systems Group (Distribution Biz) > boston semi equipment";
		break;
	case  "7" :
		$pageNum="02";
		$subNum="22";
		$subNums="224";
		$stitle1 = "2";
		$stitle2 = "2";
		$stitle3 = "submenu2";
		$stitle4="/kor/images/product/title02_04.jpg";
		$stitle5="Systems Group (Distribution Biz) > Pentagon";
		break;
	case  "8" :
		$pageNum="02";
		$subNum="22";
		$subNums="225";
		$stitle1 = "2";
		$stitle2 = "2";
		$stitle3 = "submenu2";
		$stitle4="/kor/images/product/title02_05.jpg";
		$stitle5="Systems Group (Distribution Biz) > TSSI";
		break;
}
?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/kor/inc/header.php"; ?>

<script type="text/javascript">
//<![CDATA[
$(function(){
	$('#gnb').menuModel({
		hightLight:{level_1:<?=$stitle1?>,level_2:<?=$stitle2?>},imgOn:'on.jpg',imgOff:'.jpg',target_obj:'#gnb',showOps:{display:'block'},hideOps:{display:'none'}
	});
});
//]]>
</script>