/**
 * @fileoverview 
 * Tool '인용구' Source,
 * Class Trex.Tool.Quote 와 configuration을 포함    
 *     
 */
TrexConfig.addTool(
	"quote",
	{
		sync: false,
		status: true,
		rows: 2,
		cols: 3,
		options: [
			{ type: 'image', data: 'tx-quote1', image: '#iconpath/citation01.gif?rv=1.0.1' },
			{ type: 'image', data: 'tx-quote2', image: '#iconpath/citation02.gif?rv=1.0.1' },
			{ type: 'image', data: 'tx-quote3', image: '#iconpath/citation03.gif?rv=1.0.1' },
			{ type: 'image', data: 'tx-quote4', image: '#iconpath/citation04.gif?rv=1.0.1' },
			{ type: 'image', data: 'tx-quote5', image: '#iconpath/citation05.gif?rv=1.0.1' },
			{ type: 'cancel', data: 'tx-quote6', image: '#iconpath/citation06.gif?rv=1.0.1' }
		]
	},
	function(root){
		var _config = TrexConfig.getTool("quote", root);
		_config.options.each(function(option) {
			option.image = TrexConfig.getIconPath(option.image, 'quote'); 
		});
	}
);

Trex.Tool.Quote = Trex.Class.create({
	$const: {
		__Identity: 'quote'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
			var _tool = this; 
			var _canvas = this.canvas;

			var _map = {};
			config.options.each(function(option) {
				_map[option.data] = {
					type: option.type
				};
			});

			var _toolHandler = function(data) {
				if(!_map[data]) {
					return;
				}
				var _type = _map[data].type;
				var _tag = "blockquote";
				var _attributes = { "className": data };

				if(_canvas.canHTML()) {
					_canvas.execute(function(processor) {
						var _bNode = processor.findNode(_tag);
						if (_bNode) {
							if(_type == "cancel") {
								processor.unwrap(_bNode);
							} else {
								processor.apply(_bNode, _attributes);
							}
						} else {
							if(_type != "cancel") {
								var _nodes = processor.blocks(function(type) {
									return '%wrapper,%paragraph';
								});
								_nodes = _nodes.select(function(node) {
									if($tom.kindOf(node, "%innergroup")) {
										processor.wrap($tom.children(node), _tag, _attributes);	
										return false;
									} else {
										return true;
									}
								});
								processor.wrap(_nodes, _tag, _attributes);	
							}
						}	
					});
				} else {
					_canvas.execute(function(processor) {
						processor.insertTag('<blockquote>','</blockquote>');
					});
				}
			};

			/* button & menu weave */
			this.weave.bind(this)(
				/* button */
				new Trex.Button(this.buttonCfg),
				/* menu */
				new Trex.Menu.List(this.menuCfg),
				/* handler */
				_toolHandler
			);

			var _popdownHandler = function() {
				_tool.button.onMouseDown();
			}
			_canvas.observeKey({ // ctrl + q
				ctrlKey: true,
				altKey: false,
				shiftKey: false,
				keyCode: 81
			}, _popdownHandler);
		}
	
});

