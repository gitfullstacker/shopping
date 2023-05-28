<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
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
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/site_info2_edit.js"></script>
</head>
<body class=scroll>
<table width=100% height=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_logo_info.php";?>
		<td width=100%>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu_info.php";?>
		</td>
	</tr>
	<tr>
		<td colspan="3"><?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_tmenu.php";?></td>
	</tr>
	<tr>
		<td valign=top id=leftMenu>
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_lmenu_info.php";?>
		</td>
		<td colspan=2 valign=top height=100%> 
			<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_stitle_info.php";?>
			<table width=100%>
				<tr>
					<td style="padding:10px">
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?></div>


						<form id="frm" name="frm" target="_self" method="POST" action="site_info_edit.php" enctype="multipart/form-data">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td>구독 멤버십</td>
								<td colspan="3">
									정가 <input type=text name="int_oprice1" value="<?=$arr_Data['INT_OPRICE1']?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
									/
									판매가 <input type=text name="int_price1" value="<?=$arr_Data['INT_PRICE1']?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
								</td>
							</tr>
							<tr>
								<td>이벤트문구</td>
								<td colspan="3"><input type=text name=str_event1 value="<?=$arr_Data['STR_EVENT1']?>" style="width:400px"></td>
							</tr>
						</table>
						<br>
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td>렌트 멤버십</td>
								<td colspan="3">
									정가 <input type=text name="int_oprice2" value="<?=$arr_Data['INT_OPRICE2']?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
									/
									판매가 <input type=text name="int_price2" value="<?=$arr_Data['INT_PRICE2']?>" style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()">
								</td>
							</tr>
							<tr>
								<td>이벤트문구</td>
								<td colspan="3"><input type=text name=str_event2 value="<?=$arr_Data['STR_EVENT2']?>" style="width:400px"></td>
							</tr>
						</table>
						<br>
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td>렌트 구간할인1</td>
								<td colspan="3">
									<input type="number" name="int_dstart1" value="<?=$arr_Data['INT_DSTART1']?>" style="width: 50px;">
									~
									<input type="number" name="int_dend1" value="<?=$arr_Data['INT_DEND1']?>" style="width: 50px;">
									:
									<input type="number" name="int_discount1" value="<?=$arr_Data['INT_DISCOUNT1']?>" style="width: 50px;">%
								</td>
							</tr>
							<tr>
								<td>렌트 구간할인2</td>
								<td colspan="3">
									<input type="number" name="int_dstart2" value="<?=$arr_Data['INT_DSTART2']?>" style="width: 50px;">
									~
									<input type="number" name="int_dend2" value="<?=$arr_Data['INT_DEND2']?>" style="width: 50px;">
									:
									<input type="number" name="int_discount2" value="<?=$arr_Data['INT_DISCOUNT2']?>" style="width: 50px;">%
								</td>
							</tr>
							<tr>
								<td>렌트 구간할인3</td>
								<td colspan="3">
									<input type="number" name="int_dstart3" value="<?=$arr_Data['INT_DSTART3']?>" style="width: 50px;">
									~
									<input type="number" name="int_dend3" value="<?=$arr_Data['INT_DEND3']?>" style="width: 50px;">
									:
									<input type="number" name="int_discount3" value="<?=$arr_Data['INT_DISCOUNT3']?>" style="width: 50px;">%
								</td>
							</tr>
							<tr>
								<td>렌트 구간할인4</td>
								<td colspan="3">
									<input type="number" name="int_dstart4" value="<?=$arr_Data['INT_DSTART4']?>" style="width: 50px;">
									~
									<input type="number" name="int_dend4" value="<?=$arr_Data['INT_DEND4']?>" style="width: 50px;">
									:
									<input type="number" name="int_discount4" value="<?=$arr_Data['INT_DISCOUNT4']?>" style="width: 50px;">%
								</td>
							</tr>
							<tr>
								<td>렌트 구간할인5</td>
								<td colspan="3">
									<input type="number" name="int_dstart5" value="<?=$arr_Data['INT_DSTART5']?>" style="width: 50px;">
									~
									<input type="number" name="int_dend5" value="<?=$arr_Data['INT_DEND5']?>" style="width: 50px;">
									:
									<input type="number" name="int_discount5" value="<?=$arr_Data['INT_DISCOUNT5']?>" style="width: 50px;">%
								</td>
							</tr>
						</table>
						

						<div class=button>
						<a href="javascript:Save_Click();"><img src="/admincenter/img/btn_<?If ($RetrieveFlag=="INSERT") {?>register<?}else{?>modify<?}?>.gif"></a>
						</div>

						</form>

						<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_btip_info.php";?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td height=3 bgcolor="#E6E6E6" colspan=2></td></tr>
	<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_copyright_info.php";?>
</table>
<script>table_design_load();</script>
</body>
</html>