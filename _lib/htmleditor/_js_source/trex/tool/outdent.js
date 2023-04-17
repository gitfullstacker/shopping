/**
 * @fileoverview 
 * Tool '내어쓰기' Source,
 * Class Trex.Tool.Outdent 와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"outdent",
	{
		sync: false,
		status: false
	}
);

Trex.Tool.Outdent = Trex.Class.create({
	$const: {
		__Identity: 'outdent'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.IndentExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;
		
		var _toolHandler = function() {
			_canvas.execute(function(processor) {
				_tool.executeOutdentParagraph(processor);
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

		var _keyHandler = function() {
			_canvas.execute(function(processor) {
				_tool.executeOutdentByKeyEvent(processor);
			});
		};
		_canvas.observeKey({ // shift + tab - 들여쓰기
			ctrlKey: false,
			altKey: false,
			shiftKey: true,
			keyCode: 9
		}, _keyHandler);
	}
});
