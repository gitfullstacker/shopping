
var Split = function(){
	this.initialize.apply(this, arguments);
};
Split.prototype = {
	initialize: function(root, props){
		this.root = root;
		this.clonePolicy = props.clonePolicy ? props.clonePolicy : "backend";
		this.target = props.target ? props.target : null;
		this.filter =  props.filter ? props.filter : true;
	},
	run: function(){
		return this.split(this.target);
	},
	split: function(target){
		var _t = target;
		var _p = _t.parentNode;
		if(_p.nodeName == "BODY"){
			return;
		}
		if(!this.filter(_t)){
			return _t;
		}
		var _pClone;
		if(_p && _p !== this.root){
			_pClone = _p.cloneNode(false);
			if(this.clonePolicy == "backend"){
				do{
					var tmp = _t.nextSibling;
					_pClone.appendChild(_t);
					var _t = tmp;
				} while(_t);
				
				if(_p.nextSibling){
					_p.parentNode.insertBefore(_pClone, _p.nextSibling);
				}else{
					_p.parentNode.appendChild(_pClone);
				}
				this.split(_pClone);
			}else if(this.clonePolicy == "frontend"){
				do{
					var tmp = _t.previousSibling;
					if(!_pClone.firstChild){
						_pClone.appendChild(_t);
					}else{
						_pClone.insertBefore(_t, _pClone.firstChild);
					}
					_t = tmp;
				} while(_t);
				
				_p.parentNode.insertBefore(_pClone, _p);
				this.split(_pClone);
			}
		}else{
			//console.log("Finished");
		}		
		return _pClone;
	}
};

Trex.I.Processor.StandardBR = {
	expand: function (txRng){
		this.moveStartElement(txRng.beforeStart);
		this.moveEndElement(txRng.afterEnd);
	},
	moveStartElement: function(beforeStart){
		var found, last;
		var tagList = ["P", "DIV", "OL", "UL", "LI", "BLOCKQUOTE", "TABLE", "TR", "TD", "BODY"];
		this.walkBetweenNodesDesc(beforeStart, this.doc.body.firstChild,
			function(node){
				last = node;
				if (!found) {
					if (node.nodeType != 1) {
						return;
					}
					if (node.nodeName == "BR") {
						found = node;
					} else {
						var res = tagList.detect(function(tag){
							if (tag == node.nodeName) {
								found = node;
								return true;
							}
							return false;
						});
					}
				}
			}
		);
		if(!found ){
			found = last.parentNode;
		}
		if (found.nodeName == "BR") {
			if (found.nextSibling) {
				found.parentNode.insertBefore(beforeStart, found.nextSibling);
			} else {
				found.parentNode.appendChild(beforeStart);
			}
		} else {
			if (this.isParentOf(beforeStart, found)) {
				found.insertBefore(beforeStart, found.firstChild);
			} else {
				found.parentNode.insertBefore(beforeStart, found.nextSibling);
			}
		}	
	},
	moveEndElement: function(afterEnd){
		var found, last;
		var tagList = ["P", "DIV", "OL", "UL", "LI", "BLOCKQUOTE", "TABLE", "TR", "TD", "BODY"];
		this.walkBetweenNodes2(afterEnd, this.doc.body.lastChild,
			function(node){
				last = node;
				if (!found) {
					if (node.nodeType != 1) {
						return;
					}
					if (node.nodeName == "BR") {
						found = node;
					} else {
						tagList.detect(function(tag){
							if (tag == node.nodeName) {
								found = node;
								return true;
							}
							return false;
						});
					}
				}
			}
		);
		if(!found ){
			found = last || afterEnd.parentNode.lastChild;
		}
		if (found.nodeName == "BR") {
			if (found.nextSibling) {
				found.parentNode.insertBefore(afterEnd, found.nextSibling);
			} else {
				found.parentNode.appendChild(afterEnd);
			}
		} else {
			if (this.isParentOf(afterEnd, found)) {
				found.appendChild(afterEnd);
			} else {
				found.parentNode.insertBefore(afterEnd, found);
			}
		}	
	},
	findSameParent: function(node1, node2){
		var output;
		var node1Parents  = [node1];
		var loop = node1;
		while	(loop.nodeName != "BODY"){
			loop = loop.parentNode;
			node1Parents.push(loop);
		}
		loop = node2;
		while	(loop.nodeName != "BODY"){
			for(var i = 0; i < node1Parents.length; i++){
				if(node1Parents[i] === loop){
					output = node1Parents[i];
					break;
				}
			}
			loop = loop.parentNode;
		}R
		return (output || this.doc.body); 
	},
	hasSameTagName: function(nodeList){
		var _tagName;
		for(var i = 0; i < nodeList.length; i ++){
			var _node = nodeList[i];
			if(!_tagName){
				_tagName = _node.tagName;	
			}else{
				if(_tagName != _node.tagName){
					return false;
				}
			}
		}
		return _tagName;
	},
	collectTextNodesBetweenMarkers: function(beforeStart, afterEnd) {
		var _nodelist = [];
		this.walkBetweenNodes(beforeStart, afterEnd, function(node) {
			if(node.nodeType == 3) {
				if(!node.nodeValue.match(new RegExp('^[\s\t\n]+$'))) {
					_nodelist.push(node);
				}
			} else if($tom.kindOf(node, "img")) {
				_nodelist.push(node);
			}
		});
		return _nodelist; 
	},
	walkBetweenNodes2: function(startNode, endNode, fn) {
		var TRAILING = 0; 
		var LEADING = 1;
		var node = startNode, edge = LEADING;
		var update = function(newNode, newEdge) {
			node = newNode; 
			edge = newEdge;
			//if(edge == LEADING) {
				fn(node);
			//}
		};
		if (startNode === endNode) {
			fn(startNode);
		} else {
			do {
				if (node.firstChild && edge != TRAILING) {
					update(node.firstChild, LEADING);
				} else if (node.nextSibling) {
					update(node.nextSibling, LEADING);
				} else if (node.parentNode) {
					update(node.parentNode, TRAILING);
				}
			} while (node != endNode);
		}
	},
	walkBetweenNodes: function(startNode, endNode, fn) {
		var TRAILING = 0; 
		var LEADING = 1;
		var node = startNode, edge = LEADING;
		var update = function(newNode, newEdge) {
			node = newNode; 
			edge = newEdge;
			if(edge == LEADING) {
				fn(node);
			}
		};
		if (startNode === endNode) {
			fn(startNode);
		} else {
			do {
				if (node.firstChild && edge != TRAILING) {
					update(node.firstChild, LEADING);
				} else if (node.nextSibling) {
					update(node.nextSibling, LEADING);
				} else if (node.parentNode) {
					update(node.parentNode, TRAILING);
				}
			} while (node != endNode);
		}
	},
	walkBetweenNodesDesc: function(startNode, endNode, fn) {
		var TRAILING = 0; 
		var LEADING = 1;
		var node = startNode, edge = LEADING;
		var update = function(newNode, newEdge) {
			node = newNode; 
			edge = newEdge;
			//if(edge == LEADING) {
				fn(node);
			//}
		};
		if (startNode === endNode) {
			fn(startNode);
		} else {
			do {
				if (node.lastChild && edge != TRAILING) {
					update(node.lastChild, LEADING);
				}else if (node.previousSibling) {
					update(node.previousSibling, LEADING);
				}else if (node.parentNode) {
					update(node.parentNode, TRAILING);
				}
			} while (node != endNode);
		}
	},
	exec: function(fn, isexpand){
		try{
			var txRng = this.getTxRange(this.getRange());
			if(isexpand){
				this.expand(txRng);	
			}
			var landmark = this.tidy(txRng);
			if(fn){
				fn(landmark);
			}
		}finally{
			this.clean();	
		}
  	},
	groupInlineElementsWith: function(tagName, start, end ){
		if (start === end) {
			return [start];
		} else if (start.nextSibling === end) {
			return [start, end];
		}
		var collection = [];
		var block = this.doc.createElement(tagName);
		
		var startTag = start.nodeName;
		var endTag = end.nodeName;
		var isParentOfnodeCollected = false;
		var loop = start;
		do{
			if(loop.nodeType == 1 && 
				( loop.nodeName == "UL" || 
				  loop.nodeName == "OL" || 
				  loop.nodeName == "TABLE" || 
				  loop.nodeName == "TR" ||
				  loop.nodeName == "DIV" ||
				  loop.nodeName == "P" )
			){
				if(!isParentOfnodeCollected){
					collection.push(loop);
				}
				if (block.hasChildNodes()) {
					loop.parentNode.insertBefore(block, loop);
					collection.push(block);
					block = this.doc.createElement("div");
				}
			} else if ( loop.nodeName == "LI" || loop.nodeName == "TD" ){
				collection.push(loop);					
			} else {
				var tmp = loop.previousSibling;
				block.appendChild(loop);
				loop = tmp;
			} 
			if(loop.nextSibling){
				loop = loop.nextSibling;
				isParentOfnodeCollected = false;
			}else{
				loop = loop.parentNode;
				isParentOfnodeCollected = true;
			}
			if( startTag == "TD" && 
				(loop.nodeName == "TD" || loop.nodeName == "TR" ||	 loop.nodeName == "TH" || loop.nodeName == "TABLE" ) ){
			}else if(startTag == "LI" && 	(loop.nodeName == "LI" || loop.nodeName == "OL" || loop.nodeName == "UL"  )){
			}else if(startTag == "P"  || startTag == "DIV"){
				if(loop.nodeType == 3){
				}else if ( loop.nodeName == "TABLE" ||  loop.nodeName == "OL" ||  loop.nodeName == "UL"  ) {
					if( endTag == "LI" || endTag == "TD"){
						collection.push(loop);
						break;	
					}
				}
			} else {
				break;
			}
			if (loop === end) {
				collection.push(loop);
				break; 
			}else if(loop.nodeName == "BODY"){
				break;
			}
		}while(true);
		return collection;	
	},
	tidy: function(txRng){
		var isMatched= function(_el){
			return ["P", "UL", "OL", "TABLE", "DIV"].detect(
				function(tag){ 
					if(_el.nodeType == 1 && tag == _el.nodeName){ 
						if(tag == "DIV"){
							if(_el.className == "txc-textbox" || _el.className == "txc-moreless" ){
								return false;
							}	
						}
						return true;
					} else{
						return false;
					}
				}
			);
		};
		
		var filterFn = function(node){
			var parent = node.parentNode;
			if(parent.nodeName == "BODY"){
				return false;
			}else if(parent.nodeName == "UL"  ||  parent.nodeName == "OL"){
				return false;
			}else if(parent.nodeName == "TBODY" || parent.nodeName == "TD" || parent.nodeName == "TR"  ||  parent.nodeName == "TABLE"){
				return false;
			}else if(parent.className == "txc-textbox" || parent.className == "txc-moreless" ){
				return false;
			}	
			return true;
		};
		
		var start, end;
		var fromElement = txRng.beforeStart;
		var toElement = txRng.afterEnd;
		if(fromElement.parentNode.nodeName == "BODY" ||
			fromElement.parentNode.className == "txc-textbox" ||
			fromElement.parentNode.className == "txc-moreless"
		){
			var dest = this.doc.createElement("div");
			fromElement.parentNode.insertBefore(dest, fromElement);
			var _el = fromElement;
			while(true){
				if(!_el ){
					break;
				}
				if(isMatched(_el)){
					break;
				}
				dest.appendChild(_el);
				_el = dest.nextSibling;
			}
			start = dest;
		}else{
			start = new Split(this.doc.body, { 
				clonePolicy: "frontend", 
				target: fromElement,
				filter: filterFn
			}).run();
			if(start.nodeName == "LI" ||  start.nodeName == "UL" || start.nodeName == "OL" ){
				start = start.nextSibling;
			}else{
				while(
					!(start.parentNode.nodeName == "BODY" ||
					start.parentNode.className == "txc-textbox" || 
					start.parentNode.className == "txc-moreless")
				){
					start = start.parentNode;	
				}
				start = start.nextSibling;	
			}
		}
		
		if(toElement.parentNode.nodeName == "BODY"){	
			var dest = this.doc.createElement("div");
			if(toElement.nextSibling){
				toElement.parentNode.insertBefore(dest, toElement.nextSibling);
			}else{
				toElement.parentNode.appendChild(dest);
			}
			var _el = toElement;
			while(true){
				if(!_el){
					break;
				}
				if(isMatched(_el)){
					break;
				}
				if(dest.hasChildNodes()){
					dest.insertBefore(_el, dest.firstChild);
				}else{
					dest.appendChild(_el);
				}
				_el = dest.previousSibling;
			}
			end = dest;
		}else{
			end = new Split(this.doc.body, { 
				clonePolicy: "backend", 
				target: toElement,
				filter: filterFn
			}).run();
			if (end.nodeName == "LI" || end.nodeName == "UL" || end.nodeName == "OL") {
				end = end.previousSibling;
			} else {
				while(
					!(end.parentNode.nodeName == "BODY" ||
					end.parentNode.className == "txc-textbox" || 
					end.parentNode.className == "txc-moreless")
				){
					end = end.parentNode;
				}
				end = end.previousSibling;
			}

		}
		return {
			startElement: start,
			endElement: end
		};
	},
	clean: function (){
		var m1 = this.doc.getElementById("tx_beforestart_mark");
		if(m1){
			var p = m1.parentNode;
			if(p.childNodes.length == 1){
				p.parentNode.removeChild(p);
			}else{
				m1.parentNode.removeChild(m1);
			}
		}
		var m2 = this.doc.getElementById("tx_afterend_mark");
		if(m2){
			if(m2.parentNode.childNodes.length != 1){
				m2.parentNode.removeChild(m2);
			}else{
				var c = m2;
				var p = c.parentNode;
				while(true){
					if(p.childNodes.length == 1){
						c = p;
						p = p.parentNode;
					}else{
						break;
					}
				}
				c.parentNode.removeChild(c);	
			}
		}	
	},
	isParentOf: function(target, parent){
		var loop = target.parentNode;
		var res = false;
		while(loop){
			if(loop === parent){
				res = true;
				break;
			}
			loop = loop.parentNode;
		}
		return res;
	},
	/* find current block */
	applyAttributesGroupByParagraph: function(attributes) {	// Align
		var _self = this;
		this.exec( 
			function(landmark){
				var coll =  _self.groupInlineElementsWith("div", landmark.startElement, landmark.endElement);
				coll.each(function(node){
					$tom.applyAttributes(node, attributes);
				});
				try {
					_self.selectNodes(coll);
				}catch (e) { 
					console.log(e); 
				}
			}, 
			true
		);
	},
/*** wrap **/
	wrapInBlock:  function(element, attributes) {
		this.wrapWith(element, attributes, false);
	},
	wrapWith: function(element, attributes, collapse) {
		var _collapse = collapse ? collapse : false;
		var _range= this.getRange();
		
		var _el;
		if ($tx.msie) {
			try{
				_el = this.win[element](attributes);
				_el.setAttribute("id", "tmp_wrapped_item");
				_el.innerHTML = _range.htmlText != "" ? _range.htmlText + "<br />" : "<br />";
				
				_range.pasteHTML(_el.outerHTML);
				_range.select();
				if (_collapse) {
					_range.collapse(false);
				}
				_el = this.doc.getElementById("tmp_wrapped_item");
				_el.removeAttribute("id");
			}finally{
				var tmpAttr = this.doc.getElementById("tmp_wrapped_item");
				if(tmpAttr){
					tmpAttr.removeAttribute("id");
				} 	
			}
			
		} else {
			var _selectedElements = _range.extractContents();
			if(_selectedElements.childNodes.length == 0 || _selectedElements.childNodes[0].nodeValue ==''){
				_selectedElements = this.win.br();
			}
			_el = this.win[element](attributes, _selectedElements);
			_range.insertNode(_el);
			_range.selectNode(_el);
			if (_collapse) {
				_range.collapse(false);
			}
		}
		this.moveCaretTo(_el);
		return true;
	},
	wrapInList:  function(element, attributes) {
		var _root = this.win[element](attributes ? attributes : {});
		this.wrapEachLineWith(_root, "li", {});
	},
	wrapEachLineWith: function(parent, child, attributes) {
		var _range = this.getRange();
		var _self = this;
		var _el;
		if ($tx.msie) {
			try{
				_el = _self.win[child](attributes);
				_el.setAttribute("id", "tmp_wrapped_item");
				_el.innerHTML = _range.htmlText;
				parent.appendChild(_el);
				_range.pasteHTML(parent.outerHTML);
				_range.select();
				_range.collapse(false);
				_el = this.doc.getElementById("tmp_wrapped_item");
				_el.removeAttribute("id");
			}finally{
				var tmpAttr = this.doc.getElementById("tmp_wrapped_item");
				if(tmpAttr){
					tmpAttr.removeAttribute("id");
				} 	
			}
		} else {
			var _selectedElements = _range.extractContents();
			if(_selectedElements.childNodes.length == 0 || _selectedElements.childNodes[0].nodeValue ==''){
				_selectedElements = this.win.br();
			}
			_el = this.win[child](attributes, _selectedElements);
			parent.appendChild(_el);
			
			_range.insertNode(parent);
			_range.selectNode(parent);
			_range.collapse(false);
		}
		this.moveCaretTo(_el);
	},
	pasteContent:  function(textContent, newLine){
		this.paste(textContent);
		if (newLine) {
			this.paste("<br />");
		}
	},
	pasteNode:  function(nodeContent, newLine){
		var _dummy = this.win.div();
		_dummy.appendChild(nodeContent);
		this.paste(_dummy.innerHTML);
		if (newLine) {
			this.paste("<br />");
		}
		_dummy = null;
	},
	paste: function(textContent){
		var _range= this.getRange();
		if ($tx.msie) {
			var _text = textContent ? textContent : "<br />"; 
			_range.pasteHTML(_text);
			_range.select();
			_range.collapse(false);
		} else {
			var _dummy = this.win.div();
			_dummy.innerHTML = textContent;
			_range.extractContents();
			
			var hook = null;
			for(var l = 0, i = _dummy.childNodes.length - 1; i >= l; i--){
				var e = _dummy.childNodes[i];
				if(e){
					if(!hook){
						hook = e;
					}
					_range.insertNode(e);
				}
			}
			_range.selectNode(hook);
			_range.collapse(false);
			_dummy = null;
			hook = null;
		}
		var el = this.doc.getElementById("new_object");
		return el;
	},
	selectNodes: function(nodes){
		if (nodes.length == 0) {
			return;
		} else if (nodes.length == 1) {
			var _node = nodes[0];
			if (this.hasControl()) {
				var _clpsNode = this.win.span("\ufeff");
				$tom.insertAt(_clpsNode, _node);
				var _clpsRng = this.doc.body.createTextRange();
				_clpsRng.moveToElementText(_clpsNode);
				_clpsRng.collapse(true);
				$tom.remove(_clpsNode);
				_clpsRng.select();
			}
			var _rng = this.getRange();
			_rng.setEndPoint("EndToEnd", this.getPointedEndRange(_node, "<node>text^</node>"));
			try {
				_rng.setEndPoint("StartToStart", this.getPointedStartRange(_node, "<node>^text</node>"));
			} catch (e) {
				_rng.setEndPoint("StartToStart", this.getPointedStartRange(_node, "^<node>text</node>"));
			}
			_rng.select();
		} else {
			//CHECK
			var _rng = this.getRange();
			_rng.setEndPoint("EndToEnd", this.getPointedEndRange(nodes[nodes.length - 1], "<node>text^</node>"));
			_rng.setEndPoint("StartToStart", this.getPointedStartRange(nodes[0], "<node>^text</node>"));
			_rng.select();
		}
	},
	getPointedStartRange: function(node, type){
		var _rng = this.getRange();
		var _pntNode = this.win.span("\ufeff");
		if (type == "<node>^text</node>") {
			$tom.insertAt(_pntNode, node.firstChild);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(false);
			if (_rng.compareEndPoints('EndToStart', _pntRng) == -1) {
				_rng.setEndPoint('EndToStart', _pntRng);
			}
			_rng.setEndPoint('StartToStart', _pntRng);
		} else if (type == "<node>text^</node>") {
			$tom.append(node, _pntNode);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(true);
			if (_rng.compareEndPoints('EndToEnd', _pntRng) == -1) {
				_rng.setEndPoint('EndToEnd', _pntRng);
			}
			_rng.setEndPoint('StartToEnd', _pntRng);
		} else if (type == "^<node>text</node>") {
			$tom.insertAt(_pntNode, node);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(true);
			if (_rng.compareEndPoints('EndToStart', _pntRng) == -1) {
				_rng.setEndPoint('EndToStart', _pntRng);
			}
			_rng.setEndPoint('StartToStart', _pntRng);
		} else if (type == "^<node>text</node>") {
			$tom.insertNext(_pntNode, node);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(false);
			if (_rng.compareEndPoints('EndToEnd', _pntRng) == -1) {
				_rng.setEndPoint('EndToEnd', _pntRng);
			}
			_rng.setEndPoint('StartToEnd', _pntRng);
		}
		$tom.remove(_pntNode);
		return _rng;
	},
	getPointedEndRange: function(node, type){
		var _rng = this.getRange();
		var _pntNode = this.win.span("\ufeff");
		if (type == "<node>^text</node>") {
			$tom.insertAt(_pntNode, node.firstChild);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(true);
			if (_rng.compareEndPoints('StartToEnd', _pntRng) == 1) {
				_rng.setEndPoint('StartToEnd', _pntRng);
			}
			_rng.setEndPoint('EndToEnd', _pntRng);
		} else if (type == "<node>text^</node>") {
			$tom.append(node, _pntNode);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(false);
			if (_rng.compareEndPoints('StartToEnd', _pntRng) == 1) {
				_rng.setEndPoint('StartToEnd', _pntRng);
			}
			_rng.setEndPoint('EndToEnd', _pntRng);
		} else if (type == "^<node>text</node>") {
			$tom.insertAt(_pntNode, node);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(false);
			if (_rng.compareEndPoints('StartToEnd', _pntRng) == 1) {
				_rng.setEndPoint('StartToEnd', _pntRng);
			}
			_rng.setEndPoint('EndToEnd', _pntRng);
		} else if (type == "^<node>text</node>") {
			$tom.insertNext(_pntNode, node);
			
			var _pntRng = this.doc.body.createTextRange();
			_pntRng.moveToElementText(_pntNode);
			_pntRng.collapse(true);
			if (_rng.compareEndPoints('StartToEnd', _pntRng) == 1) {
				_rng.setEndPoint('StartToEnd', _pntRng);
			}
			_rng.setEndPoint('EndToEnd', _pntRng);
		}
		$tom.remove(_pntNode);
		return _rng;
	},
/** wrap end */
	getTxRange: function(_rng){
		var _sel = this.getSel();
		var _rng = this.getRange();
		 
		var _collapsed =  _rng.collapsed;
		var _beforeStart =  this.win.span({ id: "tx_beforestart_mark"});
		var _afterEnd =  this.win.span({ id: "tx_afterend_mark"});
		
		var _startContainer = _rng.startContainer; 
		var _startOffset = _rng.startOffset; 
		var _endContainer = _rng.endContainer; 
		var _endOffset = _rng.endOffset;
		
		if(_endContainer.nodeType == 3) {
			_endContainer.splitText(_endOffset); 
			_endContainer.parentNode.insertBefore(_afterEnd, _endContainer.nextSibling);
		} else {
			_endContainer.insertBefore(_afterEnd, _endContainer.childNodes[_endOffset]);
		}

		if(_startContainer.nodeType == 3) {
			_startContainer.splitText(_startOffset); 
			_startContainer.parentNode.insertBefore(_beforeStart, _startContainer.nextSibling);
		} else {
			_startContainer.insertBefore(_beforeStart, _startContainer.childNodes[_startOffset]);
		}
		
		return {
			"beforeStart": _beforeStart,
			"afterEnd": _afterEnd,
			"rng": _rng,
			"collapsed": _collapsed 
		};
	}
};
	