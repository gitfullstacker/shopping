/**
 * @fileoverview 
 * OL을 삽입하는 '번호매기기' Source,
 * Class Trex.Tool.OrderedList와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"ordered",
	{
		radio: true,
		sync: true,
		status: true
	}
);

Trex.Tool.OrderedList = Trex.Class.create({
	$const: {
		__Identity: 'ordered'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.ListExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;
		var _toolbar = this.toolbar;

		var _toolHandler = function() {
			_toolbar.tools["unordered"].button.normalState();
			/*if(_toolbar.tools["ordered"].button.isPushed()){
				return false;
			}*/
			
			_canvas.execute(function(processor) {
				var _bNode = processor.findNode('%listhead');
				if (_bNode) {
					if ($tom.kindOf(_bNode, "ol")) {
						_tool.executeOffList(processor);
					} else {
						_tool.executeToList(processor, "ol", {});
					}
				} else {
					_tool.executeToList(processor, "ol", {});
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
				return processor.queryCommandState('insertorderedlist');
			});
			if(_cachedProperty == _data) {
				return;
			}
			_tool.button.setState(_data);
			_cachedProperty = _data;
		});
		
		_canvas.observeKey({ // ctrl + o
			ctrlKey: true,
			altKey: true,
			shiftKey: false,
			keyCode: 79
		}, _toolHandler);
	}
	
});