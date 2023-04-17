/**
 * @fileoverview 
 *  Tool 'Underline' Source,
 *  Class Trex.Tool.Underline  configuration 을 포함 하고있다.    
 * 
 */
TrexConfig.addTool(
	"underline",
	{
		wysiwygonly: true,
		sync: true,
		status: true
	}
);

Trex.Tool.Underline = Trex.Class.create({
	$const: {
		__Identity: 'underline'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _btn = new Trex.Button(this.buttonCfg);
			
		var _toolHandler = function() {
			if (_canvas.canHTML()) {
				_canvas.execute(function(processor){
					processor.execCommand('underline', null);
				});
				_canvas.syncProperty('underline');
			}else{
				_btn.setState(true);
				_canvas.execute(function(processor) {
					processor.insertTag('<u>','</u>');
				});
			}	
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			_btn,
			/* menu */
			null,
			/* handler */
			_toolHandler
		);

		var _cachedProperty = false;
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				return processor.queryCommandState('underline');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({// ctrl + u
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 85
		}, _toolHandler);
	}
});