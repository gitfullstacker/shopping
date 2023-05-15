<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
    $authtype = "";      	// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드
    	
	$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
	$customize 	= "";			//없으면 기본 웹페이지 / Mobile : 모바일페이지
    
    $reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
                                    // 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
    $reqseq = `$cb_encode_path SEQ $sitecode`;
    
    // CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
    $returnurl = "http://".$_SERVER["HTTP_HOST"]."/m/memberjoin/checkplus_success.php";	// 성공시 이동될 URL
    $errorurl = "http://".$_SERVER["HTTP_HOST"]."/m/memberjoin/checkplus_fail.php";		// 실패시 이동될 URL
	
    // reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.
    
    $_SESSION["REQ_SEQ"] = $reqseq;

    // 입력될 plain 데이타를 만든다.
    $plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
			    			  "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
			    			  "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
			    			  "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
			    			  "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
			    			  "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
			    			  "9:CUSTOMIZE" . strlen($customize) . ":" . $customize ;
    
    $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

    if( $enc_data == -1 )
    {
        $returnMsg = "암/복호화 시스템 오류입니다.";
        $enc_data = "";
    }
    else if( $enc_data== -2 )
    {
        $returnMsg = "암호화 처리 오류입니다.";
        $enc_data = "";
    }
    else if( $enc_data== -3 )
    {
        $returnMsg = "암호화 데이터 오류 입니다.";
        $enc_data = "";
    }
    else if( $enc_data== -9 )
    {
        $returnMsg = "입력값 오류 입니다.";
        $enc_data = "";
    }
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/join.js"></script>
		
		<div class="con_width" >
			
			
			<form id="frm" name="frm" target="_self" method="POST" action="join02.php">
			<input type="hidden" name="str_cert" id="str_cert" value="M">
			<input type="hidden" name="str_name" id="str_name" value="">
			<input type="hidden" name="str_hp" id="str_hp" value="">
			<input type="hidden" name="str_birth" id="str_birth" value="">
			<input type="hidden" name="str_sex" id="str_sex" value="">
			
			<p class="f_bk mt105">에이블랑은 개인정보처리방침에 따라 아래와 같이 회원의 개인정보를 수집∙이용하고 있습니다.</p>
			<div class="join_agree_bx02 mt10">
				<div class="frame_bx"><iframe src="use_txt.html" frameborder="0"></iframe></div>
				<p class="frame_ck"><label><input type="checkbox" name="str_agree1" class="cform" /> 위의 이용 약관 및 개인정보처리방침을 확인하였고 이에 동의합니다.</label></p>
			</div>

			<div class="personal_certification" style="margin-bottom: 50px;">
				<dl>
					<dt>휴대폰 본인확인</dt>
					<dd class="txt">본인 명의의 휴대폰으로 인증번호를 <span>전송 받아 확인하는 방법입니다.</span></dd>
					<dd class="mt20"><a href="javascript:Save_Click();" class="btn btn_m btn_bk w60p">휴대폰 본인확인하기</a></dd>
				</dl>
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

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>


