	function fnc_makedir() {
		popupLayer('/admincenter/comm/comm_editor_dir.php',300,150);
	}
	function Delete_Click(int_number,str_location) {
		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n      정말로 삭제하시겠습니까?")) return
			document.frm.RetrieveFlag.value="DELETE"
			document.frm.int_number.value=int_number;
			document.frm.str_location.value=str_location;
			document.frm.action = "comm_editor_list_proc.php";
			document.frm.submit();
	}
	function Delete_FClick(int_number,str_location) {
		if (!confirm("한번 삭제한 데이터는 복구할 수 없습니다.\n      정말로 삭제하시겠습니까?")) return
			document.frm.RetrieveFlag.value="FDELETE"
			document.frm.int_number.value=int_number;
			document.frm.str_location.value=str_location;
			document.frm.action = "comm_editor_list_proc.php";
			document.frm.submit();
	}
	
	function Save_Click() {
		if (ValidChk()==false) return;
		document.frm.RetrieveFlag.value ="UPLOAD";
		document.frm.action = "comm_editor_list_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		if(chkSpace(f.str_image.value)){
	       	alert('\n파일이 입력되지 않았습니다.');
	   		f.str_image.focus();
	        return false;
	   	}
		return true;
	}
	var opener = window.dialogArguments;
	var Editor_Root_Dir	= parent.Editor_Root_Dir;
	//var ObjName			= parent.document.location.search.substring(1,parent.document.location.search.length);
	//alert(eval("parent.document.frm.Obj.value"));
	var ObjName			= eval("parent.document.frm.Obj.value").substring(0,eval("parent.document.frm.Obj.length"));
	//var ObjName = eval("parent.document.frm.Obj.value");
	//var ObjName = "str_summary"

	function fnc_insertimg(str_path,str_file){
		var ImageHTML = '';
		ImageHTML = '<img src="'+ str_path + str_file +'">';
		parent.Editor_InsertHTML(ObjName, ImageHTML);
	}
	/*
	function fnc_insertimg(str_path,str_file){
		var objSetTable = parent.document.all.layAddBrow;
		var objInEditor = parent.document.frames.I_Editor;
		objInEditor.focus();

		var strHtml = '<img src="'+ str_path + str_file +'">';
		var objRange = objInEditor.document.selection.createRange();
		objRange.pasteHTML(strHtml);
	}
	*/

	function getFileExtension(filePath)
	{
	  var lastIndex = -1;
	  lastIndex = filePath.lastIndexOf('.');
	  var extension = "";

	  if ( lastIndex != -1 ) {
	    extension = filePath.substring( lastIndex+1, filePath.len );
	  }
	  else {
	    extension = "";
	  }

	  return extension;
	}

	// 이미지 체크 공통함수
	function resetImage(obj)
	{
	  // obj.select();
	  // document.selection.clear();
	  // document.execCommand('Delete');
	  obj.outerHTML = obj.outerHTML
	}

	// 파일 찾아보기 하면 바로 이미지 나오게 하는 스크립트
	function uploadImageCheck(obj)
	{
	  var value = obj.value;
	  var src = getFileExtension(value);
	  if (src == "") {
	    alert('올바른 파일을 입력하세요!');
	    resetImage(obj);
	    return;
	  }
	  else if ( !((src.toLowerCase() == "gif") || (src.toLowerCase() == "jpg") || (src.toLowerCase() == "jpeg")) ) {
	    alert('gif 와 jpg 파일만 지원합니다.');
	    resetImage(obj);
	    return;
	  }
	}
	function Down_Click(int_number,str_location) {
		document.frm.RetrieveFlag.value="DOWN"
		document.frm.int_number.value=int_number;
		document.frm.str_location.value=str_location;
		document.frm.action = "comm_editor_list_proc.php";
		document.frm.submit();
	}