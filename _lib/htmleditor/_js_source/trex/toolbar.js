/**
 * @fileoverview
 * - Trex.Toolbar
 */

/**
 * Trex.Toolbar Class
 * @class
 * @param {Object} editor
 * @param {Object} config
 */
Trex.Toolbar = Trex.Class.create(/** @lends Trex.Toolbar.prototype */{
	/** @ignore */
	$mixins: [
		Trex.I.JobObservable
	],
	/**
	 * Toolbar Dom Element
	 */
	el: null,
	/**
	 * Tools List
	 */
	tools: null,
	initialize: function(editor, rootConfig) {
		this.canvas = editor.getCanvas();
		
		var _initializedId =  rootConfig.initializedId || "";
		this.el = $must("tx_toolbar_basic" + _initializedId, "Trex.Toolbar");
	},
	/**
	 * Toolbar의 tool을 비활성화 시킨다. 
	 * @function
	 * @example
	 * 	Editor.getToolbar().disableToolbar();
	 */
	disableToolbar: function(){
		var _tools = this.tools;
		for (var _name in _tools) {
			if (_tools[_name].button) {
				_tools[_name].button.disable();
			}
		}
	},
	/**
	 * 현재 toolbar의 상태를 serializing한다. 
	 * @function
	 * @returns {object}
	 */
	serializeToolValues : function(){
		var _tools = this.tools;
		var result = {};
		for(var name in _tools){
			var _tool = _tools[name];
			result[name] = _tool.button.lastValue;
		}
		return result;
	},
	widgetSeq:0,
	makeWidget: function(button, menu, handler) {
		var _toolbar = this;
		var _canvas = this.canvas;
		var _dummyToolClass = new (function() {
			this.identity = 'widget' + (++_toolbar.widgetSeq);
			this.wysiwygonly = true;
			this.canvas = _canvas;
			this.toolbar = _toolbar;
		})();
		
		Trex.Tool.prototype.weave.bind(_dummyToolClass)(
			button, 
			menu, 
			handler
		);
		
		this.tools[_dummyToolClass.identity] = _dummyToolClass;
		return _dummyToolClass;
	}
});

Trex.install("editor.getTool",
	function(editor, toolbar, sidebar, canvas, config) {
		var _tools = toolbar.tools = {};
		
		/**
		 * memberOf Editor.prototype
		 * @param {Object} name
		 */
		editor.getTool = function(name) {
			if(_tools[name] != null) {
				return _tools[name];
			} else if(arguments.length == 0){
				return _tools;
			}else{
				return null;
			}
		};
	}
);

Trex.register("new tools",
	function(editor, toolbar, sidebar, canvas, config) {
		var _tools = toolbar.tools;
		
		var _initializedId = config.initializedId || ""; 
		for(var item in Trex.Tool) {
			var _name = Trex.Tool[item]['__Identity'];
			if(_name){
				var cfg = TrexConfig.getTool(_name, config);
				cfg.initializedId = _initializedId;
				if (Trex.available(cfg, _name + _initializedId)) {
					_tools[_name] = new Trex.Tool[item](editor, toolbar, cfg);
				}
			}
		}
	}
);

Trex.module("bind events with tools",
	function(editor, toolbar, sidebar, canvas, config) {
		var _tools = toolbar.tools;
		
		var _changeMode = function(from, to){
			if (from == to) {
				return;
			}
			for (var _name in _tools) {
				var _tool = _tools[_name];
				var _btn = _tool.button;
				if (Trex.Canvas.__WYSIWYG_MODE == to) {
					_btn.enable();
				} else if (Trex.Canvas.__WYSIWYG_MODE == from) {
					if (_tool.wysiwygonly) {
						_btn.disable();
					} else {
						_btn.enable();
					}
				}
			}
		};
		canvas.observeJob(Trex.Ev.__CANVAS_MODE_CHANGE, _changeMode);
		canvas.observeJob(Trex.Ev.__CANVAS_MODE_INITIALIZE, _changeMode);
		
		var _releaseTools = function(identity) {
			for(var _name in _tools) {
				var _tool = _tools[_name];
				if(identity != _tool.identity) {
					if (_tool.button) {
						_tool.button.release();
					}
					if(_tool.menu) {
						_tool.menu.release();
					}
				}
			}
		};
		canvas.observeJob(Trex.Ev.__CANVAS_PANEL_CLICK, _releaseTools);
		canvas.observeJob(Trex.Ev.__CANVAS_SOURCE_PANEL_CLICK, _releaseTools);
		canvas.observeJob(Trex.Ev.__CANVAS_TEXT_PANEL_CLICK, _releaseTools);
		
		toolbar.observeJob(Trex.Ev.__TOOL_CLICK, _releaseTools);

		canvas.observeKey({ // Esc
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: 27
		}, _releaseTools);

		editor.observeKey({ // Esc
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: 27
		}, _releaseTools);
		
		$tx.observe(document, 'click', 
			function(e){
				var _el = $tx.element(e);
				var _class = [	'tx-sidebar', 'tx-toolbar-basic' ,'tx-toolbar-advanced', 
					'tx-sidebar-boundary', 'tx-toolbar-boundary', 'tx-toolbar-boundary'];
				if (Trex.Util.getMatchedClassName(_el, _class)) {
					_releaseTools("-");
				}	
			}
		, false);	
	}
);

/**
 * Tool 클래스의 추상 부모클래스로 각각의 tool들은 이 클래스를 상속받아야 하고, 
 * 'oninitialized' 함수를 구현해야한다.
 * 
 * @abstract
 * @class
 * @param {Object} editor
 * @param {Object} toolbar
 * @param {Object} config
 * 
 * @example
 *	Trex.Tool.Example = Trex.Class.create({
 *		$const: {
 *			__Identity: 'example'
 *		},
 *		$extend: Trex.Tool,
 *		oninitialized: function(config) {
 *			var _tool = this;
 *			
 *			this.weave.bind(this)(
 *				new Trex.Button(this.buttonCfg),
 *				new Trex.Menu(this.menuCfg),
 *				function(data) {
 *					//TODO
 *				}
 *			);
 *		}
 *	});
 */
Trex.Tool = Trex.Class.draft(/** @lends Trex.Tool.prototype */{
	/**
	 * tool identifier. 유일해야한다.
	 * @private
	 */
	identity: null,
	/**
	 * button 객체
	 */
	button: null,
	/**
	 * menu 객체
	 */
	menu: null,
	initialize: function(editor, toolbar, config) {
		if(!this.constructor.__Identity) {
			throw new Error("[Exception]Trex.Tool : not implement const(__Identity)");
		}
		this.identity = this.constructor.__Identity;

		if(!editor) {
			throw new Error("[Exception]Trex.Tool : not exist argument(editor)");
		}
		/** 
		 * editor 객체 
		 * @private
		 */
		this.editor = editor;
		/** 
		 * toolbar 객체 
		 * @private
		 */
		this.toolbar = toolbar;
		/** 
		 * canvas 객체
		 * @private 
		 */
		this.canvas = editor.getCanvas();
		/** 
		 * 해당 tool 설정값 
		 * @private
		 */
		this.config = config;
		this.wysiwygonly = ((config.wysiwygonly != null)? config.wysiwygonly: true);
		
		/** 
		 * 버튼을 생성할 때 필요한 설정값
		 * @private 
		 */
		this.buttonCfg = TrexConfig.merge({
			id: "tx_" + this.identity
		}, config);
		
		/** 
		 * 메뉴를 생성할 때 필요한 설정값
		 * @private 
		 */
		this.menuCfg = TrexConfig.merge({
			id: "tx_" + this.identity + "_menu"
		}, config);
		
		this.oninitialized.bind(this)(config);
	},
	/**
	 * tool 객체를 초기화하는 마지막 단계에서 호출되는 함수로,
	 * tool 클래스를 상속받는 tool에서 반드시 구현해야 한다.
	 * 
	 * @abstract
	 * @private
	 * @function
	 * @param {Object} config
	 */ 
	oninitialized: function(config) {
		throw new Error("[Exception]Trex.Tool : not implements function(oninitialized)");
	},
	/**
	 * 보통 tool은 버튼과 메뉴로 구성되는데, 이 함수에서 그 둘 사이의 연결을 해준다.<br/>
	 * menu가 없으면 버튼을 클릭할 때 execHandler가 실행되고,
	 * menu가 있으면 버튼을 클릭할 때 menu가 보이며, 
	 * menu에서 특정 값을 선택하면 그 값을 가지고 execHandler가 실행된다.
	 * 
	 * @function
	 * @private
	 * @param {Object} button - 버튼 객체
	 * @param {Object} menu - 메뉴 객체 optional
	 * @param {Function} execHandler
	 * @param {Function} initHandler - optional
	 * 
	 * @example
	 *	this.weave.bind(this)(
	 *		new Trex.Button(this.buttonCfg),
 	 *		new Trex.Menu(this.menuCfg),
	 *		function(data) {
	 *			//TODO
	 *		});
	 *	}
	 */
	weave: function(button, menu, execHandler, initHandler) {
		var _tool = this;
		var _identity = this.identity;
		var _toolbar = this.toolbar;
		var _canvas = this.canvas;
		
		this.button = button;
		button.tool = this;
		var cmd = null;
		if(!menu){
			button.setCommand(
				cmd = function(){
					_toolbar.fireJobs(Trex.Ev.__TOOL_CLICK, _identity);
					var success = execHandler.apply(_tool, arguments);
					return success;
				}
			);
		}else{
			this.menu = menu;
			menu.tool = this;
			
			menu.initHandler = initHandler || function(){};
			menu.cancelHandler = function(){ button.setState(false); };
		
			menu.setCommand(
				cmd = function() { 
					var success = execHandler.apply(_tool, arguments);
					button.updateAfterCommand.apply(button, arguments);
					return success;
				}
			);
			button.setCommand(
				function() {
					_toolbar.fireJobs(Trex.Ev.__TOOL_CLICK, _identity);
					if(!button.isPushed()) {
						var _lastvalue = button.getValue();
						menu.show(_lastvalue);
					} else {
						menu.hide();
					}
					if($tx.msie) {
						var _processor = _canvas.getProcessor();
						if(_processor.restoreRange){
							setTimeout(function(){
								_processor.restoreRange();
							},0);
						}
					}
					return true;
				}
			);
		}
		this.execute = cmd;
	}
});
