<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$Tpage = Fnc_Om_Conv_Default($_REQUEST[Tpage],"");
	$page = Fnc_Om_Conv_Default($_REQUEST[page],"1");

	switch($RetrieveFlag){
     	case "Load" :
     	
			$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],10);
			$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
		
			$SQL_QUERY="select count(a.str_goodcode) from ";
			$SQL_QUERY.=$Tname;
			$SQL_QUERY.="comm_goods_view a inner join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode where a.str_session='".$_COOKIE['str_vsession']."' ";
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
		
			$SQL_QUERY = "select a.*,b.str_goodcode,b.str_egoodname,b.str_image1,b.str_image2,e.str_code,(select ifnull(count(c.str_userid),0) as cnt from ".$Tname."comm_member_like c where c.str_goodcode=a.str_goodcode) as likecnt,(select c.str_bcode from ".$Tname."comm_goods_master_category c where a.str_goodcode=c.str_goodcode limit 1) as str_bcode,(select ifnull(count(d.str_userid),0) as cnt from ".$Tname."comm_goods_cart d where d.str_goodcode=a.str_goodcode and d.str_userid='".$arr_Auth[0]."' and d.int_state in ('4')) as cartcnt from ";
			$SQL_QUERY.=$Tname;
			$SQL_QUERY.="comm_goods_view a inner join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode left join ".$Tname."comm_com_code e on b.int_brand=e.int_number  ";
			$SQL_QUERY.="where a.str_session='".$_COOKIE['str_vsession']."' ";
			$SQL_QUERY.=$Str_Query;
			$SQL_QUERY.="order by a.dtm_indate desc ";
			$SQL_QUERY.="limit $f_limit,$l_limit";
		
			$result = mysql_query($SQL_QUERY);
			if(!$result) {
			 	error("QUERY_ERROR");
			 	exit;
			}
			$total_record_limit=mysql_num_rows($result);
			
			$sBuy = fnc_buy_info();
			?>

			<?$count=0;?>
			<?if($total_record_limit!=0){?>
			<?$article_num = $total_record - $displayrow*($page-1) ;?>
			<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
			<?$sRent=fnc_cart_info(mysql_result($result,$i,str_goodcode));?>
			<li>
				<?if ($sRent==0) {?><span class="rented">RENTED</span><?}?>
				<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?=mysql_result($result,$i,likecnt)?></p>
				<a href="/m/category/detail.php">
					<p><?if (mysql_result($result,$i,str_image1)!="") {?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" border="0"><?}else{?>&nbsp;<?}?></p>
					<dl>
						<dt><?=mysql_result($result,$i,str_code)?></dt>
						<dd><?=mysql_result($result,$i,str_egoodname)?></dd>
					</dl>
					<p class="mt10">
						<?If ($arr_Auth[0]=="") {?>
							<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
						<?}else{?>
							<?if ($sBuy > 0) {//���Ű� ������?>
								<?if ($sRent!=0) {//ǰ���� �ƴҶ�?>
									<?if (mysql_result($result,$i,cartcnt)>0) {//���� ������ǰ�϶�?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
									<?}else{?>
										<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">CHANGE</a>
									<?}?>
								<?}else{?>
										<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
								<?}?>
							<?}else{//���Ű� ������?>
								<?if ($sRent!=0) {//ǰ���� �ƴҶ�?>
									<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_get">GET</a>
								<?}else{?>
									<span class="btn btn_get" style="visibility:hidden;">&nbsp;</span>
								<?}?>
							<?}?>
						<?}?>
					</p>
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
	