
TrexMessage.addMsg({
	'@file.error.file.count.alert': "업로드 파일갯수가 초과되었습니다.",
	'@file.error.file.size.alert': "업로드 용량이 초과되었습니다."
});
		
/**
 * Trex.FileUploaderAdaptor - Adaptor Interface
 */
Trex.FileUploaderAdaptor = {  //NOTE: cuz multi editor
	checkEditor: function(ctx){
		var idx = ctx.substr(4, ctx.length);
		if(Editor.getInitializedId() != idx) {
			Editor.prototype.switchEditor(idx);
		}
	},
	/**
	 * Callback function called when upload session is started
	 */
	on_upload_start: function(ctx){
		this.checkEditor(ctx);
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.startUpload) {
			_attachbox.startUpload();
		}
	},
	/**
	 * Callback function on progress
	 * @param {Object} percent 
	 */
	on_upload_progress: function(percent, ctx){
		this.checkEditor(ctx);
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.doUpload) {
			_attachbox.doUpload(percent);
		}
	},
	/**
	 * Callback function called when each file is uploaded complete into temp directory.
	 * @param {String} result - string data delimetered by '||'
	 * 	 ex} filename||attachurl||infourl||filesize||filemime\n||url(key)
	 */
	on_upload_complete: function(result, ctx){ // X
		this.checkEditor(ctx);
		var _adaptor = Editor.getSidebar().getUploadAdaptor(); 
		if (_adaptor && _adaptor.attach) {
			_adaptor.attach(arguments[0]);
		}
	},
	/**
	 * Callback function called when upload session is finished
	 */
	on_upload_finish: function(ctx){
		this.checkEditor(ctx);
		
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.endUpload) {
			_attachbox.endUpload();
		}
		Editor.getSidebar().addOnlyBox = null;		
	},
	/**
	 * Callback function called if size of each file is bigger than permission  
	 * @param {Object} filename - filename delimetered by '||'
	 */
	on_over_filesize: function(filename, ctx){
		alert(TXMSG('@file.error.file.size.alert'));
		this.checkEditor(ctx);
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.endUpload) {
			_attachbox.endUpload();
		}
	},
	/**
	 * Callback function called if files are selected more than max count.  
	 * @param {Object} count - selected file count
	 * @param {Object} maxcount - max count
	 */
	on_over_filecount: function(maxcount, ctx){
		alert(TXMSG('@file.error.file.count.alert'));
		this.checkEditor(ctx);
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.endUpload) {
			_attachbox.endUpload();
		}
	},
	/**
	 * Callback function called on error
	 */
	on_error: function(msg, ctx){ //NOTE: not implement
		this.checkEditor(ctx);
		Editor.getSidebar().addOnlyBox = null;
	},
	on_browse_cancel: function(ctx){ //NOTE: not implement
		this.checkEditor(ctx);
		Editor.getSidebar().addOnlyBox = null;
	},
	on_upload_open: function(name, size, type){ //NOTE: not implement
	},
	/**
	 * Callback function called when each file is transfered to permanent directory from temp directory.
	 * Usually, this is called after 'on_upload_complete' call
	 */
	on_activate_complete: function(result){ //NOTE: not implement
	},
	/**
	 * Callback function called when activating is finished
	 * @param {string} result - succecss code
	 */
	on_activate_finish: function(){ //NOTE: not implement
	},
	/**
	 * size : allow unlimited if -1
	 * @param {Object} cur_size
	 * @param {Object} max_size
	 */
	on_over_filequota: function(quota, ctx){ //NOTE: not implement
		alert(TXMSG('@file.error.file.size.alert'));
		this.checkEditor(ctx);
		var _attachbox = Editor.getAttachBox();
		if (_attachbox && _attachbox.endUpload) {
			_attachbox.endUpload();
		}
	},
	on_upload_skip: function(filename, localfile_size, localfile_type){
		
	}
};
