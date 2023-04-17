Trex.module("new Trex.Resizer",
	function(editor, toolbar, sidebar, canvas, config){
		var _initializedId = config.initializedId || ""; 
		var cfg = TrexConfig.get("resizer", config);
		if (Trex.available(cfg, "resizer" + _initializedId)) {
			new Trex.Resizer(editor, cfg);
		}
	}
);
TrexConfig.add({
	'resizer': {
		minHeight: 200
	}
});
Trex.Resizer = Trex.Class.create({
	$const: {
		__Identity: 'resizer'
	},
	$mixins: [
		Trex.I.JobObservable
	],
	initialize: function(editor, config) {
		var _presentHeight = 0;
		if(!editor) {
			return;
		}

		var _initializedId = editor.getInitializedId();
		var _elBar = this.elBar = $must("tx_resizer" + _initializedId, "Trex.Worker.Resizer");
		if(!_elBar) {
			return;
		}
		if($tx.msie_ver == '5.5'){
			_elBar.setAttribute('align', 'center');
		}
		
		this.resizeHeightAtService = function( height ) { //NOTE: service specific job for resize(callback)
			if(typeof(resizeHeight) != 'undefined') {
				resizeHeight( height );
			}
		};
		var _minDragHeight = config.minHeight;
		var _wysiwygDoc;
		this.startDrag = function(ev) {
			var _canvas = editor.getCanvas();
			var _panel = _canvas.getCurrentPanel();
			if(_panel == null) {
				return;
			}

			var _position = _panel.getPosition();
			this.panelHeight = _position.height;
			this.dragStartPosY = ev.clientY;
			this.isDragging = true;
			$tx.observe(document, 'mousemove', this.documentDraggingHandler);
			$tx.observe(document, 'mouseup', this.stopDragHandler);
			if(_panel.getName() == Trex.Canvas.__WYSIWYG_MODE) {
				this.panelTop = _position.y;
				_wysiwygDoc = _panel.getDocument();
				if(_wysiwygDoc == null) {
					return;
				}
				_canvas.fireJobs('canvas.height.beforechange');
				$tx.observe(_wysiwygDoc, 'mousemove', this.wysiwygDraggingHandler);
				$tx.observe(_wysiwygDoc, 'mouseup', this.stopDragHandler);
			}
			$tx.stop(ev);
		};

		this.stopDrag = function(ev){
			var _canvas = editor.getCanvas();
			var _panel = _canvas.getCurrentPanel();
			if(_panel == null) {
				return;
			}
			this.isDragging = false;

			$tx.stopObserving(document, 'mousemove', this.documentDraggingHandler);
			$tx.stopObserving(document, 'mouseup', this.stopDragHandler);
			if(_wysiwygDoc == null) {
				return;
			}
			$tx.stopObserving(_wysiwygDoc, 'mousemove', this.wysiwygDraggingHandler);
			$tx.stopObserving(_wysiwygDoc, 'mouseup', this.stopDragHandler);
			_wysiwygDoc = null;
			
			this.resizeHeightAtService(_presentHeight);
			_canvas.fireJobs('canvas.height.afterchange');
			$tx.stop(ev);
		};

		this.dragingAtDocument = function(ev) {
			var _canvas = editor.getCanvas();
			if (this.isDragging) {
				var _panel = _canvas.getCurrentPanel();
				if(_panel == null) {
					return;
				}
				try {
					var _height = Math.max((this.panelHeight + ev.clientY - this.dragStartPosY), _minDragHeight).toPx();
					_panel.setPanelHeight(_height);
					_presentHeight = _height;
					_canvas.fireJobs('canvas.height.change', _height);
				} catch(e) {
					console.log(e);
				}
			}
			$tx.stop(ev);
		};

		this.dragingAtWysiwyg = function(ev) {
			var _canvas = editor.getCanvas();
			if (this.isDragging) {
				var _panel = _canvas.getCurrentPanel();
				if(_panel == null) {
					return;
				}
				try {
					var _scrollTop = document.body.scrollTop || document.documentElement.scrollTop || window.pageYOffset;
					var _height = Math.max((this.panelHeight + ev.clientY - this.dragStartPosY + this.panelTop - _scrollTop), _minDragHeight).toPx();
					_panel.setPanelHeight(_height);
					_canvas.fireJobs('canvas.height.change', _height);
				} catch(e) {
					console.log(e);
				}
			}
			$tx.stop(ev);
		};

		this.startDragHandler = this.startDrag.bindAsEventListener(this);
		this.stopDragHandler = this.stopDrag.bindAsEventListener(this);
		this.documentDraggingHandler = this.dragingAtDocument.bindAsEventListener(this);
		this.wysiwygDraggingHandler = this.dragingAtWysiwyg.bindAsEventListener(this);
		this.isDragging = false;

		$tx.observe(_elBar, 'mousedown', this.startDragHandler);

		var _canvas = editor.getCanvas();
		_canvas.observeJob('canvas.fullscreen.change', function() {
			$tx.hide(_elBar);
		});

		_canvas.observeJob('canvas.normalscreen.change', function() {
			$tx.show(_elBar);
		});

	}
});