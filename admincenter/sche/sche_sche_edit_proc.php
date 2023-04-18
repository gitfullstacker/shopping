<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$int_fnumber = Fnc_Om_Conv_Default($_REQUEST[int_fnumber],"");
	$str_String = Fnc_Om_Conv_Default($_REQUEST[str_String],"");
	$str_date = Fnc_Om_Conv_Default($_REQUEST[str_date],"");
	$str_time1 = Fnc_Om_Conv_Default($_REQUEST[str_time1],"");
	$str_time2 = Fnc_Om_Conv_Default($_REQUEST[str_time2],"");
	$str_time = $str_time1.":".$str_time2;
	$str_title = Fnc_Om_Conv_Default($_REQUEST[str_title],"");
	$str_contents = Fnc_Om_Conv_Default($_REQUEST[str_contents],"");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");	
	$str_indate1 = Fnc_Om_Conv_Default($_REQUEST[str_indate1],"");	
	$str_indate2 = Fnc_Om_Conv_Default($_REQUEST[str_indate2],"");	
	$str_indate3 = Fnc_Om_Conv_Default($_REQUEST[str_indate3],"");	
	$str_indate = $str_indate1." ".$str_indate2.":".$str_indate3.":00";
	
	$str_sImage1=$_FILES['str_sImage1']['tmp_name'];
	$str_sImage1_name=$_FILES['str_sImage1']['name'];
	$str_sImage1_size=$_FILES['str_sImage1']['size'];
	
	$str_source = Fnc_Om_Conv_Default($_REQUEST[str_source],"");	
	$str_stitle = Fnc_Om_Conv_Default($_REQUEST[str_stitle],"");	
	$str_url = Fnc_Om_Conv_Default($_REQUEST[str_url],"");	

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");
	
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT']."/admincenter/files/sche/";

	if (!is_dir($str_Add_Tag)){
		mkdir($str_Add_Tag,0777);
	}

	switch($RetrieveFlag){
     	case "INSERT" :
     	
			$arr_Temp=$str_Temp[1];
			$str_dimage6=$arr_Temp[0];

			$SQL_QUERY = "select ifnull(max(int_number),0)+1 as lastnumber from ".$Tname."comm_sche " ;
			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber);

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_DATE";
			$arr_Column_Name[2]		= "STR_TIME";
			$arr_Column_Name[3]		= "STR_TITLE";
			$arr_Column_Name[4]		= "STR_CONTENTS";
			$arr_Column_Name[5]		= "DTM_INDATE";
			$arr_Column_Name[6]		= "DTM_MODATE";
			$arr_Column_Name[7]		= "STR_INUSERID";
			$arr_Column_Name[8]		= "STR_MOUSERID";
			$arr_Column_Name[9]		= "STR_SERVICE";
			
			$arr_Set_Data[0]		= $lastnumber;
			$arr_Set_Data[1]		= $str_date;
			$arr_Set_Data[2]		= $str_time;
			$arr_Set_Data[3]		= addslashes($str_title);
			$arr_Set_Data[4]		= addslashes($str_contents);
			$arr_Set_Data[5]		= $str_indate;
			$arr_Set_Data[6]		= date("Y-m-d H:i:s");
			$arr_Set_Data[7]		= $arr_Auth[0];
			$arr_Set_Data[8]		= $arr_Auth[0];
			$arr_Set_Data[9]		= $str_service;
			
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
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_sche` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
	
			for($ii = 1; $ii < count($str_sImage1); $ii++) {
				if(!empty($str_sImage1[$ii])) {
				
					$str_Temp=Fnc_Om_File_Save($str_sImage1[$ii],$str_sImage1_name[$ii],'','','',$str_del_img1,$str_Add_Tag);
					if ($str_Temp[0] == "0") {
						?>
						<script language="javascript">
							alert("업로드에 실패하셨습니다.");
							history.back();
						</script>
						<?
						exit;
					}
					$arr_Temp=$str_Temp[1];
					$str_sdimage1=$arr_Temp[0];
					
					$SQL_QUERY = "select ifnull(max(INT_FNUMBER),0)+1 as lastnumber from `".$Tname."comm_sche_file` where int_number='".$lastnumber."' " ;
					$arr_sort_Data=mysql_query($SQL_QUERY);
					$lastnumber1 = mysql_result($arr_sort_Data,0,lastnumber);
					
					$SQL_QUERY = "INSERT INTO `".$Tname."comm_sche_file` (";
							$SQL_QUERY .= "INT_NUMBER,INT_FNUMBER,STR_SIMAGE1,INT_SIZE,DTM_INDATE
													) VALUES (
														'$lastnumber','$lastnumber1','".$str_sdimage1."','".$str_sImage1_size[$ii]."','".date("Y-m-d H:i:s")."'
													)";
					mysql_query($SQL_QUERY);
				}
			}
			
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche_news WHERE INT_NUMBER='".$lastnumber."' ";
			mysql_query($SQL_QUERY);
			
			for($ii = 1; $ii < count($str_source); $ii++) {
			
				if(!empty($str_source[$ii])) {
				
					$SQL_QUERY = "select ifnull(max(INT_NNUMBER),0)+1 as lastnumber from `".$Tname."comm_sche_news` where int_number='".$lastnumber."' " ;
					$arr_sort_Data=mysql_query($SQL_QUERY);
					$lastnumber1 = mysql_result($arr_sort_Data,0,lastnumber);
					
					$SQL_QUERY = "INSERT INTO `".$Tname."comm_sche_news` (";
							$SQL_QUERY .= "INT_NUMBER,INT_NNUMBER,STR_SOURCE,STR_STITLE,STR_URL,DTM_INDATE
													) VALUES (
														'$lastnumber','$lastnumber1','".addslashes($str_source[$ii])."','".addslashes($str_stitle[$ii])."','".$str_url[$ii]."','".date("Y-m-d H:i:s")."'
													)";
					mysql_query($SQL_QUERY);
				}
			}
	
			?>
			<script language="javascript">
				window.location.href="sche_sche_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$lastnumber?>";
			</script>
			<?
			exit;
			break;

     	case "UPDATE" :
			
			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_NUMBER";
			$arr_Column_Name[1]		= "STR_DATE";
			$arr_Column_Name[2]		= "STR_TIME";
			$arr_Column_Name[3]		= "STR_TITLE";
			$arr_Column_Name[4]		= "STR_CONTENTS";
			$arr_Column_Name[5]		= "DTM_INDATE";
			$arr_Column_Name[6]		= "DTM_MODATE";
			$arr_Column_Name[7]		= "STR_MOUSERID";
			$arr_Column_Name[8]		= "STR_SERVICE";
			
			$arr_Set_Data[0]		= $str_no;
			$arr_Set_Data[1]		= $str_date;
			$arr_Set_Data[2]		= $str_time;
			$arr_Set_Data[3]		= addslashes($str_title);
			$arr_Set_Data[4]		= addslashes($str_contents);
			$arr_Set_Data[5]		= $str_indate;
			$arr_Set_Data[6]		= date("Y-m-d H:i:s");
			$arr_Set_Data[7]		= $arr_Auth[0];
			$arr_Set_Data[8]		= $str_service;
			
			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";

			}

			$Sql_Query = "UPDATE `".$Tname."comm_sche` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($Sql_Query);
			
			for($ii = 1; $ii < count($str_sImage1); $ii++) {
				if(!empty($str_sImage1[$ii])) {

					$str_Temp=Fnc_Om_File_Save($str_sImage1[$ii],$str_sImage1_name[$ii],'','','',$str_del_img1,$str_Add_Tag);
					if ($str_Temp[0] == "0") {
						?>
						<script language="javascript">
							alert("업로드에 실패하셨습니다.");
							history.back();
						</script>
						<?
						exit;
					}
					$arr_Temp=$str_Temp[1];
					$str_sdimage1=$arr_Temp[0];
					
					$SQL_QUERY = "select ifnull(max(INT_FNUMBER),0)+1 as lastnumber from `".$Tname."comm_sche_file` where int_number='".$str_no."' " ;
					$arr_sort_Data=mysql_query($SQL_QUERY);
					$lastnumber1 = mysql_result($arr_sort_Data,0,lastnumber);
					
					$SQL_QUERY = "INSERT INTO `".$Tname."comm_sche_file` (";
							$SQL_QUERY .= "INT_NUMBER,INT_FNUMBER,STR_SIMAGE1,INT_SIZE,DTM_INDATE
													) VALUES (
														'$str_no','$lastnumber1','".$str_sdimage1."','".$str_sImage1_size[$ii]."','".date("Y-m-d H:i:s")."'
													)";
					mysql_query($SQL_QUERY);
				}
			}
			
			$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche_news WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($SQL_QUERY);
			
			for($ii = 1; $ii < count($str_source); $ii++) {
				if(!empty($str_source[$ii])) {
				
					$SQL_QUERY = "select ifnull(max(INT_NNUMBER),0)+1 as lastnumber from `".$Tname."comm_sche_news` where int_number='".$str_no."' " ;
					$arr_sort_Data=mysql_query($SQL_QUERY);
					$lastnumber1 = mysql_result($arr_sort_Data,0,lastnumber);
					
					$SQL_QUERY = "INSERT INTO `".$Tname."comm_sche_news` (";
							$SQL_QUERY .= "INT_NUMBER,INT_NNUMBER,STR_SOURCE,STR_STITLE,STR_URL,DTM_INDATE
													) VALUES (
														'$str_no','$lastnumber1','".addslashes($str_source[$ii])."','".addslashes($str_stitle[$ii])."','".$str_url[$ii]."','".date("Y-m-d H:i:s")."'
													)";
					mysql_query($SQL_QUERY);
				}
			}
			?>
			<script language="javascript">
				window.location.href="sche_sche_edit.php<?=$str_String?>&RetrieveFlag=UPDATE&str_no=<?=$str_no?>";
			</script>
			<?

			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {


				$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche_news WHERE INT_NUMBER='".$chkItem1[$i]."' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY =	" SELECT
								STR_SIMAGE1
							FROM "
								.$Tname."comm_sche_file
							WHERE
								INT_NUMBER='$chkItem1[$i]' ";

				$arr_img_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_img_Data);

				if($rcd_cnt){
					for($int_I = 0 ;$int_I < $rcd_cnt; $int_I++) {
					   	if (mysql_result($arr_img_Data,$int_I,STR_SIMAGE1) !="") {
					   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,$int_I,STR_SIMAGE1));
					   	}
				   	}
				}
				
				$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche_file WHERE INT_NUMBER='".$chkItem1[$i]."' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche WHERE INT_NUMBER='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);


			}
			?>
			<script language="javascript">
				window.location.href="sche_sche_list.php<?=$str_String?>";
			</script>
			<?
			exit;
			break;
			
		case "Load" :
			?>
			<table class=tb>
				<thead>
				<col width=90% align=left>
				<col width=10% align=center>
				</thead>
				<tbody>
				<?
				$SQL_QUERY = "select * from ";
							$SQL_QUERY .= $Tname;
							$SQL_QUERY .= "comm_sche_file
						where
							int_number='".$str_no."'
						order by int_fnumber asc " ;

				$arr_sub_Data=mysql_query($SQL_QUERY);
				?>
				<?while($row=mysql_fetch_array($arr_sub_Data)){?>
				<tr>
					<td style="height:30px;">
						<?if (!($row[STR_SIMAGE1]=="")) {?><a href="sche_sche_dn.php?str_no=<?=$row[INT_NUMBER]?>&int_fnumber=<?=$row[INT_FNUMBER]?>"><img src="/pub/img/board/ic_disk.gif" align="absmiddle"> <?=$row[STR_SIMAGE1]?> [<?=fnc_File_Size($row[INT_SIZE])?>]</a><?}else{?>&nbsp;<?}?>
					</td>
					<td style="text-align:center;">
						<a href="javascript:fnc_del('<?=$row[INT_NUMBER]?>','<?=$row[INT_FNUMBER]?>')"><img src="/admincenter/img/btn_s_del.gif" align="absmiddle" style="cursor:pointer"/></a>
					</td>
				</tr>
				<?}?>
			</table>
			<?
			exit;
			break;
			
		case "FDELETE" :
		
			$SQL_QUERY =	" SELECT
							STR_SIMAGE1
						FROM "
							.$Tname."comm_sche_file
						WHERE
							INT_NUMBER='$str_no'
							AND
							INT_FNUMBER='$int_fnumber' ";

			$arr_img_Data=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($arr_img_Data);

			if($rcd_cnt){
			   	if (mysql_result($arr_img_Data,0,STR_SIMAGE1) !="") {
			   		Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_img_Data,0,STR_SIMAGE1));
			   	}
			}

			$SQL_QUERY = "DELETE FROM ".$Tname."comm_sche_file WHERE INT_NUMBER='$str_no' AND INT_FNUMBER='$int_fnumber' ";
			mysql_query($SQL_QUERY);

			exit;
			break;
			
		case "SERVICE" :

			$SQL_QUERY = "UPDATE ".$Tname."comm_sche SET STR_SERVICE='$str_service' WHERE INT_NUMBER='".$str_no."' ";
			mysql_query($SQL_QUERY);
				

			exit;
			break;
			
		case "LSERVICE" :
		
			$SQL_QUERY =	" SELECT
							A.*
						FROM "
							.$Tname."comm_sche AS A
						WHERE
							A.INT_NUMBER='$str_no' ";
	
			$arr_Rlt_Data=mysql_query($SQL_QUERY);
			if (!$arr_Rlt_Data) {
	    		echo 'Could not run query: ' . mysql_error();
	    		exit;
			}
			$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
			
			?>
				<a href="javascript:fnc_Read_Cont('<?=$arr_Data['INT_NUMBER']?>','<?=$arr_Data['STR_SERVICE']?>');"  id="btn_pos<?=$arr_Data['INT_NUMBER']?>">
				<img src="/pub/img/icons/bullet_key.gif" align="absmiddle">
				<?
				switch ($arr_Data['STR_SERVICE']) {
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

				
			exit;
			break;
			
    }

?>