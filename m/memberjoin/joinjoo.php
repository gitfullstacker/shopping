<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
    $authtype = "";      	// ������ �⺻ ����ȭ��, X: ����������, M: �ڵ���, C: ī��
    	
	$popgubun 	= "N";		//Y : ��ҹ�ư ���� / N : ��ҹ�ư ����
	$customize 	= "";			//������ �⺻ �������� / Mobile : �����������
    
    $reqseq = "REQ_0123456789";     // ��û ��ȣ, �̴� ����/�����Ŀ� ���� ������ �ǵ����ְ� �ǹǷ�
                                    // ��ü���� �����ϰ� �����Ͽ� ���ų�, �Ʒ��� ���� �����Ѵ�.
    $reqseq = `$cb_encode_path SEQ $sitecode`;
    
    // CheckPlus(��������) ó�� ��, ��� ����Ÿ�� ���� �ޱ����� ���������� ���� http���� �Է��մϴ�.
    $returnurl = "http://".$_SERVER["HTTP_HOST"]."/m/memberjoin/checkplus_success.php";	// ������ �̵��� URL
    $errorurl = "http://".$_SERVER["HTTP_HOST"]."/m/memberjoin/checkplus_fail.php";		// ���н� �̵��� URL
	
    // reqseq���� ������������ �� ��� ������ ���Ͽ� ���ǿ� ��Ƶд�.
    
    $_SESSION["REQ_SEQ"] = $reqseq;

    // �Էµ� plain ����Ÿ�� �����.
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
        $returnMsg = "��/��ȣȭ �ý��� �����Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -2 )
    {
        $returnMsg = "��ȣȭ ó�� �����Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -3 )
    {
        $returnMsg = "��ȣȭ ������ ���� �Դϴ�.";
        $enc_data = "";
    }
    else if( $enc_data== -9 )
    {
        $returnMsg = "�Է°� ���� �Դϴ�.";
        $enc_data = "";
    }
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/joinnew.js"></script>
		
		<div class="con_width" >
			
			
			<form id="frm" name="frm" target="_self" method="POST" action="join02.php">
			<input type="hidden" name="str_cert" id="str_cert" value="M">
			<input type="hidden" name="str_name" id="str_name" value="">
			<input type="hidden" name="str_hp" id="str_hp" value="">
			<input type="hidden" name="str_birth" id="str_birth" value="">
			<input type="hidden" name="str_sex" id="str_sex" value="">
			
			<p class="f_bk mt105" style="text-align:center; font-size:17px;">ȸ��/������ ��� ����</p>
			<p class="f_bk mt105" style="font-size:20px; font-weight: bolder; margin-bottom: 0.7em; letter-spacing: -1.5px">ȸ������</p>
			<p style="font-size:17px; letter-spacing: -1.5px; margin-bottom: 0.7em">����� ������ �ּ���.</p>
		
			<div class="join_agree_bx02 mt10" style="font-size:12px;">
				
				<!--p class="frame_dk" style="margin-top:5px; margin-bottom:15px; margin-left:5px;"><label><input type="checkbox" name="str_agree1" class="cform" /><a href="/m/memberjoin/agreement1.php"> [�ʼ�]&nbsp;���̺��� �̿� ��� ���� &nbsp;&nbsp; ></a></label></p-->
				
				<div class="frame_bx" style="margin-top: 15px; height:120px; border: 0; background: #EEEEEE"><iframe src="agreement2.html" frameborder="0"></iframe></div>
				<p class="frame_dk" style="margin-top:5px; margin-bottom:15px; margin-left:5px;"><label><input type="checkbox" name="str_agree2" class="cform" /><span style="font-size: 11px; font-weight: bold;">&nbsp;[�ʼ�]&nbsp;���̺��� �̿� ��� ���� </span><a href="/m/memberjoin/agreement2.php"><span style="font-size: 8px; color: #888888; float: right">�ڼ�������</span></a></label></p>
				<div class="frame_bx" style="margin-top: 15px; height:120px; border: 0; background: #EEEEEE"><iframe src="agreement3.html" frameborder="0"></iframe></div>
				<p class="frame_dk" style="margin-top:5px; margin-bottom:15px; margin-left:5px;"><label><input type="checkbox" name="str_agree3" class="cform" /><span style="font-size: 11px; font-weight: bold;">&nbsp; [�ʼ�]&nbsp;����(�ſ�)���� ���� ����</span><a href="/m/memberjoin/agreement3.php"><span style="font-size: 8px; color: #888888; float: right">�ڼ�������</span></a></label></p>					
				<div class="frame_bx" style="margin-top: 15px; height:120px; border: 0; background: #EEEEEE"><iframe src="agreement3.html" frameborder="0"></iframe></div>
				<p class="frame_dk" style="margin-top:5px; margin-bottom:15px; margin-left:5px;"><label><input type="checkbox" name="str_agree4" class="cform" /><span style="font-size: 11px; font-weight: bold;">&nbsp;[�ʼ�]&nbsp;����(�ſ�)���� ���� ���� </span><a href="/m/memberjoin/agreement3.php"><span style="font-size: 8px; color: #888888; float: right">�ڼ�������</span></a></label></p>		
			</div>
			

			<div class="personal_certification" style="margin: 46px 0; text-align: center; ">
				<dl>
					
					<dd class="mt20"><a href="javascript:Save_Click();" class="btn btn_m btn_bk w100p">�޴��� ����Ȯ���ϱ�</a></dd>
				</dl>
			</div>
			
			</form>
			
			<form name="form_chk" method="post">
				<input type="hidden" name="m" id="m" value="checkplusSerivce">						<!-- �ʼ� ����Ÿ��, �����Ͻø� �ȵ˴ϴ�. -->
				<input type="hidden" name="EncodeData" id="EncodeData" value="<?= $enc_data ?>">		<!-- ������ ��ü������ ��ȣȭ �� ����Ÿ�Դϴ�. -->
			    
			    <!-- ��ü���� ����ޱ� ���ϴ� ����Ÿ�� �����ϱ� ���� ����� �� ������, ������� ����� �ش� ���� �״�� �۽��մϴ�.
			    	 �ش� �Ķ���ʹ� �߰��Ͻ� �� �����ϴ�. -->
				<input type="hidden" name="param_r1" id="param_r1" value="">
				<input type="hidden" name="param_r2" id="param_r2" value="">
				<input type="hidden" name="param_r3" id="param_r3" value="">
			</form>


		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>




