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
			$Sql_Add_Query .= " CONF_SEQ=".$int_Ini_Board_Seq." AND  ";
		}
		// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		$Sql_Add_Query .= "(" .$str_Itm." LIKE '%".$str_Txt."%' OR E.STR_GOODNAME LIKE '%".$str_Txt."%' OR F.STR_CODE LIKE '%".$str_Txt."%') GROUP BY BD_IDX) ";


	}
	//	= 검색 종료
	// ======================================
	

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
					LEFT JOIN `"
					.$Tname."comm_goods_master` AS E
					ON
					A.BD_ITEM1=E.STR_GOODCODE
					LEFT JOIN `"
					.$Tname."comm_com_code` AS F
					ON
					E.INT_BRAND=F.INT_NUMBER
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
					E.STR_GOODNAME,
					E.STR_IMAGE1,
					A.BD_ITEM2,
					F.STR_CODE,
					A.BD_FORMAT,
					A.BD_THUMB_YN
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
					LEFT JOIN `"
					.$Tname."comm_goods_master` AS E
					ON
					A.BD_ITEM1=E.STR_GOODCODE
					LEFT JOIN `"
					.$Tname."comm_com_code` AS F
					ON
					E.INT_BRAND=F.INT_NUMBER
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
					E.STR_GOODNAME,
					E.STR_IMAGE1,
					A.BD_ITEM2,
					F.STR_CODE,
					A.BD_FORMAT,
					A.BD_THUMB_YN
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
					LEFT JOIN `"
					.$Tname."comm_goods_master` AS E
					ON
					A.BD_ITEM1=E.STR_GOODCODE
					LEFT JOIN `"
					.$Tname."comm_com_code` AS F
					ON
					E.INT_BRAND=F.INT_NUMBER
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

	$str_String = "?bd=".$int_Ini_Board_Seq."&itm=".$int_Itm."&txt=".urlencode($str_Txt)."&pg=";
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
<SCRIPT LANGUAGE="JavaScript">
<!--
	/* +++++++++++++++++++++++++++++++++++++++ *\
		수정일자	: 2006-09-20
		작성자		: 김진규(p7227kjg@dreamwiz.com)
		기능설명	: 작성글 조회 페이지로 이동.
					  비공개글 조회시 글 비밀번호 입력창 출력
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Read_Cont(url, int_Mem, int_Opn, int_Adm, int_Match)
	{
		if (int_Adm==1)
		{
			location.href=url;
		}
		else
		{
			if (int_Match==1)
			{
				location.href=url;
			}
			else
			{
				if(int_Mem==1)
				{
					alert("회원이 작성한 글입니다.\n\n로그인을 하여 주십시오.");
				}
				else
				{
					if (int_Mem==0 && int_Opn==0)
					{
						location.href=url;
					}
					else
					{
						var lbl_Layer = eval("lbl_Pwd");
						var int_Y = event.clientY;
						var int_X = event.clientX;

						lbl_Layer.style.top=int_Y+document.body.scrollTop;
						lbl_Layer.style.left=int_X+document.body.scrollLeft;
						document.frm_Pwd.hid_Url.value=url;
						lbl_Layer.style.visibility="visible";
						document.frm_Pwd.txt_Pwd.focus();
					}
				}
			}
		}
	}
//-->
</SCRIPT>
<?
	$int_Adm = 0;
	If ($bln_Cur_Admin) {
		$int_Adm = 1;
	}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function fnc_Send_Pwd(it)
	{
		var obj_Form = it;

		var txt_Pwd = obj_Form.txt_Pwd.value;

		if(!obj_Blank(txt_Pwd))
		{
			alert("글 암호를 입력하세요.");
			obj_Form.txt_Pwd.focus();
			return false;
		}
		location.href=obj_Form.hid_Url.value+'&pwd='+txt_Pwd;
		return false;
	}
	
	var old='';
	function menu(name){
			
		submenu=eval("submenu_prodeval"+name+".style");

		if(old!=submenu)
		{
			if(old!='')
			{
				old.display='none';
			}
			submenu.display='table-row';
			old=submenu;
		}
		else
		{
			submenu.display='none';
			old='';
		}
	}
//-->
</SCRIPT>
<?include "inc/inc_mid.php";?>

<label id="lbl_Pwd" class="layer_brow">
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#000000" width="190">
<form name="frm_Pwd" method="post" action="egoread.asp" onsubmit="return fnc_Send_Pwd(this);">
<input type="hidden" name="hid_Url">
	<tr>
		<td width="70" bgcolor="#DDDDDD" height="25" align="center">
			<B><img src="/pub/img/icons/key_01.gif" align="absMiddle"> 암호</B>
		</td>
		<td width="130" bgcolor="#FFFFFF">
			<input type="password" class="board_input" name="txt_Pwd" size="10">
			<input type="image" src="/pub/img/icons/alert_01.gif" width="16" height="16" align="absMiddle">
			<img src="/pub/img/icons/cancel_r.gif" align="absMiddle" onmouseover="this.style.cursor='hand'" onclick="document.all['lbl_Pwd'].style.visibility='hidden'">
		</td>
	</tr>
</form>
</table>
</label>
 
	<form name="frm_List">
	<input type="hidden" name="bd" value="<?=$int_Ini_Board_Seq?>">
	<input type="hidden" name="mode" value="99">
					<div class="search_bx mt30">
						<span class="tit">후기 검색하기</span>
						<input type="hidden" name="itm" value="0">
						<input type="text" class="inp_faq" name="txt" maxlength="20" value="<?=$str_Txt?>"/>
						<input type="button" value="검색" class="btn_bt" />
					</div>
					<p class="f_s13 mt35">총 <?=$int_Total_Cnt?>개의 이용후기가 있습니다.</p>
					<div class="t_cover01 mt15">
						<table class="t_type01">
							<colgroup>
								<col style="width:75px;" />
								<col style="width:155px;" />
								<col />
								<col style="width:50px;" />
								<col style="width:145px;" />
								<col style="width:145px;" />
							</colgroup>
							<tbody>
								<?if($int_Total_Cnt!=0){?>
								<?$article_num = $int_Total_Cnt - $int_Page_Size*($str_Pg-1) ;?>
								<?for($int_I = 0 ;$int_I <= $int_Page_Size -1; $int_I++) {?>
								<tr>
									<td><?=$article_num?></td>
									<td style="width:108px;height:83px;"><?if (mysql_result($arr_Get_Data,$int_I,str_image1)!=""){?><img src="/admincenter/files/good/<?=mysql_result($arr_Get_Data,$int_I,str_image1)?>" style="width:108px;height:108px;" class="img_bd" alt="" /><?}else{?>&nbsp;<?}?></td>
									<td class="left02">
										<p class="f_bd f_bk">[<?=mysql_result($arr_Get_Data,$int_I,str_code)?>] <?=mysql_result($arr_Get_Data,$int_I,str_goodname)?></p>
										<p class="mt10">
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
											<a href="javascript:menu('<?=mysql_result($arr_Get_Data,$int_I,bd_seq)?>');" class="f_bd f_bk">
											<?=$str_Tmp?>
											<?
												// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//	= 새글표시 시작
												If (left($arr_New_Date[0][0],10)==left(mysql_result($arr_Get_Data,$int_I,bd_reg_date),10)) {
													echo "<img src='".$str_Board_Icon_Img."ic_new.gif' align='absMiddle' border='0'> ";
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
					
												$str_Tmp = Fnc_Conv_View($str_Tmp, 0);
					
												echo $str_Tmp;
											?>
											</a>
										</p>
										<p class="mt15">
											<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="1"){?><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><?}?>
											<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="2"){?><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><?}?>
											<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="3"){?><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><?}?>
											<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="4"){?><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><?}?>
											<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="5"){?><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><?}?>
										</p>
									</td>
									<td>
										<?
											If (mysql_result($arr_Get_Data,$int_I,img_seq)+mysql_result($arr_Get_Data,$int_I,file_seq)>0) {
												echo "<img src='/images/sub/icn_photoreview.gif' align='absMiddle'>";
											}Else{
												echo "&nbsp;";
											}
										?>
									</td>
									<td class="left"><?for ($int_C=0;$int_C<=strlen(mysql_result($arr_Get_Data,$int_I,mem_id))-4;$int_C++) {?><?=substr(mysql_result($arr_Get_Data,$int_I,mem_id),$int_C,1)?><?}?>***</td>
									<td><?=str_replace("-", ".",substr(mysql_result($arr_Get_Data,$int_I,bd_reg_date),0,10))?></td>
								</tr>
								<tr id="submenu_prodeval<?=mysql_result($arr_Get_Data,$int_I,bd_seq)?>" style="display: none;">
									<td colspan="6" class="review_con">
										<p>
											<?
											$Sql_Query =	" SELECT
															1 AS TYPE,
															IMG_SEQ AS SEQ,
															IMG_ID_KEY AS SKEY,
															IMG_TITLE AS F_TITLE,
															IMG_CONT AS F_CONT,
															IMG_F_NAME AS F_NAME,
															IMG_F_TYPE AS F_TYPE,
															IMG_F_SIZE AS F_SIZE,
															IMG_DOWN_CNT,
															IMG_F_WIDTH,
															IMG_F_HEIGHT,
															IMG_VIEW_CNT
														FROM
															`".$Tname."b_img_data".$str_Ini_Group_Table."`
														WHERE
															CONF_SEQ=".mysql_result($arr_Get_Data,$int_I,conf_seq)."
															AND
															BD_SEQ=".mysql_result($arr_Get_Data,$int_I,bd_seq)."
														UNION ALL
														SELECT
															0 AS TYPE,
															FILE_SEQ AS SEQ,
															FILE_ID_KEY AS SKEY,
															FILE_TITLE AS F_TITLE,
															FILE_CONT AS F_CONT,
															FILE_F_NAME AS F_NAME,
															FILE_F_TYPE AS F_TYPE,
															FILE_F_SIZE AS F_SIZE,
															FILE_DOWN_CNT,
															0,
															0,
															-1
														FROM
															`".$Tname."b_file_data".$str_Ini_Group_Table."`
														WHERE
															CONF_SEQ=".mysql_result($arr_Get_Data,$int_I,conf_seq)."
															AND
															BD_SEQ=".mysql_result($arr_Get_Data,$int_I,bd_seq);
										
											$arr_File_Data=mysql_query($Sql_Query);
											$arr_File_Data_Cnt=mysql_num_rows($arr_File_Data);
											?>
                                 	   		<table width="100%" border="0" cellspacing="2" cellpadding="0">
												<?
													// =======================================
													//	= 이미지 미리보기 시작
													If (mysql_result($arr_Get_Data,$int_I,bd_thumb_yn)>0) {
														If ($arr_File_Data_Cnt) {

														for($int_J = 0 ;$int_J < $arr_File_Data_Cnt; $int_J++) {
															If (mysql_result($arr_File_Data,$int_J,TYPE)>0) {
															?>
											              	<tr>
											              		<td align="center" colspan="4"  style="padding:0px;border-bottom:0px;padding-top:5px;">
																	<table width="100%" border="0" cellpadding="0" cellspacing="2">
																		<tr>
																			<td style="padding:0px;border-bottom:0px;text-align:center;">
																				<?$int_Ini_Table_Width=600;?>
																				<a href="javascript:fnc_Img_View(<?=mysql_result($arr_Get_Data,$int_J,conf_seq)?>, <?=mysql_result($arr_File_Data,$int_J,SEQ)?>, '<?=mysql_result($arr_File_Data,$int_J,SKEY)?>', <?=mysql_result($arr_File_Data,$int_J,IMG_F_WIDTH)?>, <?=mysql_result($arr_File_Data,$int_J,IMG_F_HEIGHT)?>);"><img src="egofiledata.php?bd=<?=mysql_result($arr_Get_Data,$int_J,conf_seq)?>&iseq=<?=mysql_result($arr_File_Data,$int_J,SEQ)?>&ikey=<?=mysql_result($arr_File_Data,$int_J,SKEY)?>" width="<?
																														$int_Tmp = ($int_Ini_Table_Width/100)*99;
																														If (mysql_result($arr_File_Data,$int_J,IMG_F_WIDTH)>$int_Tmp) {
																															echo $int_Tmp;
																														}Else{
																															echo mysql_result($arr_File_Data,$int_J,IMG_F_WIDTH);
																														}
																													?>"></a>
																			</td>
																		</tr>
																		<?
																			If (mysql_result($arr_File_Data,$int_J,F_TITLE)!="") {
																		?>
																		<tr><td style="padding:0px;border-bottom:0px;"><img src="<?=$str_Board_Icon_Img?>ic_pen.gif" align="absMiddle"> <font color="#000000"><b><?=Fnc_Conv_View(mysql_result($arr_File_Data,$int_J,F_TITLE), 0)?></b></font></td></tr>
																		<?
																			}
			
																			If (mysql_result($arr_File_Data,$int_J,F_CONT)!="") {
																		?>
																		<tr><td style="padding:0px;border-bottom:0px;"><font color="#000000"><?=Fnc_Conv_View(mysql_result($arr_File_Data,$int_J,F_CONT), 0)?></font></td></tr>
																		<?
																			}
																		?>
																	</table>
											              		</td>
											              	</tr>
															<?
															}
														}

														}
													}
													//	= 이미지 미리보기 종료
													// =======================================
												?>
                                   	   			<tr>
                                   	   				<td style="padding:0px;border-bottom:0px;text-align:left;">
														<?
															$str_Tmp = Fnc_Conv_View(stripslashes(mysql_result($arr_Get_Data,$int_I,bd_cont)), mysql_result($arr_Get_Data,$int_I,bd_format));

															$str_Tmp = js_escape($str_Tmp);
														?>
														<SCRIPT LANGUAGE="JavaScript">
														<!--
															document.write(unescape('<?=$str_Tmp?>'));
														//-->
														</SCRIPT>
                                   	   				</td>
                                   	   			</tr>

                                   	   		</table>	
										</p>
									</td>
								</tr>
								<?
								$article_num--;
								if($article_num==0){
									break;
								}
								?>
								<?}?>
								<?}else{?>
								<tr>
									<td colspan="5" align="center" valign="middle" height="200">이용후기 내역이 없습니다.</td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>

					<div class="position_w mt30">
						<div class="paging02 ">
							<?=Fnc_Output_Page_Num1($int_Total_Page, $str_Pg, $int_Out_Page_Cnt, $int_St_Num, $str_Url)?>
						</div>
						<p class="p_r"><a href="/boad/bd_free/2m/egolist.php?bd=2" class="btn btn_m btn_bk w100">후기 남기기</a></p>
					</div>

	</form>
	
<?include "inc/inc_btm.php";?>
