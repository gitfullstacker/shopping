/**
 * DomFindy - Very Very Simple Dom Selector Engine, But find ancestor
 * - id : #
 * - class : .
 * - tag : tagname
 */
(function(){
	var m, el, els;
	var filters = {
		'#': function(cnxt, expr){
			if ((m = /(\S*)#(\S+)/.exec(expr)) !== null) {
				var tag = ((m[1] === "") ? "*" : m[1]);
				var id = m[2];
				var _node = cnxt;
				while(_node) {
					if(_node.nodeName.toLowerCase() == "body") {
						break;
					}
					if (tag == "*" || _node.nodeName.toLowerCase() == tag) {
						if (_node.id == id) {
							return _node;
						}
					}
					_node = _node.parentNode;
				}
			}
			return null;
		},
		'.': function(cnxt, expr){
			if ((m = /(\S*)\.(\S+)/.exec(expr)) !== null) {
				var tag = ((m[1] === "") ? "*" : m[1]);
				var klass = m[2];
				var _node = cnxt;
				while(_node) {
					if(_node.nodeName.toLowerCase() == "body") {
						break;
					}
					if (tag == "*" || _node.nodeName.toLowerCase() == tag) {
						if (_node.className.indexOf(klass) > -1) {
							return _node;
						}
					}
					_node = _node.parentNode;
				}
			}
			return null;
		},
		'*': function(cnxt, expr){
			var _node = cnxt;
			var map = {};
			var exprs = expr.split(",");
			for (var i=0,len=exprs.length; i<len; i++) {
				map[exprs[i]] = true;
			}
			while(_node) {
				if(_node.nodeName.toLowerCase() == "body") {
					break;
				}
				if (map[_node.nodeName.toLowerCase()]) {
					return _node;
				}
				_node = _node.parentNode;
			}
			return null;
		}
	};
	
	var find = function(cnxt, expr) {
		var fltr;
		if ((f = /(\.|#|:\w+)/.exec(expr)) !== null) {
			if(filters[f[1]]) {
				fltr = f[1];
			}
		}
		fltr = fltr || "*";
		var result = null;
		if((result = filters[fltr](cnxt, expr)) != null) {
			return result;
		};
		return null;
	}
	
	var DomFindy = function(context, selector) {
		if ( !selector || typeof selector !== "string" ) {
			return null;
		}
		
		var els = context;
		var exprs = selector.split(" ");
		for(var i=0,len=exprs.length; i<len; i++) {
			if((els = find(els, exprs[i])) == null) {
				return null;
			}
		} 
		return els;
		/*
		if (els.length < 1) {
			return null;
		} else if (els.length < 2) {
			return els[0];
		} else {
			return els;
		}*/
	};
 
	/**
	 * Find Ancestor Element By Css Selector
	 * 
	 * dFindy(element, selector) or dFindy(selector)
	 * ex)
	 *  dFindy($tx("#wrapper"), "div.article")
	 *  dFindy("#wrapper div.article") -> default document
	 */
	window.dFindy = function() {
		if(arguments.length == 1) {
			throw new Error("need more arguments");
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				return DomFindy(arguments[0], arguments[1]);
			}
		}
		return null;
	};
})();
