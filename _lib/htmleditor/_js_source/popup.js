var DEVELLIBS = [
	"global.js",
	/** debugging library */
	"lib/firebug/firebugx.js",
	"lib/stopwatch.js",
	/** common library */
	"lib/txlib.js",
	"lib/hyperscript.js",
	"lib/template.js",
	"lib/dgetty.js",
	"lib/xgetty.js",
	"lib/dateformat.js",
	"lib/rubber.js",
	"lib/swfobject.js",
	/** trex engine & config */
	"trex/trex.js",
	/** trex library */
	"trex/lib/markup.js",
	"trex/lib/domutil.js",
	"trex/lib/utils.js",
	"trex/lib/flash.js",
	/** trex mixins */
	"trex/mixins/ajax.js",
	"trex/mixins/observable.js",
	/** trex common */
	"trex/common/blackbox.js",
	"trex/common/noticebox.js",
	"common.js",
	'' /*dummy*/
];

(function() {
	var _importScript = function(filename) { 
		if (filename) {
			document.write('<script type="text/javascript" src="_js_source/' + filename + "?ver=" + new Date().getTime().toString() + '" charset="utf-8"></s' + 'cript>');
		}
	};
	for(var i=0; i<DEVELLIBS.length; i++) {
		_importScript(DEVELLIBS[i]);
	}
})();
