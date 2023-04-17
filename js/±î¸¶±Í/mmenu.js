/*****************************************************
 * ypSlideOutMenu
 * 3/04/2001
 * 
 * --youngpup--
 *
 * modified 25/04/05
 * Jan Wulff
 *****************************************************/

ypSlideOutMenu.Registry = []
ypSlideOutMenu.aniLen = 100
ypSlideOutMenu.hideDelay = 100
ypSlideOutMenu.minCPUResolution = 10

// constructor
function ypSlideOutMenu(id, dir, left, top, width, height, parentid)
{
	this.ie  = document.all ? 1 : 0
	this.ns4 = document.layers ? 1 : 0
	this.dom = document.getElementById ? 1 : 0

	if (this.ie || this.ns4 || this.dom) {
		this.id			 = id
		this.dir		 = dir
		this.orientation = dir == "left" || dir == "right" ? "h" : "v"
		this.dirType	 = dir == "right" || dir == "down" ? "-" : "+"
		this.dim		 = this.orientation == "h" ? width : height
		this.hideTimer	 = false
		this.aniTimer	 = false
		this.open		 = false
		this.over		 = false
		this.startTime	 = 0

		this.sliding	 = false
		this.parentid	 = parentid
		this.showcount	 = 0

		// global reference to this object
		this.gRef = "ypSlideOutMenu_"+id
		eval(this.gRef+"=this")
		
		this.initleft = left
		this.inittop = top
		this.initwidth = width
		this.initheight = height
		this.showcount = 0;


		// add this menu object to an internal list of all menus
		ypSlideOutMenu.Registry[id] = this

		var d = document

                var strCSS = '<style type="text/css">';
                strCSS += '#' + this.id + 'Container { visibility:hidden; '
		strCSS += 'left:' + left + 'px; '
		strCSS += 'top:' + top + 'px; '
		strCSS += 'overflow:hidden; z-index:10000; }'
		strCSS += '#' + this.id + 'Container, #' + this.id + 'Content { position:absolute; '
		strCSS += 'width:' + width + 'px; '
		strCSS += 'height:' + height + 'px; '
		strCSS += 'clip:rect(0 ' + width + ' ' + height + ' 0); '
		strCSS += '}'
                strCSS += '</style>';

                d.write(strCSS)

		this.load()
	}
}

ypSlideOutMenu.writeCSS = function() {
	document.writeln('<style type="text/css">');
	for (var id in ypSlideOutMenu.Registry) {
		document.writeln(ypSlideOutMenu.Registry[id].css);
	}
	document.writeln('</style>');
}

ypSlideOutMenu.prototype.load = function() {
	var d = document
	var lyrId1 = this.id + "Container"
	var lyrId2 = this.id + "Content"
	var obj1 = this.dom ? d.getElementById(lyrId1) : this.ie ? d.all[lyrId1] : d.layers[lyrId1]
	if (obj1) var obj2 = this.ns4 ? obj1.layers[lyrId2] : this.ie ? d.all[lyrId2] : d.getElementById(lyrId2)
	// var temp

	if (!obj1 || !obj2) window.setTimeout(this.gRef + ".load()", 100)
	else {
		this.container	= obj1
		this.menu		= obj2
		this.style		= this.ns4 ? this.menu : this.menu.style
		this.homePos	= eval("0" + this.dirType + this.dim)
		this.outPos		= 0
		this.accelConst	= (this.outPos - this.homePos) / ypSlideOutMenu.aniLen / ypSlideOutMenu.aniLen 

		// set event handlers.
		if (this.ns4) this.menu.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
		this.menu.onmouseover = new Function("ypSlideOutMenu.showMenu('" + this.id + "')")
		this.menu.onmouseout = new Function("ypSlideOutMenu.hideMenu('" + this.id + "')")

		//set initial state
		this.endSlide()
	}
}
	
ypSlideOutMenu.showMenu = function(id)
{
	//stop the dropdowns on safari
	if (navigator.userAgent.indexOf('Safari') != -1) {
	
	}else{

	var reg = ypSlideOutMenu.Registry
	var obj = ypSlideOutMenu.Registry[id]
	
        if (id == 'menu100' && document.getElementById('flashy')) {
          document.getElementById('flashy').style.visibility = 'hidden';
        }
		if ((id == 'menu200' || id == 'menu300') && document.getElementById('flashy7')) {
          document.getElementById('flashy7').style.visibility = 'hidden';
        }
		
	if (obj.container) {
		obj.over = true

		// close other menus.
		// for (menu in reg) if (id != menu) ypSlideOutMenu.hide(menu)

		// if this menu is scheduled to close, cancel it.
		if (obj.hideTimer) { reg[id].hideTimer = window.clearTimeout(reg[id].hideTimer) }

		obj.showcount++;

		// if this menu is closed, open it.
		if (!obj.open && !obj.aniTimer) reg[id].startSlide(true)
	}
	}
}

ypSlideOutMenu.hideMenu = function(id)
{
	// schedules the menu to close after <hideDelay> ms, which
	// gives the user time to cancel the action if they accidentally moused out
	var obj = ypSlideOutMenu.Registry[id]
	if (obj.container) {
		if (obj.hideTimer) window.clearTimeout(obj.hideTimer)
		
		obj.showcount--;
		
		obj.hideTimer = window.setTimeout("ypSlideOutMenu.hide('" + id + "')", ypSlideOutMenu.hideDelay);
	}
}

ypSlideOutMenu.hide = function(id)
{
	var obj = ypSlideOutMenu.Registry[id]
	var reg = ypSlideOutMenu.Registry
	obj.over = false

	if (obj.hideTimer) window.clearTimeout(obj.hideTimer)
	
	// flag that this scheduled event has occured.
	obj.hideTimer = 0
	
	var close = true;
	
	for (menu in reg) {
	// for each child, if either
	// 1. the child is open or
	// 2. the child is closing (but hasn't closed yet)
	// then we don't close this menu.
		var pid = ypSlideOutMenu.Registry[menu].parentid;
		if(pid == id) {
			if (ypSlideOutMenu.Registry[menu].open) close = false;
			if (!ypSlideOutMenu.Registry[menu].open && ypSlideOutMenu.Registry[menu].sliding) close = false;
		}
	}

	// if this menu is open, close it.
	if (obj.open && !obj.aniTimer && close && !obj.showcount) {
          obj.startSlide(false);
          if (id == 'menu100' && document.getElementById('flashy')) {
            document.getElementById('flashy').style.visibility = 'visible';
          }
		  if ((id == 'menu200' || id == 'menu300') && document.getElementById('flashy7')) {
          document.getElementById('flashy7').style.visibility = 'visible';
        }
		  
        }
}

ypSlideOutMenu.prototype.startSlide = function(open) {
	this[open ? "onactivate" : "ondeactivate"]()
	this.open = open
	if (open) this.setVisibility(true)
	this.startTime = (new Date()).getTime()	
	this.sliding = true;
	this.aniTimer = window.setInterval(this.gRef + ".slide()", ypSlideOutMenu.minCPUResolution)
}

ypSlideOutMenu.prototype.slide = function() {
        var elapsed = (new Date()).getTime() - this.startTime
	if (elapsed > ypSlideOutMenu.aniLen) this.endSlide()
	else {
		var d = Math.round(Math.pow(ypSlideOutMenu.aniLen-elapsed, 2) * this.accelConst)
		if (this.open && this.dirType == "-")		d = -d
		else if (this.open && this.dirType == "+")	d = -d
		else if (!this.open && this.dirType == "-")	d = -this.dim + d
		else										d = this.dim + d

		this.moveTo(d)
	}
}

ypSlideOutMenu.prototype.endSlide = function() {
        this.aniTimer = window.clearTimeout(this.aniTimer)
	this.moveTo(this.open ? this.outPos : this.homePos)
	if (!this.open) this.setVisibility(false)
	this.sliding = false;
	if ((this.open && !this.over) || (!this.open && this.over) && (!this.parent || this.parent.open)) {
		this.startSlide(this.over)
	} else {
		var overchild = false;
		var reg = ypSlideOutMenu.Registry
		for (menu in reg) {
			var pid = ypSlideOutMenu.Registry[menu].parentid
			if (pid == this.id) overchild = ypSlideOutMenu.Registry[menu].over ? true : overchild
		}
		if(!overchild && this.parentid && !ypSlideOutMenu.Registry[this.parentid].over) ypSlideOutMenu.hide(this.parentid);
	}
}

ypSlideOutMenu.prototype.setVisibility = function(bShow) { 
	var s = this.ns4 ? this.container : this.container.style
	s.visibility = bShow ? "visible" : "hidden"
}
ypSlideOutMenu.prototype.moveTo = function(p) { 
	this.style[this.orientation == "h" ? "left" : "top"] = this.ns4 ? p : p + "px"
}
ypSlideOutMenu.prototype.getPos = function(c) {
	return parseInt(this.style[c])
}

// events
ypSlideOutMenu.prototype.onactivate		= function() { }
ypSlideOutMenu.prototype.ondeactivate	= function() { }