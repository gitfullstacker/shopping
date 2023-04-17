	function Click_Cancel(str_no) {
		var sTemp = fuc_ajax('get_proc.php?RetrieveFlag=LOG');

		if (sTemp == "0") {
			alert("로그인이 필요합니다.");
		}

		if(!confirm("GET 취소하시겠습니까?")) return;
		fuc_ajax('get_proc.php?RetrieveFlag=UPDATE&str_no='+str_no);

		window.location.href="/mypage/get.php";
		return;		
	
	}
	