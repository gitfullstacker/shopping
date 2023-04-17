/**
 * @fileoverview
 * DaumEitor의 Entrypoint역할을 하는 source로 Trex.Editor, Editor 를 포함
 */

/**
 * 실제 Editor Implementation, 하지만 Editor 생성 시에는 Class Editor를 사용한다
 *
 * {@link Editor}
 * @class
 * @param {Object} config
 */
Trex.Editor = Trex.Class.create( /** @lends Trex.Editor.prototype */{
	/** @ignore */
	$mixins: [Trex.I.JobObservable, Trex.I.KeyObservable],
	toolbar: null,
	sidebar: null,
	canvas: null,
	config: null,
	initialize: function(config) {
		StopWatch.lap("Started editor.init");
		var _editor = this, _config = this.config = TrexConfig.setup(config);
		StopWatch.lap("Before new Trex.Canvas ");
		var _canvas = this.canvas = new Trex.Canvas(_editor, _config);
		StopWatch.lap("Before new Trex.Toolbar ");
		var _toolbar = this.toolbar = new Trex.Toolbar(_editor, _config);
		StopWatch.lap("Before new Trex.Sidebar ");
		var _sidebar = this.sidebar = new Trex.Sidebar(_editor, _config);
		Trex.invokeInstallation(_editor, _toolbar, _sidebar, _canvas, _config);
		
		/* common key event */
		var _evConfig = _config.events;
		var _keyDownHandler = function(ev) {
			if (_evConfig.useHotKey) {
				_editor.fireKeys(ev);
			}
		};
		$tx.observe(document, "keydown", _keyDownHandler.bindAsEventListener(this), false);
		if (_canvas.mode != Trex.Canvas.__WYSIWYG_MODE) {
			_canvas.fireJobs(Trex.Ev.__CANVAS_MODE_INITIALIZE, Trex.Canvas.__WYSIWYG_MODE, _canvas.mode);
		}
		
		_canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {
			var _initializedId = _editor.getInitializedId();
			var _elLoading = $tx("tx_loading" + _initializedId);
			if (!_elLoading) {
				return;
			}
			$tx.hide(_elLoading);
		});
		StopWatch.lap("Before executing Modules ");
		Trex.invokeRegisters(_editor, _toolbar, _sidebar, _canvas, _config);
		Trex.invokeModules(_editor, _toolbar, _sidebar, _canvas, _config);
		StopWatch.lap("Finished editor.init");
	},
	/**
	 * Get toolbar instance
	 * @see Trex.Toolbar
	 */
	getToolbar: function() {
		return this.toolbar;
	},
	/**
	 * Get sidebar instance
	 * @see Trex.Sidebar
	 */
	getSidebar: function() {
		return this.sidebar;
	},
	/**
	 * Get canvas instance
	 * @see Trex.Canvas
	 */
	getCanvas: function() {
		return this.canvas;
	},
	getUsedWebfont: function() {
		return this.canvas.getUsedWebfont();
	},
	/**
	 * Get config instance
	 */
	getConfig: function() {
		return this.config;
	},
	getParam: function(name) {
		var _params = {}, _config = this.config;
		_config.params.each(function(name) {
			if (_config[name]) {
				_params[name] = _config[name];
			}
		});
		return _params[name];
	},
	getWrapper: function() {
		return $must(this.config.wrapper);
	},
	getInitializedId: function() {
		return this.config.initializedId || "";
	},
	saveEditor: function() {
		this.setDisableUnloadHandler();
		this.getSaver().submit();
	},
	loadEditor: function(data) {
		this.getSaver().load(data);
	},
	/**
	 * Editor에서 작성된 저장하기 위해 parsing된 글의 내용을  가져온다.
	 * @see Trex.Canvas#getContent
	 */
	getContent: function() {
		return this.getSaver().getContent();
	},
	/**
	 * Editor에 첨부된 첨부데이터 리스트를 가져온다.
	 * * @see Trex.Sidebar#getAttachments
	 */
	getAttachments: function(type, all) {
		return this.getSaver().getAttachments(type, all);
	},
	/**
	 * Editor에 삽입된 Embed데이터 리스트를 가져온다.
	 * * @see Trex.Sidebar#getEmbeddedData
	 */
	getEmbeddedData: function(type) {
		return this.getSaver().getEmbeddedData(type);
	},
	/**
	 * Editor에 첨부된 정보첨부 리스트를 가져온다.
	 * * @see Trex.Sidebar#getResults
	 */
	getResults: function(type) {
		return this.getSaver().getResults(type);
	}
});
// Binds helper functions for Editor
(function() {
	/**
	 * Editor
	 *
	 * @example
	 *  new Editor({
	 *  	txService: 'sampleService',
	 *  	txHost: 'sample.daum.net',
	 *  	txPath: 'sampleService',
	 *  	txVersion: '1.0',
	 *  	initializedId: 'stringValue',
	 *  	form: 'tx_editor_form'+"$!initializedId"
	 *  });
	 *
	 * @extends Trex.Editor
	 * @class
	 * @param {Object} config
	 */
	Editor = Trex.Class.create({
		/** @ignore */
		$const: {
			__ACTIVE: false,
			__PANEL_LOADED: false, //NOTE: Cuz modify, restore
			__EDITOR_LOADED: false,
			__MULTI_LIST: [],
			__SELECTED_INDEX: 0
		},
		initialize: function(config) {
			StopWatch.start();
			var _editor;
			try {
				Editor.__EDITOR_LOADED = false;
				Editor.__PANEL_LOADED = false;
				_editor = new Trex.Editor(config);
				var _initializedId = _editor.getInitializedId();
				if (_initializedId != null) {
					var idx = _initializedId == "" ? 0 : _initializedId;
					Editor.__MULTI_LIST[idx] = _editor;
					Editor.__SELECTED_INDEX = idx;
				}
				Object.extend(Editor, _editor);
				Editor.__EDITOR_LOADED = true;
				Editor.__ACTIVE = true;
			} catch (e) {
				console.log(e);
				if (_editor) {
					_editor.fireJobs(Trex.Ev.__RUNTIME_EXCEPTION, e);
				}
			}
		}
	});
	/**
	 * 글을 수정할 때 저장된 글을 불러온다.
	 * @param {Object} data - 에디트에 로드할 내용/첨부파일 값
	 * @example
	 *  Editor.modify({
	 *  	content:'&lt;p&gt;content example&lt;/p&gt;' or $tx('tx_content')
	 *  	attachments: [
	 *  		{attacher: 'image', 
	 *				data: {
	 *					thumburl: "http://cfile163.uf.daum.net/P150x100/0126A20248BFAFF72D2229",
	 *					imageurl: "http://cfile163.uf.daum.net/image/0126A20248BFAFF72D2229",
	 *					originalurl: "http://cfile163.uf.daum.net/original/0126A20248BFAFF72D2229",
	 *					exifurl: "http://cfile163.uf.daum.net/info/0126A20248BFAFF72D2229",
	 *					attachurl: "http://cfile163.uf.daum.net/attach/0126A20248BFAFF72D2229",
	 *					filename: "Tree.jpg",
	 *					filesize: "155833"
	 *				}
	 *			}]
	 *  });
	 */
	Editor.modify = function(data) {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			if (this.loadEditor) {
				this.loadEditor(data);
			}
		} else {
			setTimeout(this.modify.bind(this, data), 10);
		}
	};
	/**
	 * Editor 생성 후 자동저장된 Content를 불러올 경우 사용한다.
	 * @param {Object} data
	 * @example
	 *  Editor.restore(
	 *  	{content: 'string', 
	 *  	attachments: [{Object}]});
	 */
	Editor.restore = function(data) {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			var _autoSaver = this.getAutoSaver();
			if (_autoSaver) {
				_autoSaver.load(data);
			}
		} else {
			setTimeout(this.restore.bind(this, data), 10);
		}
	};
	/**
	 * 글 저장시 사용한다.
	 * @example
	 *  &lt;a onclick="Editor.save();return false;" href="#"&gt;save&lt;/a&gt;
	 */
	Editor.save = function() {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			if (this.saveEditor) {
				this.saveEditor();
			}
		} else {
			setTimeout(this.saveEditor.bind(this), 10);
		}
		return false;
	};
	/**
	 * Canvas의 최근 focus가 있던 영역에  focus를 준다.
	 * 예를들어, 이미지를 첨부하는 팝업창에서 작업을 완료 후 팝업창을 닫고 에디터에 최근의 focus를 준다.
	 */
	Editor.focus = function() {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			var _canvas = this.getCanvas();
			if (_canvas) {
				_canvas.focus();
			}
		} else {
			setTimeout(this.focus.bind(this), 10);
		}
		return false;
	}; 
	/**
	 * Canvas의 맨 위에 focus를 준다.
	 * @see Canvas#focusOnTop
	 */
	Editor.focusOnTop = function() {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			var _canvas = this.getCanvas();
			if (_canvas) {
				_canvas.focusOnTop();
			}
		} else {
			setTimeout(this.focusOnTop.bind(this), 10);
		}
		return false;
	};
	/**
	 * Canvas의 맨 아래에 focus를 준다.
	 * @see Canvas#focusOnBottom
	 */
	Editor.focusOnBottom = function() {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			var _canvas = this.getCanvas();
			if (_canvas) {
				_canvas.focusOnBottom();
			}
		} else {
			setTimeout(this.focusOnBottom.bind(this), 10);
		}
		return false;
	};
	/**
	 * Editor가 있는 page를 나갈 경우 beforeunload eventlistener를 실행 시키지 도록 설정한다.
	 * 예를들면, Editor에서 글을 작성 중에 새로고침했을 경우 경고창을 안뜨게 한다.
	 */
	Editor.permitUnload = function() {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			this.setDisableUnloadHandler();
		} else {
			setTimeout(this.permitUnload.bind(this), 500);
		}
	};
	/**
	 * Editor와 Iframe이 정상적으로 생성 된후 argument로 지정된 function을 실행 시킨다.
	 * @param {Function} fn
	 * @example
	 * 	Editor.onPanelLoadComplete(
	 * 		Editor.focus();
	 * 	);
	 */
	Editor.onPanelLoadComplete = function(fn) {
		if (Editor.__PANEL_LOADED == true && Editor.__EDITOR_LOADED == true) {
			if (fn) {
				fn();
			}
		} else {
			Editor.panelLoadCompleteHandler = fn;
		}
	};
	/**
	 * 동일한 Page에 Editor가 여러개 생성됬을 경우, 다른 Editor를 지정한다.
	 * @param {Object} toIndex
	 */
	Editor.switchEditor = function(toIndex) {
		Editor.__SELECTED_INDEX = toIndex;
		Object.extend(Editor, Editor.__MULTI_LIST[toIndex]);
	};
	/**
	 * focus on form
	 * @param {String} name - focus를 줄 form의 name 속성 값
	 * @example
	 * 	Editor.focusOnForm("tx_article_title");
	 */
	Editor.focusOnForm = function(name) {
		if (Editor.__PANEL_LOADED && Editor.__EDITOR_LOADED) {
			window.focus();
			var _form = Editor.getForm();
			if (_form.getElementByName(name)) {
				_form.getElementByName(name).focus();
			}
		} else {
			setTimeout(Editor.focusOnForm.bind(Editor, name), 500);
		}
		return false;
	};
	/**
	 * <b>deprecated</b> - use Editor.switchEditor, 동일한 Page에 Editor가 여러개 생성됬을 경우, 다른 Editor를 지정한다.
	 * @function
	 * @deprecated since ver 1.2, use Editor.switchEditor
	 */
	Editor.prototype.switchEditor = Editor.switchEditor;
	/**
	 * <b>deprecated</b> - use Editor.focusOnForm, focus on form
	 * @function
	 * @deprecated since ver 1.2, Use Editor.focusOnForm
	 */
	Editor.prototype.focusOnForm = Editor.focusOnForm;
})();
