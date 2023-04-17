<?include "inc/inc_top.php";?>
<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	// ==================================================
	//	= 새글표시를 위한 날짜값 설정 시작

	$Sql_Query = " SELECT IFNULL(MAX(BD_REG_DATE), NOW()) AS MAX_DATE FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."`";
	If (!$bln_Main_Bd) {
		$Sql_Query .= " WHERE CONF_SEQ=".$int_Ini_Board_Seq;
	}
	$obj_Rlt = mysql_query($Sql_Query);

	$arr_New_Date = array();
	while($row = mysql_fetch_array($obj_Rlt)) {
  		array_push($arr_New_Date, $row);
	}
	//	= 새글표시를 위한 날짜값 설정 종료
	// ==================================================

	// ===============================
	//	= 페이지관련 설정 시작
	$int_Page_Size		= $arr_Ini_Board_Info[0][17];					// @@@@@@ 한 페이지에 출력될 목록수 설정
	$int_Page_Size		= 6;					// @@@@@@ 한 페이지에 출력될 목록수 설정
	$int_Out_Page_Cnt	= $arr_Ini_Board_Info[0][18];					// @@@@@@ 출력할 페이지 갯수 설정

	$int_Total_Page = 0; $int_Total_Cnt = 0;

	$str_Pg = Fnc_Om_Conv_Default($_REQUEST[pg],"1");

	//	= 페이지관련 설정 종료
	// ===============================

	// ======================================
	//	= 검색 시작
	$Sql_Add_Query = "";

	$int_Itm = Fnc_Om_Conv_Default($_REQUEST[itm],"");
	$str_Txt = Fnc_Om_Conv_Default($_REQUEST[txt],"");
	$Txt_item1 = Fnc_Om_Conv_Default($_REQUEST[Txt_item1],"");

	If (Is_Numeric($int_Itm)) {
		switch (int_Itm) {
			case "1" :
				$str_Itm = "BD_W_NAME";break;
			case "2" :
				$str_Itm = "MEM_ID"; break;
			case "3" :
				$str_Itm = "BD_W_EMAIL"; break;
			case "4" :
				$str_Itm = "BD_CONT"; break;
			default :
				$str_Itm = "BD_TITLE";
				$int_Itm = "0";
				break;;
		}

		$Sql_Add_Query =	" AND A.BD_IDX IN(SELECT BD_IDX FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE ";
		// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//	= 전체 게시판이 아닐때
		//	  해당 게시판 목록 출력
		If ($bln_Main_Bd==False) {
			$Sql_Add_Query .= " CONF_SEQ=".$int_Ini_Board_Seq." AND ";
		}
		// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		$Sql_Add_Query .= $str_Itm." LIKE '%".$str_Txt."%' GROUP BY BD_IDX) ";

	}
	//	= 검색 종료
	// ======================================
	
	If ($Txt_item1!="") {
		$Sql_Add_Query .= " AND A.BD_ITEM1 = '".$Txt_item1."'  ";
	}

	$Sql_Query =	" SELECT
					COUNT(A.BD_SEQ)
				FROM `"
					.$Tname."b_bd_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN `"
					.$Tname."b_img_data".$str_Ini_Group_Table."` AS C
					ON
					A.CONF_SEQ=C.CONF_SEQ
					AND
					A.BD_SEQ=C.BD_SEQ
					AND
					C.IMG_ALIGN=1
					LEFT JOIN `"
					.$Tname."b_file_data".$str_Ini_Group_Table."` AS D
					ON
					A.CONF_SEQ=D.CONF_SEQ
					AND
					A.BD_SEQ=D.BD_SEQ
					AND
					D.FILE_ALIGN=1
				WHERE ";

	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//	= 기술원 전체 게시판이 아닐때
	//	  해당 게시판 목록 출력
	If ($bln_Main_Bd==False) {
		$Sql_Query .= " A.CONF_SEQ=".$int_Ini_Board_Seq." AND ";
	}
	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	$Sql_Query .= " A.BD_ID_KEY IS NOT NULL ";
	$Sql_Query .= $Sql_Add_Query;

	$arr_Get_Data = mysql_query($Sql_Query);

	if(!result){
	   error("QUERY_ERROR");
	   exit;
	}
	$int_Total_Cnt = mysql_result($arr_Get_Data,0,0);

	if(!$int_Total_Cnt){
		$first = 1;
		$last = 0;
	}else{
	  	$first = $int_Page_Size *($str_Pg-1) ;
	  	$last = $int_Page_Size *$str_Pg;

	  	$IsNext = $int_Total_Cnt - $last ;
	  	if($IsNext > 0){
			$last -= 1;
	  	}else{
	   		$last = $int_Total_Cnt -1 ;
	  	}
	}
	$int_Total_Page = ceil($int_Total_Cnt/$int_Page_Size);

	$f_limit=$first;
	$l_limit=$last + 1 ;

	$Sql_Query =	" SELECT
					A.BD_SEQ,
					A.CONF_SEQ,
					A.BD_ID_KEY,
					A.BD_IDX,
					A.BD_ORDER,
					A.BD_LEVEL,
					A.MEM_CODE,
					A.MEM_ID,
					A.BD_W_NAME,
					A.BD_W_EMAIL,
					A.BD_TITLE,
					A.BD_CONT,
					A.BD_OPEN_YN,
					A.BD_REG_DATE,
					A.BD_DEL_YN,
					A.BD_VIEW_CNT,
					A.BD_GOOD_CNT,
					A.BD_BAD_CNT,
					IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
					IFNULL(C.IMG_SEQ, 0) AS IMG_SEQ,
					IFNULL(C.IMG_ID_KEY, '') AS IMG_ID_KEY,
					IFNULL(C.IMG_TITLE, '') AS IMG_TITLE,
					IFNULL(C.IMG_CONT, '') AS IMG_CONT,
					IFNULL(C.IMG_F_WIDTH, 0) AS IMG_F_WIDTH,
					IFNULL(C.IMG_F_HEIGHT, 0) AS IMG_F_HEIGHT,
					IFNULL(D.FILE_SEQ, 0) AS FILE_SEQ,
					A.BD_ITEM1
				FROM `"
					.$Tname."b_bd_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN `"
					.$Tname."b_img_data".$str_Ini_Group_Table."` AS C
					ON
					A.CONF_SEQ=C.CONF_SEQ
					AND
					A.BD_SEQ=C.BD_SEQ
					AND
					C.IMG_ALIGN=1
					LEFT JOIN `"
					.$Tname."b_file_data".$str_Ini_Group_Table."` AS D
					ON
					A.CONF_SEQ=D.CONF_SEQ
					AND
					A.BD_SEQ=D.BD_SEQ
					AND
					D.FILE_ALIGN=1
				WHERE ";

	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//	= 기술원 전체 게시판이 아닐때
	//	  해당 게시판 목록 출력
	If ($bln_Main_Bd==False) {
		$Sql_Query .= " A.CONF_SEQ=".$int_Ini_Board_Seq." AND ";
	}
	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	$Sql_Query .= " A.BD_ID_KEY IS NOT NULL ";
	$Sql_Query .= $Sql_Add_Query;
	$Sql_Query .= " ORDER BY
								BD_ORDER DESC ";
	$Sql_Query.="limit $f_limit,$l_limit";

	$arr_Get_Data= mysql_query($Sql_Query);
	if(!$arr_Get_Data) {
	 	error("QUERY_ERROR");
	 	exit;
	}
	$arr_Get_Data_Cnt=mysql_num_rows($arr_Get_Data);

	// =============================================
	//	= 공지글 배열에 저장 시작
	$Sql_Query =	" SELECT
					A.BD_SEQ,
					A.CONF_SEQ,
					A.BD_ID_KEY,
					A.BD_IDX,
					A.BD_ORDER,
					A.BD_LEVEL,
					A.MEM_CODE,
					A.MEM_ID,
					A.BD_W_NAME,
					A.BD_W_EMAIL,
					A.BD_TITLE,
					'' AS BD_CONT,
					A.BD_OPEN_YN,
					A.BD_REG_DATE,
					A.BD_DEL_YN,
					A.BD_VIEW_CNT,
					A.BD_GOOD_CNT,
					A.BD_BAD_CNT,
					IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
					IFNULL(C.IMG_SEQ, 0) AS IMG_SEQ,
					IFNULL(C.IMG_ID_KEY, '') AS IMG_ID_KEY,
					IFNULL(C.IMG_TITLE, '') AS IMG_TITLE,
					IFNULL(C.IMG_CONT, '') AS IMG_CONT,
					IFNULL(C.IMG_F_WIDTH, 0) AS IMG_F_WIDTH,
					IFNULL(C.IMG_F_HEIGHT, 0) AS IMG_F_HEIGHT,
					IFNULL(D.FILE_SEQ, 0) AS FILE_SEQ,
					A.BD_ITEM1
				FROM `"
					.$Tname."b_bd_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN `"
					.$Tname."b_img_data".$str_Ini_Group_Table."` AS C
					ON
					A.CONF_SEQ=C.CONF_SEQ
					AND
					A.BD_SEQ=C.BD_SEQ
					AND
					C.IMG_ALIGN=1
					LEFT JOIN `"
					.$Tname."b_file_data".$str_Ini_Group_Table."` AS D
					ON
					A.CONF_SEQ=D.CONF_SEQ
					AND
					A.BD_SEQ=D.BD_SEQ
					AND
					D.FILE_ALIGN=1
				WHERE
					A.CONF_SEQ=".$int_Ini_Board_Seq."
					AND
					A.BD_ID_KEY IS NOT NULL
					AND
					A.BD_NOTICE_YN=1
				ORDER BY
					A.BD_SEQ DESC ";

	$arr_Notice_Data=mysql_query($Sql_Query);
	$arr_Notice_Data_Cnt=mysql_num_rows($arr_Notice_Data);
	//	= 공지글 배열에 저장 종료
	// =============================================

	$int_St_Num = ((int)(($str_Pg-1)/$int_Out_Page_Cnt)*$int_Out_Page_Cnt)+1;		//' @@@@@@ 페이지 리스트 출력 초기 페이지 값 설정

	$str_String = "?bd=".$int_Ini_Board_Seq."&itm=".$int_Itm."&txt=".urlencode($str_Txt)."&Txt_item1=".urlencode($Txt_item1)."&pg=";
	$str_Url = "egolist.php".$str_String;
?>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT ="-1">
<SCRIPT LANGUAGE="JavaScript" SRC="ego_ini.html"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var int_Doc_Width = '<?=$int_Ini_Table_Width?>';
	document.write('<L'+'I'+'NK rel="stylesheet" HREF="'+gbl_Str_Comm_Path+'css/egobd.css" TYPE="text/css">');
	document.write('<SCR'+'I'+'PT LANGUAGE="JavaScript" SRC="'+gbl_Str_Comm_Path+'js/egobd/comm.js"><\/SCRIPT>');
//-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var obj_Blank = new Function("x", "return fncCheckBlank(x)");
	var obj_Alert = new Function("x", "y", "z", "return fncFocusAlert(x, y, z)");

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 목록구분 점선으로 분리
		반환값 : str_Devide_Html[라인분리HTML태그]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Line_Divide()
	{
		var str_Divide_Html = '';
		str_Divide_Html =	'<tr>'+
							'<td colspan="20" style="background-image:url('+gbl_Str_Comm_Image+'board/line_dot.gif);">'+
							'</td>'+
							'</tr>';
		return str_Divide_Html;
	}

	function fnc_Send_Data(pr_Form)
	{
		var obj_Form = pr_Form;
		var obj_Txt = obj_Form.txt;
		var regSchChk = /[^\w@\s.ㄱ-힣]/;

		if(!obj_Blank(obj_Txt.value))
			return obj_Alert(obj_Txt, null, "검색어를 입력하세요.");

		if(regSchChk.test(obj_Txt.value))
			return obj_Alert(obj_Txt, null, "@ . 이외의 기호는 사용하실 수 없습니다.");
	}

	function fnc_Del_Bd(pr_Form)
	{
		var obj_Form = pr_Form;

		var int_I = 0;
		var obj = document.getElementsByName("seq[]");

		if(typeof(obj.length)!="undefined"){
			for(var i=0; i<obj.length; i++)
			{
				if(obj[i].checked==true)
					int_I += 1;
			}
		}else{
			if(obj.checked==true)
				int_I += 1;
		}

		if(int_I==0)
		{
			alert("삭제할 데이터를 선택해 주세요");
		}
		else
		{
			if(confirm("선택한 데이터를 삭제하시겠습니까?"))
			{
				obj_Form.method="post";
				obj_Form.action="egodelete.php";
				obj_Form.submit();
			}
		}
	}

	function fnc_All_Chk(pr_Form)
	{
		var obj_Form = pr_Form;
		try
		{
			var obj = document.getElementsByName("seq[]");

			if(typeof(obj.length)!="undefined"){
				for(var i=0; i<obj.length; i++)
				{
					if(obj[i].checked==false)
						obj[i].checked=true;
					else
						obj[i].checked=false;
				}
			}else{
				if(obj.checked==false)
					obj.checked=true;
				else
					obj.checked=false;
			}
		}catch(e){}
	}
//-->
</SCRIPT>
<?include "inc/inc_mid.php";?>

	<form name="frm_List">
	<input type="hidden" name="bd" value="<?=$int_Ini_Board_Seq?>">
	<input type="hidden" name="mode" value="99">
	
	
					<div id="gallery">
						<div class="list">
							<ul>
								<?if($int_Total_Cnt!=0){?>
								<?$article_num = $int_Total_Cnt - $int_Page_Size*($str_Pg-1) ;?>
								<?for($int_I = 0 ;$int_I <= $int_Page_Size -1; $int_I++) {?>
								<li>
									<a href="egoread.php<?=$str_String.$str_Pg?>&seq=<?=mysql_result($arr_Get_Data,$int_I,bd_seq)?>">
									<?
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
										//	= 이미지 출력 시작
										If (mysql_result($arr_Get_Data,$int_I,img_seq)>0) {
									?>
									<img src="egofiledata.php?bd=<?=mysql_result($arr_Get_Data,$int_I,conf_seq)?>&iseq=<?=mysql_result($arr_Get_Data,$int_I,img_seq)?>&ikey=<?=mysql_result($arr_Get_Data,$int_I,img_id_key)?>&tp=1" align="absMiddle" style="width:216px;height:175px;" border="0">
									<?
										}Else{
									?>
									<img src="/images/board/img.jpg" alt="" />
									<?
										}
										//	= 이미지 출력 종료
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									?>
									<br />
									<?
									// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
										//	= 답변글이라면 답변글 계층 표시 시작
										If (mysql_result($arr_Get_Data,$int_I,bd_level)>0) {
									?>
									<img src="<?=$str_Board_Icon_Img?>blank.gif" border="0" width="<?=mysql_result($arr_Get_Data,$int_I,bd_level)*5?>" align="absMiddle"><img src="<?=$str_Board_Icon_Img?>ic_reply.gif" border="0" align="absMiddle">
									<?
									}
										//	= 답변글이라면 답변글 계층 표시 종료
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
										//	= 비공개글 표시 아이콘 변수에 저장 시작
										$str_Tmp = "";
										If (mysql_result($arr_Get_Data,$int_I,bd_open_yn)>0) {
											$str_Tmp = "<img src='".$str_Board_Icon_Img."ic_key.gif' border='0' align='absMiddle'> ";
										}
										//	= 비공개글 표시 아이콘 변수에 저장 종료
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									?>
									<?=$str_Tmp?>
									<?
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
										//	= 새글표시 시작
										If (left($arr_New_Date[0][0],10)==left(mysql_result($arr_Get_Data,$int_I,bd_reg_date),10)) {
											//echo "<img src='".$str_Board_Icon_Img."ic_new.gif' align='absMiddle' border='0'> ";
										}
										//	= 새글표시 종료
										// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									?>
									<?
										// ========================
										//	= 메모글 갯수 출력 시작
										If (mysql_result($arr_Get_Data,$int_I,bd_memo_cnt)>0) {
											echo " (<img src='".$str_Board_Icon_Img."ic_memo.gif' align='absMiddle' border='0'> " . mysql_result($arr_Get_Data,$int_I,bd_memo_cnt) . ") ";
										}
										//	= 메모글 갯수 출력 종료
										// ========================
					
										$str_Tmp = stripslashes(mysql_result($arr_Get_Data,$int_I,bd_title));
					
										if (strlen(stripslashes(mysql_result($arr_Get_Data,$int_I,bd_title))) > 20 ) {
											$str_Tmp = mb_substr(stripslashes(mysql_result($arr_Get_Data,$int_I,bd_title)),0,20,'utf-8')."...";
										} else {
											$str_Tmp = stripslashes(mysql_result($arr_Get_Data,$int_I,bd_title));
										}
					
										echo $str_Tmp;
									?>
									</a>
								</li>
								<?
								$article_num--;
								if($article_num==0){
									break;
								}
								?>
								<?}?>
								<?}else{?>
								<li style="padding-left:0px;width:100%;height:150px;padding-top:120px;text-align:center;">자료가 없습니다.</li>
								<?}?>
							</ul>
						</div>
					</div>

					<div style="clear:both;"></div>
					<div class="paging">
						<?=Fnc_Output_Page_Num1($int_Total_Page, $str_Pg, $int_Out_Page_Cnt, $int_St_Num, $str_Url)?>
					</div>


					<div class="board_search">
						<fieldset>
							<legend style="display:none;">게시판 검색</legend>
							<select name="itm" size="1" />
								<option value="0"<?If ($int_Itm=="0") {?> selected<?}?>>글제목</option>
								<option value="1"<?If ($int_Itm=="1") {?> selected<?}?>>작성자</option>
								<option value="4"<?If ($int_Itm=="4") {?> selected<?}?>>글내용</option>
							</select>
							<input type="text" name="txt" maxlength="20" value="<?=$str_Txt?>" class="board_input" style="width:200px;" title="검색어 입력" onFocus="if(this.value=='검색어 입력')this.value='';" onBlur="if (this.value =='') this.value='검색어 입력'" />
							<input type="image" src="/images/board/btn_search.jpg" alt="검색" title="검색" align="absmiddle" class="btn_mb1"/>
						</fieldset>
					</div>


	</form>

<?include "inc/inc_btm.php";?>
