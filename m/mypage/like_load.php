<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
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
		
		
			$SQL_QUERY="select count(a.str_goodcode) from ";
			$SQL_QUERY.=$Tname;
			$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_like b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' where a.str_goodcode is not null and (a.str_service='Y' or a.str_service='R') ";
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
		
			$SQL_QUERY = "select a.*,e.str_code,(select b.str_bcode from ".$Tname."comm_goods_master_category b where a.str_goodcode=b.str_goodcode limit 1) as str_bcode,(select ifnull(count(b.str_userid),0) as cnt from ".$Tname."comm_member_like b where b.str_goodcode=a.str_goodcode) as likecnt,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt ";
			$SQL_QUERY.=" from ";
			$SQL_QUERY.=$Tname;
			$SQL_QUERY.="comm_goods_master a inner join ".$Tname."comm_member_like b on a.str_goodcode=b.str_goodcode and b.str_userid='$arr_Auth[0]' left join ".$Tname."comm_com_code e on a.int_brand=e.int_number ";
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
			
			$sBuy = fnc_buy_info();
		
			$str_String = "?Page=".$page."&displayrow=".urlencode($displayrow)."&Txt_bcode=".urlencode($Txt_bcode);
			?>

			<?$count=0;?>
			<?if($total_record_limit!=0){?>
			<?$article_num = $total_record - $displayrow*($page-1) ;?>
			<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
			<li>
				<?if (fnc_cart_info(mysql_result($result,$i,str_goodcode))==0) {?><span class="rented">RENTED</span><?}?>
				<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($result,$i,likecnt)?></p>
				<a href="/m/category/detail.php">
					<p><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" border="0"><?}else{?>&nbsp;<?}?></p>
					<dl>
						<dt><?=mysql_result($result,$i,str_code)?></dt>
						<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
					</dl>
				</a>
				<div class="center">
						<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
						<?If ($arr_Auth[0]=="") {?>
							<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
						<?}else{?>
							<?if ($sBuy > 0) {//구매가 있을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<?if (mysql_result($result,$i,cartcnt)>0) {//내가 빌링상품일때?>
										
									<?}else{?>
										<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a>
									<?}?>
								<?}else{?>

								<?}?>
							<?}else{//구매가 없을때?>
								<?if ($sRent!=0) {//품절이 아닐때?>
									<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
								<?}?>
							<?}?>
						<?}?>
					<a href="javascript:Click_Del('<?=mysql_result($result,$i,str_goodcode)?>');" class="btn btn_get">DELETE</a>
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

			<?
			exit;
			break;
	}
?>
	