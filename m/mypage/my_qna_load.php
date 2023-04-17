<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();

	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$Tpage = Fnc_Om_Conv_Default($_REQUEST[Tpage],"");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],"1");

	switch($RetrieveFlag){
     	case "Load" :

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

			<?$count=0;?>
			<?if($total_record_limit!=0){?>
			<?$article_num = $total_record - $displayrow*($page-1) ;?>
			<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>		
					
			<div class="<?if (mysql_result($result,$i,int_level)=="0") {?>logWrap logMy<?}else{?>logWrap logFriend<?}?>">
				<p class="pfImg"><img src="../images/<?if (mysql_result($result,$i,int_level)=="0") {?>qna_c.png<?}else{?>qna_ablanc.png<?}?>" alt="" /></p>
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
							<a href="javascript:npopupLayer('my_qna_write.php?RetrieveFlag=UPDATE&str_no=<?=mysql_result($result,$i,int_number)?>', 550, 390);" class="btn btn_bk btn_s w40">수정</a>
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

			<?
			exit;
			break;
	}
?>
	