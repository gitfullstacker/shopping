
Trex.module("Remove Style ( Ctrl + Alt + X ) ",
	function(editor, toolbar, sidebar, canvas, config){
		var removeFormatting = function(str) {
			var styleTags = ["b", "strong", "i", "em", "u", "ins", "strike", "del", "font"];
			for(var i = 0;  i < styleTags.length; i++) {
				var regTag = new RegExp("</?" + styleTags[i] + "(?:>| [^>]*>)", "i");
				while (result = regTag.exec(str)) {
					str = str.replaceAll(result[0], "");
				}	
			}
			str = str.replace(new RegExp('\\s*style="[^"]*"', "gi"), "");
			var styleContainers = ["span", "div"];
			for(var i = 0;  i < styleContainers.length; i++) {
				var regTag = new RegExp("<span\\s*?>((?:.|\\s)*?)</span>", "i");
				while (result = regTag.exec(str)) {
					str = str.replace(result[0], result[1]);
				}	
			}
			return str;
		};
			
		canvas.observeKey({ 
				ctrlKey: true,
				altKey: true,
				shiftKey: false,
				keyCode: 88
			},
		 	function(){
				if (canvas.canHTML()) {
					var _rng = canvas.getProcessor().getRange();
					if ($tx.msie) {
						if (_rng.htmlText != "") {
							if (_rng.parentElement().outerHTML == _rng.htmlText) {
								_rng.parentElement().outerHTML = removeFormatting(_rng.htmlText);
							} else {
								_rng.pasteHTML(removeFormatting(_rng.htmlText));
							}
						}
					} else {
						if (_rng.startOffset != _rng.endOffset) {
							var dummyNode = document.createElement("div");
							dummyNode.appendChild(_rng.extractContents());
							_rng.insertNode(_rng.createContextualFragment(removeFormatting(dummyNode.innerHTML)));
						}
					}
				}
			}
		);
	}
);
