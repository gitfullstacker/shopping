<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<? 
	$str_root = "/admincenter/files/data/";
	$str_location = Fnc_Om_Conv_Default($_REQUEST[str_location],$str_root);
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="JavaScript" src="js/comm_editor_list.js"></script>
</head>
<body class=scroll>

			<table width=100% border='0'>
				<tr>
					<td style="padding:10px;" valign="top">

						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
							<tr>
								<td class="table_PopTitle" align="center"><img src="/admincenter/img/pop_titlebar_up.gif" align="absmiddle"></td>
							</tr>
						</table>
					
						<div class="title title_top">이미지관리</div>

						<form name="frm" method="post" enctype="multipart/form-data" action="comm_editor_list_proc.php"> 	
						<input type="hidden" name="key" value="name">
						<input type="hidden" name="search" value="">
						<input type="hidden" name="str_location" value="<?=$str_location?>">
						<input type="hidden" name="RetrieveFlag">
						<input type="hidden" name="int_number">
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr><td class=rnd colspan=2></td></tr>
							<tr class=rndbg>
								<th colspan="2" align="right" style="padding-right:10px;">폴더생성&nbsp; <a href=javascript:fnc_makedir();><img src="/admincenter/img/i_add.gif" border=0 align="absmiddle"></a></th>
							</tr>
							<tr><td class=rnd colspan=2></td></tr>
							<col width=30% align=center>
							<col width=70% align=center>
							<?
							$SQL_QUERY = "select * from ".$Tname."comm_dir order by int_number asc";
							$arr_dir_Data=mysql_query($SQL_QUERY);    
							?>
							<tr height=30 align="center">
								<td><font class=ver81 color=616161>폴더관리[<a href="comm_editor_list.php?str_location=">루트로가기</a>]</font></td>
								<td>현재경로 : <b><?=$str_location?></b></td>
							</tr>
							<tr><td colspan=2 class=rndline></td></tr>
							<tr>
								<td bgcolor="ffffff" colspan="2">
									<div style="overflow-y:scroll; width:100%; height:100; padding:4px" >
						          	<table width="100%" border="0" cellspacing="0" cellpadding="0">
						          		<?while($row=mysql_fetch_array($arr_dir_Data)){?>
										<tr>
											<td width="100%" height="20" align="center">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="95%"><img src="/admincenter/img/dir.gif" border=0 align="absmiddle"> <a href="comm_editor_list.php?str_location=<?=urlencode($str_root.$row[STR_DIR])?>/"><font class=small color=000000><?=$row[STR_DIR]?></font></a></td> 
														<td width="5%"><a href=javascript:Delete_Click('<?=$row[INT_NUMBER]?>','<?=$str_root.$row[STR_DIR]?>/');><img src=/admincenter/img/i_del.gif border=0 align=absmiddle alt=폴더삭제></a></td>
													</tr>
												</table>
											</td>
										</tr>
						    			<?}?>
									</table>
									</div>
								</td>
							</tr>
							<tr class=rndbg>
								<th colspan="2" align="center">파일목록</th>
							</tr>
							<?
							$SQL_QUERY = "select * from ".$Tname."comm_file where str_path='$str_location' order by int_number desc";
							$arr_file_Data=mysql_query($SQL_QUERY);    
							?>
							<tr>
								<td bgcolor="ffffff" colspan="2">
									<div style="overflow-y:scroll; width:100%; height:130; padding:4px" >
						          	<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<?while($row=mysql_fetch_array($arr_file_Data)){?>
										<tr>
											<td width="50%" height="20" align="left">&nbsp;
											<?
											$full_filename = explode(".", $row[STR_FILE]);
									
											//확장자가 있는경우와 없는경우
											if (sizeof($full_filename) > 1){
												$extension = $full_filename[sizeof($full_filename)-1];
											}else{
												$extension = $full_filename[1];
											}
											?>
											
											<?switch (strtolower($extension)){
												case "jpg": echo "<img src='/admincenter/img/jpg.gif' border='0' align='absmiddle'>";break;
												case "jpeg": echo "<img src='/admincenter/img/jpg.gif' border='0' align='absmiddle'>";break;
												case "gif": echo "<img src='/admincenter/img/gif.gif' border='0' align='absmiddle'>";break;
											} ?>
											<a href="javascript:fnc_insertimg('<?=$row[STR_PATH]?>','<?=$row[STR_FILE]?>')"><font class=small color=000000><?=$row[STR_FILE]?></font></a>

											</td>
											<td width="50%" height="20" align="left">
												<font class=small color=000000><?=$row[DTM_INDATE]?></font>&nbsp;
												<a href=javascript:Delete_FClick('<?=$row[INT_NUMBER]?>','<?=$str_location?>');><img src="/admincenter/img/i_del.gif" border=0 align="absmiddle" alt="삭제"></a>
												<a href="/admincenter/comm/comm_down.php?file_dir=<?=urlencode($str_location)?>&filename=<?=urlencode($row[STR_FILE])?>"><img src="/admincenter/img/bu_file.gif" border=0 align="absmiddle" alt="삭제"></a>
											</td>
										</tr>
										<?}?>
									</table>
									</div>
								</td>
							</tr>
							<tr><td colspan=2 class=rndline></td></tr>
							<tr>
						  		<td bgcolor="#FFFFFF" colspan="2">
						    		<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="13%" align="center" class="BOR"><b>이미지</b></td>
											<td width="37%" style="padding-right:5px;">&nbsp;<input type="file" name="str_image" size="25" onChange="uploadImageCheck(this)" style="width:100%;">
											</td>
										</tr>
									</table>
						  		</td>
							</tr>
							<tr><td colspan=2 class=rndline></td></tr>
						</table>
						<br>
						<table width="100%" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" align=center>
							<tr>
  								<td align="center"><a href="javascript:Save_Click();"><img src="/admincenter/img/btn_regist_s.gif"></a></td>
							</tr>
						</table>
						
						</form>


					</td>
				</tr>
			</table>

</body>
</html>