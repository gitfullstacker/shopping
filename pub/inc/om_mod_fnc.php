<?

// ############ ++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++
//	값이 없을때 대체값 반환 시작
function Fnc_Om_Conv_Default($pr_Val, $pr_Def)
{

	$str_Rtn = $pr_Val;

	if ((Is_Null($pr_Val) || ($pr_Val == "")) && (!(is_array($pr_Val)))) {
		$str_Rtn = $pr_Def;
	} else {
		$str_Rtn = $pr_Val;
	}

	return $str_Rtn;
}
//	값이 없을때 대체값 반환 종료
// +++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++ ############

// ############ ++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++
//	해당 숫자의 길이만큼 앞자리에 Zero 추가 함수 시작
function Fnc_Om_Add_Zero($str_Number, $int_Len)
{
	return right("0000000000000" . $str_Number, $int_Len);
}
//	해당 숫자의 길이만큼 앞자리에 Zero 추가 함수 종료
// +++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++ ############

// ############ ++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++
//	Unique한 숫자를 생성하여 반환하는 함수 시작
function Fnc_Om_Id_Key_Create()
{

	$str_Date = Date("YmdHis", time());
	$str_ram = rand(0, 9999999);

	return $str_Date . Fnc_Om_Add_Zero($str_ram, 7);
}
//	Unique한 숫자를 생성하여 반환하는 함수 종료
// +++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++ ############

// #################################################
//	= 공백 숫자로 변환 시작
//	기능설명 : 공백 데이터 Zero로 변환 후 Return
//	입력값 : pr_Val[처리할데이터]
//	출력값 : int_Value[0]
function Fnc_Om_Zero_Convert($pr_Val)
{

	$int_Value = $pr_Val;

	if ($pr_Val == "") {
		$int_Value = 0;
	}

	if (Is_Numeric($int_Value) == false) {
		$int_Value = 0;
	}

	return $int_Value;
}
//	= 공백 숫자로 변환 종료
// #################################################

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//	= 폴더가 존재하지 않을때 폴더 자동생성 서브루틴 시작
function Fnc_Om_Folder_Create($pr_Str_Dir_Path)
{

	if (!is_dir($pr_Str_Dir_Path)) {
		if (!@mkdir($pr_Str_Dir_Path, 0700, true)) {
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
//	= 폴더가 존재하지 않을때 폴더 자동생성 서브루틴 종료
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//	= 파일 삭제 서브루틴 시작
function Fnc_Om_File_Delete($pr_Str_Dir_Path, $pr_Str_File_Name)
{

	$pr_Str_File_Name = iconv("UTF-8", "EUC-KR", $pr_Str_File_Name) ? iconv("UTF-8", "EUC-KR", $pr_Str_File_Name) : $pr_Str_File_Name;

	$om_ds = file_exists($pr_Str_Dir_Path . $pr_Str_File_Name);

	if ($om_ds) {
		@unlink($pr_Str_Dir_Path . $pr_Str_File_Name);
		return true;
	} else {
		return false;
	}
}
//	= 파일 삭제 서브루틴 종료
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function Fnc_Om_File_Exp($file_name)
{

	$full_name = explode(".", "$file_name");
	$extension = $full_name[sizeof($full_name) - 1];

	if (
		!strcmp($extension, "html") ||
		!strcmp($extension, "htm") ||
		!strcmp($extension, "php") ||
		!strcmp($extension, "php3") ||
		!strcmp($extension, "phtml") ||
		!strcmp($extension, "inc") ||
		!strcmp($extension, "pl") ||
		!strcmp($extension, "cgi") ||
		!strcmp($extension, "asp") ||
		!strcmp($extension, "exe") ||
		!strcmp($extension, "")
	) {
		return false;
	} else {
		return true;
	}
}

function Fnc_Om_File_Fexist($str_file, $str_path)
{

	$fexist = true;
	$int_cnt = 0;
	$full_filename = explode(".", "$str_file");

	while ($fexist) {

		$same_file_exist = file_exists($str_path . iconv("UTF-8", "EUC-KR", $str_file));

		if ($same_file_exist) {
			$int_cnt = $int_cnt + 1;
			$str_file = "$full_filename[0]" . "[" . "$int_cnt" . "]" . ".$full_filename[1]";
		} else {
			$fexist = false;
		}
	}
	return $str_file;
}

function Fnc_Om_Store_Info($str_gubun)
{

	global $Tname;

	mysql_query('set names utf-8');
	$str_query = "select * from " . $Tname . "comm_site_info where int_number='1'  ";
	$rel = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($rel);

	if ($rcd_cnt) {
		switch ($str_gubun) {
			case "1":
				return mysql_result($rel, 0, str_sitename);
				break;
			case "2":
				return mysql_result($rel, 0, str_memail);
				break;
			case "3":
				return mysql_result($rel, 0, str_siteurl);
				break;
			case "4":
				return mysql_result($rel, 0, str_company);
				break;
			case "5":
				return mysql_result($rel, 0, str_telep);
				break;
			case "6":
				return mysql_result($rel, 0, str_toptitle);
				break;
			case "7":
				return mysql_result($rel, 0, str_copyright);
				break;
			case "8":
				return mysql_result($rel, 0, str_logo);
				break;
			case "9":
				return mysql_result($rel, 0, str_level1);
				break;
			case "10":
				return mysql_result($rel, 0, int_stamp1);
				break;
			case "11":
				return mysql_result($rel, 0, int_stamp2);
				break;
			case "12":
				return mysql_result($rel, 0, int_stamp3);
				break;
			case "13":
				return mysql_result($rel, 0, int_stamp4);
				break;
			case "14":
				return mysql_result($rel, 0, int_payyn);
				break;
			case "15":
				return mysql_result($rel, 0, str_url1);
				break;
			case "16":
				return mysql_result($rel, 0, str_url2);
				break;
			default:
				return "";
				break;
		}
	} else {
		return "";
	}
}

function Fnc_Om_Select_Code($str_chocode, $str_idxnum)
{

	global $Tname;

	if ($str_chocode == "0000000") {

		$str_query = "select
									distinct(a.str_unicode),a.str_menutype,a.int_chosort
					 				,a.str_chocode,a.int_unisort,a.str_menupath,a.str_idxword,b.str_btmflag
					 			from ";
		$str_query .= $Tname;
		$str_query .= "comm_menu_idx a,";
		$str_query .= $Tname;
		$str_query .= "comm_menu_con b,";
		$str_query .= $Tname;
		$str_query .= "comm_menu_right c
								where
								 	a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode
									and a.str_unicode=b.str_unicode and a.str_menutype=c.str_menutype
									and a.str_chocode=c.str_chocode and a.str_unicode=c.str_unicode and c.str_idxcode='01' and a.str_unicode < '20000'
									and c.str_idxnum='$str_idxnum'
									and a.str_service='Y' order by a.str_menutype asc, a.int_chosort asc, a.str_chocode asc, a.int_unisort, a.str_unicode asc";
		$DbRecIdx = mysql_query($str_query);
		$rcd_cnt = mysql_num_rows($DbRecIdx);

		if ($rcd_cnt) {
			$str_chocode = mysql_result($DbRecIdx, 0, str_chocode);
		}
	}

	$str_query = "select
								distinct(a.str_unicode),a.str_menutype,a.int_chosort
								,a.str_chocode,a.int_unisort,a.str_menupath,a.str_idxword,b.str_btmflag
							from ";
	$str_query .= $Tname;
	$str_query .= "comm_menu_idx a,";
	$str_query .= $Tname;
	$str_query .= "comm_menu_con b,";
	$str_query .= $Tname;
	$str_query .= "comm_menu_right c
							where
								a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode
								and a.str_unicode=b.str_unicode and a.str_menutype=c.str_menutype
								and a.str_chocode=c.str_chocode and a.str_unicode=c.str_unicode and c.str_idxcode='01' and a.str_chocode='$str_chocode' and a.str_unicode > '30000' and a.str_unicode < '40000'
								and c.str_idxnum='$str_idxnum'
								and a.str_service='Y' order by a.str_menutype asc, a.int_chosort asc, a.str_chocode asc, a.int_unisort, a.str_unicode asc";

	$DbRecIdx = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($DbRecIdx);

	if ($rcd_cnt) {
		return mysql_result($DbRecIdx, 0, str_chocode) . mysql_result($DbRecIdx, 0, str_unicode);
	} else {
		return "0000000";
	}
}

function Fnc_Om_Select_Url($str_menu)
{

	global $Tname;
	global $arr_Auth;

	//$str_menu = "01".$str_menu;

	if (substr($str_menu, 2, 1) != "3") {

		$str_query = "select distinct(a.str_unicode),a.str_menutype,a.int_chosort
						,a.str_chocode,a.int_unisort,a.str_menupath,a.str_idxword,b.str_btmflag
					from ";
		$str_query .= $Tname;
		$str_query .= "comm_menu_idx a,";
		$str_query .= $Tname;
		$str_query .= "comm_menu_con b,";
		$str_query .= $Tname;
		$str_query .= "comm_menu_right c
					where
						a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode
						and a.str_unicode=b.str_unicode and a.str_menutype=c.str_menutype
						and a.str_chocode=c.str_chocode and a.str_unicode=c.str_unicode and c.str_idxcode='01'
						and a.str_chocode='" . substr($str_menu, 0, 2) . "' and a.str_unicode > '30000' and a.str_unicode < '40000'
						and c.str_idxnum='" . $arr_Auth[3] . "'
						and a.str_service='Y' order by a.str_menutype asc, a.int_chosort asc, a.str_chocode asc, a.int_unisort, a.str_unicode asc";

		$DbRecIdx = mysql_query($str_query);
		$rcd_cnt = mysql_num_rows($DbRecIdx);

		if ($rcd_cnt) {
			$str_menu = mysql_result($DbRecIdx, 0, str_chocode) . mysql_result($DbRecIdx, 0, str_unicode);
		} else {
			$str_menu = "0000000";
		}
	}

	$str_query = "select str_menupath from ";
	$str_query .= $Tname;
	$str_query .=  "comm_menu_idx
			where str_menutype='01'
				and str_chocode='" . substr($str_menu, 0, 2) . "'
				and str_unicode='" . substr($str_menu, 2, 5) . "'";

	$DbRecIdx = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($DbRecIdx);

	if ($rcd_cnt) {
		return Fnc_Om_Conv_Default(mysql_result($DbRecIdx, 0, str_menupath), "/admincenter/comm/comm_blank.php");
	} else {
		return "/admincenter/comm/comm_blank.php";
	}
}

function Fnc_Om_Set_Code($str_gubun, $str_menu)
{

	session_start();
	global $Tname;
	global $arr_Auth;

	for ($int_I = 0; $int_I <= 11; $int_I++) {
		if ($int_I != (int)$str_gubun) {
			$sTemp .= base64_encode($arr_Auth[$int_I]) . "~";
		} else {
			if (substr($str_menu, 2, 1) != "3") {

				$SQL_QUERY =	"select distinct(a.str_unicode),a.str_menutype,a.int_chosort
								,a.str_chocode,a.int_unisort,a.str_menupath,a.str_idxword,b.str_btmflag
							from ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_idx a, ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_con b, ";
				$SQL_QUERY .= $Tname;
				$SQL_QUERY .= "comm_menu_right c
							WHERE
								a.str_menutype=b.str_menutype and a.str_chocode=b.str_chocode
								and a.str_unicode=b.str_unicode and a.str_menutype=c.str_menutype
								and a.str_chocode=c.str_chocode and a.str_unicode=c.str_unicode and c.str_idxcode='01'
								and a.str_chocode='" . substr($str_menu, 0, 2) . "' and a.str_unicode > '30000' and a.str_unicode < '40000'
								and c.str_idxnum='" . $arr_Auth[3] . "'
								and a.str_service='Y' order by a.str_menutype asc, a.int_chosort asc, a.str_chocode asc, a.int_unisort, a.str_unicode asc";

				$DbRecIdx = mysql_query($SQL_QUERY);
				$tot = mysql_num_rows($DbRecIdx);

				if ($tot) {
					$str_menu = mysql_result($DbRecIdx, 0, str_chocode) . mysql_result($DbRecIdx, 0, str_unicode);
				}
			}
			$sTemp .= base64_encode($str_menu) . "~";
		}
	}
	//setcookie("COK_USER_INFO_DATA",$sTemp,0,"/");
	$_SESSION['COK_USER_INFO_DATA'] = $sTemp;
}


function Fnc_Om_Cate_Name($str)
{

	global $Tname;

	$str_query = "select Full_Name from ";
	$str_query .= $Tname;
	$str_query .=  "comm_menu_idx
			where str_menutype='" . substr($str, 0, 2) . "'
				and str_chocode='" . substr($str, 2, 2) . "'
				and str_unicode='" . substr($str, 4, 5) . "'";

	$DbRecIdx = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($DbRecIdx);

	if ($rcd_cnt) {
		//return mysql_result($DbRecIdx,0,str_idxword);
		return str_replace("|", "  > ", substr(mysql_result($DbRecIdx, 0, Full_Name), 0, strlen(mysql_result($DbRecIdx, 0, Full_Name)) - 1));
		//return substr(mysql_result($DbRecIdx,0,Full_Name),0,strlen(mysql_result($DbRecIdx,0,Full_Name)) - 1);
	} else {
		return "";
	}
}

function Fnc_Om_Loc_Name($str)
{

	global $Tname;

	$str_query = "select str_idxword from ";
	$str_query .= $Tname;
	$str_query .=  "comm_menu_idx
			where str_menutype='" . substr($str, 0, 2) . "'
				and str_chocode='" . substr($str, 2, 2) . "'
				and str_unicode='" . substr($str, 4, 5) . "'";

	$DbRecIdx = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($DbRecIdx);

	if ($rcd_cnt) {
		return mysql_result($DbRecIdx, 0, str_idxword);
	} else {
		return "";
	}
}

function Fnc_Om_Stamp($str_userid)
{

	global $Tname;

	$str_query = "select ifnull(sum(int_stamp), 0) as int_stamp from ";
	$str_query .= $Tname;
	$str_query .=  "comm_member_stamp
			where
				str_userid='$str_userid' ";

	$DbRecIdx = mysql_query($str_query);
	$rcd_cnt = mysql_num_rows($DbRecIdx);

	if ($rcd_cnt) {
		return mysql_result($DbRecIdx, 0, int_stamp);
	} else {
		return 0;
	}
}

function Fnc_Om_Stamp_In($str_userid, $str_gubun, $int_stamp, $str_cont)
{

	global $Tname;

	$SQL_QUERY = "select ifnull(max(a.int_number),0)+1 as lastnumber from ";
	$SQL_QUERY .= $Tname;
	$SQL_QUERY .= "comm_member_stamp a ";

	$arr_max_Data = mysql_query($SQL_QUERY);
	$lastnumber = mysql_result($arr_max_Data, 0, lastnumber);

	$SQL_QUERY = "INSERT INTO " . $Tname . "comm_member_stamp(";
	$SQL_QUERY .= "INT_NUMBER,STR_USERiD,STR_GUBUN,INT_STAMP,STR_CONT,DTM_INDATE
										) VALUES (
											'$lastnumber','$str_userid','$str_gubun','" . $int_stamp . "','" . $str_cont . "','" . date("Y-m-d H:i:s") . "'
										)";

	mysql_query($SQL_QUERY);
}

function Fnc_Om_File_Save($str_Image1, $str_Image1_name, $str_dimage1, $s_pto_width1, $s_pto_height1, $str_del_img1, $str_Add_Tag)
{
	$str_Image1_name = getRandomFileName($str_Image1_name);
	$Gob_F = 1;

	if ($str_del_img1 == "Y") {

		if (file_exists($str_Add_Tag . $str_dimage1)) {
			unlink($str_Add_Tag . $str_dimage1);
		}
		$str_dimage1 = "";
		$s_pto_width1 = "";
		$s_pto_height1 = "";
	} else {
		if ($str_Image1) {
			if (strcmp($str_Image1, "none")) {
				if (Fnc_Om_File_Exp($str_Image1_name)) {

					$imsi_img = $str_dimage1;
					$str_dimage1 = Fnc_Om_File_Fexist($str_Image1_name, $str_Add_Tag);

					if (!copy($str_Image1, $str_Add_Tag . iconv("UTF-8", "EUC-KR", $str_dimage1))) {
						echo "UPLOAD_COPY_FAILURE";
						exit;
					}

					$img_ary = getimagesize($str_Add_Tag . iconv("UTF-8", "EUC-KR", $str_dimage1));
					$s_pto_width1 = $img_ary[0];
					$s_pto_height1 = $img_ary[1];
					$s_pto_type1 = $img_ary[2];
					$s_pto_mime1 = $img_ary[mime];

					if (!unlink($str_Image1)) {
						echo "임시파일을 삭제하는데 실패했습니다.";
						exit;
					}
					if ($imsi_img != "") {
						Fnc_Om_File_Delete($str_Add_Tag, $imsi_img);
					}
				} else {
					echo "
					   <script>
					   		window.alert('선택한 파일은 업로드가 금지되어 있습니다.');
					   		//history.back()
					   </script>";
					$Gob_F = 0;
					//exit;
				}
			}
		}
	}
	$arr_File = array($Gob_F, array($str_dimage1, $s_pto_width1, $s_pto_height1, $s_pto_type1, $s_pto_mime1));

	return $arr_File;
}

function toString($text)
{
	return iconv('UTF-16LE', 'UHC', chr(hexdec(substr($text[1], 2, 2))) . chr(hexdec(substr($text[1], 0, 2))));
}

function toUnicode($word)
{
	$word = iconv('UHC', 'UTF-16LE', $word);
	return strtoupper(dechex(ord(substr($word, 1, 1))) . dechex(ord(substr($word, 0, 1))));
}

function unescape($text)
{
	return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'toString', $text));
}

function js_escape($str, $chr_set = 'utf-8')
{
	$arr_dec = unpack("n*", iconv($chr_set, "UTF-16BE", $str));
	$callback_function = create_function('$dec', 'if(in_array($dec, array(42, 43, 45, 46, 47, 64, 95))) return chr($dec); elseif($dec >= 127) return "%u".strtoupper(dechex($dec)); else return rawurlencode(chr($dec));');
	$arr_hexcode = array_map($callback_function, $arr_dec);
	return implode($arr_hexcode);
}

function escape($str)
{
	$len = strlen($str);
	for ($i = 0, $s = ''; $i < $len; $i++) {
		$ck = substr($str, $i, 1);
		$ascii = ord($ck);
		if ($ascii > 127) $s .= '%u' . toUnicode(substr($str, $i++, 2));
		else $s .= (in_array($ascii, array(42, 43, 45, 46, 47, 64, 95))) ? $ck : '%' . strtoupper(dechex($ascii));
	}
	return $s;
}

function right($value, $count)
{
	$value = substr($value, (strlen($value) - $count), strlen($value));
	return $value;
}

function left($string, $count)
{
	return substr($string, 0, $count);
}

function Fnc_Om_Dir_Delete($path)
{

	if (is_dir($path)) {

		$directory = dir($path);
		while ($entry = $directory->read()) {
			if ($entry != "." && $entry != "..") {
				if (Is_Dir($path . "/" . $entry)) {
					Fnc_Om_Dir_Delete($path . "/" . $entry);
				} else {
					@UnLink($path . "/" . $entry);
				}
			}
		}
		$directory->close();
		@RmDir($path);
	}
}

function download_file($file_name, $file_micro, $file_dir, $file_type)
{
	if (!$file_name || !$file_micro || !$file_dir) return 1;
	if (eregi("\\\\|\.\.|/", $file_micro)) return 2;
	if (file_exists($file_dir . $file_micro)) {
		$fp = fopen($file_dir . $file_micro, "r");


		if (eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) {
			Header("Content-type:application/octet-stream");
			Header("Content-Length:" . filesize($file_dir . $file_micro));
			Header("Content-Disposition:attachment;filename=$file_name");
			Header("Content-Transfer-Encoding:binary");
			Header("Pragma:no-cache");
			Header("Expires:0");
			Header("Cache-control:private");
		} else {
			Header("Content-type:file/unknown");
			Header("Content-Length:" . filesize($file_dir . $file_micro));
			Header("Content-Disposition:attachment;filename=$file_micro");
			Header("Content-Description:PHP3 Generated Data");
			Header("Pragma:no-cache");
			Header("Expires:0");
			Header("Cache-control:private");
		}

		fpassthru($fp);
		fclose($fp);
	} else return 1;
}
function Fnc_Om_Move_Link($Url, $Target, $Alert)
{
	echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
	echo "<script>";
	if ($Alert) echo "alert('" . $Alert . "          ');";
	if ($Url) echo $Target . "location.href='" . $Url . "';";
	echo "</script>";
	exit;
}
function Fnc_Preloading()
{

	echo "<div ID='lbl_Preload' style='position:absolute; left:0; top:0; overflow:hidden; border:0px; z-index:1; width:100%;'>\n";
	echo "    <table width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
	echo "        <tr>\n";
	echo "            <td height='100'>&nbsp;</td>\n";
	echo "        </tr>\n";
	echo "        <tr>\n";
	echo "            <td width='100%' align='center'><img src='/pub/img/etc/loa.gif' border=0></td>\n";
	echo "        </tr>\n";
	echo "    </table>\n";
	echo "</div>\n";


	echo "<SCRIPT LANGUAGE='JavaScript'>\n";
	echo "window.onload = function(){fnStartInit();}\n";
	echo "    function fnStartInit(){\n";
	echo "            if (document.getElementById('lbl_Preload')) {\n";
	echo "                document.getElementById('lbl_Preload').style.visibility = 'hidden';\n";
	echo "        }\n";
	echo "    }\n";
	echo "</SCRIPT>";
}
function Fnc_Acc_Admin()
{
	global $arr_Auth;

	if ($arr_Auth[3] == "00" || $arr_Auth[3] == "") {
		echo "<script language='javascript'>alert('접근권한이 없습니다.');window.location.href='/admincenter/logi/logi_login.php';</script>";
		exit;
	}
}

//	function Fnc_Om_Sendmail($subject, $body, $from, $to, $type = 'text/html') {
//		//$smtp_id = "mailuser";
//		//$smtp_pwd = "apdlfdyd!@#$";
//		//$host = "210.109.5.189";

//		$smtp_id = "tt";
//		$smtp_pwd = "tt";
//		$host = "mail.tt.co.kr";

//		$subject = iconv("UTF-8","EUC-KR",$subject) ? iconv("UTF-8","EUC-KR",$subject) : $subject;
//		$body = iconv("UTF-8","EUC-KR",$body) ? iconv("UTF-8","EUC-KR",$body) : $subject;

//		$fp = fsockopen($host, 25, &$errno, &$errstr, 10);
//		if(!$fp) {
//			exit('메일오류 ['.$errno.'] '.$errstr);
//		}
//		fgets($fp, 128);
//		fputs($fp, "helo $host\r\n");
//		fgets($fp, 128);

// 로긴
//		fputs($fp, "auth login\r\n");
//		fgets($fp,128);
//		fputs($fp, base64_encode($smtp_id)."\r\n");
//		fgets($fp,128);
//		fputs($fp, base64_encode($smtp_pwd)."\r\n");
//		fgets($fp,128);

//		fputs($fp, "mail from: <$from>\r\n");
//		$returnvalue[0] = fgets($fp, 128);
//		fputs($fp, "rcpt to: <$to>\r\n");
//		$returnvalue[1] = fgets($fp, 128);
//		fputs($fp, "data\r\n");
//		fgets($fp, 128);
//		fputs($fp, "Return-Path: $from\r\n");
//		fputs($fp, "From: \"$from\" <$from>\r\n");
//		fputs($fp, "To: <$to>\r\n");
//		fputs($fp, "Subject: $subject\r\n");
//		fputs($fp, "Content-Type: ".$type."; charset=\"euc-kr\"\r\n");
//		fputs($fp, "\r\n");

//$body = chunk_split(base64_encode($body));
//		fputs($fp, $body);
//		fputs($fp, "\r\n");
//		fputs($fp, "\r\n.\r\n");
//		$returnvalue[2] = fgets($fp, 128);
//		fclose($fp);
//		//print_r($returnvalue);
//		if (preg_match("/^250/", $returnvalue[0])&&preg_match("/^250/", $returnvalue[1])&&preg_match("/^250/", $returnvalue[2])) {
//			return true;
//		}
//		else {
//			return false;
//		}
//	}

function Fnc_Om_Sendmail($subject, $body, $from, $to, $type = 'text/html')
{

	//$subject=mb_convert_encoding($subject,"EUC-KR","UTF-8");
	//		$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
	//		$header = "From: $sender <$from>\r\n";
	//		$header .= "Reply-to: $from\r\n";
	//		$header .= "Content-Type: text/html;charset=utf-8\r\n";
	//		$header .= "MIME-Version: 1.0\r\n";


	//		$Headers = "from: =?utf-8?B?".base64_encode($from_name)."?= <$from>n"; 
	$Headers = "From: $sender <$from>\r\n";
	//		$Headers .= "Content-Type: text/html;"; 
	$Headers .= "Content-Type: text/html;charset=utf-8\r\n";
	$Headers .= "MIME-Version: 1.0\r\n";

	$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

	return mail($to, $subject, $body, $Headers);
}

function Fnc_Om_Mail($subject, $body, $from, $to)
{

	$Headers = "from: =?utf-8?B?" . base64_encode($from_name) . "?= <$from>n"; // from 과 : 은 붙여주세요 => from: 
	$Headers .= "Content-Type: text/html;";

	#$subject = \'=?UTF-8?B?\'.base64_encode("?! ??메일 예제 - mail").\'?=\'; 
	$subject = '=?UTF-8?B?' . base64_encode("mail send check") . '?=';
	mail($to, $subject, $body, $Headers);
}

function error($msg)
{
	echo $msg;
	exit;
}

##############################15###############################
###
# 랜덤 문자열 유일키 발생(상품코드로 사용) / 총 50자인데.. 필요한 만큼만 자르자.
###############################################################
#
function getCode($len)
{
	$SID = md5(uniqid(rand()));
	$code = substr($SID, 0, $len);
	return $code;
}
###############################################################
#
# 세션키 생성 주문번호로 가장 괜찮을거 같아 만들었음
###############################################################
#
function getSession()
{
	$SID = microtime();
	$str = str_replace("-", "", date("ymdHis", mktime()));
	$session = $str . substr($SID, 4, 3);
	return $session;
}


function load_file($filepath)
{
	$data = implode("", file($filepath));

	return $data;
}

function fnc_Login_Chk()
{

	global $arr_Auth;
	$str_Url = urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]);

	if ($arr_Auth[0] == "") { ?>
		<script language="javascript">
			document.location.href = "/memberjoin/login.php?loc=<?= $str_Url ?>";
		</script>
	<? }
}

function fnc_MLogin_Chk()
{

	global $arr_Auth;
	$str_Url = urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]);

	if ($arr_Auth[0] == "") { ?>
		<script language="javascript">
			document.location.href = "/m/memberjoin/login.php?loc=<?= $str_Url ?>";
		</script>
	<? }
}

function fnc_Login2_Chk()
{

	global $arr_Auth;
	$str_Url = urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]);

	if ($arr_Auth[0] == "") { ?>
		<script language="javascript">
			document.location.href = "/member/login.php?loc=<?= $str_Url ?>";
		</script>
		<? } else {
		if ($arr_Auth[8] > 6) {	?>
			<script language="javascript">
				alert("접근권한이 없습니다.");
				document.location.href = "/main/main.php";
			</script>
		<?
			exit;
		}
	}
}
function fnc_Login3_Chk()
{

	global $arr_Auth;
	$str_Url = urlencode($_SERVER["SCRIPT_NAME"] . "?" . $_SERVER["QUERY_STRING"]);

	if ($arr_Auth[0] == "") { ?>
		<script language="javascript">
			document.location.href = "/login/login.php?loc=<?= $str_Url ?>";
		</script>
		<? } else {
		if ($arr_Auth[1] < 3) {	?>
			<script language="javascript">
				alert("VIP 회원만 이용하실 수 있습니다.\n1:1멘토링서비스를 신청하시면 관리자가\n확인 후 등급변경 해 드리겠습니다.");
				document.location.href = "/index.php";
			</script>
	<?
			exit;
		}
	}
}

function fnc_mapinfo($real_address)
{

	$map_key = "b7757fe2171bfd6816a6b3e04d7f58b3";  // 네이버 지도api 키값
	$map_query = str_replace(" ", "", $real_address); // 공백을 제거

	// 지도의 축적 1~11 사이의 자연수. 1에 가까울 수록 지도가 확대
	$map_zoom = 2;

	// euc-kr로 변환 
	$map_cquery = iconv("utf-8", "euc-kr", "$map_query");

	// 여기부터 주소 검색 xml 파싱
	$pquery = "key=" . $map_key . "&query=" . $map_query;
	$fp = fsockopen("maps.naver.com", 80, $errno, $errstr, 30);
	if (!$fp) {
		echo "$errstr ($errno)";
	} else {
		fputs($fp, "GET /api/geocode.php?");
		fputs($fp, $pquery);
		fputs($fp, " HTTP/1.1\r\n");
		fputs($fp, "Host: maps.naver.com\r\n");
		fputs($fp, "Connection: Close\r\n\r\n");

		$header = "";
		while (!feof($fp)) {
			$out = fgets($fp, 512);
			if (trim($out) == "") {
				break;
			}
			$header .= $out;
		}

		$mapbody = "";
		while (!feof($fp)) {
			$out = fgets($fp, 512);
			$mapbody .= $out;
		}

		$idx = strpos(strtolower($header), "transfer-encoding: chunked");

		if ($idx > -1) { // chunk data 
			$temp = "";
			$offset = 0;
			do {
				$idx1 = strpos($mapbody, "\r\n", $offset);
				$chunkLength = hexdec(substr($mapbody, $offset, $idx1 - $offset));

				if ($chunkLength == 0) {
					break;
				} else {
					$temp .= substr($mapbody, $idx1 + 2, $chunkLength);
					$offset = $idx1 + $chunkLength + 4;
				}
			} while (true);
			$mapbody = $temp;
		}
		//header("Content-Type: text/xml; charset=utf-8"); 
		fclose($fp);
	}
	// 여기까지 주소 검색 xml 파싱


	// 여기부터 좌표값 변수에 등록
	$map_x_point_1 = explode("<x>", $mapbody);
	$map_x_point_2 = explode("</x>", $map_x_point_1[1]);
	$map_x_point = $map_x_point_2[0];

	$map_y_point_1 = explode("<y>", $mapbody);
	$map_y_point_2 = explode("</y>", $map_y_point_1[1]);
	$map_y_point = $map_y_point_2[0];
	// 여기까지 좌표값 변수에 등록

	$arr_File = array($map_x_point, $map_y_point);
	return $arr_File;
}



function fnc_cal1($str_date)
{

	global $count;
	global $Tname;
	global $sgbn;

	$Sql_Query = "SELECT str_time FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_service='Y' group by str_time order by str_time asc ";
	$arr_Data = mysql_query($Sql_Query);
	$arr_Data_Cnt = mysql_num_rows($arr_Data);
	?>

	<? if ($arr_Data_Cnt) { ?>
		<dl>
			<?
			for ($int_K = 0; $int_K < $arr_Data_Cnt; $int_K++) {

				$Sql_Query = "SELECT * FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_time='" . mysql_result($arr_Data, $int_K, str_time) . "' and str_service='Y' order by str_time asc ";
				$arr_Data2 = mysql_query($Sql_Query);
				$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
			?>
				<dt><?= mysql_result($arr_Data, $int_K, str_time) ?></dt>
				<?
				for ($int_J = 0; $int_J < $arr_Data2_Cnt; $int_J++) {
				?>
					<dd><a href="/today/view.php?sgbn=<?= $sgbn ?>&year=<?= substr(mysql_result($arr_Data2, $int_J, str_date), 0, 4) ?>&month=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 5, 2) ?>&day=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 8, 2) ?>&str_no=<?= mysql_result($arr_Data2, $int_J, int_number) ?>"><?= stripslashes(mysql_result($arr_Data2, $int_J, str_title)) ?></a></dd>
			<?
					$count++;
				}
			}

			?>
		</dl>
	<? } ?>
<?

}
function fnc_cal3($str_date)
{

	global $count;
	global $Tname;
	global $sgbn;
	global $vgbn;
	global $arr_Auth;

	$Sql_Query = "SELECT str_time FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' ";
	if ($vgbn == "1") {
		$Sql_Query .= " and (str_service='Y' or str_inuserid='" . $arr_Auth[0] . "') ";
	} else {
		$Sql_Query .= " and str_inuserid='" . $arr_Auth[0] . "' ";
	}
	$Sql_Query .= " group by str_time order by str_time asc ";

	$arr_Data = mysql_query($Sql_Query);
	$arr_Data_Cnt = mysql_num_rows($arr_Data);
?>

	<? if ($arr_Data_Cnt) { ?>
		<dl>
			<?
			for ($int_K = 0; $int_K < $arr_Data_Cnt; $int_K++) {

				$Sql_Query = "SELECT * FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_time='" . mysql_result($arr_Data, $int_K, str_time) . "' ";
				if ($vgbn == "1") {
					$Sql_Query .= " and (str_service='Y' or str_inuserid='" . $arr_Auth[0] . "') ";
				} else {
					$Sql_Query .= " and str_inuserid='" . $arr_Auth[0] . "' ";
				}
				$Sql_Query .= " order by str_time asc ";
				$arr_Data2 = mysql_query($Sql_Query);
				$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
			?>
				<dt><?= mysql_result($arr_Data, $int_K, str_time) ?></dt>
				<?
				for ($int_J = 0; $int_J < $arr_Data2_Cnt; $int_J++) {
				?>
					<dd>
						<? if ($arr_Auth[0] == mysql_result($arr_Data2, $int_J, str_inuserid)) { ?>
							<input type="checkbox" name="chkItem1[]" id="chkItem1" value="<?= mysql_result($arr_Data2, $int_J, int_number) ?>" />
						<? } ?>
						<a href="/mypage/myschedule_view.php?sgbn=<?= $sgbn ?>&vgbn=<?= $vgbn ?>&year=<?= substr(mysql_result($arr_Data2, $int_J, str_date), 0, 4) ?>&month=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 5, 2) ?>&day=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 8, 2) ?>&str_no=<?= mysql_result($arr_Data2, $int_J, int_number) ?>"><?= stripslashes(mysql_result($arr_Data2, $int_J, str_title)) ?></a>
						<? if ($arr_Auth[0] == mysql_result($arr_Data2, $int_J, str_inuserid)) { ?>
							<?
							switch (mysql_result($arr_Data2, $int_J, str_service)) {
								case  "A":
							?>
									<? if ($sgbn == "1") { ?>
										<span class="control_btn">
										<? } ?>
										<a href="#;" class="btn btn_ctl01">접수</a>
										<? if ($sgbn == "1") { ?>
										</span>
									<? } ?>
								<?
									break;
								case  "Y":
								?>
									<? if ($sgbn == "1") { ?>
										<span class="control_btn">
										<? } ?>
										<a href="#;" class="btn btn_ctl02">출력</a>
										<? if ($sgbn == "1") { ?>
										</span>
									<? } ?>
								<?
									break;
								case  "N":
								?>
									<? if ($sgbn == "1") { ?>
										<span class="control_btn">
										<? } ?>
										<a href="#;" class="btn btn_ctl01">미출력</a>
										<? if ($sgbn == "1") { ?>
										</span>
									<? } ?>
							<?
									break;
							}
							$count++;
							?>
						<? } ?>
					</dd>
			<?
				}
			}

			?>
		</dl>
	<? } ?>
<?

}
function fnc_cal4($str_date, $Txt_key, $Txt_word)
{

	global $count;
	global $Tname;
	global $sgbn;

	if ($Txt_word != "") {
		switch ($Txt_key) {
			case  "0":
				$Str_Query = " and (str_title like '%$Txt_word%' or str_contents like '%$Txt_word%') ";
				break;
			case  "1":
				$Str_Query = " and str_title like '%$Txt_word%' ";
				break;
			case  "2":
				$Str_Query = " and str_contents like '%$Txt_word%' ";
				break;
		}
	}

	$Sql_Query = "SELECT str_time FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_service='Y' ";
	$Sql_Query .= $Str_Query;
	$Sql_Query .= " group by str_time order by str_time asc ";
	$arr_Data = mysql_query($Sql_Query);
	$arr_Data_Cnt = mysql_num_rows($arr_Data);
?>

	<? if ($arr_Data_Cnt) { ?>
		<dl>
			<?
			for ($int_K = 0; $int_K < $arr_Data_Cnt; $int_K++) {

				$Sql_Query = "SELECT * FROM " . $Tname . "comm_sche WHERE date_format(str_date, '%Y-%m-%d') = '$str_date' and str_time='" . mysql_result($arr_Data, $int_K, str_time) . "' and str_service='Y' ";
				$Sql_Query .= $Str_Query;
				$Sql_Query .= " order by str_time asc ";
				$arr_Data2 = mysql_query($Sql_Query);
				$arr_Data2_Cnt = mysql_num_rows($arr_Data2);
			?>
				<dt><?= mysql_result($arr_Data, $int_K, str_time) ?></dt>
				<?
				for ($int_J = 0; $int_J < $arr_Data2_Cnt; $int_J++) {
				?>
					<dd><a href="/today/view.php?sgbn=<?= $sgbn ?>&year=<?= substr(mysql_result($arr_Data2, $int_J, str_date), 0, 4) ?>&month=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 5, 2) ?>&day=<?= (int)substr(mysql_result($arr_Data2, $int_J, str_date), 8, 2) ?>&str_no=<?= mysql_result($arr_Data2, $int_J, int_number) ?>"><?= stripslashes(mysql_result($arr_Data2, $int_J, str_title)) ?></a></dd>
			<?
					$count++;
				}
			}

			?>
		</dl>
	<? } ?>
<?

}
$yoil = array("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT");

function SendMesg($url)
{
	$fp = fsockopen("211.233.20.184", 80, $errno, $errstr, 10);
	if (!$fp) echo "$errno : $errstr";

	fwrite($fp, "GET $url HTTP/1.0\r\nHost: 211.233.20.184\r\n\r\n");
	$flag = 0;

	while (!feof($fp)) {
		$row = fgets($fp, 1024);

		if ($flag) $out .= $row;
		if ($row == "\r\n") $flag = 1;
	}
	fclose($fp);
	return $out;
}

function fnc_sms_Send($str_shp, $str_rhp, $str_msg)
{


	$userid = "garosu5254";
	$passwd = "rkfhtn1234";
	$hpSender = str_replace("-", "", $str_shp);         // 보내는분 핸드폰번호
	$hpReceiver = str_replace("-", "", $str_rhp);        // 받는분의 핸드폰번호
	$adminPhone = str_replace("-", "", $str_shp);       // 비상시 메시지를 받으실 관리자 핸드폰번호
	$hpMesg = $str_msg;           // 메시지
	/*  UTF-8 글자셋 이용으로 한글이 깨지는 경우에만 주석을 푸세요. */
	$hpMesg = iconv("UTF-8", "EUC-KR", "$hpMesg");
	/*  ---------------------------------------- */
	$hpMesg = urlencode($hpMesg);
	$endAlert = 0;  // 전송완료알림창 ( 1:띄움, 0:안띄움 )


	// 한줄로 이어쓰기 하세요.
	SendMesg("/MSG/send/web_admin_send.htm?userid=$userid&passwd=$passwd&sender=$hpSender&receiver=$hpReceiver&encode=1&end_alert=$endAlert&message=$hpMesg");
}

function fnc_Sms_Ram()
{

	$url = "http://www.winc7788.co.kr/MSG/send/web_admin_send.htm?call_type=1&userid=garosu5254&passwd=rkfhtn1234";
	$result = SendMesg($url);

	$sTemp = explode("|", $result);

	return "잔액 : " . number_format($sTemp[0]) . "원";
}

function fnc_pay_info()
{

	global $Tname;
	global $arr_Auth;

	$Sql_Query =	" SELECT 
						B.*
					FROM 
						`" . $Tname . "comm_member_pay` AS A
					INNER JOIN
						`" . $Tname . "comm_member_pay_info` AS B
					ON
						A.INT_NUMBER=B.INT_NUMBER
						AND date_format(B.STR_SDATE, '%Y-%m-%d') <= '" . date("Y-m-d") . "'
						AND date_format(B.STR_EDATE, '%Y-%m-%d') >= '" . date("Y-m-d") . "' 
						AND A.STR_USERID='$arr_Auth[0]' ";

	$arr_To_Data = mysql_query($Sql_Query);
	$arr_To_Data_Cnt = mysql_num_rows($arr_To_Data);

	return $arr_To_Data_Cnt;
}

function fnc_sub_member_info()
{
	global $Tname;
	global $arr_Auth;

	$Sql_Query =    'SELECT 
						A.*
					FROM 
						`' . $Tname . 'comm_membership` A
					WHERE 
						A.STR_USERID = "' . $arr_Auth[0] . '"
						AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
						AND A.INT_TYPE = 1
						AND A.STR_PASS = "0"';

	$arr_To_Data = mysql_query($Sql_Query);
	$arr_To_Data_Cnt = mysql_num_rows($arr_To_Data);

	return $arr_To_Data_Cnt;
}

function fnc_ren_member_info()
{
	global $Tname;
	global $arr_Auth;

	$Sql_Query =    'SELECT 
						A.*
					FROM 
						`' . $Tname . 'comm_membership` A
					WHERE 
						A.STR_USERID = "' . $arr_Auth[0] . '"
						AND NOW() BETWEEN A.DTM_SDATE AND A.DTM_EDATE
						AND A.INT_TYPE = 2
						AND A.STR_PASS = "0"';

	$arr_To_Data = mysql_query($Sql_Query);
	$arr_To_Data_Cnt = mysql_num_rows($arr_To_Data);

	return $arr_To_Data_Cnt;
}

function fnc_cart_info($str_goodcode)
{

	global $Tname;

	$Sql_Query = "select a.str_sgoodcode from " . $Tname . "comm_goods_master_sub a where a.str_goodcode='$str_goodcode' and a.str_service='Y' and a.str_sgoodcode not in (select b.str_sgoodcode from " . $Tname . "comm_goods_cart b where b.str_goodcode='$str_goodcode' and not(b.int_state='0' or b.int_state='10' or b.int_state='11')) ";

	$arr_To_Data = mysql_query($Sql_Query);
	$arr_To_Data_Cnt = mysql_num_rows($arr_To_Data);

	return $arr_To_Data_Cnt;
}

function fnc_buy_info()
{

	global $Tname;
	global $arr_Auth;

	$Sql_Query = "select a.str_sgoodcode from " . $Tname . "comm_goods_cart a where a.str_userid='$arr_Auth[0]' and not(a.int_state='0' or a.int_state='10' or a.int_state='11') ";

	$arr_To_Data = mysql_query($Sql_Query);
	$arr_To_Data_Cnt = mysql_num_rows($arr_To_Data);

	return $arr_To_Data_Cnt;
}

function dateDiff($date1, $date2)
{
	$_date1 = explode("-", $date1);
	$_date2 = explode("-", $date2);

	$tm1 = mktime(0, 0, 0, $_date1[1], $_date1[2], $_date1[0]);
	$tm2 = mktime(0, 0, 0, $_date2[1], $_date2[2], $_date2[0]);

	return ($tm1 - $tm2) / 86400;
}

function Fun_Goods_Cnt($str_goodcode)
{

	global $Tname;

	if ($str_goodcode != "") {

		$SQL_QUERY = "DELETE FROM " . $Tname . "comm_goods_view WHERE date_format(dtm_indate, '%Y-%m-%d') < '" . date("Y-m-d", strtotime($day . "-2day")) . "' ";
		mysql_query($SQL_QUERY);


		$SQL_QUERY = "select * from " . $Tname . "comm_goods_view where str_goodcode='" . $str_goodcode . "' and str_session = '" . $_COOKIE['str_vsession'] . "'  ";
		$arr_Data2 = mysql_query($SQL_QUERY);
		$arr_Data2_Cnt = mysql_num_rows($arr_Data2);

		if (!$arr_Data2_Cnt) {
			$SQL_QUERY = "INSERT INTO " . $Tname . "comm_goods_view (str_session,str_goodcode,dtm_indate) values('" . $_COOKIE['str_vsession'] . "', '" . $str_goodcode . "','" . date("Y-m-d H:i:s") . "') ";
			mysql_query($SQL_QUERY);
		}
	}
}
function fnc_card_kind($str_card)
{

	switch ($str_card) {
		case  "CCKM":
			echo "국민카드";
			break;
		case  "CCNH":
			echo "NH농협카드";
			break;
		case  "CCSG":
			echo "신세계한미";
			break;
		case  "CCCT":
			echo "씨티카드";
			break;
		case  "CCHM":
			echo "한미카드";
			break;
		case  "CVSF":
			echo "해외비자";
			break;
		case  "CCAM":
			echo "롯데아멕스카드";
			break;
		case  "CCLO":
			echo "롯데카드";
			break;
		case  "CCBC":
			echo "BC카드";
			break;
		case  "CCBC":
			echo "우리카드";
			break;
		case  "CCHN":
			echo "하나SK카드";
			break;
		case  "CCSS":
			echo "삼성카드";
			break;
		case  "CCKJ":
			echo "광주카드";
			break;
		case  "CCSU":
			echo "수협카드";
			break;
		case  "CCBC":
			echo "신협카드";
			break;
		case  "CCJB":
			echo "전북카드";
			break;
		case  "CCCJ":
			echo "제주카드";
			break;
		case  "CCLG":
			echo "신한카드";
			break;
		case  "CMCF":
			echo "해외마스터";
			break;
		case  "CJCF":
			echo "해외JCB";
			break;
		case  "CCKE":
			echo "외환카드";
			break;
		case  "CCBC":
			echo "현대증권카드";
			break;
		case  "CCDI":
			echo "현대카드";
			break;
		case  "CCBC":
			echo "저축카드";
			break;
		case  "CCBC":
			echo "산업카드";
			break;
		case  "CCUF":
			echo "은련카드";
			break;
	}
}

function rtn_mobile_chk()
{
	// 모바일 기종(배열 순서 중요, 대소문자 구분 안함)
	$ary_m = array("iPhone", "iPod", "IPad", "Android", "Blackberry", "SymbianOS|SCH-M\d+", "Opera Mini", "Windows CE", "Nokia", "Sony", "Samsung", "LGTelecom", "SKT", "Mobile", "Phone");

	for ($i = 0; $i < count($ary_m); $i++) {
		if (preg_match("/$ary_m[$i]/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
			return $ary_m[$i];
			break;
		}
	}

	return "PC";
}

function getRandomFileName($fileName)
{
	if ($fileName) {
		$timestamp = time();
		$randomFileName = $timestamp . '_' . mt_rand(); // Combining timestamp and a random number
		$extension = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension from the original file name
		return $randomFileName . '.' . $extension; // Combine the random file name and extension
	} else {
		return '';
	}
}

function getSpentMoney($str_userid)
{
	global $Tname;

	// 상품구매 1년 총결제액
	$Sql_Query =    'SELECT 
                        IFNULL(SUM(A.INT_PRICE), 0) AS SUM_MONEY
                    FROM 
                        `' . $Tname . 'comm_good_pay` AS A
                    WHERE
						A.DTM_INDATE >= "' . date("Y-m-d H:i:s", strtotime("-1 year")) . '"
						AND A.DTM_INDATE <= "' . date("Y-m-d H:i:s") . '"
						AND A.STR_REFUND = "N"
                        AND A.STR_USERID="' . $str_userid . '"';

	$arr_To_Data = mysql_query($Sql_Query);
	$good_money_Data = mysql_fetch_assoc($arr_To_Data);
	
	// 멤버십구매 1년 총결제액
	$Sql_Query =    'SELECT 
                        IFNULL(SUM(A.INT_SPRICE), 0) AS SUM_MONEY
                    FROM 
                        `' . $Tname . 'comm_member_pay_info` AS A
					LEFT JOIN
						`' . $Tname . 'comm_member_pay` AS B
					ON
						A.INT_NUMBER = B.INT_NUMBER
                    WHERE
						A.DTM_INDATE >= "' . date("Y-m-d H:i:s", strtotime("-1 year")) . '"
						AND A.DTM_INDATE <= "' . date("Y-m-d H:i:s") . '"
                        AND B.STR_USERID="' . $str_userid . '"';

	$arr_To_Data = mysql_query($Sql_Query);
	$membership_money_Data = mysql_fetch_assoc($arr_To_Data);

	return ($good_money_Data['SUM_MONEY'] ?: 0) + ($membership_money_Data['SUM_MONEY'] ?: 0);
}

function addBlackCoupons($str_userid)
{
	global $Tname;

	$Sql_Query = "UPDATE `" . $Tname . "comm_member` SET STR_GRADE='B', DTM_GRADEDATE='" . date("Y-m-d H:i:s") . "' WHERE STR_USERID='" . $str_userid . "'";
	mysql_query($Sql_Query);

	// VIP쿠폰
	$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_coupon` A WHERE INT_NUMBER=3';
	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

	$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $str_userid . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
	mysql_query($SQL_QUERY);

	// 빈티지전용 할인 쿠폰
	$SQL_QUERY = 'SELECT A.* FROM `' . $Tname . 'comm_coupon` A WHERE INT_NUMBER=5';
	$arr_Rlt_Data = mysql_query($SQL_QUERY);
	$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);

	$SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_coupon` (STR_USERID, INT_COUPON, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $str_userid . '", ' . $arr_Data['INT_NUMBER'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $arr_Data['INT_MONTHS'] . ' months')) . '") ';
	mysql_query($SQL_QUERY);
}
?>