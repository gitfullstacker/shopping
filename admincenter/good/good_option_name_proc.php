<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$str_oname = Fnc_Om_Conv_Default($_REQUEST[str_oname],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(int_gubun),0)+1 as lastnumber from ".$Tname."comm_goods_option_name where str_goodcode = '".$str_goodcode."' " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_GUBUN";
			$arr_Column_Name[1]		= "STR_GOODCODE";
			$arr_Column_Name[2]		= "STR_ONAME";
			$arr_Column_Name[3]		= "DTM_INDATE";

			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $str_goodcode;
			$arr_Set_Data[2]		= $str_oname;
			$arr_Set_Data[3]		= date("Y-m-d H:i:s");

			$arr_Sub1 = "";
			$arr_Sub2 = "";
			
			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";

			}

			$Sql_Query = "INSERT INTO `".$Tname."comm_goods_option_name` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			
			?>
			<script language="javascript">
				window.location.href="good_option_name.php?page=<?=$page?>&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;
			
		case "DELETE" :
		
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_goods_option_value WHERE STR_GOODCODE='$str_goodcode' AND INT_GUBUN='$str_no' ";
			mysql_query($SQL_QUERY);
			
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_goods_option_name WHERE STR_GOODCODE='$str_goodcode' AND INT_GUBUN='$str_no' ";
			mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="good_option_name.php?page=1&str_goodcode=<?=$str_goodcode?>";
			</script>
			<?
			exit;
			break;
			
		case "OPTION" :
			
				$Sql_Query =	" SELECT
								A.*,
								(SELECT COUNT(B.INT_NUMBER) FROM ".$Tname."comm_goods_option_value B WHERE B.STR_GOODCODE=A.STR_GOODCODE AND B.INT_GUBUN=A.INT_GUBUN) AS cnt1 
							FROM `"
								.$Tname."comm_goods_option_name` AS A
							WHERE
								A.STR_GOODCODE='".$str_goodcode."' 
							ORDER BY
								A.INT_GUBUN DESC ";

				$arr_Data=mysql_query($Sql_Query);
				$arr_Data_Cnt=mysql_num_rows($arr_Data);
				?>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<?
						for($int_I = 0 ;$int_I < $arr_Data_Cnt; $int_I++) {
					?>
					<tr>
						<td width="90%" height="17">[<?=mysql_result($arr_Data,$int_I,str_oname)?> <span id="idView_Option<?=mysql_result($arr_Data,$int_I,str_goodcode)?>_<?=mysql_result($arr_Data,$int_I,int_gubun)?>"><?=mysql_result($arr_Data,$int_I,cnt1)?>건</span>]</td>
						<td width="10%" align="right">&nbsp;<a href="javascript:popupLayer('good_option_edit.php?str_goodcode=<?=mysql_result($arr_Data,$int_I,str_goodcode)?>&int_gubun=<?=mysql_result($arr_Data,$int_I,int_gubun)?>',600,500)"><img src="/admincenter/img/i_add.gif" border=0 align=absmiddle align="right"></a></td>
					</tr>
					<?
						}
					?>
				</table>
			<?
			exit;
			break;
			
	}
?>