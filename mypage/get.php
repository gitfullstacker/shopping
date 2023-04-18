<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
	
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],9);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);


	$SQL_QUERY="select count(a.int_number) from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_cart a where a.str_userid='$arr_Auth[0]' and a.int_state not in ('0') ";
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

	$SQL_QUERY = "select a.*,b.str_goodname ";
	$SQL_QUERY.=" from ";
	$SQL_QUERY.=$Tname;
	$SQL_QUERY.="comm_goods_cart a left join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode ";
	$SQL_QUERY.="where a.str_userid='$arr_Auth[0]' and a.int_state not in ('0') ";
	$SQL_QUERY.=$Str_Query;
	$SQL_QUERY.="order by a.dtm_indate desc ";
	$SQL_QUERY.="limit $f_limit,$l_limit";

	$result = mysql_query($SQL_QUERY);
	if(!$result) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$total_record_limit=mysql_num_rows($result);
	
	$SQL_QUERY =	" SELECT
					A.*,B.*,C.STR_URL1,D.STR_CODE
				FROM "
					.$Tname."comm_goods_cart AS A
					INNER JOIN
					".$Tname."comm_goods_master AS B
					ON
					A.STR_GOODCODE=B.STR_GOODCODE
					LEFT JOIN 
					".$Tname."comm_com_code AS C 
					ON 
					A.INT_DELICODE=C.INT_NUMBER 
					AND 
					C.STR_SERVICE='Y' 
					LEFT JOIN
					".$Tname."comm_com_code D
					ON
					B.INT_BRAND=D.INT_NUMBER
				WHERE
					A.INT_STATE IN ('1','2','3','4') AND STR_USERID='$arr_Auth[0]' ORDER BY A.DTM_INDATE DESC LIMIT 1 ";
	
	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
			echo 'Could not run query: ' . mysql_error();
			exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/get.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   가방 내역</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>
					

					<?if ($arr_Data["INT_NUMBER"]!="") {?>
					<div class="mypage_img_w mt80">
						<script type="text/javascript" src="../js/jquery.bxslider.js"></script>
						<link type="text/css" rel="stylesheet" href="../css/jquery.bxslider.css" />
						<ul class="bxslider">
							<!-- 반납 -->
							<?for ($int_I=3;$int_I<=9;$int_I++){?>
							<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?>
							<li>
								<div class="mypage_txt01">
									<?if (date("Y-m-d") <= $arr_Data["STR_EDATE"]) {?>
									<p class="tit"><?=substr($arr_Data["STR_EDATE"],0,4)?>년 <?=substr($arr_Data["STR_EDATE"],5,2)?>월 <?=substr($arr_Data["STR_EDATE"],8,2)?>일까지 <span class="f_ylw">반납</span> 해 주셔야 합니다.</p>
									<p class="t_desc mt15">(반납 날짜 이전에 반납/교환 모두 가능합니다)</p>
									<?}else{?>
									<p class="tit">가방이 연체중입니다. 빠른 시일 내에 반납 부탁드립니다. </p>
									<p class="t_desc mt15"><span class="f_org f_bd">연체일 수 : <?=dateDiff(date("Y-m-d"), $arr_Data["STR_EDATE"])?>일</span></p>									
									<?}?>
								</div>
								<p class="bx_img mt45"><a href="#;"><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>" style="width:698px;height:698px;" border="0"></a></p>
								<p class="bx_tit"><a href="#;"><span class="tit_brand"><?=$arr_Data['STR_CODE']?></span><?=$arr_Data['STR_EGOODNAME']?></a></p>
								<div class="bx_btn">
									<?if ($arr_Data["INT_STATE"]=="1") {?>
									<a href="javascript:Click_Cancel('<?=$arr_Data["INT_NUMBER"]?>');" class="btn btn_l btn_ylw w w270 f_bd">GET 취소</a>
									<?}?>
									<?if ($arr_Data["INT_STATE"]=="3") {?>
									<a href="<?if ($arr_Data["STR_DELICODE"]!="") {?><?=str_replace("__INVOICENO__",$arr_Data["STR_DELICODE"],$arr_Data["STR_URL1"])?><?}else{?>#<?}?>" <?if ($arr_Data["STR_DELICODE"]!="") {?> target="_blank"<?}?> class="btn btn_l btn_bk w w270 f_bd">배송조회</a>
									<?}?>
									<?if ($arr_Data["INT_STATE"]=="4") {?>
									<a href="/mypage/return.php" class="btn btn_l btn_bk w w270 f_bd">반납하기</a> 
									<?}?>
								</div>
							</li>
							<?}?>
							<?}?>
						</ul>

						<script type="text/javascript">
							$(document).ready(function(){
								$('.bxslider').bxSlider({
									mode: 'fade',
									captions: true
								});
							});
						</script>


					</div>
					<?}?>
					
					<form id="frm" name="frm" target="_self" method="POST" action="get.php">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="str_no">
					
					<div class="tit_h3 mt60">가방 내역</div>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:100px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:220px;" />
								<col style="width:180px;" />
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>회차</th>
									<th>상품</th>
									<th>신청일자</th>
									<th>유효기간</th>
									<th>상태</th>
									<th>반납일자</th>
								</tr>
							</thead>
							<tbody>
								<?$count=0;?>
								<?if($total_record_limit!=0){?>
								<?$article_num = $total_record - $displayrow*($page-1) ;?>
								<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
								<tr>
									<td><?=$article_num?></td>
									<td><?=mysql_result($result,$i,str_goodname)?></td>
									<td><?=mysql_result($result,$i,dtm_indate)?></td>
									<td><?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?></td>
									<td>
										<?switch (mysql_result($result,$i,int_state)) {
											case  "1" : echo "접수"; break;
											case  "2" : echo "관리자확인"; break;
											case  "3" : echo "발송"; break;
											case  "4" : echo "배송완료"; break;
											case  "5" : echo "반납접수"; break;
											case  "10" : echo "반납완료"; break;
											case  "11" : echo "취소"; break;
										}
										?>
										<?if (mysql_result($result,$i,int_state)=="5") {?>(<?=mysql_result($result,$i,str_rdate)?>)<?}?>
									</td>
									<td><?=Fnc_Om_Conv_Default(mysql_result($result,$i,str_redate),"-")?></td>
								</tr>
								<?$count++;?>
								<?
								$article_num--;
								if($article_num==0){
									break;
								}
								?>
								<?}?>
								<?}else{?>
								<tr>
									<td colspan="6">내역이 없습니다.</td>
								</tr>
								<?}?>
								<input type="hidden" name="txtRows" value="<?=$count?>">

							</tbody>
						</table>
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

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
