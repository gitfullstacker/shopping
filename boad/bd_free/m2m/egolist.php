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
			$Sql_Add_Query .= " CONF_SEQ=".$int_Ini_Board_Seq." AND ";
		}
		// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		$Sql_Add_Query .= $str_Itm." LIKE '%".$str_Txt."%' GROUP BY BD_IDX) ";

	}
	//	= 검색 종료
	// ======================================
	
	$Sql_Add_Query .= " AND A.MEM_ID='".$arr_Auth[0]."' ";

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
					E.STR_GOODNAME,
					E.STR_IMAGE1,
					A.BD_ITEM2,
					F.STR_CODE
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
					E.STR_GOODNAME,
					E.STR_IMAGE1,
					A.BD_ITEM2,
					F.STR_CODE
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
	<input type="hidden" name="page" value="<?=$page?>">
	
			<?
			$page = Fnc_Om_Conv_Default($_REQUEST[page],1);
			$displayrow = Fnc_Om_Conv_Default($_REQUEST[displayrow],5);
			$displaypage = Fnc_Om_Conv_Default($_REQUEST[displaypage],10);
		
			$SQL_QUERY = "select count(a.int_number) from ".$Tname."comm_goods_cart a left join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode left join ".$Tname."comm_com_code c on b.int_brand=c.int_number ";
			$SQL_QUERY.="where a.str_userid='$arr_Auth[0]' and a.int_state in ('4','5','10') ";
			$SQL_QUERY.=$Str_Query;
			$result = mysql_query($SQL_QUERY);
		
			if(!result){
			   error("QUERY_ERROR");
			   exit;
			}
			$total_record = mysql_result($result,0,0);
		
			if(!$total_record){
				$first = 1;
				$last = 0;
			}else{
			  	$first = $displayrow *($page-1) ;
			  	$last = $displayrow *$page;
		
			  	$IsNext = $total_record - $last ;
			  	if($IsNext > 0){
					$last -= 1;
			  	}else{
			   		$last = $total_record -1 ;
			  	}
			}
			$total_page = ceil($total_record/$displayrow);
		
			$f_limit=$first;
			$l_limit=$last + 1 ;
			
			$SQL_QUERY = "select a.*,b.str_goodname,b.str_image1,c.str_code from ".$Tname."comm_goods_cart a left join ".$Tname."comm_goods_master b on a.str_goodcode=b.str_goodcode left join ".$Tname."comm_com_code c on b.int_brand=c.int_number ";
			$SQL_QUERY.="where a.str_userid='$arr_Auth[0]' and a.int_state in ('4','5','10') ";
			$SQL_QUERY.=$Str_Query;
			$SQL_QUERY.="order by a.dtm_indate desc ";
			$SQL_QUERY.="limit $f_limit,$l_limit";
		
			$result = mysql_query($SQL_QUERY);

			if(!$result) {
			 	error("QUERY_ERROR");
			 	exit;
			}
			$total_record_limit=mysql_num_rows($result);
			?>
			<div class="tit_h3 mt15">작성 가능한 이용 내역 </div>
			<div class="t_cover01 mt10">
				<table class="t_type01">
					<colgroup>
						<col style="width:35%;" />
						<col style="width:35%;" />
						<col style="width:30%;" />
					</colgroup>
					<thead>
						<tr>
							<th class="f_bd ">발송일/<br />이용내역번호</th>
							<th class="f_bd ">이용가방</th>
							<th class="f_bd">이용후기작성</th>
						</tr>
					</thead>
					<tbody>
						<?$count=0;?>
						<?if($total_record_limit!=0){?>
						<?$article_num = $total_record - $displayrow*($page-1) ;?>
						<?for($i = 0 ;$i <= $displayrow -1; $i++) {?>
						<tr>
							<td class="">
								<p><?=substr(mysql_result($result,$i,dtm_indate),0, 10)?></p>
								<p class="f_bk"><?=mysql_result($result,$i,int_number)?></p>
							</td>
							<td class="center">
								<div class="review_item">
									<p><?if (mysql_result($result,$i,str_image1)!=""){?><img src="/admincenter/files/good/<?=mysql_result($result,$i,str_image1)?>" style="width:60px;height:60px;" alt="" class="t_img"/><?}else{?>&nbsp;<?}?></p>
									<p class="f_bk f_bd mt07"><?=mysql_result($result,$i,str_code)?></p>
									<p class=" tit mt05"><?=mysql_result($result,$i,str_goodname)?></p>
								</div>
							</td>
							<td>
								<a href="egowrite.php<?=$str_String . $str_Pg?>&str_goodcode=<?=mysql_result($result,$i,str_goodcode)?>" class="btn btn_s btn_bk">작성하기</a>
							</td>
						</tr>
						<?$count++;?>
						<?
						$article_num--;
						if($article_num==0){
							break;
						}
						?>
						<?}?>
						<?}else{?>
						<tr>
							<td colspan="3">작성 가능한 이용 내역이 없습니다. 이용후기는 이용 후에 작성하실 수 있습니다.</td>
						</tr>
						<?}?>
						<input type="hidden" name="txtRows" value="<?=$count?>">
					</tbody>
				</table>
			</div>
			<div class="paging mt15">
				<?
				$total_block = ceil($total_page/$displaypage);
				$block = ceil($page/$displaypage);

				$first_page = ($block-1)*$displaypage;
				$last_page = $block*$displaypage;

				if($total_block <= $block) {
						$last_page = $total_page;
				}

				$file_link= basename($PHP_SELF);
				$link="$file_link?$param";

				if($page > 1) {?>
					<a href="Javascript:MovePage3('1');" class="pg_nav pg_fir"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_fir"></a>
				<?}

				if($block > 1) {
				   $my_page = $first_page;
				?>
					<a href="Javascript:MovePage3('<?=$my_page?>');" class="pg_nav pg_prev"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_prev"></a>
				<?}
				?>
				<span class="num">
				<?

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				   if($page == $direct_page) {?>
				      	<a href="#;" class="on"><?=$direct_page?></a>
				   <?} else {?>
				    	<a href="Javascript:MovePage3('<?=$direct_page?>');"><?=$direct_page?></a>
				   <?}
				}
				?>
				</span>
				<?
				if($block < $total_block) {
				   	$my_page = $last_page+1;?>
				    <a href="Javascript:MovePage3('<?=$my_page?>');" class="pg_nav pg_next"></a>
				<?}else{ ?>
					<a href="#;" class="pg_nav pg_next"></a>
				<?}

				if($page < $total_page) {?>
					<a href="Javascript:MovePage3('<?=$total_page?>');" class="pg_nav pg_last"></a>
				<?}else{?>
					<a href="#;" class="pg_nav pg_last"></a>
				<?}
				?>
			</div>
			
			<div class="tit_h3 mt25">고객님께서 작성한 이용후기</div>
			<div class="t_cover01 mt10">
				<ul class="item_list">
					<?
						for($int_I = 0 ;$int_I < $arr_Notice_Data_Cnt; $int_I++) {
					?>
					<li>
						<a href="egoread.php<?=$str_String.$str_Pg?>&seq=<?=mysql_result($arr_Notice_Data,$int_I,bd_seq)?>">
							<p class="item_img"><?if (mysql_result($arr_Notice_Data,$int_I,str_image1)!=""){?><img src="/admincenter/files/good/<?=mysql_result($arr_Notice_Data,$int_I,str_image1)?>" alt="" /><?}else{?>&nbsp;<?}?></p>
							<div class="item_info">
								<p class="f_bd f_bk"><?=mysql_result($arr_Notice_Data,$int_I,str_code)?></p>
								<p><?=mysql_result($arr_Notice_Data,$int_I,str_goodname)?></p>
								<p class="rating">
									<?if (mysql_result($arr_Notice_Data,$int_I,bd_item2)=="1"){?><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Notice_Data,$int_I,bd_item2)=="2"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Notice_Data,$int_I,bd_item2)=="3"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Notice_Data,$int_I,bd_item2)=="4"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Notice_Data,$int_I,bd_item2)=="5"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><?}?>
								</p>
								<p class="date"><?=str_replace("-", ".",substr(mysql_result($arr_Notice_Data,$int_I,bd_reg_date),0,10))?> <i class="icn icn_bar"></i> <?=mysql_result($arr_Notice_Data,$int_I,mem_id)?></p>
							</div>
						</a>
					</li>
					<?}?>
					<?if($int_Total_Cnt!=0){?>
					<?$article_num = $int_Total_Cnt - $int_Page_Size*($str_Pg-1) ;?>
					<?for($int_I = 0 ;$int_I <= $int_Page_Size -1; $int_I++) {?>
					<li>
						<a href="egoread.php<?=$str_String.$str_Pg?>&seq=<?=mysql_result($arr_Get_Data,$int_I,bd_seq)?>">
							<p class="item_img"><?if (mysql_result($arr_Get_Data,$int_I,str_image1)!=""){?><img src="/admincenter/files/good/<?=mysql_result($arr_Get_Data,$int_I,str_image1)?>" alt="" /><?}else{?>&nbsp;<?}?></p>
							<div class="item_info">
								<p class="f_bd f_bk"><?=mysql_result($arr_Get_Data,$int_I,str_code)?></p>
								<p><?=mysql_result($arr_Get_Data,$int_I,str_goodname)?></p>
								<p class="rating">
									<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="1"){?><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="2"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="3"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="4"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star00"></i><?}?>
									<?if (mysql_result($arr_Get_Data,$int_I,bd_item2)=="5"){?><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><i class="icn icn_star01"></i><?}?>
								</p>
								<p class="date"><?=str_replace("-", ".",substr(mysql_result($arr_Get_Data,$int_I,bd_reg_date),0,10))?> <i class="icn icn_bar"></i> <?=mysql_result($arr_Get_Data,$int_I,mem_id)?></p>
							</div>
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
					<li style="text-align:center;padding:20px 0;">이용후기 내역이 없습니다.</li>
					<?}?>
				</ul>
			</div>
			<div class="paging mt15">
				<?=Fnc_Output_Page_Num2($int_Total_Page, $str_Pg, $int_Out_Page_Cnt, $int_St_Num, $str_Url)?>
			</div>


	</form>
	
<?include "inc/inc_btm.php";?>
