/**
 * This is wrapper of swfobject 2.2
 */
Trex.Flash = {
	DEFAULT:{
		flashvar: {
			debug:"false"
		},
		paraObj:{
			allowScriptAccess: "always",
			quality: "low",
			menu: "false",
			scale: "noscale",
			salign: "tl",
			loop: "false"
		},
		attrObj:{
			bgcolor: "#FFFFFF"
		}
	},
	minFlashVer:"9.0.28",
	load: function(src, elId, flashId, options){
		/* options = {
		 * 		width: "500",
		 * 		height: "100",
		 * 		flashVarObj: { ... },
		 * 		paraObj: { ... },
		 * 		attrObj: { ... }
		 * }
		 */
		var _flashvarObj = $tx.extend({}, Trex.Flash.DEFAULT.flashvar );		
		var _paraObj = $tx.extend({}, Trex.Flash.DEFAULT.paraObj );		
		var _attrObj = $tx.extend({}, Trex.Flash.DEFAULT.attrObj );
		
		var _options = options?options:{};
		$tx.extend( _flashvarObj, _options.flashvarObj );	
		$tx.extend( _paraObj, _options.paraObj );	
		$tx.extend( _attrObj, _options.attrObj );
//		_attrObj.id = _attrObj.name = flashId;			// Setting name to flash brings external interface error!
		_attrObj.id = flashId;
		
		if(!$tx(elId)) {
			document.body.appendChild(tx.div({ 'id': elId }));
		}
		
		swfobject.embedSWF(
			src,
			elId,
			_options.width ? _options.width:"0",	
			_options.height ? _options.height:"0",	
			this.minFlashVer,
			false,
			_flashvarObj,
			_paraObj,
			_attrObj
		);
	},
	get: function(id){
		return swfobject.getObjectById(id);
	},
	getPlayerVersion: function(){
		return swfobject.getFlashPlayerVersion();
	},
	hasPlayerVersion: function(version){
		return swfobject.hasFlashPlayerVersion(version);
	},
	ready: function(id, handler) {
		if(!Trex.Flash.get(id)) {
			setTimeout(function() {
				Trex.Flash.ready(id, handler);
			}, 500);
			return;
		}
		setTimeout(handler, 500);
	}
};

function $txSWF(id) {
	return Trex.Flash.get(id);
} 
