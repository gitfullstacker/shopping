function _ID(obj){return document.getElementById(obj)}

function iciScroll(obj)
{
	if (event.wheelDelta >= 120) obj.scrollTop -= 40;
	else if (event.wheelDelta <= -120) obj.scrollTop += 40;
	//obj.scrollBy(0,event.wheelDelta / -3);
	return false;
}

/**
 * chkForm(form)
 *
 * ÀÔ·Â¹Ú½ºÀÇ null À¯¹« Ã¼Å©¿Í ÆÐÅÏ Ã¼Å©
 *
 * @Usage	<form onSubmit="return chkForm(this)">
 */

function chkForm(form)
{
	if (typeof(mini_obj)!="undefined" || document.getElementById('_mini_oHTML')) mini_editor_submit();

	for (i=0;i<form.elements.length;i++){
		currEl = form.elements[i];
		if (currEl.disabled) continue;
		if (currEl.getAttribute("required")!=null){
			if (currEl.type=="checkbox" || currEl.type=="radio"){
				if (!chkSelect(form,currEl,currEl.getAttribute("msgR"))) return false;
			} else {
				if (!chkText(currEl,currEl.value,currEl.getAttribute("msgR"))) return false;
			}
		}
		if (currEl.getAttribute("option")!=null && currEl.value.length>0){
			if (!chkPatten(currEl,currEl.getAttribute("option"),currEl.getAttribute("msgO"))) return false;
		}
		if (currEl.getAttribute("minlength")!=null){
			if (!chkLength(currEl,currEl.getAttribute("minlength"))) return false;
		}
		if (currEl.getAttribute("maxlen")!=null){
			if(!chkMaxLength(currEl,currEl.getAttribute("maxlen"))) return false;
		}
	}
	if (form.password2){
		if (form.password.value!=form.password2.value){
			alert("ºñ¹Ð¹øÈ£°¡ ÀÏÄ¡ÇÏÁö ¾Ê½À´Ï´Ù");
			form.password.value = "";
			form.password2.value = "";
			return false;
		}
	}

	if (form['resno[]'] && !chkResno(form)) return false;
	if (form.chkSpamKey) form.chkSpamKey.value = 1;
	if (document.getElementById('avoidDbl')) document.getElementById('avoidDbl').innerHTML = "--- µ¥ÀÌÅ¸ ÀÔ·ÂÁßÀÔ´Ï´Ù ---";
	return true;
}

function chkMaxLength(field,len){
	if (chkByte(field.value) > len){
		if (!field.getAttribute("label")) field.setAttribute("label", field.name);
		alert("["+field.getAttribute("label") + "]Àº "+ len +"Byte ÀÌÇÏ ¿©¾ß ÇÕ´Ï´Ù.");
		return false;
	}
	return true;
}

function chkLength(field,len)
{
	text = field.value;
	if (text.trim().length<len){
		alert(len + "ÀÚ ÀÌ»ó ÀÔ·ÂÇÏ¼Å¾ß ÇÕ´Ï´Ù");
		field.focus();
		return false;
	}
	return true;
}

function chkText(field,text,msg)
{
	text = text.replace("¡¡", "");
	text = text.replace(/\s*/, "");
	if (text==""){
		var caption = field.parentNode.parentNode.firstChild.innerText;
		if (!field.getAttribute("label")) field.setAttribute("label",(caption)?caption:field.name);
		if (!msg) msg = "[" + field.getAttribute("label") + "] ÇÊ¼öÀÔ·Â»çÇ×";
		alert(msg);
		if (field.tagName!="SELECT") field.value = "";
		if (field.type!="hidden") field.focus();
		return false;
	}
	return true;
}

function chkSelect(form,field,msg)
{
	var ret = false;
	fieldname = eval("form.elements['"+field.name+"']");
	if (fieldname.length){
		for (j=0;j<fieldname.length;j++) if (fieldname[j].checked) ret = true;
	} else {
		if (fieldname.checked) ret = true;
	}
	if (!ret){
		if (!field.getAttribute("label")) field.setAttribute("label", field.name);
		if (!msg) msg = "[" + field.getAttribute("label") + "] ÇÊ¼ö¼±ÅÃ»çÇ×";
		alert(msg);
		field.focus();
		return false;
	}
	return true;
}

function chkPatten(field,patten,msg)
{
	var regNum			= /^[0-9]+$/;
	var regEmail		= /^[^"'@]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regUrl			= /^(http\:\/\/)*[.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regAlpha		= /^[a-zA-Z]+$/;
	var regHangul		= /[°¡-ÆR]/;
	var regHangulEng	= /[°¡-ÆRa-zA-Z]/;
	var regHangulOnly	= /^[°¡-ÆR]*$/;
	var regId			= /^[a-zA-Z0-9]{1}[^"']{3,9}$/;
	var regPass			= /^[a-zA-Z0-9_-]{4,12}$/;

	patten = eval(patten);
	if (!patten.test(field.value)){
		if (!field.getAttribute("label")) field.setAttribute("label", field.name);
		if (!msg) msg = "[" + field.getAttribute("label") + "] ÀÔ·ÂÇü½Ä¿À·ù";
		alert(msg);
		field.focus();
		return false;
	}
	return true;
}

function formOnly(form){
	var i,idx = 0;
	var rForm = document.getElementsByTagName("form");
	for (i=0;i<rForm.length;i++) if (rForm[i].name==form.name) idx++;
	return (idx==1) ? form : form[0];
}

function chkResno(form)
{
	var resno = form['resno[]'][0].value + form['resno[]'][1].value;

	fmt = /^\d{6}[1234]\d{6}$/;
	if (!fmt.test(resno)) {
		alert('Àß¸øµÈ ÁÖ¹Îµî·Ï¹øÈ£ÀÔ´Ï´Ù.'); return false;
	}

	birthYear = (resno.charAt(6) <= '2') ? '19' : '20';
	birthYear += resno.substr(0, 2);
	birthMonth = resno.substr(2, 2) - 1;
	birthDate = resno.substr(4, 2);
	birth = new Date(birthYear, birthMonth, birthDate);

	if ( birth.getYear()%100 != resno.substr(0, 2) || birth.getMonth() != birthMonth || birth.getDate() != birthDate) {
		alert('Àß¸øµÈ ÁÖ¹Îµî·Ï¹øÈ£ÀÔ´Ï´Ù.');
		return false;
	}

	buf = new Array(13);
	for (i = 0; i < 13; i++) buf[i] = parseInt(resno.charAt(i));

	multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
	for (i = 0, sum = 0; i < 12; i++) sum += (buf[i] *= multipliers[i]);

	if ((11 - (sum % 11)) % 10 != buf[12]) {
		alert('Àß¸øµÈ ÁÖ¹Îµî·Ï¹øÈ£ÀÔ´Ï´Ù.');
		return false;
	}
	return true;
}

/**
 * chkBox(El,mode)
 *
 * µ¿ÀÏÇÑ ÀÌ¸§ÀÇ Ã¼Å©¹Ú½ºÀÇ Ã¼Å© »óÈ² ÄÁÆ®·Ñ
 *
 * -mode	true	ÀüÃ¼¼±ÅÃ
 *			false	¼±ÅÃÇØÁ¦
 *			'rev'	¼±ÅÃ¹ÝÀü
 * @Usage	<input type=checkbox name=chk[]>
 *			<a href="javascript:void(0)" onClick="chkBox(document.getElementsByName('chk[]'),true|false|'rev')">chk</a>
 */

function chkBox(El,mode)
{
	if (!El) return;
	for (i=0;i<El.length;i++) El[i].checked = (mode=='rev') ? !El[i].checked : mode;
}

/**
 * isChked(El,msg)
 *
 * Ã¼Å©¹Ú½ºÀÇ Ã¼Å© À¯¹« ÆÇº°
 *
 * -msg		null	¹Ù·Î ÁøÇà
 *			msg		confirmÃ¢À» ¶ç¾î ½ÇÇà À¯¹« Ã¼Å© (msg - confirmÃ¢ÀÇ ÁúÀÇ ³»¿ë)
 * @Usage	<input type=checkbox name=chk[]>
 *			<a href="javascript:void(0)" onClick="return isChked(document.getElementsByName('chk[]'),null|msg)">del</a>
 */

function isChked(El,msg)
{
	if (!El) return;
	if (typeof(El)!="object") El = document.getElementsByName(El);
	if (El) for (i=0;i<El.length;i++) if (El[i].checked) var isChked = true;
	if (isChked){
		return (msg) ? confirm(msg) : true;
	} else {
		alert ("¼±ÅÃµÈ »çÇ×ÀÌ ¾ø½À´Ï´Ù");
		return false;
	}
}

/**
 * comma(x), uncomma(x)
 *
 * ¼ýÀÚ Ç¥½Ã (3ÀÚ¸®¸¶´Ù ÄÞ¸¶Âï±â)
 *
 * @Usage	var money = 1000;
 *			money = comma(money);
 *			alert(money);
 *			alert(uncomma(money));
 */

function comma(x)
{
	var temp = "";
	var x = String(uncomma(x));

	num_len = x.length;
	co = 3;
	while (num_len>0){
		num_len = num_len - co;
		if (num_len<0){
			co = num_len + co;
			num_len = 0;
		}
		temp = ","+x.substr(num_len,co)+temp;
	}
	return temp.substr(1);
}

function uncomma(x)
{
	var reg = /(,)*/g;
	x = parseInt(String(x).replace(reg,""));
	return (isNaN(x)) ? 0 : x;
}

/**
 * tab(El)
 *
 * textarea ÀÔ·Â ¹Ú½º¿¡¼­ tabÅ°·Î °ø¹é ¶ç¿ì±â ±â´É Ãß°¡
 *
 * @Usage	<textarea onkeydown="return tab(this)"></textarea>
 */

function tab(El)
{
	if ((document.all)&&(event.keyCode==9)){
		El.selection = document.selection.createRange();
		document.all[El.name].selection.text = String.fromCharCode(9)
		document.all[El.name].focus();
		return false;
	}
}

function enter()
{
    if (event.keyCode == 13){
        if (event.shiftKey == false){
            var sel = document.selection.createRange();
            sel.pasteHTML('<br>');
            event.cancelBubble = true;
            event.returnValue = false;
            sel.select();
            return false;
        } else {
            return event.keyCode = 13;
		}
    }
}

/**
 * strip_tags(str)
 *
 * ÅÂ±×¾ÈÀÇ ¹®ÀÚ¸¸ °¡Á®¿À´Â ÇÔ¼ö
 */

function strip_tags(str)
{
	var reg = /<\/?[^>]+>/gi;
	str = str.replace(reg,"");
	return str;
}

/**
 * miniResize(obj)
 *
 * ÀÌ¹ÌÁö Å×ÀÌºí Å©±â¿¡ ¸ÂÃß¾î¼­ ¸®»çÀÌÁî
 */

function miniResize(obj)
{
	fix_w = obj.clientWidth;
	var imgs = obj.getElementsByTagName("img");
	for (i=0;i<imgs.length;i++){
		//document.write("["+i+"] "+imgs[i].width+" - "+imgs[i].height+"<br>");
		if (imgs[i].width > fix_w){
			imgs[i].width = fix_w;
			imgs[i].style.cursor = "pointer";
			imgs[i].title = "view original size";
			imgs[i].onclick = popupImg;
		}
	}
}

function miniSelfResize(contents,obj)
{
	fix_w = contents.clientWidth;
	if (obj.width > fix_w){
		obj.width = fix_w;
		obj.title = "popup original size Image";
	} else obj.title = "popup original Image";
	obj.style.cursor = "pointer";
	obj.onclick = popupImg;
}

function popupImg(src,base)
{
	if (!src) src = this.src;
	if (!base) base = "";
	window.open(base+'../board/viewImg.php?src='+escape(src),'','width=1,height=1');
}

/**
 * ¹®ÀÚ¿­ Byte Ã¼Å© (ÇÑ±Û 2byte)
 */
function chkByte(str)
{
	var length = 0;
	for(var i = 0; i < str.length; i++)
	{
		if(escape(str.charAt(i)).length >= 4)
			length += 2;
		else
			if(escape(str.charAt(i)) != "%0D")
				length++;
	}
	return length;
}

/**
 * ¹®ÀÚ¿­ ÀÚ¸£±â (ÇÑ±Û 2byte)
 */
function strCut(str, max_length)
{
	var str, msg;
	var length = 0;
	var tmp;
	var count = 0;
	length = str.length;

	for (var i = 0; i < length; i++){
		tmp = str.charAt(i);
		if(escape(tmp).length > 4) count += 2;
		else if(escape(tmp) != "%0D") count++;
		if(count > max_length) break;
	}
	return str.substring(0, i);
}

/**
 * etc..
 */

function get_objectTop(obj){
	if (obj.offsetParent == document.body) return obj.offsetTop;
	else return obj.offsetTop + get_objectTop(obj.offsetParent);
}

function get_objectLeft(obj){
	if (obj.offsetParent == document.body) return obj.offsetLeft;
	else return obj.offsetLeft + get_objectLeft(obj.offsetParent);
}

function mv_focus(field,num,target)
{
	len = field.value.length;
	if (len==num && event.keyCode!=8) target.focus();
}

function onlynumber()
{
	var e = event.keyCode;
	window.status = e;
	if (e>=48 && e<=57) return;
	if (e>=96 && e<=105) return;
	if (e>=37 && e<=40) return;
	if (e==8 || e==9 || e==13 || e==46) return;
	event.returnValue = false;
}

function explode(divstr,str)
{
	var temp = str;
	var i;
	temp = temp + divstr;
	i = -1;
	while(1){
		i++;
		this.length = i + 1;
		this[i] = temp.substring(0, temp.indexOf( divstr ) );
		temp = temp.substring(temp.indexOf( divstr ) + 1, temp.length);
		if (temp=="") break;
	}
}

function getCookie( name )
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
				endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
			break;
	}
	return "";
}

String.prototype.trim = function()
{
	return this.replace(/(^\s*)|(\s*$)/g, "");
}

/**
 * chg_cart_ea(obj,str)
 *
 * Ä«Æ® ¼ö·® º¯°æÇÏ±â
 *
 * -obj		Ä«µå ¼ö·® ÀÔ·Â¹Ú½º ¾ÆÀÌµð
 * -str		up|dn
 * -idx		ÀÎµ¦½º ¹øÈ£ (»ý·« °¡´É)
 */

function chg_cart_ea(obj,str,idx)
{
	if (obj.length) obj = obj[idx];
	if (isNaN(obj.value)){
		alert ("±¸¸Å¼ö·®Àº ¼ýÀÚ¸¸ °¡´ÉÇÕ´Ï´Ù");
		obj.value=1;
		obj.focus();
	} else {
		if (str=='up') obj.value++;
		else  obj.value--;
		if (obj.value==0) obj.value=1;
	}
}

function buttonX(str,action,width)
{
	if (!width) width	= 100;
	if (action) action	= " onClick=\"" + action + "\"";
	ret = "<button style='width:" + width + ";background-color:transparent;color:transparent;border:0;cursor:default' onfocus=this.blur()" + action + ">";
	ret += "<table width=" + (width-1) + " cellpadding=0 cellspacing=0>";
	ret += "<tr height=22><td><img src='/admin/img/btn_l.gif'></td>";
	ret += "<td width=100% background='/admin/img/btn_bg.gif' align=center style='font:8pt tahoma' nowrap>" + str + "</td>";
	ret += "<td><img src='/admin/img/btn_r.gif'></td></tr></table></button>";
	document.write(ret);
}

/**
 * selectDisabled(oSelect)
 *
 * ¼¿·ºÆ®¹Ú½º¿¡ disabled ¿É¼ÇÃß°¡
 */
function selectDisabled(oSelect)
{
	var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
	if (isOptionDisabled){
		oSelect.selectedIndex = oSelect.preSelIndex;
		return false;
	} else oSelect.preSelIndex = oSelect.selectedIndex;
	return true;
}

/** prototype **/

String.prototype.trim = function(){ return this.replace(/(^\s*)|(\s*$)/g, ""); }

/** Ãß°¡ ½ºÅ©¸³ **/

function viewSub(obj)
{
	var obj = obj.parentNode.childNodes[1].childNodes[0];
	obj.style.display = "block";
}

function hiddenSub(obj)
{
	var obj = obj.parentNode.childNodes[1].childNodes[0];
	obj.style.display = "none";
}

function execSubLayer()
{
	var obj = document.getElementById('menuLayer');
	for (i=0;i<obj.rows.length;i++){
		if (typeof(obj.rows[i].cells[1].childNodes[0])!="undefined"){
			obj.rows[i].cells[0].onmouseover = function(){ viewSub(this) }
			obj.rows[i].cells[0].onmouseout = function(){ hiddenSub(this) }
			obj.rows[i].cells[1].style.position = "relative";
			obj.rows[i].cells[1].style.verticalAlign = "top";
			obj.rows[i].cells[1].childNodes[0].onmouseover = function(){ viewSub(this.parentNode.parentNode.childNodes[0]) };
			obj.rows[i].cells[1].childNodes[0].onmouseout = function(){ hiddenSub(this.parentNode.parentNode.childNodes[0]) };
		}
	}
}

function popup(src,width,height)
{
	window.open(src,'','width='+width+',height='+height+',scrollbars=1');
}

/*-------------------------------------
 °ø¿ë - À©µµ¿ì ÆË¾÷Ã¢ È£Ãâ / ¸®ÅÏ
-------------------------------------*/
function popup_return( theURL, winName, Width, Height, left, top, scrollbars ){

	if ( !Width ) Width=500;
	if ( !Height ) Height=415;
	if ( !left ) left=200;
	if ( !top ) top=10;
	if ( scrollbars=='' ) scrollbars=0;
	features = "loaction=no, directories=no, Width="+Width+", Height="+Height+", left="+left+", top="+top+", scrollbars="+scrollbars;
	var win = window.open( theURL, winName, features );

	return win;
}

/*** ÇÒÀÎ¾× °è»ê ***/
function getDcprice(price,dc)
{
	if (!dc) return 0;
	var ret = (dc.match(/%$/g)) ? price * parseInt(dc.substr(0,dc.length-1)) / 100 : parseInt(dc);
	return parseInt(ret / 100) * 100;
}

/*** ÇÃ·¡½Ã Ãâ·Â ***/
function embed(src,width,height)
{
	document.write('\
	<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="'+width+'" HEIGHT="'+height+'"  ALIGN="" name="flashProdnodep">\
	<PARAM NAME=movie VALUE="'+src+'">\
	<PARAM NAME=quality VALUE=high>\
	<PARAM NAME=wmode VALUE=transparent>\
	<PARAM NAME=bgcolor VALUE=#FFFFFF>\
	<EMBED src="'+src+'" quality=high bgcolor=#FFFFFF WIDTH="'+width+'" HEIGHT="'+height+'" NAME="flashProdnodep" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>\
	</OBJECT>\
	');
}

/*** °ü¸®ÀÚ ÆäÀÌÁö °ü·Ã ½ºÅ©¸³Æ® ***/

function showSub(obj)
{
	var obj = obj.parentNode.getElementsByTagName('ul');
	obj[0].style.display = (obj[0].style.display!="block") ? "block" : "none";
}

function showSubAll(mode)
{
	var obj = _ID('navi');
	el = obj.getElementsByTagName('ul');
	for (i=0;i<el.length;i++) el[i].style.display = mode;
}

function table_design_load()
{
	var tb = document.getElementsByTagName('table');
	for (i=0;i<tb.length;i++){
		if (tb[i].className=="tb"){
			with (tb[i]){
				setAttribute('border', 1);
				setAttribute('borderColor', "#EBEBEB");
				//frame = "hsides";
				//rules = "rows";
				//cellPadding = "4";
			}
			with (tb[i].style){
				width = "100%";
				borderCollapse = "collapse";
			}
		}
	}
}

function table_udesign_load()
{
	var tb = document.getElementsByTagName('table');
	for (i=0;i<tb.length;i++){
		if (tb[i].className=="tb"){
			with (tb[i]){
				setAttribute('border', 1);
				setAttribute('borderColor', "#EBEBEB");
				//frame = "hsides";
				//rules = "rows";
				//cellPadding = "4";
			}
			with (tb[i].style){
				width = "630";
				borderCollapse = "collapse";
			}
		}
	}
}

function hiddenLeft()
{
	_ID('leftMenu').style.display = (_ID('leftMenu').style.display!="none") ? "none" : "block";
	_ID('btn_menu').style.display = (_ID('leftMenu').style.display=="none") ? "block" : "none";
}

function openLayer(obj,mode)
{
	obj = _ID(obj);
	if (mode) obj.style.display = mode;
	else obj.style.display = (obj.style.display!="none") ? "none" : "block";
}

/*** ·¹ÀÌ¾î ÆË¾÷Ã¢ ¶ç¿ì±â ***/
function popupLayer(s,w,h)
{
	if (!w) w = 600;
	if (!h) h = 400;

	var pixelBorder = 3;
	var titleHeight = 12;
	w += pixelBorder * 2;
	h += pixelBorder * 2 + titleHeight;

	var bodyW = document.body.clientWidth;
	var bodyH = document.body.clientHeight;

	var posX = (bodyW - w) / 2;
	var posY = (bodyH - h) / 2;

	hiddenSelectBox('hidden');

	/*** ¹é±×¶ó¿îµå ·¹ÀÌ¾î ***/
	var obj = document.createElement("div");
	with (obj.style){
		position = "absolute";
		left = 0;
		top = 0;
		width = "100%";
		height = document.body.scrollHeight;
		backgroundColor = "#000000";
		filter = "Alpha(Opacity=50)";
		opacity = "0.5";
	}
	obj.id = "objPopupLayerBg";
	document.body.appendChild(obj);

	/*** ³»¿ëÇÁ·¹ÀÓ ·¹ÀÌ¾î ***/
	var obj = document.createElement("div");
	with (obj.style){
		position = "absolute";
		left = posX + document.body.scrollLeft;
		top = posY + document.body.scrollTop;
		width = w;
		height = h;
		backgroundColor = "#FFFFFF";
		border = "3px solid #000000";
	}
	obj.id = "objPopupLayer";
	document.body.appendChild(obj);

	/*** Å¸ÀÌÆ²¹Ù ·¹ÀÌ¾î ***/
	var bottom = document.createElement("div");
	with (bottom.style){
		position = "absolute";
		width = w - pixelBorder * 2;
		height = titleHeight;
		left = 0;
		top = h - titleHeight - pixelBorder * 3;
		padding = "2px 0 0 0";
		textAlign = "right";
		backgroundColor = "#000000";
		color = "#ffffff";
		font = "bold 11px tahoma";
	}
	bottom.innerHTML = "<a href='javascript:closeLayer()' class=white>close</a>&nbsp;&nbsp;&nbsp;";
	obj.appendChild(bottom);

	/*** ¾ÆÀÌÇÁ·¹ÀÓ ***/
	var ifrm = document.createElement("iframe");
	with (ifrm.style){
		width = w - 6;
		height = h - pixelBorder * 2 - titleHeight - 3;
		//border = "3 solid #000000";
	}
	ifrm.frameBorder = 0;
	ifrm.src = s;
	//ifrm.className = "scroll";
	obj.appendChild(ifrm);
}
function closeLayer()
{
	hiddenSelectBox('visible');
	_ID('objPopupLayer').parentNode.removeChild( _ID('objPopupLayer') );
	_ID('objPopupLayerBg').parentNode.removeChild( _ID('objPopupLayerBg') );
}
function hiddenSelectBox(mode)
{
	var obj = document.getElementsByTagName('select');
	for (i=0;i<obj.length;i++){
		obj[i].style.visibility = mode;
	}
}

/*-------------------------------------
ÀÚ¹Ù½ºÅ©¸³Æ® µ¿Àû ·Îµù
-------------------------------------*/
function exec_script(src)
{
	var scriptEl = document.createElement("script");
	scriptEl.src = src;
	_ID('dynamic').appendChild(scriptEl);
}

/*-------------------------------------
 CSS ¶ó¿îµå Å×ÀÌºí
 ------------------------------------*/
function cssRound(id,color,bg)
{
	if (!bg) bg = '#ffffff';
	var obj = _ID(id);
	obj.style.backgroundColor = color;
	with (obj.style){
		margin = "5px 0";
		color = "#4c4c4c";
		font = "8pt dotum";
	}
	//obj.innerHTML = "<div style='padding:8px 13px;'><img src='/admin/img/icn_chkpoint.gif'><br>" + obj.innerHTML + "</div>";

	cssRound_top(obj,bg,color);
	cssRound_bottom(obj,bg,color);
}

function cssRound_top(el,bg,color)
{
	var d=document.createElement("b");
	d.className="rOut";
	d.style.fontSize = 0;
	d.style.backgroundColor=bg;
	for(i=1;i<=4;i++){
		var x=document.createElement("b");
		x.className="r" + i;
		x.style.backgroundColor=color;
		d.appendChild(x);
	}
	el.style.paddingTop=0;
	el.insertBefore(d,el.firstChild);
}

function cssRound_bottom(el,bg,color){
	var d=document.createElement("b");
	d.className="rOut";
	d.style.fontSize = 0;
	d.style.backgroundColor=bg;
	for(i=4;i>0;i--){
		var x=document.createElement("b");
		x.className="r" + i;
		x.style.backgroundColor=color;
		d.appendChild(x);
	}
	el.style.paddingBottom=0;
	el.appendChild(d);
}

/*-------------------------------------
 »ö»óÇ¥ º¸±â
-------------------------------------*/
function colortable(){

	var hrefStr = '../proc/help_colortable.php';

	var win = popup_return( hrefStr, 'colortable', 400, 400, 200, 200, 0 );
	win.focus();
}

/*-------------------------------------
 WebFTP
-------------------------------------*/
function webftp(){

	var hrefStr = '../proc/help_design_webftp.php';

	var win = popup_return( hrefStr, 'webftp', 900, 800, 50, 50, 1 );
	win.focus();
}

/*-------------------------------------
 WebFTP Fileinfo
-------------------------------------*/
function webftpinfo( file_root ){

	if ( file_root == '' ){
		alert( '¾÷·ÎµåµÈ ÀÌ¹ÌÁö°¡ ¾ø½À´Ï´Ù.' );
		return;
	}

	var hrefStr = '../design/webftp/webftp_info.php?file_root=' + file_root;

	var win = popup_return( hrefStr, '', 190, 300, 50, 50, 0 );
	win.focus();
}

/*-------------------------------------
 Stylesheet
-------------------------------------*/
function stylesheet(){

	var hrefStr = '../proc/help_design_css.php';

	var win = popup_return( hrefStr, 'stylesheet', 900, 650, 100, 100, 1 );
	win.focus();
}

/*-------------------------------------
 manual
-------------------------------------*/
function manual(){

	var hrefStr = 'http://guide.godo.co.kr/shop/board/list.php?id=exgoods';

	var win = popup_return( hrefStr, 'manual', 1000, 780, 100, 100, 1 );
	win.focus();
}

/*-------------------------------------
 °ø¿ë - Ã¼Å©¹Ú½º Ã¼Å©
 ckFlag : select, reflect, deselect
 CObj : checkbox object
-------------------------------------*/
function PubAllSordes( ckFlag, CObj ){

	if ( !CObj ) return;
	var ckN = CObj.length;

	if ( ckN != null ){

		if ( ckFlag == "select" ){
			for ( jumpchk = 0; jumpchk < ckN; jumpchk++ ) CObj[jumpchk].checked = true;
		}
		else if ( ckFlag=="reflect" ){
			for ( jumpchk = 0; jumpchk < ckN; jumpchk++ ){
				if ( CObj[jumpchk].checked == false ) CObj[jumpchk].checked = true; else CObj[jumpchk].checked = false;
			}
		}
		else{
			for ( jumpchk = 0; jumpchk < ckN; jumpchk++ ) CObj[jumpchk].checked = false;
		}
	}
	else {

		if ( ckFlag == "select" ) CObj.checked = true;
		else if ( ckFlag == "reflect" ){
			if ( CObj.checked == false ) CObj.checked = true; else CObj.checked = false;
		}
		else CObj.checked = false;
	}
}

/*-------------------------------------
 °ø¿ë - Ã¼Å©¹Ú½º ÇÑ°³ÀÌ»ó Ã¼Å©¿©ºÎ
 CObj : checkbox object
-------------------------------------*/
function PubChkSelect( CObj ){

	if ( !CObj ) return;
	var ckN = CObj.length;

	if ( ckN != null ){

		var sett = 0;
		for ( jumpchk = 0; jumpchk < ckN; jumpchk++ ){
			if ( CObj[jumpchk].checked == false ) sett++;
		}

		if ( sett == ckN ) return false;
		else return true;
	}
	else{

		if ( CObj.checked == true ) return true;
		else return false;
	}
}

function setDate(obj1,obj2,from,to)
{
	document.getElementById(obj1).value = from;
	document.getElementById(obj2).value = to;
}

/**********************
 * categoryBox
 *
 * @name	category Æû°´Ã¼¸í
 * @idx		category ¹Ú½º °¹¼ö
 */

function categoryBox(name,idx,val,type,formnm)
{
	if (!idx) idx = 1;
	if (type=="multiple") type = "multiple style='width:160px;height:96'";
	for (i=0;i<idx;i++) document.write("<select " + type + " idx=" + i + " name='" + name + "' onchange='categoryBox_request(this)' class='select'></select>");

	oForm = eval("document.forms['" + formnm + "']");

	if ( oForm == null ) this.oCate = eval("document.forms[0]['" + name + "']");
	else{ this.oCate = eval("document." + oForm.name + "['" + name + "']"); }

	if (idx==1) this.oCate = new Array(this.oCate);

	this.categoryBox_init = categoryBox_init;
	this.categoryBox_build = categoryBox_build;
	this.categoryBox_init();

	function categoryBox_init()
	{
		this.categoryBox_build();
		categoryBox_request(this.oCate[0],val);
	}

	function categoryBox_build()
	{
		for (i=0;i<4;i++){
			if (this.oCate[i]){
				this.oCate[i].options[0] = new Option("= "+(i+1)+"Â÷ ºÐ·ù =","");
			}
		}
	}

}

function categoryBox_request(obj,val)
{
	if (!val) val = "";
	var idx = obj.getAttribute('idx');

	if ( document.location.href.indexOf("/admin") == -1 ){
		exec_script("../lib/_categoryBox.script.php?mode=user&idx=" + idx + "&obj=" + obj.name + "&formnm=" + obj.form.name + "&val=" + val + "&category=" + obj.value);
	}
	else {
		exec_script("../../lib/_categoryBox.script.php?mode=admin&idx=" + idx + "&obj=" + obj.name + "&formnm=" + obj.form.name + "&val=" + val + "&category=" + obj.value);
	}
}

/**
 * Calendar Script
 *
 * @author	mirrh (imirrh@gmail.com)
 * @date	2006.01.22
 * @usage	<input type=text onclick="calendar()" format="%Y-%m-%d">
 */

var calObjdoc;
var calInput;

function calendar_init()
{
	var date = new Date;
	var year = date.getYear();
	var month = date.getMonth();

	var calStyle = "\
	<style>\
	body {margin:0}\
	select {font:8pt tahoma}\
	a {text-decoration:none;color:#000000}\
	.tahoma {font:8pt tahoma}\
	.white {color:#ffffff}\
	.today {font-weight:bold;color:#ff0000}\
	</style>\
	";
	


	var calLayout = "\
	<form name=frmCalendar style='display:inline'>\
	<table width=200 cellpadding=0 cellspacing=0><tr><td style='border:2 solid #323232'>\
	<table width=196 cellpadding=0 cellspacing=0>\
	<tr>\
		<td bgcolor=#000000 style='padding:0 9;border-bottom:2 solid #323232'>\
		<table width=100% cellpadding=0 cellspacing=0 class=tahoma>\
		<tr>\
			<td width=30><font color=#ffffff onclick='parent.calendar_move(-1)' style='cursor:pointer'>¢¸</font></td>\
			<td align=center>\
			<select name=year onChange=parent.calendar_update()></select>\
			<select name=month onChange=parent.calendar_update()></select>\
			</td>\
			<td width=30 align=right><font color=#ffffff onClick='parent.calendar_move(1)' style='cursor:pointer'>¢º</font></td>\
		</tr>\
		</table>\
		</td>\
	</tr>\
	<tr>\
		<td height=122 valign=top>\
		<table width=100% id=calInner class=tahoma>\
		<tr><th style='color:red'>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th style='color:blue'>S</th></tr>\
		<col align=center span=7>\
		</table>\
		</td>\
	</tr>\
	<tr>\
		<td bgcolor=#000000>\
		<table width=100% class=tahoma>\
		<tr>\
			<td><a href='javascript:parent.calendar_update(" + year + "," + month + ")' onfocus=blur() class=white>\
			<b>now</b> (" + year + "-" + parent.calendar_addZero(month+1) + ")\
			</a></td>\
			<td align=right><a href='javascript:parent.calendar_close()' class=white>close</a></td>\
		</tr>\
		</table>\
		</td>\
	</tr>\
	</table>\
	</td></tr></table>\
	</form>\
	";
	alert("aaa")


	var ifrm = document.createElement("iframe");
	ifrm.id = "calObj";
	ifrm.frameBorder = 0;
	with (ifrm.style){
		position	= "absolute";
		left		= "-999px";
		background	= "#ffffff";
		width		= "200px";
		height		= "166px";
		//z-index	= "999";
	}
	document.body.appendChild(ifrm);

	calObjdoc = document.getElementById('calObj').contentWindow.document;
	calObjdoc.open();
	calObjdoc.write(calStyle);
	calObjdoc.write(calLayout);
	calObjdoc.close();

	calendar_setup();
}

function calendar_setup()
{
	var objMonth = calObjdoc.frmCalendar.month;
	for (i=0;i<12;i++) objMonth.options[i] = new Option(i+1+"¿ù",i);

	var date = new Date;
	var year = date.getYear();
	var month = date.getMonth();
	calendar_update(year,month);
}

function calendar_update(year,month)
{
	if (isNaN(year)){
		year = calObjdoc.frmCalendar.year.value;
		month = calObjdoc.frmCalendar.month.value;
	}

	year = parseInt(year);

	var objYear = calObjdoc.frmCalendar.year;
	var objMonth = calObjdoc.frmCalendar.month;

	for (i=0;i<5;i++) objYear.options[i] = new Option(year+i-2+"³â",year+i-2);
	objYear.selectedIndex = 2;
	objMonth.selectedIndex = month;

	calendar_inner(year,month);
}

function calendar_inner(year,month)
{
	var date = new Date;
	var Y = date.getYear();
	var m = date.getMonth();
	var d = date.getDate();

	var firstDay = new Date(year,month);
	firstDay = firstDay.getDay();
	var lastDay = calendar_lastDay(year,month);

	var obj = calObjdoc.getElementById('calInner');

	for (i=obj.rows.length;i>1;i--) obj.deleteRow(i-1);

	oTr = obj.insertRow();
	for (i=0;i<firstDay;i++) oTr.insertCell();
	cnt = i;

	for (i=1;i<=lastDay;i++){
		if (cnt++%7==0) oTr = obj.insertRow();
		oTd = oTr.insertCell();
		oTd.style.cursor = "pointer";
		oTd.style.backgroundColor = "#f7f7f7";
		oTd.color = "#000000";
		if (Y==year && m==month && d==i){
			oTd.color = "#ff0000";
			oTd.style.fontWeight = "bold";
		}
		oTd.innerText = i;
		oTd.style.color = oTd.color;
		oTd.onmouseover = function(){this.style.backgroundColor = "#316AC5"; this.style.color = "#ffffff"}
		oTd.onmouseout = function(){this.style.backgroundColor = "#f7f7f7"; this.style.color = this.color}
		oTd.onclick = function(){parent.calendar_print(this.innerText)}
	}
	//document.getElementById('calObj').height = calObjdoc.body.scrollHeight;
}

function calendar_move(idx)
{
	var year = calObjdoc.frmCalendar.year.value;
	var month = parseInt(calObjdoc.frmCalendar.month.value) + idx;

	if (month<0){ year--; month=11; }
	if (month==12){ year++; month=0; }

	calendar_update(year,month);
}

function calendar()
{
	if (!_ID('calObj')) calendar_init();

	calInput = event.srcElement;

	var xpos = calendar_get_objectLeft(calInput);
	var ypos = calendar_get_objectTop(calInput) + calInput.offsetHeight + 2;

	var calObj = document.getElementById('calObj');
	calObj.style.pixelLeft = xpos;
	calObj.style.pixelTop = ypos;
	calObj.style.display = "block";
}

function calendar_print(day)
{
	var year = calObjdoc.frmCalendar.year.value;
	var month = calObjdoc.frmCalendar.month.value;

	calInput.value = calendar_format(year,month,day);
	calendar_close();
}

function calendar_format(year,month,day)
{
	month++;
	var format = (calInput.getAttribute("format")!=null) ? calInput.format : "%Y%m%d";

	var Y = year;
	var y = year.substr(2,2);
	var m = calendar_addZero(month);
	var d = calendar_addZero(day);

	format = format.replace(/%Y/g, Y);
	format = format.replace(/%y/g, y);
	format = format.replace(/%m/g, m);
	format = format.replace(/%d/g, d);

	return format;
}

function calendar_close()
{
	var calObj = document.getElementById('calObj');
	calObj.style.display = "none";
}

function calendar_addZero(str){
	return ((str < 10) ? "0" : "") + str;
}

function calendar_lastDay(year,month){
	var leap;
	var last = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if (year%4==0)		leap = true;
	if (year%100==0)	leap = false;
	if (year%400==0)	leap = true;
	if (leap) last[1] = 29;
	return last[month];
}

function calendar_get_objectTop(obj){
	if (obj.offsetParent == document.body) return obj.offsetTop;
	else return obj.offsetTop + get_objectTop(obj.offsetParent);
}

function calendar_get_objectLeft(obj){
	if (obj.offsetParent == document.body) return obj.offsetLeft;
	else return obj.offsetLeft + get_objectLeft(obj.offsetParent);
}

/*** onLoad ÀÌº¥Æ®¿¡ ÇÔ¼ö ÇÒ´ç ***/
function addOnloadEvent(fnc)
{
	if ( typeof window.addEventListener != "undefined" )
		window.addEventListener( "load", fnc, false );
	else if ( typeof window.attachEvent != "undefined" ) {
		window.attachEvent( "onload", fnc );
	}
	else {
		if ( window.onload != null ) {
			var oldOnload = window.onload;
			window.onload = function ( e ) {
				oldOnload( e );
				window[fnc]();
			};
		}
		else window.onload = fnc;
	}
}

function order_print(frmp_nm, frml_nm)
{
	var frmp = document.forms[frmp_nm];
	var frml = document.forms[frml_nm];
	if ( frmp['list_type'][0].checked != true && frmp['list_type'][1].checked != true ) return;

	if ( frmp['list_type'][0].checked == true && frmp['list_type'][0].value == 'list' ){
		if ( PubChkSelect( frml['chk[]'] ) == false ){
			alert( "¼±ÅÃÇÑ ³»¿ªÀÌ ¾ø½À´Ï´Ù." );
			return;
		}

		var cds = new Array();
		var idx = 0;
		var count=frml['chk[]'].length;

		if ( count == undefined ){
			if ( frml['chk[]'].ordno != null ) cds[ idx++ ] = frml['chk[]'].ordno;
			else cds[ idx++ ] = frml['chk[]'].value;
		}
		else
			for ( i = 0; i < count ; i++ )
				if ( frml['chk[]'][i].checked )
					if ( frml['chk[]'][i].ordno != null ) cds[ idx++ ] = frml['chk[]'][i].ordno;
					else cds[ idx++ ] = frml['chk[]'][i].value;

		frmp['ordnos'].value = cds.join( ";" );
	}

	var orderPrint = window.open("","orderPrint","width=750,height=600,menubar=yes,scrollbars=yes" );
	frmp.target='orderPrint';
	frmp.action='../order/_paper.php';
	frmp.submit();
	orderPrint.focus();
}

/* ºê¶ó¿ìÀúº° ÀÌº¥Æ® Ã³¸®*/
function addEvent(obj, evType, fn){
	if (obj.addEventListener) {
		obj.addEventListener(evType, fn, false);
		return true;
	} else if (obj.attachEvent) {
		var r = obj.attachEvent("on"+evType, fn);
		return r;
	} else {
		return false;
	}
}

function delEvent(obj, evType, fn){
	if (obj.removeEventListener) {
		obj.removeEventListener(evType, fn, false);
		return true;
	} else if (obj.detachEvent) {
		var r = obj.detachEvent("on"+evType, fn);
		return r;
	} else {
		return false;
	}
}

function getTargetElement(evt)
{
	if ( evt.srcElement ) return target_Element = evt.srcElement; // ÀÍ½º
	else return target_Element = evt.target; // ÀÍ½º¿Ü
}

function popupEgg(asMallId, asOrderId){
	//Ã¢À» È­¸éÀÇ Áß¾Ó¿¡ À§Ä¡
	iXPos = (window.screen.width - 700) / 2;
	iYPos = (window.screen.height - 600) / 2;
	var egg = window.open("https://gateway.usafe.co.kr/esafe/InsuranceView.asp?mall_id="+asMallId + "&order_id=" + asOrderId, "egg", "width=700, height=600, scrollbars=yes, left=" + iXPos + ", top=" + iYPos);
	egg.focus();
}

function inArray( needle, haystack )
{
	for ( i = 0; i < haystack.length; i++ )
		if ( haystack[i] == needle ) return true;
	return false;
}

/*** AJAX GRAPH METHOD (AGM) ***/
AGM = {
	bMsg : new Array(),
	iobj : new Array(),
	articles: new Array(),
	running: new Array(),
	interverID: '',

	act: function (c)
	{
		if (c && typeof(c.onStart) == 'function'){
			this.func = c;
			this.func.onStart(this);
			this.start();
		}
		else return;
	},

	start: function ()
	{
		this.running = new Array();
		this.clearinterverid();

		this.layout = "\
		<div id=report>\
			<h1>{title}</h1>\
			<table><tr><th>Àü¼Û»óÅÂ</th><td><div id=briefing><ul><li>ºê¸®ÇÎ ¸Þ½ÃÁö »ùÇÃ.</li></ul></div></td></tr></table>\
			<h2 id=report_step>ÁØºñÁß..</h2>\
			<div id=report_line><div id=report_white><div id=report_graph></div></div></div>\
			<p><!--Á¡¼±--></p>\
			<div id=report_btn><a href='javascript:;'><img src='/admin/img/btn_confirm_s.gif' alt=´Ý±â></a></div>\
		</div>\
		";
		this.layout = this.layout.replace(/{title}/,this.layoutTitle);
		popupLayer('',550,300);
		document.getElementById('objPopupLayer').innerHTML = this.layout;
		document.getElementById('report_graph').style.width = "0%";

		if (this.articles.length < 1){
			this.briefing(this.bMsg['chkEmpty'], true);
			this.closeBtn();
			return;
		}

		this.briefing(this.bMsg['chkCount'].replace(/__count__/, this.articles.length), true);
		this.briefing(this.bMsg['start']);
		this.request();
	},

	request: function ()
	{
		if (this.running.length < this.articles.length) // Àü¼ÛÁß
		{
			var idx = this.articles[ this.running.length ];
			var tmp = new Array(); tmp.push(idx);
			this.running.push(tmp);
			document.getElementById('report_step').innerHTML = '[' + this.iobj[0][idx].getAttribute('subject') + '] ³»¿ª Ã³¸®Áß';
			this.func.onRequest(this, idx);
			this.setIntervalId("AGM.graph()", 500);
		}
		else if (this.running.length == this.articles.length){ // Àü¼Û¿Ï·á
			this.clearinterverid();
			this.done();
		}
	},

	complete: function (req)
	{
		this.running[(this.running.length - 1)].push(true);
		var idx = this.running[(this.running.length - 1)][0];
		var subObj = this.iobj[0][idx];
		var response = req.responseText.replace(/{subject}/, subObj.getAttribute('subject'));
		this.briefing(response);
		this.setIntervalId("AGM.graph('continue')", 30);
	},

	error: function (req)
	{
		this.running[(this.running.length - 1)].push(false);
		var idx = this.running[(this.running.length - 1)][0];
		var subObj = this.iobj[0][idx];
		var msg = req.getResponseHeader("Status").replace(/{subject}/, subObj.getAttribute('subject'));
		if (msg == null || msg.length == null || msg.length <= 0)
		{
			this.briefing("Error! Request status is " + req.status);
			this.setIntervalId("AGM.graph('continue')", 30);
		}
		else
		{
			var remsg = '';
			var tmp = msg.split("^");
			for (i = 0; i < tmp.length; i++)
			{
				if (i == 1) remsg += '<ol type="1" style="margin-bottom:10px;">';
				if (i == 0) remsg += tmp[i];
				else remsg += '<li>' + tmp[i] + '</li>';
				if (i > 0 && (i+1) == tmp.length) remsg += '</ol>';
			}
			this.briefing(remsg, false, 'red');

			if (req.status == 600) this.done();
			else this.setIntervalId("AGM.graph('continue')", 30);
		}
	},

	done: function ()
	{
		this.briefing(this.bMsg['end']);
		document.getElementById('report_step').innerHTML = '¿Ï·á';
		this.closeBtn();
		this.clearinterverid();
	},

	closeBtn: function ()
	{
		var btnDiv = document.getElementById('report_btn');
		btnDiv.childNodes[0].href = "javascript:closeLayer();";
		btnDiv.style.display = "block";
		if (this.func && typeof(this.func.onCloseBtn) == 'function') this.func.onCloseBtn(this, btnDiv);
	},

	setIntervalId: function (func, interval)
	{
		this.clearinterverid();
		this.interverID = setInterval(func.toString(), interval);
	},

	clearinterverid: function ()
	{
		clearInterval(this.interverID);
		this.interverID = '';
	},

	briefing: function (str, emtpy, color)
	{
		var briefing = document.getElementById('briefing').childNodes[(document.getElementById('briefing').childNodes[0].nodeType == 1 ? 0 : 1)];
		if (emtpy == true) while (briefing.childNodes.length > 0) briefing.removeChild(briefing.lastChild);
		var liNode = document.createElement('LI');
		briefing.appendChild(liNode);
		liNode.innerHTML = str;
		if (color != '') liNode.style.color = color;
	},

	graph: function (code)
	{
		var limitPercent = eval(this.running.length) / eval(this.articles.length) * 100;
		var nowPercent = eval(document.getElementById('report_graph').style.width.replace( /%/, ''));
		if (limitPercent > nowPercent) document.getElementById('report_graph').style.width = ++nowPercent + '%';
		else if (code == 'continue') this.request();
	}
}

/**
 * extComma(x), extUncomma(x)
 *
 * ¼ýÀÚ Ç¥½Ã (3ÀÚ¸®¸¶´Ù ÄÞ¸¶Âï±â, ¸¶ÀÌ³Ê½º ¹× ¼Ò¼öÁ¡ À¯Áö)
 *
 * @Usage	var money = -1000.12;
 *			money = extComma(money);
 *			alert(money);	// -1,000.12
 *			alert(extUncomma(money));	// -1000.12
 */
function extComma(x){
	var head = '', tail = '', minus = '';
	if (x < 0){
		minus = '-';
		x = x * (-1) + "";
	}
    if ( x.indexOf(".") >= 0 ) {
        head = comma(x.substring ( 0 , x.indexOf(".") ));
        tail = uncomma(x.substring ( x.indexOf(".") + 1, x.length ));
    }
    else head = comma(x);
	x = minus + head;
    if ( tail.toString().length > 0 ) x += "." + tail;
	return x;
}

function extUncomma(x){
	var head = '', tail = '', minus = '';
	if (x < 0){
		minus = '-';
		x = x * (-1) + "";
	}
    if ( x.indexOf(".") >= 0 ) {
        head = uncomma(x.substring ( 0 , x.indexOf(".") ));
        tail = uncomma(x.substring ( x.indexOf(".") + 1, x.length ));
    }
    else head = uncomma(x);
	x = minus + head;
    if ( tail.toString().length > 0 ) x += "." + tail;
	return x;
}

/*** UI NAVIGATION METHOD (UNM) ***/
UNM = {
	m_no: "",
	m_id: "",
	isOver: false,
	agoMenuNo: "",
	overBgcolor: "#e4ff75",
	outBgcolor: "#ffffff",
	popup: "",

	inner: function ()
	{
		document.onclick = this.mouseDown;
		var navigs = document.getElementsByName('navig');

		for (no = 0; no < navigs.length; no++)
		{
			navigs[no].style.position = "relative";
			content = navigs[no].innerHTML;
			navigs[no].innerHTML = '';
			navigs[no].style.zIndex = 0;

			var va = navigs[no].appendChild(document.createElement('A'));
			va.href = "javascript:UNM.callMenu('" + navigs[no].getAttribute('m_no') + "', '" + navigs[no].getAttribute('m_id') + "', '" + navigs[no].getAttribute('popup') + "');";
			va['onmouseover'] = function(e) { UNM.evtHandler(); };
			va.innerHTML = content;
			va.setAttribute('no', no);

			var vDiv = navigs[no].insertBefore(document.createElement('DIV'), navigs[no].childNodes[0]);
			vDiv.setAttribute('id', 'menuarent' + no);
			with (vDiv.style){
				position = 'absolute';
				display = 'none';
				top = -3;
				left = -132;
			}

			var menu = '';
				menu += '<table width="127" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:solid 3px #5f5f5f">';
				menu += '<tr> ';
				menu += '<td style="padding:3px 0 0 10px" height="23" onmouseout="UNM.menuOut(this);" onmouseover="UNM.menuOver(event, this);" onclick="UNM.exec(\'EVENT1\');" class=small1><font color=808080>&#149;</font>&nbsp;<font color=404040>CRM (°í°´°ü¸®) º¸±â</td>';
			    menu += '</tr><tr> ';
				menu += '<td height=1 bgcolor=ebebeb></td>';
				menu += '</tr><tr> ';
				menu += '<td style="padding:2px 0 0 10px" height="22" onmouseout="UNM.menuOut(this);" onmouseover="UNM.menuOver(event, this);" onclick="UNM.exec(\'EVENT2\');" class=small1><font color=808080>&#149;</font>&nbsp;<font color=404040>SMS º¸³»±â</td>';
				menu += '</tr><tr> ';
				menu += '<td height=1 bgcolor=ebebeb></td>';
				menu += '</tr><tr> ';
				menu += '<td style="padding:2px 0 0 10px" height="22" onmouseout="UNM.menuOut(this);" onmouseover="UNM.menuOver(event, this);" onclick="UNM.exec(\'EVENT3\');" class=small1><font color=808080>&#149;</font>&nbsp;<font color=404040>¸ÞÀÏ º¸³»±â</td>';
				menu += '</tr><tr> ';
				menu += '<td height=1 bgcolor=ebebeb></td>';
				menu += '</tr><tr> ';
				menu += '<td style="padding:2px 0 0 10px" height="22" onmouseout="UNM.menuOut(this);" onmouseover="UNM.menuOver(event, this);" onclick="UNM.exec(\'EVENT4\');" class=small1><font color=808080>&#149;</font>&nbsp;<font color=404040>ÁÖ¹®³»¿ª º¸±â</td>';
				menu += '</tr><tr> ';
				menu += '<td height=1 bgcolor=ebebeb></td>';
				menu += '</tr><tr> ';
				menu += '<td style="padding:2px 0 0 10px" height="22" onmouseout="UNM.menuOut(this);" onmouseover="UNM.menuOver(event, this);" onclick="UNM.exec(\'EVENT5\');" class=small1><font color=808080>&#149;</font>&nbsp;<font color=404040>Àû¸³±Ý³»¿ª º¸±â</td>';
				menu += '</tr></table>';
			vDiv.innerHTML = menu;
		}
	},

	callMenu: function (m_no, m_id, popup)
	{
		this.m_no = m_no;
		this.m_id = m_id;
		this.popup = popup;
	},

	evtHandler: function ()
	{
		if (window.navigator.appName.indexOf("Explorer") == -1) return;
		document.onclick = this.mouseDown;
	},

	mouseDown: function (e)
	{
		var event = e || window.event;
		var evtTarget = event.target || event.srcElement;
		if (evtTarget.toString().indexOf("javascript:UNM.callMenu(") && evtTarget.parentNode != null) evtTarget = evtTarget.parentNode;
		if (evtTarget.toString().indexOf("javascript:UNM.callMenu(") && evtTarget.parentNode != null) evtTarget = evtTarget.parentNode;

		if (!UNM.isOver) UNM.hideAll();
		if (!evtTarget.toString().indexOf("javascript:UNM.callMenu(") && evtTarget.getAttribute('no') != null){
			UNM.agoMenuNo = evtTarget.getAttribute('no');
			_ID('menuarent' + evtTarget.getAttribute('no')).style.display = 'block';
			_ID('menuarent' + evtTarget.getAttribute('no')).parentNode.style.zIndex = document.getElementsByName('navig').length;
		}
		else return;
	},

	menuOver: function (e, obj)
	{
		var event = e || window.event;
		this.isOver = true;
		this.chgBgcolor(obj);
	},

	menuOut: function (obj)
	{
		this.isOver = false;
		this.chgBgcolor(obj);
	},

	chgBgcolor: function (obj)
	{
		if (typeof obj.painted == 'undefined') obj.painted = false;
		obj.style.backgroundColor = obj.painted?this.outBgcolor:this.overBgcolor;
		obj.painted = !obj.painted;
	},

	hideAll: function ()
	{
		try {
			document.getElementById("menuarent" + this.agoMenuNo).style.display = 'none';
			document.getElementById("menuarent" + this.agoMenuNo).parentNode.style.zIndex = 0;
		} catch(e) { return; }
	},

	exec: function (key)
	{
		this.hideAll();
		switch(key) {
		case "EVENT1" :
			(this.popup == '1' ? popup :popupLayer)('../member/Crm_view.html?m_id=' + this.m_id,780,600);
		break;
		case "EVENT2" :
			(this.popup == '1' ? popup :popupLayer)('../member/popup.sms.php?m_id=' + this.m_id,780,600);
		break;
		case "EVENT3" :
			(this.popup == '1' ? popup :popupLayer)('../member/email.php?type=direct&m_id=' + this.m_id,780,600);
		break;
		case "EVENT4" :
			(this.popup == '1' ? popup :popupLayer)('../member/orderlist.php?m_no=' + this.m_no,500,600);
		break;
		case "EVENT5" :
			(this.popup == '1' ? popup :popupLayer)('../member/popup.emoney.php?m_no=' + this.m_no,600,500);
		break;
		}
	}
}

function panel(idnm, section)
{
	if (document.getElementById(idnm) == null) return;
	var ajax = new Ajax.Request( "../proc/indb.php",
	{
		method: "post",
		parameters: "mode=getPanel&idnm=" + idnm + "&section=" + section,
		onComplete: function ()
		{
			var req = ajax.transport;
			if (req.status != 200) return;
			if (req.responseText =='') return;
			var obj = document.getElementById(idnm);
			if (idnm == 'paneltop')
			{
				obj.parentNode.style.textAlign = 'right';
				obj.parentNode.style.width = 808;
			}
			obj.innerHTML = req.responseText;

			if(idnm == 'maxlicense'){
				popupLayerAgree(idnm,530,430);
			}
			if(idnm == 'maxagree'){
				window.onload=function(){popupLayerAgree(idnm,530,430);}
			}
		}
	} );
}

/*** license ***/
function popupLayerAgree(s,w,h)
{
	if (!w) w = 600;
	if (!h) h = 400;

	var pixelBorder = 3;
	var titleHeight = 12;
	w += pixelBorder * 2;
	h += pixelBorder * 2 + titleHeight;

	var bodyW = document.body.clientWidth;
	var bodyH = document.body.clientHeight;

	var posX = (bodyW - w) / 2;
	var posY = (bodyH - h) / 2;

	hiddenSelectBox('hidden');

	/*** ¹é±×¶ó¿îµå ·¹ÀÌ¾î***/
	var obj = document.createElement("div");
	with (obj.style){
		position = "absolute";
		left = 0;
		top = 0;
		width = "100%";
		height = document.body.scrollHeight;
		backgroundColor = "#000000";
		filter = "Alpha(Opacity=70)";
		opacity = "0.5";
	}
	obj.id = "objPopupLayerBg";
	document.body.appendChild(obj);

	/*** ³»¿ëÇÁ·¹ÀÓ ·¹ÀÌ¾î ***/
	var obj = document.createElement("div");
	with (obj.style){
		position = "absolute";
		left = posX + document.body.scrollLeft;
		top = posY + document.body.scrollTop;
		width = w;
		height = h;
	}
	obj.id = "objPopupLayer";
	obj.innerHTML = document.getElementById(s).innerHTML;
	document.body.appendChild(obj);
}

function fnc_menu(str_menu,str_path) {
	window.location.href="/admin/comm/comm_return_url.asp?str_menu="+str_menu+"&str_path="+escape(str_path);
}