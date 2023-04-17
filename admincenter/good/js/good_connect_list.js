
	function Delete_Click(str_no) {

   		document.frm.str_no.value = str_no;
		document.frm.action = "good_connect_list_proc.php";
		document.frm.RetrieveFlag.value="DELETE";
		document.frm.submit();

	}
	
	function Add_Click(str_no) {
   		document.frm.str_no.value = str_no;
		document.frm.action = "good_connect_list_proc.php";
		document.frm.RetrieveFlag.value="INSERT";
		document.frm.submit();
	}
	
	function fnc_search1() {
		document.frm.page1.value=1;
		document.frm.action = "good_connect_list.php";
		document.frm.submit();
	}
	
	function fnc_search2() {
		document.frm.page2.value=1;
		document.frm.action = "good_connect_list.php";
		document.frm.submit();
	}