<?
function Fnc_Output_Page_Num($p_Total, $p_Cur, $p_Out, $p_St, $p_Url)
{

	global $con_Ego_Cm_Fol;

	$str_Temp = "";
	$i = 0;

	if ($p_Cur > 1) {
		$str_Temp .= "<a href='$p_Url" . ($p_Cur - 1) . "' class='lnk0'>
						<img src='" . $con_Ego_Cm_Fol . "img/board/btn_prev.gif' border='0' align='absMiddle' alt='다음'></a>&nbsp;";
	}

	if ($p_Cur > 1) {
		$str_Temp .= "<a href='" . $p_Url . "1' class='lnk0'>[1]</a>...&nbsp;";
	}

	for ($i = $p_St; $i <= ($p_St + $p_Out) - 1; $i++) {

		if ($i > $p_Total) {
			break;
		} else {
			if ($i == $p_Cur) {
				$str_Temp .= " <font color='red'>[" . $i . "]</font> ";
			} else {
				$str_Temp .= " <a href='" . $p_Url . $i . "' class='lnk0'>[" . $i . "]</a> ";
			}
		}
	}

	if ($p_Cur < $p_Total) {
		$str_Temp .= "&nbsp;...<a href='" . $p_Url . $p_Total . "' class='lnk0'>[" . $p_Total . "]</a>";
	}

	if ($p_Total > $p_Cur) {
		$str_Temp .= "&nbsp;<a href='$p_Url" . ($p_Cur + 1) . "' class='lnk0'>
						<img src='" . $con_Ego_Cm_Fol . "img/board/btn_next.gif' border='0' align='absMiddle' alt='이전'></a>";
	}

	if ($p_Total == 0) {
		$str_Temp = "&nbsp;";
	}

	return $str_Temp;
}

function Fnc_Output_Page_Num1($p_Total, $p_Cur, $p_Out, $p_St, $p_Url)
{

	global $con_Ego_Cm_Fol;

	$str_Temp = "";
	$i = 0;

	$str_Temp .= "<a href='" . $p_Url . "1' class='img_b'><img src='/images/board/btn_page_first.gif' alt='' /></a> ";

	if ($p_Cur > 1) {
		$str_Temp .=	"<a href='" . $p_Url . ($p_Cur - 1) . "' class='img_b'><img src='/images/board/btn_page_prev.gif' alt='' /></a> ";
	} else {
		$str_Temp .= 	"<a href='#' class='img_b'><img src='/images/board/btn_page_prev.gif' alt='' /></a> ";
	}
	//$str_Temp .= "&nbsp;&nbsp;&nbsp;";


	for ($i = $p_St; $i <= ($p_St + $p_Out) - 1; $i++) {

		if ($i > $p_Total) {
			break;
		} else {


			if ($i == $p_Cur) {
				if ($i == $p_St) {
					$str_Temp .= "<a href='#' class='on'>" . $i . "</a>";
				} else {
					$str_Temp .= "<a href='#' class='on'>" . $i . "</a>";
				}
			} else {
				$str_Temp .= "<a href='" . $p_Url . $i . "'>" . $i . "</a>";
			}

			if (!(($i == $p_Total) || ($i == $p_Out))) {
				//$str_Temp .= "&nbsp;<img src='/kor/images/inc/paging/paging_line.jpg' width='1' height='9' />&nbsp;";
			}
		}
	}

	//$str_Temp .= "&nbsp;&nbsp;";

	$sPage = $i;

	if ($p_Total >= ($p_Cur + 1)) {
		$str_Temp .=	" <a href='" . $p_Url . ($p_Cur + 1) . "' class='img_b'><img src='/images/board/btn_page_next.gif' alt='' /></a> ";
	} else {
		$str_Temp .=	" <a href='#' class='img_b'><img src='/images/board/btn_page_next.gif' alt='' /></a> ";
	}


	$str_Temp .=	"<a href='" . $p_Url . $p_Total . "' class='img_b'><img src='/images/board/btn_page_last.gif' alt='' /></a>";

	if ($p_Total == 0) {
		$str_Temp = "&nbsp;";
	}

	return $str_Temp;
}

function Fnc_Output_Page_Num2($p_Total, $p_Cur, $p_Out, $p_St, $p_Url)
{

	global $con_Ego_Cm_Fol;

	$str_Temp = "";
	$i = 0;

	if ($p_Cur > 1) {
		$str_Temp .=	"<a href='" . $p_Url . ($p_Cur - 1) . "'><svg width='8' height='17' viewBox='0 0 8 17' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z' fill='black' /></svg></a> ";
	} else {
		$str_Temp .= 	"<a href='#'><svg width='8' height='17' viewBox='0 0 8 17' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z' fill='black' /></svg></a> ";
	}

	$str_Temp .= '<div class="pages">';

	for ($i = $p_St; $i <= ($p_St + $p_Out) - 1; $i++) {

		if ($i > $p_Total) {
			break;
		} else {


			if ($i == $p_Cur) {
				if ($i == $p_St) {
					$str_Temp .= "<a href='#' class='item actived'>" . $i . "</a>";
				} else {
					$str_Temp .= "<a href='#' class='item actived'>" . $i . "</a>";
				}
			} else {
				$str_Temp .= "<a href='" . $p_Url . $i . "' class='item'>" . $i . "</a>";
			}

			if (!(($i == $p_Total) || ($i == $p_Out))) {
				//$str_Temp .= "&nbsp;<img src='/kor/images/inc/paging/paging_line.jpg' width='1' height='9' />&nbsp;";
			}
		}
	}

	$str_Temp .= '</div>';

	$sPage = $i;

	if ($p_Total >= ($p_Cur + 1)) {
		$str_Temp .=	" <a href='" . $p_Url . ($p_Cur + 1) . "'><svg width='8' height='17' viewBox='0 0 8 17' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z' fill='black' /></svg></a> ";
	} else {
		$str_Temp .=	" <a href='#'><svg width='8' height='17' viewBox='0 0 8 17' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z' fill='black' /></svg></a> ";
	}

	if ($p_Total == 0) {
		$str_Temp = "&nbsp;";
	}

	return $str_Temp;
}

function Fnc_Conv_View($Content, $pr_Int_Val)
{

	if ($pr_Int_Val == "0") {
		$Content = str_replace(chr(32), "&nbsp;", $Content);
		$Content = str_replace(">", "&gt;", $Content);
		$Content = str_replace("<", "&lt;", $Content);
	}

	if ($pr_Int_Val == "0" || $pr_Int_Val == "2") {
		$Content = str_replace(chr(13), "<br>", $Content);
		$Content = str_replace(chr(10), "", $Content);
	}

	return $Content;
}

function fnc_File_Exe_Icon($pr_Str_Type)
{

	$str_Exe = strtolower($pr_Str_Type);

	$str_Icon_Img = "";

	if ($str_Exe == "zip" || $str_Exe == "alz" || $str_Exe == "cab" || $str_Exe == "jar") {
		$str_Icon_Img = "zip.gif";
	} elseif ($str_Exe == "rar" || $str_Exe == "gz" || $str_Exe == "ace" || $str_Exe == "arj" || $str_Exe == "tar" || $str_Exe == "tgz") {
		$str_Icon_Img = "rar.gif";
	} elseif ($str_Exe == "jpeg" || $str_Exe == "jpg") {
		$str_Icon_Img = "jpg.gif";
	} elseif ($str_Exe == "htm" || $str_Exe == "html" || $str_Exe == "mht") {
		$str_Icon_Img = "htm.gif";
	} elseif ($str_Exe == "java" || $str_Exe == "class") {
		$str_icon_Img = "java.gif";
	} elseif ($str_Exe == "mp3" || $str_Exe == "m3u" || $str_Exe == "ogg" || $str_Exe == "mp2") {
		$str_Icon_Img = "mp3.gif";
	} elseif ($str_Exe == "sql" || $str_Exe == "mysql" || $str_Exe == "ora") {
		$str_Icon_Img = "sql.gif";
	} elseif ($str_Exe == "xls" || $str_Exe == "xla") {
		$str_Icon_Img = "xls.gif";
	} elseif ($str_Exe == "xml" || $str_Exe == "xsl") {
		$str_Icon_Img = "xml.gif";
	} elseif ($str_Exe == "wav" || $str_Exe == "ra" || $str_Exe == "mid") {
		$str_Icon_Img = "wav.gif";
	} elseif ($str_Exe == "ram" || $str_Exe == "avi" || $str_Exe == "mpg" || $str_Exe == "mpeg" || $str_Exe == "asf") {
		$str_Icon_Img = "avi.gif";
	} elseif ($str_Exe == "iso" || $str_Exe == "lcd") {
		$str_Icon_Img = "cd.gif";
	} elseif ($str_Exe == "vbs" || $str_Exe == "asp" || $str_Exe == "jsp" || $str_Exe == "php" || $str_Exe == "cgi") {
		$str_Icon_Img = "script.gif";
	} elseif ($str_Exe == "txt" || $str_Exe == "log") {
		$str_Icon_Img = "txt.gif";
	} elseif ($str_Exe == "inf" || $str_Exe == "ini") {
		$str_Icon_Img = "inf.gif";
	} elseif ($str_Exe == "bmp" || $str_Exe == "gif" || $str_Exe == "png" || $str_Exe == "psd" || $str_Exe == "ppt" || $str_Exe == "doc" || $str_Exe == "ai" || $str_Exe == "cs" || $str_Exe == "css" || $str_Exe == "dll" || $str_Exe == "exe" || $str_Exe == "fla" || $str_Exe == "swf" || $str_Exe == "hwp" || $str_Exe == "js" || $str_Exe == "mdb" || $str_Exe == "msi" || $str_Exe == "pdf" || $str_Exe == "tif") {
		$str_Icon_Img = $str_Exe . ".gif";
	} else {
		$str_Icon_Img = "none.gif";
	}

	return $str_Icon_Img;
}
function fnc_File_Size($p_File_Size)
{
	if ($p_File_Size < 1024) {
		$str_File_Size = $p_File_Size . " byte";
	} elseif ($p_File_Size < (1024 * 1024)) {
		$str_File_Size = Number_Format($p_File_Size / 1024) . " kb";
	} else {
		$str_File_Size = Number_Format($p_File_Size / 1024 / 1024) . " mb";
	}

	return $str_File_Size;
}
