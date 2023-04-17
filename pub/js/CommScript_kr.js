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
	frm.Page.value = PageNo;
	document.frm.submit();
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











