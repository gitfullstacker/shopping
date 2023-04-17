/**
 * @fileOverview
 * wysiwyg 영역의 컨텐츠를 수정, 관리하기 위한 WysiwygPanel 관련 Source
 */

(function() {
/**
 * wysiwyg 영역의 컨텐츠를 수정, 관리하기 위한 클래스로 <br/>
 * wysiwyg의 객체 접근하여 이벤트를 부여하거나 속성 값들을 얻어온다. <br/>
 *
 * @class
 * @extends Trex.Canvas.BasedPanel
 * @param {Object} canvas
 * @param {Object} config - canvas의 config
 */
Trex.Canvas.WysiwygPanel = Trex.Class.create(/** @lends Trex.Canvas.WysiwygPanel.prototype */{
	/** @ignore */
	$extend: Trex.Canvas.BasedPanel,
	/** @ignore */
	$const: {
		/** @name Trex.Canvas.WysiwygPanel.__MODE */
		__MODE: Trex.Canvas.__WYSIWYG_MODE
	},
	initialize: function(canvas, config) {
		StopWatch.lap("Started WysiwygPanel.init");
		var _panel = this;
		var _canvas = canvas; 
		config = Object.extend({}, config);
		
		this.$super.initialize(canvas, config);

		var _elPanel = this.el;
		var _win = _elPanel.contentWindow;
		var _doc;
		var _processor;
		
		var _name = this.constructor.__MODE;
		/**
		 * panel의 이름을 리턴한다. 
		 * @function
		 * @returns {String} 'html'
		 */
		this.getName = function() { return _name; };
		/**
		 * wysiwyg 영역의 document 객체를 넘겨준다. 
		 * @function
		 * @returns {Element} wysiwyg 영역의 document 객체
		 */
		this.getDocument = function() { return _doc; };
		/**
		 * wysiwyg 영역의 window 객체를 넘겨준다. 
		 * @function
		 * @returns {Element} wysiwyg 영역의 window 객체
		 */
		this.getWindow = function() { return _win; };
		
		/**
		 * wysiwyg 영역에 쓰여진 컨텐츠를 얻어온다. 
		 * @function
		 * @returns {String} 컨텐츠 문자열
		 */
		this.getContent = function() { return _doc.body.innerHTML; };
		/**
		 * wysiwyg 영역의 컨텐츠를 주어진 문자열로 수정한다. 
		 * @function
		 * @param {String} content - 컨텐츠
		 */
		this.setContent = function(content) { 
			_doc.body.innerHTML = content ? content.replace(/\ufeff/g, "") : config.bogus_html;
			if ($tx.msie) {
				var _pNodes = $tom.collectAll(_doc.body, 'p,li');
				for (var i=0,len=_pNodes.length; i<len; i++) {
					if($tom.getLength(_pNodes[i]) == 0) {
						_pNodes[i].innerHTML = '&nbsp;';
					} 
					if($tom.getLength(_pNodes[i]) == 1 && _pNodes[i].innerHTML == '&nbsp;') {
						_pNodes[i].innerHTML = '';
					} 
				}
			}
		 };
		
		/**
		 * 생성된 Processor 객체를 리턴한다.
		 * @function
		 * @returns {Object} Processor 객체
		 */
		this.getProcessor = function() { return _processor; };
		
		/**
		 * wysiwyg 영역에 포커스를 준다.
		 * @function
		 * @see Trex.Canvas.Processor#focus
		 */
		this.focus = function() { _processor.focus(); };
		
		/**
		 * 스타일명으로 wysiwyg 영역의 스타일 값을 얻어온다.
		 * @function
		 * @param {String} name - 스타일명
		 * @returns {String} 해당 스타일 값
		 */
		this.getStyle = function(name) { return $tx.getStyle(_doc.body, name); };
		/**
		 * wysiwyg 영역에 스타일을 적용한다.
		 * @function
		 * @param {Object} styles - 적용할 스타일
		 */
		this.addStyle = function(styles) {
			try {
				for(var name in styles) {
					_doc.body.style[name] = styles[name];
				}
			}catch(e){}
		};
		
		/**
		 * 현재 wysiwyg 영역의 수직 스크롤 값을 얻어온다.
		 * @function
		 * @returns {Number} 수직 스크롤 값
		 */
		this.getScrollTop = function() { return $tom.getScrollTop(_doc); };
		/**
		 * wysiwyg 영역의 수직 스크롤 값을 셋팅한다.
		 * @function
		 * @param {Number} scrollTop - 수직 스크롤 값
		 */
		this.setScrollTop = function(scrollTop) {
			$tom.setScrollTop(_doc, scrollTop);
		};
		/**
		 * 현재 wysiwyg 영역의 수평 스크롤 값을 얻어온다.
		 * @function
		 * @returns {Number} 수평 스크롤 값
		 */
		this.getScrollLeft = function() { return $tom.getScrollLeft(_doc); };
		
		var _relative;
		/**
		 * 특정 노드의 wysiwyg 영역에서의 상대 위치를 얻어온다.
		 * @function
		 * @param {Element} node - 특정 노드
		 * @returns {Object} position 객체 = {
		 *								x: number,
		 *								y: number,
		 *								width: number,
		 *								height: number
		 *						}
		 */
		this.getPositionByNode = function(node) {
			return _relative.getRelative(node);
		};
		
		var _webfontLoader;
		/**
		 * 컨텐츠를 파싱하여 사용되고 있는 웹폰트가 있으면, 웹폰트 css를 로딩한다.<br/>
		 * 로딩속도를 향상시키기 위해 본문을 파싱하여 웹폰트를 사용할 경우에만 동적으로 웹폰트 CSS를 호출한다.  
		 * @function
		 * @param {String} content - 컨텐츠
		 */
		this.includeWebfontCss = function(content) {
			if ($tx.msie) {
				_webfontLoader.load(content);
			}
		};
		/**
		 * 본문에 사용된 웹폰트명 목록을 리턴한다.
		 * @function
		 * @returns {Array} 사용하고 있는 웹폰트명 목록
		 */
		this.getUsedWebfont = function() {
			if (!$tx.msie) {
				return [];
			}
			return _webfontLoader.getUsed();
		};
		
		var _isJsHolding = false;
		var _jsQueue = [];
		var _runScript = function() {
			if(_jsQueue.length == 0) {
				return;
			}
			if(!_isJsHolding) {
				_isJsHolding = true;
				try {
					_win.eval(_jsQueue.shift());
				} catch(e) {
					console.log(e);
				} finally {
					_isJsHolding = false;
				}
			}
			setTimeout(_runScript, 5);
		};
		/**
		 * 자바스크립트를 동적으로 실행한다
		 * @function
		 * @param {String} script - 자바스크립트 문자열
		 */
		this.runScript = function(script) {
			_jsQueue.push(script);
			_runScript();
		};

		/* Panel Iframe Initialize ---------------------------------------------------- */
		//NOTE: Cuz different domain
		_canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function(panelDoc) {
			StopWatch.lap("start initPanel");
			_doc = panelDoc;
			installHyperscript(_win, _doc);
			if(config.newlinepolicy == "br"){
				_processor = new Trex.Canvas.ProcessorBR(_win, _doc);
			}else{
				_processor = new Trex.Canvas.ProcessorP(_win, _doc);	
			}
			_relative = new WysiwygRelative(_doc, _elPanel);
			_webfontLoader = new WebfontLoader(_doc, config);
			
			if(!(config.readonly || false)) {
				//Firefox 3, Safari 3, Opera 9, Google Chrome, and Internet Explorer (since 5.5).
				if($tx.msie || $tx.chrome || $tx.webkit_ver >= 3) { 
					_doc.body.setAttribute("contentEditable", "true");
					StopWatch.lap("After designMode on In initPanel ");
				} else { //old version
					setTimeout(function(){
						try{
							_doc.designMode = "On";
							if ($tx.gecko) {
								_doc.execCommand("enableInlineTableEditing", false, false);
								StopWatch.lap("After designMode on In initPanel ");
							}
						}catch(e){
							_panel.designModeActivated = false;
						}	
					}, 10);
				}
			}
			try {
				_panel.setBodyStyle(_doc, config.styles);
			} catch(e) {}
			_panel.setContent();
			Editor.__PANEL_LOADED = true;
			StopWatch.lap("end initPanel");
		});
		
		/* Event Hook ----------------------------------- */
		_canvas.reserveJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function(panelDoc) {
			try {
				_panel.setFontStyle(_doc, config.styles);
			} catch(e) {}
			_panel.bindEvents(_win, _doc, _canvas, config);
		}, 500);	
		
		StopWatch.lap("before set iframe src in WysiwygPanel");
		/* Iframe Page Load ---------------------------------------------------- */
		_elPanel.setAttribute("src", config.wysiwygUrl);
		
		StopWatch.lap("Finished WysiwygPanel.init");
	},
	bindEvents : function(win, doc, canvas, config) {
		var _doc = doc;
		var _win = win;
		var _canvas = canvas;
		var _cvConfig = config;
		var _history = _canvas.history;
		var _processor = _canvas.getProcessor();
		
		/* wysiwyg handler */
		var _cachedKeyCode;
		var _typingCount = 0;
		var _isNewTypingForSync = false;
		
		var _queryKey = {};
		[13, 8, 32, 33, 34, 37, 38, 39, 40, 46].each( function(key){
			_queryKey[key] = true;
		});
			
		var _wysiwyghandlers = {
			keydown: function(ev) {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_KEYDOWN, ev);
				if(config.useHotKey) {
					_canvas.fireKeys(ev);
				}
			},
			keypress: function(ev) { //NOTE: cuz typing check
				switch(ev.keyCode){
					case 8:  case 16: case 17: case 18: 
					case 32: case 33: case 34:
					case 37:	case 38: 	case 39: 	case 40:
					case 46:
					case 229: // hangul 
						return;	
				}
				if(_cachedKeyCode && _cachedKeyCode == ev.keyCode){
					return;
				} else {
					if(++_typingCount > 10) {
						_queryState(ev);
						_typingCount = 0;
					}
				}
				_cachedKeyCode = ev.keyCode;	
			},
			keyup: function(ev) {
				if(_queryKey[ev.keyCode]) {
					_processor.clearDummy();
				}
				_history.saveHistoryByKey( {
					'code': ev.keyCode,
					'ctrl': ev.ctrlKey || ( ev.keyCode == 17),
					'alt': ev.altKey || ( ev.keyCode == 18),
					'shift': ev.shiftKey || ( ev.keyCode == 16)
				});
				
				try {
					_isNewTypingForSync = true;
					_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_KEYUP, ev);
					if (_queryKey[ev.keyCode]) {
						_queryState(ev);
					}
					if(ev.keyCode == Trex.__KEY.DELETE || ev.keyCode == Trex.__KEY.BACKSPACE) { //NOTE: content change by (Del/Backspace) keys Cuz Sync attachments
						_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_DELETE_SOMETHING);
					}
				}catch(e){
					
				}
			},
			mouseover: function(ev) {
				try {
					_canvas.fireMouseover($tx.element(ev));
				}catch (e) {
					console.log(e);
				}
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_MOUSEOVER, ev);
			},
			mousedown: function(ev) {
				_processor.clearDummy();
				try {
					_canvas.fireElements($tx.element(ev));
				} catch(e) {
					console.log(e);
				}
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_MOUSEDOWN, ev);
				if (_history.isNewTypingForUndo) {
					_history.saveHistory();
				}
			},
			mouseup: function(ev) {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_MOUSEUP, ev);
				setTimeout(function(){
					_propertySyncHandler(true);
				}, 20);
			},
			click: function(ev) {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_CLICK, ev);
			},
			scroll: function(ev) {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_SCROLLING, ev);
			}
		};
		
		var handlers = _wysiwyghandlers;
		for(var eventType in handlers){
			var handler = handlers[eventType];
			if (eventType == "keypress") {
				eventType = ($tx.msie || $tx.webkit) ? "keydown" : "keypress";
			}
			if(eventType == "scroll") {
				if ($tx.opera) {
					setTimeout(function(){
						$tx.observe(_win, eventType, handler, false);
					}, 100);
				}else{
					$tx.observe(_win, eventType, handler, false);
				}
			} else {
				$tx.observe(_doc, eventType, handler, false);
			}
		}
		
		/* Panel Event Handler - Private Method ---------------------------- */
		var _propertySyncHandler = function(isMouseEv) {
			try {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS);
				if(!isMouseEv) {
					_canvas.fireElements(_processor.getTxSel().getNode());
				}
			} catch(e) {
				console.log(e);
			}
		};

		var _queryState = function(ev) {
			if (!_canvas.canHTML()) {
				return;
			}
			var _processor = _canvas.getProcessor();
			setTimeout(function(){
				_propertySyncHandler();
			}, 0);
		};
		
		_canvas.syncProperty = function(isMouseEv) {
			setTimeout(function(){
				_propertySyncHandler(isMouseEv);
			}, 20);
		};
		
		var _intvl = -1;
		var _checkContentChange = function() { //NOTE: periodically content change check Cuz Sync attachments
			if(_isNewTypingForSync) {
				_canvas.fireJobs(Trex.Ev.__CANVAS_PANEL_DELETE_SOMETHING);
				_isNewTypingForSync = false;
			}
		};
		setTimeout(function() {
			_intvl = setInterval(_checkContentChange, 3000);
		}, 10000);
	},
	setBodyStyle: function(doc, styles) {
		//exclude color, font-size, font-family, line-height
		for(var _style in styles) {
			if("||color||fontSize||fontFamily||lineHeight||".indexOf("||" + _style + "||") < 0) {
				doc.body.style[_style] = styles[_style];
			}
		}
	},
	setFontStyle: function(doc, styles) {
		var _csses = new Template("\
			body, td, button {\
				color:#{color};\
				font-size:#{fontSize};\
				font-family:#{fontFamily};\
				line-height:#{lineHeight};\
			}\
			a, a:hover, a:link, a:active, a:visited { color:#{color}; }\
			div.txc-search-border { border-color:#{color}; }\
			div.txc-search-opborder { border-color:#{color}; }\
			img._tx-unresizable { width: auto !important; height: auto !important; }\
			blockquote.txc-info h3, blockquote.txc-info h4 { font-size:#{fontSize}; }\
			button a { text-decoration:none #{if:browser=='firefox'}!important#{/if:browser}; color:#{color} #{if:browser=='firefox'}!important#{/if:browser}; }\
		").evaluate(Object.extend(styles, {
			'browser': $tx.browser
		}));
				
		var _elStyle = doc.createElement('style');
		_elStyle.setAttribute("type", "text/css");
		if (_elStyle.styleSheet) { // IE
		    _elStyle.styleSheet.cssText = _csses;
		} else { // the other
			_elStyle.textContent = _csses;
		}
		doc.getElementsByTagName('head')[0].appendChild(_elStyle);
	},
	/**
	 * panel 엘리먼트를 가지고 온다.
	 * @function
	 */
	getPanel: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_wysiwyg" + _initializedId, "Trex.Canvas.WysiwygPanel");
	},
	/**
	 * panel 엘리먼트를 감싸고 있는 wrapper 엘리먼트를 가지고 온다.
	 * @function
	 */
	getHolder: function(config) {
		var _initializedId = ((config.initializedId)? config.initializedId: "");
		return $must("tx_canvas_wysiwyg_holder" + _initializedId, "Trex.Canvas.WysiwygPanel");
	},
	/**
	 * wysiwyg panel을 보이게한다.
	 * @function
	 */
	show: function() {
		this.$super.show();
		var _processor = this.getProcessor();
		if (_processor) {
			setTimeout(function(){
				try{
					_processor.focusOnBottom();
				}catch(e){}	
			}, 100);
		}
	},
	/**
	 * wysiwyg panel을 감춘다.
	 * @function
	 */
	hide: function() {
		var _processor = this.getProcessor();
		if (_processor) {
			_processor.blur();
		}
		this.$super.hide();
	}
});

var __SCROLL_WIDTH = 16;
/**
 * wysiwyg 영역에서의 특정 노드의 상대 위치를 계산하기 위한 클래스로 WysiwygPanel 내부에서만 사용된다.
 * @private
 * @class
 */
var WysiwygRelative = Trex.Class.create({
	initialize: function(doc, elPanel) {
		this.doc = doc;
		this.elPanel = elPanel;
	},
	getRelative: function(node) {
		var _relatives = { x:0, y:0, width:0, height:0 };
		if (node) {
			var _position = $tom.getPosition(node, true);
			var _frameHeight = $tom.getHeight(this.elPanel);
			var _scrollTop = $tom.getScrollTop(this.doc);

			if(_position.y + _position.height < _scrollTop || _position.y > _scrollTop + _frameHeight) {
				return _relatives;
			} else {
				var _frameLeft = 0; //Holder 기준
				var _frameTop = 0; //Holder 기준
				var _frameWidth = $tom.getWidth(this.elPanel);
				var _scrollLeft = $tom.getScrollLeft(this.doc);

				_relatives.x = _frameLeft + ((_scrollLeft > 0)? 0: _position.x);
				_relatives.width = Math.min(_frameWidth - _position.x - __SCROLL_WIDTH, _position.width - ((_scrollLeft > 0)? _scrollLeft - _position.x: 0)); 
				_relatives.height = _position.height;
				_relatives.y = _position.y - _scrollTop + _frameTop;
			}
		}
		return _relatives;
	}
});

/**
 * 웹폰트를 로딩하기 위한 클래스로 WysiwygPanel 내부에서만 사용된다.
 * @private
 * @class
 */
var WebfontLoader = Trex.Class.create({
	initialize: function(doc, config) {
		this.doc = doc;
		this.styleCnt = 0;
		this.defWebfont = config.styles.fontFamily;
		this.useWebfont = (config.webfont && config.webfont.use);
		this.webfontCfg = config.webfont || [];
		this.elStyleSheet = this.getStyleSheet();
	},
	load: function(content) {
		if (!content) {
			return;
		}
		if(!this.useWebfont) {
			return;
		}
		
		var _matchs = []; 
		content += " // font-family:" + this.defWebfont;
		content.replace(/font-family\s*:\s*(\w*)/gi, function(full, name) {
			_matchs.push(name);
			return full;
		});
		if(_matchs.length == 0) {
			return;
		}
			
		var _loader = this;
		setTimeout(function() {
			var _matchedSource = _matchs.uniq().join("||");
			_loader.webfontCfg.options.each(function(item) {
				if (item.url && _matchedSource.indexOf(item.data) > -1) {
					_loader.imports(item);
				}
			});
		}, 10);
	},
	getUsed: function() {
		var _result = [];
		if(!this.useWebfont) {
			return _result;
		}
		this.webfontCfg.options.each(function(item) {
			if (!item.url) {
				_result.push(item.data);
			}
		});
		return _result;
	},
	getStyleSheet: function() {
		return this.doc.styleSheets[this.styleCnt++];
	},
	imports: function(item) {
		try {
			this.elStyleSheet.addImport(item.url, 2);
		} catch(e) {
			this.elStyleSheet = this.getStyleSheet();
			this.elStyleSheet.addImport(item.url, 2);
		}
		item.url = null;
	}
});
	
})();

Trex.module("interrupt enter key action @ wysiwyg panel",
	function(editor, toolbar, sidebar, canvas, config) {
		var _newlinepolicy = canvas.config.newlinepolicy;
		canvas.observeKey({ 
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: Trex.__KEY.ENTER
		}, function(ev) {
			if(!canvas.canHTML()) {
				return;
			}
			var _processor = canvas.getProcessor();
			try {
				_processor.getTxSel().collapse(false);
				if(_newlinepolicy == "p") {
					_processor.controlEnterByParagraph(ev);
				} else {
					_processor.controlEnterByLinebreak(ev);
				}
			} catch(e) { if(e == $propagate) { throw e; } }
		});	
		
		canvas.observeKey({ 
			ctrlKey: false,
			altKey: false,
			shiftKey: true,
			keyCode: Trex.__KEY.ENTER
		}, function(ev) {
			if(!canvas.canHTML()) {
				return;
			}
			var _processor = canvas.getProcessor();
			try {
				_processor.getTxSel().collapse(false);
				if(_newlinepolicy == "p") {
					_processor.controlEnterByLinebreak(ev);
				} else {
					_processor.controlEnterByParagraph(ev);
				}
			} catch(e) { if(e == $propagate) { throw e; } }
		});	
	}
);
