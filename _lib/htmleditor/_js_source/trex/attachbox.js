
TrexConfig.addSidebar('attachbox', {
	show: true,
	destroy: false
});

/**
 * Trex.AttachBox
 * Trex.Attachment instance들이 저장되는 class  
 * @class
 * @extends Trex.EntryBox
 */
Trex.AttachBox = Trex.Class.create({
	/** @ignore */
	$extend: Trex.EntryBox,
	isChecked: false,
	initialize: function(config, editor) {

	},
	checkAvailableCapacity: function() { //Before Popup
		return true;
	},
	getAvailableCapacity: function() { //Within Flash
		return true;
	},
	checkInsertableSize: function(attachSize) { //Before Attach
		return true;
	}
});

Trex.install("editor.getAttachBox & sidebar.getAttachments",
	function(editor, toolbar, sidebar, canvas, config){
		var _attachBox = new Trex.AttachBox(config, editor);
		sidebar.entryboxRegistry['attachbox'] = _attachBox;
		editor.getAttachBox = function() {
			return _attachBox;
		};
		sidebar.getAttachments = _attachBox.getEntries.bind(_attachBox);
	}
);

Trex.register("filter > attachers",
	function(editor, toolbar, sidebar, canvas, config) {
		var _attachBox = editor.getAttachBox();		
		var _docparser = editor.getDocParser();		
		_docparser.registerFilter(
			'filter/attachments', {
				'text@load': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regLoad, "");
					});
					return contents;
				},
				'source@load': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regLoad, entry.dispText);
					});
					return contents;
				},
				'html@load': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regLoad, entry.dispHtml);
					});
					return contents;
				},
				'text4save': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regText, "");
					});
					return contents;
				},
				'source4save': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regText, entry.saveHtml, ["id", "class"]);
					});
					return contents;
				},
				'html4save': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regHtml, entry.saveHtml, ["id", "class"]);
					});
					return contents;
				},
				'text2source': function(contents){
					return contents;
				},
				'text2html': function(contents){
					return contents;
				},
				'source2text': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regText, "");
					});
					return contents;
				},
				'source2html': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regText, entry.dispHtml);
					});
					return contents;
				},
				'html2text': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regHtml, "");
					});
					return contents;
				},
				'html2source': function(contents){
					var entries = _attachBox.datalist;					
					entries.each(function(entry) {
						contents = entry.getChangedContent(contents, entry.regHtml, entry.dispText, ["id", "class"]);
					});
					return contents;
				}
			}
		);
	}
);
		
Trex.module("push history @when entrybox has changes",
	function(editor, toolbar, sidebar, canvas, config) {		
		var _attachBox = editor.getAttachBox();		
		// history를 남기자.
		_attachBox.observeJob( "entrybox.entryremoved", function(entry) {
			canvas.history.saveHistory({
					'deleted': true,
					'content': canvas.getContent(),
					'scrollTop': canvas.getScrollTop()
				}, 
				function(data){
					entry.deletedMark = (data.deleted == true || data.deleted == undefined)?true:false;
					_attachBox.fireJobs(Trex.Ev.__ENTRYBOX_ENTRY_REFRESH, entry);
					canvas.setContent( data.content );	
				}
			);
		});
		
		_attachBox.observeJob(Trex.Ev.__ENTRYBOX_ENTRY_ADDED, function(entry){
			canvas.history.injectHistory({ 
					'deleted': false 
				}, 
				function(data){
					entry.deletedMark = (data.deleted === false)?false:true;
					_attachBox.fireJobs(Trex.Ev.__ENTRYBOX_ENTRY_REFRESH, entry);
				}
			);
		});
	}
);

