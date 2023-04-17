	//드림위버에서 지원하는 함수들
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	  	window.open(theURL,winName,features);
	}
	function MM_reloadPage(init) {
		if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
	    	document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
	  		else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
	}
	MM_reloadPage(true);
	function MM_findObj(n, d) { //v4.0
	  	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	    	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	  	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	  	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	  	if(!x && document.getElementById) x=document.getElementById(n); return x;
	}
	function MM_showHideLayers() { //v3.0
	  	var i,p,v,obj,args=MM_showHideLayers.arguments;
	 	for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
	    	if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
	    	obj.visibility=v; }
	}
	function MM_preloadImages() { //v3.0
	  	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}
	function MM_swapImgRestore() { //v3.0
	  	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}
	function MM_swapImage() { //v3.0
	  	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	   	if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}
	function newXMLHttpRequest() {

	  var xmlreq = false;

	  if (window.XMLHttpRequest) { //파이어폭스나 맥의 사파리의 경우처리
	    xmlreq = new XMLHttpRequest();
	  } else if (window.ActiveXObject) { //IE계열의 브라우져의 경우
	    try {
	      xmlreq = new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e1) {
	      try {
	        xmlreq = new ActiveXObject("Microsoft.XMLHTTP");
	      } catch (e2) {

	      }
	    }
	  }
	  return xmlreq;
	}
	function fuc_set(str_url, str_gubun) {

		xmlHttp = newXMLHttpRequest();

		xmlHttp.open("GET", str_url, false);
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');
		xmlHttp.send(null);

		var Temp;

		if (str_gubun!='') {
			document.getElementById("idView"+str_gubun).innerHTML = xmlHttp.responseText;
		}
	}
	function fuc_ajax(str_url) {
	
		xmlHttp = newXMLHttpRequest();
	
		xmlHttp.open("GET", str_url, false);
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');
		xmlHttp.send(null);

		return xmlHttp.responseText;

	}
	function hangulcheck(a,b) {
	    for(i=0; i<a.value.length; i++) {
	        if(a.value.charAt(i)<"0" || a.value.charAt(i) >"9")  {
	            if(b==0) {
	                a.focus(); a.value="";
	            } else {
	                a.value="";
	            }
	            return;
	        }
	    }
	}
	function num_only(){
	  if((event.keyCode<48) || (event.keyCode>57)){
		event.returnValue=false;
	  }
	}
	// 입력값이 NULL 인지 체크
	function chkSpace(strValue){
		var flag=true;
		if (strValue!=""){
			for (var i=0; i < strValue.length; i++){
				if (strValue.charAt(i) != " "){
					flag=false;
					break;
				}
			}
		}
		return flag;
	}
	function MovePage(PageNo) {
		frm.page.value = PageNo;
		document.frm.target = "_self";
		document.frm.submit();
	}
	function MovePage1(PageNo1) {
		frm.page1.value = PageNo1;
		document.frm.target = "_self";
		document.frm.submit();
	}
	function MovePage2(PageNo2) {
		frm.page2.value = PageNo2;
		document.frm.target = "_self";
		document.frm.submit();
	}
	
	function MovePage3(PageNo) {
		frm_List.page.value = PageNo;
		document.frm_List.target = "_self";
		document.frm_List.submit();
	}

	function change_msg(str_msg) {
		try {
			center.innerHTML  = "<table width=100% border=0 cellspacing=0 cellpadding=0 align=center style='border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000;'><tr><td height=40 align=center bgcolor=ffffff><img src='/pub/image/adm/net_b.gif' align='absmiddle'> <b>"+str_msg+"</b> </td></tr></table>";
		} catch(e) {}
	}
	function blank_msg() {
		try {
			center.innerHTML  = "";
		} catch(e) {}
	}
	function fnc_processbar(str_msg,int_second) {
		try {
			change_msg(str_msg)
			setTimeout(blank_msg, parseInt(int_second)*1000);
		} catch(e) {}
	}
	function fnc_Loddingbar(str_msg,int_second) {
		try {
			change_msg(str_msg)
			setTimeout(blank_msg, parseInt(int_second)*1000);
		} catch(e) {}
	}

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

	function uploadImageCheck1(obj)
	{
	  var value = obj.value;
	  var src = getFileExtension(value);
	  if (src == "") {
	    alert('올바른 파일을 입력하세요!');
	    resetImage(obj);
	    return;
	  }
	  else if (((src.toLowerCase() == "exe") || (src.toLowerCase() == "asp") || (src.toLowerCase() == "php") || (src.toLowerCase() == "jsp") || (src.toLowerCase() == "cgi")) ) {
	    alert('exe, asp, php, jsp, cgi는 지원하지 않습니다.');
	    resetImage(obj);
	    return;
	  }
	}

	function uploadMovieCheck(obj)
	{
	  var value = obj.value;
	  var src = getFileExtension(value);
	  if (src == "") {
	    alert('올바른 파일을 입력하세요!');
	    resetImage(obj);
	    return;
	  }
	  else if ( !((src.toLowerCase() == "swf") || (src.toLowerCase() == "wmv")) ) {
	    alert('swf 와 wmv 파일만 지원합니다.');
	    resetImage(obj);
	    return;
	  }
	}


	function input_cal_byte(input_name, max_byte){
		var input_name_str, byte_count=0, input_name_length=0, one_str, ext_byte;
	        input_name_str = new String(input_name.value);
	        input_name_length = input_name_str.length;

	        for (i=0;i<input_name_length;i++){
	            	one_str=input_name_str.charAt(i);
	            	if (escape(one_str).length > 4){
	                	byte_count+=2;
	            	} else if (one_str != '\r'){
	                	byte_count++;
	            	}
	        }

	        if (byte_count > max_byte){
	            	ext_byte = byte_count - max_byte;
	            	alert('\n내용을 '+max_byte+'Byte 이상 입력하실수 없습니다.\n\n입력하신 내용 중 초과 '+ext_byte+'Byte는 자동 삭제 됩니다.\n');
	            	input_cut_text(input_name,max_byte);
	        }

	}

	function generate_flash(file_, width_, height_){
		var mstring="";

		mstring = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+width_+'" height="'+height_+'" id="falsh_" align="middle"> \n';
		mstring += '<param name="allowScriptAccess" value="always"> \n';
		mstring += '<param name="movie" value="'+file_+'"> \n';
		mstring += '<param name="quality" value="high"> \n';
		mstring += '<param name="wmode" value="Transparent"> \n';
		mstring += '<param name="bgcolor" value="#ffffff"> \n';
		mstring += '<embed src="'+file_+'" quality="high" bgcolor="#ffffff" width="'+width_+'" height="'+height_+'" name="flash_" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"> \n';
		mstring += '</object> \n';

		document.write(mstring);
	}

	function generate_flash2(file_, width_, height_){
		var mstring="";

		mstring = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+width_+'" height="'+height_+'" id="falsh_" align="middle"> \n';
		mstring += '<param name="allowScriptAccess" value="always"> \n';
		mstring += '<param name="movie" value="'+file_+'"> \n';
		mstring += '<param name="quality" value="high"> \n';
		mstring += '<param name="loop" value="false"> \n';
		mstring += '<param name="wmode" value="Transparent"> \n';
		mstring += '<param name="bgcolor" value="#ffffff"> \n';
		mstring += '<embed src="'+file_+'" quality="high" bgcolor="#ffffff" width="'+width_+'" height="'+height_+'" name="flash_" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"> \n';
		mstring += '</object> \n';

		document.write(mstring);
	}

	function fuc_param(str_url, str_gubun) {

		xmlHttp = newXMLHttpRequest();

		var param = compFormPost(document.frm);

		xmlHttp.open("GET", str_url+"?"+param, false);
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');
		xmlHttp.send(null);

		//alert(xmlHttp.responseText);
		var Temp;

		if (str_gubun!='') {
			document.getElementById("idView"+str_gubun).innerHTML = xmlHttp.responseText;
		}
	}

	function compFormPost(frmObj) {

     	var str = '';
		var elm;
		var endName = '';

		for (i = 0, k = frmObj.length; i < k; i++) {
			elm = frmObj[i];
			switch (elm.type) {
			case 'text':
			case 'hidden':
			case 'password':
			case 'textarea':
			case 'select-one':
				str += elm.name + '=' + escape(elm.value) + '&';
				break;
			case 'select-multiple':
				sElm = elm.options;
				str += elm.name + '='
				for (x = 0, z = sElm.length; x < z; x++) {
					if (sElm[x].selected) {
						str += escape(sElm[x].value) + ',';
					}
				}
				str = str.substr(0, str.length - 1) + '&';
				break;
			case 'radio':
				if (elm.checked) {
					str += elm.name + '=' + escape(elm.value) + '&';
				}
				break;
			case 'checkbox':
				if (elm.checked) {
					if (elm.name == endName) {
						if (str.lastIndexOf('&') == str.length - 1) {
							str = str.substr(0, str.length - 1);
						}
						str += ',' + escape(elm.value);
					} else {
						str += elm.name + '=' + escape(elm.value);
					}
					str += '&';
					endName = elm.name;
				}
				break;
			}
		}
		return str.substr(0, str.length - 1);
	}


	/*********************************************
	 * 텍스트필드에서 엔터를 쳤을 경우 처리하는 함수.
	 * @param pm_oEvent : 이벤트 객체
	 * @param pm_sFncName : 처리할 함수명
	 * @param pm_bReturn : return 값
	**********************************************/
    function fn_handleEnter(pm_oEvent, pm_sFncName, pm_bReturn) {
	    var lm_oKeyCode = pm_oEvent.keyCode ? pm_oEvent.keyCode : pm_oEvent.which ? pm_oEvent.which : pm_oEvent.charCode;

	    if (lm_oKeyCode == 13) {
	        eval(pm_sFncName);
	        event.returnValue = pm_bReturn;
	    }
	}

    /****************************************************************
	 * 텍스트필드에 포커스가 발생했을때 디폴트 텍스트를 지우는 함수.
	 * @param pm_oEvent : 이벤트 객체
	*****************************************************************/
	function fn_clearField(pm_oField) {
	    if(pm_oField.value == pm_oField.defaultValue) {
	    	pm_oField.value = "";
	    }
	}

	/****************************************************************
	 * 텍스트필드에 포커스가 사라질 경우 디폴트 텍스트를 넣어주는 함수.
	 * @param pm_oEvent : 이벤트 객체
	*****************************************************************/
	function fn_checkField(pm_oField) {
	    if(!pm_oField.value) {
	    	pm_oField.value = pm_oField.defaultValue;
	    }
	}

	/****************************************************************
	 * 입력값이 특정 문자(chars)만으로 되어있는지 체크.
	 * 특정 문자만 허용하려 할 때 사용
	 * @param pm_sInput : 검사할 문자열
	 * @param pm_sChars : 기준 문자열
	*****************************************************************/
	function fn_ContainsCharsOnly(pm_sInput, pm_sChars) {
	    for(var i=0; i<pm_sInput.value.length; i++) {
	       if(pm_sChars.indexOf(pm_sInput.value.charAt(i)) == -1) {
	           return false;
	       }
	    }

	    return true;
	}
	function comma(num)
	{
		var str=''+num;
		var len=str.length;
		var no=len/3;
		var remain=len%3;
		var rv='';
		var strl='';
		var blank=0;
		var Bstr='           ';
		for(var i=1;i<=no;i++)
		{
			rv=str.substring(len-i*3,len-(i*3)+3)+rv;
			if(i!=no) rv=','+rv;
		}
		if(remain) rv=str.substring(0,remain)+rv;
		rv+='원';
		if(navigator.appName=="Microsoft Internet Explorer")
		{
			rv=Bstr.substring(0,14-rv.length)+rv;
		}
		else
		{
			rv=Bstr.substring(0,14-rv.length)+rv;
		}
		return rv;
	}

	function fnc_Img_View(p_img, p_Width, p_Height)
	{
		var int_Sys_Width = screen.width-20;
		var int_Sys_Height = screen.height-60;
		var int_View_Width = p_Width;
		var int_View_Height = p_Height;
		var str_Scrollbar = 'no';

		if(p_Width>int_Sys_Width)
		{
			int_View_Width = int_Sys_Width;
			str_Scrollbar = 'yes';

		}
		if(p_Height>int_Sys_Height)
		{
			int_View_Height = int_Sys_Height;
			str_Scrollbar = 'yes';
		}

		obj_Win = window.open('', 'imgviewer', 'top=0,left=0,width='+int_View_Width+',height='+int_View_Height+',location=no,scrollbars='+str_Scrollbar);
		if(obj_Win !=null) {
		obj_Win.document.write('<html><head>');
		obj_Win.document.write('<title>IMAGE</title>');
		obj_Win.document.write('</head><body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">');
		obj_Win.document.write('<a href="javascript:self.close();"><img src="'+p_img+'" border="0"></a>');
		obj_Win.document.write('</body></html>');
		}
	}

	function fnc_down(str_path,str_file){
		window.location.href="/comm/comm_down.asp?filepath="+str_path+"&filename="+str_file;
	}

	function winp(str_url,cw,ch) {
		sw=screen.availWidth;
		sh=screen.availHeight;

		//px=(sw-cw)/2;
		px= 0;
		//py=(sh-ch)/2;
		py= 0;
		test=window.open(str_url,'pop','left='+px+',top='+py+',width='+cw+',height='+ch+',toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=no');
	}
	function fnc_blank(obj1, obj2, obj3) {
		eval("document."+obj1+"." +obj2).value = "";
		eval("document."+obj1+"." +obj3).value = "";
	}
	
	function fnNaverMap(x,y,w,h){
	 	var mapObj = new NMap(document.getElementById('mapContainer'),w,h);
	  	mapObj.setCenterAndZoom(new NPoint(x,y),3);
	 	var iconurl = "http://test19.bflat.co.kr/pub/img/icons/flag_red.gif";
	 	var iconSize  = new NSize(20,20);
	 	var markObj = new NMark(new NPoint(x,y), new NIcon(iconurl,iconSize));
	  	mapObj.addOverlay(markObj);
	  	markObj.show();
	 	var zoom =new NZoomControl();
	 	var save = new NSaveBtn();
	 	zoom.setAlign("left");
	 	zoom.setValign("bottom");
	 	save.setValign("top");
	 	mapObj.addControl(save);
	 	mapObj.addControl(zoom);

    	//var nPoint = new NPoint(529268,322773);
    	//var marker = new NMark(nPoint,new NIcon("/images/point.png", new NSize(15,15)));
    	//var infowin = new NInfoWindow();
    	//infowin.set(nPoint, "남서울대");
    	//mapObj.addOverlay(infowin);
    	//infowin.showWindow();
    	//mapObj.addOverlay(marker);
	}
	function fncSearchD() {
		if (ValidChkD()==false) return false;

		document.frmT.action = "/search/search.php";
		document.frmT.submit();
	}
	function ValidChkD()	{
		var f = document.frmT;
		if(chkSpace(f.Txt_word.value)){
	       	alert("\n검색어가 입력되지 않았습니다.");
	   		f.Txt_word.focus();
	        return false;
	   	}
	   	return true;
	}
	function getRadioValue(obj) {
			var len = obj.length;
			var result = "";
			if (!len && obj.checked) {
				result = obj.value;
			}
			for (var i=0, m=obj.length; i < m; i++ ) {
				if (obj[i].checked) {
						result = obj[i].value;
				}
			}
			return result;
	}
	
	function Cart_Click(str_goodcode) {
		var sTemp = fuc_ajax('/category/detail_proc.php?RetrieveFlag=LOG');
		if (sTemp == "0") {
			if(!confirm("로그인이 필요합니다.\n로그인 하시겠습니까?")) return;
			document.location.href="/memberjoin/login.php?loc="+document.frm.loc.value;
			return;
		}
		var sTemp = fuc_ajax('/category/detail_proc.php?RetrieveFlag=CART&str_goodcode='+str_goodcode);
		//alert(sTemp);
		//return;
		
		var mTemp = sTemp.split("＾");
		
		if (mTemp[0] == "00") {
			alert("가방이 품절되어 GET 할수 없는 상품입니다.");
			return;
		}else if (mTemp[0] == "-1") {
			if(!confirm("멤버십에 등록하셔야 가방을\nGET 하실 수 있습니다.\n등록하시겠습니까?")) return;
			document.location.href="/mypage/membership.php";
			return;
		}else if (mTemp[0] == "1") {
			alert("이미 GET신청한 상품이 있습니다.\n재 신청을 원하실 경우 마이페이지에서 \nGET취소를 하신후 다시 신청바랍니다.");
			return;
		}else if (mTemp[0] == "2") {
			alert("상품이 현재 관리자 확인상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
			return;
		}else if (mTemp[0] == "3") {
			alert("상품이 현재 배송 상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
			return;
//		}else if (mTemp[0] == "5") {
//			alert("상품이 반납 신청 상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
//			return;
		} else if (sTemp[0] == "0"||sTemp[0] == "5") {
			window.location.href="/cart/cart.php?str_no="+mTemp[1];
			return;
		} else if (sTemp[0] == "4") {
			window.location.href="/mypage/return.php?str_no="+mTemp[1];
			return;
		}
	}
	
	function Cart_MClick(str_goodcode) {
		var sTemp = fuc_ajax('/m/category/detail_proc.php?RetrieveFlag=LOG');
		if (sTemp == "0") {
			if(!confirm("로그인이 필요합니다.\n로그인 하시겠습니까?")) return;
			document.location.href="/m/memberjoin/login.php?loc="+document.frm.loc.value;
			return;
		}
		var sTemp = fuc_ajax('/m/category/detail_proc.php?RetrieveFlag=CART&str_goodcode='+str_goodcode);
		//alert(sTemp);
		//return;
		
		var mTemp = sTemp.split("＾");
		
		if (mTemp[0] == "00") {
			alert("가방이 품절되어 GET 할수 없는 상품입니다.");
			return;
		}else if (mTemp[0] == "-1") {
			if(!confirm("멤버십에 등록하셔야 가방을\nGET 하실 수 있습니다.\n등록하시겠습니까?")) return;
			document.location.href="/m/mypage/membership.php";
			return;
		}else if (mTemp[0] == "1") {
			alert("이미 GET신청한 상품이 있습니다.\n재 신청을 원하실 경우 마이페이지에서 \nGET취소를 하신후 다시 신청바랍니다.");
			return;
		}else if (mTemp[0] == "2") {
			alert("상품이 현재 관리자 확인상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
			return;
		}else if (mTemp[0] == "3") {
			alert("상품이 현재 배송 상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
			return;
//		}else if (mTemp[0] == "5") {
//			alert("상품이 반납 신청 상태입니다.\n재 신청을 원하실 경우 관리자에게 문의하세요.");
//			return;
		} else if (sTemp[0] == "0"||sTemp[0] == "5") {
			window.location.href="/m/cart/get_cart.php?str_no="+mTemp[1];
			return;
		} else if (sTemp[0] == "4") {
			window.location.href="/m/mypage/return.php?str_no="+mTemp[1];
			return;
		}
	}
	
	function fnc_total() {
		if (chkSpace(document.frmTT.Txt_word.value)){
			alert('검색어를 입력해 주세요.');
			document.frmTT.Txt_word.focus();
			return false;
		}
		return true;
	}
	function fnc_mtotal() {
		if (chkSpace(document.frmTT.Txt_word.value)){
			alert('검색어를 입력해 주세요.');
			document.frmTT.Txt_word.focus();
			return false;
		}
		return true;
	}
	
	function MClick_Cancel(str_no) {
		var sTemp = fuc_ajax('/m/mypage/get_proc.php?RetrieveFlag=LOG');

		if (sTemp == "0") {
			alert("로그인이 필요합니다.");
		}

		if(!confirm("GET 취소하시겠습니까?")) return;
		fuc_ajax('/m/mypage/get_proc.php?RetrieveFlag=UPDATE&str_no='+str_no);

		window.location.href="/m/mypage/get.php";
		return;		
	
	}
	