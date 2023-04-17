<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
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

	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " and (a.str_goodname like '%$Txt_word%') ";
				break;
			case  "str_goodname" :
				$Str_Query = " and a.str_goodname like '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	//If ($Txt_bcode!="") { $Str_Query .= " and a.str_bcode = '$Txt_bcode' ";}

	if ($Txt_bcode!="") { $Str_Query .= " and a.str_goodcode in (select d.str_goodcode from ".$Tname."comm_goods_master_category d where d.str_bcode in (select concat(c.str_menutype,c.str_chocode,c.str_btmuni) from ".$Tname."comm_menu_btm c where c.str_menutype='".substr($Txt_bcode,0,2)."' and c.str_chocode='".substr($Txt_bcode,2,2)."' and c.str_unicode='".substr($Txt_bcode,4,5)."')) ";}


	$SQL_QUERY="select count(a.str_goodcode) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
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

	$SQL_QUERY = "select a.*,(select b.str_bcode from ".$Tname."comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master a ";
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

	$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >  <?=Fnc_Om_Conv_Default(Fnc_Om_Cate_Name($Txt_bcode),"ALL")?></p>
				</div>
				<div class="sub_visual s_v01 mt20"></div>
				<div class="contents_w">
					<p class="mt30">총 <?=$total_record?> 개의 가방이 있습니다.</p>
					<script type="text/javascript">
						(function( $ ){
							$.fn.hoverGrid = function( options ) {  
							var settings = $.extend( {
									'itemClass' : '.item'
								}, options);
							
								return this.each(function() {       
								var hoverGrid = $(this);
								hoverGrid.addClass('hover-grid');
								hoverGrid.find(settings.itemClass).addClass('hover-grid-item');
								
								$(hoverGrid).find(settings.itemClass).hover(function () {
									$(this).find('div.caption').stop(false, true).fadeIn(200);
								},
										function () {
												$(this).find('div.caption').stop(false, true).fadeOut(200);
										});
								});
							};
						})( jQuery );
					</script>
					<script type="text/javascript">
							$(document).ready(function() {
								$('#layout').hoverGrid();
							});
					</script>
					
					
					<form id="frm" name="frm" target="_self" method="POST" action="list.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					<input type="hidden" name="str_String" value="<?=$str_String?>">
					
					<div class="item_list02">
						<div id="layout">
						
							<?$count=0;?>
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							
							<div class="item">
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><a href="detail.php"><img src="../images/main/icn_zzim_on.png" alt="" /></a> 15</p>
								<p class="item_img"><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" width="120" height="80" border="0"><?}else{?>&nbsp;<?}?></p>
								<dl>
									<dt><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?=mysql_result($result,$i,str_goodname)?></a></dt>
									<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img"><a href="detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?if (mysql_result($result,$i,str_image2)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image2)?>" width="120" height="80" border="0"><?}else{?>&nbsp;<?}?></a></p>
									<p class="on_btn mt20"><a href="#;" class="btn btn_get">GET</a></p>
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
							
							<div class="item">
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><a href="#;"><img src="../images/main/icn_zzim_off.png" alt="" /></a> 15</p>
								<p class="item_img"><img src="../images/main/ex02.jpg" alt="" /></p>
								<dl>
									<dt><a href="#;">MULBERRY (M)</a></dt>
									<dd>Small New Bayswater</dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img"><img src="../images/main/ex01_on.jpg" alt="" /></p>
									<p class="on_btn mt20"><a href="#;" class="btn btn_get">GET</a></p>
								</div>
							</div>
							<div class="item">
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><a href="#;"><img src="../images/main/icn_zzim_off.png" alt="" /></a> 15</p>
								<p class="item_img"><img src="../images/main/ex03.jpg" alt="" /></p>
								<dl>
									<dt><a href="#;">CHANEL (s)</a></dt>
									<dd>핸들 장식의 플랩 백</dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img"><img src="../images/main/ex01_on.jpg" alt="" /></p>
									<p class="on_btn mt20"><a href="#;" class="btn btn_get">GET</a></p>
								</div>
							</div>
							<div class="item">
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><a href="#;"><img src="../images/main/icn_zzim_off.png" alt="" /></a> 15</p>
								<p class="item_img"><img src="../images/main/ex04.jpg" alt="" /></p>
								<dl>
									<dt><a href="#;">BULGARI (s)</a></dt>
									<dd>세르펜티 바이퍼 탑 핸들 백</dd>
								</dl>
								<div class="caption" style="display: none;">
									<p class="item_img"><img src="../images/main/ex01_on.jpg" alt="" /></p>
									<p class="on_btn mt20"><a href="#;" class="btn btn_get">GET</a></p>
								</div>
							</div>
						</div>
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
