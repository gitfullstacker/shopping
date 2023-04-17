<!--
//****************************************************************************************
//*
//*		프로그램명	: HTML 에디터 Ver2.0.0.1 JS 파일
//*		제작자		: 이원문 (Knhead , 큰머리)
//*		제작일		: 2003년 10월 13일
//*		수정		:
//*
//*		특징		: 순수 Javascript로 위직 에디터 구현
//*		저작권		: 저작권은 이원문(Knhead, 큰머리)에 있음.
//*					  소스 수정 사용시 제작자의 허락이 있어야 함.
//*					  원본 그대로 사용시는 허락 없어도 사용 가능
//*
//*		주의		: 이 소스로 인한 피해 및 손해 배상은 제작자가 아닌 사용자에게 있습니다.
//*
//****************************************************************************************


	//**	스타일 출력
		var Style	=	'<style type="text/css">\n';
			Style	+=	'	textarea			{font-size: 9pt; font-family: 굴림, 돋음; font-style:  normal; font-weight: normal;}\n';
			Style	+=	'	.Editor_Tool		{border-collapse: collapse; background-color: buttonface; margin: 0; padding: 0;}\n';
			Style	+=	'	.Editor_Btn_Default	{cursor:hand; width: 23px; height: 22px; border: 1px solid buttonface;}\n';
			Style	+=	'	.Editor_Btn_Over	{cursor:hand; width: 23px; height: 22px; border: 1px outset;}\n';
			Style	+=	'	.Editor_Btn_Down	{cursor:hand; width: 23px; height: 22px; border: 1px inset; background-color: buttonhighlight;}\n';
			Style	+=	'	.Editor_Btn_Disable	{cursor:default; width: 23px; height: 22px; border: 1px solid buttonface; filter: alpha(opacity=20);}\n';
			Style	+=	'	.Editor_Btn2_Default{cursor:hand; border: 1px solid threedface;}\n';
			Style	+=	'	.Editor_Btn2_Over	{cursor:hand; border: 1px solid #0A246A; background-color: #B6BDD2;}\n';
			Style	+=	'	.Editor_Btn2_Check	{cursor:hand; border: 1px solid #0A246A; background-color: #D4D5D8;}\n';
			Style	+=	'	.Editor_Select		{cursor:hand; border: 1px solid #808080; font-size: 9pt;}\n';
			Style	+=	'	.Editor_Separator	{border: 1px inset; width: 1px; height: 22px; margin: 0 3 0 3}\n';
			Style	+=	'</style>'

		document.write(Style);
		var Editor_Root_Dir_root = '/pub/editor/';


	/*-------------------------------------------------------------------
		펑션명	: Editor_Defaule_Config
		변수명	: EditorObjName - 에디터 객체 이름
		설명	: 에디터 기본 설정 값
	-------------------------------------------------------------------*/

		function Editor_Defaule_Config(EditorObjName){

			this.Version		=	'2.0.0.1'		//**	버전
			this.Width			=	'auto'			//**	에디터 폭
			this.Height			=	'auto'			//**	에디터 높이
			this.BodyStyle		=	'font-size: 9pt; font-family: 굴림; background-color: #FFFFFF;'		//**	에디터 Body 스타일
			this.HeightSpace	=	0				//**	에디터 버튼간 높이
			this.WidthSpace		=	0				//**	에디터 버튼간 너비
			this.ImagePath		=	 '/pub/img/editor/'		//**	에디터 그림 경로

			this.EditMod		=	0;				//**	현재 상태 (0: Text, 1:Html, 2: Preview)
			this.Debug			=	0;				//**	디버그 중 유무
			this.ReplaceBR		=	0;				//**	줄바꿈을 <BR> 로 표시

			this.StyleSheet		=	'';				//에디터 안에 들어갈 스타일 시트 파일(풀 경로[주소 포함]로 적어 주세요)

			//**	기본 스타일 시트
			this.DefaultStyle	=	  '<style type="text/css">\n'
									+ '	body	{font-size: 10pt; font-family: 굴림, 돋음; font-style:  normal; font-weight: normal;}\n'
									+ '	p		{font-size: 10pt; font-family: 굴림, 돋음; font-style:  normal; font-weight: normal;}\n'
									+ '	td		{font-size: 10pt; font-family: 굴림, 돋음; font-style:  normal; font-weight: normal;}\n'
									+ '</style>\n';

			//**	툴바 설정
			this.ToolBar		=	[
									//**	폰트이름
										['FontName'],
									//**	폰트 사이즈
										['FontSize'],
									//**	글머리 기호 및 번호 메기기
										['separator', 'InsertOrderedList', 'InsertUnOrderedList', 'Outdent', 'Indent'],
									//**	정렬
										['separator', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'],
									//**	버전 정보, 도움말
									//**  	['separator', 'Version', 'Help'],

									//**	줄바꿈
									//**		['LineBreak'],

									//**	잘라내기, 복사, 붙이기
										['Cut', 'Copy', 'Paste', 'separator'],
									//**	글자 형태
										['Bold', 'Italic', 'Underline', 'separator'],
									//**	글자색, 글자 배경색
										['ForeColor', 'BackColor', 'separator'],
									//**	가로줄, 링크, 링크 그림 삽입, 테이블 삽입
										['InsertHorizontalRule', 'CreateLink', 'InsertImage','InsertImage1', 'InsertTable', 'separator']

									]

			//**	폰트 이름 설정
				this.FontNames	=	{
					//**				'표시 이름'			:	'폰트 이름'
										'굴림체'			:	'굴림체',
										'돋움체'			:	'돋움체',
										'바탕체'			:	'바탕체',
										'궁서체'			:	'궁서체',
										'휴먼매직체'		:	'휴먼매직체',
										'휴먼옛체'			:	'휴먼옛체',
										'HY엽서L'			:	'HY엽서L',
										'HY얕은샘물M'		:	'HY얕은샘물M',
										'HY헤드라인M'		:	'HY헤드라인M',
										'Arial'				:	'arial, helvetica, sans-serif',
    									'Courier New'		:	'courier new, courier, mono',
									    'Georgia'			:	'Georgia, Times New Roman, Times, Serif',
									    'Tahoma'			:	'Tahoma, Arial, Helvetica, sans-serif',
									    'Times New Roman'	:	'times new roman, times, serif',
									    'Verdana'			:	'Verdana, Arial, Helvetica, sans-serif',
									    'impact'			:	'impact',
									    'WingDings'			:	'WingDings'
									}

			//**	폰트 크기
				this.FontSize	=	{
					//**				'표시 이름'			:	'폰트 크기'
										'1(8pt)'			:	'1',
										'2(10pt)'			:	'2',
										'3(12pt)'			:	'3',
										'4(14pt)'			:	'4',
										'5(18pt)'			:	'5',
										'6(24pt)'			:	'6',
										'7(36pt)'			:	'7'
									}

			//**	에디터 버튼 정의
				this.ButtonList	=	{
					//**				버튼 이름				:	 아이디					설명				클릭시 실행				이미지 경로
										'insertorderedlist'		:	['InsertOrderedList',	'번호메기기',		'Editor_ACT(this.id)',		'icon_numberlist.gif'],
										'insertunorderedlist'	:	['InsertUnOrderedList',	'글머리기호',		'Editor_ACT(this.id)',		'icon_balllist.gif'],
										'outdent'				:	['Outdent',				'내어쓰기',			'Editor_ACT(this.id)',		'icon_outdent.gif'],
										'indent'				:	['Indent',				'들여쓰기',			'Editor_ACT(this.id)',		'icon_indent.gif'],
										'justifyleft'			:	['JustifyLeft',			'왼쪽정렬',			'Editor_ACT(this.id)',		'icon_left.gif'],
										'justifycenter'			:	['JustifyCenter',		'가운데정렬',		'Editor_ACT(this.id)',		'icon_center.gif'],
										'justifyright'			:	['JustifyRight',		'오른쪽정렬',		'Editor_ACT(this.id)',		'icon_right.gif'],
										'bold'					:	['Bold',				'굵게',				'Editor_ACT(this.id)',		'icon_b.gif'],
										'italic'				:	['Italic',				'기울임꼴',			'Editor_ACT(this.id)',		'icon_i.gif'],
										'underline'				:	['Underline',			'밑줄',				'Editor_ACT(this.id)',		'icon_u.gif'],
										'cut'					:	['Cut',					'자르기',			'Editor_ACT(this.id)',		'icon_cut.gif'],
										'copy'					:	['Copy',				'복사하기',			'Editor_ACT(this.id)',		'icon_copy.gif'],
										'paste'					:	['Paste',				'붙여넣기',			'Editor_ACT(this.id)',		'icon_paste.gif'],
										'forecolor'				:	['ForeColor',			'글자색',			'Editor_ACT(this.id)',		'icon_fontcolor.gif'],
										'backcolor'				:	['BackColor',			'강조',				'Editor_ACT(this.id)',		'icon_backcolor.gif'],
										'inserthorizontalrule'	:	['InsertHorizontalRule','가로줄',			'Editor_ACT(this.id)',		'icon_hr.gif'],
										'createlink'			:	['CreateLink',			'하이퍼링크 삽입',	'Editor_ACT(this.id)',		'icon_link.gif'],
										'insertimage'			:	['InsertImage',			'그림 삽입',		'Editor_ACT(this.id)',		'icon_image.gif'],
										'insertimage1'			:	['InsertImage1',			'그림 삽입',		'Editor_ACT(this.id)',		'box.gif'],
										'inserttable'			:	['InsertTable',			'표 삽입',			'Editor_ACT(this.id)',		'icon_table.gif'],
										'version'				:	['Version',				'에디터 버전 정보',	'Editor_ACT(this.id)',		'icon_info.gif'],
										'help'					:	['Help',				'도움말',			'Editor_ACT(this.id)',		'icon_help.gif']
									}

		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_New_Generate
		변수명	: EditorObjName - 에디터 객체 이름
				  CustomEditorConfigObj - 에디터 설정 객체
		설명	: 에디터 초기화
		사용법	: Editor_New_Generate('Teatarea 이름', 사용자에디터설정객체명)
	-------------------------------------------------------------------*/

		function Editor_New_Generate(EditorObjName, CustomEditorConfigObj){

			//**	에디터 오브젝트 정의
				var EditorObj	=	document.all[EditorObjName];

			//**	에디터 설정 정의
				var ConfigObj	= new Editor_Defaule_Config(EditorObjName);

			//**	사용자 정의가 있을시.. 기본정의 설정에 덮어 씌우기
				if(CustomEditorConfigObj){
					for( var ParameterName in CustomEditorConfigObj){
						if(CustomEditorConfigObj[ParameterName]){
							ConfigObj[ParameterName]	= CustomEditorConfigObj[ParameterName];
						}
					}
				}

			//**	에디터 객체에 설정 탑재
				EditorObj.Config	= ConfigObj;

			//**	에디터 너비 설정
				//**	에디터의 너비가 설정 되어 있을 경우
				if(!ConfigObj.Width || ConfigObj.Width=='auto'){
					if(EditorObj.style.width)	{	ConfigObj.Width = EditorObj.style.width;	}		//**	스타일 시트에 너비 지정 되어 있을경우
					else if(EditorObj.cols)		{	ConfigObj.Width = (EditorObj.cols * 22) + 22;}		//**	Textarea의 col의 갯수만큼 너비 설정
					else						{	ConfigObj.Width = '100%';					}		//**	아무설정 없을때 너비는 100%로 설정
				}

				//**	에디터의 높이가 설정 되어 있을 경우
				if(!ConfigObj.Height || ConfigObj.Height =='auto'){
					if(EditorObj.style.height)	{	ConfigObj.Height = EditorObj.style.height;	}		//**	스타일 시트에 높이 지정 되어 있을경우
					else if(EditorObj.rows)		{	ConfigObj.Height = EditorObj.rows * 17;		}		//**	Textarea의 row의 갯수만큼 높이 설정
					else						{	ConfigObj.Height = '300';					}		//**	아무설정 없을때 높이는 300으로 설정
				}

			//**	전체적인 에디터 모양 만들기
				//**	버튼 외곽 테이블 HTML
					var HTML_Table_Open		=	'<table border="0" cellpadding="0" cellspacing="0" style="float: left;"><tr><td>';
					var HTML_Table_Close	=	'</td></tr></table>';

				//**	툴바 HTML
					var HTML_Toolbar		=	'';
					var btnGroup, btnParameter, btnName;
					var btnObjId, btnObjTitle, btnObjOnClickEvent, btnObjImgSrc

					for(btnGroup in ConfigObj.ToolBar){
						//**	줄바꿈 처리
							if(ConfigObj.ToolBar[btnGroup].length==1 && ConfigObj.ToolBar[btnGroup][0].toLowerCase()=='linebreak'){
								HTML_Toolbar	+=	'<br clear="all">';
								continue;
							}

						//**	에디터 버튼 및 선택창 처리
							//**	버튼 외곽 테이블 열기
								HTML_Toolbar	+=	HTML_Table_Open;

							for(btnParameter in ConfigObj.ToolBar[btnGroup]){
								btnName	=	ConfigObj.ToolBar[btnGroup][btnParameter].toLowerCase();		//**	버튼 이름

								//**	폰트명
								if(btnName	==	'fontname'){
									HTML_Toolbar	+=	'<select id="Editor__'+ EditorObjName +'__FontName" OnChange="Editor_ACT(this.id)" class="Editor_Select">\n';

									for(var FontName in ConfigObj.FontNames){
										HTML_Toolbar	+=	'<option value="'+ ConfigObj.FontNames[FontName] +'">'+ FontName +'</option>\n';
									}
									HTML_Toolbar	+=	'</select>';
									continue;
								}

								//**	폰트 크기
								if(btnName	==	'fontsize'){
									HTML_Toolbar	+=	'<select id="Editor__'+ EditorObjName +'__FontSize" OnChange="Editor_ACT(this.id)" class="Editor_Select">';

									for(var FontSize in ConfigObj.FontSize){
										HTML_Toolbar	+=	'<option value="'+ ConfigObj.FontSize[FontSize] +'">'+ FontSize +'</option>';
									}
									HTML_Toolbar	+=	'</select>';
									continue;
								}

								//**	세로줄
								if(btnName	==	'separator'){
									HTML_Toolbar	+=	'<span class="Editor_Separator"></span>'
									continue;
								}

								//**	버튼들
								var btnObj	=	ConfigObj.ButtonList[btnName];

									//**	버튼안에 줄바꿈 사용시 에러 메세지
									if(btnName	==	'linebreak'){
										alert('HTML생성 에러입니다.\n\n+ 에러 내용 +\n\t버튼 줄바꿈옵션[LineBreak]은 .ToolBar에서만 추가 할수 있습니다.\n\t소스를 수정 해주시기 바랍니다.\n\nHTML 위직 에디터 생성 실패.');
										return false;
									}

									//**	리스트에 없는 버튼 사용시 에러 메세지
									if(!btnObj){
										alert('HTML생성 에러입니다.\n\n+ 에러 내용 +\n\t'+ EditorObjName +'의 버튼 '+ btnName +'정보가 없습니다.\n\t소스를 수정 해주시기 바랍니다.\n\nHTML 위직 에디터 생성 실패.');
										return false;
									}

									//**	버튼 만들기
										btnObjId			=	btnObj[0];
										btnObjTitle			=	btnObj[1];
										btnObjOnClickEvent	=	btnObj[2];
										btnObjImgSrc		=	btnObj[3];

										HTML_Toolbar	+=	'<button id="Editor__'+ EditorObjName +'__'+ btnObjId +'" title="'+ btnObjTitle +'" class="Editor_Btn_Default" OnClick="javascript:'+ btnObjOnClickEvent +'" OnMouseOver="javascript:if(this.className==\'Editor_Btn_Default\'){this.className=\'Editor_Btn_Over\';}" OnMouseOut="javascript:if(this.className==\'Editor_Btn_Over\'){this.className=\'Editor_Btn_Default\';}" unselectable="on"> <img src="'+ ConfigObj.ImagePath + btnObjImgSrc +'" border="0"></button>';
							}

							//**	버튼 외곽 테이블 닫기
								HTML_Toolbar	+=	HTML_Table_Close;
					}



				//**	전체 HTML 에디터 모양 만들기
					var HTML_Editor	=	'';

						HTML_Editor	+=	'<table  class="Editor_Tool" border="1" cellpadding="1" cellspacing="0" width="'+ ConfigObj.Width+'" height="'+ ConfigObj.Height +'" style="border-collapse: collapse;"><tr><td>';
						HTML_Editor	+=	'<span id="Editor_ToolBar"><table class="Editor_Tool" border="0" cellpadding="0" cellspacing="0" width="'+ ConfigObj.Width +'" style="border-collapse: collapse;"><tr><td style=" padding-top:5; padding-left:2; padding-bottom:2;">';
						HTML_Editor	+=	HTML_Toolbar;
						HTML_Editor	+=	'</td></tr></table></span>';
						HTML_Editor	+=	'</td></tr><tr><td>';
						HTML_Editor	+=	'<textarea id="Editor__'+ EditorObjName +'__EditorPad" style="width:'+ ConfigObj.Width +'; height:'+ ConfigObj.Height +'; "></textarea>';
						HTML_Editor	+=	'</td></tr><tr><td style="height:20; padding-left:5;">';
						HTML_Editor	+=	'	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="50%">';
						HTML_Editor	+=	'		<img id="Editor__'+ EditorObjName +'__HTMLEdit" class="Editor_Btn2_Default" src="'+ ConfigObj.ImagePath +'icon_edit.gif" OnClick="javascript:Editor_ACT(this.id)" OnMouseOver="javascript:if(this.className==\'Editor_Btn2_Default\'){this.className=\'Editor_Btn2_Over\';}" OnMouseOut="javascript:if(this.className==\'Editor_Btn2_Over\'){this.className=\'Editor_Btn2_Default\';}">';
						HTML_Editor	+=	'		<img id="Editor__'+ EditorObjName +'__HTMLSource" class="Editor_Btn2_Default" src="'+ ConfigObj.ImagePath +'icon_html.gif" OnClick="javascript:Editor_ACT(this.id)" OnMouseOver="javascript:if(this.className==\'Editor_Btn2_Default\'){this.className=\'Editor_Btn2_Over\';}" OnMouseOut="javascript:if(this.className==\'Editor_Btn2_Over\'){this.className=\'Editor_Btn2_Default\';}">';
						HTML_Editor	+=	'		<img id="Editor__'+ EditorObjName +'__HTMLPreview" class="Editor_Btn2_Default" src="'+ ConfigObj.ImagePath +'icon_preview.gif" OnClick="javascript:Editor_ACT(this.id)" OnMouseOver="javascript:if(this.className==\'Editor_Btn2_Default\'){this.className=\'Editor_Btn2_Over\';}" OnMouseOut="javascript:if(this.className==\'Editor_Btn2_Over\'){this.className=\'Editor_Btn2_Default\';}">';
						HTML_Editor	+=	'	</td><td width="50%" align="right" style="padding-right:10; cursor:default;">';
						HTML_Editor	+=	'	</td></tr></table>';
						HTML_Editor	+=	'</td></tr></table>';

			//**	본문에 에디터 HTML 소스 삽입하기
				document.all[EditorObjName].insertAdjacentHTML('afterEnd', HTML_Editor);

			//**	HTML 변환이 다 끝났으면 본문의 Textare 숨기기
				if(!ConfigObj.Debug){
					document.all[EditorObjName].style.display	=	'none';
				}

				if(ConfigObj.ReplaceBR){
					var Content	=	EditorObj.value;
						Content = Content.replace(/\r\n/g, '<br>');
						Content = Content.replace(/\n/g, '<br>');
						Content = Content.replace(/\r/g, '<br>');
					EditorObj.value	=	Content
				}

			//**	HTML 에디터로 변화 시키기
				Editor_Change_Mode(EditorObjName, 1);

		}








	/*-------------------------------------------------------------------
		펑션명	: Editor_Change_Mode
		변수명	: ObjName - 에디터 객체 이름
				  ChangeMode	- 보고자 하는 모드(0:Text, 1;Html, 2:Preview)
		설명	: 에디터의 수정 모드 변화
		사용법	: Editor_Change_Mode(객체이름, 에디터 모드)
	-------------------------------------------------------------------*/

		function Editor_Change_Mode(ObjName, ChangeMode){
			var ConfigObj		=	document.all[ObjName].Config;
			var ContentObj		=	document.all[ObjName];
			var EditorObj		=	document.all['Editor__'+ ObjName +'__EditorPad'];

			//**	페이지 로딩이 다 끝났을때 처리를 위한...처리 ㅡㅡ;
				if(document.readyState != 'complete'){
					setTimeout(function(){	Editor_Change_Mode(ObjName, ChangeMode);	}, 25);
					return false;
				}

			//**	처리 모드에 따른 에디트 창들
				var TextEditor		=	'<textarea id="Editor__'+ ObjName +'__EditorPad" style="width:'+ EditorObj.style.width +'; height:'+ EditorObj.style.height +';" rows="1" cols="20"></textarea>';
				var HtmlEditor		=	'<iframe id="Editor__'+ ObjName +'__EditorPad" style="width:'+ EditorObj.style.width +'; height:'+ EditorObj.style.height +';"></iframe>';
				var PreviewEditor	=	'<iframe id="Editor__'+ ObjName +'__EditorPad" style="width:'+ EditorObj.style.width +'; height:'+ EditorObj.style.height +';"></iframe>';

			//**	처리 모드

				//**	Text 모드로 변화
					var Now_EditMode	=	ConfigObj.EditMod;

					if(ChangeMode==0 && Now_EditMode!=0){
						//**	설정 바꿈]
							ConfigObj.EditMod	=	0;

						//**	에디터 창 바꿈 설정
							var Content			=	ContentObj.value;
							EditorObj.outerHTML	=	TextEditor;
							EditorObj			=	document.all['Editor__'+ ObjName +'__EditorPad'];
							EditorObj.value		=	Content

						//**	상태 버튼 변화
							document.all['Editor__'+ ObjName +'__HTMLEdit'].className		='Editor_Btn2_Default';
							document.all['Editor__'+ ObjName +'__HTMLSource'].className		='Editor_Btn2_Check';
							document.all['Editor__'+ ObjName +'__HTMLPreview'].className	='Editor_Btn2_Default';

						//**	버튼 비활성화
							Editor_UpdatToolbar(ObjName, 'disable');


						//**	HTML 에디터의 이벤트 헨들러 설정
							EditorObj.onkeydown		=	function()	{	Editor_Event_Handlers(ObjName);	}
							EditorObj.onkeypress	=	function()	{	Editor_Event_Handlers(ObjName);	}
							EditorObj.onkeyup		=	function()	{	Editor_Event_Handlers(ObjName);	}
							EditorObj.onmouseup		=	function()	{	Editor_Event_Handlers(ObjName);	}
							EditorObj.onblur		=	function()	{	Editor_Event_Handlers(ObjName, -1);	}
							EditorObj.oncut			=	function()	{	Editor_Event_Handlers(ObjName, 100);	}
							EditorObj.ondrop		=	function()	{	Editor_Event_Handlers(ObjName, 100);	}
							EditorObj.onpaste		=	function()	{	Editor_Event_Handlers(ObjName, 100);	}

						//**	포커스 이동
							//Editor_Focus(EditorObj);

					}else if(ChangeMode==1 && Now_EditMode!=1){
						//**	설정 바꿈]
							ConfigObj.EditMod	=	1;
						//**	적용 내용 삽입
							var Content	=	ContentObj.value;

							//**	에디터 창 바꿈
								EditorObj.outerHTML	=	HtmlEditor;

							//**	에디터 오브젝트 재설정
								EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];

							//**	에디터 안에 들어갈 소스 설정
								var EditorPad_Source	=	'';
								EditorPad_Source +=	'<html><head>\n';

								//**	스타일 시트 적용
									if(ConfigObj.StyleSheet!=''){
										EditorPad_Source +=	'<link href="'+ ConfigObj.StyleSheet +'" rel="stylesheet" type="text/css">\n';
									}

								//**	기본 스타일 적용
									if(ConfigObj.DefaultStyle!=''){
										EditorPad_Source +=	ConfigObj.DefaultStyle;
									}

								//**	Body 삽입
									EditorPad_Source +=	'<body contenteditable="true" topmargin="1" leftmargin="1">\n';
								//**	내용 삽입
									EditorPad_Source +=	Content;
								//**	서식 닫기
									EditorPad_Source +=	'</body>\n</html>\n';

							//**	HTML 적용
								var EditorDoc	=	EditorObj.contentWindow.document;
									EditorDoc.open();
									EditorDoc.write(EditorPad_Source);
									EditorDoc.close();

							//**	객체 다시 적용
								EditorDoc.ObjName = ObjName;

							//**	버튼 비활성화
								Editor_UpdatToolbar(ObjName, 'enable');

							//**	HTML 에디터의 이벤트 헨들러 설정
								EditorDoc.onkeydown		=	function()	{	Editor_Event_Handlers(ObjName);	}
								EditorDoc.onkeypress	=	function()	{	Editor_Event_Handlers(ObjName);	}
								EditorDoc.onkeyup		=	function()	{	Editor_Event_Handlers(ObjName);	}
								EditorDoc.onmouseup		=	function()	{	Editor_Event_Handlers(ObjName);	}
								EditorDoc.body.onblur	=	function()	{	Editor_Event_Handlers(ObjName, -1);	}
								EditorDoc.body.oncut	=	function()	{	Editor_Event_Handlers(ObjName, 100);	}
								EditorDoc.body.ondrop	=	function()	{	Editor_Event_Handlers(ObjName, 100);	}
								EditorDoc.body.onpaste	=	function()	{	Editor_Event_Handlers(ObjName, 100);	}

							//**	포커스 이동
								//Editor_Focus(EditorObj);

						//**	상태 버튼 변화
							document.all['Editor__'+ ObjName +'__HTMLEdit'].className		='Editor_Btn2_Check';
							document.all['Editor__'+ ObjName +'__HTMLSource'].className		='Editor_Btn2_Default';
							document.all['Editor__'+ ObjName +'__HTMLPreview'].className	='Editor_Btn2_Default';

					}else if(ChangeMode==2 && Now_EditMode!=2){
						//**	설정 바꿈]
							ConfigObj.EditMod	=	2;

						//**	창 바꿈
							var PreContent		=	'<html><head>\n'
							var Content			=	ContentObj.value;

							//**	스타일 시트 적용
								if(ConfigObj.StyleSheet!=''){
									PreContent +=	'<link href="'+ ConfigObj.StyleSheet +'" rel="stylesheet" type="text/css">\n';
									}
							//**	기본 스타일 적용
								if(ConfigObj.DefaultStyle!=''){
									PreContent +=	ConfigObj.DefaultStyle;
								}

								PreContent	+= '<body contenteditable="false" topmargin="1" leftmargin="1">\n';

								Content = PreContent + Content + '</body>\n</html>\n';

							Editor_GetHTML(ObjName);
							EditorObj.outerHTML	=	PreviewEditor;
							EditorObj			=	document.all['Editor__'+ ObjName +'__EditorPad'];
							var EditorDoc = EditorObj.contentWindow.document;
								EditorDoc.open();
								EditorDoc.write(Content);
								EditorDoc.close();

							EditorDoc.designMode = 'Off';

						//**	상태 버튼 변화
							document.all['Editor__'+ ObjName +'__HTMLEdit'].className		='Editor_Btn2_Default';
							document.all['Editor__'+ ObjName +'__HTMLSource'].className		='Editor_Btn2_Default';
							document.all['Editor__'+ ObjName +'__HTMLPreview'].className	='Editor_Btn2_Check';

						//**	버튼 비활성화
							Editor_UpdatToolbar(ObjName, 'disable');
					}

		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_Focus
		변수명	: EditorObj		- 에디터 객체
		설명	: 해당 객체에 포커스를 이동
	-------------------------------------------------------------------*/
		function Editor_Focus(EditorObj){

			//**	에디터 모드 체크
				//**	Textarea 일경우
					if(EditorObj.tagName.toLowerCase() == 'textarea'){
						setTimeout(function(){	EditorObj.focus();	}, 150);								//**	약간의 딜레이를 줘서 포커스 이동

				//**	위직 에디터 모드 일경우
					}else{
						var EditorDoc			=	EditorObj.contentWindow.document;	//**	위직 에디터의 문서 객체
						var EditorRange			=	EditorDoc.body.createTextRange();		//**	에디터 Range
						var EditorCursorRange	=	EditorDoc.selection.createRange();		//**	선택 Range

						//**	선택 범위가 없고 선택 영역이 에디터 영역에 없을때.. 커서를 처음, 커서가 있던 위치로 이동
							if(EditorCursorRange.length	== null && !EditorRange.inRange(EditorCursorRange)){
								EditorRange.collapse();
								EditorRange.select();

								EditorCursorRange	=	EditorRange;
							}
					}
		}



	/*-------------------------------------------------------------------
		펑션명	: Editor_Event_Handlers
		변수명	: ObjName	- 에디터 객체 이름
				  RunDelay	- 시간 지연, -1은 바로 실행
				  EventName	- 이벤트 이름
		설명	: 에디터 이벤트 값
		사용법	: Editor_Event_Handlers(객체이름, [지연시간], [이벤트 이름])
	-------------------------------------------------------------------*/

		function Editor_Event_Handlers(ObjName, RunDelay, EventName){
			var Config		=	document.all[ObjName].Config;						//**	원본 Textarea의 설정 불러오기
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];		//**	HTML 에디터 객체 불러오기

			//**	RunDelay의 값이 없을때는 0을 자동 삽입
				if(RunDelay == null){	RunDelay=0;	}

			var EditorDoc	=	'';
			var EditorEvent	=	EditorObj.contentWindow;
				if(EditorEvent){
					EditorEvent	=	EditorObj.contentWindow.event;
				}else{
					EditorEvent	=	event;
				}

			//**	KeyPress 이벤트
				if(EditorEvent && EditorEvent.keyCode){
					var keyCode		=	EditorEvent.keyCode;
					var ctrlKey		=	EditorEvent.ctrlKey;
					var altKey		=	EditorEvent.altKey;
					var shiftKey	=	EditorEvent.shiftKey;

					if(keyCode==16){return}		//**	쉬프트키 취소
					if(keyCode==17){return}		//**	컨트롤키 취소
					if(keyCode==18){return}		//**	알트키 취소

					//**	엔터키를 <p></p>가 아닌 <br>로 대체
					if(keyCode==13 && EditorEvent.type == 'keypress'){
						EditorEvent.returnValue	=	false;
						Editor_InsertHTML(ObjName, "<br>");
					}

					//**	Undo 처리 (ctrl+z)
					if(ctrlKey && (keyCode==122 || keyCode==90)){
						EditorEvent.cancelBubble	=	true;
						return;
					}
					//**	Redo 처리(ctrl-y, ctrl-shift-z)
					if((ctrlKey && (keyCode==121 || keyCode==89)) || (ctrlKey && shiftKey && (keyCode==122 || keyCode==90))){
						return;
					}
				}

			//**	이벤트에 딜레이 시간이 있을경우
				if(RunDelay > 0){
					return setTimeout(function(){	Editor_Event_Handlers(ObjName);	}, RunDelay);
				}

			//**	지간 지연이 더 필요한 경우
				if(this.tooSoon==1 && RunDelay >= 0){
					this.queue=1;
					return;
				}

				this.tooSoon = 1;
				setTimeout(function(){
										this.tooSoon	= 0;
										if(this.queue){
											Editor_Event_Handlers(ObjName, -1);
										}
										this.queue		= 0;
									}, 333);

			//**	원본 Textarea안에 내용 저장
				Editor_UpdateOutput(ObjName);

			//**	커서가 있는 위치의 글에 적용되는 버튼들 활성화
				Editor_UpdatToolbar(ObjName);
		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_UpdateOutput
		변수명	: ObjName		- 에디터 객체 이름
		설명	: 숨어있는 원래의 Textarea의 내용을 갱신
	-------------------------------------------------------------------*/

		function Editor_UpdateOutput(ObjName){
			var Config		=	document.all[ObjName].Config;							//**	원본 Textarea의 설정 불러오기
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];			//**	HTML 에디터 객체 불러오기

			var isTextarea	=	(EditorObj.tagName.toLowerCase()=='textarea');			//**	에디트 창이 Textarea 인지 검사
			var EditorDoc	= 	isTextarea ? null : EditorObj.contentWindow.document;

			//**	위직에디터창에서 내용을 가지고옮
				var Content	=	'';

				if(isTextarea){
					Content	=	EditorObj.value;
				}else{
					Content	=	EditorDoc.body.innerHTML;
				}

			//**	내용이 수정 되었는지 여부 검사
				if(Config.lastUpdateOutput && Config.lastUpdateOutput == Content){
					return;
				}else{
					Config.lastUpdateOutput	=	Content;
				}

			//**	원본 Textarea의 내용 갱신
				document.all[ObjName].value	=	Content;
		}

	/*-------------------------------------------------------------------
		펑션명	: Editor_InsertHTML
		변수명	: ObjName		- 에디터 객체 이름
				  str1			- 삽입 문자
				  str2			- 삽입문자
				  bitSelection	- 이벤트 이름
		설명	: 해당 str을 삽입
	-------------------------------------------------------------------*/
		function Editor_InsertHTML(ObjName, str1, str2, bitSel){
			var Config		=	document.all[ObjName].Config;						//**	원본 Textarea의 설정 불러오기
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];		//**	HTML 에디터 객체 불러오기

			if(str1==null){str1='';}
			if(str2==null){str2='';}

			//**	기본 Textarea 에디트 모드일 경우
				var DefaultObj	=	document.all[ObjName];

				if(DefaultObj && EditorObj == null){
					DefaultObj.focus();
					DefaultObj.value	=	DefaultObj.value + str1 + str2;
					return;
				}

			//**	에디터 창 유무 체크
				if(EditorObj == null){
					alert('해당 문자를 삽입 할수가 없습니다.\n\n '+ ObjName +'의 이름을 가진 객체를 찾을수 없습니다.');
					return;
				}

			//**	포커스 이동
				Editor_Focus(EditorObj);

			var EditorTagName	=	EditorObj.tagName.toLowerCase();
			var EditorSelectRange;

			//**	위직 에디트 모드일 경우
				if(EditorTagName == 'iframe'){
					var EditorDoc		=	EditorObj.contentWindow.document;
					EditorSelectRange	=	EditorDoc.selection.createRange();

					var EditorSelectRangeHtml	=	EditorSelectRange.htmlText;

					//**	위치 값이 없을경우 경고 메세지
						if(EditorSelectRange.length){
							alert('해당 문자를 삽입할수가 없습니다.\n삽입 위치를 선택해 주시기 바랍니다.');
							return;
						}

					//**	위치 값이 있을경우 해당 문자 삽입
						var OldHandler	=	window.onerror;
						window.onerror	=	function(){
														alert('해당 문자를 삽입할수가 없습니다.');
														return;
													}
						if(EditorSelectRangeHtml.length){
							if(str2){
								EditorSelectRange.pasteHTML(str1 + EditorSelectRangeHtml + str2);
							}else{
								EditorSelectRange.pasteHTML(str1);
							}
						}else{
							if(bitSel){
								alert('해당 문자를 삽입할수가 없습니다.\n먼저 문자를 선택해 주시기 바랍니다.');
								return;
							}

							EditorSelectRange.pasteHTML(str1 + str2);
						}

						window.onerror	=	OldHandler;

			//**	텍스트 모드 일경우
				}else if(EditorTagName == 'textarea'){
					EditorObj.focus();

					EditorSelectObj	=	document.selection.createRange();

					var EditorSelectRangeHtml	=	EditorSelectObj.text;

					//**	문자 삽입
						if(EditorSelectRangeHtml.length){
							if(str2){
								EditorSelectRange.text	=	str1 + EditorSelectRangeHtml + str2;
							}else{
								EditorSelectRange.text	=	str1;
							}
						}else{
							if(bitSel){
								alert('문자를 삽입할수 없습니다.\n먼저 문자를 선택해 주시기 바랍니다.');
							}

							EditorSelectRange.text	= str1 + str2;
						}
				}else{
					alert('문자를 삽입할수가 없습니다.\n'+ EditorTagName +'의 에디터 창이 없습니다.');
				}

				//**	새로운 입력 값으로 이동
					EditorSelectRange.collapse(false);		//**	선택 영역의 끝으로 이동
					EditorSelectRange.select();				//**	선택 복귀
		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_GetHTML
		변수명	: ObjName		- 에디터 객체 이름
		설명	: 해당 에디터의 소스를 추출
	-------------------------------------------------------------------*/
		function Editor_GetHTML(ObjName){
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];		//**	HTML 에디터 객체 불러오기
			var isTextarea	=	(EditorObj.tagName.toLowerCase() == 'textarea');

			if(isTextarea){
				return EditorObj.value;
			}else{
				return EditorObj.contentWindow.document.body.innerHTML;
			}

		}



	/*-------------------------------------------------------------------
		펑션명	: Editor_AppendHTML
		변수명	: ObjName		- 에디터 객체 이름
				  Html			- 추가 소스
		설명	: 해당 에디터의 소스에 추가
	-------------------------------------------------------------------*/
		function Editor_AppendHTML(ObjName, Html){
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];		//**	HTML 에디터 객체 불러오기
			var isTextarea	=	(EditorObj.tagName.toLowerCase() == 'textarea');

			if(isTextarea){
				EditorObj.value += Html;
			}else{
				EditorObj.contentWindow.document.body.innerHTML += Html;
			}

		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_Detect_RGB
		변수명	: Value		- 숫자이름
		설명	: 해당 숫자를 16진수로 변화
	-------------------------------------------------------------------*/
		function Editor_Detect_RGB(Value){
			var strHex = '';

			//해당 숫자의 8진수 구하기
			var strHexByte, tmpStr1, tmpStr2;

			for(var HexNum = 0; HexNum < 3; HexNum++){
				strHexByte	=	Value & 0xFF;
				Value >>= 8;
				tmpStr2	= strHexByte & 0x0F;
				tmpStr1	= (strHexByte >> 4) & 0x0F;

				strHex	+=	tmpStr1.toString(16);
				strHex	+=	tmpStr2.toString(16);
			}

			return strHex.toUpperCase();
		}


	/*-------------------------------------------------------------------
		펑션명	: Editor_UpdatToolbar
		변수명	: ObjName		- 객체 이름
				  State			- 상태
		설명	: 해당 숫자를 16진수로 변화
	-------------------------------------------------------------------*/
		function Editor_UpdatToolbar(ObjName, State){
			var EditorObj	=	document.all['Editor__'+ ObjName +'__EditorPad'];
			var Config		=	document.all[ObjName].Config;

			//**	베튼의 활성 비활성
			if(State == 'enable' || State =='disable'){
				//**	드롭다운 메뉴 버튼 설정
					var ToolBarItems	=	new Array('FontName', 'FontSize', 'FontStyle');

				//**	버튼 목록에서 버튼 추가
					for(var btnName in Config.ButtonList){
						ToolBarItems.push(Config.ButtonList[btnName][0]);
					}

				for(var idxBtn in ToolBarItems){
					var CmdId		=	ToolBarItems[idxBtn].toLowerCase();
					var ToolBarObj	=	document.all['Editor__'+ ObjName +'__'+ ToolBarItems[idxBtn]];

					//**	에디트창 변화, 버전, 도움말 버튼은 비활성화
						if(CmdId == 'htmledit' || CmdId == 'htmlsource' || CmdId == 'htmlpreview' || CmdId == 'version' || CmdId == 'help'){
							continue;
						}

					if(ToolBarObj == null){
						continue;
					}

					var isButton	=	(ToolBarObj.tagName.toLowerCase() == 'button') ? true : false;

					if(State == 'enable'){
						ToolBarObj.disabled	= false;
						if(isButton){
							ToolBarObj.className	= 'Editor_Btn_Default';
						}
					}

					if(State == 'disable'){
						ToolBarObj.disabled	= true;
						if(isButton){
							ToolBarObj.className	= 'Editor_Btn_Disable';
						}
					}
				}

				return;
			}


			//**	버튼 갱신

				//**	텍스트 모드 일경우 갱신 금지
					if(EditorObj.tagName.toLowerCase() == 'textarea'){
						return;
					}

			var EditorDoc	=	EditorObj.contentWindow.document;

			//**	폰트명 설정
				var FontNameObj	=	document.all['Editor__'+ ObjName +'__FontName'];

				if(FontNameObj){
					var FontName	=	EditorDoc.queryCommandValue('FontName');
					if(FontName == null){
						FontNameObj.value	= null;
					}else{
						var FoundFont	= 0;

						for(i=0; i<FontNameObj.length; i++){
							if(FontName.toLowerCase() == FontNameObj[i].text.toLowerCase()){
								FontNameObj.selectedIndex	= i;
								FoundFont	= 1;
							}
						}

						//**	폰트를 못찾을 경우
						if(FoundFont != 1){
							FontNameObj.value	= null;
							FontNameObj.selectedIndex	= 0;
						}
					}
				}

			//**	폰트 크기 설정
				var FontSizeObj	=	document.all['Editor__'+ ObjName +'__FontSize'];

				if(FontSizeObj){
					var FontSize	= EditorDoc.queryCommandValue('FontSize');
					if(FontSize == null){
						FontSizeObj.value	= null;
					}else{
						var FoundFont	= 0;

						for(i=0; i<FontSizeObj.length; i++){
							if(FontSize == FontSizeObj[i].value){
								FontSizeObj.selectedIndex	= i;
								FoundFont	= 1;
							}
						}

						//**	폰트크기를 못찾았을 경우
						if(FoundFont != 1){
							FontSizeObj.value			= null;
							FontSizeObj.selectedIndex	= 1;
						}
					}
				}

			//**	폰트 스타일 설정
				var classNameObj	= document.all['Editor__'+ ObjName +'__FontStyle'];

				if(classNameObj){
					var CusorRange	= EditorObj.selection.createRange();

					//**	클레스 이름 검색
						var ParentElement

						if(CusorRange.length){
							ParentElement	= CursorRange[0];				//**	제어 테그
						}else{
							ParentElement	= CursorRange.parentElement();	//**	문자 범위
						}

						while(ParentElement && !ParentElement.className){
							ParentElement	= ParentElement.parentElement;
						}

						var thisClassName	= ParentElement ? ParentElement.classNametoLowerCase() : '';

						if(!thisClassName && classNameObj.value){
							classNameObj.value	= '';
						}else{
							var FoundClass	= 0;

							for(i=0; i<classNameObj.length; i++){
								if(thisClass == classNameObj[i].value.toLowerCase()){
									classNameObj.selectedIndex	= 1;
									FoundClass	= 1;
								}
							}

							//**	클레스이름을 못찾았을경우
								if(FoundClass != 1){
									classNameObj.value	= null;
								}
						}
				}


			//**	다른 버튼들 갱신

				var BtnIdList	= Array('Bold', 'Italic', 'Underline', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'InsertOrderedList', 'InsertUnOrderedList');

				for(i=0; i<BtnIdList.length; i++){
					var BtnObj	= document.all['Editor__'+ ObjName +'__'+ BtnIdList[i]];

					if(BtnObj == null){
						continue;
					}

					var CmdActive	= EditorDoc.queryCommandState(BtnIdList[i]);

					//**	옵션 활성화
						if(!CmdActive){
							if(BtnObj.className != 'Editor_Btn_Default'){
								BtnObj.className	= 'Editor_Btn_Default';
							}
							if(BtnObj.disableed != false){
								BtnObj.disabled	= false;
							}

					//** 옵션 비활성화
						}else if(CmdActive){
							if(BtnObj.className != 'Editor_Btn_Down'){
								BtnObj.className	= 'Editor_Btn_Down';
							}
							if(BtnObj.disableed != false){
								BtnObj.disabled	= false;
							}
						}
				}
		}
//************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************
//**
//**	에디터 버튼 이벤트
//**
//************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************

		function Editor_ACT(ButtonId){

			var Array_ObjName	=	ButtonId.split('__');

			var thisState		=	Array_ObjName[0];
			var thisObjName		=	Array_ObjName[1];
			var thisActId		=	Array_ObjName[2];

			var ButtonObj	=	document.all[ButtonId];
			var EditorObj	=	document.all['Editor__'+ thisObjName +'__EditorPad'];
			var Config		=	document.all[thisObjName].Config;


			//**	에디터 바꾸기 버튼
				//**	위직 에디터
					if(thisActId == 'HTMLEdit'){
						Editor_Change_Mode(thisObjName, 1);
						return;

				//**	소스 에디터
					}else if(thisActId == 'HTMLSource'){
						Editor_Change_Mode(thisObjName, 0);
						return;

				//**	미리보기
					}else if(thisActId == 'HTMLPreview'){
						Editor_Change_Mode(thisObjName, 2);
						return;
					}

			//**	팝업창 버튼 처리( 버전, 도움말)

				//**	버전
					if(thisActId == 'Version'){
						showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_Version.htm', 'EditorVersion', 'resizable: no; help: no; status: no; scroll: no;');
						return;
					}

				//**	도움말
					if(thisActId == 'Help'){
						showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_Help.htm', 'EditorVersion', 'resizable: no; help: no; status: no; scroll: yes;');
						return;
					}

			//**	텍스트 모드일경우 실행 취소
				if(EditorObj.tagName.toLowerCase()=='textarea'){
					return;
				}

			//**	버튼 실행 설정
				var EditorDoc	=	EditorObj.contentWindow.document;

				Editor_Focus(EditorObj);

				//**	드롭다운 메뉴 버튼의 인덱스 및 값 가지고 오기
					var ButtonIndex	=	ButtonObj.selectedIndex;
					var ButtonValue	=	(ButtonIndex != null) ? ButtonObj[ButtonIndex].value : null;

						if(false){

					//**	폰트 이름
						}else if(thisActId == 'FontName' && ButtonValue){
							EditorDoc.execCommand(thisActId, 0, ButtonValue);

					//**	폰트 크기
						}else if(thisActId == 'FontSize' && ButtonValue){
							EditorDoc.execCommand(thisActId, 0, ButtonValue);

					//**	폰트 스타일(스타일 시트의 클래스이름으로 변환)
						}else if(thisActId == 'FontStyle' && ButtonValue){
							EditorDoc.execCommand('RemoveFormat');
							EditorDoc.execCommand(thisActId, 0, '0UC7740UC6D00UBB380UCC9C0UC7AC');

							var FornArray	=	EditorDoc.all.tags("FONT");
							for(i=0; i<FontArray.length; i++){
								if(FontArray[i].face == '0UC7740UC6D00UBB380UCC9C0UC7AC'){
									FontArray[i].face		= "";
									FontArray[i].className	= ButtonValue;
									FontArray[i].outerHTML	= FontArray[i].outerHTML.replace(/face=['"]+/, "");
								}
							}
							ButtonObj.selectedIndex = 0;

					//**	글자색, 글자 배경색
						}else if(thisActId == 'ForeColor' || thisActId == 'BackColor'){
							var OldColor	= Editor_Detect_RGB(EditorDoc.queryCommandValue(thisActId));
							var NewColor	= showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_SelectColor.htm', OldColor, 'resizable: no; help: no; status: no; scroll: no;');

							if(NewColor != null && NewColor != OldColor){
								EditorDoc.execCommand(thisActId, false, NewColor);
							}
					
					
					//**	기타 글자 테그 관련 설정 적용하기
						}else{
							
							//**	하이퍼 링크
								if(thisActId == 'CreateLink'){
									EditorDoc.execCommand(thisActId, 1);
								}
							
							//**	그림 삽입하기
								else if(thisActId == 'InsertImage'){
									showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_InsertImage.htm?'+ thisObjName, window, 'resizable: no; help: no; status: no; scroll: no;');
								}

							//**	그림 삽입하기
								else if(thisActId == 'InsertImage1'){
									document.frm.Obj.value = thisObjName;
 									//CallOpenWin(Editor_Root_Dir_root + 'PopupWin/Editor_InsertImage.php'+thisObjName ,100,'no','그림삽입',530,480)
 									popupLayer('/admincenter/comm/comm_editor_list.php',500,510);
									//showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_InsertImage.asp?'+ thisObjName, window, 'dialogWidth:555px; dialogHeight:530px;','resizable: no; help: no; status: no; scroll: no;');
								}

							//**	테이블 삽입하기
								else if(thisActId == 'InsertTable'){
									showModalDialog(Editor_Root_Dir_root + 'PopupWin/Editor_InsertTable.htm?'+ thisObjName, window, 'resizable: yes; help: no; status: no; scroll: no;');
								}

							//**	기타 다른 스타일 테그
								else{
									EditorDoc.execCommand(thisActId);
								}
						}

				Editor_Event_Handlers(thisObjName);
		}
//-->