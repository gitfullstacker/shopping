/**
 * Trex.EmbedEntry
 * 삽입된 embed들을 wrapping하는 class 
 * @class
 * @extends Trex.Entry
 * 
 * @param {Object} actor
 * @param {Object} data 
 * 
 * 1.5 되면서 IE에서는 변환하지 않음
*/
Trex.EmbedEntry = Trex.Class.create({
	$extend: Trex.Entry,
	attrs: {
		align: "left"
	},
	initialize: function(actor, data) {
		var _entry = this;
		
		var _actor = this.actor = actor;
		var _canvas = this.canvas = _actor.canvas; 
		var _entryBox = this.entryBox = _actor.entryBox; 

		this.setProperties(data);
	},
	register:  function() { 
		if(this.canvas.canHTML()) {
			var _style = this.actor.config.defaultstyle;
			if(_style){
				this.canvas.pasteContent(this.dispHtml, true, {
						'style': _style 
					});
			}else{
				this.canvas.pasteContent(this.dispHtml, true);	
			}
		} else {
			this.canvas.getProcessor().insertTag('', this.dispText);						
		}	
	},
	setProperties: function(data) {
		this.type = this.constructor.__Identity;
		
		var _data = this.data = data;
		var _key = this.key = _data.key;

		this.dispHtml = this.getDispHtml(_data);
		this.saveHtml = this.dispText = this.getDispText(_data); //NOTE: Cuz dispText = saveHtml
		this.regHtml = this.getRegHtml(_data);
		this.regLoad = this.regText = this.getRegText(_data); //NOTE: Cuz dispText = saveHtml
	}
});

