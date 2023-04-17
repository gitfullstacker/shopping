/**
 * @fileoverview 
 * Toolbar의 AlignLeft Icon을 위해 필요한 configuration과 Class Trex.Tool.AlignLeft을/를 포함    
 * 
 */
TrexConfig.addTool(
	"alignleft",
	{
		sync: true,
		status: true,
		radio: true
	}
);

Trex.Tool.AlignLeft = Trex.Class.create({
	$const: {
		__Identity: 'alignleft'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.AlignExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _toolbar = this.toolbar;
		var _canvas = this.canvas;
		
		/*
		 * Text : align left
		 * Image : float none + align left
		 */
		var __TextAlignProperty = "left";
		var __ImageFloatProperty = 'none';
		var __ImageClearProperty = 'none';

		_tool.imageAlignMode = false;
		var _toolHandler = function() {
			_canvas.execute(function(processor) {
				if (_tool.imageAlignMode) {
					_tool.executeAlignImageMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_IMG_LEFT);
				} else {
					_tool.executeAlignTextMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_LEFT);
				}
			});
			_canvas.syncProperty();
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button(this.buttonCfg),
			/* menu */
			null,
			/* handler */
			_toolHandler);

		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			if(_tool.imageAlignMode) {
				_data = _canvas.query(function(processor) {
					var _textAlign = _tool.queryTextAlign(processor);
					if (_textAlign == __TextAlignProperty) {
						var _float = _tool.queryImageFloat(processor);
						_float = _float || 'none';
						return (_float == __ImageFloatProperty);
					} else {
						return false;
					}
				});
				_tool.button.setState(_data);
			} else {
				_data = _canvas.query(function(processor){
					var _controlAlign = _tool.queryControlAlign(processor);
					if(_controlAlign == null) {
						var _textAlign = _tool.queryTextAlign(processor);
						return (_textAlign == __TextAlignProperty);
					} else {
						return (_controlAlign == __TextAlignProperty);
					}
				});
				_tool.button.setState(_data);
			}
		});
		
		_canvas.observeKey({ // ctrl + ,
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 188
		}, _toolHandler);
		
		Trex.Tool.AlignLeft.__ImageModeProps = {
			'paragraph': {
				'align': null,
				'style': {
					'textAlign': __TextAlignProperty
				}
			},
			'image': {
				'style': {
					'clear': __ImageClearProperty,
					'float': __ImageFloatProperty,
					'marginLeft': "",
					'marginRight': ""
				}
			}
		};
		
		Trex.Tool.AlignLeft.__TextModeProps = {
			'paragraph': {
				'align': null,
				'style': {
					'textAlign': __TextAlignProperty
				}
			}
		};
	}
});


