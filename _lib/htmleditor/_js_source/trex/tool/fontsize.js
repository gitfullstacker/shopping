/**
 * @fileoverview 
 * 설정에서 지정된 여러 fontsize들을 선택할 수 있는 메뉴를 포함하는 tool인 '글자크기' Icon을 위한 source로,
 * Class Trex.Tool.FontSize, configuration 을 포함    
 * 
 *   
 */
TrexConfig.addTool(
	"fontsize", 
	{
		sync: true,
		status: true,
		options: [
			{ label: '가나다라마바사 (8pt)', title: '8pt', data: '8pt', klass: 'tx-8pt' },
			{ label: '가나다라마바사 (9pt)', title: '9pt', data: '9pt', klass: 'tx-9pt' },
			{ label: '가나다라마바사 (10pt)', title: '10pt', data: '10pt', klass: 'tx-10pt' },
			{ label: '가나다라마바사 (11pt)', title: '11pt', data: '11pt', klass: 'tx-11pt' },
			{ label: '가나다라마바사 (12pt)', title: '12pt', data: '12pt', klass: 'tx-12pt' },
			{ label: '가나다라마바사 (14pt)', title: '14pt', data: '14pt', klass: 'tx-14pt' },
			{ label: '가나다라마바사 (18pt)', title: '18pt', data: '18pt', klass: 'tx-18pt' },
			{ label: '가나다라마 (24pt)', title: '24pt', data: '24pt', klass: 'tx-24pt' },
			{ label: '가나다 (36pt)', title: '36pt', data: '36pt', klass: 'tx-36pt' }
		]
	}
);

Trex.Tool.FontSize = Trex.Class.create({
	$const: {
		__Identity: 'fontsize'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _defaultProperty = _canvas.getStyleConfig().fontSize;
		var _optionz = (config.options || []);
		var _map = {};
		_optionz.each(function(option) {
			_map[option.data] = option.title;
		});
		[
			{ title: '7.5pt', data: '1' }, //NOTE: Cuz font tags
			{ title: '10pt', data: '2' },
			{ title: '12pt', data: '3' },
			{ title: '14pt', data: '4' },
			{ title: '18pt', data: '5' },
			{ title: '24pt', data: '6' },
			{ title: '36pt', data: '7' },
			{ title: '7.5pt', data: '10px'},
			{ title: '8pt', data: '11px' },
			{ title: '9pt', data: '12px' },
			{ title: '10pt', data: '13px' },
			{ title: '11pt', data: '15px' },
			{ title: '12pt', data: '16px' },
			{ title: '14pt', data: '19px' },
			{ title: '18pt', data: '24px' },
			{ title: '24pt', data: '32px' },
			{ title: '36pt', data: '48px' } //NOTE: Cuz Safari
		].each(function(option) {
			_map[option.data] = option.title;
		});
		
		var _getTextByValue = function(value) {
			if(_map[value]) {
				return _map[value];
			} else {
				return value;
			}
		};
		
		var _toolHandler = function(data) {
			_canvas.execute(function(processor) {
				var _nodes = processor.inlines(function(type) {
					if(type === 'control') {
						return 'img,hr,table';
					}
					return '%text,span,font';
				});
				_nodes.each(function(node) { //clean tag
					[node].concat($tom.descendants(node, 'span,font')).each(function(inNode) {
						$tom.applyAttributes(inNode, {
							'style': { 'fontSize': null },
							'size': null
						});
					});
				});
				processor.apply(_nodes, { 
					'style': { 'fontSize': data },
					'size': null	
				});
			});
		};
		
		/* button & menu weave */
		this.weave.bind(this)( 
			/* button */
			new Trex.Button.Select(TrexConfig.merge(this.buttonCfg, {
				selectedValue: _defaultProperty,
				selectedText: _getTextByValue(_defaultProperty)
			})),
			/* menu */
			new Trex.Menu.Select(this.menuCfg),
			/* handler */
			_toolHandler
		);
		
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				var _node = processor.findNode('%inline');
				return processor.queryStyle(_node, 'fontSize');
			});
			
			if(_data == null) { 
				_data = _canvas.query(function(processor) {
					var _node = processor.findNode('%inline');
					return processor.queryAttr('size');
				});
			}
			_data = _data || _defaultProperty;

			if (_data.indexOf('px') != -1 ) {
				_data = Math.round( parseFloat(_data) ) + 'px';
			}
			
			var _text = _getTextByValue(_data);
			_tool.button.setText(_text);
		});
	}
});
