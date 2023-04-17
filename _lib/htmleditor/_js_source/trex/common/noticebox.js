Trex.MarkupTemplate.add('noticebox', 
'<div class="tx-noticebox">\
	<dl>\
		<dt>\
			<span>#{head}</span>\
			<a href="javascript:;">close</a>\
		</dt>\
		<dd>\
			<p>#{body}</p>\
			<div>\
				<a href="javascript:;"><img src="#{confirm}" border="0"/></a>\
				<a href="javascript:;"><img src="#{cancel}" border="0" /></a>\
			</div>\
		</dd>\
	</dl>\
</div>'
);

Trex.NoticeBox = Trex.Class.create({
	initialize: function(options, blackbox) {
		this.make({
			'head': options.head,
			'body': options.body,
			'confirm': options.confirm || 'http://icon.daum-img.net/editor/btn_confirm_s1.gif?rv=1.0.1',
			'cancel': options.cancel || 'http://icon.daum-img.net/editor/btn_cancel_s1.gif?rv=1.0.1'
		});
		this.blackbox = blackbox;
	},
	make: function(options) {
		if(this.elBox) {
			return this;
		}
		options = options || {};
		var _elBox = this.elBox = Trex.MarkupTemplate.get("noticebox").evaluateAsDom(options);
		$tx.observe($tom.collect(_elBox, "dt a"), "click", this.cancel.bind(this));
		
		$tx.observe($tom.collectAll(_elBox, "dd div a")[0], "click", this.confirm.bind(this));
		$tx.observe($tom.collectAll(_elBox, "dd div a")[1], "click", this.cancel.bind(this));
		return this;
	},
	weave: function(confirmHandler, cancelHandler, completeHandler) {
		this.confirmHandler = confirmHandler;
		this.cancelHandler = cancelHandler;
		this.completeHandler = completeHandler;
		return this;
	},
	show: function() {
		this.blackbox.show(this.elBox);
	},
	hide: function(ev) {
		this.blackbox.hide();
		return false;
	},
	confirm: function(ev) {
		if(this.confirmHandler) {
			this.confirmHandler();
		}
		return false;
	},
	cancel: function(ev) {
		if(this.cancelHandler) {
			this.cancelHandler();
		}
		this.hide(ev);
		return false;
	},
	complete: function(ev) {
		if(this.completeHandler) {
			this.completeHandler();
		}
		this.hide(ev);
		return false;
	}
});

Trex.install("editor.newNoticeBox",
	function(editor, toolbar, sidebar, canvas, config) {
		editor.newNoticeBox = function(options) {
			return new Trex.NoticeBox(options, editor.getBlackBox());
		};
	}
);

