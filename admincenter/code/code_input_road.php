<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_menutype = Fnc_Om_Conv_Default($_REQUEST[str_menutype],"01");
	$str_chocode = Fnc_Om_Conv_Default($_REQUEST[str_chocode],"00");
	$str_unicode = Fnc_Om_Conv_Default($_REQUEST[str_unicode],"00000");

	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY = "SELECT
					A.STR_IDXWORD,
					A.STR_MENUPATH,
					A.INT_CHOSORT,
					A.INT_UNISORT,
					A.STR_SERVICE,
					A.STR_UNICODE
				FROM ";
					$SQL_QUERY .= $Tname;
					$SQL_QUERY .= "comm_menu_idx A
				WHERE
					A.STR_MENUTYPE='$str_menutype'
					AND
					A.STR_CHOCODE='$str_chocode'
					AND
					A.STR_UNICODE='$str_unicode'
				ORDER BY
					A.FULL_SORT ASC ";

		$arr_menu_Data=mysql_query($SQL_QUERY);
		$rcd_cnt=mysql_num_rows($arr_menu_Data);

		if($rcd_cnt){
			$str_idxword = mysql_result($arr_menu_Data,0,STR_IDXWORD);
			$str_menupath = mysql_result($arr_menu_Data,0,STR_MENUPATH);
			$str_service = mysql_result($arr_menu_Data,0,STR_SERVICE);

			if (substr(mysql_result($arr_menu_Data,0,STR_UNICODE),0,1)=="1") {
				$str_sort = mysql_result($arr_menu_Data,0,INT_CHOSORT);
			}else{
				$str_sort = mysql_result($arr_menu_Data,0,INT_UNISORT);
			}
		}

	}
?>

		<div class="title_sub" style="margin:0">분류명 생성/수정/삭제<span>분류명을 추가하고 관리합니다</span></div>

		<form id="frm" name="frm" target="_self" method="POST">
		<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
		<input type="hidden" name="str_menutype" value="<?=$str_menutype?>">
		<input type="hidden" name="str_chocode" value="<?=$str_chocode?>">
		<input type="hidden" name="str_unicode" value="<?=$str_unicode?>">

		<table class=tb>
			<col class=cellC><col class=cellL>
			<tbody style="height:26px">
			<tr>
				<td>전체경로</td>
				<td><b><?=Fnc_Om_Conv_Default(Fnc_Om_Cate_Name($str_menutype.$str_chocode.$str_unicode),"TOP")?></b></td>
			</tr>
			<tr>
				<td><?if ($str_menutype=="01") {?>메뉴명<?}else{?>코드명<?}?></td>
				<td><input type=text name=str_idxword value="<?=$str_idxword?>" class=lline></td>
			</tr>
			<?If ($str_menutype == "01") {?>
			<tr>
				<td>메뉴경로</td>
				<td><input type=text name=str_menupath value="<?=$str_menupath?>" class=lline></td>
			</tr>
			<?}?>
			<tr>
				<td>순번</td>
				<td><input type=text name=str_sort value="<?=$str_sort?>" class=lline style="ime-mode:inactive" onKeyUp="hangulcheck(this,0);" onkeypress="num_only()"></td>
			</tr>
			<tr>
				<td>사용유무</td>
				<td>
					<input type="radio" value="Y" name="str_service" class=null <?if (Fnc_Om_Conv_Default($str_service,"Y")=="Y") {?>checked<?}?>> 사용
					<input type="radio" value="N" name="str_service" class=null <?if (Fnc_Om_Conv_Default($str_service,"Y")=="N") {?>checked<?}?>> 사용안함
				</td>
			</tr>
		</table>
		<?if ($RetrieveFlag=="INSERT"){?>
		<div style="padding:20px" align=center class=noline><img src="../img/btn_register.gif" onClick="Save_Click();" style="cursor:hand;"></div>
		<?}else{?>
		<div style="padding:20px" align=center class=noline><img src="/admincenter/img/btn_modify.gif" onClick="Save_Click();" style="cursor:hand;"></div>
		<?}?>
		</form>


		<script language="javascript" defer="true">
			table_design_load();
		</script>

