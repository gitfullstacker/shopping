
Trex.module("make padding area inside Canvas with editor width", 
	function(editor, toolbar, sidebar, canvas, config) {
	
		var _sizeConfig = canvas.getSizeConfig();
		var __EditorMaxWidth = _sizeConfig.wrapWidth;
		var __CanvasWidth = _sizeConfig.contentWidth;
		var __ContentPadding = _sizeConfig.contentPadding;
		if(__EditorMaxWidth == __CanvasWidth) {
			return;
		}
		
		var __CanvasTextColor = canvas.getStyleConfig().color;
		
		var __HolderHorPadding = (__CanvasWidth == 971)? 5:0;
		var __HolderVerPadding = 5;
		var __ScrollWidth = 16;
	
		var _elHolder;
		var _elPaddingLeft;
		var _elPaddingRight;
		
		var _wysiwygPanel;
		var _wysiwygDoc;
		var _elWysiwyg;
		
		//iframe 패딩과 패딩영역의 사이즈를 계산한다.
		var _calculateSize = function(padding) {
			var _paddingWidth = Math.max(Math.ceil((__EditorMaxWidth - __CanvasWidth - __HolderHorPadding * 2 - __ScrollWidth - 2) / 2), 0);
			var _paddingTop = __ContentPadding;
			
			var _paddingTop = __ContentPadding;
			var _paddingBottom = __ContentPadding;
			
			if (padding && padding.paddingTop > 0) {
				_paddingTop = padding.paddingTop;
			}
			if (padding && padding.paddingBottom > 0) {
				_paddingBottom = padding.paddingBottom;
			}
			return {
				panel: {
					paddingTop: (__HolderVerPadding + _paddingTop).toPx(),
					paddingRight: (_paddingWidth + __ContentPadding + __HolderHorPadding).toPx(),
					paddingBottom: (__HolderVerPadding + _paddingBottom).toPx(),
					paddingLeft: (_paddingWidth + __ContentPadding + __HolderHorPadding).toPx()
				},
				emptyspace: {
					width: _paddingWidth.toPx(),
					right: (_paddingWidth + __HolderHorPadding + __CanvasWidth).toPx()
				}
			};
		};
		
		var _hidePaddingSpace = function(){
			$tx.hide( _elLeftSpace );
			$tx.hide( _elRightSpace );
		}
		var _showPaddingSpace = function(){
			$tx.show( _elLeftSpace );
			$tx.show( _elRightSpace );
		}
		// iframe이 로딩되면 패딩영역을 추가한다.
		canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {
			_elHolder = canvas.wysiwygEl;
			_wysiwygPanel = canvas.getPanel(Trex.Canvas.__WYSIWYG_MODE);
			if (!_wysiwygPanel) {
				return;
			}
			
			_wysiwygDoc = _wysiwygPanel.getDocument();
			_elWysiwyg = _wysiwygPanel.el;
			
			var _height = _wysiwygPanel.getPanelHeight();
			var _size = _calculateSize();
			
			_wysiwygPanel.addStyle(_size.panel);
			
			if (!$tx.msie) {
				$tx.setStyle(_elWysiwyg, {
					'overflowX': 'auto',
					'overflowY': 'scroll'
				});
			}
			
			_elLeftSpace = tx.div({ 
				'className': "tx-wysiwyg-padding", 
				'style': {
					'width': _size.emptyspace.width,
					'height': _height,
					'left': "0".toPx()
				}
			});
			
			_elLeftSpaceChild = tx.div({'className': "tx-wysiwyg-padding-divL",
				'style': {
					'borderRight': "1px solid " ,
					'borderBottom': "1px solid ",
					'borderColor': __CanvasTextColor
				}});
			_elLeftSpace.appendChild(_elLeftSpaceChild);
			_elHolder.insertBefore(_elLeftSpace, _elWysiwyg);
			
			_elRightSpace = tx.div({ 
				'className': "tx-wysiwyg-padding", 
				'style': {
					'width': _size.emptyspace.width,
					'height': _height,
					'left': _size.emptyspace.right
				}
			});
			
			_elRightSpaceChild = tx.div({ 'className': "tx-wysiwyg-padding-divR",
				'style': {
					'borderLeft': "1px solid " ,
					'borderBottom': "1px solid ",
					'borderColor': __CanvasTextColor
				}});
				
			_elRightSpace.appendChild(_elRightSpaceChild);
			_elHolder.insertBefore(_elRightSpace, _elWysiwyg);
			
			_wysiwygPanel.getScrollTop = function() { 
				return (_wysiwygDoc.documentElement.scrollTop || _wysiwygDoc.body.scrollTop);
			};
			
			_wysiwygPanel.setScrollTop = function(scrollTop) { 
				if(_wysiwygDoc.documentElement.scrollTop) {
					_wysiwygDoc.documentElement.scrollTop = scrollTop;
				} else {
					_wysiwygDoc.body.scrollTop = scrollTop;
				}
			};
			if ( canvas.mode != "html" ){
				_hidePaddingSpace();
			}
		});
		
		//모드를 변경하였을 경우 패딩영역 처리 
		canvas.observeJob(Trex.Ev.__CANVAS_MODE_CHANGE, function(from, to) {
			if(from == to) return;
			if(from == Trex.Canvas.__WYSIWYG_MODE) {
				_hidePaddingSpace();
			} else if(to == Trex.Canvas.__WYSIWYG_MODE) {
				_showPaddingSpace();
			}
		});
		
		//에디터 높이가 변하였을 경우 패딩영역의 높이를 조절한다.
		canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(height) {
			_elLeftSpace.style.height = height;
			_elRightSpace.style.height = height;
		});
		
		//배경이 적용되었을 경우 사이즈를 변경한다. 
		canvas.observeJob('canvas.apply.background', function(data) {
			var _padding = {
				paddingTop: 0,
				paddingBottom: 0
			};
			if(data.topLeftImage) { //스킨
				_padding.paddingTop = data.topLeftHeight.parsePx();
				_padding.paddingBottom = data.botLeftHeight.parsePx();
			}
			var _size = _calculateSize(_padding);
			_wysiwygPanel.addStyle(_size.panel);
		});
		
		canvas.getCanvasGuideSize = function(){
			return _calculateSize().emptyspace.width.parsePx();
		};
	}
);

