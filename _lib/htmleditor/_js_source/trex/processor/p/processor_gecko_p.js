
Trex.I.Processor.GeckoP = {
	restoreScrollTop: function(node) {
		if(!node) {
			return;
		}
		if(this.win.innerHeight < this.doc.documentElement.offsetHeight){
			var _oldTop = document.documentElement.scrollTop;				
			$tom.goInto(node, false);
			document.documentElement.scrollTop = _oldTop;					
		}
	}
};
