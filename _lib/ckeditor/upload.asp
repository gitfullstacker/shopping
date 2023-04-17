<!--#include virtual = "/sys_inc/common_header.asp"-->
<%

'=============================================================================
Server.ScriptTimeout = 1800    

Set uploadform = Server.CreateObject("DEXT.FileUpload") 
'board_save_dir = "\sys_util\ckeditor_ASP\upload\"
board_save_dir = "\_upload\editer\"
uploadform.DefaultPath =  Server.MapPath("\") & board_save_dir
'oDext.DefaultPath = Server.MapPath("../../upload")
uploadform.CodePage=65001  'utf-8 한글깨짐처리
boardUploadUrl=uploadform.DefaultPath

For each Item in uploadform.Form
	Execute(Item.Name & " = injection(trim(uploadform(""" & Item.Name & """)),true,0)")
	'QueryLink = QueryLink & "&" & Item.Name & "=" & uploadform(Item.Name)
Next


'######################### 파일 허용체크 #########################
totFileSize=0
FILE_PERMIT_EXT=FILE_PERMIT_EXT_IMG
set file_temp = uploadform("upload")
%>
<!--#include virtual = "/sys_lib/file_permit_ext.asp"-->
<%
set file_temp = nothing
'######################### 파일 허용체크 #########################





'######################### 이미지 업로드 #########################
totFileSize=0
set file_temp = uploadform("upload")
imgPrefix="Thumbnail" ' 필요한경우만
' 허용파일 체크
%>
<!--#include virtual = "/sys_lib/file_dext_img.asp"-->
<%


strUrl = uploadform("callback") & "?callback_func=" & uploadform("callback_func")
'strFileName = uploadform("upload").SaveAs(, false)
strFileName = save_file_name


    '' 오류 유무에 따른 URL 구성

    if file_temp.FileName<>"" Then

      %>
		<script type='text/javascript'>alert('업로드성공');
		</script>
	  <%

		strFileName = Server.URLEncode(strFileName)

        strUrl = strUrl & "&bNewLine=true"
        strUrl = strUrl & "&sFileName=" & strFileName
        strUrl = strUrl & "&sFileURL=/sys_util/ckeditor_ASP/upload/" & strFileName


    End If

set file_temp = nothing

%>
<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction('<%=CKEditorFuncNum%>', '/sys_util/ckeditor_ASP/upload/<%=strFileName%>');</script>;