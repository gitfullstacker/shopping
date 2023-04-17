/**
 * @fileoverview 
 *  글자 배경색을 적용 하기 위해 쓰이는, Toolbar의 글자배경색 Icon을 위해 필요한 
 *  configuration과 Class Trex.Tool.BackColor을/를 포함
 * 
 */
TrexConfig.addTool(
	"backcolor",
	{
		defaultcolor: "#9aa5ea",
		wysiwygonly: true, 
		sync: false,
		status: true,
		useFavorite: true,
		texts: {
			options: [
				{ color: '#ff0000', text: '#ffffff', label: '가나다' },
				{ color: '#e545d0', text: '#ffffff', label: '가나다' },
				{ color: '#000000', text: '#ffffff', label: '가나다' },
				{ color: '#ff5e00', text: '#ffffff', label: '가나다' },
				{ color: '#7c43b1', text: '#ffffff', label: '가나다' },
				{ color: '#848484', text: '#ffffff', label: '가나다' },
				{ color: '#ffbb00', text: '#ffffff', label: '가나다' },
				{ color: '#4673ff', text: '#ffffff', label: '가나다' },
				{ color: '#66e8ff', text: '#000000', label: '가나다' },
				{ color: '#ffe400', text: '#ffffff', label: '가나다' }, 
				{ color: '#1fafda', text: '#ffffff', label: '가나다' },
				{ color: '#8cfccb', text: '#000000', label: '가나다' },
				{ color: '#a8c40d', text: '#ffffff', label: '가나다' },
				{ color: '#009999', text: '#ffffff', label: '가나다' },
				{ color: '#ffffff', text: '#000000', label: '가나다' }
			]
		},
		thumbs: Trex.__CONFIG_COMMON.thumbs,
		needRevert: true,
		needTrans: false
	}
);

Trex.Tool.BackColor = Trex.Class.create({
	$const: {
		__Identity: 'backcolor'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.CookieBaker],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;

		var _useFavorite = false;
		if (config.useFavorite) {
			_useFavorite = true;
			_tool.initCookie('txBackColorFavorite');
		}
		
		var _selectedProperty = config.defaultcolor;
		if (_useFavorite) {
			if(_tool.readCookie()) {
				_selectedProperty = _tool.readCookie();
			}
		}
		
		var _revertBackColor = "transparent";
		var _revertForeColor = _canvas.getStyleConfig('color');
		var _command = ($tx.gecko || $tx.opera ? 'hilitecolor': 'backcolor');
		var _toolHandler = function(color) {
			var _color = color ? color.split('|')[0] : null;
			var _text = (color && color.indexOf('|') > -1)? color.split('|')[1]: null;
			_canvas.execute(function(processor) {
				if (_canvas.canHTML()) {
					if(_color == null) {
						processor.execCommand(_command, _revertBackColor);
						processor.execCommand('forecolor', _revertForeColor);
					} else {
						processor.execCommand(_command, _color);
						if(_text) {
							processor.execCommand('forecolor', _text);
						}
					}
				}else{
					_canvas.execute(function(processor) {
						processor.insertTag('<span style="background-color: ' +_color+';" >','</span>');
					});
				}
			});
			if(_color) {
				$tx.setStyle( _tool.button.elButton, {'backgroundColor': _color});
			}
			if(_useFavorite) {
				_tool.writeCookie(color);
			}
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button.Splits(Object.extend(this.buttonCfg, {
				selectedValue: _selectedProperty
			})),
			/* menu */
			new Trex.Menu.ColorPallete(this.menuCfg),
			/* handler */
			_toolHandler
		);
		$tx.setStyle( _tool.button.elButton, {'backgroundColor': _selectedProperty.split('|')[0]});
	}
	
});
