<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
	
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
<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/header.php"; ?>
<script language="javascript" src="js/membership.js"></script>

		<div id="container">
			
			<div class="sub_container" style="padding-bottom:0px;">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   멤버십 정보</p>
					<div class="lnb_tab mt10">
						<? require_once $_SERVER[DOCUMENT_ROOT]."/mypage/tab.php"; ?>
					</div>
					<!-- <div class="tit_h2_2 mt45">멤버십 정보</div> -->

				
					<div class="mt50"><img src="/images/sub/membership_guide.gif" alt="" /></div>

						<div style="background-color:#EAEBEE; width:1100px; height:100px;"></div>

			<form id="frm" name="frm"  style="background-colr:#EAEBEE;">
			<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
			<input type="hidden" name="str_repay" value="<?=$str_repay?>">
		
		
					<table  style="position:center;"  >
						<colgroup>
							<col style="width:30px; height: 100px background-color:#EAEBEE;" />
							<col />
						</colgroup>

						<tbody>
							<tr style="background-color:#EAEBEE; "></tr>
								<td style = "width:150px; height:100px; background-color:#EAEBEE;">
									<div> </div>
									<div> </div>
									<div> </div>
									</td>
							
								<th style="padding-left: 50px; background-color:white; width:100px;" class="line_r  <?if ($int_gubun=="1"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform"  value="1" <?if ($int_gubun=="1"){?> checked<?}?> onclick=<?$int_gubun=“1”?> ></label></th>
								<td>
									<div class="f_bk" style=" padding-left:20px; font-size:15px;">정기권 구독</div>
									<div style="height:10px;"></div>
									<p><?if ($arr_Data['INT_OPRICE1']!="0"){?><?}?> <span class="f_ylw" style="padding-left:20px; font-size:23px;">￦<?=number_format($arr_Data['INT_PRICE1'])?><echo style="font-size:15px;">/월</span> </p>
									<?if ($arr_Data['STR_EVENT1']!=""){?> 
									<div class="mt10" style="display:none;"font-size="15px" >
										<span class="icn btn_bk btn_s" style="display:none;" ><span class="f_ylw" style="display:none;" >EVENT</span></span>
										<span style = "padding-left: 5px;" style="display:none;" ><?=$arr_Data['STR_EVENT1']?> </span>
									</div>
									<?}?>
								</td>
								<td class="f_bk" style = "width:400px; padding-left: 5px;">
									<div> - 왕복배송비 2회 포함 </div>
									<div> - 가방 이용횟수 제한 없음 </div>
									<div> - 신규고객 스타벅스 이용권 증정 </div>
							
									</td>	
								<td style = "width:150px; height:100px; background-color:#EAEBEE;">
									<div> </div>
									<div> </div>
									<div> </div>
							
									</td>	
							</tr>
							<tr>
							<th style="background-color:#EAEBEE; padding:10px">
								</th>
								<td style ="background-color:#EAEBEE;  height:10px">
									</td>
										<td style ="background-color:#EAEBEE; height:10px">
										</td>
										 	<td style ="background-color:#EAEBEE; height:10px">
											</td>
													<td style ="background-color:#EAEBEE; height:10px">
													</td>
							</tr>	
							<tr style="background-color:#EAEBEE;" > </tr>		
								<td style = "width:100px; height:100px; background-color:#EAEBEE;">
									<div> </div>
									<div> </div>
									<div> </div>
								</td>
								<th style="padding-left: 50px; background-color:white; width:100px;" class="line_r <?if ($int_gubun=="2"){?> th_em<?}?>"><label><input type="radio" name="int_gubun" class="cform"  value="2" <?if ($int_gubun=="2"){?> checked<?}?> onclick=<?$int_gubun=“2”?> ></label></th>
								<td> 
									<div class="f_bk" style="padding-left:20px; font-size:15px;">1개월권 구독</div>
									<div style="height:10px;"></div>
									<p><?if ($arr_Data['INT_OPRICE2']!="0"){?><?}?><span class="f_bk" style="padding-left:20px; font-size:23px;">￦<?=number_format($arr_Data['INT_PRICE2'])?></span></span><span style="15px bold"<?=number_format($arr_Data['INT_PRICE2'])?></span></p>
									<?if ($arr_Data['STR_EVENT2']!=""){?>
									<dl class="mt10">
										<dt class="icn btn_bk btn_s"><span class="f_ylw">EVENT</span></dt>
										<dd class="mt05"><?=$arr_Data['STR_EVENT2']?> </dd>
									</dl>
									<?}?>
								</td>
								<td class="f_bk" style = "width:400px; padding-left: 5px;">
									<div> - 왕복배송비 2회 포함 </div>
									<div> - 가방 교환 1회 가능  </div>
								
									</td>
								<td style = "width:100px; height:100px; background-color:#EAEBEE;">
									<div> </div>
									<div> </div>
									<div> </div>
							
								</td>	
							</tr>
						</tbody>
					</table>
	
				<div style="background-color:#EAEBEE; width:1100px; height:10px; "></div>
					<div class="f_size_s" text align="center" style="background-color:#EAEBEE; font-size:12px; width:1100px; height:10px;"> # 정기권 구독 후 1개월을 이용하실 경우 1개월권 요금이 적용됩니다</div>
				<div style="background-color:#EAEBEE; width:1100px; height:80px; "></div>
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
				
				<div class="center" style="background-color:#EAEBEE; width:1100px;" >
					<a href="javascript:<?if (Fnc_Om_Store_Info(14)=="1") {?>Save_Click();<?}else{?>alert('멤버십 결제가 현재 불가능합니다.\n관리자에게 문의바랍니다.');<?}?>" class="btn btn_l btn_bk w w270 f_bd">구독하기</a>
				</div>
				<div style="background-color:#EAEBEE; width:1100px; height:150px; "></div>
				</div>
			</form>

			

			</div>
					
					
					
			</div>
			</div>
			

		</div>

<? require_once $_SERVER[DOCUMENT_ROOT]."/inc/footer.php"; ?>
