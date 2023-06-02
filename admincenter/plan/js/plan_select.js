function Save_Click() {
	if (!confirm("작성하신 데이터를 저장하시겠습니까?")) return;

	document.frm.target = "_self";
	document.frm.action = "plan_select_proc.php";
	document.frm.submit();
}