/**
 * @fileoverview 
 *  Tool 'UnDo' Source,
 *  Class Trex.Tool.UnDo 와  configuration 을 포함 하고있다.    
 * 
 */
TrexConfig.addTool(
	"undo",
	{
		sync: false,
		status: false
	}
);

Trex.Tool.UnDo = Trex.Class.create({
	$const: {
		__Identity: 'undo'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
			var _canvas = this.canvas;

			var _toolHandler = function() {
				_canvas.getProcessor().blur();
				_canvas.focus();	
					
				setTimeout( function(){
					_canvas.fireJobs('canvas.panel.undo');	
				}, 20);
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

			_canvas.observeKey({ // ctrl + z - 실행취소
				ctrlKey: true,
				altKey: false,
				shiftKey: false,
				keyCode: 90
			}, function() {
				_canvas.fireJobs('canvas.panel.undo');
				_canvas.syncProperty('undo');
			});
		}
	
});
