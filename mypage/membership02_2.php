<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
	
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	
	$Sql_Query =	" SELECT 
					B.*,A.STR_PTYPE,A.STR_CANCEL
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
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>
<script language="javascript" src="js/membership02_2.js"></script>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   마이페이지   >   구독권 정보</p>
					<div class="tit_h2 mt10">마이페이지</div>
					<div class="lnb_tab">
						<? require_once $_SERVER['DOCUMENT_ROOT']."/mypage/tab.php"; ?>
					</div>
					
		          	<form id="frm" name="frm" target="_self" method="POST">
		          	<input type="hidden" name="RetrieveFlag">
		          	<input type="hidden" name="str_no" value="<?=$str_no?>">
					
					<!-- <div class="tit_h2_2 mt45">구독권 해지</div>
					<p class="tit_desc mt20">에이블랑의 구독권 이용을 해지하시는 이유를 말씀해주시면, 참고하여 보다 나은 서비스를 위해 노력하겠습니다.</p> -->
					<div class="membership_bx02 mt20">
						<?
						$SQL_QUERY = "select a.* from ";
						$SQL_QUERY.=$Tname;
						$SQL_QUERY.="comm_com_code a ";
						$SQL_QUERY.="where a.int_gubun='4' and a.str_service='Y' ";
						$SQL_QUERY.="order by a.int_number asc ";

						$arr_Code_Menu = mysql_query($SQL_QUERY);
						?>
						<?while($row=mysql_fetch_array($arr_Code_Menu)){?>
						<label><input type="radio" value="<?=$row[INT_NUMBER]?>" name=int_esce /> <?=$row[STR_CODE]?></label>
						<?}?>
					</div>
					<div class="membership_bx03 mt30">
						<textarea name="str_escont" id="str_escont" cols="30" rows="10"></textarea>
					</div>

					<div class="center mt35">
						<a href="javascript:Save_Click();" class="btn btn_l btn_ylw w w270 f_bd">구독권 등록 해지하기</a>
						<a href="membership.php" class="btn btn_l btn_bk w w270 f_bd">취소</a>
					</div>

					</form>
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
