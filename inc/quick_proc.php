<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"QUICK");

	switch($RetrieveFlag){
     	case "QUICK" :

			$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
			$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],2);
			$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],1);
				
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
		
			$SQL_QUERY = "select a.*,b.str_goodcode,b.str_goodname,b.str_image1,(select c.str_bcode from ".$Tname."comm_goods_master_category c where a.str_goodcode=c.str_goodcode limit 1) as str_bcode from ";
			$SQL_QUERY.=$Tname;
			$SQL_QUERY.="comm_goods_view a inner join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode ";
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
			
			?>
			
			
				<dl>
					<dt><a href="/cscenter/today.php">최근본상품</a><span><?=$total_record?></span></dt>
					<dd>
						<p class="list_bx" style="height:190px;">
							<?if($total_record_limit!=0){?>
							<?$article_num = $total_record - $displayrow*($page-1) ;?>
							<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
							<a href="/category/detail.php?Txt_bcode=<?=mysql_result($result,$i,str_bcode)?>&str_no=<?=mysql_result($result,$i,str_goodcode)?>"><?If (mysql_result($result,$i,str_image1)!=""){?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" alt="" style="width:85px;height:85px;"/><?}else{?><div style="width:85px;height:85px;">&nbsp;</div><?}?></a>
							<?
							$article_num--;
							if($article_num==0){
								break;
							}
							?>
							<?}?>
							<?}?>
						</p>
						<p class="btn_bx">
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
	
							if($block > 1) {
							   $my_page = $first_page;
							?>
								<a href="Javascript:fuc_set('/inc/quick_proc.php?RetrieveFlag=QUICK&page=<?=$my_page?>', '_Prod');"><img src="/images/common/w_btn_p.gif" alt="" /></a>
							<?}else{?>
								<img src="/images/common/w_btn_p.gif" alt="" />
							<?}
	
							for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
							   if($page == $direct_page) {?>
							   <?} else {?>
							   <?}
							}
							?>
							<?
							if($block < $total_block) {
							   	$my_page = $last_page+1;?>
							    <a href="Javascript:fuc_set('/inc/quick_proc.php?RetrieveFlag=QUICK&page=<?=$my_page?>', '_Prod');"><img src="/images/common/w_btn_n.gif" alt="" /></a>
							<?}else{ ?>
								<img src="/images/common/w_btn_n.gif" alt="" />
							<?}?>
						</p>
					</dd>
				</dl>
		
			
			<?

			exit;
			break;
	}
?>