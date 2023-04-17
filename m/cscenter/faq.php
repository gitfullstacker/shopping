<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],7);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],7);

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
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/faq.js"></script>
		
		<div class="con_width">
		
			<form id="frm" name="frm" target="_self" method="POST" action="faq.php" onSubmit="return fnc_search();">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="total_page" value="<?=$total_page?>">
			<input type="hidden" name="str_no">
			
			<p class="pt15">
				<select name="Txt_gubun" id="Txt_gubun" class="selc w100p" onchange="fnc_search()">
					<option value="">분류 선택하기</option>
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
					<option value="<?=mysql_result($arr_Data,$int_I,int_number)?>" <?if ($Txt_gubun==mysql_result($arr_Data,$int_I,int_number)) {?> selected<?}?>><?=mysql_result($arr_Data,$int_I,str_code)?>
					<?
						}
					?>						
				</select>
			</p>
			<div class="t_cover01 mt15">
				<ul class="faq_list" id="labData">
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
			<p class="mt15" style="margin-bottom: 15px;"><a href="javascript:fnc_more();" class="btn btn_readmore">READ MORE <i class="icn"></i></a></p>
			
		</div>
		
		
		</form>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>