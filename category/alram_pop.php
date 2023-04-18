<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$Tcnt = Fnc_Om_Conv_Default($_REQUEST[Tcnt],"0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ABLANC</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<link type="text/css" rel="stylesheet" href="../css/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" src="../js/common_gnb.js"></script>
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
			$(".search_close").click(function(){
				$("#search_menu").hide();
			});
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
<body style="background:#ccc;overflow-x:hidden;overflow-y:hidden;">
	<div class="pop_w02 w485">
		<div class="pop_close"><a href="javascript:parent.closeLayer();"><img src="../images/common/btn_pop_close02.png" alt="" /></a></div>
		<div class="pop_con">
			<p class="in_al01">입고알림받기</p>
			<p class="in_al02 mt30">이 가방에 대한 입고알림 대기자는 현재 <span class="f_bd"><?=$Tcnt?>명</span>입니다.</p>
			<div class="in_al03 mt20">
				<p>지금 알림받기를 누르시면</p>
				<p class="em">해당 가방이 입고 되었을 시</p>
				<p>입고알림을 받으실 수 있습니다.</p>
			</div>
			<div class="in_al04 mt20">※입고알림 신청은 3개의 가방까지 가능하며 <br />[마이 페이지-입고알림 가방] 에서 확인 하실 수 있습니다.</div>
			<div class="in_al05 mt20"><a href="/cscenter/guide.php#guide05" target="_blank">입고알림 서비스 상세보기</a></div>
			<div class="center mt25">
				<a href="javascript:parent.closeLayer();" class="btn btn_m btn_wt w125">취소</a>
				<a href="javascript:Click_Alarm_In('<?=$str_goodcode?>');" class="btn btn_m btn_bk w125">알림받기</a>
			</div>
		</div>
	</div>
</body>
</html>