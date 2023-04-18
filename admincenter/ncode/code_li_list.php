<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?   
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<? 
	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"01");
?>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . "/admincenter/inc/inc_header_info.php";?>
<script language="javascript" src="js/code_li_list.js"></script>
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
						<div class="title title_top"><?=Fnc_Om_Loc_Name("01".$arr_Auth[7]);?><span>분류들을 등록하고 수정하는 영역입니다</span> </div>
						
						<table width=100% border=0>
							<tr>
								<td valign=top>
								
									<div id=treeCategory class=scroll onmousewheel="return iciScroll(this)">
									<div style="padding-bottom:1px"><span>
									
										<iframe src="code_vi_road.php?str_menutype=<?=$str_menutype?>" frameborder="0" width="98%" height="99%" marginwidth="0" name="_TreeView" marginheight="0" scrolling="yes"></iframe>
								
									</div>
									</div>
									
								</td>
								<td valign=top width=100% style="padding-left:10px"> 
								
									<span id="idView_Incode"></span>
						 
									<script language="javascript">
										fuc_set('code_input_road.php?str_menutype=<?=$str_menutype?>','_Incode');
										table_design_load();
									</script>
								
								</td>
							</tr>
						</table>
						
						<table>
							<tr>
								<td id="obj_Lbl" colspan="2" height="0"></td>
							</tr>
						</table>
						
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
