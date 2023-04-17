
TrexConfig.addTool(
	"fullscreen", 
	{
		wysiwygonly: false,
		status: false,
		switched: false,
		minHeight: 200,
		minWidth: 766
	}
);

TrexMessage.addMsg({
	'@fullscreen.attach.close.btn': "파일첨부박스",
	'@fullscreen.noti.btn': "일반 글쓰기로",
	'@fullscreen.noti.span': "넓게쓰기 버튼을 다시 누르시면 처음 글쓰기 창 크기로 돌아갑니다."
});

Trex.Tool.FullScreen = Trex.Class.create({
	$const: {
		__Identity: 'fullscreen'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _editor = this.editor;
		var _canvas = _editor.getCanvas();
		
		var _attachBox = _editor.getAttachBox();
		
		var _wrapper = _editor.getWrapper();
		if(!_wrapper) {
			return;
		}
		
		var _fullscreen;
		var _toolHandler = function() {
			if(!_fullscreen) {
				_fullscreen = new Trex.FullScreen(_editor, config);
			}
			_fullscreen.execute();
		};
		
		if(config.switched) { //기본이 전체화면
			if(!_fullscreen) {
				_fullscreen = new Trex.FullScreen(_editor, config);
			}
			_fullscreen.showFullScreen();
		}
		
		this.weave.bind(this)(
			new Trex.Button(this.buttonCfg), 
			null,
			_toolHandler
		);
		
		_canvas.observeKey({ // ctrl + m - 넓게쓰기
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 77
		}, _toolHandler);

		_editor.observeKey({ // ctrl + m - 넓게쓰기
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 77
		}, _toolHandler);
	}
});


Trex.MarkupTemplate.add(
	'fullscreen.notice', 
	'<div class="tx-fullscreen-notice"><span>@fullscreen.noti.span</span><a href="#">@fullscreen.noti.btn</a></div>'
);
Trex.MarkupTemplate.add(
	'fullscreen.linebox', 
	'<div class="tx-fullscreen-line">\
		<div class="tx-fullscreen-line-division">\
			<div class="tx-fullscreen-line-left">&nbsp;</div>\
			<div class="tx-fullscreen-line-right">&nbsp;</div>\
		</div>\
		<div class="tx-fullscreen-line-box">\
			<div class="tx-fullscreen-line-left">&nbsp;</div>\
			<div class="tx-fullscreen-line-right">&nbsp;</div>\
			<a href="#">@fullscreen.attach.close.btn</a>\
		</div>\
	</div>'
);
Trex.FullScreen = Trex.Class.create({
	initialize: function(editor, config) {
		if(!editor) {
			return;
		}
		
		this.isInit = false;
		this.isFullScreen = false;

		this.wrapper = editor.getWrapper();
		this.canvas = editor.getCanvas();
		this.toolbar = editor.getToolbar();
		this.attachBox = editor.getAttachBox();

		this.elSavedHiddens = [];
		this.minHeight = config.minHeight;
		this.minWidth = config.minWidth;

		this.useAttachBox = (this.attachBox.elBox !== undefined);
		this.isAttachBoxDisplay = false;

		this.resizeHandler = this.resizeContainer.bind(this);

		this.toolbar.observeJob("toolbar.advanced.fold", function() { 
			if (this.isFullScreen) {
				this.resizeContainer();
			}
		}.bind(this));
		
		this.toolbar.observeJob("toolbar.advanced.spread", function() { 
			if (this.isFullScreen) {
				this.resizeContainer();
			}
		}.bind(this));
		
		if(typeof(showAttachBox) != 'undefined') { //NOTE: service specific job for changing attachbox's display(callback)
			this.showAttachBoxAtServiceForSave = showAttachBox; //NOTE: cuz disable showAttachBox() at fullscreen mode
		}
		if(typeof(hideAttachBox) != 'undefined') { //NOTE: service specific job for changing attachbox's display(callback)
			this.hideAttachBoxAtServiceForSave = hideAttachBox; //NOTE: cuz disable hideAttachBox() at fullscreen mode
		}
	},
	execute: function() {
		if(this.isFullScreen) {
			this.showNormalScreen();
		} else {
			this.showFullScreen();
		}
	},
	onAttachClick: function() {
		this.attachClickHandler(!this.isAttachBoxDisplay);
		this.resizeContainer();
	},
	attachClickHandler: function(isAttachBoxDisplay) {
		if(isAttachBoxDisplay) {
			this.showAttachBox();
		} else {
			this.hideAttachBox();
		}
	},
	showNormalScreen: function() {
		if(!this.isFullScreen) {
			return;
		}

		document.documentElement.style.overflow = '';
		document.body.style.overflow = '';

		//NOTE: Service Specific
		this.showNormalScreenAtService();

		var _wrapper = this.wrapper;
		if(!_wrapper) {
			return;
		}

		_wrapper.style.width = '';
		$tx.removeClassName(_wrapper, 'tx-editor-fullscreen');

		this.elSavedHiddens.each(function(el) {
			el.style.visibility = 'visible';
		});

		if(parent) {
			if (parent.parent) {
				$tx.stopObserving(parent.parent, 'resize', this.resizeHandler);
			} else {
				$tx.stopObserving(parent, 'resize', this.resizeHandler);
			}
		} else {
			$tx.stopObserving(window,'resize', this.resizeHandler);
		}

		this.canvas.setCanvasSize({
		 	height: this.panelNormalHeight.toPx()
		});

		//첨부파일박스
		if(this.useAttachBox) {
			this.attachClickHandler(this.attachBox.checkDisplay());
		}

		this.canvas.fireJobs("plugin.normalscreen.change");
		
		//NOTE: Service Specific
		if(this.showAttachBoxAtServiceForSave) {
			window.showAttachBox = this.showAttachBoxAtServiceForSave;
		}
		if(this.hideAttachBoxAtServiceForSave) {
			window.hideAttachBox = this.hideAttachBoxAtServiceForSave;
		}
		
		
		for (var i = 0; i < this.relativeParents.length; i++) {
			var element = this.relativeParents.pop();
			var value = this.relativeValues.pop();
			element.style.position = value;
		}
		
		this.isFullScreen = false;
		if (!$tx.msie) {
			setTimeout(function() {
				var _elIcon = $tom.collect($tx("tx_fullscreen"), "a");
				_elIcon.focus();
			}.bind(this), 500);
		}
	},
	showFullScreen: function() {
		if(this.isFullScreen) {
			return;
		}

		if(!this.isInit) {
			this.generate();
		}

		document.documentElement.style.overflow = 'hidden'; //Remove basic scrollbars
		document.documentElement.scrollTop = 0;
		document.body.style.overflow = 'hidden';

		//NOTE: Service Specific
		this.showFullScreenAtService();
		if(this.showAttachBoxAtServiceForSave) {
			window.showAttachBox = function(){
				this.showAttachBox();
				this.resizeContainer();
			}.bind(this);
		}
		if(this.hideAttachBoxAtServiceForSave) {
			window.hideAttachBox = function(){
				this.hideAttachBox();
				this.resizeContainer();
			}.bind(this);
		}
		
		var _wrapper = this.wrapper;

		if(!_wrapper) {
			return;
		}
		$tx.addClassName(_wrapper, 'tx-editor-fullscreen');
		
		//Hide select,activeX 
		var _savedHiddens = [];
		["select", "embed", "object"].each(function(name) {
			var _elHdns = $A(document.getElementsByTagName(name));
			_elHdns.each(function(el) {
				el.style.visibility = 'hidden';
				_savedHiddens.push(el);
			});
		});
		this.elSavedHiddens = _savedHiddens;

		//attach file box
		if(this.useAttachBox) {
			this.attachClickHandler(this.attachBox.checkDisplay());
		}

		var _panel = this.canvas.getCurrentPanel();
		this.panelNormalHeight = _panel.getPosition().height;

		if(parent) {
			if (parent.parent) {
				$tx.observe(parent.parent, 'resize', this.resizeHandler);
			} else {
				$tx.observe(parent, 'resize', this.resizeHandler);
			}
		} else {
			$tx.observe(window,'resize', this.resizeHandler);
		}

		this.canvas.fireJobs("plugin.fullscreen.change");

		// make trace element and move container to body's direct child
		window.wrapper = _wrapper;
		this.relativeParents = [];
		this.relativeValues = [];
		var parent = _wrapper.offsetParent;
		while (parent && parent.tagName && parent.tagName.toUpperCase() != "HTML" && parent.tagName.toUpperCase() != "BODY") {
			var position = (parent.currentStyle)?parent.currentStyle['position']:window.getComputedStyle(parent, null).getPropertyValue('position');
			if (position.toLowerCase() == "relative") {
				this.relativeParents.push(parent);
				this.relativeValues.push(position);
				parent.style.position = "static";
			}
			parent = parent.offsetParent;
		}
		
		this.isFullScreen = true;
		this.resizeContainer();
		if (!$tx.msie) {
			var _elIcon = $tom.collect($tx("tx_fullscreen"), "a");
			_elIcon.focus();
		}
	},
	generate: function() {
		if(this.isInit) {
			return;
		}

		var _wrapper = this.wrapper;
		if(!_wrapper) {
			return;
		}

		var _elNoti = Trex.MarkupTemplate.get("fullscreen.notice").evaluateAsDom({});
		$tom.insertFirst(_wrapper, _elNoti);
		
		var _elNotiBtn = $tom.collect(_elNoti, 'a');
		$tx.observe(_elNotiBtn,'click', function() { //NOTE: cuz
			if(this.isFullScreen) {
				this.showNormalScreen();
			} else {
				this.showFullScreen();
			}
		}.bind(this));

		var _elCanvas = this.canvas.elContainer;
		var _elLine = Trex.MarkupTemplate.get("fullscreen.linebox").evaluateAsDom({});
		$tom.insertNext(_elLine, _elCanvas);

		var _attr = { className: "tx-fullscreen-line-box"};
		if($tx.msie_ver == '5.5'){
			_attr.align = "center"; 
		}
		
		var _elLineBox = $tom.collect(_elLine, 'div.tx-fullscreen-line-box');
		if($tx.msie_ver == '5.5'){
			_elLineBox.align = "center"; 
		}
		
		var _elLineBtn = this.elLineBtn = $tom.collect(_elLineBox, "a");
		$tx.observe(_elLineBtn,'click', this.onAttachClick.bind(this));
		this.isInit = true;
	},
	getAttachBoxPosition: function() {
		if(this.isAttachBoxDisplay) {
			return $tom.getPosition(this.attachBox.elBox);
		} else {
			return {x:0, y:0, width:0, height:0};
		}
	},
	resizeContainer: function() {
		//NOTE: Service Specific
		this.resizeScreenAtService();
		var _panelPosY = this.canvas.getCanvasPos().y;
		var _attachBoxPosition = this.getAttachBoxPosition();

		var _panelHeight = 0;
		if (document.documentElement.clientHeight > 0) {
			_panelHeight = document.documentElement.clientHeight - _panelPosY - 17; //NOTE: cuz line
		}else{
			_panelHeight = document.documentElement.offsetHeight - _panelPosY - 17;
		}
		
		if(_attachBoxPosition.height > 0) {
			_panelHeight -= _attachBoxPosition.height + 20; //NOTE: cuz margin
		}
		_panelHeight = Math.max(_panelHeight, this.minHeight);

		this.canvas.setCanvasSize({
			height: _panelHeight.toPx()
		});

		var _panelWidth = 0;
		if(document.documentElement.clientWidth > 0){
			_panelWidth = document.documentElement.clientWidth;
		}else{
			_panelWidth = document.documentElement.offsetWidth;
		}
		
		_panelWidth = Math.max(_panelWidth, this.minWidth);

		var _wrapper = this.wrapper;
		if(!_wrapper) {
			return;
		}
		_wrapper.style.width = _panelWidth.toPx();
	},
	showAttachBox: function() {
		if(this.attachBox.useBox) {
			$tx.addClassName(this.elLineBtn, "tx-attach-close");
			$tx.show(this.attachBox.elBox);
			this.isAttachBoxDisplay = true;
		}
	},
	hideAttachBox: function() {
		if(this.attachBox.useBox) {
			$tx.removeClassName(this.elLineBtn, "tx-attach-close");
			$tx.hide(this.attachBox.elBox);
			this.isAttachBoxDisplay = false;
		}
	},
	showFullScreenAtService: function() { //NOTE: service specific job for fullscreen(callback)
		if(typeof(showFullScreen) != 'undefined') {
			showFullScreen();
		}
	},
	showNormalScreenAtService: function() { //NOTE: service specific job for escaping from fullscreen(callback)
		if(typeof(showNormalScreen) != 'undefined') {
			showNormalScreen();
		}
	},
	resizeScreenAtService: function() { //NOTE: service specific job for resize(callback)
		if(typeof(resizeScreen) != 'undefined') {
			resizeScreen();
		}
	}
});

