	function Save_Click() {
		if (ValidChk()==false) return;

		if(!confirm("결제를 신청하시겠습니까?")) return;
		document.frm.RetrieveFlag.value="INSERT";

		document.frm.target = "_self";
		document.frm.action = "pay_bill_edit_proc.php";
		document.frm.submit();
	}
	function ValidChk()	{
		var f = document.frm;
		
		if(chkSpace(f.str_sdate.value)){
	       	alert("\n기간이 입력되지 않았습니다");
	       	f.str_sdate.focus();
	        return false;
	   	}
		if(chkSpace(f.str_edate.value)){
	       	alert("\n기간이 입력되지 않았습니다");
	       	f.str_edate.focus();
	        return false;
	   	}
		if(chkSpace(f.good_mny.value)){
	       	alert("\n금액이 입력되지 않았습니다");
	       	f.good_mny.focus();
	        return false;
	   	}
		return true;
	}
	
      function init_orderid()
      {
          var today = new Date();
          var year  = today.getFullYear();
          var month = today.getMonth()+ 1;
          var date  = today.getDate();
          var time  = today.getTime();

          if(parseInt(month) < 10)
          {
              month = "0" + month;
          }

          var vOrderID = year + "" + month + "" + date + "" + time;

          document.frm.ordr_idxx.value = vOrderID;
      }