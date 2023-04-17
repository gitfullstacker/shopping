<!--
//		Copyright obout inc      http://www.obout.com
//	
//		JavaScript file version 2004.01.28


// false - when dragging show moving node itself without children.
// true - when dragging show moving node with children.
var show_with_children = true;


var ob_tve,ob_tvr,ob_tvt=0,ob_tvq=0,ob_tvy=false,ob_tvu=null,ob_tvi=null,tree_dd_path="",tree_dd_id="",ob_tvo=0,ob_tvp=0,ob_tva=true,ob_tvs=0,ob_tvd=0,objTree;function ob_t11(event){if(ob_tva==true){if(window.event){var event=window.event;ob_tvo=event.x;ob_tvp=event.y;}else{ob_tvo=event.pageX;ob_tvp=event.pageY;}ob_tva=false;return;}else{if(window.event){var event=window.event;ob_tvs=event.x;ob_tvd=event.y;}else{ob_tvs=event.pageX;ob_tvd=event.pageY;}}if((Math.abs(ob_tvs-ob_tvo)>5)||(Math.abs(ob_tvd-ob_tvp)>5)){}else{return;}if(ob_tvy==false)return;if(ob_tvu==null){if(show_with_children==true){ob_tvu=ob_tvi.cloneNode(true);ob_tvu.firstChild.firstChild.firstChild.firstChild.style.display="none";if(ob_tvu.firstChild.nextSibling!=null){ob_tvu.firstChild.nextSibling.firstChild.firstChild.firstChild.style.display="none";}}else{ob_tvu=ob_tvi.firstChild.cloneNode(true);document.body.appendChild(ob_tvu);ob_tvu.firstChild.firstChild.firstChild.style.display="none";}document.body.appendChild(ob_tvu);ob_tvu.style.position = "absolute";ob_tvu.style.zIndex="0";ob_tvu.style.filter="Alpha(Opacity='70',FinishOpacity='0',Style='1',StartX='0',StartY='0',FinishX='100',FinishY='100')";ob_tvu.id="ob_drag";if(window.event) {ob_tvt=document.body.scrollLeft;ob_tvq=document.body.scrollTop;}else{ob_tve=event.pageX;ob_tvr=event.pageY;}}if(window.event){var event=window.event;ob_tvu.style.left=event.x+ob_tvt-5;ob_tvu.style.top=event.y+ob_tvq-5;}else{ob_tvu.style.left=event.pageX-5;ob_tvu.style.top=event.pageY-5;}var top=ob_t14(objTree);var bottom=top+objTree.offsetHeight;if((top-ob_tvu.offsetTop)>-20&&objTree.scrollTop>0){objTree.scrollTop=objTree.scrollTop-6;}if((ob_tvu.offsetTop-bottom)>-40){objTree.scrollTop=objTree.scrollTop+6;}}function ob_t10(event,el){

	// EVENT. Before Drag start.

objTree=document.getElementById(ob_tree_id);ob_tvy=true;ob_tvi=el.parentNode;document.onmousemove=function(e){ob_t11(e)};document.onmouseup=function(e){ob_t13(e)};document.onselectstart=function(){return false;};document.onmousedown=function(){return false;};}function ob_t12(){ob_tvy=false;document.onmousemove=null;document.onselectstart=function(){return true;};document.onmousedown=function(){return true;};}function ob_t13(event){var e,lensrc,s,ob_tvg=false,s2;ob_tva=true;if(ob_tvu==null){return;}if(window.event){var event=window.event;var ob_tvh=event.x+ob_tvt;var ob_tvj=event.y+ob_tvq;}else{var ob_tvh=event.pageX;var ob_tvj=event.pageY;}var ob_tvf,flagReturn=false;ob_tvu.style.display="none";items=document.getElementsByTagName("TABLE");for(i=0;i<items.length;i++){var top=ob_t14(items[i])-objTree.scrollTop;var left=ob_t15(items[i])-objTree.scrollLeft;if(items[i].tagName=="TABLE"&&(ob_tvj>=top&&ob_tvj<=items[i].offsetHeight+top)&&(ob_tvh>=left&&ob_tvh<=items[i].offsetWidth+left)){ob_tvf=items[i];if(ob_tvf==ob_tvi.firstChild){ob_tvf=null;


		alert("Can not move. The destination is the same as the source.");


}}}if(ob_tvf!=null){if(ob_tvf.parentNode.tagName=="DIV"){if(ob_tvf.firstChild.firstChild.childNodes.length==3){if(ob_tvf.firstChild.firstChild.firstChild.firstChild.tagName=="IMG"){s=ob_tvf.firstChild.firstChild.firstChild.firstChild.src.toLowerCase();lensrc=(s.length-6);s=s.substr(lensrc, 6);if((s=="ik.gif")||(s=="hr.gif")||(s=="_l.gif")||(s=="us.gif")){}else{flagReturn=true;}}else{flagReturn=true;}}else{flagReturn=true;}}else{flagReturn=true;}}if(flagReturn==true)ob_tvf=null;if(ob_tvf!= null){e = ob_tvf.firstChild.firstChild.firstChild.nextSibling.nextSibling;tree_dd_path = "";ob_t19(e);var arr=tree_dd_path.split("|");var idSource=ob_tvi.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling.id;	for(i=0;i<arr.length;i++){if(arr[i]==idSource){ob_tvf=null;
				
				
		alert("Can not move. The destination is under the source.");


}}}if(ob_tvf!=null){if(ob_tvf.parentNode.childNodes.length>1){if(ob_tvf.nextSibling==ob_tvi.parentNode.parentNode.parentNode.parentNode){ob_tvf=null;


		alert("Can not move. The destination is the same as the source.");


}}}if(ob_tvf!=null){var ob_dd_target_id=ob_tvf.firstChild.firstChild.firstChild.nextSibling.nextSibling.id;if(sNoDrop!=""){var a=new Array;a=sNoDrop.split(",");if(a.length>0){for(i=0;i<a.length;i++){if(ob_dd_target_id==a[i]){ob_tvf=null;


		alert("Can not move. The destination folder is restricted.");


}}}}}ob_tvu.style.display="block";if(ob_tvf!=null){e=ob_tvi.firstChild.firstChild.firstChild.firstChild.firstChild;e.src=ob_t16(e);e.parentNode.style.backgroundImage="none";ob_tvi.firstChild.firstChild.firstChild.firstChild.style.backgroundImage = "none";if(ob_tvi.childNodes.length==2){ob_tvi.firstChild.nextSibling.firstChild.firstChild.firstChild.style.backgroundImage="none";}if(ob_tvf.parentNode.childNodes.length==1){e=ob_tvf.firstChild.firstChild.firstChild.firstChild;e.src=ob_style+"/minus_l.gif";e.onclick=function(){ob_t21(this,'')};e=ob_tvf.parentNode.appendChild(document.createElement("TABLE"));if(document.all){e.border="0";e.cellPadding="0";e.cellSpacing="0";}else{e.setAttribute("border","0");e.setAttribute("cellpadding","0");e.setAttribute("cellspacing", "0");}e.appendChild(document.createElement("tbody"));var e2=e.firstChild.appendChild(document.createElement("TR"));e=e2.appendChild(document.createElement("TD"));if(ob_tvf.parentNode.parentNode.lastChild!=ob_tvf.parentNode){e.style.backgroundImage="url("+ob_style+"/vertical.gif)";}e.innerHTML="<div class=ob_d5></div>";e=e2.appendChild(document.createElement("TD"));e.className="ob_t5";}else{e=ob_tvf.nextSibling.firstChild.firstChild.firstChild.nextSibling;if(e.lastChild.childNodes.length>1){e.lastChild.firstChild.nextSibling.firstChild.firstChild.firstChild.style.backgroundImage="url("+ob_style+"/vertical.gif)";e.lastChild.firstChild.firstChild.firstChild.firstChild.style.backgroundImage="url("+ob_style+"/vertical.gif)";e2=e.lastChild.firstChild.firstChild.firstChild.firstChild.firstChild;s=e2.src;lensrc=(s.length-6);s2=s.substr(lensrc, 6);if(s2=="_l.gif"){s2=s.substr(0, lensrc)+".gif";e2.src=s2;e2.onclick=function(){ob_t21(this,'')};}}else{e2=e.lastChild.firstChild.firstChild.firstChild.firstChild.firstChild;e2.src=ob_style+"/hr.gif";ob_tvg=true;}}var tempE=e;document.body.removeChild(ob_tvu);var ob_dd_id=ob_tvi.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling.id;tree_dd_id=tree_dd_id+ob_dd_target_id+","+ob_dd_id+"|";if(ob_tvi.parentNode.childNodes.length==1){e=ob_tvi.parentNode.parentNode.parentNode.parentNode.parentNode;if(ob_tvg==false){e.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style+"/hr_l.gif";}else {e.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style+"/hr.gif";}e.removeChild(e.firstChild.nextSibling);}else{if(ob_tvi.parentNode.lastChild==ob_tvi){e=ob_tvi.previousSibling.firstChild.firstChild.firstChild.firstChild.firstChild;e.src=ob_t16(e);e.parentNode.style.backgroundImage="none";if(ob_tvi.previousSibling.childNodes.length>1){ob_tvi.previousSibling.firstChild.nextSibling.firstChild.firstChild.firstChild.style.backgroundImage="none";}else{}}}document.onmousemove="";e=ob_tvf.firstChild.firstChild.firstChild.firstChild;lensrc=(e.src.length-8);s=e.src.substr(lensrc,8);if((s=="usik.gif")||(s=="ik_l.gif")){e.onclick();}tempE.appendChild(ob_tvi);}else{document.body.removeChild(document.getElementById("ob_drag"));}ob_tvu=null;ob_tvy=false;document.onselectstart=function(){return true;};document.onmousedown=function(){return true;};document.onmouseup=null;

	// EVENT. After Drag & Drop finished.

}function ob_t15(vz){var pos=0;if(vz.offsetParent){while(vz.offsetParent){pos+=vz.offsetLeft;vz=vz.offsetParent;}}else if(vz.x)pos+=vz.x;return pos;}function ob_t14(ue){var pos=0;if(ue.offsetParent){while(ue.offsetParent){pos+=ue.offsetTop;ue=ue.offsetParent;}}else if (ue.y)pos+=ue.y;return pos;}
function ob_t18(s){if(document.all){var items=s.getElementsByTagName("IMG");for(var i=0;i<items.length;i++){items[i].ondragstart=function(){return false;};}}var e;var items=s.getElementsByTagName("DIV");for(i=0;i<items.length;i++){if((items[i].className=="ob_t2b")||(items[i].className=="ob_t2c")){e=items[i].firstChild;if(document.all){e.onmousedown=new Function("ob_t10(null,this);");e.onmouseup=new Function("ob_t12();");}else{e.setAttribute("onmousedown","ob_t10(event,this);");e.setAttribute("onmouseup","ob_t12();");}}}}function ob_t19(e){if(e.parentNode.parentNode.parentNode.parentNode.parentNode.className=="ob_di2"){return};e=e.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;tree_dd_path=e.id+"|"+tree_dd_path;ob_t19(e);}function ob_tnodrag(s){if(s==""){return;}var a=new Array;a=s.split(",");for(var i=0;i<a.length;i++){e=document.getElementById(a[i]).parentNode.parentNode.parentNode;e.onmousedown=function(){return false;};e.onmouseup=function(){return false;};}}function ob_t16(e){e.onclick=function(){ob_t21(this,'')};var s="",lensrc=0,s2="";s=e.src;lensrc=(s.length-6);s2=s.substr(lensrc, 6);if(s2!="_l.gif"){s2=s.substr(0,lensrc+2)+"_l.gif";return s2;}else{return s;}}

//-->














