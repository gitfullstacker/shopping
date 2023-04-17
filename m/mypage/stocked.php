<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();

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


	$SQL_QUERY="select count(a.str_goodcode) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_alarm b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
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

	$SQL_QUERY = "select a.*,e.str_code,(select b.str_bcode from ".$Tname."comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode,(select ifnull(count(b.int_number),0) as cnt from ".$Tname."comm_member_alarm b where b.str_goodcode=a.str_goodcode) as alarmcnt ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_alarm b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
	$SQL_QUERY.="where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.int_sort desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);

	$str_String = "?page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/stocked.js"></script>
		
		<div class="con_width">
			
			<div class="tit_h2 pt15">
				<em>입고 알림 가방</em>
				<span class="tit_h2_desc">고객님께서 입고 알림 신청을 한 가방들입니다.<br />최대 3개 가방까지 선택하실 수 있습니다.<br/>알림은 메신저를 통해 매일 동시 발송됩니다.</span>
			</div>

			<form id="frm" name="frm" target="_self" method="POST" action="stocked.php">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="str_no">
			<input type="hidden" name="str_String" value="<?=$str_String?>">

			<div class="stocked_w">
				<ul class="new_list mt25">
					<?$count=0;?>
					<?if($total_record_limit!=0){?>
					<?$article_num = $total_record - $displayrow*($page-1) ;?>
					<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
					<li>
						<p class="f_size_s">본 가방에 대해 <span class="f_ylw"><?=mysql_result($result,$i,alarmcnt)?></span>명이 <br />입고 알림을 기다리고 있습니다.</p>
						<a href="/m/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>">
							<p class="i_img"><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" border="0"><?}else{?>&nbsp;<?}?></p>
							<dl>
								<dt><?=mysql_result($result,$i,str_code)?></dt>
								<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
							</dl>
						</a>
						<div class="btn_w mt10">
							<a href="javascript:Click_Del('<?=mysql_result($result,$i,str_goodcode)?>');" class="btn btn_s btn_bk">알림 취소</a>
						</div>
					</li>
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
			
			</form>
			
			<!--<p><a href="#;" class="btn btn_readmore">READ MORE <i class="icn"></i></a></p>//-->
		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>