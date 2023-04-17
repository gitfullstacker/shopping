Trex.install("editor.getSaver",
	function(editor, toolbar, sidebar, canvas, config){
		var _saver = new Trex.Save(editor, toolbar, sidebar, canvas, config);
		editor.getSaver = function() {
			return _saver;
		};
	}
);

Trex.Save = Trex.Class.create({
	editor: null,
	toolbar: null,
	sidebar: null,
	canvas: null,
	config: null,
	form: null,
	initialize: function(editor, toolbar, sidebar, canvas, config) {
		this.editor = editor;
		this.toolbar = toolbar;
		this.sidebar = sidebar;
		this.canvas = canvas;
		this.config = config;
		this.form = editor.getForm();
		this.docparser = editor.getDocParser();
		this.entryproxy = editor.getEntryProxy();
	},
	save: function() {
		try {
			if(validForm){
				if (!validForm(this.editor)) {
					return false;
				}
			}
			if(setForm){
				if (!setForm(this.editor)) {
					return false;
				}
			}
			return true;
		} catch(e) {
			this.editor.fireJobs(Trex.Ev.__RUNTIME_EXCEPTION, e);
			return false;
		}
	},
	submit: function() {
		if(this.save()) {
			this.editor.fireJobs(Trex.Ev.__ON_SUBMIT, this.editor);
			var _form = this.form;
			setTimeout(function(){
				_form.submit();
			}, 500);
		}
	},
	getContent: function(outputMode) {
		var _canvas = this.canvas;

		//에디터모드, 출력모드
		var _editorMode = _canvas.mode;
		var _outputMode = outputMode || "original";
		
		var _content = _canvas.getContent(); // getContent() of current mode
		_content = this.docparser.convertAtSave(_content, _editorMode, _outputMode);
		
		return _content;
	},
	getAttachments: function(type, all) {
		all = all || false;
		var _attachments = this.sidebar.getAttachments(type); // all getAttachments()
		return this.entryproxy.getAttachments(_attachments, all);
	},
	getEmbeddedData: function(type) {
		return this.sidebar.getEmbeddedData(type);
	},
	getResults: function(type) {
		return this.sidebar.getResults(type);
	},
	/*
		data = {
			content: "string",
			inputmode: "string",
			attachments: [{
				attacher: "string",
				data: {object}
			}]
		}
	*/
	load: function(jsonData) { //NOTE: data format = JSON
		if(!jsonData) {
			throw new Error("[Exception]Trex.Save : not exist argument(data)");
		}
		if(typeof(loadForm) != "undefined") {
			loadForm(this.editor, jsonData);
		}
		
		var _canvas = this.canvas;
		var _toolbar = this.toolbar;
		var _sidebar = this.sidebar;
		var _form = this.form;
		
		//에디터모드, 입력모드
		var _editorMode = _canvas.mode;
		var _inputMode = (!jsonData.inputmode || jsonData.inputmode == 'html')? 'original': jsonData.inputmode;
		
		var _content = "";
		var _contentObj = jsonData.content;
		if (typeof _contentObj == "string") {
			_content = jsonData.content;
		} else if (_contentObj && _contentObj.nodeType && (_contentObj.nodeType == 1)) {
			_content = jsonData.content.value
		} else {
			throw new Error("[Exception]Trex.Save : invalid argument(jsonData.content)");
		}
		
		this.entryproxy.setAttachments(jsonData.attachments, _content);
		
		_content = this.docparser.convertAtLoad(_content, _editorMode, _inputMode); //onlyHTML
		_canvas.initContent(_content);
		
		_sidebar.syncSidebar(); //?
		
		if(typeof(postLoad) != "undefined") {
			postLoad(this.editor, jsonData);
		}
	},
	makeField: function() {
		var _sidebar = this.sidebar;
		var _form = this.form;

		//NOTE: create field content
		var _content = this.getContent();
		_form.createField(tx.textarea({ name: "tx_content", style: { display: "none" } }, _content));

		//NOTE: create field attach
		var _fields = _sidebar.getFields();
		_fields.each(function(field) {
			_form.createField(tx.input({ type: "hidden", name: field.name, value: field.value }));
		});
	}

});

