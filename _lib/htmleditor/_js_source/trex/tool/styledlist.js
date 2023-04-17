/**
 * @fileoverview 
 *  여러 Style의 리스트를 삽입 할 수 있는 Tool 'styledlist' Source,
 * Class Trex.Tool.StyledList 와 configuration을 포함    
 *     
 */

TrexMessage.addMsg({
	'@styledlist.subtitle1': '취소',
	'@styledlist.subtitle2': '동그라미',
	'@styledlist.subtitle3': '네모',
	'@styledlist.subtitle4': '숫자',
	'@styledlist.subtitle5': '로마숫자',
	'@styledlist.subtitle6': '알파벳'
});

TrexConfig.addTool(
	"styledlist",
	{
		sync: false,
		status: true,
		options: [
			{ label: TXMSG('@styledlist.subtitle1'), title: 'cancel', type: 'cancel', data: 'cancel', klass: 'tx-styledlist-0' },
			{ label: TXMSG('@styledlist.subtitle2'), title: 'disc', type: 'ul', data: 'disc', klass: 'tx-styledlist-1' },
			{ label: TXMSG('@styledlist.subtitle3'), title: 'square', type: 'ul', data: 'square', klass: 'tx-styledlist-2' },
			{ label: TXMSG('@styledlist.subtitle4'), title: 'decimal', type: 'ol', data: 'decimal', klass: 'tx-styledlist-3' },
			{ label: TXMSG('@styledlist.subtitle5'), title: 'upper-roman', type: 'ol', data: 'upper-roman', klass: 'tx-styledlist-4' },
			{ label: TXMSG('@styledlist.subtitle6'), title: 'upper-alpha', type: 'ol', data: 'upper-alpha', klass: 'tx-styledlist-5' }
		]
	}
);

Trex.Tool.StyledList = Trex.Class.create({
	$const: {
		__Identity: 'styledlist'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.ListExecution],
	oninitialized: function(config) {
		var _tool = this;
		var _toolbar = this.toolbar;
		var _canvas = this.canvas;

		var _defaultProperty = "decimal";
		var _map = {};
		config.options.each(function(option) {
			_map[option.data] = {
				type: option.type,
				klass: option.klass
			};
		});
		
		var _getClassByValue = function(value) {
			if(_map[value]) {
				return _map[value].klass;
			} else {
				return _map[_defaultProperty].klass;
			}
		};

		var _toolHandler = function(data) {
			if(!_map[data]) {
				return;
			}
			var _type = _map[data].type;
			var _class = _map[data].klass;
			var _attributes = {
				'style': {
					'listStyleType': data
				}
			};
			
			_canvas.execute(function(processor) {
				if (_type == "cancel") {
					_tool.executeOffList(processor);
				} else {
					_tool.executeToList(processor, _type, _attributes);
				}
			});
		};
		
		var _initHandler = function() {
			var _insideList = _canvas.query(function(processor) {
				return !!processor.findNode('%listhead');
			});
			var _elCancel = $tom.collect(_tool.menu.elMenu, 'li');
			if(_insideList) {
				$tx.show(_elCancel);
			} else {
				$tx.hide(_elCancel);
			}
		};
		
		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button.StyledList(this.buttonCfg),
			/* menu */
			new Trex.Menu.Select(this.menuCfg),
			/* handler */
			_toolHandler,
			_initHandler
		);
			
		var _cachedProperty = _defaultProperty; 
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				var _node = processor.findNode('%listhead');
				return processor.queryStyle(_node, 'listStyleType');
			});
			_data = _data || _defaultProperty;
			if(_cachedProperty == _data) {
				return;
			}

			var _text = _getClassByValue(_data);
			_tool.button.setText(_text);
			_cachedProperty = _data;
		});

		_canvas.observeKey({ // ctrl + alt + u
			ctrlKey: true,
			altKey: true,
			shiftKey: false,
			keyCode: 85
		}, _toolHandler.bind(this, "disc"));

		_canvas.observeKey({ // ctrl + alt + o
			ctrlKey: true,
			altKey: true,
			shiftKey: false,
			keyCode: 79
		}, _toolHandler.bind(this, "decimal"));
	}
	
});

Trex.Button.StyledList = Trex.Class.create({
	$extend: Trex.Button.Select,
	setText: function(text) {
		this.elIcon.className = "tx-icon " + text;
	}
});