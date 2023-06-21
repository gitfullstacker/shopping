Trex.module("add drop-down menu button if extra buttons exist.", 
	function (editor, toolbar, sidebar, canvas, config) {
		var _seq = 0;
		var addExtraButtonEvent = function(elButton) {
			var elMenu = $tom.next(elButton, '.tx-extra-menu');
			if (!elMenu) {
				return;
			}
			
			var _dummyToolClass = new (function() {
				this.identity = 'extra' + (++_seq);
				this.wysiwygonly = true;
				this.canvas = canvas;
				this.toolbar = toolbar;
			})();
			
			Trex.Tool.prototype.weave.bind(_dummyToolClass)(
				new Trex.Button({
					el: elButton,
					sync: false,
					status: true
				}), 
				new Trex.Menu({
					el: elMenu
				}), 
				function() { //dummy handler
				}
			);
			
			toolbar.tools[_dummyToolClass.identity] = _dummyToolClass;
		};
		
		canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {
			var _elButtonList = $tom.collectAll(editor.getWrapper(), 'li.tx-list-extra div.tx-extra');
			if (_elButtonList.length == 0) {
				return;
			}
			_elButtonList.each(addExtraButtonEvent);
		});
	}
);

