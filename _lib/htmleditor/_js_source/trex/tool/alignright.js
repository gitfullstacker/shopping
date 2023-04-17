/**
 * @fileoverview 
 * Toolbar의 AlignRight Icon을 위해 필요한 configuration과 Class Trex.Tool.AlignRight을/를 포함    
 * 
 */
TrexConfig.addTool(
	"alignright",
	{
		sync: true,
		status: true,
		radio: true
	}
);

Trex.Tool.AlignRight = Trex.Class.create({
	$const: {
		__Identity: 'alignright'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.AlignExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _toolbar = this.toolbar;
		var _canvas = this.canvas;
		
		/*
		 * Text : align right
		 * Image : float left
		 */
		var __TextAlignProperty = "right";
		var __ImageFloatProperty = 'left';
		var __ImageClearProperty = 'both';

		_tool.imageAlignMode = false;
		var _toolHandler = function() {
			_canvas.execute(function(processor) {
				if (_tool.imageAlignMode) {
					_tool.executeAlignImageMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_IMG_FLOAT_LEFT);
				} else {
					_tool.executeAlignTextMode(processor);
					_toolbar.fireJobs(Trex.Ev.__CMD_ALIGN_RIGHT);
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
				var _data = _canvas.query(function(processor) {
					var _float = _tool.queryImageFloat(processor);
					return (_float == __ImageFloatProperty);
				});
				_tool.button.setState(_data);
			} else {
				var _data = _canvas.query(function(processor) {
					var _controlAlign = _tool.queryControlAlign(processor);
					if(_controlAlign == null) {
						var _textAlign = _tool.queryTextAlign(processor) || 'left';
						return (_textAlign == __TextAlignProperty);
					} else {
						return (_controlAlign == __TextAlignProperty);
					}	
				});
				_tool.button.setState(_data);
			}
		});
		
		_canvas.observeKey({ // ctrl + /
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 191
		}, _toolHandler);
		
		Trex.Tool.AlignRight.__ImageModeProps = {
			'image': {
				'style': {
					'clear': __ImageClearProperty,
					'float': __ImageFloatProperty
				}
			}
		};
		
		Trex.Tool.AlignRight.__TextModeProps = {
			'paragraph': {
				'align': null,
				'style': {
					'textAlign': __TextAlignProperty
				}
			}
		};
	}
});