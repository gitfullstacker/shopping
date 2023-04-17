<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();

	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],9);
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
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/my_qna.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   고객센터   >   문의하기(Q&amp;A)</p>
					<div class="lnb_tab lnb_tab6 mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/cscenter/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">문의하기(Q&amp;A)</div>
					<p class="tit_desc mt45">궁금하신 내용을 빠르게 답변해 드립니다.</p> -->
					
					<form id="frm" name="frm" target="_self" method="POST" action="my_qna.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					
					<div class="qna_bx mt50">
						<div class="logWrap logFriend">
							<p class="pfImg"><img src="../images/sub/qna_ablanc.png" alt="" /></p>
							<p class="pDate">&nbsp;</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">1:1 문의하기 입니다.<br />궁금하신 점이나 에이블랑에 요청하고 싶은 점을 자유롭게 남겨주세요^^</span></p>
								</div>
							</div>
						</div>

						
						<?$count=0;?>
						<?if($total_record_limit!=0){?>
						<?$article_num = $total_record - $displayrow*($page-1) ;?>
						<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>						
						
						<div class="<?if (mysql_result($result,$i,int_level)=="0") {?>logWrap logMy<?}else{?>logWrap logFriend<?}?>">
							<p class="pfImg"><img src="../images/sub/<?if (mysql_result($result,$i,int_level)=="0") {?>qna_c.png<?}else{?>qna_ablanc.png<?}?>" alt="" /></p>
							<p class="pDate"><?=str_replace("-",".",substr(mysql_result($result,$i,dtm_indate),0,10))?></p>
							<div class="msg">
								<div class="msgMain">
									
									<div class="messageBodyWrap">
										<span class="txt"><?=str_replace(chr(13),"<br>",Fnc_Om_Conv_Default(mysql_result($result,$i,str_cont),""))?></span>
										<?if (mysql_result($result,$i,str_image1)!=""){?>
										<div class="file_txt mt20">
											<span class="f_bk f_bd">첨부파일</span> 
											<ul class="list_type01">
												<li><i class="icn icn_file"></i> <a href="my_qna_dn.php?str_no=<?=mysql_result($result,$i,int_number)?>"><?=mysql_result($result,$i,str_image1)?></a></li>
											</ul>
										</div>
										<?}?>
									</div>
									
									<?if (mysql_result($result,$i,str_userid)==$arr_Auth[0]) {?>
									<p class="user_option mt05"><a href="javascript:npopupLayer('my_qna_pop.php?RetrieveFlag=UPDATE&str_no=<?=mysql_result($result,$i,int_number)?>', 550, 390);" class="btn btn_bk btn_s w40">수정</a> <a href="javascript:Click_Delete('<?=mysql_result($result,$i,int_number)?>');" class="btn btn_wt btn_s w40">삭제</a></p>
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
							<p class="pfImg"><img src="../images/sub/qna_ablanc.png" alt="" /></p>
							<p class="pDate">2016.09.10</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">답변 합니다.</span></p>
								</div>
							</div>
						</div>
						<div class="logWrap logMy">
							<p class="pfImg"><img src="../images/sub/qna_c.png" alt="" /></p>
							<p class="pDate">2016.09.10</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">네 알겠습니다.</span></p>
								</div>
							</div>
						</div>
						<div class="logWrap logFriend">
							<p class="pfImg"><img src="../images/sub/qna_ablanc.png" alt="" /></p>
							<p class="pDate">2016.09.10</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.답변 합니다.</span></p>
								</div>
							</div>
						</div>
						<div class="logWrap logMy">
							<p class="pfImg"><img src="../images/sub/qna_c.png" alt="" /></p>
							<p class="pDate">2016.09.10</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.네 알겠습니다.</span></p>
								</div>
							</div>
						</div>
						<div class="logWrap logMy">
							<p class="pfImg"><img src="../images/sub/qna_c.png" alt="" /></p>
							<p class="pDate">2016.09.10</p>
							<div class="msg">
								<div class="msgMain">
									<p class="messageBodyWrap"><span class="txt">네 알겠습니다.네 알겠습니다.네 알겠습니다.</span></p>
								</div>
							</div>
						</div>
						//-->
					</div>

					<div class="center mt30">
						<a href="javascript:npopupLayer('my_qna_pop.php', 550, 390);" class="btn btn_l btn_bk w w270 f_bd">문의하기</a>
					</div>

					<div class="paging02 mt50">
						<?
						$total_block = ceil($total_page/$displaypage);
						$block = ceil($page/$displaypage);

						$first_page = ($block-1)*$displaypage;
						$last_page = $block*$displaypage;

						if($total_block <= $block) {
   							$last_page = $total_page;
						}

						$file_link= basename($PHP_SELF);
						$link="$file_link?$param";

						if($page > 1) {?>
							<a href="Javascript:MovePage('1');" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_first.gif" alt="" /></a>
						<?}

						if($block > 1) {
						   $my_page = $first_page;
						?>
							<a href="Javascript:MovePage('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_prev.gif" alt="" /></a>
						<?}

						for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
						   if($page == $direct_page) {?>
						      	<a href="#;" class="on"><?=$direct_page?></a>
						   <?} else {?>
						    	<a href="Javascript:MovePage('<?=$direct_page?>');"><?=$direct_page?></a>
						   <?}
						}

						if($block < $total_block) {
						   	$my_page = $last_page+1;?>
						    <a href="Javascript:MovePage('<?=$my_page?>');" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}else{ ?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_next.gif" alt="" /></a>
						<?}

						if($page < $total_page) {?>
							<a href="Javascript:MovePage('<?=$total_page?>');" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}else{?>
							<a href="#;" class="img_b"><img src="../images/board/btn_page_last.gif" alt="" /></a>
						<?}
						?>
					</div>
					
					</form>

				
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
