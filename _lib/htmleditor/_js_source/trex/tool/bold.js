/**
 * @fileoverview 
 * Toolbar의 Bold Icon을 위해 필요한 configuration과 Class Trex.Tool.Bold을/를 포함    
 *  
 */
TrexConfig.addTool(
	"bold", 
	{
		wysiwygonly: true,
		sync: true,
		status: true
	}
);

Trex.Tool.Bold = Trex.Class.create({
	$const: {
		__Identity: 'bold'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;
		
		var _btn = new Trex.Button(this.buttonCfg);
			
		var _toolHandler = function() {
			if(_canvas.canHTML()){
				_canvas.execute(function(processor) {
					processor.execCommand('bold', null);
				});
				_canvas.syncProperty();
			}else{
				_btn.setState(true);
				_canvas.execute(function(processor) {
					processor.insertTag('<strong>','</strong>');
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
			_toolHandler);

		var _cachedProperty = false;
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				return processor.queryCommandState('bold');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({ // ctrl + b - 굵게
			ctrlKey: true,
			altKey: false,
			shiftKey: false,
			keyCode: 66
		}, _toolHandler);
	}
	
});
