<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$Tpage = Fnc_Om_Conv_Default($_REQUEST[Tpage],"");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],"1");

	switch($RetrieveFlag){
     	case "Load" :
     	
			$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],16);
			$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],1);
		
			$Txt_rent = Fnc_Om_Conv_Default($_REQUEST[Txt_rent],"0");
			$Txt_word = Fnc_Om_Conv_Default($_REQUEST[Txt_word],"");
		
			$Txt_bcode = Fnc_Om_Conv_Default($_REQUEST[Txt_bcode],"");
			$Txt_brand = Fnc_Om_Conv_Default($_REQUEST[Txt_brand],"");
			
			$sTemp1 = "";
			if (is_array($Txt_bcode)) {
			
				for ($int_A = 0; $int_A < count($Txt_bcode); $int_A++) {
					$sTemp1.= "'".$Txt_bcode[$int_A]."'";
					if ($int_A != (count($Txt_bcode)-1)) {
						$sTemp1.= ",";
					}
				}
			
			}
			
			$sTemp2 = "";
			if (is_array($Txt_brand)) {
			
				for ($int_A = 0; $int_A < count($Txt_brand); $int_A++) {
					$sTemp2.= "'".$Txt_brand[$int_A]."'";
					if ($int_A != (count($Txt_brand)-1)) {
						$sTemp2.= ",";
					}
				}
			
			}
		
			//If ($Txt_rent!="0") { $Str_Query .= " AND A.RENT != '0' ";}
			
			If ($Txt_word!="") {$Str_Query = " AND (A.STR_GOODNAME LIKE '%$Txt_word%' OR A.STR_EGOODNAME LIKE '%$Txt_word%' OR A.INT_BRAND IN (select E.INT_NUMBER FROM ".$Tname."comm_com_code E WHERE (E.STR_KCODE LIKE '%$Txt_word%' OR E.STR_CODE LIKE '%$Txt_word%') AND E.INT_GUBUN='2' AND E.STR_SERVICE='Y')) ";}
		
		
			if ($sTemp1!="") { $Str_Query .= " AND A.STR_GOODCODE IN (SELECT D.STR_GOODCODE FROM ".$Tname."comm_goods_master_category D WHERE D.STR_BCODE IN (SELECT CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) FROM ".$Tname."comm_menu_btm C WHERE CONCAT(C.STR_MENUTYPE,C.STR_CHOCODE,C.STR_BTMUNI) IN (".$sTemp1."))) ";}
			if ($sTemp2!="") { $Str_Query .= " AND A.INT_BRAND IN (".$sTemp2.") ";}
		
		
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
			
			$sBuy = fnc_buy_info();
			 
			
			function fnc_chkbox($Txt_bcode,$str_bcode) {
			
				if (is_array($Txt_bcode)) {
				
					for ($int_A = 0; $int_A < count($Txt_bcode); $int_A++) {
						If ($Txt_bcode[$int_A]==$str_bcode) {
							echo " checked";
						}
					}
				
				}
			
			}
			?>

			<?$count=0;?>
			<?if($total_record_limit!=0){?>
			<?$article_num = $total_record - $displayrow*($page-1) ;?>
			<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
			<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
			<li>
				<?if ($sRent==0) {?><span class="rented">RENTED</span><?}?>
				<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($result,$i,likecnt)?></p>
				<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>">
					<p><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" border="0"><?}else{?>&nbsp;<?}?></p>
					<dl>
						<dt><?=mysql_result($result,$i,str_code)?></dt>
						<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
					</dl>
					<!--<p class="mt10">
						<?If ($arr_Auth[0]=="") {?>
							<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
						<?}else{?>
							<?if ($sBuy > 0) {//구매가 있을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}else{?>
										<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a>
									<?}?>
								<?}else{?>
									<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
								<?}?>
							<?}else{//구매가 없을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<a href="/m/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
								<?}else{?>
									<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
								<?}?>
							<?}?>
						<?}?>
					</p>//-->
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

			<?
			exit;
			break;
	}
?>
	