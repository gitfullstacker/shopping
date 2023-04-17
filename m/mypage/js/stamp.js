	function Click_Buy(int_prod,int_ustamp) {
		if(!confirm("상품을 구매 하시겠습니까?")) return;		

		var sTemp = fuc_ajax('stamp_proc.php?RetrieveFlag=BUY&int_prod='+int_prod+'&int_ustamp='+int_ustamp);
	
		if (sTemp=="1") {
			alert("상품이 구매되었습니다");
			document.frm.submit();
			return;
		}else{
			alert("보유 스탬프 수가 모자랍니다.");
			return;
		}
	}


