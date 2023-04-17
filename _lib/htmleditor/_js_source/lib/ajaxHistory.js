var AjaxHistory = {
	elPageFrame: null,
	pageUrlWithParam: null,
	initialHash: null,
	currentHash: null,
	historyMoveHandler: null,
	initialize: function(page, hash) {
		this.pageUrlWithParam = page;
		if(!hash && hash.length === 0) {
			hash = window.location.hash;
		}
		this.currentHash = this.initialHash = hash;
		var _elPageFrame = this.elPageFrame = tx.iframe({ id: "ke_history_frame", name: "ke_history_frame", className: "ke-history-frame", frameborder: "0" });
		_elPageFrame.src = this.mixUrlByHash(hash);
		document.body.appendChild(_elPageFrame);
	},
	addListener: function(historyMoveHandler) {
		this.historyMoveHandler = historyMoveHandler;
	},
	addHistory: function(hash) {
		if (this.currentHash == hash) { //user click action
			//No Action
		} else { //history navigate action
			this.currentHash = hash;
			this.elPageFrame.src = this.mixUrlByHash(hash);
		}
	},
	changeHashAtLoad: function(hash) {
		if(!hash && hash.length === 0) {
			hash = this.initialHash;
		}
		try {
			hash = decodeURIComponent(hash);
		} catch(e) {}
		if(this.currentHash == hash) { //user click action
			//No Action
		} else { //history navigate action
			this.currentHash = hash;
			if(this.historyMoveHandler) {
				this.historyMoveHandler(hash);
			}
		}
	},
	mixUrlByHash: function(hash) {
		var _page = this.pageUrlWithParam;
		return _page + ((_page.indexOf("?") < 0)? "?": "&") + "dummy=" + this.getDummy(hash) + hash;
	},
	getDummy: function(hash) {
		return Math.floor(Math.random() * 1000000);
	}
};

