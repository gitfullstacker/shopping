	/* ++++++++++++++++++++++++++++++++++++
		웹 에디터 지원 스크립트
	*/
	var str_Icon_Path = "/pub/image/edit/";		// --- 아이콘 이미지 경로
	var str_With_Path = "/pub/editor/";			// --- 관련 브라우저 경로
	var int_Edit_Mode = 0;	// --- 0 : text, 1 : html, 2 : html + <br>, 9 : editor
	var arr_Use_Image_Exe = new Array('jpg', 'gif', 'bmp', 'png');		// --- 등록 가능한 이미지 파일 배열

	var strIframeHeader = '<STYLE>body{font-family:돋움;font-size:9pt;LINE-HEIGHT:normal;TEXT-DECORATION:none; BORDER:#6F6F6F 1px solid; PADDING:3px;margin:0;}P{margin-top:3px;margin-bottom:3px;}td{font-family:돋움;font-size:9pt;}</STYLE>';
	var str_Mouse_Blank = '<BODY oncontextmenu="return false">';
	var str_Editor_Menu_Style = ' class="editor_btn_def" width="18" align="center" style="cursor:hand;" onmousedown="fnc_Editor_Event(this, \'editor_btn_down\');" onmouseup="fnc_Editor_Event(this, \'editor_btn_over\');" onmouseover="fnc_Editor_Event(this, \'editor_btn_over\');" onmouseout="fnc_Editor_Event(this, \'editor_btn_def\');" ';

	document.write("<style>");
	document.write(".editor_btn_menu{border-width:1px;border-style:solid;border-color:white gray gray white;background-color:#DDDDDD;FONT-FAMILY:돋움;FONT-SIZE:9pt;}");
	document.write(".editor_btn_def{border-width:1px;border-style:solid;border-color:#DDDDDD #DDDDDD #DDDDDD #DDDDDD;}");
	document.write(".editor_btn_over{border-width:1px;border-style:solid;border-color:white gray gray white;background-color:#DDDDDD;FONT-FAMILY:돋움;FONT-SIZE:9pt;}");
	document.write(".editor_btn_down{border-width:1px;border-style:solid;border-color:gray white white gray;background-color:#DDDDDD;FONT-FAMILY:돋움;FONT-SIZE:9pt;}");
	document.write(".sel_Css{FONT-FAMILY:돋움;FONT-SIZE:8pt;}");
	document.write(".mtx_Css{textarea{font-size:10pt;border-width:1px;border-style:solid;background-image:url("+str_Icon_Path+"line.gif);background-position:left top;background-repeat:repeat;background-attachment:scroll;font-family:돋움;}");
	document.write("</style>");

	var arr_Feel_Icon = new Array();
	arr_Feel_Icon[0] = new Array(str_Icon_Path + "face01.gif", '좋음');
	arr_Feel_Icon[1] = new Array(str_Icon_Path + "face02.gif", '나쁨');
	arr_Feel_Icon[2] = new Array(str_Icon_Path + "face03.gif", '기쁨');
	arr_Feel_Icon[3] = new Array(str_Icon_Path + "face04.gif", '보통');
	arr_Feel_Icon[4] = new Array(str_Icon_Path + "face05.gif", '놀람');
	arr_Feel_Icon[5] = new Array(str_Icon_Path + "face06.gif", '당황');

	var arr_Pre_Feel_Icon = new Array();
	for(var i=0; i<arr_Pre_Feel_Icon.length; i++)
	{
		arr_Pre_Feel_Icon[i] = new Image();
		arr_Pre_Feel_Icon[i].src = arr_Feel_Icon[i][0];
	}

	var arr_Edit_Icon = new Array();
	arr_Edit_Icon[0] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[1] = new Array(str_Icon_Path + "ed_undo.gif", 'fncCmdExec(\'Undo\');', '되돌리기');
	arr_Edit_Icon[2] = new Array(str_Icon_Path + "ed_redo.gif", 'fncCmdExec(\'Redo\');', '다시실행');
	arr_Edit_Icon[3] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[4] = new Array(str_Icon_Path + "ed_cut.gif", 'fncCmdExec(\'Cut\');', '자르기');
	arr_Edit_Icon[5] = new Array(str_Icon_Path + "ed_copy.gif", 'fncCmdExec(\'Copy\');', '복사');
	arr_Edit_Icon[6] = new Array(str_Icon_Path + "ed_paste.gif", 'fncCmdExec(\'Paste\');', '붙이기');
	arr_Edit_Icon[7] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[8] = new Array(str_Icon_Path + "ed_bold.gif", 'fncCmdExec(\'Bold\');', '볼드체');
	arr_Edit_Icon[9] = new Array(str_Icon_Path + "ed_italic.gif", 'fncCmdExec(\'Italic\');', '이텔릭체');
	arr_Edit_Icon[10] = new Array(str_Icon_Path + "ed_underline.gif", 'fncCmdExec(\'Underline\');', '밑줄');
	arr_Edit_Icon[11] = new Array(str_Icon_Path + "ed_fontbg.gif", 'fncSetConvert(1);', '글배경색');
	arr_Edit_Icon[12] = new Array(str_Icon_Path + "ed_fontcolor.gif", 'fncSetConvert(2);', '글자색');
	arr_Edit_Icon[13] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[14] = new Array(str_Icon_Path + "ed_left.gif", 'fncCmdExec(\'JustifyLeft\');', '왼쪽정렬');
	arr_Edit_Icon[15] = new Array(str_Icon_Path + "ed_center.gif", 'fncCmdExec(\'JustifyCenter\');', '가운데정렬');
	arr_Edit_Icon[16] = new Array(str_Icon_Path + "ed_right.gif", 'fncCmdExec(\'JustifyRight\');', '오른쪽정렬');
	arr_Edit_Icon[17] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[18] = new Array(str_Icon_Path + "ed_ordered.gif", 'fncCmdExec(\'InsertOrderedList\');', '번호매기기');
	arr_Edit_Icon[19] = new Array(str_Icon_Path + "ed_unordered.gif", 'fncCmdExec(\'InsertUnOrderedList\');', '글머리기호');
	arr_Edit_Icon[20] = new Array(str_Icon_Path + "ed_outdent.gif", 'fncCmdExec(\'Outdent\');', '내어쓰기');
	arr_Edit_Icon[21] = new Array(str_Icon_Path + "ed_indent.gif", 'fncCmdExec(\'Indent\');', '들여쓰기');
	arr_Edit_Icon[22] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[23] = new Array(str_Icon_Path + "ed_hr.gif", 'fncCmdExec(\'InsertHorizontalRule\');', '선긋기');
	arr_Edit_Icon[24] = new Array(str_Icon_Path + "ed_btable.gif", 'fncSetConvert(0);', '테이블생성');
	arr_Edit_Icon[25] = new Array(str_Icon_Path + "ed_hyperlink.gif", 'fncCmdExec(\'CreateLink\');', '하이퍼링크');
	arr_Edit_Icon[26] = new Array(str_Icon_Path + "ed_divide.gif", null, null);
	arr_Edit_Icon[27] = new Array(str_Icon_Path + "ed_prev.gif", 'fncPreview();', '미리보기');
	arr_Edit_Icon[28] = new Array(str_Icon_Path + "ed_print.gif", 'fncPrintMode();', '인쇄하기');

	var arr_Pre_Edit_Icon = new Array();
	for(var i=0; i<arr_Pre_Edit_Icon.length; i++)
	{
		arr_Pre_Edit_Icon[i] = new Image();
		arr_Pre_Edit_Icon[i].src = arr_Edit_Icon[i][0];
	}


	function fnc_Editor_Event(it, cls)
	{
		it.className=cls;
	}

	function fncFocus()
	{
		html_Editor.focus();
	}

	function fncCmdExec(cmd, val, it)
	{
		fncFocus();
		try
		{
			var obj_Ed_Doc = html_Editor.document;
			var obj_Ed_Range = obj_Ed_Doc.body.createTextRange();
			var obj_Ed_Cur = obj_Ed_Doc.selection.createRange();

			switch(cmd)
			{
				case "FontName": case "FontSize":
					it.selectedIndex=0;
					obj_Ed_Cur.execCommand(cmd, 0, val);
					break;
				case "Undo": case "Redo":
					obj_Ed_Doc.execCommand(cmd);
					break;
				case "CreateLink":
					obj_Ed_Doc.execCommand(cmd, 1);
					break
				default:
					obj_Ed_Cur.execCommand(cmd, false);
					break;
			}
		}
		catch(e){alert(e);}
		finally{fncFocus();}
	}

	/* ++++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 웹에디터에 이미지 등록 함수
		입력값 : val[이미지파일의경로]
		출력값 : 이미지 파일의 HTML 태그 반환
	\* ++++++++++++++++++++++++++++++++++++++++ */
	function fncImageAdd(val)
	{
		if(int_Edit_Mode!=9)
		{
			alert("에디터 모드에서만 이미지를 등록하실 수 있습니다.");
			return false;
		}

		var arr_Img = val.split(".");
		var bln_Flag = false;
		for(var i=0; i<arr_Use_Image_Exe.length; i++)
		{
			if(arr_Use_Image_Exe[i]==arr_Img[arr_Img.length-1])
			{
				bln_Flag = true;
				break;
			}
		}
		if(!bln_Flag)
		{
			alert("등록가능한 이미지파일이 아닙니다.");
			return bln_Flag;
		}

		if((int_Edit_Mode==9) && (val!=""))
		{
			fncFocus();
			try
			{
				var objRange = html_Editor.document.selection.createRange();
				 //onclick="fncImageAdd('+i+');"
				//objRange.pasteHTML('<img src="'+arr_Feel_Icon[val][0]+'" border="0" align="absMiddle">');
				objRange.pasteHTML('<img src="'+val+'" border="0" align="absMiddle">');
			}catch(e){alert(e);}
			finally{fncFocus();}
		}else{
			alert("ERROR");
		}
	}




	function fncSetConvert(val, form, i_Name)
	{
		var int_Bd = 0;
		try
		{
			int_Bd = form.bd.value;
		}catch(e){}

		var str_Add = "";
		try
		{
			str_Add = form.elements[i_Name].value;
		}catch(e){}

		if(int_Edit_Mode!=9)
		{
			alert("에디터 모드에서만 기능을 사용하실 수 있습니다.");
			return false;
		}

		var objLay = eval('layAddBrow');
		var intFrmWidth;
		var intFrmHeight;
		var strUrl = "";
		var bln_Flag = true;

		switch(val)
		{
			case 0:		// 테이블 생성
				intFrmWidth = 250;
				intFrmHeight = 190;
				objLay.style.posLeft = objLay.style.posLeft-intFrmWidth;
				strUrl = str_With_Path + "make_table.html";
				break;
			case 1:
				intFrmWidth = 250;
				intFrmHeight = 220;
				strUrl = str_With_Path + "font_bgcolor.html";
				break;
			case 2:
				intFrmWidth = 250;
				intFrmHeight = 220;
				strUrl = str_With_Path + "font_fgcolor.html";
				break;
			case 3:		// --- 이미지 생성
				intFrmWidth = 250;
				intFrmHeight = 220;
				strUrl = str_With_Path + "img_set.html?bd="+int_Bd+"&str="+str_Add;
				break;
			default:
				break;
		}

		if(bln_Flag)
		{
			with(objLay)
			{
				style.posTop = event.clientY+document.body.scrollTop;
				style.posLeft = event.clientX+document.body.scrollLeft;
				style.zIndex = 100;
				style.display = "";
			}

			objLay.innerHTML = '<iframe id="iframeAddBrow" width="'+intFrmWidth+'" height="'+intFrmHeight+'" frameborder="0" scrolling="no"></iframe>';

			var objIfrm = eval('iframeAddBrow');
			objIfrm.location.href = strUrl;
		}
	}

	function fncPrintMode()
	{
		try{
			window.frames.html_Editor.focus();
			window.frames.html_Editor.print();
		}catch(e){}
		finally{}
	}

	function fncPreview()
	{
		var str_Tag = "";
		try{
			objWin = window.open("", "", "width=600,height=400,top=10,left=10,toolbar=no,menubar=no,status=no,resizable=yes,scrollbars=yes");
			if(objWin !=null)
			{
				str_Tag = html_Editor.document.documentElement.outerHTML;
				str_Tag = str_Tag.replace(str_Mouse_Blank, '');
				str_Tag = fncConvLink(str_Tag);
				try
				{
					str_Tag = str_Tag.replace('</HEAD>', '</HEAD><table width="'+int_Doc_Width+'" border="0" cellpadding="0" cellspacing="0"><tr><td>');
					str_Tag = str_Tag.replace('</BODY>', '</td></tr></table></BODY>');
				}catch(e){}
				objWin.document.write(str_Tag);
			}
		}catch(e){}
		finally{}
	}

	function fncConvLink(strVal)
	{
		var regLink = new RegExp('<A href="', 'ig');
		return strVal.replace(regLink, '<A target="_blank" href="');
	}

	/*function fncConvHtml(strVal)
	{
		var regBr = new RegExp("\r\n","gi");
		var regBrP = new RegExp("\r\n<P>","gi");
		//var regBrTable = new RegExp("([^<|^<\/][TA|TB|TD|TR]*[>])(<BR>)","gi");
		var regBrTable = new RegExp("([^<|^<\/][T(A|B|D|R)]*[>])(<BR>)","gi");
		//strVal = strVal.replace(/\r\n<P>/, "<P>");
		//strVal = strVal.replace(/\r\n/, "<BR>");
		var regStyle = new RegExp("<STYLE>.*<\/STYLE>","gi");
		strVal = strVal.replace(regStyle, "");
		strVal = strVal.replace(regBrP, "<P>");
		strVal = strVal.replace(regBr, "<BR>");
		strVal = strVal.replace(regBrTable, "$1");
		return strIframeHeader + str_Mouse_Blank + strVal;
		fncFocus();
	}*/
	function fncConvHtml(strVal)
	{
		//var regBr = new RegExp("\r\n","gi");
		var regStyle = new RegExp("<STYLE>.*<\/STYLE>","gi");
		//var regBrTable = new RegExp("([^<|^<\/][T(A|B|D|R)]*[>])(<BR>)","gi");
		//strVal = strVal.replace(regBr, "<BR>");
		strVal = strVal.replace(regStyle, "");
		//strVal = strVal.replace(regBrTable, "$1");
		if((strVal.substring(0, 4)=="\r\n")||(strVal.substring(0, 4)=="<BR>"))
			strVal = strVal.substring(4, strVal.length);
		return strIframeHeader + str_Mouse_Blank + strVal;
		fncFocus();
	}

	/*function fncConvText(strVal, type)
	{
		var regBr = new RegExp("<BR>","gi");
		var regBrP = new RegExp("(<P>)(.*)(<\/P>)","gi");
		//var regScript = new RegExp("<(SCRIPT)(.*)<\/SCRIPT>","gi");
		var regScript = new RegExp("(<SCRIPT).*(<\/SCRIPT>)","gi");
		var F = strVal.indexOf(str_Mouse_Blank)+35;
		var L = strVal.lastIndexOf("</BODY>");
		strVal = strVal.substring(F, L);
		strVal = strVal.replace(regScript, "");
		//strVal = strVal.replace(/<BR>/, "\r\n");
		if(type==0){
			strVal = strVal.replace(regBrP, "$2");
			strVal = strVal.replace(regBr, "\r\n");
		}
		if(type==1)
		{
			strVal = strVal.replace("\r\n", "<BR>");
			if(strVal.substring(0, 8)=='<BR><BR>')
				strVal = strVal.substring(8, strVal.length);
		}
		strVal = fncConvLink(strVal);

		return strVal;
	}*/
	function fncConvText(strVal, type)
	{
		var regBrP = new RegExp("(<P>)(.*)(<\/P>)","gi");
		var regScript = new RegExp("(<SCRIPT).*(<\/SCRIPT>)","gi");

		var regBody = new RegExp("<BODY[^<]*>","gi");//<B>[^<]*<\B>
		strVal = strVal.replace(regBody, "<BODY>");

		var regSpan = new RegExp("(<SPAN[^<]*>)(.*)<\/SPAN>","gi");//<B>[^<]*<\B>
		strVal = strVal.replace(regSpan, "$2");
		
		var regStyle = new RegExp("<STYLE>.*<\/STYLE>","gi");
		strVal = strVal.replace(regStyle, "");

		var F = strVal.indexOf("<BODY>")+6;
		var L = strVal.lastIndexOf("</BODY>");
		strVal = strVal.substring(F, L);

		var regStyle = new RegExp("<STYLE>.*<\/STYLE>","gi");
		strVal = strVal.replace(regStyle, "");
		strVal = strVal.replace(regScript, "");
		strVal = strVal.replace(regBrP, "$2<BR>");

		if((strVal.substring(0, 4)=="\r\n")||(strVal.substring(0, 4)=="<BR>"))
			strVal = strVal.substring(4, strVal.length);
		strVal = fncConvLink(strVal);

		return strVal;
	}

	function fncCngMode(fArea, vArea, vIframe, mode)
	{
		var extWrite;

		if(mode>0)	// text => html
		{
			extWrite = fArea.value;
			fArea.value = "";

			vArea.style.display="none";
			vIframe.style.display="";
			vIframe.innerHTML='<iframe scrolling="yes" src="about:blank" name="I_Editor" id="html_Editor" style="width:100%;height:300px;"></iframe>';

			html_Editor.document.designMode = 'on';
			html_Editor.document.open();
			html_Editor.document.write(fncConvHtml(extWrite));
			html_Editor.document.close();
			fncFocus();
		}
		else	// html => text
		{
			extWrite = html_Editor.document.documentElement.outerHTML;
			vIframe.style.display="none";
			vArea.style.display="";
			fArea.value=(fncConvText(extWrite, 0));
			fArea.focus();
		}
	}
	/*
		웹 에디터 지원 스크립트
	++++++++++++++++++++++++++++++++++++ */

	/* ++++++++++++++++++++++++++++++++++++
		폰트 선택 콤보박스 출력
	*/
	function fnc_Editor_Font_Select()
	{
		var arr_Font_Family = new Array();
		arr_Font_Family[0] = "굴림";
		arr_Font_Family[1] = "굴림체";
		arr_Font_Family[2] = "돋움";
		arr_Font_Family[3] = "돋움체";
		arr_Font_Family[4] = "궁서";
		arr_Font_Family[5] = "궁서체";
		arr_Font_Family[6] = "바탕";
		arr_Font_Family[7] = "바탕체";
		arr_Font_Family[8] = "Arial Black";
		arr_Font_Family[9] = "Courier New";
		arr_Font_Family[10] = "Impact";
		arr_Font_Family[11] = "Lucida Sans Unicode";
		arr_Font_Family[12] = "Verdana";
		arr_Font_Family[13] = "Webdings";
		arr_Font_Family[14] = "Wingdings";

		var str_Sel_Font = "";
		str_Sel_Font +=	'<select name="sel_Font" class="sel_Css" size="1" onChange="fncCmdExec(\'FontName\', this.value, this)">'+
						'<option value="">폰트</option>';
						for (var i=0; i<arr_Font_Family.length; i++)
						{
							str_Sel_Font += '<option value="'+arr_Font_Family[i]+'">'+arr_Font_Family[i]+'</option>';
						}
						str_Sel_Font +=	'</select>';

		return str_Sel_Font;
	}

	/* ++++++++++++++++++++++++++++++++++++++
		폰트 크기 선택 콤보박스 출력
	*/
	function fnc_Editor_Font_Size()
	{
		var str_Sel_Font_Size = "";
		str_Sel_Font_Size +=	'<select name="sel_Font" class="sel_Css" size="1" onChange="fncCmdExec(\'FontSize\', this.value, this);">'+
								'<option value="">크기</option>';
								for (var i=1; i<8; i++)
								{
									str_Sel_Font_Size += '<option value="'+i+'">'+i+'</option>';
								}
								str_Sel_Font_Size += '</select>';
		return str_Sel_Font_Size;
	}

	/* ++++++++++++++++++++++++++++++++++++++
		기분 선택 아이콘 출력
	*/
	function fnc_Feel_Icon()
	{
		var str_Feel_Icon = "";
		str_Feel_Icon +=	'<table border="0" cellpadding="2" cellspacing="0">'+
							'<tr>'+
							'<td><img src="'+arr_Edit_Icon[0][0]+'" align="absMiddle" border="0"></td>'+
							'<td style="font-size:9pt;">기분 : </td>';
							for (var i=0; i<arr_Feel_Icon.length; i++)
							{
								str_Feel_Icon += '<td '+str_Editor_Menu_Style+' title="'+arr_Feel_Icon[i][1]+'"><img src="'+arr_Feel_Icon[i][0]+'" align="absMiddle" border="0" onclick="fncImageAdd(this.src);"></td>';
							}
							str_Feel_Icon +=	'</tr></table>';
		return str_Feel_Icon;
	}


	/* ++++++++++++++++++++++++++++++++++++++
		에디터 기능 선택 아이콘 출력
	*/
	function fnc_Edit_Function()
	{
		var str_Edit_Function = "";
		var str_Event = "";
		var str_Title = "";

		str_Edit_Function +=	'<table border="0" cellpadding="2" cellspacing="0">'+
								'<tr>';
								for (var i=0; i<arr_Edit_Icon.length; i++)
								{
									str_Event = (arr_Edit_Icon[i][1]!=null)? ' onclick="'+arr_Edit_Icon[i][1]+'" ': '';
									str_Title = (arr_Edit_Icon[i][2]!=null)? ' title="'+arr_Edit_Icon[i][2]+'" ': '';
									str_Edit_Function += (arr_Edit_Icon[i][1]!=null)? '<td '+str_Editor_Menu_Style+' '+str_Title+' '+str_Event+'>': '<td>';
									str_Edit_Function += '<img src="'+arr_Edit_Icon[i][0]+'" '+str_Title+' align="absMiddle" border="0">';
									str_Edit_Function += (arr_Edit_Icon[i][1]!=null)? '</td>': '</td>';
								}
								str_Edit_Function +=	'</tr></table>';
		return str_Edit_Function;
	}

	/* +++++++++++++++++++++++++++++++++++++++
		첫번째 에디터 메뉴 출력
	*/
	function fnc_We_First_Menu()
	{
		var str_Fir_Menu = '';
		str_Fir_Menu +=	'<table border="0" cellpadding="1" cellspacing="0" width="100%">'+
						'<tr>'+
						'<td class="editor_btn_menu">'+
							'<table border="0" cellpadding="0" cellspacing="0">'+
							'<tr>'+
							'<td width="5" align="right"><img src="'+arr_Edit_Icon[0][0]+'" align="absMiddle" border="0"></td>'+
							'<td width="5"></td>'+
							'<td width="5">'+fnc_Editor_Font_Select()+'</td>'+
							'<td width="5"></td>'+
							'<td width="5">'+fnc_Editor_Font_Size()+'</td>'+
							'<td width="5"></td>'+
							'<td>'+fnc_Feel_Icon()+'</td>'+
							'</tr>'+
							'</table>'+
						'</td>'+
						'</tr>'+
						'</table>';
		return str_Fir_Menu;
	}


	/* +++++++++++++++++++++++++++++++++++++++
		두번째 에디터 메뉴 출력
	*/
	function fnc_We_Second_Menu()
	{
		var str_Sec_Menu = '';
		str_Sec_Menu +=	'<table border="0" cellpadding="1" cellspacing="0" width="100%">'+
						'<tr>'+
						'<td class="editor_btn_menu">'+
						fnc_Edit_Function()+
						'</td>'+
						'</tr>'+
						'</table>';
		return str_Sec_Menu;
	}

	/* +++++++++++++++++++++++++++++++++++++++++
		입력 포멧 변환
	*/
	function fncCngType(it, form, fSel, fInput, fArea, menu, vArea, vIframe)
	{
		var objMenu = eval(menu);
		var objTextArea = eval(vArea);
		var objIframe = eval(vIframe);
		
		try
		{
			if(document.forms[form].elements[fSel].disabled==true)
			{
				document.forms[form].elements[fSel].disabled=false;
				document.forms[form].elements[fSel].style.background="#FFFFFF";
				it.style.color="#000000";
				objMenu.style.display="none";
				it.innerHTML = '<img src="'+str_Icon_Path+'editor.gif" align="absMiddle"> editor';
				fncCngMode(document.forms[form].elements[fArea], objTextArea, objIframe, 0);
				//int_Edit_Mode = document.forms[form].elements[fSel].value;
				fnc_Editor_Format(form, fInput, 0);
			}
			else
			{
				document.forms[form].elements[fSel].disabled=true;
				document.forms[form].elements[fSel].selectedIndex=0;
				document.forms[form].elements[fSel].style.background="#DCDCDC";
				it.style.color="blue";
				objMenu.style.display="";
				it.innerHTML = '<img src="'+str_Icon_Path+'text.gif" align="absMiddle">&nbsp;&nbsp;text';
				fncCngMode(document.forms[form].elements[fArea], objTextArea, objIframe, 1);
				fnc_Editor_Format(form, fInput, 9);
			}
		}
		catch(e)
		{
			alert(e);
		}
	}

	/* ++++++++++++++++++++++++++++++++++++ *\
		문서 포멧 설정 변환
	\* ++++++++++++++++++++++++++++++++++++ */
	function fnc_Editor_Format(pr_Form, pr_Input, pr_Val)
	{
		document.forms[pr_Form].elements[pr_Input].value = pr_Val;
		int_Edit_Mode = pr_Val;
	}

	/* ++++++++++++++++++++++++++++++++++++
		브라우저 정보 출력
		브라우저가 Internet Explorer 5 이상이라면 true 반환
	*/
	function fnc_Brow_Info()
	{
		var str_Brow_Name = navigator.appName;
		var str_Brow_Ver = navigator.appVersion;
		var flt_Ver = 0;

		if(str_Brow_Name.indexOf('Microsoft')>-1)
			flt_Ver = parseFloat(str_Brow_Ver.split(';')[1].split(' ')[2]);

		return flt_Ver;
	}

	/* +++++++++++++++++++++++++++++++++++++
		웹에디터 메뉴 출력
		사용 예) document.write(fnc_Out_Editor_Menu('폼이름', '문서포멧형식전송폼이름', '멀티텍스트박스폼이름'));
		데이터 전송시 필수적으로 입력할 코드
		cf)		function fnc_Eb_Send(pr_Form, pr_Mtx)
				{
					var tmpType = null;
					var str_Send_Html = "";

					pr_Form.elements[pr_Mtx].wrap = "soft";
					if(int_Edit_Mode==9)
					{
						str_Send_Html = fncConvText(html_Editor.document.documentElement.outerHTML, 1);
						str_Send_Html = (str_Send_Html.indexOf(strIframeHeader)>-1)? str_Send_Html: strIframeHeader+str_Send_Html;
						pr_Form.elements[pr_Mtx].innerText = str_Send_Html;
					}
				}
	*/
	function fnc_Out_Editor_Menu(pr_Form_Name, pr_Format_Input, pr_Mtx_Name)
	{
		var str_Edit_Head = '';
		var str_Edit_Tail = '';
		var str_Sel_Format = '';

		str_Edit_Head +=	'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>';
		str_Edit_Tail +=	'</td></tr></table>';

		str_Sel_Format +=	'<table border="0" cellpadding="0" cellspacing="0" width="100%">'+
							'<tr>'+
								'<td>'+
									'<input type="hidden" name="'+pr_Format_Input+'" value="'+int_Edit_Mode+'">'+
									'<select name="sel_Editor_Format"  class="sel_Css" size="1" style="width:100;" onchange="fnc_Editor_Format(\''+pr_Form_Name+'\', \''+pr_Format_Input+'\', this.options[options.selectedIndex].value);">'+
										'<option value="0" selected>text</option>'+
										'<option value="1">html</option>'+
										'<option value="2">html+&lt;br&gt;</option>'+
									'</select>';
		if(fnc_Brow_Info()>0)
		{
			str_Sel_Format +=	'&nbsp;<span id="ed_Type" style="cursor:hand;font-size:9pt;" onclick="fncCngType(this, \''+pr_Form_Name+'\', \'sel_Editor_Format\', \''+pr_Format_Input+'\', \''+pr_Mtx_Name+'\', \'viewEditMenu\', \'viewArea\', \'viewIframe\');" title="편집모드전환"><img src="'+str_Icon_Path+'editor.gif" align="absMiddle"> editor</span>';
		}
		
		str_Sel_Format +=	'</td></tr>';

		if(fnc_Brow_Info()>0)
			str_Sel_Format +=	'<div id="layAddBrow" style="display:none;position:absolute;"></div>';

		if(fnc_Brow_Info()>0){
			str_Sel_Format +=	'<tr id="viewEditMenu" style="display:none;">'+
									'<td>'+
										fnc_We_First_Menu()+
										fnc_We_Second_Menu()+
									'</td>'+
								'</tr>'+
								'<tr>'+
									'<td>'+
										'<span id="viewArea" style="visibility:visible;"><textarea name="'+pr_Mtx_Name+'" class="mtx_Css" cols="65" rows="18" style="width:100%;"></textarea></span>'+
										'<span id="viewIframe"></span>'+
									'</td>'+
								'</tr>';
		}else{
			str_Sel_Format +=	'<tr><td><textarea name="'+pr_Mtx_Name+'" wrap="soft" cols="65" rows="18" style="width:100%;"></textarea></td></tr>';
		}

		str_Sel_Format +=	'</table>';

		return str_Edit_Head + str_Sel_Format + str_Edit_Tail;
	}

















