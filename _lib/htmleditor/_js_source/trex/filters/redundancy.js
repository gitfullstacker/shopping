
Trex.register("filter > clear redundancy",
	function(editor, toolbar, sidebar, canvas, config) {
		
		function clearRedundancy(contents) {
			var _clearHanler = function(content, style, loop) {
				var _matchNum = 0;
				var _matchHanler = function(all, value, text){
					_matchNum++;
					if(text.length == 0 || text.trim().length == 0) {
						return "";
					} else {
						return ['<span style="', style, ':', value, ';">', text, '</span>'].join("");
					}
				};
				var _reg = new RegExp("(?:<span[^>]*" + style + ":[^>]*>){" + loop + "}<span\\s*style=['\"]?" + style + ":\\s*(\\w+)[;'\"]*>([\\S\\s]*?)<\/span>(?:<\/span>){" + loop + "}", "gi");
				do {
					_matchNum = 0;
					content = content.replace(_reg, _matchHanler);
				} while(_matchNum > 0);
			
				return content;
			};
			var _styles = ['font-size', 'font-family'];
			for(var i=0; i<_styles.length; i++) {
				contents = _clearHanler(contents, _styles[i], 8);
				contents = _clearHanler(contents, _styles[i], 4);
				contents = _clearHanler(contents, _styles[i], 1);
			}
			contents = contents.replace(/<span[^>]*><\/span>/gi, "");
			contents = contents.replace(/<font[^>]*><\/font>/gi, "");
			return contents;
		}
		
		var _docparser = editor.getDocParser();	
		_docparser.registerFilter(
			'filter/redundancy', {
				'text@load': function(contents){
					return contents;
				},
				'source@load': function(contents){
					return clearRedundancy(contents);
				},
				'html@load': function(contents){
					return clearRedundancy(contents);
				},
				'text4save': function(contents){
					return contents;
				},
				'source4save': function(contents){
					return contents;
				},
				'html4save': function(contents){
					return contents;
				},
				'text2source': function(contents){
					return contents;
				},
				'text2html': function(contents){
					return contents;
				},
				'source2text': function(contents){
					return contents;
				},
				'source2html': function(contents){ //source2wysiwyg
					return contents;
				},
				'html2text': function(contents){
					return contents;
				},
				'html2source': function(contents){ //wysiwyg2source
					return clearRedundancy(contents);
				}
			}
		);
	}
);
