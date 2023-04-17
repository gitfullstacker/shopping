<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<? require_once $_SERVER[DOCUMENT_ROOT]."/m/inc/header.php"; ?>
		
		
		<div class="con_widthyong">
			
		
			<div class="guide_w mt90">
				<div class="guide_bx" id="guide01">
					<p class="g_img"><img src="../images/yongnewpage.jpeg" alt="" /></p>
						<div class="tit_h2 mt25">
				<em>멤버십 정보</em>
				
			<div style="background-color:#DCDCDC; width:100%; height:30px; padding:20px"></div>
			
			<form id="frm" name="frm" target="_self" method="POST">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="str_repay" value="<?=$str_repay?>">
			
				<div class="t_cover04" >
					<table class="t_type04"  >
						<colgroup>
							<col style="width:30px;" />
							<col />
						</colgroup>
						<tbody>
							<tr style="background-color:white">
							 	
								<th style="background-color:white" class="line_r <?if ($int_gubun=="1"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform" font="9px" value="1" <?if ($int_gubun=="1"){?> checked<?}?> onclick="Pay_Click('1')" > </label></th>
								<td>
									<div>정기권</div>
									<br/>
									<p><?if ($arr_Data['INT_OPRICE1']!="0"){?><?}?> <span class="f_bd f_bk"  > ￦ <?=number_format($arr_Data['INT_PRICE1'])?></span> / 월 </p>
									<?if ($arr_Data['STR_EVENT1']!=""){?> 
									<div class="mt10" style="display:none;"font-size="15px" >
										<span class="icn btn_bk btn_s" style="display:none;" ><span class="f_ylw" style="display:none;" >EVENT</span></span>
										<span style = "padding-left: 5px;" style="display:none;" ><?=$arr_Data['STR_EVENT1']?> </span>
									</div>
									<?}?>
								</td>
								<td style = "padding-left: 5px;">
									<div> - 왕복배송비 2회 포함 </div>
									<div> - 가방 이용횟수 제한 없음 </div>
									<div> - 신규 회원 스타벅스 이용권 증정 </div>
							
									</td>
							</tr>
							<tr>
							<th style="background-color:#DCDCDC; width:30px; padding:10px">
								</th>
								<td style ="background-color:#DCDCDC; width:50px; height:10px">
									</td>
										<td style ="background-color:#DCDCDC; width:70px; height:10px">
									</td>
									</tr>
						
							<tr style="background-color:white">
								<th style="background-color:white" class="line_r <?if ($int_gubun=="2"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform"  value="2" <?if ($int_gubun=="2"){?> checked<?}?> onclick="Pay_Click('2')" > </label></th>
								<td>
									<div>1개월권</div><p>
									<br/><span class="f_bd f_bk">￦ </span><span style="15px bold"<?=number_format($arr_Data['INT_PRICE2'])?></span> </p>
									<?if ($arr_Data['STR_EVENT2']!=""){?>
									<dl class="mt10">
										<dt class="icn btn_bk btn_s"><span class="f_ylw">EVENT</span></dt>
										<dd class="mt05"><?=$arr_Data['STR_EVENT2']?> </dd>
									</dl>
									<?}?>
								</td>
								<td style = "padding-left: 5px;">
									<div> - 왕복배송비 1회 포함 </div>
									<div> - 가방 교환 1회 가능  </div>
								
									</td>
							
							</tr>
						</tbody>
					</table>
				</div>
				<div style="background-color:#DCDCDC; width:100%; height:30px; padding:20px"></div>
					<div class="f_size_s" text align="center" style="background-color:#DCDCDC; width:100%; height:30px;"> # 정기권 구독 후 1개월을 이용하실 경우 1개월권 요금이 적용됩니다</div>
				<div class="mt10">
					<table class="t_type03" style="display:none;" >
						<colgroup>
							<col style="width:50%;" />
							<col style="width:50%;" />
						</colgroup>
						<tbody >
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
		<div class="con_width">
				
				<!--<div class="mt25"><a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?><?if ($int_gubun=="1"){?><?if ($arr_Auth[0]=="joilya7"||$arr_Auth[0]=="ablanc"||$arr_Auth[0]=="yonghun4") {?>Save_Click('<?=$int_gubun?>');<?}else{?>alert('정기권은 PC에서 신청 부탁드립니다.');<?}?><?}else{?>Save_Click();<?}?><?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>//-->
				<div class="mt25"><a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?>Save_Click('<?=$int_gubun?>');<?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>
					
				</div>
			</div>
			
		</div>