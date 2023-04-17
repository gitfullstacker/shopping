/**
 * @fileoverview 
 * 'Italic' Icon Source,
 * Class Trex.Tool.Italic과 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"italic",
	{
		wysiwygonly: true,
		sync: true,
		status: true
	}
);

Trex.Tool.Italic = Trex.Class.create({
	$const: {
		__Identity: 'italic'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _btn = new Trex.Button(this.buttonCfg);
			
		var _toolHandler = function() {
			if(_canvas.canHTML()){
				_canvas.execute(function(processor) {
					processor.execCommand('italic', null);
				});
				_canvas.syncProperty('italic');
			}else{
				_btn.setState(true);
				_canvas.execute(function(processor) {
					processor.insertTag('<em>','</em>');
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
				return processor.queryCommandState('italic');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({// ctrl + i - 기울임
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 73
		}, _toolHandler);
	}
	
});