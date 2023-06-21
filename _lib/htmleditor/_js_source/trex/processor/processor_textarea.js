Trex.Canvas.TextAreaProcessor = Trex.Class.create({
	$mixins: [ ],
	initialize: function(textarea) {
		this.el = textarea;
	},
	focus: function() {
		this.el.focus();
	},
	blur: function() {
		window.focus();
	},
	savePosition: function() {
		if (this.el.createTextRange) {
			this.currentPos = document.selection.createRange().duplicate();
		}	
	},
	controlEnter: function(ev) {
		var _processor = this;
		_processor.insertTag("<br/>", "");
	},
	insertTag: function(prefix, postfix) {
		var _el = this.el;
		var selection = $tx.webkit ? window.getSelection : document.selection;
		if(selection) {
			if (selection.createRange) {
				var _range = this.currentPos;
				_range.text = prefix + _range.text + postfix;
				this.savePosition(_el);
				_el.focus();
			} else {
				_el.value = _el.value + prefix + postfix;
			}	
		}else if(_el.selectionStart) {
			var begin = _el.value.substr(0, _el.selectionStart);
			var selection = _el.value.substr(_el.selectionStart, _el.selectionEnd - _el.selectionStart);
			var end = _el.value.substr(_el.selectionEnd);
			var newCursorPos = _el.selectionStart;
			var scrollPos = _el.scrollTop;

			_el.value = begin + prefix + selection + postfix + end;

			if(_el.setSelectionRange) {
				if (selection.length == 0) {
					_el.setSelectionRange(newCursorPos + prefix.length, newCursorPos + prefix.length);
				} else {
					_el.setSelectionRange(newCursorPos, newCursorPos + prefix.length + selection.length + postfix.length);
				}	
				_el.focus();
			}
			_el.scrollTop = scrollPos;
		} else {
			_el.value += prefix + postfix;
			_el.focus(_el.value.length - 1);
		}
		return true;
	}
});
