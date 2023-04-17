Trex.MarkupTemplate.add("blackbox",
	'<div class="tx-blackbox">\
		<div class="tx-blackbox-panel"></div>\
		<div class="tx-content"></div>\
	</div>'
);

Trex.BlackBox = Trex.Class.create({
	initialize: function() { },
	make: function(holder) {
		var _elBlackBox = this.elBlackbox = Trex.MarkupTemplate.get("blackbox").evaluateAsDom({});
		var _holder = this.holder = holder || document.body;
		$tom.insertFirst(_holder, _elBlackBox)
		
		this.elBlackboxPanel = $tom.collect( _elBlackBox, "div.tx-blackbox-panel");
		this.elContentArea = $tom.collect( _elBlackBox, "div.tx-content");
		
		var _panelSize = this.calculatePanelSize();
		this.panelWidth = _panelSize[0];
		this.panelHeight = _panelSize[1];
	},
	show: function(elContent) {
		if(this.elContentArea.firstChild != null){
			return false;
		}
		$tom.append(this.elContentArea, elContent);
		
		$tx.setStyle(this.elBlackbox, {
			'width': this.panelWidth.toPx(),
			'height': this.panelHeight.toPx()
		});
		$tx.setStyle(this.elBlackboxPanel, {
			'width': this.panelWidth.toPx(),
			'height': this.panelHeight.toPx()
		});
		
		$tx.show(this.elBlackbox);
		this.alignCenter();
		return false;
	},
	hide: function() {
		$tx.hide(this.elBlackbox);
		this.elContentArea.removeChild(this.elContentArea.firstChild);
	},
	calculatePanelSize: function() {
		var _panelSize = $tom.getPosition(this.holder);
		return [_panelSize.width, _panelSize.height];
	},
	resizeBlackbox: function(height) {
		this.panelHeight = height;
		$tx.setStyle(this.elBlackbox, {
			'height': this.panelHeight.toPx()
		});
		$tx.setStyle(this.elBlackboxPanel, {
			'height': this.panelHeight.toPx()
		});
		this.alignCenter();
	},
	alignCenter: function(){
		var width = $tx.getStyle(this.elBlackbox, "width" ); 
		var height = $tx.getStyle(this.elBlackbox, "height" );
		
		var _contentSize = $tom.getPosition(this.elContentArea.firstChild);
		var _contentWidth = _contentSize.width.parsePx();
		var _contentHeight = _contentSize.height.parsePx();
		
		var _marginLeft = (this.panelWidth - _contentWidth)/2;
		var _marginTop = ( this.panelHeight > _contentHeight)? (this.panelHeight - _contentHeight)/2: 0;
		$tx.setStyle( this.elContentArea, {
			'marginLeft': _marginLeft.toPx(),
			'marginTop': _marginTop.toPx()
		});
	}
});

Trex.install("editor.getBlackBox & canvas.getBlackBox",
	function(editor, toolbar, sidebar, canvas, config) {
		var _blackBox = new Trex.BlackBox();
		editor.getBlackBox = function() {
			return _blackBox;
		};
		canvas.getBlackBox = function(){
			return _blackBox;
		};
	}
);

Trex.module("generate blackbox", 
	function(editor, toolbar, sidebar, canvas, config) {
		var __CANVAS_OFFSET_HEIGHT = 92;
		var _blackBox = editor.getBlackBox();
		
		_blackBox.calculatePanelSize = function() { // overwrite
			var width = canvas.getSizeConfig().wrapWidth;
			var height = canvas.getCurrentPanel().getPanelHeight().parsePx() + __CANVAS_OFFSET_HEIGHT;
			return [width, height];
		};
		
		var _elContainer = editor.getWrapper();
		_blackBox.make(_elContainer);
		
		canvas.observeKey({ // Esc
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: 27
		}, _blackBox.hide.bind(_blackBox));
		
		editor.observeKey({ // Esc
			ctrlKey: false,
			altKey: false,
			shiftKey: false,
			keyCode: 27
		}, _blackBox.hide.bind(_blackBox));
		
		canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(height) {
			_blackBox.resizeBlackbox(height.parsePx() + __CANVAS_OFFSET_HEIGHT);
		});
	}
);
