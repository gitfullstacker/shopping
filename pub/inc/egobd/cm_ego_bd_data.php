<?
	Function fnc_Board_Ini($pr_Int_Conf) {

		global $Tname;

		$Sql_Query = " SELECT * FROM ".$Tname."b_conf_bd WHERE CONF_SEQ='$pr_Int_Conf' ";
		$obj_Rlt = mysql_query($Sql_Query);
		$rcd_cnt=mysql_num_rows($obj_Rlt);

		if($rcd_cnt){

			$arr_Rtn_Info = array();
			while($row = mysql_fetch_array($obj_Rlt)) {
		  		array_push($arr_Rtn_Info, $row);
			}
			return $arr_Rtn_Info;

		}else{
			return "";
		}

	}

	Function fnc_Image_Cbo_Re_Set($pr_Arr_Forms, $pr_Str_Id_Key, $pr_Str_Group_Table) {

		global $Tname;

		$Sql_Query =	" SELECT
						IMG_SEQ AS A1,
						IMG_ID_KEY AS A2,
						IMG_ALIGN AS A3,
						IFNULL(IMG_TITLE, '') AS A4,
						IFNULL(IMG_CONT, '') AS A5,
						IMG_F_NAME AS A6,
						1 AS A7,
						IMG_F_SIZE AS A8,
						IMG_F_WIDTH AS A9,
						IMG_F_HEIGHT AS A10
					 FROM `"
						.$Tname."b_img_data".$pr_Str_Group_Table."`
						WHERE
						IMG_ID_KEY='$pr_Str_Id_Key' ";

		$Sql_Query .=	" UNION ALL  ";

		$Sql_Query .=	" SELECT
									FILE_SEQ AS A1,
									FILE_ID_KEY AS A2,
									FILE_ALIGN AS A3,
									IFNULL(FILE_TITLE, '') AS A4,
									IFNULL(FILE_CONT, '') AS A5,
									FILE_F_NAME AS A6,
									0 AS A7,
									FILE_F_SIZE AS A8,
									0 AS A9,
									0 AS A10
								FROM `"
									.$Tname."b_file_data".$pr_Str_Group_Table."`
								WHERE
									FILE_ID_KEY='$pr_Str_Id_Key' ";

		$result = mysql_query($Sql_Query);

		if(!result){
		   error("QUERY_ERROR");
		   exit;
		}
		$int_Total=mysql_num_rows($result);

		If ($int_Total>0) {
			$arr_File[$int_Total][1] = array();

			$Fcount=0;

			while($row=mysql_fetch_array($result)){
				$str_Temp = "";
				$str_Temp = js_escape($row[A1])."|".js_escape($row[A2])."|".js_escape($row[A3])."|".js_escape(stripslashes($row[A4]))."|".js_escape(stripslashes($row[A5]))."|".js_escape($row[A6])."|".js_escape($row[A7])."|".js_escape($row[A8])."|".js_escape($row[A9])."|".js_escape($row[A10]);

				$arr_File[$Fcount][0]= js_escape($row[A6]);
				$arr_File[$Fcount][1]= $str_Temp;

				$Fcount++;
			}

		}Else{
			$arr_File[0][1] = array();

			$arr_File[0][0]= js_escape("== 첨부된 파일이 존재하지 않습니다.");
			$arr_File[0][1]= "";
		}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function fnc_Re_Setup()
	{
		var arr_Item = new Array();
		var arr_Value = new Array();
		<?
			For ($int_I=0; $int_I <=$int_Total; $int_I++) {
				echo "arr_Item[".$int_I."]='".$arr_File[$int_I][0]."';";
				echo "arr_Value[".$int_I."]='".$arr_File[$int_I][1]."';";
			}

			echo "var str_Lbl = '".$pr_Arr_Forms[0]."';";
			echo "var str_Form = '".$pr_Arr_Forms[1]."';";
			echo "var str_Name = '".$pr_Arr_Forms[2]."';";
		?>
		var obj_Lbl;
		var obj_Sel_Box;
		var obj_Doc;
		if(typeof(document.all[str_Lbl])=="object")
		{
			obj_Lbl = document.all[str_Lbl];
			obj_Sel_Box = document.forms[str_Form].elements[str_Name];
			obj_Doc = document;
		}
		else
		{
			obj_Lbl = parent.document.all[str_Lbl];
			obj_Sel_Box = parent.document.forms[str_Form].elements[str_Name];
			obj_Doc = parent.document;
		}

		var obj_Form = obj_Sel_Box.form;

		obj_Form.txt_File_Idx.value = "";
		obj_Form.txt_File_Subject.value = "";
		obj_Form.mtx_File_Content.value = "";
		//obj_Doc.all.lbl_File_Re_Write.innerHTML = '<input type="file" class="board_input" name="fil_File_Data" id="fil_File_Data" onkeydown="event.returnValue=false;" size="52">';
		//document.getElementById("lbl_File_Re_Write").innerHTML  = '<input type="file" class="input_basic" name="fil_File_Data" id="fil_File_Data" onkeydown="event.returnValue=false;" size="52">';
		//parent.document.getElementsByName("fil_File_Data")[0].form.reset(); 
		//document.getElementById("lbl_File_Re_Write").innerHTML  = '<input type="file" class="input_basic" name="fil_File_Data" id="fil_File_Data" onkeydown="event.returnValue=false;" size="52">';
		//document.getElementById("wrapper").innerHTML = document.getElementById("wrapper").innerHTML;
		
		//var fileObj = $("input[name=fil_File_Data]");
		//fileObj.replaceWith(fileObj.clone(true));

		obj_Sel_Box.selectedIndex=0;
		obj_Sel_Box.length = arr_Item.length;

		for(var i=0; i<arr_Item.length; i++)
		{
			obj_Sel_Box.options[i].text = unescape(arr_Item[i]);
			obj_Sel_Box.options[i].value = arr_Value[i];
		}

		var objSetTable = obj_Lbl;
		with(objSetTable)
		{
			//style.zIndex = 0;
			style.display = "none";
		}
	}

	fnc_Re_Setup();
//-->
</SCRIPT>
<?
	}

	Function fnc_Use_File_Size($pr_Str_Group_Table, $pr_Str_Id_Key) {

		global $Tname;

		$str_Where = " IMG_ID_KEY='$pr_Str_Id_Key' ";
		$str_Where2 = " FILE_ID_KEY='$pr_Str_Id_Key' ";

		$Sql_Query	= "SELECT IFNULL(SUM(IMG_F_SIZE), 0) AS NUM FROM `".$Tname."b_img_data".$pr_Str_Group_Table."` WHERE ".$str_Where;
		$Sql_Query2	= "SELECT IFNULL(SUM(FILE_F_SIZE), 0) AS NUM FROM `".$Tname."b_file_data".$pr_Str_Group_Table."` WHERE ".$str_Where2;

		$result=mysql_query($Sql_Query);
		$result2=mysql_query($Sql_Query2);

		$int_Sum_Size = mysql_result($result,0,NUM)+mysql_result($result2,0,NUM);

		return $int_Sum_Size;

	}

	Function fnc_File_Use_Graph($pr_Str_Lbl, $pr_Int_Perm_Size, $pr_Int_Cur_Size) {

		global $int_Cur_File_Size;

		$int_Use_Percent = (($int_Cur_File_Size*100)/$pr_Int_Perm_Size);
		If ($int_Use_Percent==0 && $pr_Int_Cur_Size>0) {
			$int_Use_Percent = 1;
		}

		If ($pr_Int_Cur_Size<1024) {
			$str_Use_Amt = $pr_Int_Cur_Size . " Byte";
		}ElseIf ($pr_Int_Cur_Size<(1024*1024)) {
			$str_Use_Amt = number_format($pr_Int_Cur_Size/1024) . " KB";
		}Else{
			$str_Use_Amt = number_format($pr_Int_Cur_Size/1024/1024) . " MB";
		}
	?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		function fnc_View_File(pr_Perc, pr_Use, pr_Perm, pr_Lbl)
		{
			var int_Use_Per = pr_Perc;
			var str_Use_Amt = pr_Use;
			var str_Perm_Amt = pr_Perm;
			var str_Lbl = pr_Lbl;

			var obj_Lbl;
			if(typeof(document.all[str_Lbl])=="object")
				obj_Lbl = document.all[str_Lbl];
			else
				obj_Lbl = parent.document.all[str_Lbl];

			var str_View_Html =	'<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
								'<tr>'+
								'<td width="50%">'+
									'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#DDDDDD" height="10">'+
									'<table border="0" cellpadding="0" cellspacing="0" width="'+int_Use_Per+'%" height="100%">'+
										'<tr><td bgcolor="#0075BB"></td></tr>'+
									'</table>'+
									'</td></tr></table>'+
								'</td>'+
								'<td width="50%" style="font-size:8pt;">&nbsp;'+str_Use_Amt+" /"+str_Perm_Amt+'</td>'+
								'</tr>'+
								'</table>';
			obj_Lbl.innerHTML = str_View_Html;
		}

		fnc_View_File(<?=$int_Use_Percent?>, '<?=$str_Use_Amt?>', '<?=($pr_Int_Perm_Size/1024/1024)." MB"?>', '<?=$pr_Str_Lbl?>');
	//-->
	</SCRIPT>

	<?

	}

?>