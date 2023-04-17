<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],32);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],5);

	$Txt_rent = Fnc_Om_Conv_Default($_REQUEST[Txt_rent],"1");
	$Txt_key = Fnc_Om_Conv_Default($_REQUEST[Txt_key],"all");
	$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
	$Txt_service = Fnc_Om_Conv_Default($_REQUEST[Txt_service],"");

	$Txt_bname = Fnc_Om_Conv_Default($_REQUEST[Txt_bname],"");
	$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");

	$Txt_sindate = Fnc_Om_Conv_Default($_REQUEST[Txt_sindate],"");
	$Txt_eindate = Fnc_Om_Conv_Default($_REQUEST[Txt_eindate],"");

	If ($Txt_rent!="0") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT F.STR_GOODCODE FROM ".$Tname."comm_goods_master_sub F WHERE F.STR_GOODCODE=A.STR_GOODCODE AND F.STR_SERVICE='Y' AND F.STR_SGOODCODE NOT IN (SELECT G.STR_SGOODCODE FROM ".$Tname."comm_goods_cart G WHERE G.STR_GOODCODE=A.STR_GOODCODE AND NOT(G.INT_STATE='0' OR G.INT_STATE='10' OR G.INT_STATE='11'))) ";}
	
	If ($Txt_word!="") {
		switch ($Txt_key) {
			case  "all" :
				$Str_Query = " AND (A.STR_GOODNAME LIKE '%$Txt_word%') ";
				break;
			case  "str_goodname" :
				$Str_Query = " AND A.STR_GOODNAME LIKE '%$Txt_word%' ";
				break;
		}
	}

	If ($Txt_service!="") { $Str_Query .= " and a.str_service = '$Txt_service' ";}
	//If ($Txt_bcode!="") { $Str_Query .= " AND A.STR_BCODE = '$Txt_bcode' ";}

	if ($Txt_bcode!="") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT D.STR_GOODCODE FROM ".$Tname."comm_goods_master_category D WHERE D.STR_BCODE IN (SELECT CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) FROM ".$Tname."comm_menu_btm C WHERE C.STR_MENUTYPE='".substr($Txt_bcode,0,2)."' AND C.STR_CHOCODE='".substr($Txt_bcode,2,2)."' AND C.STR_UNICODE='".substr($Txt_bcode,4,5)."')) ";}


	$SQL_QUERY="SELECT COUNT(A.STR_GOODCODE) FROM ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_master A WHERE A.STR_GOODCODE IS NOT NULL AND (A.STR_SERVICE='Y' OR A.STR_SERVICE='R') ";
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

	$SQL_QUERY = "SELECT 
								A.*,
								(SELECT B.STR_BCODE FROM ".$Tname."comm_goods_master_category B WHERE A.STR_GOODCODE=B.STR_GOODCODE LIMIT 1) AS STR_BCODE,
								(SELECT IFNULL(COUNT(C.STR_USERID),0) AS CNT FROM ".$Tname."comm_member_like C WHERE C.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT,
								(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM ".$Tname."comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='".$arr_Auth[0]."' AND D.INT_STATE IN ('4')) AS CARTCNT,
								E.STR_CODE,
								(SELECT IFNULL(COUNT(F.STR_SGOODCODE),0) AS CNT FROM ".$Tname."comm_goods_master_sub F WHERE F.STR_GOODCODE=A.STR_GOODCODE AND F.STR_SERVICE='Y' AND F.STR_SGOODCODE NOT IN (SELECT G.STR_SGOODCODE FROM ".$Tname."comm_goods_cart G WHERE G.STR_GOODCODE=A.STR_GOODCODE AND NOT(G.INT_STATE='0' OR G.INT_STATE='10' OR G.INT_STATE='11'))) AS RENT
							FROM 
								".$Tname."comm_goods_master A
								LEFT JOIN
								".$Tname."comm_com_code E
								ON
								A.INT_BRAND=E.INT_NUMBER
							WHERE 
								A.STR_GOODCODE IS NOT NULL 
								AND 
								(A.STR_SERVICE='Y' OR A.STR_SERVICE='R') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="ORDER BY A.INT_SORT DESC ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);

	$str_String = "?page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode)."&Txt_rent=".urlencode($Txt_rent);
	
	$sBuy = fnc_buy_info();
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/list.js"></script>


		<form id="frm" name="frm" target="_self" method="POST" action="list.php">
		<input type="hidden" name="page" value="<?=$page?>">
		<input type="hidden" name="str_no">
		<input type="hidden" name="Txt_bcode" value="<?=$Txt_bcode?>">
		<input type="hidden" name="Txt_rent" value="<?=$Txt_rent?>">
		<input type="hidden" name="str_String" value="<?=$str_String?>">
		<input type="hidden" name="total_page" value="<?=$total_page?>">
		
		<div class="con_width">
			<p class="list_option" style="
			padding-top: 24px;">
				<a href="javascript:fnc_gbn('0');"<?If ($Txt_rent=="0") {?> class="on"<?}?>><i class="icn icn_all"></i>전체 가방</a> 
	
				<a href="javascript:fnc_gbn('1');"<?If ($Txt_rent=="1") {?> class="on"<?}?>><i class="icn icn_possible"></i>GET 가능한 가방 </a>
				
			</p>
			<ul class="new_list" id="labData">
			
				<?$count=0;?>
				<?if($total_record_limit!=0){?>
				<?$article_num = $total_record - $displayrow*($page-1) ;?>
				<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
				<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
				<li>
					<?if ($sRent==0) {?>
					<span class="rented">RENTED</span>
					<?}?>
					<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($result,$i,likecnt)?></p>
					<a href="/m/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>">
						<p><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>"  border="0"><?}else{?>&nbsp;<?}?></p>
						<dl>
							<dt style="padding-top:10px;"><?=mysql_result($result,$i,str_code)?></dt>
							<dd style="padding-top:2px;"><?=mysql_result($result,$i,str_egoodname)?></dd>
						</dl>
						<!-- <p class="mt10">
							<?If ($arr_Auth[0]=="") {?>
								<a href="/m/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><span class="btn btn_get">GET</span></a>
							<?}else{?>
								<?if ($sBuy > 0) {//구매가 있을때?>
									<?if ($sRent!=0) {//품절이 아닐때?>
										<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
											<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
										<?}else{?>
											<a href="/m/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><span class="btn btn_get">CHANGE</span></a>
										<?}?>
									<?}else{?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}?>
								<?}else{//구매가 없을때?>
									<?if ($sRent!=0) {//품절이 아닐때?>
										<a href="/m/category/detail.php<?=$str_String?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><span class="btn btn_get">GET</span></a>
									<?}else{?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}?>
								<?}?>
							<?}?>
						</p>-->
					</a>
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
			<div class="paging mt15" style="margin-bottom: 20px;">
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
					<a href="Javascript:MovePage('1');" class="pg_nav pg_fir"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_fir"></a>
				<?}

				if($block > 1) {
				   $my_page = $first_page;
				?>
					<a href="Javascript:MovePage('<?=$my_page?>');" class="pg_nav pg_prev"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_prev"></a>
				<?}
				
				?>
				<span class="num">
				<?

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				   if($page == $direct_page) {?>
				      	<a href="#;" class="on"><?=$direct_page?></a>
				   <?} else {?>
				    	<a href="Javascript:MovePage('<?=$direct_page?>');"><?=$direct_page?></a>
				   <?}
				}

				?>
				</span>
				<?

				if($block < $total_block) {
				   	$my_page = $last_page+1;?>
				    <a href="Javascript:MovePage('<?=$my_page?>');" class="pg_nav pg_next"></a>
				<?}else{ ?>
					<a href="#;" class="pg_nav pg_next"></a>
				<?}

				if($page < $total_page) {?>
					<a href="Javascript:MovePage('<?=$total_page?>');" class="pg_nav pg_last"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_last"></a>
				<?}
				?>
			</div>
			
			<!--<p><a href="javascript:fnc_more();" class="btn btn_readmore">MORE BAGS <i class="icn"></i></a></p>//-->
		</div>
		
		</form>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>