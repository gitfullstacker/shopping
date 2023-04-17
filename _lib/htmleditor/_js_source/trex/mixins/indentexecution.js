Trex.I.IndentExecution = Trex.Mixin.create(/** @lends Trex.I.IndentExecution */{
	executeIndentByKeyEvent: function(processor) {
		if (processor.isCollapsed()) {
			var _textPos = processor.compareTextPos();
			if (_textPos == $tom.__POSITION.__MIDDLE_OF_TEXT) {
				this.executeAppendPadding(processor);
				return;
			} else if(_textPos == $tom.__POSITION.__END_OF_TEXT) {
				if (processor.findNode('td')) {
					this.goNextCell(processor);
					return;
				}
			}
		}
		this.executeIndentParagraph(processor);
	},
	executeOutdentByKeyEvent: function(processor) {
		if (processor.isCollapsed()) {
			var _textPos = processor.compareTextPos();
			if(_textPos == $tom.__POSITION.__START_OF_TEXT) {
				if (processor.findNode('td')) {
					this.goPreviousCell(processor);
					return;
				}
			}
		}
		this.executeOutdentParagraph(processor);
	},
	executeIndentParagraph: function(processor) {
		var _nodes = processor.blocks(function() {
			return '%paragraph';
		});
		if(!_nodes) {
			return null;
		}
		
		var _attributes = {	'style': { 'marginLeft': "+4em" } };
		
		var _curGNode;
		var _subGNode;
		$A(_nodes).each(function(node) {
			if ($tom.kindOf(node, "li,dd,dt")) {
				var _gNode = $tom.ancestor(node, 'ul,ol,dl');
				if(_gNode) {
					if (_gNode != _curGNode) {
						_subGNode = null;
					}
					if (_subGNode) {
						$tom.append(_subGNode, node);
					} else {
						_subGNode = $tom.wrap($tom.clone(_gNode), node);
					}
					_curGNode = _gNode;
				} else {
					$tom.applyAttributes(node, _attributes); //invalid case
				}
			} else if ($tom.kindOf(node, "td,th")) {
				var _pNode = processor.newNode('p');
				$tom.moveChild(node, _pNode);
				$tom.append(node, _pNode);
				$tom.applyAttributes(_pNode, _attributes);
			} else {
				$tom.applyAttributes(node, _attributes);
			}
		});
	},
	executeOutdentParagraph: function(processor) {
		var _nodes = processor.blocks(function() {
			return '%paragraph';
		});
		if(!_nodes) {
			return null;
		}
		
		var _attributes = {	'style': { 'marginLeft': "-4em" } };
		
		$A(_nodes).each(function(node) {
			if ($tom.kindOf(node, "li,dd,dt")) {
				var _gNode = $tom.ancestor(node, 'ul,ol,dl');
				if(_gNode) {
					var _ngNode = $tom.divideNode(_gNode, $tom.indexOf(node));
					var _ggNode = $tom.ancestor(_ngNode, 'ul,ol,dl');
					if(_ggNode) {
						$tom.insertAt(node,_ngNode);
					} else {
						var _lNode = $tom.replace(node, processor.newNode('p'));
						$tom.insertAt(_lNode,_ngNode);
					}
					if(!$tom.first(_gNode, 'li')) {
						$tom.remove(_gNode);
					}
					if(!$tom.first(_ngNode, 'li')) {
						$tom.remove(_ngNode);
					}
				} else {
					$tom.applyAttributes(node, _attributes); //invalid case
				}
			} else {
				$tom.applyAttributes(node, _attributes);
			}
		});
	},
	goNextCell: function(processor) {
		var _cNode = processor.findNode('td,th');
		var _tNode = $tom.ancestor(_cNode, 'table');
		var _allNodes = $tom.collectAll(_tNode, 'td,th');
		while(_allNodes.length > 0) {
			if(_cNode == _allNodes.shift()) {
				break;
			}
		}
		if(_allNodes.length > 0) {
			processor.bookmarkInto(_allNodes[0]);
		} else {
			processor.bookmarkToNext(_tNode);
		}
	},
	goPreviousCell: function(processor) {
		var _cNode = processor.findNode('td,th');
		var _tNode = $tom.ancestor(_cNode, 'table');
		var _allNodes = $tom.collectAll(_tNode, 'td,th');
		while(_allNodes.length > 0) {
			if(_cNode == _allNodes.pop()) {
				break;
			}
		}
		if(_allNodes.length > 0) {
			processor.bookmarkInto(_allNodes[_allNodes.length - 1]);
		} else {
			processor.bookmarkToPrevious(_tNode);
		}
	},
	executeAppendPadding: function(processor) {
		processor.pasteContent("&nbsp;&nbsp;&nbsp;&nbsp;", false);
	}
});
