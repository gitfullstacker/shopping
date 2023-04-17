/**
 * @fileoverview 
 *  Tool '취소선' Source,
 * Class Trex.Tool.Strike 와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"strike",
	{
		wysiwygonly: true,
		sync: true,
		status: true
	}
);

Trex.Tool.Strike = Trex.Class.create({
	$const: {
		__Identity: 'strike'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _btn = new Trex.Button(this.buttonCfg);
			
		var _toolHandler = function() {
			if(_canvas.canHTML()){
				_canvas.execute(function(processor) {
					processor.execCommand('strikethrough', null);
				});
				_canvas.syncProperty('strikethrough');
			}else{
				_btn.setState(true);
				_canvas.execute(function(processor) {
					processor.insertTag('<strike>','</strike>');
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
				return processor.queryCommandState('strikethrough');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({// ctrl + d
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 68
		}, _toolHandler);
	}

});