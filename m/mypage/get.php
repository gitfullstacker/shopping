<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
	$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
	$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],5);
	$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],5);


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
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/get.js"></script>


		<div class="con_width">


			<?
			$Sql_Query2 =	" SELECT 
							B.*,A.STR_PTYPE,A.STR_CANCEL,A.STR_CARDCODE,A.STR_PASS
						FROM `"
							.$Tname."comm_member_pay` AS A
							INNER JOIN
							`".$Tname."comm_member_pay_info` AS B
							ON
							A.INT_NUMBER=B.INT_NUMBER
							AND 
							A.STR_PASS='0' 
							AND
							date_format(B.STR_SDATE, '%Y-%m-%d') <= '".date("Y-m-d")."'
							AND
							date_format(B.STR_EDATE, '%Y-%m-%d') >= '".date("Y-m-d")."' 
							AND
							A.STR_USERID='$arr_Auth[0]' ";
	
			$arr_Data2=mysql_query($Sql_Query2);
			$arr_Data_Cnt=mysql_num_rows($arr_Data2);
			?>	
			<div class="tit_h3 pt30">구독권 기간</div>				
				<?if ($arr_Data_Cnt != 0) {?>
			<div class="membership_bx01 mt07">구독권 기간은 <?=substr(mysql_result($arr_Data2,0,str_edate),0,4)?>년 <?=substr(mysql_result($arr_Data2,0,str_edate),5,2)?>월 <?=substr(mysql_result($arr_Data2,0,str_edate),8,2)?>일까지 입니다.</div>
		
			<?}else{?>
			<div class="membership_bx01 mt07">현재 서비스 구독 중이 아닙니다.</div>
			<?}?>
			<div class="center mt07"> 정기권 이용 시, 한 가방은 최대 3개월까지 이용가능합니다.  </div>
			<div class="center mt01"> 구독권 종료예정인 경우 종료일 전 반납부탁드립니다.  </div>

			<?if ($arr_Data["INT_NUMBER"]!="") {?>
			<!-- 수정 부분 -->
			<?if (date("Y-m-d") <= $arr_Data["STR_EDATE"]) {?>
			<?}?>
			<br>
			
			
			<div class="get_img mt15">
				<ul class="bxslider">
					<?for ($int_I=3;$int_I<=9;$int_I++){?>
					<?if (!($arr_Data["STR_IMAGE".$int_I]=="")) {?>
					<li><img src="/admincenter/files/good/<?=$arr_Data["STR_IMAGE".$int_I]?>" border="0"></li>
					<?}?>
					<?}?>
				</ul>
				<script type="text/javascript">
					$(document).ready(function(){
						$('.bxslider').bxSlider({
							auto: true,
							controls:false
						});
					});
				</script>
			</div>


			
			<script type="text/javascript" src="../../js/jquery.bxslider.js"></script>
			<link type="text/css" rel="stylesheet" href="../../css/jquery.bxslider.css" />
			<dl class="detail_name mt20">
				<dt><?=$arr_Data['STR_EGOODNAME']?></dt>
				<dd>RETAIL <?=number_format($arr_Data['INT_PRICE'])?>원</dd>
			</dl>


			
			<div class="center btn_w">
				<?if ($arr_Data["INT_STATE"]=="1") {?>
				<a href="javascript:Click_Cancel('<?=$arr_Data["INT_NUMBER"]?>');" class="btn btn_l btn_bk w30p f_bd">GET 취소</a> 
				<?}?>
				<?if ($arr_Data["INT_STATE"]=="3") {?>
				<a href="<?if ($arr_Data["STR_DELICODE"]!="") {?><?=str_replace("__INVOICENO__",$arr_Data["STR_DELICODE"],$arr_Data["STR_URL1"])?><?}else{?>#<?}?>" <?if ($arr_Data["STR_DELICODE"]!="") {?> target="_blank"<?}?> class="btn btn_l btn_bk w30p f_bd">배송조회</a> 
				<?}?>
				<?if ($arr_Data["INT_STATE"]=="4") {?>
				<a href="/m/mypage/return.php" class="btn btn_l btn_bk w30p f_bd">반납하기</a> 
				<?}?>
			</div>

			<!-- //수정 부분 -->
			<?}?>
			

			
			<form id="frm" name="frm" target="_self" method="POST" action="get.php">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="str_no">
			
			<div class="tit_h3 pt30">대여 내역</div>
			<div class="t_cover01 mt10">
				<table class="t_type">
					<colgroup>
						<col style="width:15%;" />
						<col style="width:85%;" />
					</colgroup>
					<tbody>
						<?$count=0;?>
						<?if($total_record_limit!=0){?>
						<?$article_num = $total_record - $displayrow*($page-1) ;?>
						<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
						<tr>
							<td class="r_line"><?=$article_num?></td>
							<td>
								<ul class="list_type01">
									<li>상품  : <?=mysql_result($result,$i,str_goodname)?></li>
									<li>신청일자 : <?=mysql_result($result,$i,dtm_indate)?></li>
									<li>유효기간 : <?=mysql_result($result,$i,str_sdate)?>~<?=mysql_result($result,$i,str_edate)?></li>
									<li>상태 :
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
									</li>
									<li>반납일자 : <?=Fnc_Om_Conv_Default(mysql_result($result,$i,str_redate),"-")?></li>
								</ul>
							</td>
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
							<td colspan="2" align="center">내역이 없습니다.</td>
						</tr>
						<?}?>
						<input type="hidden" name="txtRows" value="<?=$count?>">
					</tbody>
				</table>
			</div>
			<div class="paging mt15" style="margin-bottom: 15px;">
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
			
			
			</form>

			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>
