	function Click_Del(str_goodcode) {

		if(!confirm("알림을 취소 하시겠습니까?")) return;
		window.location.href="/mypage/stocked_proc.php?RetrieveFlag=ALARMDEL&str_goodcode="+str_goodcode;
		return;	

	}