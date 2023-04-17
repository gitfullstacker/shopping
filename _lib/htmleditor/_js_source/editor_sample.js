var PROJECTLIBS = [
	"sample/config.js",
	"sample/message.js",
	
	/** NOTE: Attacher Start */
	/** NOTE: Attacher End */
	
	/** NOTE: Tool Start */
	/** NOTE: Tool End */
	
	/** NOTE: Plugin Start */
	/** NOTE: Plugin End */

	'' /*dummy*/
];

(function() {
	var _importScript = function(filename) { 
		if (filename) {
			document.write('<script type="text/javascript" src="_js_source/' + filename + "?ver=" + new Date().getTime().toString() + '" charset="utf-8"></s' + 'cript>');
		}
	};

	for(var i=0; i<PROJECTLIBS.length; i++) {
		_importScript(PROJECTLIBS[i]);
	}
})();
