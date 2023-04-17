/**
 * @fileOverview
 * Textarea (source, text) 영역의 컨텐츠를 수정, 관리하기 위한 HtmlPanel, TextPanel 관련 Source
 */

/**
 * HTML모드(소스모드)의 컨텐츠를 수정, 관리하기 위한 클래스
 *
 * @class
 * @extends Trex.Canvas.BasedPanel
 * @param {Object} canvas
 * @param {Object} config - canvas의 config
 */
Trex.Canvas.HtmlPanel = Trex.Class.create(/** @lends Trex.Canvas.HtmlPanel.prototype */{
	/** @ignore */
	$extend: Trex.Canvas.BasedPanel,
	/** @ignore */
	$const: {
		/** @name Trex.Canvas.HtmlPanel.__MODE */
		__MODE: Trex.Canvas.__HTML_MODE
	},
	initialize: function(canvas, config) {
		this.$super.initialize(canvas, config);
		
		var _processor = new Trex.Canvas.TextAreaProcessor(this.el);
		/**
		 * 생성된 Processor 객체를 리턴한다.
		 * @function
		 * @returns {Object} Processor 객체
		 */
		this.getProcessor = function() {
			return _processor;
		};
		
		this.bindEvents();
		
		this.lastHeight = (this.lastHeight - 9*2).toPx();//"382px";
	},
	bindEvents: function() {
		var _handlers = {
			keydown: function(ev){
				var _canvas = this.canvas;
				var _cvConfig = this.config;
				this.canvas.fireJobs(Trex.Ev.__CANVAS_SOURCE_PANEL_KEYDOWN, ev);
			},
			keyup: function(ev){
				this.canvas.getProcessor().savePosition();
			},
			mousedown: function(ev){
				this.canvas.fireJobs(Trex.Ev.__CANVAS_SOURCE_PANEL_MOUSEDOWN, ev);
			},
			mouseup: function(ev){
				this.canvas.getProcessor().savePosition();	
			},
			click: function(ev) {
				this.canvas.fireJobs(Trex.Ev.__CANVAS_SOURCE_PANEL_CLICK, ev);	
			}
		};
		for(var _eventType in _handlers){
			$tx.observe(this.el, _eventType, _handlers[_eventType].bind(this), true);
		}
	},
	/**
	 * panel 엘리먼트를 가지고 온다.
	 * @function
	 */
	getPanel: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_source" + _initializedId, "Trex.Canvas.HtmlPanel");
	},
	/**
	 * panel 엘리먼트를 감싸고 있는 wrapper 엘리먼트를 가지고 온다.
	 * @function
	 */
	getHolder: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_source_holder" + _initializedId, "Trex.Canvas.HtmlPanel");
	},
	/**
	 * panel을 보이게한다.
	 * @function
	 */
	show: function() {
		this.$super.show();
		var _elPanel = this.el;
		var _elHolder = this.elHolder;
		setTimeout(function(){
			_elPanel.focus();
			if ($tx.msie && $tx.msie_ver < 7) {
				// #552 
				_elHolder.style.padding = "1px";
				setTimeout(function(){
					_elHolder.style.padding = "0px";
				}, 0);
			}			
		}, 100);
	},
	/**
	 * 컨텐츠 영역에 쓰여진 컨텐츠를 얻어온다. 
	 * @function
	 * @returns {String} 컨텐츠 문자열
	 */
	getContent: function() {
		return this.el.value;
	},
	/**
	 * 컨텐츠 영역의 컨텐츠를 주어진 문자열로 수정한다. 
	 * @function
	 * @param {String} content - 컨텐츠
	 */
	setContent: function(content) {
		var validator = new Trex.Validator();
		if (validator.exists(content)) {
			this.el.value = content;
		} else {
			this.el.value = "";
		}
	},
	/**
	 * panel 영역의 높이를 얻어온다.
	 * @function
	 * @returns {String} textarea 영역의 높이 (px)
	 */
	getPanelHeight: function() { 
		return ($tom.getHeight(this.el).parsePx() + 2).toPx(); 
	},
	/**
	 * panel 영역의 높이를 셋팅한다.
	 * @function
	 * @param {Number} width - textarea 영역의 넓이 (px)
	 */
	setPanelHeight: function(height) {
		this.$super.setPanelHeight((height.parsePx() - 2).toPx());
	}
});



/**
 * 텍스트모드의 컨텐츠를 수정, 관리하기 위한 클래스
 *
 * @class
 * @extends Trex.Canvas.BasedPanel
 * @param {Object} canvas
 * @param {Object} config - canvas의 config
 */
Trex.Canvas.TextPanel = Trex.Class.create(/** @lends Trex.Canvas.TextPanel.prototype */{
	/** @ignore */
	$extend: Trex.Canvas.BasedPanel,
	/** @ignore */
	$const: {
		/** @name Trex.Canvas.TextPanel.__MODE */
		__MODE: Trex.Canvas.__TEXT_MODE
	},
	initialize: function(canvas, config) {
		this.$super.initialize(canvas, config);
		
		var _processor = new Trex.Canvas.TextAreaProcessor(this.el);
		/**
		 * 생성된 Processor 객체를 리턴한다.
		 * @function
		 * @returns {Object} Processor 객체
		 */
		this.getProcessor = function() {
			return _processor;
		};
		
		this.bindEvents();
		
		this.lastHeight = (this.lastHeight - 9*2).toPx();//"382px";
	},
	bindEvents: function() {
		var _handlers = {
			keydown: function(ev){},
			keyup: function(ev){},
			mousedown: function(ev){},
			mouseup: function(ev){},
			click: function(ev) {
				this.canvas.fireJobs(Trex.Ev.__CANVAS_TEXT_PANEL_CLICK, ev);
			}			
		};
		for(var _eventType in _handlers){
			$tx.observe(this.el, _eventType, _handlers[_eventType].bind(this), true);
		}
	},
	/**
	 * panel 엘리먼트를 가지고 온다.
	 * @function
	 */
	getPanel: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_text" + _initializedId, "Trex.Canvas.TextPanel");
	},
	/**
	 * panel 엘리먼트를 감싸고 있는 wrapper 엘리먼트를 가지고 온다.
	 * @function
	 */
	getHolder: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_text_holder" + _initializedId, "Trex.Canvas.TextPanel");
	},
	/**
	 * panel을 보이게한다.
	 * @function
	 */
	show: function() {
		this.$super.show();
		var _elPanel = this.el;
		var _elHolder = this.elHolder;
		setTimeout(function(){
			_elPanel.focus();
			if ($tx.msie && $tx.msie_ver < 7) {
				// #552 
				_elHolder.style.padding = "1px";
				setTimeout(function(){
					_elHolder.style.padding = "0px";
				}, 0);
			}			
		}, 100);
	},
	/**
	 * 컨텐츠 영역에 쓰여진 컨텐츠를 얻어온다. 
	 * @function
	 * @returns {String} 컨텐츠 문자열
	 */
	getContent: function() {
		return this.el.value;
	},
	/**
	 * 컨텐츠 영역의 컨텐츠를 주어진 문자열로 수정한다. 
	 * @function
	 * @param {String} content - 컨텐츠
	 */
	setContent: function(content) {
		this.el.value = content;
	},
	/**
	 * panel 영역의 높이를 얻어온다.
	 * @function
	 * @returns {String} textarea 영역의 높이 (px)
	 */
	getPanelHeight: function() { 
		return ($tom.getHeight(this.el).parsePx() + 2).toPx(); 
	},
	/**
	 * panel 영역의 높이를 셋팅한다.
	 * @function
	 * @param {Number} width - textarea 영역의 넓이 (px)
	 */
	setPanelHeight: function(height) {
		this.$super.setPanelHeight((height.parsePx() - 2).toPx());
	}
});

Trex.module("interrupt enter key action @ text panel",
	function(editor, toolbar, sidebar, canvas, config) {
		var _newlinepolicy = canvas.config.newlinepolicy;
		var _insertbr = canvas.config.insertbr;
		if (_newlinepolicy == "br" && _insertbr) {
			canvas.observeJob(Trex.Ev.__CANVAS_SOURCE_PANEL_KEYDOWN, function(ev){
				if (canvas.canHTML()) {
					return;
				}
				canvas.getProcessor().controlEnter(ev);
			});
		}	
	}
);
