//*롤오버 아웃 이미지
function menuOver() {
	sc = this.src;
	sc = sc.replace("_on.gif", ".gif");
	this.src = sc.replace(".gif", "_on.gif");
}
function menuOut() {
	this.src = this.src.replace("_on.gif", ".gif");
}

function menuClick() {
	if(this.id.indexOf("menu-image") > -1) {
		var submenu = document.getElementById("menu" + this.id.substring(10));
		var uls = submenu.getElementsByTagName("ul");
		if(uls.length>0){
			if(uls[0].style.display == "none")
				uls[0].style.display = "block";
			else
				uls[0].style.display = "none";
		}
	}
}


/**
 * 
 * @param ImgEls
 * @param SelImg
 */
function initImgEffect(menuCode) {
	
	var MenuImg = $('.gnbVr').find(">ul>li");
	
	MenuImg.each(
			
			function (index){
				
				var arrCode = menuCode.split("_");
				
				var img = $(this).find("img");
				
				if((index+1) == parseInt(arrCode[0])){
					
					 img.attr("src", img.attr("src").replace(".gif", "_on.gif"));
					 
					 var arrLi =$(this).find(">div>ul>li");
					 
					 arrLi.each(
							 function (li_index){
								 
								 if($(this).attr("id") == arrCode[1]){
									 
									 $(this).find(">a").addClass("on");
									 //$(this).find(">a").css('fontWeight','bold');
								 }
							 }
					 );
				}
				else{
					img.mouseover(menuOver);
					img.mouseout(menuOut);
				}
			}
	);
}

/**
 * 
 * @param ImgEls
 * @param SelImg
 */
function initImgEffect_back(ImgEls,SelImg) {
	
	MenuImg = document.getElementById(ImgEls).getElementsByTagName("img");
	MenuImgLen = MenuImg.length;
	
	for (var i=0; i<MenuImgLen; i++) {
		MenuImg.item(i).onmouseover = menuOver;
		MenuImg.item(i).onmouseout = menuOut;
		if (i == SelImg) {
			MenuImg.item(i).onmouseover();
			MenuImg.item(i).onmouseover = null;
			MenuImg.item(i).onmouseout = null;
		}
	}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}



function initSubmenuByMenuId(depth1, depth2, depth3,depth4, menuId) {
	selectDepth1 = "menu" + depth1 + "-" + depth2;
	selectDepth2 = "menu" + depth1 + "-" + depth2 + "-" + depth3;
	selectDepth3 = "menu" + depth1 + "-" + depth2 + "-" + depth3 + "-" + depth4;
	
	nav = document.getElementById(menuId);
	if(!nav) return;
	menuEl = nav.getElementsByTagName("li");	
		
	
	for(var i = 0; i < menuEl.length; i++) {
		if (menuEl.item(i).id == selectDepth1 || menuEl.item(i).id == selectDepth2  || menuEl.item(i).id == selectDepth3  ) {
			var im = menuEl.item(i).getElementsByTagName("img");
			if(im && im.length > 0 ) {
				im.item(0).src = im.item(0).src.replace(".gif", "_on.gif");
			}
			else {
				var anc = menuEl.item(i).getElementsByTagName("a");
				if(anc && anc.length > 0) {
					anc.item(0).className = "on";
					if(menuEl.item(i).id == selectDepth3) {
						anc.item(0).className += " leaf";
					}
				}
			}
		} else {
			var im = menuEl.item(i).getElementsByTagName("img");
			if( im == null || im.length == 0)  continue;
			im.item(0).onmouseclick = menuOver;/* 수정 */
			im.item(0).onmouseout = menuOut;
			im.item(0).onfocus = menuOver;
			im.item(0).onblur = menuOut;
			if (menuEl.item(i).getElementsByTagName("ul").item(0)) {
				menuEl.item(i).getElementsByTagName("ul").item(0).style.display = "none";
			}
		}
	}
	menuId = "menu" + depth1;
	initTopmenuByMenuId(depth1,depth2,depth3,depth4,menuId);
}

function initTopMenu(el,depth1) {
	topMenuOut(el.getElementsByTagName("img").item(0));
	if(el.id == "top-menu" + depth1) {
		topMenuOver(el.getElementsByTagName("img").item(0));
	}
}
function topMenuOver(img) {
	img.src = img.src.replace(".gif", "_on.gif");
}
function topMenuOut(img) {
	img.src = img.src.replace("_on.gif", ".gif");
}

function selectTopmenuByMenuId() {
	
	var depth1 = this.id.substring("top-menu-head".length,this.id.length);
	var menuId = "sub-menu" + depth1;
	
	// top 메뉴
	var topnav = document.getElementById("lnb");
	if(!topnav) return;
	
	// 1depth 메뉴의 sub 메뉴
	var topEl = topnav.getElementsByTagName("ul");
	for(var i = 0 ; i < topEl.length ; i++){
		if(topEl[i].id.substring(0,12) == "top-sub-menu") {
			topEl[i].style.display = "none";
		}
	}
	
	// 1depth 메뉴
	var topEl2 = topnav.getElementsByTagName("li");
	for(i = 0 , seq = 1; i < topEl2.length ; i++){
		if(topEl2[i].id.substring(0,8) == "top-menu") {
			initTopMenu(topEl2[i],depth1);
		}
	}
	
	// 선택한 sub 메뉴 (2depth)
	var nav = document.getElementById("top-" + menuId);
	if(!nav) return;
	nav.style.display = "block";
	menuEl = nav.getElementsByTagName("li");
	for(var i = 0; i < menuEl.length; i++) {
		var menuElItm = menuEl.item(i);
		var imgEl = menuEl.item(i).getElementsByTagName("img");
		if(imgEl != null && imgEl.length>0) {
			if (menuElItm.id ==  selectedMenu ) {
				imgEl.item(0).onmouseover = null;
				imgEl.item(0).onmouseout = null;
				imgEl.item(0).onfocus = null;
				imgEl.item(0).onblur = null;
			}else{
				imgEl.item(0).onmouseover = menuOver;
				imgEl.item(0).onmouseout = menuOut;
				imgEl.item(0).onfocus = menuOver;
				imgEl.item(0).onblur = menuOut;
			}
		}
	}
}

var selectedDepth = "1";
var selectedMenu = "";

// 현재 메뉴 사용여부
var menuUse = false;

//메뉴 롤백 타임
var rollbackTime;

function setMenuUseOff(){
	menuUse = false;
	rollbackTime = setTimeout("rollbackTopmenuAction()",200);
}

function setMenuUseOn(){
	clearTimeout(rollbackTime);
	menuUse = true;
}

// 기존 선택한 메뉴 Roll Back
function rollbackTopmenuAction(){
	
	if(menuUse) return;
	
	var depth1 = selectedDepth;
	var menuId = "sub-menu" + depth1;
	
	// top 메뉴
	var topnav = document.getElementById("lnb");
	if(!topnav) return;
	
	// 1depth 메뉴의 sub 메뉴
	var topEl = topnav.getElementsByTagName("ul");
	for(var i = 0 ; i < topEl.length ; i++){
		if(topEl[i].id.substring(0,12) == "top-sub-menu") {
			topEl[i].style.display = "none";
		}
	}
	
	// 1depth 메뉴
	var topEl2 = topnav.getElementsByTagName("li");
	for(i = 0 , seq = 1; i < topEl2.length ; i++){
		if(topEl2[i].id.substring(0,8) == "top-menu") {
			initTopMenu(topEl2[i],depth1);
		}
	}
	
	// 선택한 sub 메뉴 (2depth)
	var nav = document.getElementById("top-" + menuId);
	if(!nav) return;
	nav.style.display = "block";
	menuEl = nav.getElementsByTagName("li");
	for(var i = 0; i < menuEl.length; i++) {
		var menuElItm = menuEl.item(i);
		var imgEl = menuEl.item(i).getElementsByTagName("img");
		if(imgEl != null && imgEl.length>0) {
			if (menuElItm.id ==  selectedMenu ) {
				imgEl.item(0).onmouseover = null;
				imgEl.item(0).onmouseout = null;
				imgEl.item(0).onfocus = null;
				imgEl.item(0).onblur = null;
			}else{
				imgEl.item(0).onmouseover = menuOver;
				imgEl.item(0).onmouseout = menuOut;
				imgEl.item(0).onfocus = menuOver;
				imgEl.item(0).onblur = menuOut;
			}
		}
	}
}

/**
 * Top 메뉴 초기설정.
 * @param depth1
 * @param depth2
 * @param depth3
 * @param depth4
 * @param menuId
 */
function initTopmenuByMenuId(depth1, depth2, depth3, depth4, menuId) {
	
	selectedDepth = depth1;
	
	var selectDepth1 = "top-" + depth1 + "-" + depth2;
	var selectDepth2 = "top-" + depth1 + "-" + depth2 + "-" + depth3;
	var selectDepth3 = "top-" + depth1 + "-" + depth2 + "-" + depth3 + "-" + depth4;
	
	// top 메뉴
	var topnav = document.getElementById("lnb");
	if(!topnav) return;
	
	// 1depth 메뉴의 sub 메뉴
	var topEl = topnav.getElementsByTagName("ul");	
	for(var i = 0 ; i < topEl.length ; i++){
		if(topEl[i].id.substring(0,12) == "top-sub-menu") {
			topEl[i].style.display = "none";
			topEl[i].onmouseover = setMenuUseOn;
			topEl[i].onmouseout = setMenuUseOff;
		}
	}
	
	// 1depth 메뉴
	var topEl2 = topnav.getElementsByTagName("li");
	for(i = 0 , seq = 1; i < topEl2.length ; i++){
		if(topEl2[i].id.substring(0,8) == "top-menu") {
			topEl2[i].onmouseover = setMenuUseOn;
			topEl2[i].onmouseout = setMenuUseOff;
		}
	}
	
	// 현재 미사용
	/*
	var topEl3 = topnav.getElementsByTagName("li");
	for(i = 0 , seq = 1; i < topEl3.length ; i++){
		if(topEl3[i].id.substring(0,8) == "position") {
			if(depth1 == seq) topEl3[i].style.display = "block";
			else topEl3[i].style.display = "none";
			seq++;
		}
	}
	*/ 
	
	// 1depth 메뉴의  Link
	var topEl3 = topnav.getElementsByTagName("a");
	for(i = 0, seq = 0 ; i < topEl3.length ; i++){
		if(topEl3[i].id.substring(0,13) == "top-menu-head") {
			topEl3[i].onmouseover = selectTopmenuByMenuId;
			topEl3[i].onfocus = selectTopmenuByMenuId;
			if ( topEl3[i].id.substring(13) == depth1) {
				topEl3[i].onmouseover();
			}
			seq++;
		}
	}
	
	// 선택한 sub 메뉴 (2depth) - 이미지 변경 Action
	var nav = document.getElementById("top-" + menuId);
	if(!nav) return;
	nav.style.display = "block";
	menuEl = nav.getElementsByTagName("li");
	for(i = 0; i < menuEl.length; i++) {
		var menuElItm = menuEl.item(i);
		var imgEl = menuElItm.getElementsByTagName("img");
		if(imgEl == null || imgEl.length == 0)  {
			var aEl = menuElItm.getElementsByTagName("a");
			var itm = aEl.item(0);
			if (menuElItm.id == selectDepth1 || menuElItm.id == selectDepth2  || menuElItm.id == selectDepth3  ) {
				
				selectedMenu = "top-" + depth1 + "-"+depth2;
				
				itm.className = "on";
				itm.onmouseover = null;
				itm.onmouseout = null;
				itm.onfocus = null;
				itm.onblur = null;
			}
			else {
				itm.onmouseover = menuOver;
				itm.onmouseout = menuOut;
				itm.onfocus = menuOver;
				itm.onblur = menuOut;
			}
		} else {
			var itm = imgEl.item(0);
			if (menuElItm.id == selectDepth1 || menuElItm.id == selectDepth2  || menuElItm.id == selectDepth3  ) {
				
				selectedMenu = "top-" + depth1 + "-"+depth2;
				
				itm.src = itm.src.replace(".gif", "_on.gif");
				itm.onmouseover = null;
				itm.onmouseout = null;
				itm.onfocus = null;
				itm.onblur = null;
			}
			else {
				itm.onmouseover = menuOver;
				itm.onmouseout = menuOut;
				itm.onfocus = menuOver;
				itm.onblur = menuOut;
			}
		}
	}
}

//따라다니는 배너
// var stmnLEFT = 0; // 오른쪽 여백 
// var stmnGAP1 = 150; // 위쪽 여백 
// var stmnGAP2 = 0; // 스크롤시 브라우저 위쪽과 떨어지는 거리 
// var stmnBASE = 10; // 스크롤 시작위치 
// var stmnActivateSpeed = 35; //스크롤을 인식하는 딜레이 (숫자가 클수록 느리게 인식)
// var stmnScrollSpeed = 10; //스크롤 속도 (클수록 느림)
// var stmnTimer; 
 
// function RefreshStaticMenu() { 
//  var stmnStartPoint, stmnEndPoint; 
//  stmnStartPoint = parseInt(document.getElementById('STATICMENU').style.top, 10); 
//  stmnEndPoint = Math.max(document.documentElement.scrollTop, document.body.scrollTop) + stmnGAP2; 
//  if (stmnEndPoint < stmnGAP1) stmnEndPoint = stmnGAP1; 
//  if (stmnStartPoint != stmnEndPoint) { 
//   stmnScrollAmount = Math.ceil( Math.abs( stmnEndPoint - stmnStartPoint ) / 15 ); 
//   document.getElementById('STATICMENU').style.top = parseInt(document.getElementById('STATICMENU').style.top, 10) + ( ( stmnEndPoint<stmnStartPoint ) ? -stmnScrollAmount : stmnScrollAmount ) + 'px'; 
//   stmnRefreshTimer = stmnScrollSpeed; 
//   }
//  stmnTimer = setTimeout("RefreshStaticMenu();", stmnActivateSpeed); 
//  } 
// function InitializeStaticMenu() {
//  document.getElementById('STATICMENU').style.right = stmnLEFT + 'px';  //처음에 오른쪽에 위치. left로 바꿔도.
//  document.getElementById('STATICMENU').style.top = document.body.scrollTop + stmnBASE + 'px'; 
//  RefreshStaticMenu();
//  }

 