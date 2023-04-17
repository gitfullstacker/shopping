<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();

	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");


	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_qna a where a.str_muserid='$arr_Auth[0]' and a.int_number is not null ";
	$SQL_QUERY.=$Str_Query;
	$result = mysql_query($SQL_QUERY);


	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$total_record = mysql_result($result,0,0);

	if(!$total_record){
		$first = 1;
		$last = 0;
	}else{
	  	$first = $displayrow *($page-1) ;
	  	$last = $displayrow *$page;

	  	$IsNext = $total_record - $last ;
	  	if($IsNext > 0){
			$last -= 1;
	  	}else{
	   		$last = $total_record -1 ;
	  	}
	}
	$total_page = ceil($total_record/$displayrow);

	$f_limit=$first;
	$l_limit=$last + 1 ;

	$SQL_QUERY = "select a.* ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_member_qna a where a.str_muserid='$arr_Auth[0]' and a.int_number is not null ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_order desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/my_qna.js"></script>
		
		
		<form id="frm" name="frm" target="_self" method="POST" action="my_qna.php">
		<input type="hidden" name="page" value="<?=$page?>">
		<input type="hidden" name="total_page" value="<?=$total_page?>">
		<input type="hidden" name="str_no">
		
		<div class="con_width">
			
			<!-- <div class="tit_h2 mt25">
				<em>문의하기 (Q&A)</em>
				<span class="tit_h2_desc">궁금하신 내용을 빠르게 답변해 드립니다.</span>
			</div> -->
			<div class="pt15"></div>
			<div class="qna_bx  " id="labData">
				<div class="logWrap logFriend">
					<p class="pfImg"><img src="../images/qna_ablanc.png" alt="" /></p>
					<p class="pDate">&nbsp;</p>
					<div class="msg">
						<div class="msgMain">
							<p class="messageBodyWrap"><span class="txt">1:1 문의하기 게시판입니다.<br />문의사항 혹은 가방연장 등의 요청사항을 남겨주세요. 최대한 빠른게 답변드리겠습니다 ^_^</span></p>
						</div>
					</div>
				</div>
				
				<?$count=0;?>
				<?if($total_record_limit!=0){?>
				<?$article_num = $total_record - $displayrow*($page-1) ;?>
				<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>		
						
				<div class="<?if (mysql_result($result,$i,int_level)=="0") {?>logWrap logMy<?}else{?>logWrap logFriend<?}?>">
					<p class="pfImg"><img src="../images/<?if (mysql_result($result,$i,int_level)=="0") {?>?}else{?>qna_ablanc.png<?}?>" alt="" /></p>
					<p class="pDate"><?=str_replace("-",".",substr(mysql_result($result,$i,dtm_indate),0,10))?></p>
					<div class="msg">
						<div class="msgMain">
							<div class="messageBodyWrap">
								<span class="txt"><?=str_replace(chr(13),"<br>",Fnc_Om_Conv_Default(mysql_result($result,$i,str_cont),""))?></span>
								<?if (mysql_result($result,$i,str_image1)!=""){?>
								<p class="file_txt mt20">
									<span class="f_bk f_bd">첨부파일</span>
									<ul class="list_type01">
										<li><i class="icn icn_file"></i><a href="my_qna_dn.php?str_no=<?=mysql_result($result,$i,int_number)?>"><?=mysql_result($result,$i,str_image1)?></a></li>
									</ul>
								</p>
								<?}?>
							</div>
							<?if (mysql_result($result,$i,str_userid)==$arr_Auth[0]) {?>
							<p class="user_option mt05">
								<a href="javascript:npopupLayer('my_qna_write.php?RetrieveFlag=UPDATE&str_no=<?=mysql_result($result,$i,int_number)?>', 550, 235);" class="btn btn_bk btn_s w40">수정</a>
								<a href="javascript:Click_Delete('<?=mysql_result($result,$i,int_number)?>');" class="btn btn_wt btn_s w40">삭제</a>
							</p>
							<?}?>
						</div>
					</div>
				</div>
				<?$count++;?>
				<?
				$article_num--;
				if($article_num==0){
					break;
				}
				?>
				<?}?>
				<?}?>
				<input type="hidden" name="txtRows" value="<?=$count?>">
				
				
				<!--
				<div class="logWrap logFriend">
					<p class="pfImg"><img src="../images/qna_ablanc.png" alt="" /></p>
					<p class="pDate">2016.09.10</p>
					<div class="msg">
						<div class="msgMain">
							<p class="messageBodyWrap"><span class="txt">답변 합니다.</span></p>
						</div>
					</div>
				</div>
				<div class="logWrap logMy">
					<p class="pfImg"><img src="../images/qna_c.png" alt="" /></p>
					<p class="pDate">2016.09.10</p>
					<div class="msg">
						<div class="msgMain">
							<p class="messageBodyWrap"><span class="txt">네 알겠습니다.</span></p>
						</div>
					</div>
				</div>
				<div class="logWrap logMy">
					<p class="pfImg"><img src="../images/qna_c.png" alt="" /></p>
					<p class="pDate">2016.09.10</p>
					<div class="msg">
						<div class="msgMain">
							<p class="messageBodyWrap"><span class="txt">네 알겠습니다.네 알겠습니다.네 알겠습니다.</span></p>
						</div>
					</div>
				</div>
				//-->
			</div>
			<p class="mt05"><a href="javascript:fnc_more();" class="btn btn_readmore">READ MORE <i class="icn"></i></a></p>
			<p class="mt15" style="margin-bottom: 15px;"><a href="javascript:npopupLayer('my_qna_write.php', 550, 235);" class="btn btn_l btn_bk w100p">문의하기</a></p>
			

		</div>
		
		</form>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>
