Trex.I.Processor.Webkit = {
	/**
	 * Paragraph 를 채운다.
 	 * @private
 	 * @param {Node} node - paragraph 노드
	 */
	stuffNode: function(node) {
		return $tom.stuff(node, this.newNode('br'));
	},
	/**
	 * @private
	 * @memberOf Trex.Canvas.ProcessorP
	 * Webkit에서 newlinepolicy가 p일 경우 Enter Key 이벤트가 발생하면 실행한다. 
	 * @param {Event} ev - Enter Key 이벤트
	 */
	controlEnterByParagraph: function(ev) {
		var _iNode = this.findNode('span');
		if(!_iNode || !_iNode.style.backgroundColor) {
			throw $propagate;
		}
		
		var _pNode = this.findNode('%paragraph');
		var _dvNode;
		this.execWithMarker(function(marker) {
			_dvNode = $tom.divideParagraph(marker.endMarker);
		});
		this.stuffNode(_pNode);
		this.stuffNode(_dvNode);
		this.moveCaretTo(_dvNode);
	},
	/**
	 * @private
	 * @memberOf Trex.Canvas.ProcessorBR
	 * Webkit에서 newlinepolicy가 br일 경우 Enter Key 이벤트가 발생하면 실행한다. 
	 * @param {Event} ev - Enter Key 이벤트
	 */
	controlEnterByLinebreak: function(ev) {
		var _processor = this;
		var _rng = this.getRange(false);
		var _parent = _rng.endContainer.parentNode;
		
		if (_parent && (_parent.tagName == "P" || _parent.tagName == "DIV" || _parent.tagName == "BODY" || _parent.tagName == "BLOCKQUOTE")) {
			
			if(_parent.tagName == "BLOCKQUOTE" || $tx.hasClassName(_parent, "txc-textbox") || $tx.hasClassName(_parent, "txc-moreless")){
				$tx.stop(ev);
				var _brNode = _processor.win.br();
				_rng.insertNode(_brNode);
				_rng.selectNode(_brNode);
				_rng.collapse(false);	
				_brNode = _processor.win.br();
				_rng.insertNode(_brNode);
				_rng.selectNode(_brNode);
				_rng.collapse(false);	
				
				var _rng = _processor.getRange(false);
				_rng.selectNodeContents(_brNode.nextSibling);
				
				var _sel = _processor.getSel();
				_sel.removeAllRanges();
				_sel.addRange(_rng);
				_sel.collapseToStart();
			}
		}	
	}
};
