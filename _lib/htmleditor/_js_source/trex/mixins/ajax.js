/**
 * XmlHttpRequest객체를 생성하고 이 객체를 이용해 ajax request를 수행한다.
 * @class
 */
Trex.I.XHRequester = Trex.Faculty.create(/** @lends Trex.I.XHRequester */{ 
	/**
	 * 브라우져에 맞는 XmlHttpRequest 객체를 생성해서 리턴한다.
	 * @private
	 * @return {Object] XmlHttpRequest object
	 */
	createXMLHttp: function() {
		var _xmlHttp = null;
		try{
			if(window.XMLHttpRequest) {
				_xmlHttp = new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				_xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				if(!_xmlHttp) {
					_xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
				}
			}
			return _xmlHttp;
		}catch(e){
			return null;
		}
	},
	/**
	 * ajax call를 수행한다
	 * @param {String} method - http request의 방식, "get" 또는 "post" 
	 * @param {String} url - request를 날릴 url 
	 * @param {Boolean} async - synchronous 여부 
	 * @param {Function} successHandler - ajax의 성공시의 핸들러 
	 * @param {Function} failHandler - ajax 실패시이의 핸들러  
	 * @example
	 * this.sendRequest("get","http://www.daum.net/api",true,function(value){alert(value)}, function(){alert('fail');} 
	 */
	sendRequest: function(method, url, param, async, successHandler, failHandler) { 
		if (url == null && url != "") {
			return null;
		}
		
		var _response = null;
		var _xmlHttp = this.createXMLHttp();
		if(_xmlHttp == null) {
			return null;
		}
		
		var handler = function(){
			if (_xmlHttp.status == 200) {
				if (method.toUpperCase() == "HEAD") {
					_response = successHandler(_xmlHttp.getAllResponseHeaders());
				} else {
					_response = successHandler(_xmlHttp.responseText);
				}
			} else {
				_response = failHandler(_xmlHttp.status);
			}
			_xmlHttp = null;
		};
		try{
			if (async) {
				_xmlHttp.onreadystatechange = function(){
					if (_xmlHttp.readyState == 4) {
						handler();			
					}
				};
			}
			if(method.toUpperCase() == "POST") {
				_xmlHttp.open("POST", url, async);
				_xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
				_xmlHttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				_xmlHttp.setRequestHeader("Content-Length", param.length);
				_xmlHttp.setRequestHeader("Connetion","close");
				_xmlHttp.send(param);
			} else {
				if(param && param.length > 0) {
					url = url + ((url.indexOf("?") > -1)? "&": "?") + param;
				}
				_xmlHttp.open(method.toUpperCase(), url, async);
				_xmlHttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				_xmlHttp.send(null);
			}
			
			if (!async) {
				handler();
			}
			return _response;
		}catch(e){
			return null; 
		}
	}
});

Trex.Responder = { 
	callbacks: {},
	process: function(bytesLoaded, bytesTotal) {
		//if(bytesLoaded < 0) {
			// fail
		//} else {
			// progress
		//}
	},
	newKey: function() {
		var _key = "exe_" + Math.floor(Math.random() * 100000);
		if(this[_key]) {
			return this.newKey();
		} else {
			return _key;
		}
	},
	register: function(handler) {
		var _key = this.newKey();
		this.callbacks[_key] = function(response) {
			handler(response);
			this.callbacks[_key] = null;
		}.bind(this);
		return _key;
	}
};

/**
 * 플래쉬를 이용하여 Cross Domain Security 를 우회하는 XmlHttpReuqest객체를 생성하고 reqest를 수행한다. 
 * @class
 */
Trex.I.FHRequester = Trex.Faculty.create(/** @lends Trex.I.FHRequester */{
	/**
	 * ajax call를 수행한다 
	 * @param {String} method - http request의 방식, "get" 또는 "post" 
	 * @param {String} url - request를 날릴 url
	 * @param {String} param - reuqest를 날릴때의 추가되는 param
	 * @param {Boolean} async - synchronous 여부 
	 * @param {Function} successHandler - ajax의 성공시의 핸들러 
	 * @param {Function} failHandler - ajax 실패시의 핸들러  
	 * @param {Function} progressHandler - ajax reuqest가 진행중일때 사용되는 핸들러
	 * @example
	 * this.sendRequest("get","http://www.daum.net/api","&id=petrucci&password=portnoi",true,function(value){alert(value)}, function(){alert('fail');} 
	 */
	sendRequest: function(method, url, param, async, successHandler, failHandler, progressHandler) {
		var _fhr = Trex.Flash.get("tx_fhr");
		if (!_fhr) {
			_fhr = function() {
				Trex.Flash.load(
					"http://editor.daum.net/swf/FHR3.swf?rv=1.1.0",
					"tx_fhr_target",
					"tx_fhr"
				);
				return Trex.Flash.get("tx_fhr");
			}();
			setTimeout(this.sendRequest.bind(this, method, url, param, async, successHandler, failHandler), 100);
			return;
		}
		if(!_fhr.send) {
			setTimeout(this.sendRequest.bind(this, method, url, param, async, successHandler, failHandler), 50);
			return;
		}
		
		var _succkey = Trex.Responder.register(successHandler);
		var _succHandler = 'Trex.Responder.callbacks["' + _succkey + '"]';
		
		var _failHandler = 'Trex.Responder.process'; //default callback
		if(failHandler) {
			var _failkey = Trex.Responder.register(function(bytesLoaded, bytesTotal) {
				if (bytesLoaded == -1) {
					failHandler(bytesLoaded, bytesTotal);
				} else if(progressHandler) {
					progressHandler(bytesLoaded, bytesTotal);
				}
			});
			_failHandler = 'Trex.Responder.callbacks["' + _failkey + '"]';
		}
		if(url.charAt(0) === "/") { //relative path
			url = "http://" + document.location.host + url;
		}
		if (method.toUpperCase() == "GET") {
			if (!param) {
				param = "";
			}
			url = url + ((url.indexOf("?") > -1) ? "&" : "?") + param;
		}
		if (url) {
			_fhr.send(method, url, param, _succHandler, _failHandler);
		}
	}
});
/**
 * 동적으로 외부의 javascript파일을 include한다. 
 * @class
 */
Trex.I.JSRequester = Trex.Faculty.create(/** @lends Trex.I.JSRequester */{ 
	/**
	 * 특정위치의 스크립트 파일을 include 한다.
	 * @param {String} url - http request의 방식, "get" 또는 "post" 
	 * @param {String} encoding - inlcude할 javascript의 encoding 타입
	 * @param {Element} context - 로딩된 스크립트가 표시될 dom element
	 * @example
	 * this.importScript("http://www.daum.net/api/movie.js?apikey=1234","utf-8", document.body ) 
	 */
	importScript: function(url, encoding, context) { 
		if (url == null && url != "") {
			return null;
		}
		encoding = encoding || "utf-8";
		context = context || document;
		try{
			var _elScript = context.createElement("script");
			_elScript.setAttribute("type", "text/javascript");
			_elScript.setAttribute("charset", encoding);
			context.body.appendChild(_elScript);
			
			var _orgWrite = context.write;
			context.write = function(text) {
				var _elDiv = context.createElement("div");
				context.body.appendChild(_elDiv);
				_elDiv.innerHTML += text;
			};
			
			if ($tx.msie) {
				_elScript.onreadystatechange = function() {
					if (this.readyState == "loaded" || this.readyState == "complete") {
						context.write = _orgWrite;
					}
				};
			} else {
				_elScript.onload = function() {
					context.write = _orgWrite;
				};
			}
			_elScript.setAttribute("src", url);
		}catch(e){
			console.log(e)
		}
	}
});