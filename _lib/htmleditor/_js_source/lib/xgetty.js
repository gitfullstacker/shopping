/**
 * XMLGetty - Very Very Simple XML Dom Selector Engine By XPath
 * - xpath
 */
(function(){
	
	var XMLGetty = function(node){
		this.selectSingleNode = function(path) {
			if(!node) {
				return null;
			}
			return node.selectSingleNode(path);
		};
		this.selectNodes = function(path) {
			if(!node) {
				return [];
			}
			return node.selectNodes(path);
		};
		this.getAttributeNode = function(name) {
			if(!node) {
				return null;
			}
			return node.getAttributeNode(name);
		};
		this.hasChildNodes = function() {
			if(!node) {
				return false;
			}
			return node.hasChildNodes();
		};
		this.text = node? (node.textContent || node.text) : null;
		this.type = node? node.nodeType : 0;
		this.name = (node && node.nodeType == 1)? (node.nodeName || "") : "";
		return this;
	};
	
	XMLGetty.prototype = {
		'xText': function(defval){
			defval = defval || "";
			var _val = this.text;
			_val = (_val || "").trim();
			
			if (_val === "") {
				return defval;
			} else {
				if (typeof(defval) === 'number') {
					return (isNaN(_val) ? 0 : parseInt(_val));
				} else if (typeof(defval) === 'boolean') {
					return !!_val;
				} else {
					return _val;
				}
			}
		},
		'xAttr': function(name, defval){
			defval = defval || "";
			var _attr = this.getAttributeNode(name);
			var _val = (!_attr) ? "" : _attr.nodeValue.trim();
			if (_val === "") {
				return defval;
			} else {
				if (typeof(defval) === 'number') {
					return (isNaN(_val) ? 0 : parseInt(_val));
				} else if (typeof(defval) === 'boolean') {
					return !!_val;
				} else {
					return _val;
				}
			}
		},
		'xGet': function(path){
			return xGetty(this, path);
		},
		'xGets': function(path){
			return xGetties(this, path);
		}
	};
	
	var ieXmlParsers = [
		"MSXML2.DOMDocument.6.0",
		"MSXML2.DOMDocument.5.0",
		"MSXML2.DOMDocument.4.0",
		"MSXML4.DOMDocument",
		"MSXML3.DOMDocument",
		"MSXML2.DOMDocument",
		"MSXML.DOMDocument",
		"Microsoft.XmlDom"
	];
	/**
	 * xCreate : Get XML DOM From XML Text
	 * @example
	 * var _xmlDoc = xCreate("<data><name>hopeserver</name></data>");
	 * 
	 * @param {string} text - responseText
	 * @return node 
	 * 			extend function as xText, xAttr, xGet, xGets
	 */
	window.xCreate = function(text) {
		if(!!(window.attachEvent && !window.opera)) {
			var xObj = (function() {
				var _xObj = null;
				for(var i=0; i<ieXmlParsers.length; i++) {
					try {
						_xObj = new ActiveXObject(ieXmlParsers[i]);
					} catch (e) {}
					if(_xObj !== null) {
						return _xObj;
					}
				}
				return null;
			})();
			if(xObj === null){
				return null;
			}
			xObj.async = false;
			xObj.loadXML(text);
			if (xObj.parseError.errorCode !== 0) {
				return null;
			}
			return new XMLGetty(xObj);
		} else {
			var oParser = new DOMParser();
			var xObj = oParser.parseFromString(new String(text), "text/xml");
			return new XMLGetty(xObj);
		}
	};

	/**
	 * xGetty : Get Node By Xpath
	 * @example
	 * var _node = xGetty(node, "/rss/items/title")
	 * 
	 * @param {element} node - node
	 * @param {string} path - xpath expression
	 * 
	 * @return node 
	 * 			node extends function as xText, xAttr, xGet, xGets
	 */
	window.xGetty = function(node, path) {
		if(node === null) {
			return null;
		}
		return new XMLGetty(node.selectSingleNode(path));
	};
	
	/**
	 * xGetties : Get Node List By Xpath
	 * @example
	 * var _nodelist = xGetties(node, "/rss/items/title")
	 * 
	 * @param {element} node - node
	 * @param {string} path - xpath expression
	 * 
	 * @return node array
	 * 			each node extends function as xText, xAttr, xGet, xGets
	 */
	window.xGetties = function(node, path) {
		if(node === null) {
			return [];
		}
		var list = []
		var nodes = node.selectNodes(path);
		for(var i=0, len=nodes.length; i<len; i++) {
			list.push(new XMLGetty(nodes[i]));
		}
		return list;
	};

})();