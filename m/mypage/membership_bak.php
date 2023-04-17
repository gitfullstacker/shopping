<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
	$str_repay = Fnc_Om_Conv_Default($_REQUEST[str_repay],"");
	
	if ($str_repay!="1") {
		if (fnc_pay_info()) {
			?>
			<script language="javascript">
				window.location.href="membership02_1.php";
			</script>
			<?
			exit;
		}
	}
?>
<?
	$int_gubun = Fnc_Om_Conv_Default($_REQUEST[int_gubun],"1");

	$SQL_QUERY =	" SELECT
					*
				FROM "
					.$Tname."comm_site_info
				WHERE
					INT_NUMBER=1 ";

	$arr_Rlt_Data=mysql_query($SQL_QUERY);
	if (!$arr_Rlt_Data) {
  		echo 'Could not run query: ' . mysql_error();
  		exit;
	}
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
<script language="javascript" src="js/membership.js"></script>
		
		<div class="con_width">
			
			<div class="tit_h2 mt25">
				<em>멤버십 정보</em>
			</div>
			<div><img src="../images/membership_guide_mobile.jpg" alt="" /></div>

			<form id="frm" name="frm" target="_self" method="POST">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="str_repay" value="<?=$str_repay?>">
				<div class="t_cover01 mt15">
					<table class="t_type02">
						<colgroup>
							<col style="width:50%;" />
							<col />
						</colgroup>
						<thead>
							<tr>
								<th<?if ($int_gubun=="1"){?> class="th_em"<?}?>><label><input type="radio" name="int_gubun" class="cform"  value="1" <?if ($int_gubun=="1"){?> checked<?}?> onclick="Pay_Click()" > 정기권</label></th>
								<th<?if ($int_gubun=="2"){?> class="th_em"<?}?>><label><input type="radio" name="int_gubun" class="cform"  value="2" <?if ($int_gubun=="2"){?> checked<?}?> onclick="Pay_Click()" > 1개월권</label></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="center line_r">
									<p><?if ($arr_Data['INT_OPRICE1']!="0"){?><?=number_format($arr_Data['INT_OPRICE1'])?> → <?}?><span class="f_bd f_bk"><?=number_format($arr_Data['INT_PRICE1'])?></span> /<br />월 (왕복배송비 2회 무료 / <br />최소2개월 사용 ~ 무제한)</p>
									<?if ($arr_Data['STR_EVENT1']!=""){?>
									<dl class="mt10">
										<dt class="icn btn_bk btn_s"><span class="f_ylw">EVENT</span></dt>
										<dd class="mt05"><?=$arr_Data['STR_EVENT1']?> </dd>
									</dl>
									<?}?>
								</td>
								<td class="center">
									<p><?if ($arr_Data['INT_OPRICE2']!="0"){?><?=number_format($arr_Data['INT_OPRICE2'])?> → <?}?><span class="f_bd f_bk"><?=number_format($arr_Data['INT_PRICE1'])?></span> / <br />월 (왕복배송비 2회 무료)</p>
									<?if ($arr_Data['STR_EVENT2']!=""){?>
									<dl class="mt10">
										<dt class="icn btn_bk btn_s"><span class="f_ylw">EVENT</span></dt>
										<dd class="mt05"><?=$arr_Data['STR_EVENT2']?> </dd>
									</dl>
									<?}?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="t_cover01 mt15">
					<table class="t_type03">
						<colgroup>
							<col style="width:33%;" />
							<col style="width:33%;" />
							<col />
						</colgroup>
						<thead>
							<tr>
								<th>이용요금</th>
								<th>왕복배송비</th>
								<th class="no_r_line">배송비 할인</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<p class="f_bk">
										<?if ($int_gubun=="1"){?>
										정기구독
										<?}else{?>
										1개월권
										<?}?>
									</p>
									<p class="f_bk f_bd">
										<?if ($int_gubun=="1"){?>
										<?=number_format($arr_Data['INT_PRICE1'])?>
										<?}else{?>
										<?=number_format($arr_Data['INT_PRICE2'])?>
										<?}?>
									</p>
								</td>
								<td>
									20,000원
								</td>
								<td class="no_r_line">
									-20,000원
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th>총 이용 요금 :</th>
								<td colspan="2">
									<?if ($int_gubun=="1"){?>
									<?=number_format($arr_Data['INT_PRICE1'])?>원
									<?}else{?>
									<?=number_format($arr_Data['INT_PRICE2'])?>원
									<?}?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="mt05">* 정기권을 신청하신 회원은 매회 자동결제가 됩니다</div>
				<div class="mt15"><a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?><?if ($int_gubun=="1"){?>alert('정기권 신청은 PC에서 신청바랍니다.');<?}else{?>Save_Click();<?}?><?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>
			</form>

			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/footer.php"; ?>




<link rel="styleSheet" href="/css/sumoselect.css">
<script type="text/javascript" src="/js/custominputfile.min.js"></script>
<script type="text/javascript">
	$('#demo-1').custominputfile({
		theme: 'blue-grey',
		//icon : 'fa fa-upload'
	});
	$('#demo-2').custominputfile({
		theme: 'red',
		icon : 'fa fa-file'
	});
</script>