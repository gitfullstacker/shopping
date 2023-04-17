<?include "inc/inc_top.php";?>
<?include "inc/ego_comm.php";?>
<?
	$int_Ini_Board_Seq = Fnc_Om_Conv_Default($_REQUEST[bd],"");
	$str_goodcode = Fnc_Om_Conv_Default($_REQUEST[str_goodcode],"");
?>
<?include "inc/ego_bd_ini.php";?>
<?
	$int_Bd_Seq = Fnc_Om_Conv_Default($_REQUEST[seq],"");	// --- 선택한 게시물 순번

	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//	= 읽기 전용 게시판이라면 관리자 이외의 글쓰기 거부 시작
	If ($arr_Ini_Board_Info[0][8]<2) {
		If ($bln_Cur_Writer==False) {
			echo "<Script Language='JavaScript'>alert('글 작성 권한이 없습니다.');document.location.replace('egolist.php?bd=$int_Ini_Board_Seq');</Script>";
			exit;
		}
	}
	//	= 읽기 전용 게시판이라면 관리자 이외의 글쓰기 거부 종료
	// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	// ==========================================
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 시작
	$int_Mode = Fnc_Om_Conv_Default($_REQUEST[mode],"0");  // --- int_Mode [0:신규글작성, 1:글수정, 2:답변글쓰기]
	$str_String = Fnc_Om_Conv_Default($_REQUEST[txt_String],"");
	$str_Doc_Pwd = Fnc_Om_Conv_Default($_REQUEST[txt_Pwd],"");

	If ($str_String=="") {
		$str_String = "?".$loc_I_Pg_Dstr;
	}
	//	= 수정, 답글쓰기 관련 설정값 변수에 저장 종료
	// ==========================================

	// ============================================================
	//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 시작
	If ($int_Mode==2 && $arr_Ini_Board_Info[0][9]==0) {
		echo "<Script Language='JavaScript'>alert('답글쓰기가 불가능한 게시판 입니다.');document.location.replace('egolist.php?bd=$int_Ini_Board_Seq');</Script>";
		exit;
	}
	//	= 답변 글쓰기가 불가능한 게시판이라면 답글쓰기 거부 종료
	// ============================================================

	// ===============================
	//	= 잘못 등록된 파일 및 데이터 삭제 시작

	$Sql_Query = " SELECT
					1 AS TYPE,
					A.IMG_SEQ AS SEQ,
					A.IMG_F_NICK AS F_NICK,
					B.CONF_SEQ,
					B.CONF_TB_NAME,
					B.CONF_ATT_URL
				FROM
					`".$Tname."b_img_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN
					".$Tname."b_conf_bd AS B
					ON
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					DATE_ADD(NOW(), INTERVAL -5 HOUR) > A.IMG_REG_DATE
					AND
					A.BD_SEQ=0
				UNION ALL
				SELECT
					0 AS TYPE,
					A.FILE_SEQ AS SEQ,
					A.FILE_F_NICK AS F_NICK,
					B.CONF_SEQ,
					B.CONF_TB_NAME,
					B.CONF_ATT_URL
				FROM
					`".$Tname."b_file_data".$str_Ini_Group_Table."` AS A
					LEFT JOIN
					".$Tname."b_conf_bd AS B
					ON
					A.CONF_SEQ=B.CONF_SEQ
				WHERE
					DATE_ADD(NOW(), INTERVAL -5 HOUR) > A.FILE_REG_DATE
					AND
					A.BD_SEQ=0 ";


	$arr_Del_File = mysql_query($Sql_Query);
	$arr_Del_File_Cnt=mysql_num_rows($arr_Del_File);

	if($arr_Del_File_Cnt){
		for($int_I = 0 ;$int_I < $arr_Del_File_Cnt; $int_I++) {
			// =======================================================
			//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 시작
			If (mysql_result($arr_Del_File,$int_I,TYPE)=="0") {
				$str_Db_Type = "FILE";
			}Else{
				$str_Db_Type = "IMG" ;
			}
			//	= 이미지 파일일때 이미지 테이블 아닐때 파일테이블 설정 종료
			// =======================================================


			$Temp = mysql_result($arr_Del_File,$int_I,CONF_ATT_URL).mysql_result($arr_Del_File,$int_I,CONF_SEQ)."/" ;
			$str_Add_Tag = $_SERVER[DOCUMENT_ROOT].$Temp;
			Fnc_Om_File_Delete($str_Add_Tag, mysql_result($arr_Del_File,$int_I,F_NICK));

			$Sql_Query = "DELETE FROM `".$Tname."b_".$str_Db_Type."_data".$str_Ini_Group_Table."` WHERE ".$str_Db_Type."_SEQ=".mysql_result($arr_Del_File,$int_I,SEQ);
			$result=mysql_query($Sql_Query);

		}
	}
	//	= 잘못 등록된 파일 및 데이터 삭제 종료
	// ===============================

	// ===============================
	//	= 잘못 등록된 게시물 삭제 시작
	$Sql_Query =	" DELETE FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE BD_ID_KEY IS NULL AND BD_IDX IS NULL AND DATE_ADD(NOW(), INTERVAL -1 HOUR) > BD_REG_DATE ";
	$result=mysql_query($Sql_Query);
	//	= 잘못 등록된 게시물 삭제 종료
	// ===============================

	// =========================================
	//	유일키값 생성 시작
	$str_Id_Key = Fnc_Om_Id_Key_Create();	//' --- 유일한 키값 생성
	//	유일키값 생성 종료
	// =========================================

	// =========================================
	//	= 전체 게시판 유무 확인 시작
	If ($bln_Main_Bd) {
		If ($int_Bd_Seq>0) {
			$Sql_Query = "SELECT CONF_SEQ FROM `".$Tname."b_bd_data".$str_Ini_Group_Table."` WHERE BD_SEQ=".$int_Bd_Seq;
			$result=mysql_query($Sql_Query);
			$int_Ini_Board_Seq = mysql_result($result,0,CONF_SEQ);
		}Else{
			$int_Ini_Board_Seq = $int_Main_Bd;
		}
	}
	//	= 전체 게시판 유무 확인 종료
	// =========================================

	// =================================================
	//	= 글수정일경우 배열에 데이터 저장 시작
	If ($int_Bd_Seq>0) {
		$Sql_Query =	" SELECT
						A.BD_SEQ,
						A.CONF_SEQ,
						A.BD_ID_KEY,
						A.BD_IDX,
						A.BD_ORDER,
						A.BD_LEVEL,
						A.BD_NOTICE_YN,
						A.MEM_CODE,
						A.MEM_ID,
						A.BD_W_NAME,
						A.BD_W_EMAIL,
						A.BD_W_IP,
						A.BD_TITLE,
						A.BD_CONT,
						A.BD_PWD,
						A.BD_FORMAT,
						A.BD_THUMB_YN,
						A.BD_OPEN_YN,
						A.BD_DEL_YN,
						A.BD_ITEM1,
						A.BD_ITEM2,
						B.STR_GOODNAME
					FROM `"
						.$Tname."b_bd_data".$str_Ini_Group_Table."` AS A LEFT JOIN `".$Tname."comm_goods_master` AS B ON A.BD_ITEM1=B.STR_GOODCODE
					WHERE A.CONF_SEQ=".$int_Ini_Board_Seq." AND A.BD_SEQ=".$int_Bd_Seq;

		$obj_Rlt = mysql_query($Sql_Query);
		$rcd_cnt=mysql_num_rows($obj_Rlt);

		if($rcd_cnt){
			$arr_Get_Data = array();
			while($row = mysql_fetch_array($obj_Rlt)) {
		  		array_push($arr_Get_Data, $row);
			}
		}

		If (is_array($arr_Get_Data)) {
			$bln_Flag = True;
		}
	}
	//	= 글수정일경우 배열에 데이터 저장 종료
	// =================================================

	// ============================================
	//	= 글 수정 및 답변 글쓰기 정보 변수에 저장 시작
	$int_Re_Idx = 0;
	$int_Re_Order = 0;
	$int_Re_Level = 0 ;
	$str_Title = "";
	$str_Cont = "";
	$int_Format = 0;

	switch ($int_Mode) {
		case 1 :	// @@@ 글수정
			If ($arr_Get_Data[0][8]=="" && $bln_Cur_Admin==False) {
				If ($arr_Get_Data[0][14]==$str_Doc_Pwd) {
					$bln_Cur_Writer = True;
				}Else{
					echo "<Script Language='JavaScript'>alert('암호가 일치하지 않습니다.');document.location.replace(document.referrer);</Script>";
					$bln_Cur_Writer = False;
					exit;
				}
			}ElseIf ($arr_Get_Data[0][8]!="" && $bln_Cur_Admin==False) {
				If ($arr_Get_Data[0][8]==$arr_Auth[0]) {
					$bln_Cur_Writer = True;
				}Else{
					echo "<Script Language='JavaScript'>alert('글 작성자만 글수정이 가능합니다.');document.location.replace(document.referrer);</Script>";
					$bln_Cur_Writer = False;
					exit;
				}
			}
			break;
		case 2 :	// @@@ 답변글쓰기
			$int_Re_Idx = $arr_Get_Data[0][3];
			$int_Re_Order = $arr_Get_Data[0][4] ;
			$int_Re_Level = $arr_Get_Data[0][5] ;
			$str_Title = "[Re]" . stripslashes($arr_Get_Data[0][12]);
			$str_Cont = $arr_Get_Data[0][13];
			$int_Format = $arr_Get_Data[0][15];
			$bln_Flag = False;
			break;
		default :
			$bln_Flag = False;
			break;
	}
	//	= 글 수정 및 답변 글쓰기 정보 변수에 저장 종료
	// ============================================

	// ============================================
	//	= 신규 글등록일때 배열에 값 설정 시작
	If ($bln_Flag == False) {
		$arr_Get_Data[0][21] = array();
		$arr_Get_Data[0][0] = 0;
		$arr_Get_Data[0][1] = $int_Ini_Board_Seq;
		$arr_Get_Data[0][2] = $str_Id_Key;
		$arr_Get_Data[0][3] = $int_Re_Idx;
		$arr_Get_Data[0][4] = $int_Re_Order;
		$arr_Get_Data[0][5] = $int_Re_Level;
		$arr_Get_Data[0][6] = 0;
		$arr_Get_Data[0][7] = "";
		$arr_Get_Data[0][8] = "";
		$arr_Get_Data[0][9] = "";
		$arr_Get_Data[0][10] = "";
		$arr_Get_Data[0][11] = "";
		$arr_Get_Data[0][12] = $str_Title;
		$arr_Get_Data[0][13] = "";
		$arr_Get_Data[0][14] = "";
		$arr_Get_Data[0][15] = 0;
		$arr_Get_Data[0][16] = $int_Ini_Img_Prev;
		$arr_Get_Data[0][17] = 1;
		$arr_Get_Data[0][18] = 0;
		$arr_Get_Data[0][19] = $str_goodcode;
		$arr_Get_Data[0][20] = "1";
		$arr_Get_Data[0][21] = "";

		If ($arr_Auth[0]!="") {
			$arr_Get_Data[0][8] = $arr_Auth[0];
		}
		If ($arr_Auth[2]!="") {
			$str_Tmp = $arr_Auth[2];
			If ($gbl_U_Info_Nick!="") {
				$str_Tmp = $gbl_U_Info_Nick;
			}
			$arr_Get_Data[0][9] = $str_Tmp;
		}
		If ($arr_Auth[6]!="") {
			$arr_Get_Data[0][10] = $arr_Auth[6];
		}
	}
	//	= 신규 글등록일때 배열에 값 설정 종료
	// ============================================
?>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT ="-1">
<SCRIPT LANGUAGE="JavaScript" SRC="ego_ini.html"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var int_Doc_Width = '<?=$int_Ini_Table_Width?>';
	var str_Deny_File = '<?=Trim($arr_Ini_Board_Info[0][13])?>';
	var str_String = '<?=$str_String?>';
	var str_Cur_Path = '<?=substr($gbl_Cur_Path_Page, 0, strrpos($gbl_Cur_Path_Page, "/")+1)?>';
	document.write('<L'+'I'+'NK rel="stylesheet" HREF="'+gbl_Str_Comm_Path+'css/egobd.css" TYPE="text/css">');
	document.write('<SCR'+'I'+'PT LANGUAGE="JavaScript" SRC="'+gbl_Str_Comm_Path+'js/egobd/comm.js"><\/SCRIPT>');
	document.write('<SCR'+'I'+'PT LANGUAGE="JavaScript" SRC="'+gbl_Str_Comm_Path+'editor/editor.js"><\/SCRIPT>');
//-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var obj_Blank = new Function("x", "return fncCheckBlank(x)");
	var obj_Alert = new Function("x", "y", "z", "return fncFocusAlert(x, y, z)");
	var obj_Byte = new Function("x", "y", "z", "return fncChkByte(x, y, z)");
	var obj_Digit = new Function("x", "return fncCheckDigit(x)");
	var obj_Email = new Function("x", "return fnc_Email_Conf(x)");

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 입력 라인 점선으로 분리
		반환값 : str_Devide_Html[라인분리HTML태그]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Line_Divide()
	{
		var str_Divide_Html = '';
		str_Divide_Html =	'<tr>'+
							'<td colspan="2" style="background-image:url('+gbl_Str_Comm_Image+'board/line_dot.gif);">'+
							'</td>'+
							'</tr>';
		return str_Divide_Html;
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 입력 취소
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Eb_Cancel(pr_Form)
	{
		var obj_Form = pr_Form;
		var int_Bd = obj_Form.bd.value;

		var str_Ref = document.referrer;
		var str_Move_Page = "";

		if(str_Ref=="")
			str_Move_Page = 'egolist.php';
		else
			str_Move_Page = str_Ref.substring(str_Ref.lastIndexOf("/")+1, str_Ref.lastIndexOf(".php")+4)

		if(str_Move_Page.indexOf("ego")<0)
			str_Move_Page = 'egolist.php';

		var str_Param = "";
		try
		{
			if(str_String!="")
				str_Param = str_String;
			else
				str_Param = location.search;

			if(str_Param=="")
				str_Param = '?bd='+obj_Form.bd.value;
		}
		catch(e){}
		document.location.replace(str_Move_Page+str_Param);
	}

	/* +++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 폼 전송
		반환값 : true | false[전송|거부]
	\* +++++++++++++++++++++++++++++++++++++++ */
	function fnc_Eb_Send(pr_Form, pr_Mtx)
	{
		var tmpType = null;
		var str_Send_Html = "";
		var int_Byte = 0;
		var obj_Form = pr_Form;

		if(!obj_Blank(obj_Form.txt_Name.value))
			return obj_Alert(obj_Form.txt_Name, null, "이름을 입력하세요.");

		int_Byte = obj_Byte(obj_Form.txt_Name, null, 20);
		if(int_Byte>20)
			return obj_Alert(obj_Form.txt_Name, null, "이름은 20 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");

		/*if(obj_Blank(obj_Form.txt_Email.value))
		{
			if(!obj_Email(obj_Form.txt_Email.value))
				return obj_Alert(obj_Form.txt_Email, null, "올바른 이메일 형식이 아닙니다.");
		}*/

		if(!obj_Blank(obj_Form.txt_Subject.value))
			return obj_Alert(obj_Form.txt_Subject, null, "글제목을 입력하세요.");

		int_Byte = obj_Byte(obj_Form.txt_Subject, null, 200);
		if(int_Byte>200)
			return obj_Alert(obj_Form.txt_Subject, null, "글제목은 200 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");

//		if(!obj_Blank(obj_Form.txt_Mem_Id.value))
//		{
//			try
//			{
				if(typeof(obj_Form.txt_Pwd)=="object")
				{
					if(!obj_Blank(obj_Form.txt_Pwd.value))
						return obj_Alert(obj_Form.txt_Pwd, null, "글암호를 입력하세요.");

					if((obj_Form.txt_Pwd.value.length)<4)
						return obj_Alert(obj_Form.txt_Pwd, null, "글암호는 4자 이상 입력하셔야 합니다.");
				}
//			}catch(e){}
//		}

		if (document.frm_File.fil_File_Data.value!="") {
			alert("파일 등록을 먼저 눌러주세요.");
			return;
		}


		/*
		obj_Form.elements[pr_Mtx].wrap = "soft";

		if(int_Edit_Mode==9)
		{
			str_Send_Html = fncConvText(html_Editor.document.documentElement.outerHTML, 1);
			obj_Form.elements[pr_Mtx].innerText = str_Send_Html;
		}

		int_Byte = obj_Byte(obj_Form.elements[pr_Mtx], null, 100000);

		if(int_Byte>100000)
			return obj_Alert(obj_Form.elements[pr_Mtx], null, "글내용은 100000 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");
		*/


		//if(int_Byte>100000)
		//	return obj_Alert(obj_Form.elements[pr_Mtx], null, "글내용은 100000 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");

		oEditors.getById["mtx_Content"].exec("UPDATE_CONTENTS_FIELD", []);
		obj_Form.method		= "post";
		obj_Form.encoding	= "application/x-www-form-urlencoded";
		obj_Form.target		= "_self";
		obj_Form.action		= "egosave.php";
		obj_Form.submit();
	}

	/* +++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 첨부 이미지 저장/수정/삭제
	\* +++++++++++++++++++++++++++++++++++++++++++ */
	function fnc_Image_Save(pr_Form, pr_Lbl, pr_Sel, pr_Type)
	{
		var obj_Form = document.forms[pr_Form];
		var obj_Sel = obj_Form.elements[pr_Sel];
		var int_Type = parseInt(pr_Type);

		if(pr_Type<2)
		{
			//if((obj_Form.fil_File_Data.disabled==true) && (int_Type==0))
			if((document.getElementById('fil_File_Data').disabled==true) && (int_Type==0))
			{
				alert("현재 편집모드 입니다.\n\n선택취소를 선택 하신 후 이미지를 등록하세요.");
				return false;
			}

			if((int_Type==1) && (obj_Form.txt_File_Idx.value==""))
			{
				alert("수정할 파일이 선택되지 않았습니다.");
				return false;
			}

			var int_Byte = 0;
			int_Byte = obj_Byte(obj_Form.txt_File_Subject, null, 200);
			if(int_Byte>200)
				return obj_Alert(obj_Form.txt_File_Subject, null, "이미지 제목은 200 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");

			int_Byte = obj_Byte(obj_Form.mtx_File_Content, null, 500);
			if(int_Byte>500)
				return obj_Alert(obj_Form.mtx_File_Content, null, "이미지 설명은 500 Byte이상 입력할 수 없습니다.\n\n현재 : "+int_Byte+" Byte");

			//if(!obj_Blank(obj_Form.fil_File_Data.value) && (int_Type==0))
			if(!obj_Blank(document.getElementById('fil_File_Data').value) && (int_Type==0))
				return obj_Alert(obj_Form.fil_File_Data, null, "이미지 파일이 선택되지 않았습니다.");

			//var str_File_Name = obj_Form.fil_File_Data.value;
			var str_File_Name = document.getElementById('fil_File_Data').value;
			str_File_Name = str_File_Name.substring(str_File_Name.lastIndexOf("\\")+1, str_File_Name.length);

			// @@@@@@ 등록 거부 파일 등록거부 처리 시작
			var arr_Deny_File = str_Deny_File.split(",");
			var str_File_Ext = "";
			if(str_File_Name.indexOf('.')>-1)
			{
				var str_File_Ext = str_File_Name.substring(str_File_Name.lastIndexOf('.')+1, str_File_Name.length);
			}

			try
			{
				for(var int_I=0; i<arr_Deny_File.length; i++)
				{
					if((str_File_Ext==arr_Deny_File[int_I])&&(arr_Deny_File[int_I]!=""))
					{
						alert(str_Deny_File+" 파일은 등록하실 수 없습니다.");
						return false;
					}
				}
			}catch(e){}
			// 등록 거부 파일 등록거부 처리 종료 @@@@@@

			var str_Pattern = /[\\/:*?\"<>|%]/;
			if(str_Pattern.test(str_File_Name))
			{
				alert("파일이름에 \\ / : * ? \" < > | % 문자는 올 수 없습니다.");
				return false;
			}
		}
		else
		{
			if(obj_Sel.options.selectedIndex<0)
			{
				alert("삭제할 파일을 선택하세요.");
				return false;
			}

			if((obj_Sel.options[obj_Sel.options.selectedIndex].value)=="")
			{
				alert("등록된 파일이 존재하지 않습니다.");
				return false;
			}

			var str_Img_Data = obj_Sel.options[obj_Sel.options.selectedIndex].text;

			if(confirm((obj_Sel.options.selectedIndex+1)+" 번째 \""+str_Img_Data+"\" 파일을 삭제하시겠습니까?")==false)
				return false;
		}

		obj_Form.txt_Forms.value = pr_Lbl+"|"+pr_Form+"|"+pr_Sel;

		var obj_Lbl = eval(pr_Lbl);
		with(obj_Lbl)
		{
			style.posTop = event.clientY+document.body.scrollTop;
			style.posLeft = event.clientX+document.body.scrollLeft;
			style.zIndex = 100;
			style.display = "";
		}

		var str_Url = '';
		var str_Enc_Type = '';
		switch(pr_Type)
		{
			case 0:
				intFrmWidth = 160;
				intFrmHeight = 80;
				str_Enc_Type = "multipart/form-data";
				str_Url = 'egofilesave.php';
				break
			case 1:
				intFrmWidth = 0;
				intFrmHeight = 0;
				str_Enc_Type = "application/x-www-form-urlencoded";
				str_Url = 'egofileedit.php';
				break
			case 2:
				intFrmWidth = 0;
				intFrmHeight = 0;
				str_Enc_Type = "application/x-www-form-urlencoded";
				str_Url = 'egofiledel.php';
				break;
			default:
				break;
		}

		/*theFeats =   "height=120,width=500,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no";
		theUniqueID = (new Date()).getTime() % 1000000000;
		window.open("/pub/inc/cm_ego_bar.php?ID=" + theUniqueID, theUniqueID, theFeats);

		var str_Url = '';
		str_Url = 'egofilesave.php?ID=' + theUniqueID;*/

		var str_Add_Frame = '';
		if(parseInt(pr_Type)==0)
		{
			str_Add_Frame = '<iframe src="egofileprogress.html" width="'+intFrmWidth+'" height="'+intFrmHeight+'" frameborder="0" scrolling="no"></iframe>';
			intFrmWidth = 0;
			intFrmHeight = 0;
		}

		obj_Lbl.innerHTML = '<iframe name="lbl_Image_Iframe" id="lbl_Image_Iframe_Id" src="about:blank" width="'+intFrmWidth+'" height="'+intFrmHeight+'" frameborder="0" scrolling="no"></iframe>'+str_Add_Frame;

		//obj_Lbl.innerHTML = '<iframe name="lbl_Image_Iframe" id="lbl_Image_Iframe_Id" src="about|blank" width="'+intFrmWidth+'" height="'+intFrmHeight+'" frameborder="0" scrolling="no"></iframe>';

		obj_Form.method="post";
		obj_Form.encoding=str_Enc_Type;
		obj_Form.target="lbl_Image_Iframe";
		obj_Form.action=str_Url;
		obj_Form.submit();
		
		document.frm_File.reset();
	}

	/* +++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 선택한 파일 수정모드로 변환 또는 취소
	\* +++++++++++++++++++++++++++++++++++++++++++ */
	function fnc_File_Edit_Mode(pr_Obj_Form_Name, pr_Str_Lbl_Name, pr_Int_Type)
	{
		var obj_Form = pr_Obj_Form_Name;
		var obj_Sel = obj_Form.sel_Att_File;
		var obj_Lbl = eval(pr_Str_Lbl_Name);
		var str_Value = "";
		var arr_Img_Info;

		if(pr_Int_Type>0)
		{
			if(obj_Sel.selectedIndex<0)
			{
				alert("수정할 파일을 선택하세요.");
				return false;
			}
			if(obj_Sel[obj_Sel.options.selectedIndex].value=="")
			{
				alert("첨부 파일을 등록하세요.");
				return false;
			}

			str_Value = obj_Sel.options[obj_Sel.options.selectedIndex].value;

			arr_Img_Info = str_Value.split("|");

			int_File_Type = arr_Img_Info[6];
			obj_Form.txt_File_Type.value = int_File_Type;

			/*arr_Mime = unescape(arr_Img_Info[6]).split("/");
			if(arr_Mime[0]=="image")
				obj_Form.txt_File_Type.value = 1;
			else
				obj_Form.txt_File_Type.value = 0;*/

			obj_Form.txt_File_Idx.value = unescape(arr_Img_Info[0]);
			obj_Form.txt_File_Subject.value = unescape(arr_Img_Info[3]);
			obj_Form.mtx_File_Content.value = unescape(arr_Img_Info[4]);
			obj_Lbl.innerHTML = '<input type="hidden" name="fil_File_Data" id="fil_File_Data" size="0" disabled><img src="'+gbl_Str_Comm_Image+'board/ic_file.gif" align="absMiddle">&nbsp;'+unescape(arr_Img_Info[5]);
		}
		else
		{
			obj_Form.txt_File_Idx.value = "";
			obj_Form.txt_File_Type.value = "";
			obj_Form.txt_File_Subject.value = "";
			obj_Form.mtx_File_Content.value = "";
			obj_Lbl.innerHTML = '<input type="file" class="input_basic" name="fil_File_Data" id="fil_File_Data" size="52">';
		}
	}

	function fnc_Edit_Append(pr_Obj_Form, pr_Sel_Name, pr_Txt_Desc)
	{
		var obj_Form = pr_Obj_Form;
		var obj_Sel = pr_Obj_Form.elements[pr_Sel_Name];

		if(obj_Sel.selectedIndex<0)
		{
			alert("에디터에 등록할 파일을 선택하세요.");
			return false;
		}
		if(obj_Sel[obj_Sel.selectedIndex].value=="")
		{
			alert("파일을 등록하세요.");
			return false;
		}
		var str_Value = obj_Sel[obj_Sel.selectedIndex].value;
		var arr_Value = str_Value.split("|");
		var int_Img = parseInt(arr_Value[6]);

		if(int_Img>0)
		{
			obj_Form.elements[pr_Txt_Desc].value = arr_Value[0]+"|"+arr_Value[1]+"|"+arr_Value[3]+"|"+arr_Value[5]+"|"+arr_Value[6]+"|"+arr_Value[8]+"|"+arr_Value[9]+"|"+str_Cur_Path;
			fncSetConvert(3, obj_Form, pr_Txt_Desc);
		}
		else
			alert("등록할 수 없는 파일입니다.");
	}
//-->
</SCRIPT>
<script type="text/javascript" src="/_lib/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<?include "inc/inc_mid.php";?>

				<form name="frm_Send">
				<input type="hidden" name="txt_Forms">
				<input type="hidden" name="mode" value="<?=$int_Mode?>">
				<input type="hidden" name="txt_String" value="<?=$str_String?>">
				<input type="hidden" name="seq" value="<?=$arr_Get_Data[0][0]?>">
				<input type="hidden" name="bd" value="<?=$arr_Get_Data[0][1]?>">
				<input type="hidden" name="txt_Id_Key" value="<?=$arr_Get_Data[0][2]?>">
				<input type="hidden" name="txt_Idx" value="<?=$arr_Get_Data[0][3]?>">
				<input type="hidden" name="txt_Order" value="<?=$arr_Get_Data[0][4]?>">
				<input type="hidden" name="txt_Level" value="<?=$arr_Get_Data[0][5]?>">
				<input type="hidden" name="txt_Mem_Code" value="<?=$arr_Get_Data[0][7]?>">
				<input type="hidden" name="txt_Mem_Id" value="<?=$arr_Get_Data[0][8]?>">
				<input type="hidden" name="str_goodcode" value="<?=$arr_Get_Data[0][19]?>">

			
					<div class="t_cover02 mt50">
						<table class="t_type01">
							<colgroup>
								<col style="width:20%;" />
								<col style="width:30%;" />
								<col style="width:20%;" />
								<col style="width:30%;" />
							</colgroup>
							<tbody>
								<?
								$SQL_QUERY =	" SELECT
												A.*,B.STR_CODE AS STR_BRAND
											FROM "
												.$Tname."comm_goods_master AS A
												LEFT JOIN
												".$Tname."comm_com_code AS B
												ON
												A.INT_BRAND=B.INT_NUMBER
											WHERE
												A.STR_GOODCODE='".$arr_Get_Data[0][19]."' ";

								$arr_Rlt_Data=mysql_query($SQL_QUERY);

								if (!$arr_Rlt_Data) {
						    		echo 'Could not run query: ' . mysql_error();
						    		exit;
								}
								$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
								?>
								<tr>
									<th class="left">이용가방</th>
									<td class="left" colspan="3">
										<div class="prd_bx">
											<p class="img" style="width:120px;height:120px;">
												<?if ($arr_Data['STR_IMAGE1']!=""){?><img src="/admincenter/files/good/<?=$arr_Data['STR_IMAGE1']?>" style="width:120px;height:120px;" alt="" /><?}else{?>&nbsp;<?}?>
											</p>
											<div class="f_bd f_bk">
												<p><?=$arr_Data['STR_CODE']?></p>
												<p><?=$arr_Data['STR_GOODNAME']?></p>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th class="left">아이디</th>
									<td class="left line_r">
										<?=$arr_Auth[0]?>
									</td>
									<th class="left">성명</th>
									<td class="left">
										<?
											// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
											//	= 사용자 이름 출력 시작
											If ($arr_Get_Data[0][9]=="") {
										?>
										<input type="text" name="txt_Name" style="width:161px;" maxlength="20" value="" class="board_input">
										<?
											}Else{
										?>
										<?=$arr_Get_Data[0][9]?><input type="hidden" name="txt_Name" value="">
										<?
											}
											//	= 사용자 이름 출력 종료
											// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
										?>
										<SCRIPT LANGUAGE="JavaScript">
										<!--
											document.forms["frm_Send"].elements["txt_Name"].value = unescape('<?=js_escape($arr_Get_Data[0][9])?>');
										//-->
										</SCRIPT>
									</td>
								</tr>
								<tr>
									<th class="left">만족도</th>
									<td class="left" colspan="3">
										<input type="radio" value="1" name="txt_item2" class=null <?If ($arr_Get_Data[0][20]=="1") {?> checked<?}?>> <img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" />
										<input type="radio" value="2" name="txt_item2" class=null <?If ($arr_Get_Data[0][20]=="2") {?> checked<?}?>> <img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" />
										<input type="radio" value="3" name="txt_item2" class=null <?If ($arr_Get_Data[0][20]=="3") {?> checked<?}?>> <img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" />
										<input type="radio" value="4" name="txt_item2" class=null <?If ($arr_Get_Data[0][20]=="4") {?> checked<?}?>> <img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star0.gif" alt="" />
										<input type="radio" value="5" name="txt_item2" class=null <?If ($arr_Get_Data[0][20]=="5") {?> checked<?}?>> <img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" /><img src="/images/board/icn_star1.gif" alt="" />
									</td>
								</tr>
								<tr>
									<th class="left">제목</th>
									<td class="left f_bk f_bd" colspan="3">
										<input type="text" name="txt_Subject" style="width:470px;" maxlength="200" value="" class="inp01 w580">
										<SCRIPT LANGUAGE="JavaScript">
										<!--
											document.forms["frm_Send"].elements["txt_Subject"].value = unescape('<?=js_escape(stripslashes($arr_Get_Data[0][12]))?>');
										//-->
										</SCRIPT>
									</td>
								</tr>
								<input type="hidden" name="chk_Pre_View" value="<?=$arr_Get_Data[0][16]?>">
								<tr>
									<th class="left">내용</th>
									<td class="left" colspan="3">
										<p>
											<textarea name="mtx_Content" id="mtx_Content" rows="10" cols="100" style="width:100%; height:412px; display:none;"><?php echo stripslashes($arr_Get_Data[0][13]); ?></textarea>
											<script type="text/javascript">
											var oEditors = [];
											
											// 추가 글꼴 목록
											//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
											
											nhn.husky.EZCreator.createInIFrame({
												oAppRef: oEditors,
												elPlaceHolder: "mtx_Content",
												sSkinURI: "/_lib/smart/SmartEditor2Skin.html",	
												htParams : {
													bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
													bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
													bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
													//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
													fOnBeforeUnload : function(){
														//alert("완료!");
													}
												}, //boolean
												fOnAppLoad : function(){
											
												},
												fCreator: "createSEditor2"
											});
											</script>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
								
						</form>
						
						<form name="frm_File">
						<input type="hidden" name="txt_Forms">
						<input type="hidden" name="mode" value="<?=$int_Mode?>">
						<input type="hidden" name="txt_String" value="<?=$str_String?>">
						<input type="hidden" name="seq" value="<?=$arr_Get_Data[0][0]?>">
						<input type="hidden" name="bd" value="<?=$arr_Get_Data[0][1]?>">
						<input type="hidden" name="txt_Id_Key" value="<?=$arr_Get_Data[0][2]?>">
						<input type="hidden" name="txt_Idx" value="<?=$arr_Get_Data[0][3]?>">
						<input type="hidden" name="txt_Order" value="<?=$arr_Get_Data[0][4]?>">
						<input type="hidden" name="txt_Level" value="<?=$arr_Get_Data[0][5]?>">
						<input type="hidden" name="txt_Mem_Code" value="<?=$arr_Get_Data[0][7]?>">
						<input type="hidden" name="txt_Mem_Id" value="<?=$arr_Get_Data[0][8]?>">
						<input type="hidden" name="str_goodcode" value="<?=$arr_Get_Data[0][19]?>">
								
						<table class="t_type01">
							<colgroup>
								<col style="width:20%;" />
								<col style="width:80%;" />
							</colgroup>
							<tbody>
								
								<?If ($int_Ini_File_Att>0) {?>
								<div id="lbl_File_Add_Brow" style="display:none;position:absolute;"></div>
								<input type="hidden" name="txt_File_Idx" value="">
								<input type="hidden" name="txt_File_Type" value="">
								<input type="hidden" name="txt_File_Desc" value="">
								<tr>
									<th class="left">파일선택</th>
									<td class="left" colspan="3" id="lbl_File_Re_Write">
									<input type="file" class="inp01 w580" name="fil_File_Data" id="fil_File_Data" style="width:265px;" />
									<textarea class="textarea" name="mtx_File_Content" class="border_1" wrap="soft" cols="67" rows="2" style="display:none;"></textarea>
									
									<span class="btn btn_bk btn_m w75" align="absMiddle" style="cursor:pointer;" onclick="fnc_Image_Save('frm_File', 'lbl_File_Add_Brow', 'sel_Att_File', 0);">파일등록</span>
									</td>
								</tr>
								<tr style="display:none;">
									<th class="left">file name</th>
									<td class="left" colspan="3"><input name="txt_File_Subject" type="text" style="width:265px;" class="board_input"></td>
								</tr>
								<tr>
									<th class="left">첨부리스트</th>
									<td class="left" colspan="3">
										<select name="sel_Att_File" size="3" style="width:300px;">
											<option value="">== The attached file does not exist.</option>
										</select>
										<span class="btn btn_bk btn_m w75"  align="absMiddle" style="cursor:pointer; vertical-align:top;" onclick="fnc_Image_Save('frm_File', 'lbl_File_Add_Brow', 'sel_Att_File', 2);">파일삭제</span>
										
									</td>
								</tr>
								<?
									// ==========================================
									//	= 이미지 멀티콤보박스 재 설정 시작
									$str_Tmp = "lbl_File_Add_Brow|frm_File|sel_Att_File";
									$arr_Tmp = explode("|", $str_Tmp);
									fnc_Image_Cbo_Re_Set($arr_Tmp, $arr_Get_Data[0][2], $str_Ini_Group_Table);
									//	= 이미지 멀티콤보박스 재 설정 시작
									// ==========================================
				
									// ==========================================
									//	현재 파일 사용량 확인 시작
									$int_Cur_File_Size = fnc_Use_File_Size($str_Ini_Group_Table, $arr_Get_Data[0][2]);
									//	현재 파일 사용량 확인 종료
									// ==========================================
								?>
								<tr>
									<th class="left">파일사용량</th>
									<td class="left" colspan="3"><span id="lbl_File_Use_Graph"></span></td>
								</tr>
								<?
									// ==========================================
									//	= 파일 사용량 출력 시작
									fnc_File_Use_Graph("lbl_File_Use_Graph", $int_Ini_Perm_File_Size, $int_Cur_File_Size);
									//	= 파일 사용량 출력 종료
									// ==========================================
								?>
								<?}?>
							</tbody>
						</table>
					</div>

					<div class="center mt30">
						<a href="#;" class="btn btn_l btn_bk w w270 f_bd" style="cursor:pointer;" onclick="fnc_Eb_Send(document.frm_Send, 'mtx_Content');">확인</a>
						<a href="#;" class="btn btn_l btn_wt w w270 f_bd" style="cursor:pointer;" onclick="fnc_Eb_Cancel(document.frm_Send);">취소</a>
					</div>
					
				</form>
				
					<script type="text/javascript" src="/js/custominputfile.min.js"></script>
					<script type="text/javascript">
						$('#fil_File_Data').custominputfile({
							theme: 'blue-grey',
							//icon : 'fa fa-upload'
						});
						$('#demo-2').custominputfile({
							theme: 'red',
							icon : 'fa fa-file'
						});
					</script>


<?include "inc/inc_btm.php";?>
