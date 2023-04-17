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
	"lib/dfindy.js",
	"lib/xgetty.js",
	"lib/dateformat.js",
	"lib/swfobject.js",
	/** trex engine & config */
	"trex/trex.js",
	"trex/event.js",
	"trex/config.js",
	"trex/message.js",
	/** trex library */
	"trex/lib/markup.js",
	"trex/lib/domutil.js",
	"trex/lib/utils.js",
	"trex/lib/imageresizer.js",
	"trex/lib/flash.js",
	/** trex mixins */
	"trex/mixins/ajax.js",
	"trex/mixins/observable.js",
	"trex/mixins/colorpallete.js",
	"trex/mixins/cookiebaker.js",
	"trex/mixins/alignexecution.js",
	"trex/mixins/listexecution.js",
	"trex/mixins/indentexecution.js",
	/** trex common */
	"trex/common/button.js",
	"trex/common/menu.js",
	"trex/common/blackbox.js",
	"trex/common/noticebox.js",
	
	/** editor core */
	"trex/editor.js",
	"trex/toolbar.js",
	"trex/sidebar.js",
	"trex/docparser.js",
	"trex/entryproxy.js",
	"trex/formproxy.js",
	"trex/saver.js",
	"trex/resizer.js",
	
	/** canvas & panels */
	"trex/history.js",
	"trex/canvas.js",
	"trex/panels/panel.js",
	"trex/panels/wysiwygpanel.js",
	"trex/panels/textpanel.js",
		
	/** processor */
	"trex/processor/marker.js",
	"trex/processor/selection.js",
	"trex/processor/bookmark.js",
	"trex/processor/processor_textarea.js",
		"trex/processor/processor_standard.js",
		"trex/processor/processor_trident.js",
		"trex/processor/processor_gecko.js",
		"trex/processor/processor_webkit.js",
		"trex/processor/processor_presto.js",
			/* Processor For P */
			"trex/processor/p/processor_standard_p.js",
			"trex/processor/p/processor_trident_p.js",
			"trex/processor/p/processor_gecko_p.js",
			"trex/processor/p/processor_webkit_p.js",
			"trex/processor/p/processor_presto_p.js",
			/* Processor For Br */
			"trex/processor/br/processor_standard_br.js",
			"trex/processor/br/processor_trident_br.js",
			"trex/processor/br/processor_gecko_br.js",
			"trex/processor/br/processor_webkit_br.js",
			"trex/processor/br/processor_presto_br.js",
	"trex/processor/processor.js",
	
	/** each > filter */
	"trex/filters/converting.js",
	"trex/filters/redundancy.js",
	
	/** attacher */
	"trex/attachment.js",
	"trex/attachbox.js",
	"trex/attachbox/attachbox_ui.js",
	"trex/attachbox/iadaptor.js",
	"trex/attacher.js",
	
	/** embeder */
	"trex/embeder.js",
	"trex/embedentry.js",
	
	/** each > tool */
	"trex/tool/switcher.js", 
	"trex/tool/switchertoggle.js", 
	"trex/tool/fontfamily.js", 
	"trex/tool/fontsize.js", 
	"trex/tool/bold.js", 
	"trex/tool/underline.js", 
	"trex/tool/italic.js",
	"trex/tool/strike.js",
	"trex/tool/forecolor.js",
	"trex/tool/backcolor.js",
	"trex/tool/alignleft.js",
	"trex/tool/aligncenter.js",
	"trex/tool/alignright.js",
	"trex/tool/alignfull.js",
	"trex/tool/lineheight.js",
	"trex/tool/styledlist.js",
	"trex/tool/ordered.js",
	"trex/tool/unordered.js",
	"trex/tool/indent.js",
	"trex/tool/outdent.js",
	"trex/tool/insertlink.js",
	"trex/tool/textbox.js",
	"trex/tool/quote.js",
	"trex/tool/table.js",
	"trex/tool/emoticon.js",
	"trex/tool/redo.js",
	"trex/tool/undo.js",
	"trex/tool/horizontalrule.js",
	"trex/tool/specialchar.js",
	"trex/tool/dictionary.js",
	"trex/tool/background.js",
	"trex/tool/advanced.js",
	"trex/tool/extraButtonDropdown.js",
	"trex/tool/fullscreen.js",
	
	/** each > attacher */
	"trex/attacher/image.js",
	"trex/attacher/file.js",
	
	/** each > embeder */
	"trex/embeder/media.js",
	
	/** each > module */
	"trex/modules/blockingunload.js",
	"trex/modules/alignbuttons.js",
	"trex/modules/canvassize.js",
	"trex/modules/blockingedit.js",
	"trex/modules/saveimagehistory.js",
	"trex/modules/tableedit.js",
	"trex/modules/tablebuttons.js",
	"trex/modules/noticepanel.js",//
	
	/** each > plugin */
	
	"listset/tabletemplate.js",
	
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
