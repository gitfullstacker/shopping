<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$Tcnt = Fnc_Om_Conv_Default($_REQUEST[Tcnt],"0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<title>ABLANC</title>
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />


	<link href="../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/swiper.min.css">
	<script src="../js/swiper.min.js"></script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<!-- jquery.mobilemenu -->
	<link href="../css/jquery.mobilemenu.css" type="text/css" rel="stylesheet" />
	<script src="../js/jquery.mobilemenu.js" type="text/javascript"></script>
	<script src="../js/main.js" type="text/javascript"></script>
	
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	<script>
	  $( function() {
		// run the currently selected effect
		function runEffect() {
		  // get effect type from
		  var selectedEffect = $( "#effectTypes" ).val();
	 
		  // Most effect types need no options passed by default
		  var options = {};
		  // some effects have required parameters
		  if ( selectedEffect === "scale" ) {
			options = { percent: 50 };
		  } else if ( selectedEffect === "size" ) {
			options = { to: { width: 200, height: 60 } };
		  }
	 
		  // Run the effect
		  $( "#search_menu" ).toggle( selectedEffect, options, 500 );
		};
	 
		// Set effect from select menu value
		$( "#button" ).on( "click", function() {
		  runEffect();
		});
	  } );
	</script>
	<script language="javascript" src="/pub/js/CommScript.js"></script>
	<script language="javascript" src="js/detail.js"></script>
</head>

<body>

	<div class="pop_w" id="pop_alram">
		<h1>입고알림받기</h1>
		<a href="javascript:parent.closeLayer();" class="pop_close"><img src="../images/btn_pop_close.png" alt="닫기" /></a>
		<div class="pop_con">
			<p class="in_al02 center">이 가방에 대한 입고알림 대기자는 <span class="f_bd f_ylw"><?=$Tcnt?>명</span>입니다.</p>
			<div class="in_al03 center mt10">
				<p>지금 알림받기를 누르시면</p>
				<p class="em">해당 가방이 입고 되었을 시</p>
				<p>입고알림을 받으실 수 있습니다.</p>
			</div>
			<div class="in_al04 center mt10">※입고알림 신청은 3개의 가방까지 가능하며 <br />[마이 페이지-입고알림 가방] 에서  <br />확인 하실 수 있습니다.</div>
			<div class="in_al05 center f_ylw mt10"><a href="/m/cscenter/updateyong.php" target="_blank">입고알림 서비스 상세보기</a></div>
			<div class="center mt25">
				<a href="javascript:parent.closeLayer();" class="btn btn_m btn_bk w30p f_bd">취소</a>
				<a href="javascript:Click_Alarm_In('<?=$str_goodcode?>');" class="btn btn_m btn_ylw w30p f_bd">알림받기</a>
			</div>
		</div>
	</div>

</body>
</html>

