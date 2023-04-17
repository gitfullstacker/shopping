
var TrexMessage = function() {
	var __MESSAGES = {};
	
	var _deepcopy = function(preset, service) {
		var _dest = preset;
		for(var _name in service) {
			switch(typeof(service[_name])) {
				case 'undefined':
				case 'null':
				case 'string':
				case 'number':
				case 'boolean': 
				case 'date':
				case 'function':
					_dest[_name] = service[_name];
					break;
				default:
					if(service[_name].constructor == Array) {
						_dest[_name] = [].concat(service[_name]);
					} else {
						_deepcopy(_dest[_name] || {}, service[_name]);
					}
					break;
			}
		}
		return _dest;
	};
	
	var _trexMessage = {
		getMsg: function(msgid){
			var _message = __MESSAGES[msgid] || "";
			
			if (_message.indexOf("#iconpath") > -1) {
				_message = TrexConfig.getIconPath(_message);
			}
			if (_message.indexOf("#decopath") > -1) {
				_message = TrexConfig.getDecoPath(_message);
			}
			return _message;
		},
		addMsg: function(messages) {
			_deepcopy(__MESSAGES, messages);
		},
		printAll: function() {
			var _cc = console;
			for(var _name in __MESSAGES) {
				_cc.log(_name + '=' + __MESSAGES[_name]);
			}
		}
	};
	
	return _trexMessage;
}();

window.TXMSG = TrexMessage.getMsg;	

