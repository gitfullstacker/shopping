<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$int_Img_Seq = Fnc_Om_Conv_Default($_REQUEST[iseq],"0");

	$str_Img_Key = Fnc_Om_Conv_Default($_REQUEST[ikey],"");

	$int_Img_Type = Fnc_Om_Conv_Default($_REQUEST[tp],"0");

	$Sql_Query =	" SELECT
					A.IMG_F_NAME,
					A.IMG_F_NICK,
					A.IMG_F_MIME,
					IFNULL(B.BD_OPEN_YN, 1) AS OPEN_YN,
					IFNULL(B.BD_DEL_YN, 1) AS DEL_YN
				FROM
					`".$Tname."b_img_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN
					`".$Tname."b_bd_data".$str_Ini_Group_Table."` AS B
					ON
					A.BD_SEQ=B.BD_SEQ
					AND
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					A.CONF_SEQ=".$int_Ini_Board_Seq."
					AND
					A.IMG_SEQ=".$int_Img_Seq."
					AND
					A.IMG_ID_KEY='".$str_Img_Key."'";

	$arr_Rlt_Data=mysql_query($Sql_Query);
	$arr_Rlt_Data_Cnt=mysql_num_rows($arr_Rlt_Data);

	If ($arr_Rlt_Data_Cnt) {

		$str_Real_File_Name =  mysql_result($arr_Rlt_Data,0,IMG_F_NICK);
		$str_File_Name = mysql_result($arr_Rlt_Data,0,IMG_F_NAME);
		$str_Content_Type = mysql_result($arr_Rlt_Data,0,IMG_F_MIME);

	}Else{

		$str_Url = "/admincenter/img/board/";
		$str_Real_File_Name = "noimage.gif";
		$str_File_Name = "noimage.gif";
		$str_Content_Type = "image/gif";

	}

	header("Content-type: ".$str_Content_Type);
	$str_Add_Tag = $_SERVER['DOCUMENT_ROOT'].$str_Ini_File_Path;
	$url = $str_Add_Tag . iconv( "UTF-8", "EUC-KR", $str_File_Name);

	$fp = fopen($url,"r");
	$img_data = fread($fp,filesize($url));
	fclose($fp);

	echo $img_data;
?>