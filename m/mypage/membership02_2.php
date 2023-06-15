<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	
	$Sql_Query =	" SELECT 
					B.*,A.STR_PTYPE,A.STR_CANCEL1
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
					A.iNT_NUMBER='$str_no' 
					AND
					A.STR_USERID='$arr_Auth[0]' ";

	$arr_Data=mysql_query($Sql_Query);
	$arr_Data_Cnt=mysql_num_rows($arr_Data);
	
	If ($arr_Data_Cnt==0) {
	
		exti;
	}	
?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/header.php"; ?>
<script language="javascript" src="js/membership02_2.js"></script>
		
		<div class="con_width">
		
			<div class="tit_h2 mt25">
				<em>멤버십 해지</em>
			</div>

			<p class="pt15">에이블랑의 구독권을 해지하시는 이유를 말씀해주시면, <br />참고하여 보다 나은 서비스를 위해 노력하겠습니다.</p>

          	<form id="frm" name="frm" target="_self" method="POST">
          	<input type="hidden" name="RetrieveFlag">
          	<input type="hidden" name="str_no" value="<?=$str_no?>">

				<div class="membership_bx10 mt10">
					<ul class="list_type01">
						<?
						$SQL_QUERY = "select a.* from ";
						$SQL_QUERY.=$Tname;
						$SQL_QUERY.="comm_com_code a ";
						$SQL_QUERY.="where a.int_gubun='4' and a.str_service='Y' ";
						$SQL_QUERY.="order by a.int_number asc ";

						$arr_Code_Menu = mysql_query($SQL_QUERY);
						?>
						<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
						<li><label><input type="radio" value="<?=$row[INT_NUMBER]?>" name=int_esce /> <?=$row[STR_CODE]?></label></li>
						<?}?>

					</ul>
				</div>
				<div class="membership_bx10 mt10">
					<textarea name="str_escont" id="str_escont" cols="30" rows="10"></textarea>
				</div>
				
				<div class="btn_w mt15">
					<p class="f_left"><a href="javascript:Save_Click();" class="btn btn_l btn_ylw w100p f_bd">구독권 정보 해지하기</a></p>
					<p class="f_right"><a href="membership.php" class="btn btn_l btn_bk w100p f_bd">취소</a></p>
				</div>
			</form>
			

		</div>
		<div class="paging mt15" style="margin-bottom: 15px;">

<? require_once $_SERVER['DOCUMENT_ROOT']."/m/inc/footer.php"; ?>



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