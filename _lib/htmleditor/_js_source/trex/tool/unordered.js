/**
 * @fileoverview 
 * UL을 삽입하는 '글머리 기호' Source,
 * Class Trex.Tool.UnorderedList 와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"unordered",
	{
		radio: true,
		sync: true,
		status: true
	}
);

Trex.Tool.UnorderedList = Trex.Class.create({
	$const: {
		__Identity: 'unordered'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.ListExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;
		var _toolbar = this.toolbar;
		
		var _toolHandler = function() {
			_toolbar.tools["ordered"].button.normalState();
			/*if(_toolbar.tools["unordered"].button.isPushed()){
				return false;
			}*/
			
			_canvas.execute(function(processor) {
				var _bNode = processor.findNode('%listhead');
				if (_bNode) {
					if ($tom.kindOf(_bNode, "ul")) {
						_tool.executeOffList(processor);
					} else {
						_tool.executeToList(processor, "ul", {});
					}
				} else {
					_tool.executeToList(processor, "ul", {});
				}
			});
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button(this.buttonCfg),
			/* menu */
			null,
			/* handler */
			_toolHandler
		);
			
		var _cachedProperty = null;
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				return processor.queryCommandState('insertunorderedlist');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({ // ctrl + u
			ctrlKey: true,
			altKey: true,
			shiftKey: false,
			keyCode: 85
		}, _toolHandler);
	}
});