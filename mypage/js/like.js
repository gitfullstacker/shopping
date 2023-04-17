	function Click_Del(str_goodcode) {

		if(!confirm("삭제 하시겠습니까?")) return;
		window.location.href="/mypage/like_proc.php?RetrieveFlag=LIKEDEL&str_goodcode="+str_goodcode;
		return;	

	}