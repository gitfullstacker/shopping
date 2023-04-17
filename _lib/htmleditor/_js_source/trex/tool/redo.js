/**
 * @fileoverview 
 * Tool 'Redo' Source,
 * Class Trex.Tool.ReDo 와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"redo",
	{
		sync: false,
		status: false
	}
);

Trex.Tool.ReDo = Trex.Class.create({
	$const: {
		__Identity: 'redo'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
			var _canvas = this.canvas;

			var _toolHandler = function() {
				_canvas.getProcessor().blur();
				_canvas.focus();	
					
				setTimeout( function(){
					_canvas.fireJobs('canvas.panel.redo');	
				}, 0);	
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

			_canvas.observeKey({ // ctrl + y - 다시실행
				ctrlKey: true,
				altKey: false,
				shiftKey: false,
				keyCode: 89
			}, function() {
				_canvas.fireJobs('canvas.panel.redo');
				_canvas.syncProperty('redo');
			});
		}
	
});
