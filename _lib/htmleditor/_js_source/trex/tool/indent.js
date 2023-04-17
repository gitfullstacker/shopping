/**
 * @fileoverview 
 * '들여쓰기' Icon Source,
 * Class Trex.Tool.Indent configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"indent",
	{
		sync: false,
		status: false
	}
);


Trex.Tool.Indent = Trex.Class.create({
	$const: {
		__Identity: 'indent'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.IndentExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _toolHandler = function() {
			_canvas.execute(function(processor) {
				_tool.executeIndentParagraph(processor);
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
				_tool.executeIndentByKeyEvent(processor);
			});
		};
		_canvas.observeKey({ // tab - 들여쓰기
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: 9
		}, _keyHandler);
	}
});