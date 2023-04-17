	function Click_like(str_goodcode,loc) {
		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=LOG');

		if (sTemp == "0") {
			if(!confirm("로그인이 필요합니다.\n로그인 하시겠습니까?")) return;
			document.location.href="/memberjoin/login.php?loc="+document.frm.loc.value;
			return;
		}
		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=INSERT&str_goodcode='+str_goodcode);
		var mTemp = sTemp.split("＾");
		document.getElementById("span_like").innerHTML = "<img src='/images/sub/btn_icn_like.png' alt='' /> " + mTemp[1];
		
		if (mTemp[0]=="1") {
			alert("이미 좋아요를 하셨습니다.");
			return;
		} else if (mTemp[0]=="2") {
			if(!confirm("좋아요를 하셨습니다\n좋아요 가방 화면으로 이동하시겠습니까?")) return;
			window.location.href="/mypage/like.php";
			return;		
		}
	
	}
	

	
	function Alarm_Click(str_goodcode) {
		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=LOG');
		if (sTemp == "0") {
			if(!confirm("로그인이 필요합니다.\n로그인 하시겠습니까?")) return;
			document.location.href="/memberjoin/login.php?loc="+document.frm.loc.value;
			return;
		}
		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=ALARM&str_goodcode='+str_goodcode);
		var mTemp = sTemp.split("＾");

		if(mTemp[0]=="0") {
			alert("이미 입고알림이 등록되어 있습니다.");
			return;
		} else {
			if (mTemp[0]=="-1") {
				if(!confirm("입고 알림 가방은 최대 3개까지만 등록이 가능합니다.\n기존 등록된 알림 가방을 취소하시고 등록바랍니다.\n입고 알림 가방 메뉴로 이동하시겠습니까?")) return;
				document.location.href="/mypage/stocked.php";
				return;
			}else{
				npopupLayer('alram_pop.php?str_goodcode='+str_goodcode+'&Tcnt='+mTemp[1], 480, 470);
				return;		
			}
		}
	
	}
	function Click_Alarm_In(str_goodcode) {

		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=LOG');
		if (sTemp == "0") {
			if(!confirm("로그인이 필요합니다.\n로그인 하시겠습니까?")) return;
			document.location.href="/memberjoin/login.php?loc="+document.frm.loc.value;
			return;
		}
		var sTemp = fuc_ajax('detail_proc.php?RetrieveFlag=ALARMIN&str_goodcode='+str_goodcode);
			
		if(sTemp=="0") {
			alert("이미 입고알림이 등록되어 있습니다.");
			parent.closeLayer();
			return;
		} else {
			alert("입고 알림이 정상 등록 되었습니다.");
			parent.closeLayer();
			return;		
		}
	
	}