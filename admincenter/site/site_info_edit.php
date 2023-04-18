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
<script language="javascript" src="js/site_info_edit.js"></script>
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
						<input type="hidden" name="imsi_str_logo" value="<?=$arr_Data['STR_LOGO']?>">

						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>사이트명</td>
								<td><input type=text name=str_sitename value="<?=$arr_Data['STR_SITENAME']?>" maxlength="100" class=lline></td>
								<td>관리자이메일</td>
								<td><input type=text name=str_memail value="<?=$arr_Data['STR_MEMAIL']?>" maxlength="100" class=lline></td>
							</tr>
							<tr>
								<td>사이트URL</td>
								<td colspan="3">http://<input type=text name=str_siteurl value="<?=$arr_Data['STR_SITEURL']?>" style="width:262px"></td>
							</tr>
						</table>
						<div class="title">회사정보</div>
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<col class=cellC style="width:12%"><col class=cellL style="width:38%">
							<tr>
								<td>회사명</td>
								<td colspan="3"><input type=text name=str_company value="<?=$arr_Data['STR_COMPANY']?>" maxlength="100" class=lline></td>
							</tr>
							<tr>
								<td>업태</td>
								<td><input type=text name=str_item1 value="<?=$arr_Data['STR_ITEM1']?>" maxlength="100"></td>
								<td>종목</td>
								<td><input type=text name=str_item2 value="<?=$arr_Data['STR_ITEM2']?>" maxlength="100"></td>
							</tr>
							<tr>
								<td>주소</td>
								<td colspan="3">
									<table border=0 cellpadding=0 cellspacing=0 class="mytable2">
										<tr>
											<td><font class=def>
											<script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
											<script>
											    function openDaumPostcode() {
											        new daum.Postcode({
											            oncomplete: function(data) {
											                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
											                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
											                document.getElementById('str_post').value = data.postcode1+data.postcode2;
											                document.getElementById('str_addr1').value = data.address1;
											
											                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
											                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
											                //var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
											                //document.getElementById('addr').value = addr;
											
											                document.getElementById('str_addr2').focus();
											            }
											        }).open();
											    }
											</script>  
											<input type=text name=str_post id=str_post size=6 readonly value="<?=$arr_Data['STR_POST']?>"> -
											<input type=text name=str_post2 id=str_post2 size=3 readonly value="<?=substr($arr_Data['STR_POST'],3,3)?>">
											<a href="javascript:openDaumPostcode()"><img src="/admincenter/img/btn_zipcode.gif" align=absmiddle></a>
											</td>
										</tr>
										<tr>
											<td><font class=def>
											<input type=text name=str_addr1 id=str_addr1 value="<?=$arr_Data['STR_ADDR1']?>" readonlY size=60>
											<input type=text name=str_addr2 id=str_addr2 value="<?=$arr_Data['STR_ADDR2']?>" size=50>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>사업자번호</td>
								<td colspan="3"><input type=text name=str_license value="<?=$arr_Data['STR_LICENSE']?>" maxlength="100"></td>
							</tr>
							<tr>
								<td>대표자명</td>
								<td><input type=text name=str_name value="<?=$arr_Data['STR_NAME']?>" maxlength="30"></td>
								<td>관리자명</td>
								<td><input type=text name=str_mname value="<?=$arr_Data['STR_MNAME']?>" maxlength="30"></td>
							</tr>
							<tr>
								<?$sTemp=explode("-",Fnc_Om_Conv_Default($arr_Data['STR_TELEP'],"--"))?>
								<td>전화번호</td>
								<td><font class=def>
								<input type=text name=str_telep1 value="<?=$sTemp[0]?>" size=4 maxlength=4> -
								<input type=text name=str_telep2 value="<?=$sTemp[1]?>" size=4 maxlength=4> -
								<input type=text name=str_telep3 value="<?=$sTemp[2]?>" size=4 maxlength=4>
								</td>
								<?$sTemp=explode("-",Fnc_Om_Conv_Default($arr_Data['STR_FAX'],"--"))?>
								<td>팩스번호</td>
								<td><font class=def>
								<input type=text name=str_fax1 value="<?=$sTemp[0]?>" size=4 maxlength=4> -
								<input type=text name=str_fax2 value="<?=$sTemp[1]?>" size=4 maxlength=4> -
								<input type=text name=str_fax3 value="<?=$sTemp[2]?>" size=4 maxlength=4>
								</td>
							</tr>
							<tr>
								<td>통신판매신고번호</td>
								<td colspan="3"><input type=text name=str_selnum value="<?=$arr_Data['STR_SELNUM']?>" maxlength="100"></td>
							</tr>
						</table>
						<div class="title">기타정보</div>
						<table class=tb>
							<col class=cellC style="width:12%"><col class=cellL style="width:88%">
							<tr>
								<td>브라우저타이틀</td>
								<td colspan="3"><input type=text name=str_toptitle value="<?=$arr_Data['STR_TOPTITLE']?>" maxlength="255" class=lline></td>
							</tr>
							<tr>
								<td>COPYRIGHT</td>
								<td colspan="3"><input type=text name=str_copyright value="<?=$arr_Data['STR_COPYRIGHT']?>" maxlength="255" class=lline></td>
							</tr>
							<?If ($arr_Data['STR_LOGO']!="") {?>
							<tr>
								<td>이미지</td>
								<td align="center" style="padding:10px;" valign="middle">

									<img src="/admincenter/files/site/<?=$arr_Data['STR_LOGO']?>" width="185">
								</td>
							</tr>
							<?}?>
							<tr>
								<td>관리자로고</td>
								<td colspan="3"><input type=file name=str_logo style="width:300px;"></td>
							</tr>
							<?If ($RetrieveFlag=="UPDATE") {?>
							<tr>
								<td>최종수정일자</td>
								<td colspan="3"><font class=ver8><?=$arr_Data['DTM_INDATE']?></td>
							</tr>
							<?}?>
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