TrexConfig.addTool(
	"background", 
	{
		wysiwygonly: true,
		sync: false,
		status: true,
		thumbs: Trex.__CONFIG_COMMON.thumbs
	}
);
Trex.Tool.Background = Trex.Class.create({
	$const: {
		__Identity: 'background'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _canvas = this.canvas;

		var _toolHandler = function(color) {
			_canvas.addStyle({
				backgroundColor: color
			});
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button(this.buttonCfg),
			/* menu */
			new Trex.Menu.ColorPallete(this.menuCfg),
			/* handler */
			_toolHandler
		);
	}
});

Trex.install('canvas.getBgColor & canvas.setBgColor & editor.getContentWithBg', 
	function(editor, toolbar, sidebar, canvas, config) {
		//저장, 로드할때 content 수정
		canvas.getBgColor = function() {
			var color = canvas.getPanel("html").getStyle("backgroundColor");
			if ( color ) {
				return Trex.Color.getHexColor(color);	
			} else {
				return "";
			}
		};
		
		canvas.setBgColor = function(color) {
			canvas.getPanel("html").addStyle({
				"backgroundColor": color || 'transparent'
			});
		};
		
		editor.getContentWithBg = function() {
			var _selColor = canvas.getBgColor().toLowerCase();
			if(_selColor == 'transparent') {
				return editor.getContent();
			} else {
				return [
					'<table class="txc-wrapper" border="0" cellspacing="0" cellpadding="0"><tr>',
					'<td bgcolor="',_selColor,'">',
					editor.getContent(),
					'</td>',
					'</tr></table>'
				].join("");
			}
		};
		
		var _originInitContent = canvas.initContent.bind(canvas);
		canvas.initContent = function(content) {
			if(content.search(/<table[^>]*txc-wrapper[^>]*>/i) > -1) {
				var _selColor;
				content = content.replace(/<table[^>]*txc-wrapper[^>]*><tr><td([^>]*)>([\s\S]*?)<\/td><\/tr><\/table>/i, function(full, color, html){
					_selColor = color.replace(/\sbgcolor="([#\w]*)"/, "$1");
					return html;
				});
				canvas.setBgColor(_selColor);
			}
			_originInitContent(content);
		};
	}
);