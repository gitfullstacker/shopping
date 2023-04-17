<script language="javascript" src="js/membership.js"></script>
		
		<div class="con_width">
			
			<div class="tit_h2 mt25">
				<em>멤버십 정보</em>
			</div>
			<div class="pt15"><img src="../images/membership_guide_mobile02.gif" alt="" /></div>

			<form id="frm" name="frm" target="_self" method="POST">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="str_repay" value="<?=$str_repay?>">
				<div class="f_size_s mt40"> # 정기권 구독 후 1개월을 이용하실 경우 1개월권 요금이 적용됩니다</div>
				<div class="t_cover03 mt05">
					<table class="t_type02">
						<colgroup>
							<col style="width:70px;" />
							<col />
						</colgroup>
						<tbody>
							<tr>
								<th class="line_r <?if ($int_gubun=="1"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform"  value="1" <?if ($int_gubun=="1"){?> checked<?}?> onclick="Pay_Click('1')" > 정기권</label></th>
								<td>
									<p><?if ($arr_Data['INT_OPRICE1']!="0"){?>￦ <?=number_format($arr_Data['INT_OPRICE1'])?> → <?}?> <span class="f_bd f_bk">￦ <?=number_format($arr_Data['INT_PRICE1'])?></span> / 월 (왕복배송비 2회 무료)</p>
									<?if ($arr_Data['STR_EVENT1']!=""){?> 
									<div class="mt10">
										<span class="icn btn_bk btn_s"><span class="f_ylw">EVENT</span></span>
										<span style = "padding-left: 5px;"><?=$arr_Data['STR_EVENT1']?> </span>
									</div>
									<?}?>
								</td>
							</tr>
							<tr>
								<th class="line_r <?if ($int_gubun=="2"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform"  value="2" <?if ($int_gubun=="2"){?> checked<?}?> onclick="Pay_Click('2')" > 1개월권</label></th>
								<td>
									<p><?if ($arr_Data['INT_OPRICE2']!="0"){?>￦ <?=number_format($arr_Data['INT_OPRICE2'])?> → <?}?><span class="f_bd f_bk">￦ <?=number_format($arr_Data['INT_PRICE2'])?></span>  (왕복배송비 2회 무료)</p>
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
				<div class="tit_h3 mt25">이용요금</div>
				<div class="mt10">
					<table class="t_type03">
						<colgroup>
							<col style="width:50%;" />
							<col style="width:50%;" />
						</colgroup>
						<tbody>
							<tr>
								<th>
									<p class="f_bk f_bd">
										<?if ($int_gubun=="1"){?>
										정기권
										<?}else{?>
										1개월권
										<?}?>
									</p>
								</th>
								<td>
									
										<?if ($int_gubun=="1"){?>
										￦ <?=number_format($arr_Data['INT_PRICE1'])?>
										<?}else{?>
										￦ <?=number_format($arr_Data['INT_PRICE2'])?>
										<?}?>
									
								</td>
							</tr>
							<tr>
								<th>왕복배송비</th>
								<td>
									￦ 20,000
								</td>
							</tr>
							<tr>
								<th>배송비 할인</th>
								<td class="no_r_line">
									- ￦ 20,000
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th><span style="display:none;">총 이용 요금</span></th>
								<td>
									<?if ($int_gubun=="1"){?>
									￦ <?=number_format($arr_Data['INT_PRICE1'])?>
									<?}else{?>
									￦ <?=number_format($arr_Data['INT_PRICE2'])?>
									<?}?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<!--<div class="mt25"><a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?><?if ($int_gubun=="1"){?><?if ($arr_Auth[0]=="joilya7"||$arr_Auth[0]=="ablanc"||$arr_Auth[0]=="yonghun4") {?>Save_Click('<?=$int_gubun?>');<?}else{?>alert('정기권은 PC에서 신청 부탁드립니다.');<?}?><?}else{?>Save_Click();<?}?><?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>//-->
				<div class="mt25"><a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?>Save_Click('<?=$int_gubun?>');<?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>
			</form>

			

		</div>
