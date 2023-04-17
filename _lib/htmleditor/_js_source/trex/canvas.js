/**
 * @fileOverview
 * 컨텐츠를 가지고 있는 편집 영역을 수정, 관리하는 Trex.Canvas 관련 Source로
 * 대부분 각 panel들에게 행동들을 위임한다.
 * 편집 영역 = panel = TextPanel, HtmlPanel, WysiwygPanel
 */
(function(Trex) {
	TrexConfig.add({
		"canvas": {
			doctype: "html", // xhtml, html
			mode: ["text", "html", "source"], //NOTE: redefine when config property copy
			styles: {
				color: "#333333",
				fontFamily: "돋움",
				fontSize: "9pt",
				backgroundColor: "#ffffff",
				lineHeight: "1.5",
				padding: "8px"
			},
			selectedMode: "html",
			readonly: false,
			initHeight: 400,
			minHeight: 200, //NOTE: redifine when config property copy
			ext: 'html',
			param: "",
			bogus_html: (($tx.msie) ? "<p>&nbsp;</p>" : "<p><br/></p>"),
			newlinepolicy: "p"
		}
	}, function(root) {
		var _config = TrexConfig.get('canvas', root);
		var _evConfig = root.events;
		_config.initializedId = root.initializedId;
		_config.useHotKey = _evConfig.useHotKey;
		var _switcher = TrexConfig.getTool('switcher', root);
		if (Trex.available(_switcher, "switcher" + _config.initializedId)) {
			_config.mode = _switcher.options.pluck("data");
		}
		var _fontfamily = TrexConfig.getTool('fontfamily', root);
		if (Trex.available(_fontfamily, "fontfamily" + _config.initializedId)) {
			if(_fontfamily.webfont && _fontfamily.webfont.use) {
				_config.webfont = _fontfamily.webfont;
				_config.webfont.options.each(function(element) {
					element.url = TrexConfig.getUrl(element.url);
				});
			}
		}
		var _resizer = TrexConfig.get('resizer', root)
		if (_resizer) {
			_config.minHeight = _resizer.minHeight;
		}
		_config.wysiwygUrl = TrexConfig.getUrl(["#host#path/pages/wysiwyg", ((_config.doctype == "html") ? "_html" : "_xhtml"), ".", (_config.ext ? _config.ext : "html"), "?prefix=" + root.initializedId, "&", _config.param].join(""));
	});
	
	TrexConfig.add({
		"size": {
			
		}
	});
	/**
	 * 컨텐츠를 가지고 있는 편집 영역을 수정, 관리하는 Trex.Canvas 객체로 <br/>
	 * 대부분 각 panel들에게 행동들을 위임한다. <br/>
	 * 각각의 panel들은 해당 Processor들을 포함한다. <br/>
	 * 편집 영역 = panel = TextPanel, HtmlPanel, WysiwygPanel
	 *
	 * @class
	 * @extends Trex.I.JobObservable, Trex.I.KeyObservable
	 * @param {Object} editor
	 * @param {Object} config
	 */
	Trex.Canvas = Trex.Class.create( /** @lends Trex.Canvas.prototype */{
		/** @ignore */
		$const: {
			/** @name Trex.Canvas.__TEXT_MODE */
			__TEXT_MODE: "text",
			/** @name Trex.Canvas.__HTML_MODE */
			__HTML_MODE: "source",
			/** @name Trex.Canvas.__WYSIWYG_MODE */
			__WYSIWYG_MODE: "html",
			__WYSIWYG_PADDING: 8,
			__IMAGE_PADDING: 5
		},
		/** @ignore */
		$mixins: [Trex.I.JobObservable, Trex.I.KeyObservable, Trex.I.ElementObservable, Trex.I.MouseoverObservable],
		/** Editor instance */
		editor: null,
		/** Canvas Dom element, Generally $tx('tx_canvas') */
		elContainer: null,
		/** Canvas Config */
		config: null,
		/** History Instance for redo/undo */
		history: null,
		/**
		 * Panels 객체
		 * @private
		 * @example
		 * 	canvas.panels['html']
		 * 	canvas.panels['source']
		 * 	canvas.panels['text']
		 */
		panels: null,
		initialize: function(editor, rootConfig) {
			StopWatch.lap("Start canvas.init");
			
			var _editor = this.editor = editor;
			var _canvas = this;
			var _config = this.config = TrexConfig.get('canvas', rootConfig);
			var _initializedId = ((rootConfig.initializedId) ? rootConfig.initializedId : "");
			
			this.elContainer = $must("tx_canvas" + _initializedId, 'Trex.Canvas');
			this.wysiwygEl = $must("tx_canvas_wysiwyg_holder" + _initializedId, 'Trex.Canvas');
			this.sourceEl = $must("tx_canvas_source_holder" + _initializedId, 'Trex.Canvas');
			this.textEl = $must("tx_canvas_text_holder" + _initializedId, 'Trex.Canvas');
			
			this.initConfig(rootConfig);
			this.createPanel();
			this.history = new Trex.History(this, _config);
			
			StopWatch.lap("Finished canvas.init");
		},
		initConfig: function(rootConfig) {
			var _config = this.config;
			/**
			 * root config를 얻어온다.
			 * @private
			 * @returns {Object} root config
			 */
			this.getRootConfig = function() {
				return rootConfig;
			};
			
			/**
			 * Canvas의 config를 가져온다.
			 * @returns {Object} config
			 */
			this.getConfig = function() {
				return _config;
			};
			
			/**
			 * wysiwyg panel의 스타일 config를 가져온다.
			 * @param {String} name - 스타일명 optional
			 * @returns {Object} 스타일 config
			 * @example
			 *  canvas.getStyleConfig();
			 */
			this.getStyleConfig = function(name) {
				if(name) {
					return _config.styles[name];
				} else {
					return _config.styles;
				}
			};
		
			var _sizeConfig = TrexConfig.get('size', rootConfig);
			var _dim = $tx.getDimensions(this.elContainer);
			_sizeConfig.wrapWidth = _dim.width;
			if(!_sizeConfig.contentWidth) {
				_sizeConfig.contentWidth = _sizeConfig.wrapWidth;
			}
			_sizeConfig.contentPadding = _config.styles.padding.parsePx(); //15
			
			/**
			 * canvas size 관련 config를 얻어온다.
			 * @returns {Object} size config
			 */
			this.getSizeConfig = function() {
				return _sizeConfig;
			};
		},
		/**
		 * Panels 객체들을 초기화한다.
		 * @private
		 */
		createPanel: function() {
			var _canvas = this;
			var _config = this.config;
			this.panels = {};
			this.mode = _config.selectedMode || Trex.Canvas.__WYSIWYG_MODE;
			if ($tx.iphone || $tx.ipod) {
				this.mode = Trex.Canvas.__TEXT_MODE;
			}
			var _panelCreater = {
				"text": function(_config) {
					return new Trex.Canvas.TextPanel(_canvas, _config);
				},
				"source": function(_config) {
					return new Trex.Canvas.HtmlPanel(_canvas, _config);
				},
				"html": function(_config) {
					return new Trex.Canvas.WysiwygPanel(_canvas, _config);
				}
			};
			_config.mode.each(function(name) {
				if (_panelCreater[name]) {
					_canvas.panels[name] = _panelCreater[name](_config);
				}
			});
			_canvas.observeJob('canvas.panel.iframe.load', function(panelDoc) {
				_canvas.fireJobs(Trex.Ev.__IFRAME_LOAD_COMPLETE, panelDoc);
			});
			 //NOTE: wysiwyg is shown at loading
			if (this.mode != Trex.Canvas.__WYSIWYG_MODE) {
				this.panels[Trex.Canvas.__WYSIWYG_MODE].hide();
			}
			this.panels[this.mode].show();
		},
		/**
		 * Canvas의 mode를 바꾸는것으로, 현재 활성화되어있는 panel을 변경한다.
		 * @param {String} newMode - 변경 할 mode에 해당하는 문자열
		 * @example
		 *  editor.getCanvas().changeMode('html');
		 *  editor.getCanvas().changeMode('source');
		 *  editor.getCanvas().changeMode('text');
		 */
		changeMode: function(newMode) {
			var _rootConfig = this.getRootConfig();
			var _editor = this.editor;
			var oldMode = this.mode;
			if (oldMode == newMode) {
				return;
			}
			var _oldPanel = this.panels[oldMode];
			var _newPanel = this.panels[newMode];
			if (!_oldPanel || !_newPanel) {
				throw new Error("[Exception]Trex.Canvas : not suppored mode");
			}
			var _content = _oldPanel.getContent();
			//Applying Filters
			_content = _editor.getDocParser().getContentsAtChangingMode(_content, oldMode, newMode);
			if (oldMode == Trex.Canvas.__WYSIWYG_MODE) { //FTDUEDTR-366
				_oldPanel.setContent("");
				try {
					this.focusOnTop();
				}catch(e){}
			}
			_newPanel.setContent(_content);
			this.mode = newMode;
			this.fireJobs(Trex.Ev.__CANVAS_MODE_CHANGE, oldMode, newMode);
			_newPanel.setPanelHeight(_oldPanel.getPanelHeight());
			_oldPanel.hide();
			_newPanel.show();
			// FF2 bug:: When display is none,  designMode can't be set to on
			try {
				if (newMode == "html" && !this.getPanel("html").designModeActivated && $tx.gecko) {
					this.getPanel("html").el.contentDocument.designMode = "on";
					this.getPanel("html").designModeActivated = true;
				}
			} catch (e) {
				throw e;
			};
		},
		/**
		 * 현재 panel에 포커스를 준다.
		 */
		focus: function() {
			this.panels[this.mode].focus();
		},
		/**
		 * 본문의 처음으로 캐럿을 옮긴다. - Only Wysiwyg
		 */
		focusOnTop: function() {
			if(!this.canHTML()) {
				return;
			}
			this.getProcessor().focusOnTop();
		},
		/**
		 * 본문의 마지막으로 캐럿을 옮긴다. - Only Wysiwyg
		 */
		focusOnBottom: function() {
			if(!this.canHTML()) {
				return;
			}
			this.getProcessor().focusOnBottom();
		},
		/**
		 * canvas의 position을 가져온다.
		 * @returns {Object} position = { x: number, y:number }
		 */
		getCanvasPos: function() {
			var _position = $tx.cumulativeOffset(this.elContainer);
			return {
				'x': _position[0],
				'y': _position[1]
			};
		},
		/**
		 * canvas의 height를 변경한다.
		 * @param {String} size (px)
		 * @example
		 *  canvas.setCanvasSize({
		 *  	height: "500px"
		 *  });
		 */
		setCanvasSize: function(size) {
			if (this.panels[this.mode] && size.height) {
				this.panels[this.mode].setPanelHeight(size.height);
			} else {
				throw new Error("[Exception]Trex.Canvas : argument has no property - size.height ");
			}
		},
		/**
		 * 현재 모드가 wqysiwyg 모드인지, 아닌지 알려준다.
		 * @returns {Boolean} - wqysiwyg 모드일 때 true 
		 */
		canHTML: function() {
			return (this.mode == Trex.Canvas.__WYSIWYG_MODE) ? true : false;
		},
		/**
		 * panel 객체를 가져온다.
		 * @param {String} mode - 가져올 panel 모드명
		 * @returns {Object} - parameter에 해당하는 Panel
		 * @example
		 * 	this.getPanel('html').designModeActivated = true;
		 */
		getPanel: function(mode) {
			if (this.panels[mode]) {
				return this.panels[mode];
			} else {
				return null;
			}
		},
		/**
		 * 현재 활성화되어있는 panel 객체를 가져온다.
		 * @returns {Object} - 활성화되어있는 panel 객체
		 */
		getCurrentPanel: function() {
			if (this.panels[this.mode]) {
				return this.panels[this.mode];
			} else {
				return null;
			}
		},
		/**
		 * 현재 활성화되어있는 panel의 processor을 가져온다.
		 * @returns {Object} - 활성화되어있는 panel의 processor 객체
		 */
		getProcessor: function() {
			return this.panels[this.mode].getProcessor();
		},
		/**
		 * 본문의 내용을 가져온다
		 * @returns {String}
		 */
		getContent: function() {
			var _content = this.panels[this.mode].getContent();
			if(_content) {
				_content = _content.replace(/\ufeff/g, ""); //NOTE: euc-kr
			}
			return _content;
		},
		/**
		 * 현재 Wysiwyg 영역의 수직 스크롤 값을 얻어온다. - Only Wysiwyg
		 * @function
		 * @returns {Number} 수직 스크롤 값
		 * @see Trex.Canvas.WysiwygPanel#getScrollTop
		 */
		getScrollTop: function() {
			if(!this.canHTML()) {
				return 0;
			}
			return this.panels[this.mode].getScrollTop();
		},
		/**
		 * Wysiwyg 영역의 수직 스크롤 값을 셋팅한다. - Only Wysiwyg
		 * @function
		 * @param {Number} scrollTop - 수직 스크롤 값
		 * @see Trex.Canvas.WysiwygPanel#setScrollTop
		 */
		setScrollTop: function(scrollTop) {
			if(!this.canHTML()) {
				return;
			}
			this.panels[this.mode].setScrollTop(scrollTop);
		},
		/**
		 * 현재 활성화된 panel에 컨텐츠를 주어진 문자열로 수정한다. 
		 * @param {String} content - 컨텐츠
		 */
		setContent: function(content) {
			this.panels[this.mode].setContent(content);
			this.includeWebfontCss(content);
		},
		/**
		 * panel에 컨텐츠를 주어진 문자열로 초기화한다. 
		 * @param {String} content - 컨텐츠
		 */
		initContent: function(content) {
			this.history.initHistory({
				'content': content
			});
			this.panels[this.mode].setContent(content);
			this.includeWebfontCss(content);
			// #FTDUEDTR-18, produce custom event. 
			this.fireJobs(Trex.Ev.__CANVAS_DATA_INITIALIZE, Trex.Canvas.__WYSIWYG_MODE, null);
			this.focusOnTop();
		},
		/**
		 * 컨텐츠를 파싱하여 사용되고 있는 웹폰트가 있으면, 웹폰트 css를 로딩한다. - Only Wysiwyg
		 * @param {string} content
		 * @see Trex.Canvas.WysiwygPanel#includeWebfontCss
		 */
		includeWebfontCss: function(content) {
			if(!this.canHTML()) {
				return;
			}
			return this.panels[this.mode].includeWebfontCss(content);
		},
		/**
		 * 본문에 사용된 웹폰트명 목록을 리턴한다. - Only Wysiwyg
		 * @function
		 * @returns {Array} 사용하고 있는 웹폰트명 목록
		 * @see Trex.Canvas.WysiwygPanel#getUsedWebfont
		 */
		getUsedWebfont: function() {
			if(!this.canHTML()) {
				return [];
			}
			return this.panels[this.mode].getUsedWebfont();
		},
		/**
		 * 자바스크립트를 동적으로 실행한다 - Only Wysiwyg
		 * @param {String} scripts - 자바스크립트 문자열
		 */
		runScript: function(scripts) {
			if(!this.canHTML()) {
				return [];
			}
			this.panels[this.mode].runScript(scripts);
		},
		/**
		 * 선택된 영역의 상태 값을 알기위해 주어진 함수를 실행시킨다. - Only Wysiwyg
		 * @param {Function} handler - 주어진 함수
		 * @example 
		 * 		var _data = canvas.query(function(processor) {
		 *			return processor.queryCommandState('bold');
		 *		});
		 */
		query: function(handler) {
			if(!this.canHTML()) {
				return null;
			}
			var _processor = this.getProcessor();
			/* Block Scrolling
			 if($tx.msie) {
			 _processor.focus();
			 }
			 */
			return handler(_processor);
		},
		/**
		 * 선택된 영역에 주어진 handler를 실행시킨다. 
		 * @param {Function} handler - 주어진 함수
		 * @example 
		 * 		canvas.execute(function(processor) {
		 *			processor.execCommand('bold', null);
		 *		});
		 */
		execute: function(handler) {
			var _history = this.history; 
			var _processor = this.getProcessor();
			if (this.canHTML()) {
				if ($tx.msie) {
					setTimeout(function() { //#FTDUEDTR-435
						_processor.restoreRange();
						handler(_processor);
						_history.saveHistory();
						_processor.restore();
					},0);
				}else{
					handler(_processor);
					_processor.focus();
					_history.saveHistory();
					_processor.restore();
				}
			} else {
				handler(_processor);
			}
		},
		/**
		 * caret을 주어진 위치로 이동한다. - Only Wysiwyg <br/>
		 * aaa.bbb - bbb라는 클래스를 가진 aaa 노드의 다음에 커서를 이동한다. 
		 * @param {String} scope
		 * @see Trex.Canvas.Processor#moveCaretWith
		 */
		moveCaret: function(scope) {
			if(!scope) {
				return;
			}
			if(!this.canHTML()) {
				return;
			}
			this.getProcessor().moveCaretWith(scope);
		},
		/**
		 * 선택한 영역에 HTML 컨텐츠를 삽입한다.
		 * @param {String} content - 삽입하고자 하는 HTML 컨텐츠
		 * @param {Boolean} newline - 현재 영역에서 한줄을 띄운 후 삽입할지 여부 true/false
		 * @param {Object} wrapStyle - wrapper 노드에 적용할 스타일, <br/>
		 * 					newline이 true 일 경우에만 의미를 갖는다.
		 */
		pasteContent: function(content, newline, wrapStyle) {
			newline = newline || false;
			this.execute(function(processor) {
				processor.pasteContent(content, newline, wrapStyle);
			});
		},
		/**
		 * 선택한 영역에 노드를 삽입한다. - Only Wysiwyg
		 * @param {Array,Element} nodes - 삽입하고자 하는 노드 배열 또는 노드
		 * @param {Boolean} newline - 현재 영역에서 한줄을 띄운 후 삽입할지 여부 true/false
		 * @param {Object} wrapStyle - wrapper 노드에 적용할 스타일, <br/>
		 * 					newline이 true 일 경우에만 의미를 갖는다.
		 */
		pasteNode: function(node, newline, wrapStyle) {
			if (!this.canHTML()) {
				return;
			}
			newline = newline || false;
			this.execute(function(processor) {
				processor.pasteNode(node, newline, wrapStyle);
			});
		},
		/**
		 * 현재 활성화된 panel에 스타일을 적용한다.
		 * @param {Object} styles - 적용할 스타일
		 */
		addStyle: function(styles) {
			this.panels[this.mode].addStyle(styles);
		},
		/**
		 * 스타일명으로 현재 활성화된 panel의 스타일 값을 얻어온다.
		 * @param {String} name - 스타일명
		 * @returns {String} 해당 스타일 값
		 */
		getStyle: function(name) {
			return this.panels[this.mode].getStyle(name);
		},
		/**
		 * 특정 노드의 Wysiwyg 영역에서의 상대 위치를 얻어온다. - Only Wysiwyg
		 * @function
		 * @param {Element} node - 특정 노드
		 * @returns {Object} position 객체 = {
		 *								x: number,
		 *								y: number,
		 *								width: number,
		 *								height: number
		 *						}
		 */
		getPositionByNode: function(node) {
			if(!this.canHTML()) {
				return {
					x: 0,
					y: 0,
					width: 0,
					height: 0
				};
			}
			return this.panels[this.mode].getPositionByNode(node);
		}
	});
	
})(Trex);

Trex.module("focus body @after editor iframe load",
	function(editor, toolbar, sidebar, canvas, config) {
		canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function(panelDoc) {
			if (!canvas.canHTML()) {
				return;
			}
			try {
				var _processor = canvas.getProcessor();
				_processor.focusOnTop();
			} catch(e) {}	
		});
	}
);

Trex.module("make getter for 'iframeheight' and 'iframetop' size", 
	function(editor, toolbar, sidebar, canvas, config) {
		var _iframeHeight = 0;
		var _iframeTop = 0;
		canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(height) {
			_iframeHeight = height.parsePx();
		});
		canvas.observeJob('canvas.apply.background', function() {
			var _wysiwygPanel = canvas.getPanel(Trex.Canvas.__WYSIWYG_MODE);
			var _position = $tom.getPosition(_wysiwygPanel.el);
			_iframeTop = _position.y;
		});
		canvas.reserveJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {
			var _wysiwygPanel = canvas.getPanel(Trex.Canvas.__WYSIWYG_MODE);
			_iframeHeight = _wysiwygPanel.getPanelHeight().parsePx();
			var _position = $tom.getPosition(_wysiwygPanel.el);
			_iframeTop = _position.y;				
		},300);
		
		canvas.getIframeHeight = function(){
			return _iframeHeight;
		}
		canvas.getIframeTop = function(){
			return _iframeTop;
		}
	}
);	