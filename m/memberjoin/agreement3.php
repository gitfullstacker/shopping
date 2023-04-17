<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/join.js"></script>
		
		<div class="con_width" >
			
			
			<form id="frm" name="frm" target="_self" method="POST" action="join02.php" style="padding-bottom:40px;">
		
			
			<p class="f_bk mt105" style="padding-left: 10px;">개인정보 제공/조회 동의</p>
			<div class="join_agree_bx02 mt10">
				<div class="frame_bx" style="height:400px;"><iframe src="agreement3.html" frameborder="0"></iframe></div>
					</div>

			
			</form>
			
			<form name="form_chk" method="post">
				<input type="hidden" name="m" id="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
				<input type="hidden" name="EncodeData" id="EncodeData" value="<?= $enc_data ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
			    
			    <!-- 업체에서 응답받기 원하는 데이타를 설정하기 위해 사용할 수 있으며, 인증결과 응답시 해당 값을 그대로 송신합니다.
			    	 해당 파라미터는 추가하실 수 없습니다. -->
				<input type="hidden" name="param_r1" id="param_r1" value="">
				<input type="hidden" name="param_r2" id="param_r2" value="">
				<input type="hidden" name="param_r3" id="param_r3" value="">
			</form>


		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>


