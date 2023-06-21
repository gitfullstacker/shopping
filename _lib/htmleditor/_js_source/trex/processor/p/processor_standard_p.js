
Trex.I.Processor.StandardP = {
	putBogusParagraph: function() {
		var _body = this.doc.body;
		var _lastChild = $tom.last(_body);
		if (_lastChild && $tom.kindOf(_lastChild, 'p')) {
			return;
		}
		var _newChild = this.newParagraph('p');
		if($tom.kindOf(_lastChild, "br")) {
			$tom.replace(_lastChild, _newChild);
		} else {
			$tom.append(_body, _newChild);
		}
	}
};


Trex.module("put bogus paragraph @when any key event fires",
	function(editor, toolbar, sidebar, canvas, config) {
		if($tx.msie) {
			return;
		}
		if (canvas.config.newlinepolicy == "p") {
			canvas.reserveJob(Trex.Ev.__CANVAS_PANEL_KEYUP, function(ev){
				if (!canvas.canHTML()) {
					return;
				}
				var _processor = canvas.getProcessor();
				_processor.putBogusParagraph();
			}, 10);
		}
	}
);
