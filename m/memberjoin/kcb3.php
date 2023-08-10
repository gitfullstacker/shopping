<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
		
		
	<div class="con_width" style="padding-top:1px;">
			<div class="lin_tab mt20">
			
			<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/submenu_memberjoin.php"; ?>
			<script>
				function autosize(){
					var oFrame = top.document.getElementById("clause01");
					contentHeight = oFrame.contentWindow.document.body.scrollHeight;
					oFrame.style.height = String(contentHeight) + "px";
				} 
			</script>
			
			<div class="mt20">
				<iframe src="kcb3.html" id="clause01" frameborder="0" width="100%" height="100%" scrolling="no" onload="autosize()"></iframe>
			</div>

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>