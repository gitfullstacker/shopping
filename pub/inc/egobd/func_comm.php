<?
	Function Fnc_Output_Page_Num($p_Total, $p_Cur, $p_Out, $p_St, $p_Url) {

		global $con_Ego_Cm_Fol;

		$str_Temp = "";
		$i = 0;

		If ($p_Cur>1) {
			$str_Temp .= "<a href='$p_Url".($p_Cur-1)."' class='lnk0'>
						<img src='".$con_Ego_Cm_Fol."img/board/btn_prev.gif' border='0' align='absMiddle' alt='다음'></a>&nbsp;";

		}

		If ($p_Cur>1) {
			$str_Temp .= "<a href='".$p_Url."1' class='lnk0'>[1]</a>...&nbsp;";
		}

		For ($i=$p_St; $i<=($p_St+$p_Out)-1;$i++) {

			If ($i>$p_Total) {
				break;
			}Else{
				If ($i==$p_Cur) {
					$str_Temp .= " <font color='red'>[".$i."]</font> ";
				}Else{
					$str_Temp .= " <a href='".$p_Url.$i."' class='lnk0'>[".$i."]</a> ";
				}
			}
		}

		If ($p_Cur<$p_Total) {
			$str_Temp .= "&nbsp;...<a href='".$p_Url.$p_Total."' class='lnk0'>[".$p_Total."]</a>";
		}

		If ($p_Total>$p_Cur) {
			$str_Temp .= "&nbsp;<a href='$p_Url".($p_Cur+1)."' class='lnk0'>
						<img src='".$con_Ego_Cm_Fol."img/board/btn_next.gif' border='0' align='absMiddle' alt='이전'></a>";
		}

		If ($p_Total==0) {
			$str_Temp = "&nbsp;";
		}

		return $str_Temp;

	}

	Function Fnc_Output_Page_Num1($p_Total, $p_Cur, $p_Out, $p_St, $p_Url) {

		global $con_Ego_Cm_Fol;

		$str_Temp = "";
		$i = 0;

		$str_Temp .= "<a href='".$p_Url."1' class='img_b'><img src='/images/board/btn_page_first.gif' alt='' /></a> " ;

		If ($p_Cur>1) {
			$str_Temp .=	"<a href='".$p_Url.($p_Cur-1)."' class='img_b'><img src='/images/board/btn_page_prev.gif' alt='' /></a> ";
		}Else{
			$str_Temp .= 	"<a href='#' class='img_b'><img src='/images/board/btn_page_prev.gif' alt='' /></a> ";
		}
		//$str_Temp .= "&nbsp;&nbsp;&nbsp;";


		For ($i=$p_St; $i<=($p_St+$p_Out)-1;$i++) {

			If ($i>$p_Total) {
				break;
			}Else{


				If ($i==$p_Cur) {
					If ($i==$p_St) {
						$str_Temp .= "<a href='#' class='on'>".$i."</a>";
					}Else{
						$str_Temp .= "<a href='#' class='on'>".$i."</a>";
					}
				}Else{
					$str_Temp .= "<a href='".$p_Url.$i."'>".$i."</a>";
				}

				If (!(($i==$p_Total)||($i==$p_Out))) {
					//$str_Temp .= "&nbsp;<img src='/kor/images/inc/paging/paging_line.jpg' width='1' height='9' />&nbsp;";
				}

			}

		}
		
		//$str_Temp .= "&nbsp;&nbsp;";

		$sPage = $i;

		If ($p_Total>=($p_Cur+1)) {
			$str_Temp .=	" <a href='".$p_Url.($p_Cur+1)."' class='img_b'><img src='/images/board/btn_page_next.gif' alt='' /></a> ";
		}Else{
			$str_Temp .=	" <a href='#' class='img_b'><img src='/images/board/btn_page_next.gif' alt='' /></a> ";
		}
		

		$str_Temp .=	"<a href='".$p_Url.$p_Total."' class='img_b'><img src='/images/board/btn_page_last.gif' alt='' /></a>";

		If ($p_Total==0) {
			$str_Temp = "&nbsp;";
		}

		return $str_Temp;

	}
	
	Function Fnc_Output_Page_Num2($p_Total, $p_Cur, $p_Out, $p_St, $p_Url) {

		global $con_Ego_Cm_Fol;

		$str_Temp = "";
		$i = 0;

		$str_Temp .= "<a href='".$p_Url."1' class='pg_nav pg_fir'></a> " ;

		If ($p_Cur>1) {
			$str_Temp .=	"<a href='".$p_Url.($p_Cur-1)."' class='pg_nav pg_prev'></a> ";
		}Else{
			$str_Temp .= 	"<a href='#' class='pg_nav pg_prev'></a> ";
		}
		
		$str_Temp .= "<span class='num'>";


		For ($i=$p_St; $i<=($p_St+$p_Out)-1;$i++) {

			If ($i>$p_Total) {
				break;
			}Else{


				If ($i==$p_Cur) {
					If ($i==$p_St) {
						$str_Temp .= "<a href='#' class='on'>".$i."</a>";
					}Else{
						$str_Temp .= "<a href='#' class='on'>".$i."</a>";
					}
				}Else{
					$str_Temp .= "<a href='".$p_Url.$i."'>".$i."</a>";
				}

				If (!(($i==$p_Total)||($i==$p_Out))) {
					//$str_Temp .= "&nbsp;<img src='/kor/images/inc/paging/paging_line.jpg' width='1' height='9' />&nbsp;";
				}

			}

		}
		
		$str_Temp .= "</span>";

		$sPage = $i;

		If ($p_Total>=($p_Cur+1)) {
			$str_Temp .=	" <a href='".$p_Url.($p_Cur+1)."' class='pg_nav pg_next'></a> ";
		}Else{
			$str_Temp .=	" <a href='#' class='pg_nav pg_next'></a> ";
		}
		

		$str_Temp .=	"<a href='".$p_Url.$p_Total."' class='pg_nav pg_last'></a>";

		If ($p_Total==0) {
			$str_Temp = "&nbsp;";
		}

		return $str_Temp;

	}

	Function Fnc_Conv_View($Content, $pr_Int_Val) {

		If ($pr_Int_Val=="0") {
			$Content = str_replace(chr(32), "&nbsp;", $Content);
			$Content = str_replace(">", "&gt;", $Content);
			$Content = str_replace("<", "&lt;", $Content);
		}

		If ($pr_Int_Val=="0" || $pr_Int_Val=="2") {
			$Content = str_replace(chr(13), "<br>", $Content);
			$Content = str_replace(chr(10), "", $Content);
		}

		return $Content;

	}

	Function fnc_File_Exe_Icon($pr_Str_Type) {

		$str_Exe = strtolower($pr_Str_Type);

		$str_Icon_Img = "";

		If ($str_Exe=="zip" || $str_Exe=="alz" || $str_Exe=="cab" || $str_Exe=="jar") {
			$str_Icon_Img = "zip.gif";
		}elseif ($str_Exe=="rar" || $str_Exe=="gz" || $str_Exe=="ace" || $str_Exe=="arj" || $str_Exe=="tar" || $str_Exe=="tgz") {
			$str_Icon_Img = "rar.gif";
		}elseif ($str_Exe=="jpeg" || $str_Exe=="jpg") {
			$str_Icon_Img = "jpg.gif";
		}elseif ($str_Exe=="htm" || $str_Exe=="html" || $str_Exe=="mht") {
			$str_Icon_Img = "htm.gif";
		}elseif ($str_Exe=="java" || $str_Exe=="class") {
			$str_icon_Img = "java.gif";
		}elseif ($str_Exe=="mp3" || $str_Exe=="m3u" || $str_Exe=="ogg" || $str_Exe=="mp2") {
			$str_Icon_Img = "mp3.gif";
		}elseif ($str_Exe=="sql" || $str_Exe=="mysql" || $str_Exe=="ora") {
			$str_Icon_Img = "sql.gif";
		}elseif ($str_Exe=="xls" || $str_Exe=="xla") {
			$str_Icon_Img = "xls.gif";
		}elseif ($str_Exe=="xml" || $str_Exe=="xsl") {
			$str_Icon_Img = "xml.gif";
		}elseif ($str_Exe=="wav" || $str_Exe=="ra" || $str_Exe=="mid") {
			$str_Icon_Img = "wav.gif";
		}elseif ($str_Exe=="ram" || $str_Exe=="avi" || $str_Exe=="mpg" || $str_Exe=="mpeg" || $str_Exe=="asf") {
			$str_Icon_Img = "avi.gif";
		}elseif ($str_Exe=="iso" || $str_Exe=="lcd") {
			$str_Icon_Img = "cd.gif";
		}elseif ($str_Exe=="vbs" || $str_Exe=="asp" || $str_Exe=="jsp" || $str_Exe=="php" || $str_Exe=="cgi") {
			$str_Icon_Img = "script.gif";
		}elseif($str_Exe=="txt" || $str_Exe=="log") {
			$str_Icon_Img = "txt.gif";
		}elseif ($str_Exe=="inf" || $str_Exe=="ini") {
			$str_Icon_Img = "inf.gif";
		}elseif ($str_Exe=="bmp" || $str_Exe=="gif" || $str_Exe=="png" || $str_Exe=="psd" || $str_Exe=="ppt" || $str_Exe=="doc" || $str_Exe=="ai" || $str_Exe=="cs" || $str_Exe=="css" || $str_Exe=="dll" || $str_Exe=="exe" || $str_Exe=="fla" || $str_Exe=="swf" || $str_Exe=="hwp" || $str_Exe=="js" || $str_Exe=="mdb" || $str_Exe=="msi" || $str_Exe=="pdf" || $str_Exe=="tif") {
			$str_Icon_Img = $str_Exe.".gif";
		}else{
			$str_Icon_Img = "none.gif";
		}

		return $str_Icon_Img;
	}
	Function fnc_File_Size($p_File_Size) {
		If ($p_File_Size<1024) {
			$str_File_Size = $p_File_Size . " byte";
		}ElseIf ($p_File_Size<(1024*1024)) {
			$str_File_Size = Number_Format($p_File_Size/1024) . " kb";
		}Else{
			$str_File_Size = Number_Format($p_File_Size/1024/1024) . " mb";
		}

		return $str_File_Size;
	}
?>