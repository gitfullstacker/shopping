/**
 * @fileoverview 
 * 설정에서 지정된 여러 글꼴들을 선택할 수 있는 메뉴를 포함하는 tool인 '글꼴' Icon을 위한 source로, 
 * 필요한 configuration과 Class Trex.Tool.FontFamily을/를 포함    
 * 
 *   
 */

TrexMessage.addMsg({
	'@fontfamily.gulim': '굴림',
	'@fontfamily.batang': '바탕',
	'@fontfamily.dotum': '돋움',
	'@fontfamily.gungsuh': '궁서'
});

TrexConfig.addTool(
	"fontfamily", 
	{
		sync: true,
		status: true,
		useFavorite: true,
		options: [
			{ label: TXMSG('@fontfamily.gulim')+'<span class="tx-txt">(가나다라)</span>', title: TXMSG('@fontfamily.gulim'), data: 'Gulim,굴림', klass: 'tx-gulim' },
			{ label: TXMSG('@fontfamily.batang')+'<span class="tx-txt">(가나다라)</span>', title: TXMSG('@fontfamily.batang'), data: 'Batang,바탕', klass: 'tx-batang' },
			{ label: TXMSG('@fontfamily.dotum')+'<span class="tx-txt">(가나다라)</span>', title: TXMSG('@fontfamily.dotum'), data: 'Dotum,돋움', klass: 'tx-dotum' },
			{ label: TXMSG('@fontfamily.gungsuh')+' <span class="tx-txt">(가나다라)</span>', title: TXMSG('@fontfamily.gungsuh'), data: 'Gungsuh,궁서', klass: 'tx-gungseo' },
			{ label: 'Arial <span class="tx-txt">(abcde)</span>', title: 'Arial', data: 'Arial', klass: 'tx-arial' },
			{ label: 'Verdana <span class="tx-txt">(abcde)</span>', title: 'Verda..', data: 'Verdana', klass: 'tx-verdana' }
		]
	}
);

Trex.Tool.FontFamily = Trex.Class.create({
	$const: {
		__Identity: 'fontfamily'
	},
	$extend: Trex.Tool,
	$mixins: [Trex.I.CookieBaker],
	oninitialized: function(config) {
		var _tool = this;
		var _canvas = this.canvas;
		
		var _selectedProperty = _canvas.getStyleConfig().fontFamily;
		var _webfonts = (($tx.msie && config.webfont && config.webfont.use)? config.webfont.options: []);
		if(!$tx.msie) {
			_webfonts.each(function(webfont) {
				webfont.expired = true;
			});
		}
		var _optionz = (config.options || []).concat(_webfonts);
		
		var _map = {};
		_optionz.each(function(option) {
			var fontArr = option.data.split(",");
			for( var i = 0; i < fontArr.length; i++){
				_map[fontArr[i].toLowerCase()] = option.title;	
			}
			
		});
		_optionz.each(function(option) {
			if (!_map[option.title.toLowerCase()]) {
				_map[option.title.toLowerCase()] = option.title;
			}
		});
		
		var _getTextByValue = function(value) {
			if(_map[value.toLowerCase()]) {
				return _map[value.toLowerCase()];
			} else {
				value = value.replace("_9", "").replace("9", "");
				if (_map[value.toLowerCase()]) {
					return _map[value.toLowerCase()];
				} else {
					return _map[_selectedProperty];
				}
			}
		};
		
		var _useFavorite = false;
		if (config.useFavorite) {
			if (_webfonts.length > 0) {
				_useFavorite = true;
				_tool.initCookie('txFontFamilyFavorite');
			}
		}
		
		var _toolHandler = function(data) {
			_canvas.includeWebfontCss( "font-family: " + data );
			_canvas.execute(function(processor) {
				var _nodes = processor.inlines(function(type) {
					if(type === 'control') {
						return 'img,hr,table';
					}
					return '%text,span,font';
				});
				_nodes.each(function(node) { //clean tag
					$tom.descendants(node, '%inline').each(function(inNode) {
						$tom.applyAttributes(inNode, {
							'style': { 'fontFamily': null },
							'face': null
						});
					});
				});
				processor.apply(_nodes, { 
					'style': { 'fontFamily': data },
					'face': null	
				});
			});
			if(_useFavorite) {
				_tool.writeCookie(_tool.mergeValues(_tool.readCookie(), data));
			}
		};
		
		var _focusLoosed = false;
		var _initHandler = function() {
			_focusLoosed = false;
			if(!_useFavorite) {
				return [];
			}
			_tool.menu.elMenu.scrollTop = 0;
			var _elGroup = $tom.collect(_tool.menu.elMenu, "ul.tx-menu-favlist");
			if(_elGroup) {
				$tom.remove(_elGroup);
			}
			var _favorites = _tool.extractOptions(_optionz, _tool.readCookie());
			var _elGroup = _tool.menu.generateList(_favorites);
			$tom.insertFirst(_tool.menu.elMenu, _elGroup);
			$tx.addClassName(_elGroup, 'tx-menu-favlist');
			return _favorites;
		};

		/* button & menu weave */
		this.weave.bind(this)(
			/* button */
			new Trex.Button.Select(TrexConfig.merge(this.buttonCfg, {
				selectedValue: _selectedProperty,
				selectedText: _getTextByValue(_selectedProperty)
			})),
			/* menu */
			new Trex.Menu.Select(TrexConfig.merge(this.menuCfg, {
				options: _optionz
			})),
			/* handler */
			_toolHandler,
			/* menu init handler */
			_initHandler
		);
		
		if(_webfonts.length > 0) {
			$tx.addClassName(_tool.menu.elMenu, "tx-fontfamily-webfont-menu");
			var _elDummyForFocus = tx.input({'type': 'text', 'className': 'tx-dummyfocus'});
			$tom.append(_tool.menu.elMenu, _elDummyForFocus);
			$tx.observe(_tool.menu.elMenu, 'mousedown', function(ev) {
				if(ev.offsetX < _tool.menu.elMenu.clientWidth) { //not scrollbar
					return;
				}
				_elDummyForFocus.style.top = ev.offsetY.toPx();
				if(!_focusLoosed) {
					_elDummyForFocus.focus();
					_elDummyForFocus.blur();
					_tool.menu.elMenu.focus();
					_focusLoosed = true;
				}
			});
		}
		
		_canvas.observeJob(Trex.Ev.__CANVAS_PANEL_QUERY_STATUS, function() {
			var _data = _canvas.query(function(processor) {
				var _node = processor.findNode('%inline');
				return processor.queryStyle(_node, 'fontFamily');
			});
			
			if(_data == null) { 
				_data = _canvas.query(function(processor) {
					var _node = processor.findNode('%inline');
					return processor.queryAttr('face');
				});
			}
			_data = _data || _selectedProperty;
			try{
				var _dataArr = _data.split(",");
				var _text = "";
				for( var i = 0; i < _dataArr.length; i++ ){
					var _text = _text || _getTextByValue(_dataArr[i]);
				}
				_tool.button.setText(_text);
			}catch(e){ }
		});
	}
});
