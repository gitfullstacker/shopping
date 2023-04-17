<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);

	$Txt_word  = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_gubun = Fnc_Om_Conv_Default($_REQUEST[Txt_gubun],"");

	If ($Txt_word!="") { $Str_Query .= " and (a.str_quest like '%$Txt_word%' or a.str_answer like '%$Txt_word%') ";}
	If ($Txt_gubun!="") { $Str_Query .= " and a.int_gubun = '$Txt_gubun' ";}

	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_faq a where a.int_number is not null and a.str_service='Y' ";
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

	$SQL_QUERY = "select a.*,b.str_code from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_faq a left join ".$Tname."comm_com_code b on a.int_gubun=b.int_number ";
	$SQL_QUERY.="where a.int_number is not null and a.str_service='Y' ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_indate asc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/faq.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   고객센터   >   공지사항</p>
					<div class="lnb_tab lnb_tab6 mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/cscenter/tab.php"; ?>
					</div>
					
					<form id="frm" name="frm" target="_self" method="POST" action="faq.php" onSubmit="return fnc_search();">
					<input type="hidden" name="Txt_gubun" value="<?=$Txt_gubun?>">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					
					<div class="search_bx mt30">
						<span class="tit">자주묻는 질문 검색</span>
						<input type="text" NAME="Txt_word" value="<?=$Txt_word?>" class="inp_faq" />
						<input type="image" src="../images/sub/btn_search_bk.gif" alt="" />
					</div>
					<div class="faq_category mt35">
					
						<?
						$Sql_Query =	" SELECT
										A.*
									FROM `"
										.$Tname."comm_com_code` AS A
									WHERE
										A.INT_GUBUN='3'
										AND
										A.STR_SERVICE='Y'
									ORDER BY
										A.INT_NUMBER ASC ";
					
						$arr_Data=mysql_query($Sql_Query);
						$arr_Data_Cnt=mysql_num_rows($arr_Data);
						?>
						
						<?
							for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
						?>
						<a href="faq.php?Txt_gubun=<?=mysql_result($arr_Data,$int_I,int_number)?>" <?if ($Txt_gubun==mysql_result($arr_Data,$int_I,int_number)) {?> class="on"<?}?>><?=mysql_result($arr_Data,$int_I,str_code)?></a>
						<?If ($int_I != ($arr_Data_Cnt-1)){?>
						<span class="icn icn_bar"></span>
						<?}?>
						<?
							}
						?>						
					</div>
					
				
					<div class="t_cover01 mt25">
						<ul class="faq_list">
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<li class="q"><a href="javascript:menu('<?=mysql_result($result,$i,int_number)?>');"><?=mysql_result($result,$i,str_quest)?></a> </li>
							<li class="a" id="submenu_prodeval<?=mysql_result($result,$i,int_number)?>" style="display: none;"><?=mysql_result($result,$i,str_answer)?></li>
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
						</ul>
					</div>
					
					<div class="paging02 mt30">
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
