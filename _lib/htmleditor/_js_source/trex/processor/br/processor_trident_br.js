
Trex.I.Processor.TridentBR = {
	/** Overriding */
	/** End Override */
	getTxRange: function(_rng){
		var beforeStart, afterEnd;
		var _sel = this.getSel();
		if (_sel.type == "Control") {
			_node = _rng.item(0);
			
			beforeStart =  this.win.span({ id: "tx_beforestart_mark"});
			afterEnd =  this.win.span({ id: "tx_afterend_mark"});
			_node.parentNode.insertBefore(beforeStart, _node);
			if(_node.nextSibling){
				_node.parentNode.insertBefore(afterEnd, _node.nextSibling);
			}else{
				_node.parentNode.appendChild(_afterEnd);
			}

		} else {
			if (_rng.htmlText.length != 0) {
				var _rng1 = _rng.duplicate();
				var _rng2 = _rng.duplicate();
				
				_rng1.collapse(true);
				_rng1.pasteHTML('<span id="tx_beforestart_mark"></span>');
				
				_rng2.collapse(false);
				_rng2.pasteHTML('<span id="tx_afterend_mark"></span>');
				
				beforeStart = this.doc.getElementById('tx_beforestart_mark');
				afterEnd = this.doc.getElementById('tx_afterend_mark');
			} else {
				var _rng3 = _rng.duplicate();
				_rng3.collapse(false);
				_rng3.pasteHTML('<span id="tx_beforestart_mark"></span><span id="tx_afterend_mark"></span>');
				
				beforeStart = this.doc.getElementById('tx_beforestart_mark');
				afterEnd = this.doc.getElementById('tx_afterend_mark');
			}
			
			var length = _rng.htmlText.length;
		}
		return {
			"beforeStart": beforeStart,
			"afterEnd": afterEnd,
			"rng": _rng,
			"collapsed": (length == 0 ? true : false) 
		};
	}
};

