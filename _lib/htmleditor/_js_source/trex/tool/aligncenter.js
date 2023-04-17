/**
 * @fileoverview 
 * Toolbar의 AlignCenter Icon을 위해 필요한 configuration과 Class Trex.Tool.AlignCentrer를 포함    
 * 
 */
TrexConfig.addTool(
	"aligncenter",
	{
		sync: true,
		status: true,
		radio: true
	}
);

Trex.Tool.AlignCenter = Trex.Class.create({
	$const: {
		__Identity: 'aligncenter'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.AlignExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _toolbar = this.toolbar;
		var _canvas = this.canvas;
		
		/*
		 * Text : align center
		 * Image : float none + align center
		 */
		var __TextAlignProperty = "center";
		var __ImageFloatProperty = 'none';
		var __ImageClearProperty = 'none';

		_tool.imageAlignMode = false;
		var _toolHandler = function() {
			_canvas.execute(function(processor) {
				if (_tool.imageAlignMode) {
					_tool.executeAlignImageMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_IMG_CENTER);
				} else {
					_tool.executeAlignTextMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_CENTER);
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
		
		_canvas.observeKey({ // ctrl + .
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 190
		}, _toolHandler);
		
		Trex.Tool.AlignCenter.__ImageModeProps = {
			'paragraph': {
				'align': null,
				'style': {
					'textAlign': __TextAlignProperty
				}
			},
			'image': {
				'style': {
					'clear': __ImageClearProperty,
					'float': __ImageFloatProperty
				}
			}
		};
		
		Trex.Tool.AlignCenter.__TextModeProps = {
			'paragraph': {
				'align': null,
				'style': {
					'textAlign': __TextAlignProperty
				}
			}
		};
		
	}
});