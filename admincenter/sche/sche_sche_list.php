<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$sgbn = Fnc_Om_Conv_Default($_REQUEST[sgbn],"1");
	$year = Fnc_Om_Conv_Default($_REQUEST[year],"");
	$month = Fnc_Om_Conv_Default($_REQUEST[month],"");
	$day = Fnc_Om_Conv_Default($_REQUEST[day],"");
?>
<?
	function last_day($month, $year) { // 각 달의 마지막 날짜 구하기
		return date("t", mktime(0, 0, 0, $month, 1, $year));
	}
	$vacation_day = array(""); // 지정 공휴일
	
	if($year || $month || $day) { // 상황에 따라 현재 날자값을 설정한다.
	 	$year = sprintf("%01d", $year);
	 	$month = sprintf("%01d", $month);
	 	$day = sprintf("%01d", $day);
	
	 	if($year > 9999) {$year = 9999;}
	 	else if($year < 1) {$year = 1;}
	
	 	if($month > 12) {
	 		$year++;
	 		$month = 1;
	 	} else if($month < 1) {
	 		$year--;
	 		$month = 12;
	 	}
		
		$last_day = last_day($month, $year); // 입력사항에 맞는 마지막 일을 계산한다.
	
		if($day > $last_day) {
	 		$month++;
	 		$day = 1;
	 		$last_day = last_day($month, $year); // 변동된 달의 마지막 일을 계산한다.
	 	} else if($day < 1) {
	 		$month--;
	 		$last_day = last_day($month, $year); // 변동된 달의 마지막 일을 계산한다.
	 		$day = $last_day; // 현재 날짜를 마지막 일로 변경한다.
	 	}
	 } else { 
	 	$year = date("Y");
	 	$month = date("n");
	 	$day = date("j");
	
	 	$last_day = last_day($month, $year);
	
	 }
	
	 ##### 다음해, 다음달, 다음일, 이전해, 이전달, 이전일 의 값을 설정한다. #####
	 $re_year = $year - 1;
	 $re_month = $month - 1;
	 $re_day = $day - 1;
	 $pre_year = $year + 1;
	 $pre_month = $month + 1;
	 $pre_day = $day + 1;
	 
	 $count=0;
	 
	function fnc_cal2($str_date) {
	
		global $count;
		global $Tname;
		
		$Sql_Query = "SELECT str_time FROM ".$Tname."comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' group by str_time order by str_time asc ";
		$arr_Data=mysql_query($Sql_Query);
		$arr_Data_Cnt=mysql_num_rows($arr_Data);
		?>
		
		<?if ($arr_Data_Cnt) {?>
		<table style="width:100% cellpadding=0 cellspacing=0 border=0>
		<?
		for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
		
			$Sql_Query = "SELECT * FROM ".$Tname."comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_time='".mysql_result($arr_Data,$int_I,str_time)."' order by str_time asc ";
			$arr_Data2=mysql_query($Sql_Query);
			$arr_Data2_Cnt=mysql_num_rows($arr_Data2);
			?>
			<tr>
				<td colspan="2" style="border:0px;"><?=mysql_result($arr_Data,$int_I,str_time)?></td>
			</tr>
			<?
			for($int_J = 0 ;$int_J < $arr_Data2_Cnt; $int_J++) {
			?>
			<tr>
				<td style="width:10px;border:0px;">- </td>
				<td style="border:0px;">
					<input type=checkbox name="chkItem1[]" id="chkItem1" value="<?=mysql_result($arr_Data2,$int_J,int_number)?>">
					<a href="javascript:RowClick('<?=mysql_result($arr_Data2,$int_J,int_number)?>');"><?=stripslashes(mysql_result($arr_Data2,$int_J,str_title))?></a>
					[<span id="Tm-svr<?=mysql_result($arr_Data2,$int_J,int_number)?>">
						<a href="javascript:fnc_Read_Cont('<?=mysql_result($arr_Data2,$int_J,int_number)?>','<?=mysql_result($arr_Data2,$int_J,str_service)?>');"  id="btn_pos<?=mysql_result($arr_Data2,$int_J,int_number)?>">
						<img src="/pub/img/icons/bullet_key.gif" align="absmiddle">
						<?
						switch (mysql_result($arr_Data2,$int_J,str_service)) {
							case  "A" :
								echo "<font color='blue'>접수</font>";
								break;
							case  "Y" :
								echo "출력";
								break;
							case  "N" :
								echo "<font color='red'>미출력</font>";
								break;
						}
						?>
						</a>
					</span>]
				</td>
			</tr>
			<?
			$count++;
			}
			
		}
		
		?>
		</table>
		<?}?>
		<?
		
	}
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script type="text/javascript" src="/comm/js/jquery.min.js"></script>
<script language="javascript" src="js/sche_sche_list.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function fnc_Read_Cont(int_number,str_service) {
	
		var lay_pop = $('#msgArea');
		
		if (str_service=="A") {
			document.getElementById("pass1").style.fontWeight='bold';
			document.getElementById("pass1").style.color='red';
			document.getElementById("pass2").style.fontWeight='normal';
			document.getElementById("pass2").style.color='black';
			document.getElementById("pass3").style.fontWeight='normal';
			document.getElementById("pass3").style.color='black';
		} else if (str_service=="Y") {
			document.getElementById("pass1").style.fontWeight='normal';
			document.getElementById("pass1").style.color='black';
			document.getElementById("pass2").style.fontWeight='bold';
			document.getElementById("pass2").style.color='red';
			document.getElementById("pass3").style.fontWeight='normal';
			document.getElementById("pass3").style.color='black';
		} else if (str_service=="N") {
			document.getElementById("pass1").style.fontWeight='normal';
			document.getElementById("pass1").style.color='black';
			document.getElementById("pass2").style.fontWeight='normal';
			document.getElementById("pass2").style.color='black';
			document.getElementById("pass3").style.fontWeight='bold';
			document.getElementById("pass3").style.color='red';
		}
		document.frm_Serv.str_no.value = int_number;
		
		var pos = $('#btn_pos'+int_number).position();    // 버튼의 위치에 레이어를 띄우고자 할 경우, 위치 정보 가져옴
		lay_pop.css('top', (pos.top) + 'px');    // 레이어 위치 지정
		lay_pop.css('left', (pos.left) + 'px');
		
		lay_pop.fadeIn();
		lay_pop.focus();
	

	}
	function fnc_proc(str_service) {
		fuc_ajax('sche_sche_edit_proc.php?RetrieveFlag=SERVICE&str_no='+document.frm_Serv.str_no.value+'&str_service='+str_service);
		
		document.getElementById("Tm-svr"+document.frm_Serv.str_no.value).innerHTML = fuc_ajax('sche_sche_edit_proc.php?RetrieveFlag=LSERVICE&str_no='+document.frm_Serv.str_no.value);
		$('#msgArea').fadeOut();
	}

//-->
</SCRIPT>
</head>
<body class=scroll>

<div id="msgArea" style="display:none;position:absolute;">
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
<form name="frm_Serv" method="post">
<input type="hidden" name="str_no">
	<tr>
		<td width="70" bgcolor="#DDDDDD" align="center">
			<B> 출력유무</B>
		</td>
		<td width="150" bgcolor="#FFFFFF">&nbsp;
			<a href="javascript:fnc_proc('A');" id="pass1">접수</a> | <a href="javascript:fnc_proc('Y');" id="pass2">출력</a> | <a href="javascript:fnc_proc('N');" id="pass3">미출력</a>
			<img src="/pub/img/icons/cancel_r.gif" align="absMiddle" onmouseover="this.style.cursor='pointer'" onclick="$('#msgArea').fadeOut()">
		</td>
	</tr>
</form>
</table>
</div>

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
						
						
						<form id="frm" name="frm" target="_self" method="POST">
						<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
						<input type="hidden" name="sgbn" value="<?=$sgbn?>">
						<input type="hidden" name="year" value="<?=$year?>">
						<input type="hidden" name="month" value="<?=$month?>">
						<input type="hidden" name="day" value="<?=$day?>">
						<input type="hidden" name="str_no">
						
						<table class=tb>
							<col class=cellC style="width:50%">
							<col class=cellC style="width:50%">
							<tr>
								<td style="height:30px;text-align:center;"><a href="sche_sche_list.php?sgbn=1&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><?if ($sgbn=="1"){?><b>달력으로보기</b><?}else{?>달력으로보기<?}?></a></td>
								<td style="height:30px;text-align:center;"><a href="sche_sche_list.php?sgbn=2&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><?if ($sgbn=="2"){?><b>리스트로보기</b><?}else{?>리스트로보기<?}?></a></td>
							</tr>
						</table>
						<br>
						
						<table class=tb>
							<col class=cellC>
							<tr>
								<td height="40" style="padding-top:0px;padding-left:10px;font:20px dotum;letter-spacing:-2px;color:#000000;font-weight:bold;text-align:center;">
							      	<a href="sche_sche_list.php?sgbn=<?=$sgbn?>&year=<?=$year?>&month=<?=$re_month?>&day=<?=$day?>"><img src="/admincenter/img/icon_bPrev.gif"></a>
							      	&nbsp;<?=$year?>년 <?=$month?>월&nbsp;
							      	<a href="sche_sche_list.php?sgbn=<?=$sgbn?>&year=<?=$year?>&month=<?=$pre_month?>&day=<?=$day?>"><img src="/admincenter/img/icon_bNext.gif"></a>
								</td>
							</tr>
							<tr>
								<td height="40" style="padding-top:0px;padding-left:10px;font:16px dotum;letter-spacing:-2px;color:#000000;font-weight:bold;text-align:center;">
							      	[<a href="sche_sche_list.php?sgbn=<?=$sgbn?>&year=<?=$year-1?>&month=<?=$month?>&day=<?=$day?>">전년보기</a>] [<a href="sche_sche_list.php?sgbn=<?=$sgbn?>&year=<?=date("Y")?>&month=<?=date("n")?>&day=<?=date("j")?>">현재보기 <?=date("Y")?>년</a>]
								</td>
							</tr>
						</table>
						
						<?if ($sgbn=="1"){?>
							<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/sche/sche_include1.php";?>
						<?}else{?>
							<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/sche/sche_include2.php";?>
						<?}?>
						
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
