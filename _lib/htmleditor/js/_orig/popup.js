/*
 *  Daum Open Editor Based on Trex ver 1.5.
 *  Developed by: The Editors @ RIA Tech Team, FT Center 
 *  Powered by: Daum Communication Corp
 *  License: GNU LGPL (Lesser General Public Licence) 
 *  
 *  For further information visit: 
 *  	http://code.google.com/p/daumopeneditor/
 *  	
 *  Open Source References :
 *  + prototype v1.5.1.1 - http://www.prototypejs.org/
 *  + hyperscript - http://elzr.com/posts/hyperscript
 *  + SWFObject v2.2 - http://blog.deconcept.com/swfobject/
 */

/**
 * Editor의 Global 속성들을 정의
 *  
 * @property
 */
var __TX_GLOBAL = {
	//domain: 'daum.net'
};
if(document && __TX_GLOBAL.domain && !window.Jaxer) {
	document.domain = __TX_GLOBAL.domain;
}

if (!("console" in window) || !("firebug" in console))
{
    var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml",
    "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];

    window.console = {};
    for (var i = 0; i < names.length; ++i) {
		window.console[names[i]] = function(){
		}
	}	
}if (!window.StopWatch) {
	StopWatch = {
		output: [],
		index: 0,
		start: function(){
			this._init = new Date().getTime();
		},
		lap: function(desc, c) {
			//var ctx = c ? c : window;
			var gap = new Date().getTime() - this._init;
			this.output.push("#" + (this.index++) + " : " + gap + " , " + desc);
		},
		printAll: function() {
			var _cc = console;
			for(var i=0,len=this.output.length;i<len;i++) {
				_cc.log(this.output[i]);
			}
		}
	};
}

/** @namespace */
var $tx = {}; 
(function() {
	/**
	 * @function
	 */
	Object.extend = function(destination, source) {
		for (var property in source) {
			destination[property] = source[property];
		}
		return destination;
	};
	
	window.Class = {
		create: function() {
			return function() {
				this.initialize.apply(this, arguments);
			};
		}
	};
	/**
	 * @class
	 */
	window.$break = {};
	/**
	 * 함수(=메소드) 소유자 객체로 미리 묶는 함수의 인스턴스를 반환. 반환된 함수는 원래의 것과 같은 인자를 가질 것이다.
	 * @function
	 */
	Function.prototype.bind = function() {
		var __method = this, args = $A(arguments), object = args.shift();
		return function() {
			return __method.apply(object, args.concat($A(arguments)));
		}
	};
	/**
	 * 유하는 객체 함수(=메소드) 소유자 객체로 미리 묶는 함수의 인스턴스를 반환. 반환된 함수는 이것의 인자로 현재 이벤트 객체를 가질것이다.
	 * @function
	 */
	Function.prototype.bindAsEventListener = function(object) {
		var __method = this, args = $A(arguments), object = args.shift();
		return function(event) {
			return __method.apply(object, [event || window.event].concat(args));
		}
	};
	
	var txlib = function(element) {
		if (arguments.length > 1) {
			for (var i = 0, elements = [], length = arguments.length; i < length; i++) 
				elements.push($tx(arguments[i]));
			return elements;
		}
		if (typeof element == 'string') {
			element = document.getElementById(element);
		}
		return element;
	};
	$tx = txlib;
	
	Object.extend($tx, /** @lends $tx */{
		/**
		 * Chrome browser 이면 true
		 * @field
		 */
		chrome: (navigator.userAgent.indexOf("Chrome") != -1),
		/**
		 * Firefox browser 이면 true 
		 * @field
		 */
		gecko: (navigator.userAgent.indexOf("Firefox") != -1),
		/**
		 * Firefox browser의 버전 
		 * @field
		 */
		gecko_ver: (navigator.userAgent.indexOf("Firefox") != -1)?parseFloat(navigator.userAgent.replace(/.*Firefox\/([\d\.]+).*/g,"$1")):0,
		/**
		 * MS IE 이면 true 
		 * @field
		 */
		msie: (navigator.userAgent.indexOf("MSIE") != -1),
		/**
		 * MS IE browser 버전 
		 * @field
		 */
		msie_ver: (navigator.userAgent.indexOf("MSIE") != -1)?parseFloat(navigator.appVersion.split("MSIE")[1]):0,
		/**
		 * MS IE8 browser mode 
		 * @field
		 */
		msie8_compat: ($tx.msie_ver == 7 && (navigator.userAgent.indexOf("Trident/4.0") != -1)),
		/**
		 * MS IE8 browser mode
		 * @field
		 */
		msie8_std: $tx.msie_ver == 8 && (navigator.userAgent.indexOf("Trident/4.0") != -1),
		/**
		 * AppleWebKit browser 이면 true 
		 * @field
		 */
		webkit: (navigator.userAgent.indexOf("AppleWebKit") != -1),
		/**
		 * AppleWebKit 버전
		 * @field
		 */
		webkit_ver: (navigator.userAgent.indexOf("AppleWebKit") != -1)?parseFloat(navigator.userAgent.replace(/.*Safari\//g,"")):0,
		/**
		 * Opera 이면 true 
		 * @field
		 */
		opera: (navigator.userAgent.indexOf("Opera") != -1),
		 /**  
 	      * Presto browser 이면 true   
		  * @field  
		  */
		presto: (navigator.userAgent.indexOf("Presto") != -1),  
		/**
		 * iPhone 이면 true 
		 * @field
		 */
		iphone: (navigator.userAgent.indexOf("iPhone") != -1),
		/**
		 * iPod 이면 true 
		 * @field
		 */
		ipod: (navigator.userAgent.indexOf("iPod") != -1)
	});
	
	Object.extend($tx, /** @lends $tx */{
		extend: Object.extend,
		/**
		 * browser의 이름 리턴
		 * @function
		 */
		browser: function() {
			if($tx.msie) {
				return 'msie';
			} else if($tx.gecko) {
				return 'firefox';
			} else if($tx.chrome) {
				return 'chrome';
			} else if($tx.webkit) {
				return 'safari';
			} else if($tx.opera) {
				return 'opera';
			} else {
				return "";
			}
		}()
	});
	
	/**
	 * @function
	 */
	window.$must = function(id, className) {
		var _el = $tx(id);
		if (!_el) {
			var _e = new Error("[Exception] " + className + " : not exist element(" + id + ")");
			throw _e;
		}
		return _el;
	};
	
	//expose
	window.txlib = txlib;
})();
		
(function() {		
	/**
	 * template
	 * @deprecated
	(function() {
		window.Template = Class.create();
		Template.Pattern = /(^|.|\r|\n)(#\{(.*?)\}|#%7B(.*?)%7D)/;
		Template.prototype = {
			initialize: function(template, pattern) {
				this.template = template.toString();
				this.pattern = pattern || Template.Pattern;
			},
			evaluate: function(object) {
				return this.template.gsub(this.pattern, function(match) {
					var before = match[1];
					if (before == '\\') 
						return match[2];
					return before + String.interpret(object[match[3] || match[4]]);
				});
			}
		};
	})();
	*/
	
	$tx.extend($tx, /** @lends $tx */{
		/**
		 * 주어진 element와 관련된 CSS 클래스명을 표시하는 Element.ClassNames 객체를 반환
		 * @function
		 */
		classNames: function(el) {
			return el.className.split(' ');
		},
		/**
		 * 요소가 class명중에 하나로 주어진 class명을 가진다면 true를 반환
		 * @function
		 */
		hasClassName: function(el, c) {
			var exist = false;
			if (!el.className) {
				return false;
			}
			var tmp = el.className.split(' ');
			for (var i in tmp) {
				if (tmp[i] == c) {
					exist = true;
					break;
				}
			}
			return exist;
		},
		/**
		 * 주어진 class명을 요소의 class명으로 추가
		 * @function
		 */
		addClassName: function(el, c) {
			if (!this.hasClassName(el, c)) 
				el.className += ' ' + c;
		},
		/**
		 * 요소의 class명으로 부터 주어진 class명을 제거
		 * @function
		 */
		removeClassName: function(el, c) {
			var tmp = el.className.split(' ');
			for (var i in tmp) {
				if (tmp[i] == c) {
					tmp.splice(i, 1);
					break;
				}
			}
			el.className = tmp.join(' ');
		},
		/**
		 * 요소가 눈에 보이는지 표시하는 Boolean값을 반환
		 * @function
		 */
		visible: function(element) {
			//return $tx(element).style.display != 'none';
			return $tx.getStyle(element, "display" ) != 'none';
		},
		/**
		 * 각각의 전달된 요소의 가시성(visibility)을 토글(toggle)한다.
		 * @function
		 */
		toggle: function(element) {
			element = $tx(element);
			$tx[$tx.visible(element) ? 'hide' : 'show'](element);
			return element;
		},
		/**
		 * style.display를 'block'로 셋팅하여 각각의 요소를 보여준다.
		 * @function
		 */
		show: function(element) {
			$tx(element).style.display = 'block';
			return element;
		},
		/**
		 * style.display를 'none'로 셋팅하여 각각의 요소를 숨긴다.
		 * @function
		 */
		hide: function(element) {
			$tx(element).style.display = 'none';
			return element;
		}
	});
})();

(function() {	
	$tx.extend($tx, /** @lends $tx */{
		/**
		 * 요소의 style속성 중 opacity 값을 리턴한다.
		 * @function
		 */
		getOpacity: function(element) {
			return $tx(element).getStyle('opacity');
		},
		/**
		 * 요소의 style 속성을 셋팅한다.
		 * @function
		 */
		setStyle: function(element, styles, camelized) {
			element = $tx(element);
			var elementStyle = element.style;
			for (var property in styles) 
				if (property == 'opacity') 
					$tx.setOpacity(element, styles[property]);
				else 
					elementStyle[(property == 'float' || property == 'cssFloat') ? (elementStyle.styleFloat === undefined ? 'cssFloat' : 'styleFloat') : (camelized ? property : property.camelize())] = styles[property];
			return element;
		}
	});
	
	var getStyle = function(element, style) {
		element = $tx(element);
		style = style == 'float' ? 'cssFloat' : style.camelize();
		var value = element.style[style];
		if (!value) {
			var css = document.defaultView.getComputedStyle(element, null);
			value = css ? css[style] : null;
		}
		if (style == 'opacity') 
			return value ? parseFloat(value) : 1.0;
		return value == 'auto' ? null : value;
	};
	
	$tx.extend($tx, /** @lends $tx */{
		/**
		 * 인자로 넘겨 받은 요소의 특정 style 속성값을 리턴한다.
		 * @function
		 * @param {Element} element
		 * @style {String} style property
		 */
		getStyle: getStyle
	});
	
	if ($tx.opera) {
		$tx.extend($tx, {
			getStyle: function(element, style) {
				switch (style) {
					case 'left':
					case 'top':
					case 'right':
					case 'bottom':
						if (getStyle(element, 'position') == 'static') {
							return null;
						}
					default:
						return getStyle(element, style);
				}
			}
		});
	} else if ($tx.msie) {
		$tx.extend($tx, {
			getStyle: function(element, style) {
				element = $tx(element);
				style = (style == 'float' || style == 'cssFloat') ? 'styleFloat' : style.camelize();
				var value = element.style[style];
				if (!value && element.currentStyle) 
					value = element.currentStyle[style];
				if (style == 'opacity') {
					if (value = ($tx.getStyle(element,'filter') || '').match(/alpha\(opacity=(.*)\)/)) 
						if (value[1]) 
							return parseFloat(value[1]) / 100;
					return 1.0;
				}
				if (value == 'auto') {
					if ((style == 'width' || style == 'height') && ($tx.getStyle(element,'display') != 'none')) {
						return element['offset' + style.capitalize()] + 'px';
					}
					return null;
				}
				return value;
			}
		});
	}
	
	$tx.extend($tx, /** @lends $tx */{
		/**
		 * 요소의 opacity style 속성을 셋팅한다.
		 * @function
		 */
		setOpacity: function(element, value) {
			element = $tx(element);
			element.style.opacity = (value == 1 || value === '') ? '' : (value < 0.00001) ? 0 : value;
			return element;
		}
	});
	
	if ($tx.msie) {
		$tx.extend($tx, {
			setOpacity: function(element, value) {
				element = $tx(element);
				var filter = $tx.getStyle(element, 'filter'), style = element.style;
				if (value == 1 || value === '') {
					style.filter = filter.replace(/alpha\([^\)]*\)/gi, '');
					return element;
				} else if (value < 0.00001) 
					value = 0;
				style.filter = filter.replace(/alpha\([^\)]*\)/gi, '') +
				'alpha(opacity=' +
				(value * 100) +
				')';
				return element;
			}
		});
	} else if ($tx.gecko) {
		$tx.extend($tx, {
			setOpacity: function(element, value) {
				element = $tx(element);
				element.style.opacity = (value == 1) ? 0.999999 : (value === '') ? '' : (value < 0.00001) ? 0 : value;
				return element;
			}
		});
	}
})();

//position
(function() {
	$tx.extend($tx, /** @lends $tx */ {
		/**
		 * 요소의 최상위 요소까지의 offset position 을 더한 값을 리턴한다.
		 * @function
		 */
		cumulativeOffset: function(element) {
			var valueT = 0, valueL = 0;
			do {
				valueT += element.offsetTop || 0;
				valueL += element.offsetLeft || 0;
				element = element.offsetParent;
			} while (element);
			return [valueL, valueT];
		},
		/**
		 * 요소의 최상위 요소까지의 offset position 을 더한 값을 리턴한다.
		 * 상위 요소가 body이거나 position이 relative 또는 absolute 인 경우 계산을 중지한다.
		 * @function
		 */
		positionedOffset: function(element) {
			var valueT = 0, valueL = 0;
			do {
				valueT += element.offsetTop || 0;
				valueL += element.offsetLeft || 0;
				element = element.offsetParent;
				if (element) {
					if (element.tagName == 'BODY') 
						break;
					var p = $tx.getStyle(element, 'position');
					if (p == 'relative' || p == 'absolute') 
						break;
				}
			} while (element);
			return [valueL, valueT];
		},
		/**
		 * element의 면적(dimensions)을 반환. 반환된 값은 두개의 프라퍼티(height 와 width)를 가지는 객체이다. 
		 * @function
		 */
		getDimensions: function(element) {
		    var display = $tx.getStyle(element, 'display');
		    if (display != 'none' && display != null) // Safari bug
		      return {width: element.offsetWidth, height: element.offsetHeight};
		
		    // All *Width and *Height properties give 0 on elements with display none,
		    // so enable the element temporarily
		    var els = element.style;
		    var originalVisibility = els.visibility;
		    var originalPosition = els.position;
		    var originalDisplay = els.display;
		    els.visibility = 'hidden';
		    els.position = 'absolute';
		    els.display = 'block';
		    var originalWidth = element.clientWidth;
		    var originalHeight = element.clientHeight;
		    els.display = originalDisplay;
		    els.position = originalPosition;
		    els.visibility = originalVisibility;
		    return {width: originalWidth, height: originalHeight};
	  }
	});
	// Safari returns margins on body which is incorrect if the child is absolutely
	// positioned.  For performance reasons, redefine Position.cumulativeOffset for
	// KHTML/WebKit only.
	if ($tx.webkit) {
		$tx.cumulativeOffset = function(element) {
			var valueT = 0, valueL = 0;
			do {
				valueT += element.offsetTop || 0;
				valueL += element.offsetLeft || 0;
				if (element.offsetParent == document.body) 
					if ($tx.getStyle(element, 'position') == 'absolute') 
						break;
				element = element.offsetParent;
			} while (element);
			return [valueL, valueT];
		};
	}
	
})();

//events
(function () /** @lends $tx */ {
	$tx.extend($tx, {
		/** @field backspace key */
		KEY_BACKSPACE: 8,
		/** @field tab key */
		KEY_TAB: 9,
		/** @field return key */
		KEY_RETURN: 13,
		/** @field esc key */
		KEY_ESC: 27,
		/** @field left key */
		KEY_LEFT: 37,
		/** @field up key */
		KEY_UP: 38,
		/** @field right key */
		KEY_RIGHT: 39,
		/** @field down key */
		KEY_DOWN: 40,
		/** @field delete key */
		KEY_DELETE: 46,
		/** @field home key */
		KEY_HOME: 36,
		/** @field end key */
		KEY_END: 35,
		/** @field pageup key */
		KEY_PAGEUP: 33,
		/** @field pagedown key */
		KEY_PAGEDOWN: 34,
		/**
		 * 이벤트의 target 또는 srcElement 를 반환
		 * @function
		 */
		element: function(event) {
			return $tx(event.target || event.srcElement);
		},
		/**
		 * 마우스 왼쪽 버튼을 클릭시 true값 반환
		 * @function
		 */
		isLeftClick: function(event) {
			return (((event.which) && (event.which == 1)) ||
			((event.button) && (event.button == 1)));
		},
		/**
		 * 페이지에서 마우스 포인터의 x측 좌표값 반환
		 * @function
		 */
		pointerX: function(event) {
			return event.pageX ||
			(event.clientX +
			(document.documentElement.scrollLeft || document.body.scrollLeft));
		},
		/**
		 * 페이지에서 마우스 포인터의 y측 좌표값 반환
		 * @function
		 */
		pointerY: function(event) {
			return event.pageY ||
			(event.clientY +
			(document.documentElement.scrollTop || document.body.scrollTop));
		},
		/**
		 * 이벤트의 디폴트 행위를 취소하고 위임을 연기하기 위해 이 함수를 사용
		 * @function
		 */
		stop: function(event) {
			if (event.preventDefault) {
				event.preventDefault();
				event.stopPropagation();
			} else {
				event.returnValue = false;
				event.cancelBubble = true;
			}
		},
		/**
		 * 이벤트가 시작된 노드로부터 상위로 순회하며 주어진 태그이름을 갖는 첫번째 노드를 찾는다.
		 * find the first node with the given tagName, starting from the
		 * node the event was triggered on; traverses the DOM upwards
		 * @function
		 */
		findElement: function(event, tagName) {
			var element = $tx.element(event);
			while (element.parentNode &&
			(!element.tagName ||
			(element.tagName.toUpperCase() != tagName.toUpperCase()))) 
				element = element.parentNode;
			return element;
		},
		observers: false,
		_observeAndCache: function(element, name, observer, useCapture) {
			if (!this.observers) 
				this.observers = [];
			if (element.addEventListener) {
				this.observers.push([element, name, observer, useCapture]);
				element.addEventListener(name, observer, useCapture);
			} else if (element.attachEvent) {
				this.observers.push([element, name, observer, useCapture]);
				element.attachEvent('on' + name, observer);
			}
		},
		unloadCache: function() {
			if (!$tx.observers) 
				return;
			for (var i = 0, length = $tx.observers.length; i < length; i++) {
				$tx.stopObserving.apply(this, $tx.observers[i]);
				$tx.observers[i][0] = null;
			}
			$tx.observers = false;
		},
		/**
		 * 이벤트를 위한 이벤트 핸들러 함수를 추가
		 * @function
		 * @param {Object} element 요소객체 또는 아이디
		 * @param {String} name 이벤트 명
		 * @param {Function} observer 이벤트를 다루는 함수
		 * @param {Boolean} userCapture true라면, capture내 이벤트를 다루고 false라면 bubbling 내 이벤트를 다룬다.
		 */
		observe: function(element, name, observer, useCapture) {
			element = $tx(element);
			useCapture = useCapture || false;
			if (name == 'keypress' &&
			($tx.webkit || element.attachEvent)) 
				name = 'keydown';
			$tx._observeAndCache(element, name, observer, useCapture);
		},
		/**
		 * 이벤트로부터 이벤트 핸들러를 제거
		 * @function
		 * @param {Object} element 요소객체 또는 아이디
		 * @param {String} name 이벤트 명
		 * @param {Function} observer 이벤트를 다루는 함수
		 * @param {Boolean} userCapture true라면, capture내 이벤트를 다루고 false라면 bubbling 내 이벤트를 다룬다.
		 */
		stopObserving: function(element, name, observer, useCapture) {
			element = $tx(element);
			useCapture = useCapture || false;
			if (name == 'keypress' &&
			($tx.webkit || element.attachEvent)) 
				name = 'keydown';
			if (element.removeEventListener) {
				element.removeEventListener(name, observer, useCapture);
			} else if (element.detachEvent) {
				try {
					element.detachEvent('on' + name, observer);
				} catch (e) {
				}
			}
		}
	});
	//  prevent memory leaks in IE 
	if ($tx.msie) {
		$tx.observe(window, 'unload', $tx.unloadCache, false);
	}
})();

(function()  {
	$tx.extend(Object, /** @lends Object */ {
		/**
		 * targetObj의 사람이 읽을수 있는 문자열 표현으로 반환. 주어진 객체가 inspect 인스턴스 메소드를 정의하지 않는다면, toString 의 값을 반환
		 * @function
		 */
		inspect: function(object) {
			try {
				if (object === undefined) 
					return 'undefined';
				if (object === null) 
					return 'null';
				return object.inspect ? object.inspect() : object.toString();
			} catch (e) {
				if (e instanceof RangeError) 
					return '...';
				throw e;
			}
		},
		/**
		 * object 를 json 형태로 반환
		 * @function
		 */
		toJSON: function(object) {
			var type = typeof object;
			switch (type) {
				case 'undefined':
				case 'function':
				case 'unknown':
					return;
				case 'boolean':
					return object.toString();
			}
			if (object === null) {
				return null;
			}
			if (object.toJSON) 
				return object.toJSON();
			if (object.ownerDocument === document) 
				return;
			var results = [];
			for (var property in object) {
				var value = Object.toJSON(object[property]);
				if (value !== undefined) 
					results.push(property.toJSON() + ': ' + value);
			}
			return '{' + results.join(', ') + '}';
		},
		/**
		 * object 를 복사
		 * @function
		 */
		clone: function(object) {
			return Object.extend({}, object);
		}
	});
	///////
	$tx.extend(Object, /** @lends Object */ {
		/**
		 * object property가 toEncode()를 정의하고 있다면 이를 실행시켜서 반환
		 * @function
		 */
		toEncode: function(object) {
			var type = typeof object;
			switch (type) {
				case 'undefined':
				case 'function':
				case 'unknown':
					return;
				case 'number':
				case 'boolean':
				case 'date':
					return object;
			}
			if (object === null) {
				return null;
			}
			if (object.toEncode) {
				return object.toEncode();
			}
			if (object.ownerDocument === document) {
				return;
			}
			var results = {};
			for (var property in object) {
				if (object[property]) {
					var value = Object.toEncode(object[property]);
					if (value !== undefined) {
						results[property] = value;
					}
				}
			}
			return results;
		},
		/**
		 * object property가 toDecode()를 정의하고 있다면 이를 실행시켜서 반환
		 * @function
		 */
		toDecode: function(object) {
			var type = typeof object;
			switch (type) {
				case 'undefined':
				case 'function':
				case 'unknown':
					return;
				case 'number':
				case 'boolean':
				case 'date':
					return object;
			}
			if (object === null) {
				return null;
			}
			if (object.toDecode) {
				return object.toDecode();
			}
			if (object.ownerDocument === document) {
				return;
			}
			var results = {};
			for (var property in object) {
				if (object[property]) {
					var value = Object.toDecode(object[property]);
					if (value !== undefined) {
						results[property] = value;
					}
				}
			}
			return results;
		}
	});
})();

(function () {
	$tx.extend(String, /** @lends String */{
		/**
		 * value 를 문자열로 만들어 반환한다. value 가 null 이면 빈문자열을 반환한다.
		 * @function
		 */
		interpret: function(value) {
			return value == null ? '' : String(value);
		},
		/**
		 * @field
		 */
		specialChar: {
			'\b': '\\b',
			'\t': '\\t',
			'\n': '\\n',
			'\f': '\\f',
			'\r': '\\r',
			'\\': '\\\\'
		}
	});
	$tx.extend(String.prototype, /** @lends String.prototype */{
		/**
		 * 현재 문자열에서 패턴 문자열을 찾은 결과의 문자열을 반환하고 대체 문자열이나 패턴에 일치하는 문자열을 가진 배열을 전달하는 대체함수를 호출한 결과로 대체한다. 
		 * 대체물이 문자열일때, #{n}과 같은 특별한 템플릿 형태의 토큰을 포함할수 있다. 
		 * 여기서 n이라는 값은 정규표현식 그룹의 인덱스이다.
		 * #{0}는 완전히 일치하면 대체될것이고 #{1}는 첫번째 그룹, #{2}는 두번째이다.
		 * @function
		 */
		gsub: function(pattern, replacement) {
			var result = '', source = this, match;
			replacement = arguments.callee.prepareReplacement(replacement);
			while (source.length > 0) {
				if (match = source.match(pattern)) {
					result += source.slice(0, match.index);
					result += String.interpret(replacement(match));
					source = source.slice(match.index + match[0].length);
				} else {
					result += source, source = '';
				}
			}
			return result;
		},
		/**
		 * 문자열 앞,뒤의 공백을 제거
		 * @function
		 */
		strip: function() {
			return this.replace(/^\s+/, '').replace(/\s+$/, '');
		},
		/**
		 * 문자열 중 태그 <tag> 를 삭제
		 * @function
		 */
		stripTags: function() {
			return this.replace(/<\/?[^>]+>/gi, '');
		},
		/**
		 * url query string 을 json 으로 만들어 반환한다. separator 를 & 대신 다른 값을 사용할 수 있다.
		 * @function
		 */
		toQueryParams: function(separator) {
			var match = this.strip().match(/([^?#]*)(#.*)?$/);
		    if (!match) return {};
		
			var _hash = {};
			var _lastkey = null;
		    match[1].split(separator || '&').each(function(pair) {
				var _key = null, _value = null;
				var _matches = pair.match(/([\w_]+)=(.*)/);
				if(_matches) {
					_lastkey = _key = decodeURIComponent(_matches[1]);
					if(_matches[2]) {
						_value = decodeURIComponent(_matches[2]);
					}
				} else if(_lastkey) {
					_key = _lastkey;
					_value = _hash[_key];
					_value += '&' + decodeURIComponent(pair);
				} else {
					return;
				}
				if (_key in _hash) {
					if (_hash[_key].constructor != Array) 
						_hash[_key] = [_hash[_key]];
					_hash[_key].push(_value);
				} else {
					_hash[_key] = _value;
				}
			});
			return _hash;
		},
		/**
		 * 문자열을 배열로 반환한다.
		 * @function
		 */
		toArray: function() {
			return this.split('');
		},
		/**
		 * count 만큼 문자열을 반복하여 이어 붙인다.
		 * @function
		 */
		times: function(count) {
			var result = '';
			for (var i = 0; i < count; i++) 
				result += this;
			return result;
		},
		/**
		 * -(하이픈)으로 분리된 문자열을 camelCaseString으로 변환
		 * @function
		 */
		camelize: function() {
			var parts = this.split('-'), len = parts.length;
			if (len == 1) 
				return parts[0];
			var camelized = this.charAt(0) == '-' ? parts[0].charAt(0).toUpperCase() + parts[0].substring(1) : parts[0];
			for (var i = 1; i < len; i++) 
				camelized += parts[i].charAt(0).toUpperCase() + parts[i].substring(1);
			return camelized;
		},
		/**
		 * 첫번째 글자를 대문자로 변환
		 * @function
		 */
		capitalize: function() {
			return this.charAt(0).toUpperCase() + this.substring(1).toLowerCase();
		},
		/**
		 * Returns a debug-oriented version of the string (i.e. wrapped in single or double quotes, with backslashes and quotes escaped).
		 * @function
		 */
		inspect: function(useDoubleQuotes) {
			var escapedString = this.gsub(/[\x00-\x1f\\]/, function(match) {
				var character = String.specialChar[match[0]];
				return character ? character : '\\u00' + match[0].charCodeAt().toPaddedString(2, 16);
			});
			if (useDoubleQuotes) 
				return '"' + escapedString.replace(/"/g, '\\"') + '"';
			return "'" + escapedString.replace(/'/g, '\\\'') + "'";
		},
		/**
		 * return this.inspect(true);
		 * @function
		 */
		toJSON: function() {
			return this.inspect(true);
		},
		/**
		 * 문자열이 주어진 패턴을 포함하면 true
		 * @function
		 */
		include: function(pattern) {
			return this.indexOf(pattern) > -1;
		},
		/**
		 * 빈문자열이면 true
		 * @function
		 */
		empty: function() {
			return this == '';
		},
		/**
		 * 공백문자열이면 true
		 * @function
		 */
		blank: function() {
			return /^\s*$/.test(this);
		}
	});
	String.prototype.gsub.prepareReplacement = function(replacement) {
		if (typeof replacement == 'function') 
			return replacement;
		var template = new Template(replacement);
		return function(match) {
			return template.evaluate(match);
		};
	};
	//////
	$tx.extend(String.prototype, /** @lends String.prototype */{
		/**
		 * 문자열 앞,뒤의 공백을 제거
		 * @function
		 */
		trim: function() {
			return this.replace(/(^\s*)|(\s*$)/g, "");
		},
		/**
		 * 정규표현식에서 사용되는 메타문자를 이스케이프해서 반환한다.
		 * @function
		 */
		getRegExp: function() {
			return this.replace(/\\/g, "\\\\").replace(/\./g, "\\.").replace(/\//g, "\\/").replace(/\?/g, "\\?").replace(/\^/g, "\\^").replace(/\)/g, "\\)").replace(/\(/g, "\\(").replace(/\]/g, "\\]").replace(/\[/g, "\\[").replace(/\$/g, "\\$").replace(/\+/g, "\\+").replace(/\|/g, "\\|").replace(/&/g, "(&|&amp;)");
		},
		/**
		 * 공백문자를 +로 바꾼다.
		 * @function
		 */
		toEncoded: function() {
			return this.replace(/\s/g, "+");
		},
		/**
		 * 문자열을 정수형으로 반환한다. 숫자가 아닌 문자열은 0
		 * @function
		 */
		toNumber: function() {
			return (isNaN(this) ? 0 : parseInt(this, 10));
		},
		/**
		 * 문자열을 부동소수점 형태로 반환한다. 숫자가 아닌 문자열은 0
		 * @function
		 */
		toFloat: function() {
			return (isNaN(this) ? 0 : parseFloat(this));
		},
		/**
		 * 문자열의 길이를 반환
		 * @function
		 */
		getRealLength: function() {
			var str = this;
			var idx = 0;
			for (var i = 0; i < str.length; i++) {
				idx += (escape(str.charAt(i)).charAt(1) == "u") ? 2 : 1;
			}
			return idx;
		},
		/**
		 * 문자열이 주어진 길이보다 길면 자르고 마지막에 ... 를 붙인다.
		 * @function
		 */
		cutRealLength: function(length) {
			var str = this;
			var idx = 0;
			for (var i = 0; i < str.length; i++) {
				idx += (escape(str.charAt(i)).charAt(1) == "u") ? 2 : 1;
				if (idx > length) {
					return str.substring(0, i - 3).concat("...");
				}
			}
			return str;
		},
		/**
		 * 주어진 길이로 문자열을 자른다.
		 * @function
		 */
		getCut: function(length) {
			var str = this;
			var idx = 0;
			for (var i = 0; i < str.length; i++) {
				idx += (escape(str.charAt(i)).charAt(1) == "u") ? 2 : 1;
				if (idx > length) {
					return str.substring(0, i + 1);
				}
			}
			return str.substring(0);
		},
		/**
		 * 문자열에 px 가 있으면 잘라내고 반환한다.
		 * @function
		 */
		parsePx: function() {
			if (this == null || this.length == 0) 
				return 0;
			else if (this.indexOf("px") > -1) 
				return this.substring(0, this.indexOf("px")).toNumber();
			else 
				return this.toNumber();
		},
		/**
		 * 문자열에 px 를 붙여서 반환한다.
		 * @function
		 */
		toPx: function() {
			if (this.indexOf("px") > -1) {
				return this + "";
			} else {
				return this + "px";
			}
		},
		/**
		 * 바이트를 계산하여 단위를(KB, MB) 붙여서 반환한다.
		 * @function
		 */
		toByteUnit: function() {
			return this.toNumber().toByteUnit();
		},
		/**
		 * 문자열을 인코드한다. encodeURIComponent 를 실행하여 반환
		 * @function
		 */
		toEncode: function() {
			return encodeURIComponent(this);
		},
		/**
		 * 문자열을 디코드한다. decodeURIComponent 를 실행하여 반환
		 * @function
		 */
		toDecode: function() {
			return decodeURIComponent(this);
		},
		/**
		 * 숫자로된 문자열을 천단위로 쉼표(,)를 붙인다.
		 * @function
		 */
		toCurrency: function() {
			var amount = this;
			for (var i = 0; i < Math.floor((amount.length - (1 + i)) / 3); i++) {
				amount = amount.substring(0, amount.length - (4 * i + 3)) + "," + amount.substring(amount.length - (4 * i + 3));
			}
			return amount;
		},
		/**
		 * source를 문자열 끝까지 찾아서 target으로 치환한다. 
		 * @function
		 */
		replaceAll: function(source, target) {
			source = source.replace(new RegExp("(\\W)", "g"), "\\$1");
			target = target.replace(new RegExp("\\$", "g"), "$$$$");
			return this.replace(new RegExp(source, "gm"), target);
		}
	});
})();

//date
(function() {
	/**
	 * @function
	 */
	Date.prototype.toJSON = function() {
		return '"' + this.getFullYear() + '-' +
		(this.getMonth() + 1).toPaddedString(2) +
		'-' +
		this.getDate().toPaddedString(2) +
		'T' +
		this.getHours().toPaddedString(2) +
		':' +
		this.getMinutes().toPaddedString(2) +
		':' +
		this.getSeconds().toPaddedString(2) +
		'"';
	};
})();

(function() {
	/**
	 * @name Number
	 * @class
	 */
	$tx.extend(Number.prototype, /** @lends Number.prototype */{
		/**
		 * 숫자로된 문자열이 주어진 길이보다 짧으면 앞부분에 0 으로 채워넣어서 반환한다.
		 * @function 
		 * @param {Number} length 반환되는 문자열의 최소 길이
		 * @param {Number} radix 표기될 진수. optional. 기본 10진수
		 */
		toPaddedString: function(length, radix) {
			var string = this.toString(radix || 10);
			return '0'.times(length - string.length) + string;
		},
		//	  toJSON: function() {
		//	    return isFinite(this) ? this.toString() : 'null';
		//	  }
		// =>
		toJSON: function() {
			return isFinite(this) ? this + 0 : 'null';
		},
		/**
		 * 
		 * @function
		 */
		toTime: function() {
			return Math.floor(this / 60).toString().toPaddedString(2) + ":" + (this % 60).toString().toPaddedString(2);
		},
		/**
		 * 바이트를 계산하여 단위를(KB, MB) 붙여서 반환한다.
		 * @function
		 */
		toByteUnit: function() {
			var number;
			var units = ['GB', 'MB', 'KB'];
			if (this == 0) {
				return "0" + units[2];
			}
			for (var i = 0; i < units.length; i++) {
				number = this / Math.pow(1024, 3 - i);
				if (number < 1) {
					continue;
				}
				return (Math.round(number * 10) / 10) + units[i];
			}
			return "1" + units[2];
		},
		/**
		 * px를 붙인다.
		 * @function
		 */
		toPx: function() {
			return this.toString() + "px";
		},
		/**
		 * 그대로 반환한다.
		 * @function
		 */
		parsePx: function() {
			return this;
		},
		/**
		 * 천단위로 쉼표(,)를 붙인다.
		 * @function
		 */
		toCurrency: function() {
			return this.toString().toCurrency();
		},
		/**
		 * 정규표현식에서 사용되는 메타문자를 이스케이프해서 반환한다.
		 * @function
		 */
		getRegExp: function() {
			return this.toString().getRegExp();
		}
	});
})();

(function() {
	$tx.extend(Array.prototype, /** @lends Array.prototype */{
		/**
		 * 주어진 iterator함수를 호출하는 것은 첫번째 인자내 목록으로 각각의 요소와 두번째 인자내 요소의 인덱스 전달한다
		 * @function
		 */
		each: function(iterator) {
			var index = 0;
			try {
				this._each(function(value) {
					iterator(value, index++);
				});
			} catch (e) {
				if (e != $break) 
					throw e;
			}
			return this;
		},
		_each: function(iterator) {
			for (var i = 0, length = this.length; i < length; i++) 
				iterator(this[i]);
		},
		/**
		 * 집합내 주어진 객체를 찾도록 시도한다. 객체가 찾아진다면, true를 반환하고 찾지 못한다면 false를 반환한다.
		 * @function
		 */
		include: function(object) {
			var found = false;
			this.each(function(value) {
				if (value == object) {
					found = true;
					throw $break;
				}
			});
			return found;
		},
		/**
		 * 집합의 각각의 요소내 propertyName에 의해 명시된 프라퍼티에 값을 가져가고 Array객체로 결과를 반환한다.
		 * @function
		 */
		pluck: function(property) {
			var results = [];
			this.each(function(value, index) {
				results.push(value[property]);
			});
			return results;
		},
		/**
		 * 집합내 각각의 요소를 위한 iterator함수를 호출하고 
		 * true로 해석되는 값을 반환하는 iterator함수를 야기하는 모든 요소를 가진 Array을 반환한다.
		 * @function
		 */
		select: function(iterator) {
			var results = [];
			this.each(function(value, index) {
				if (iterator(value, index)) 
					results.push(value);
			});
			return results;
		},
		/**
		 * iterator함수를 사용하여 집합의 모든 요소를 조합한다. 
		 * 호출된 iterator는 accumulator인자에서 이전 반복의 결과를 전달한다. 
		 * 첫번째 반복은 accumulator인자내 initialValue를 가진다. 마지막 결과는 마지막 반환값이다.
		 * @function
		 */
		inject: function(memo, iterator) {
			this.each(function(value, index) {
				memo = iterator(memo, value, index);
			});
			return memo;
		},
		/**
		 * 인자의 리스트에 포함된 요소를 제외한 배열을 반환. 이 메소드는 배열 자체를 변경하지는 않는다.
		 * @function
		 */
		without: function() {
			var values = $A(arguments);
			return this.select(function(value) {
				return !values.include(value);
			});
		},
		/**
		 * 배열의 마지막 요소를 반환한다.
		 * @function
		 */
		last: function() {
			return this[this.length - 1];
		},
		/**
		 * 기복이 없고, 1차원의 배열을 반환한다. 이 함수는 배열이고 반환된 배열내 요소를 포함하는 배열의 각 요소를 찾음으로써 수행된다.
		 * @function
		 */
		flatten: function() {
			return this.inject([], function(array, value) {
				return array.concat(value && value.constructor == Array ? value.flatten() : [value]);
			});
		},
		/**
		 * 집합내 각각의 요소를 위한 iterator함수를 호출하고 true를 반환하는 iterator함수를 야기하는 첫번째 요소를 반환한다. 
		 * true를 반환하는 요소가 없다면, detect는 null을 반환한다.
		 * @function
		 */
		detect: function(iterator) {
			var result;
			this.each(function(value, index) {
				if (iterator(value, index)) {
					result = value;
					throw $break;
				}
			});
			return result;
		},
		/**
		 * json으로 반환
		 * @function
		 */
		toJSON: function() {
			var results = [];
			this.each(function(object) {
				var value = Object.toJSON(object);
				if (value !== undefined) 
					results.push(value);
			});
			return '[' + results.join(', ') + ']';
		},
		/**
		 * 배열의 요소가 null 이나 빈문자열이면 제거한다. 
		 * @function
		 */
		compact: function() {
			return this.select(function(value) {
				return (value != null) && (value != '');
			});
		},
		/**
		 * 배열의 요소의 값 중 중복되는 값은 제거한다.
		 * @function
		 */
		uniq: function(sorted) {
		    return this.inject([], function(array, value, index) {
				if (0 == index || (sorted ? array.last() != value : !array.include(value)))
					array.push(value);
				return array;
			});
		},
		/**
		 * 배열의 특정요소값을 추출하여 json객체(map)을 만든다.
		 * @function
		 */
		toMap: function(property) {
			var results = {};
			this.each(function(value, index) {
				results[value[property]] = value;
			});
			return results;
		}
	});
	/**
	 * 집합내 각각의 요소를 위한 iterator함수를 호출하고 
	 * true로 해석되는 값을 반환하는 iterator함수를 야기하는 모든 요소를 가진 Array을 반환한다.
	 *  @function 
	 */
	Array.prototype.findAll = Array.prototype.select;
	if ($tx.opera) {
		Array.prototype.concat = function() {
			var array = [];
			for (var i = 0, length = this.length; i < length; i++) 
				array.push(this[i]);
			for (var i = 0, length = arguments.length; i < length; i++) {
				if (arguments[i].constructor == Array) {
					for (var j = 0, arrayLength = arguments[i].length; j < arrayLength; j++) 
						array.push(arguments[i][j]);
				} else {
					array.push(arguments[i]);
				}
			}
			return array;
		};
	}
	///////
	$tx.extend(Array.prototype, /** @lends Array.prototype */{
		/**
		 * 배열의 요소를 인코드한다.
		 * @function
		 */
		toEncode: function() {
			var results = [];
			this.each(function(object) {
				var value = Object.toEncode(object);
				if (value !== undefined) {
					results.push(value);
				}
			});
			return results;
		},
		/**
		 * 배열의 요소를 디코드한다.
		 * @function
		 */
		toDecode: function() {
			var results = [];
			this.each(function(object) {
				var value = Object.toDecode(object);
				if (value !== undefined) {
					results.push(value);
				}
			});
			return results;
		}
	});
	/** 
	 * 이것을 받아들이는 하나의 인자를 Array 객체로 변환한다.
	 * @name $A
	 * @example
	 * 	var someNodes = document.getElementsByTagName('img');
	 * 	var nodesArray = $A(someNodes);
	 */
	window.$A = Array.from = function(iterable) {
		if (!iterable) 
			return [];
		if (iterable.toArray) {
			return iterable.toArray();
		} else {
			var results = [];
			for (var i = 0, length = iterable.length; i < length; i++) 
				results.push(iterable[i]);
			return results;
		}
	};
	if ($tx.webkit) {
		$A = Array.from = function(iterable) {
			if (!iterable) 
				return [];
			if (!(typeof iterable == 'function' && iterable == '[object NodeList]') &&
			iterable.toArray) {
				return iterable.toArray();
			} else {
				var results = [];
				for (var i = 0, length = iterable.length; i < length; i++) 
					results.push(iterable[i]);
				return results;
			}
		};
	}
})();
//hash
(function() {
	/** @class */
	var Hash = function(object) {
		if (object instanceof Hash) 
			this.merge(object);
		else 
			Object.extend(this, object || {});
	};
	$tx.extend(Hash, /** @lends Hash */{
		/**
		 * 쿼리 문자열처럼 포맷팅된 문자열로 hash의 모든 항목을 반환.
		 * 이를테면 'key1=value1&key2=value2&key3=value3'
		 * @function
		 */
		toQueryString: function(obj) {
			var parts = [];
			parts.add = arguments.callee.addPair;
			this.prototype._each.call(obj, function(pair) {
				if (!pair.key) 
					return;
				var value = pair.value;
				if (value && typeof value == 'object') {
					if (value.constructor == Array) 
						value.each(function(value) {
							parts.add(pair.key, value);
						});
					return;
				}
				parts.add(pair.key, value);
			});
			return parts.join('&');
		},
		/**
		 * Hash를 json 으로 반환
		 * @function
		 */
		toJSON: function(object) {
			var results = [];
			this.prototype._each.call(object, function(pair) {
				var value = Object.toJSON(pair.value);
				if (value !== undefined) 
					results.push(pair.key.toJSON() + ': ' + value);
			});
			return '{' + results.join(', ') + '}';
		}
	});
	
	Hash.toQueryString.addPair = function(key, value, prefix) {
		key = encodeURIComponent(key);
		if (value === undefined) 
			this.push(key);
		else 
			this.push(key + '=' + (value == null ? '' : encodeURIComponent(value)));
	};
	$tx.extend(Hash.prototype, /** @lends Hash.prototype */{
		_each: function(iterator) {
			for (var key in this) {
				var value = this[key];
				if (value && value == Hash.prototype[key]) 
					continue;
				var pair = [key, value];
				pair.key = key;
				pair.value = value;
				iterator(pair);
			}
		},
		/**
		 * Hash의 key 값을 배열로 반환한다.
		 * @function
		 */
		keys: function() {
			return this.pluck('key');
		},
		/**
		 * Hash의 value 값을 배열로 반환한다.
		 * @function
		 */
		values: function() {
			return this.pluck('value');
		},
		/**
		 * hash와 전달된 다른 hash를 조합하고 새로운 결과 hash를 반환
		 * @function
		 */
		merge: function(hash) {
			return $H(hash).inject(this, function(mergedHash, pair) {
				mergedHash[pair.key] = pair.value;
				return mergedHash;
			});
		},
		/**
		 * 요소를 제거한다.
		 * @function
		 */
		remove: function() {
			var result;
			for (var i = 0, length = arguments.length; i < length; i++) {
				var value = this[arguments[i]];
				if (value !== undefined) {
					if (result === undefined) 
						result = value;
					else {
						if (result.constructor != Array) 
							result = [result];
						result.push(value);
					}
				}
				delete this[arguments[i]];
			}
			return result;
		},
		/**
		 * Hash 요소를 query string 으로 만들어서 반환한다.
		 * @function
		 */
		toQueryString: function() {
			return Hash.toQueryString(this);
		},
		/**
		 * key:value쌍을 가진 hash의 포맷팅된 문자열 표현을 반환하기 위해 변경(오버라이드)
		 * @function
		 */
		inspect: function() {
			return '#<Hash:{' +
			this.map(function(pair) {
				return pair.map(Object.inspect).join(': ');
			}).join(', ') +
			'}>';
		},
		/**
		 * Hash를 json으로 반환한다.
		 * @function
		 */
		toJSON: function() {
			return Hash.toJSON(this);
		}
	});
	/** 
	 * object를 Hash를 만들어 반환한다. 
	 * @name $H
	 * @example 
	 * 	var myHash = $H({'one': 1, 'two': 2, 'three': 3});
	 */
	window.$H = function(object) {
		if (object instanceof Hash) 
			return object;
		return new Hash(object);
	};
})();

// crossbrowser
(function() {
	if (typeof(HTMLElement) != "undefined") {
		HTMLElement.prototype.innerText;
		var hElementProto = HTMLElement.prototype;
		var hElementGrandProto = hElementProto.__proto__ = {
			__proto__: hElementProto.__proto__
		};
		if (HTMLElement.prototype.__defineSetter__) {
			hElementGrandProto.__defineSetter__("innerText", function(sText) {
				this.textContent = sText;
			});
		}
		if (HTMLElement.prototype.__defineGetter__) {
			hElementGrandProto.__defineGetter__("innerText", function() {
				return this.textContent;
			});
		}
	}
	if (typeof(XMLDocument) != "undefined") {
		if (XMLDocument.prototype.__defineGetter__) {
			XMLDocument.prototype.__defineGetter__("xml", function() {
				return (new XMLSerializer()).serializeToString(this);
			});
		}
	}
	if (typeof(Node) != "undefined") {
		if (Node.prototype && Node.prototype.__defineGetter__) {
			Node.prototype.__defineGetter__("xml", function() {
				return (new XMLSerializer()).serializeToString(this);
			});
		}
	}
	//	Simple Implementation of 
	//		setProperty() and selectNodes() and selectSingleNode() 
	//		for FireFox [Mozilla]
	if (typeof(document.implementation) != 'undefined') {
		if (document.implementation.hasFeature("XPath", "3.0")) {
			if (typeof(XMLDocument) != "undefined") {
				XMLDocument.prototype.selectNodes = function(cXPathString, xNode) {
					if (!xNode) {
						xNode = this;
					}
					var defaultNS = this.defaultNS;
					var aItems = this.evaluate(cXPathString, xNode, {
						normalResolver: this.createNSResolver(this.documentElement),
						lookupNamespaceURI: function(prefix) {
							switch (prefix) {
								case "dflt":
									return defaultNS;
								default:
									return this.normalResolver.lookupNamespaceURI(prefix);
							}
						}
					}, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
					var aResult = [];
					for (var i = 0; i < aItems.snapshotLength; i++) {
						aResult[i] = aItems.snapshotItem(i);
					}
					return aResult;
				};
				XMLDocument.prototype.setProperty = function(p, v) {
					if (p == "SelectionNamespaces" && v.indexOf("xmlns:dflt") == 0) {
						this.defaultNS = v.replace(/^.*=\'(.+)\'/, "$1");
					}
				};
				XMLDocument.prototype.defaultNS;
				// prototying the XMLDocument 
				XMLDocument.prototype.selectSingleNode = function(cXPathString, xNode) {
					if (!xNode) {
						xNode = this;
					}
					var xItems = this.selectNodes(cXPathString, xNode);
					if (xItems.length > 0) {
						return xItems[0];
					} else {
						return null;
					}
				};
				XMLDocument.prototype.createNode = function(nNodeType, sNodeName, sNameSpace) {
					if (nNodeType == 1) 
						return this.createElementNS(sNameSpace, sNodeName);
					else //Etc Not Use
 
						return null;
				};
			}
			if (typeof(Element) != "undefined") {
				Element.prototype.selectNodes = function(cXPathString) {
					if (this.ownerDocument.selectNodes) {
						return this.ownerDocument.selectNodes(cXPathString, this);
					} else {
						throw "For XML Elements Only";
					}
				};
				// prototying the Element 
				Element.prototype.selectSingleNode = function(cXPathString) {
					if (this.ownerDocument.selectSingleNode) {
						return this.ownerDocument.selectSingleNode(cXPathString, this);
					} else {
						throw "For XML Elements Only";
					}
				};
				Element.prototype.text;
				var elementProto = Element.prototype;
				var elementGrandProto = elementProto.__proto__ = {
					__proto__: elementProto.__proto__
				};
				if (Element.prototype.__defineSetter__) {
					elementGrandProto.__defineSetter__("text", function(text) {
						this.textContent = text;
					});
				}
				if (Element.prototype.__defineGetter__) {
					elementGrandProto.__defineGetter__("text", function() {
						return this.textContent;
					});
				}
			}
		}
	}
})();


/* megascript */
window.tx = {};

function each(a, f) { for(var i=0, l=a.length; i<l; i++) f(a[i]) };

function installHyperscript(namespace, oDocument) {
	each('a big blockquote br b center code dd dl dt div em font form h1 h2 h3 h4 h5 h6 hr img iframe input i li ol option pre p script select small span strike strong style sub sup table tbody td textarea tr ul u'.split(' '),
	    function(label) {
	        namespace[label]=function(){
	            var tag=oDocument.createElement(label);
	            each(arguments, function(arg){ 
	                if(arg.nodeType) {
						tag.appendChild(arg);
					} else if(typeof arg=='string' || typeof arg=='number') {
						if(label == "textarea") {
							if($tx.msie) {
								tag.value+=arg;	
							} else {
								tag.text+=arg;	
							}
						} else {
							tag.innerHTML+=arg;	
						}
					} else if(typeof arg=='array') {
						for(var i=0; i<arg.length; i++) {
							tag.appendChild(arg[i]);
						}
	                } else {
						for(var attr in arg) {
	                        if(attr=='style') {
								for(var sty in arg[attr]) {
									if((sty == 'float' || sty == 'cssFloat')) {
										tag[attr][tag[attr].styleFloat === undefined ? 'cssFloat' : 'styleFloat'] = arg[attr][sty];
									} else {
										tag[attr][sty]=arg[attr][sty];
									}
								}
							} else if(["more", "less", "longDesc"].include(attr)) {	 	// custom attributes
								if (tag.setAttribute) {
									tag.setAttribute(attr, arg[attr]);					
								}
							} else if (["colSpan", "rowSpan", "cellPadding", "cellSpacing"].include(attr)) { // nonstandard attributes
								if (tag.setAttribute) {
									tag.setAttribute(attr, arg[attr]);
								}
							} else {
								if (arg[attr]) {
									tag[attr] = arg[attr];
								}
							}
						}
	                }
	            });
	            return tag;
	        };
	    });	
}
installHyperscript(window.tx, document);
/**
 * Template - Very Very Simple Template Engine
 *  similar prototype.js template engine
 *  add syntax > #{for:name:maxCount:cutCount} template #{/for:name}
 *  add syntax > #{if:name sign value} template #{/if:name}
 */
(function(){
	
	function evaluate(data, tpl) {
		if (!data) {
			return '';
		}
		if (tpl.indexOf("\{if:") > -1) {
			tpl = tpl.replace(/#\{if:([_\w]+)([=><!]+)([_'"\-\w]+)\}([\s\S]*?)#\{\/if:\1\}/gm, function(full, start, sign, value, condtpl){
				if (data[start] == null) {
					return full;
				}
				var _condition = false;
				try {
					sign = ((sign=="=")? "==": sign);
					var _left = "\"" + (data[start] + "").replace(/['"]/g, "") + "\"";
					var _right = "\"" + value.replace(/['"]/g, "") + "\"";
					eval("_condition = (" + _left + sign + _right + ")");
				}catch(e) { _condition = false; }
				if(_condition) {
					return evaluate(data, condtpl);
				} else {
					return "";
				}
			});
		}
		if (tpl.indexOf("\{for:") > -1) {
			tpl = tpl.replace(/#\{for:([_\w]+):?(\d*):?(\d*)\}([\s\S]*?)#\{\/for:\1\}/gm, function(full, start, maxCnt, cutCnt, looptpl) {
				if (!data[start] || !data[start].length) {
					return full;
				}
				var _list = data[start];
				var _listTpl = [];
				maxCnt = !!maxCnt? (isNaN(maxCnt)? _list.length: parseInt(maxCnt)): _list.length;
				cutCnt = !!cutCnt? (isNaN(cutCnt)? 0: parseInt(cutCnt)): 0;
				for (var i = 0, len = Math.min(_list.length, maxCnt); i < len; i++) {
					_listTpl.push(evaluate(_list[i], looptpl));
				}
				return _listTpl.join("").substring(cutCnt);
			});
		}
		return tpl.replace(/#\{([_\w]+)\}/g, function(full, name) {
			if(data[name] != null) {
				return data[name];
			} else {
				return full;
			}
		});
	}
	
	window.Template = function(template) {
		this.template = template;
	};
	
	Template.prototype.evaluate = function(data) {
		return evaluate(data, this.template);
	};
	
	Template.prototype.evaluateToDom = function(data, element) {
		if(typeof(element) === 'string') {
			element = document.getElementById(element);
		}
		element.innerHTML = evaluate(data, this.template);
	};
	
	Template.prototype.evaluateAsDom = function(data, context) {
		var _tmpNode = (context || document).createElement('div');
		_tmpNode.innerHTML = evaluate(data, this.template);
		return _tmpNode.firstChild;
	};

})();
/**
 * DomGetty - Very Very Simple Dom Selector Engine
 * - id : #
 * - class : .
 * - tag : tagname
 */
(function(){
	var m, el, els;
	var filters = {
		'#': function(cnxt, expr){
			if ((m = /(\S*)#(\S+)/.exec(expr)) !== null) {
				var tag = m[1];
				var id = m[2];
				if(!cnxt.getElementById) { //ie
					cnxt = cnxt.ownerDocument;
				}
				if (el = cnxt.getElementById(id)) {
					if (tag.length < 1 || el.nodeName.toLowerCase() == tag) {
						return [el];
					}
				}
			}
			return [];
		},
		'.': function(cnxt, expr){
			if ((m = /(\S*)\.(\S+)/.exec(expr)) !== null) {
				var tag = ((m[1] === "") ? "*" : m[1]);
				var klass = m[2];
				if ((els = cnxt.getElementsByTagName(tag)).length > 0) {
					var results = [];
					for (var i=0; i<els.length; i++) {
						var el = els[i];
						if ( (new RegExp("(^| )" + klass + "($| )")).test(el.className)) {
							results.push(el);
						}
					}
					return results;
				}
			}
			return [];
		},
		'*': function(cnxt, expr){
			if ((els = cnxt.getElementsByTagName(expr)).length > 0) {
				var results = [];
				for (var i=0; i<els.length; i++) {
					results.push(els[i]);
				}
				return results;
			}
			return [];
		}
	};
	
	var match = function(cnxt, expr) {
		if(cnxt.length < 1) {
			return [];
		}
		var fltr;
		if ((f = /(\.|#)/.exec(expr)) !== null) {
			if(filters[f[1]]) {
				fltr = f[1];
			}
		}
		fltr = fltr || "*";
		var results = [];
		for(var i=0; i<cnxt.length; i++) {
			results = results.concat(filters[fltr](cnxt[i], expr));
		} 
		return results;
	}
	
	var collect = function(cnxt, expr) {
		var els = [cnxt];
		var exprs = expr.split(" ");
		for (var j = 0; j < exprs.length; j++) {
			els = match(els, exprs[j]);
		}
		return els;
	}
	
	var DomGetty = function(context, selector, all) {
		all = !!all;
		if ( context.nodeType !== 1 && context.nodeType !== 9 ) {
			return (all? []: null);
		}
		if ( !selector || typeof selector !== "string" ) {
			return (all? []: null);
		}

		var els;
		var mathes = [];
		var exprs = selector.split(",");
		for (var i = 0; i < exprs.length; i++) {
			els = collect(context, exprs[i]);
			if(els && els.length > 0) {
				mathes = mathes.concat(els);
				if(!all) {
					break;
				}
			}
		}
		if(all) {
			return mathes;
		} else {
			return mathes[0];
		} 
	};
 
	/**
	 * Get Element By Css Selector
	 * 
	 * dGetty(element, selector) or dGetty(selector)
	 * ex)
	 *  dGetty(document, "#wrapper div.article")
	 *  dGetty($tx("#wrapper"), "div.article")
	 *  dGetty("#wrapper div.article") -> default document
	 */
	window.dGetty = function() {
		if(arguments.length == 1) {
			if(typeof (arguments[0]) === "string") {
				return DomGetty(document, arguments[0]);
			}
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				return DomGetty(arguments[0], arguments[1]);
			}
		}
		return null;
	};
	
	/**
	 * Get Element List By Css Selector
	 * 
	 * dGetties(element, selector) or dGetties(selector)
	 * ex)
	 *  dGetties(document, "#wrapper div.article")
	 *  dGetties($tx("#wrapper"), "div.article")
	 *  dGetties("#wrapper div.article") -> default document
	 */
	window.dGetties = function() {
		if(arguments.length == 1) {
			if(typeof (arguments[0]) === "string") {
				return DomGetty(document, arguments[0], true);
			}
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				return DomGetty(arguments[0], arguments[1], true);
			}
		}
		return [];
	};
	
})();	

/**
 * DomChecky - Very Very Simple Dom Check Engine By Selector
 * - id : #
 * - class : .
 * - tag : tagname
 */
(function(){
	var m, el, els;
	var filters = {
		'#': function(cnxt, expr){
			if ((m = /(\S*)#(\S+)/.exec(expr)) !== null) {
				var tag = m[1];
				var id = m[2];
				if (tag.length < 1 || cnxt.nodeName.toLowerCase() == tag) {
					if (cnxt.id == id) {
						return true;
					}
				}
			}
			return false;
		},
		'.': function(cnxt, expr){
			if ((m = /(\S*)\.(\S+)/.exec(expr)) !== null) {
				var tag = m[1];
				var klass = m[2];
				if (tag.length < 1 || cnxt.nodeName.toLowerCase() == tag) {
					if (cnxt.className.indexOf(klass) > -1) {
						return true;
					}
				}
			}
			return false;
		},
		'*': function(cnxt, expr){
			var tag = expr;
			if (cnxt.nodeName.toLowerCase() == tag) {
				return true;
			}
			return false;
		}
	};
	
	var check = function(cnxt, expr) {
		var fltr;
		if ((f = /(\.|#)/.exec(expr)) !== null) {
			if(filters[f[1]]) {
				fltr = f[1];
			}
		}
		fltr = fltr || "*";
		return filters[fltr](cnxt, expr);
	}
	
	var DomChecky = function(context, selector) {
		if ( context.nodeType !== 1) {
			return false;
		}

		var found = false;
		var exprs = selector.split(",");
		for (var i = 0; i < exprs.length; i++) {
			found = check(context, exprs[i]);
			if(found) {
				break;
			}
		}
		return found;
	};
	
	/**
	 * Check Element By Css Selector
	 * @returns boolean
	 * 
	 * dChecky(element, selector)
	 * ex)
	 *  dChecky(document, "#wrapper")
	 */
	window.dChecky = function() {
		if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				return DomChecky(arguments[0], arguments[1]);
			}
		}
		return false;
	};

})();
/**
 * XMLGetty - Very Very Simple XML Dom Selector Engine By XPath
 * - xpath
 */
(function(){
	
	var XMLGetty = function(node){
		this.selectSingleNode = function(path) {
			if(!node) {
				return null;
			}
			return node.selectSingleNode(path);
		};
		this.selectNodes = function(path) {
			if(!node) {
				return [];
			}
			return node.selectNodes(path);
		};
		this.getAttributeNode = function(name) {
			if(!node) {
				return null;
			}
			return node.getAttributeNode(name);
		};
		this.hasChildNodes = function() {
			if(!node) {
				return false;
			}
			return node.hasChildNodes();
		};
		this.text = node? (node.textContent || node.text) : null;
		this.type = node? node.nodeType : 0;
		this.name = (node && node.nodeType == 1)? (node.nodeName || "") : "";
		return this;
	};
	
	XMLGetty.prototype = {
		'xText': function(defval){
			defval = defval || "";
			var _val = this.text;
			_val = (_val || "").trim();
			
			if (_val === "") {
				return defval;
			} else {
				if (typeof(defval) === 'number') {
					return (isNaN(_val) ? 0 : parseInt(_val));
				} else if (typeof(defval) === 'boolean') {
					return !!_val;
				} else {
					return _val;
				}
			}
		},
		'xAttr': function(name, defval){
			defval = defval || "";
			var _attr = this.getAttributeNode(name);
			var _val = (!_attr) ? "" : _attr.nodeValue.trim();
			if (_val === "") {
				return defval;
			} else {
				if (typeof(defval) === 'number') {
					return (isNaN(_val) ? 0 : parseInt(_val));
				} else if (typeof(defval) === 'boolean') {
					return !!_val;
				} else {
					return _val;
				}
			}
		},
		'xGet': function(path){
			return xGetty(this, path);
		},
		'xGets': function(path){
			return xGetties(this, path);
		}
	};
	
	var ieXmlParsers = [
		"MSXML2.DOMDocument.6.0",
		"MSXML2.DOMDocument.5.0",
		"MSXML2.DOMDocument.4.0",
		"MSXML4.DOMDocument",
		"MSXML3.DOMDocument",
		"MSXML2.DOMDocument",
		"MSXML.DOMDocument",
		"Microsoft.XmlDom"
	];
	/**
	 * xCreate : Get XML DOM From XML Text
	 * @example
	 * var _xmlDoc = xCreate("<data><name>hopeserver</name></data>");
	 * 
	 * @param {string} text - responseText
	 * @return node 
	 * 			extend function as xText, xAttr, xGet, xGets
	 */
	window.xCreate = function(text) {
		if(!!(window.attachEvent && !window.opera)) {
			var xObj = (function() {
				var _xObj = null;
				for(var i=0; i<ieXmlParsers.length; i++) {
					try {
						_xObj = new ActiveXObject(ieXmlParsers[i]);
					} catch (e) {}
					if(_xObj !== null) {
						return _xObj;
					}
				}
				return null;
			})();
			if(xObj === null){
				return null;
			}
			xObj.async = false;
			xObj.loadXML(text);
			if (xObj.parseError.errorCode !== 0) {
				return null;
			}
			return new XMLGetty(xObj);
		} else {
			var oParser = new DOMParser();
			var xObj = oParser.parseFromString(new String(text), "text/xml");
			return new XMLGetty(xObj);
		}
	};

	/**
	 * xGetty : Get Node By Xpath
	 * @example
	 * var _node = xGetty(node, "/rss/items/title")
	 * 
	 * @param {element} node - node
	 * @param {string} path - xpath expression
	 * 
	 * @return node 
	 * 			node extends function as xText, xAttr, xGet, xGets
	 */
	window.xGetty = function(node, path) {
		if(node === null) {
			return null;
		}
		return new XMLGetty(node.selectSingleNode(path));
	};
	
	/**
	 * xGetties : Get Node List By Xpath
	 * @example
	 * var _nodelist = xGetties(node, "/rss/items/title")
	 * 
	 * @param {element} node - node
	 * @param {string} path - xpath expression
	 * 
	 * @return node array
	 * 			each node extends function as xText, xAttr, xGet, xGets
	 */
	window.xGetties = function(node, path) {
		if(node === null) {
			return [];
		}
		var list = []
		var nodes = node.selectNodes(path);
		for(var i=0, len=nodes.length; i<len; i++) {
			list.push(new XMLGetty(nodes[i]));
		}
		return list;
	};

})();/**
 * DateFormat - date/time formatting class, similar to java.text.SimpleDateFormat
 */
(function(){
	
	var PtrnOfFormat = {
		"yyyy": /(\d{4})/,
		"MM": /(\d{2})/,
		"dd": /(\d{2})/,
		"HH": /(\d{2})/,
		"mm": /(\d{2})/,
		"ss": /(\d{2})/,
		"yy": /(\d{2})/,
		"M": /([0-1]*\d)/,
		"d": /([0-3]*\d)/,
		"EEE": /(일|월|화|수|목|금|토)/
	};
	var DayOfWeek = ['일','월','화','수','목','금','토'];
	
	/**
	 * DateFormat
	 * 
	 * pattern = yyyy-MM-dd HH:mm:ss
	 */
	function DateFormat(pattern) {
		this.pattern = pattern;
	}
	
	DateFormat.prototype = {
		/**
		 * parse(text) : text -> date
		 * Parses text from the beginning of the given string to produce a date. 
		 * ex)
		 *  new DateFormat("yyyy-MM-dd").parse("2009-07-08")
		 */
		parse: function(source) {
			var _map = {};
			this.pattern.replace(/(\w)\1*/g, function(unitPtrn) { 
				if(PtrnOfFormat[unitPtrn]) {
					source = source.replace(PtrnOfFormat[unitPtrn], function(full, unit) {
						_map[unitPtrn] = unit;
						return "";
					});
				}
				return unitPtrn;
			});
			
			return new Date(Date.parse([
				Math.max(1, parseInt(_map['MM'] || _map['M'] || "01", 10)),
				"/",
				Math.max(1, parseInt(_map['dd'] || _map['d'] || "01", 10)),
				"/",
				(_map['yyyy'] || _map['yy'] || new Date().getFullYear()),
				" ",
				_map['HH'] || "00",
				":",
				_map['mm'] || "00",
				":",
				_map['ss'] || "00"
			].join("")));
		},
		/**
		 * format(date) : date -> text
		 * Formats a Date into a date/time string.
		 * ex)
		 *  new DateFormat("yyyy-MM-dd").format(new Date())
		 */
		format: function(date) { 
			return this.pattern.replace("yyyy", date.getFullYear())
				.replace("MM", (date.getMonth() + 1).toPaddedString(2))
				.replace("dd", date.getDate().toPaddedString(2))
				.replace("HH", date.getHours().toPaddedString(2))
				.replace("mm", date.getMinutes().toPaddedString(2))
				.replace("ss", date.getSeconds().toPaddedString(2))
				.replace("yy", date.getYear())
				.replace("M", date.getMonth() + 1)
				.replace("d", date.getDate())
				.replace("EEE", DayOfWeek[date.getDay()]);
		}
	};

	window.DateFormat = DateFormat;

})();
/**
 * Rubber - Very Very Simple Popup Resize Function
 */
(function(){
	
	var __STATUSBAR_SIZE = 16 * 3;
	var __SCROLLBAR_SIZE = 16;

	var getContentWidth = function(docEl) {
		return (docEl.clientWidth == docEl.scrollWidth && docEl.scrollWidth != docEl.offsetWidth) ? docEl.offsetWidth : docEl.scrollWidth;	
	};
	
	var getContentHeight = function(docEl, wrapper) {
		if (wrapper) return wrapper.offsetHeight;
		return (docEl.clientHeight == docEl.scrollHeight && docEl.scrollHeight != docEl.offsetHeight) ? docEl.offsetHeight : docEl.scrollHeight;
	};
		
	var Rubber = function(width) {
		var _win = window.top;
		var _docEl = document.documentElement;
		var _screenHeight = top.screen.availHeight - __STATUSBAR_SIZE;
		
		var _initWidth = width || getContentWidth(_docEl);
		var _initHeight = getContentHeight(_docEl);
		var _shownVerScroll = false;
		
		if(_screenHeight < _initHeight) {
			_initHeight = _screenHeight;
			_win.resizeBy(0, _initHeight - _docEl.clientHeight);
		}
		
		this.resize = function(wrapper) {
			var _horOverflow = (_docEl.clientWidth < _docEl.scrollWidth);

			var _popWidth = _docEl.clientWidth;
			var _popHeight = _docEl.clientHeight;
			var _popLeft = (_win.screenLeft) ? _win.screenLeft : _win.screenX;
			var _popTop = (_win.screenTop) ? _win.screenTop : _win.screenY;

			var _contentWidth = getContentWidth(_docEl);
			var _contentHeight = getContentHeight(_docEl, wrapper);
			
			if (_screenHeight < _contentHeight) { //모니터가 컨텐츠보다 작으면 모니터 크기에 맞춰서
				_win.moveTo(_popLeft - ($tx.msie? 3:0), 0); //창 위치를 옮기고
				if ($tx.msie) {
					document.body.scroll = "yes";
				} 
				_win.resizeBy(0, _screenHeight - _popHeight);

				if(!_shownVerScroll) { // X->O
					//_win.resizeBy(__SCROLLBAR_SIZE, -__SCROLLBAR_SIZE);
					_win.resizeBy(0, -__SCROLLBAR_SIZE);
				}
				_shownVerScroll = true;
			} else { //모니터가 컨텐츠보다 크면 컨텐츠 크기에 맞춰서
				if ($tx.msie) {
					document.body.scroll = "no";
				}
				_win.resizeBy(0, _contentHeight - _popHeight);

				if(_shownVerScroll) { // O->X
					_win.resizeBy(-__SCROLLBAR_SIZE, 0);
				}
				if(_horOverflow) {
					_win.resizeBy(0, -__SCROLLBAR_SIZE);
				}
				_shownVerScroll = false;
			}
		};
	};
 
 	var _rubber;
	window.resizeHeight = function(width, wrapper) {
		if(!_rubber) {
			_rubber = new Rubber(width);
		}
		_rubber.resize(wrapper);
	};

})();
/*!	SWFObject v2.2 <http://code.google.com/p/swfobject/> 
	is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

var swfobject = function() {
	
	var UNDEF = "undefined",
		OBJECT = "object",
		SHOCKWAVE_FLASH = "Shockwave Flash",
		SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
		FLASH_MIME_TYPE = "application/x-shockwave-flash",
		EXPRESS_INSTALL_ID = "SWFObjectExprInst",
		ON_READY_STATE_CHANGE = "onreadystatechange",
		
		win = window,
		doc = document,
		nav = navigator,
		
		plugin = false,
		domLoadFnArr = [main],
		regObjArr = [],
		objIdArr = [],
		listenersArr = [],
		storedAltContent,
		storedAltContentId,
		storedCallbackFn,
		storedCallbackObj,
		isDomLoaded = false,
		isExpressInstallActive = false,
		dynamicStylesheet,
		dynamicStylesheetMedia,
		autoHideShow = true,
	
	/* Centralized function for browser feature detection
		- User agent string detection is only used when no good alternative is possible
		- Is executed directly for optimal performance
	*/	
	ua = function() {
		var w3cdom = typeof doc.getElementById != UNDEF && typeof doc.getElementsByTagName != UNDEF && typeof doc.createElement != UNDEF,
			u = nav.userAgent.toLowerCase(),
			p = nav.platform.toLowerCase(),
			windows = p ? /win/.test(p) : /win/.test(u),
			mac = p ? /mac/.test(p) : /mac/.test(u),
			webkit = /webkit/.test(u) ? parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, // returns either the webkit version or false if not webkit
			ie = !+"\v1", // feature detection based on Andrea Giammarchi's solution: http://webreflection.blogspot.com/2009/01/32-bytes-to-know-if-your-browser-is-ie.html
			playerVersion = [0,0,0],
			d = null;
		if (typeof nav.plugins != UNDEF && typeof nav.plugins[SHOCKWAVE_FLASH] == OBJECT) {
			d = nav.plugins[SHOCKWAVE_FLASH].description;
			if (d && !(typeof nav.mimeTypes != UNDEF && nav.mimeTypes[FLASH_MIME_TYPE] && !nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)) { // navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin indicates whether plug-ins are enabled or disabled in Safari 3+
				plugin = true;
				ie = false; // cascaded feature detection for Internet Explorer
				d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
				playerVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
				playerVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
				playerVersion[2] = /[a-zA-Z]/.test(d) ? parseInt(d.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0;
			}
		}
		else if (typeof win.ActiveXObject != UNDEF) {
			try {
				var a = new ActiveXObject(SHOCKWAVE_FLASH_AX);
				if (a) { // a will return null when ActiveX is disabled
					d = a.GetVariable("$version");
					if (d) {
						ie = true; // cascaded feature detection for Internet Explorer
						d = d.split(" ")[1].split(",");
						playerVersion = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
					}
				}
			}
			catch(e) {}
		}
		return { w3:w3cdom, pv:playerVersion, wk:webkit, ie:ie, win:windows, mac:mac };
	}(),
	
	/* Cross-browser onDomLoad
		- Will fire an event as soon as the DOM of a web page is loaded
		- Internet Explorer workaround based on Diego Perini's solution: http://javascript.nwbox.com/IEContentLoaded/
		- Regular onload serves as fallback
	*/ 
	onDomLoad = function() {
		if (!ua.w3) { return; }
		if ((typeof doc.readyState != UNDEF && doc.readyState == "complete") || (typeof doc.readyState == UNDEF && (doc.getElementsByTagName("body")[0] || doc.body))) { // function is fired after onload, e.g. when script is inserted dynamically 
			callDomLoadFunctions();
		}
		if (!isDomLoaded) {
			if (typeof doc.addEventListener != UNDEF) {
				doc.addEventListener("DOMContentLoaded", callDomLoadFunctions, false);
			}		
			if (ua.ie && ua.win) {
				doc.attachEvent(ON_READY_STATE_CHANGE, function() {
					if (doc.readyState == "complete") {
						doc.detachEvent(ON_READY_STATE_CHANGE, arguments.callee);
						callDomLoadFunctions();
					}
				});
				if (win == top) { // if not inside an iframe
					(function(){
						if (isDomLoaded) { return; }
						try {
							doc.documentElement.doScroll("left");
						}
						catch(e) {
							setTimeout(arguments.callee, 0);
							return;
						}
						callDomLoadFunctions();
					})();
				}
			}
			if (ua.wk) {
				(function(){
					if (isDomLoaded) { return; }
					if (!/loaded|complete/.test(doc.readyState)) {
						setTimeout(arguments.callee, 0);
						return;
					}
					callDomLoadFunctions();
				})();
			}
			addLoadEvent(callDomLoadFunctions);
		}
	}();
	
	function callDomLoadFunctions() {
		if (isDomLoaded) { return; }
		try { // test if we can really add/remove elements to/from the DOM; we don't want to fire it too early
			var t = doc.getElementsByTagName("body")[0].appendChild(createElement("span"));
			t.parentNode.removeChild(t);
		}
		catch (e) { return; }
		isDomLoaded = true;
		var dl = domLoadFnArr.length;
		for (var i = 0; i < dl; i++) {
			domLoadFnArr[i]();
		}
	}
	
	function addDomLoadEvent(fn) {
		if (isDomLoaded) {
			fn();
		}
		else { 
			domLoadFnArr[domLoadFnArr.length] = fn; // Array.push() is only available in IE5.5+
		}
	}
	
	/* Cross-browser onload
		- Based on James Edwards' solution: http://brothercake.com/site/resources/scripts/onload/
		- Will fire an event as soon as a web page including all of its assets are loaded 
	 */
	function addLoadEvent(fn) {
		if (typeof win.addEventListener != UNDEF) {
			win.addEventListener("load", fn, false);
		}
		else if (typeof doc.addEventListener != UNDEF) {
			doc.addEventListener("load", fn, false);
		}
		else if (typeof win.attachEvent != UNDEF) {
			addListener(win, "onload", fn);
		}
		else if (typeof win.onload == "function") {
			var fnOld = win.onload;
			win.onload = function() {
				fnOld();
				fn();
			};
		}
		else {
			win.onload = fn;
		}
	}
	
	/* Main function
		- Will preferably execute onDomLoad, otherwise onload (as a fallback)
	*/
	function main() { 
		if (plugin) {
			testPlayerVersion();
		}
		else {
			matchVersions();
		}
	}
	
	/* Detect the Flash Player version for non-Internet Explorer browsers
		- Detecting the plug-in version via the object element is more precise than using the plugins collection item's description:
		  a. Both release and build numbers can be detected
		  b. Avoid wrong descriptions by corrupt installers provided by Adobe
		  c. Avoid wrong descriptions by multiple Flash Player entries in the plugin Array, caused by incorrect browser imports
		- Disadvantage of this method is that it depends on the availability of the DOM, while the plugins collection is immediately available
	*/
	function testPlayerVersion() {
		var b = doc.getElementsByTagName("body")[0];
		var o = createElement(OBJECT);
		o.setAttribute("type", FLASH_MIME_TYPE);
		var t = b.appendChild(o);
		if (t) {
			var counter = 0;
			(function(){
				if (typeof t.GetVariable != UNDEF) {
					var d = t.GetVariable("$version");
					if (d) {
						d = d.split(" ")[1].split(",");
						ua.pv = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
					}
				}
				else if (counter < 10) {
					counter++;
					setTimeout(arguments.callee, 10);
					return;
				}
				b.removeChild(o);
				t = null;
				matchVersions();
			})();
		}
		else {
			matchVersions();
		}
	}
	
	/* Perform Flash Player and SWF version matching; static publishing only
	*/
	function matchVersions() {
		var rl = regObjArr.length;
		if (rl > 0) {
			for (var i = 0; i < rl; i++) { // for each registered object element
				var id = regObjArr[i].id;
				var cb = regObjArr[i].callbackFn;
				var cbObj = {success:false, id:id};
				if (ua.pv[0] > 0) {
					var obj = getElementById(id);
					if (obj) {
						if (hasPlayerVersion(regObjArr[i].swfVersion) && !(ua.wk && ua.wk < 312)) { // Flash Player version >= published SWF version: Houston, we have a match!
							setVisibility(id, true);
							if (cb) {
								cbObj.success = true;
								cbObj.ref = getObjectById(id);
								cb(cbObj);
							}
						}
						else if (regObjArr[i].expressInstall && canExpressInstall()) { // show the Adobe Express Install dialog if set by the web page author and if supported
							var att = {};
							att.data = regObjArr[i].expressInstall;
							att.width = obj.getAttribute("width") || "0";
							att.height = obj.getAttribute("height") || "0";
							if (obj.getAttribute("class")) { att.styleclass = obj.getAttribute("class"); }
							if (obj.getAttribute("align")) { att.align = obj.getAttribute("align"); }
							// parse HTML object param element's name-value pairs
							var par = {};
							var p = obj.getElementsByTagName("param");
							var pl = p.length;
							for (var j = 0; j < pl; j++) {
								if (p[j].getAttribute("name").toLowerCase() != "movie") {
									par[p[j].getAttribute("name")] = p[j].getAttribute("value");
								}
							}
							showExpressInstall(att, par, id, cb);
						}
						else { // Flash Player and SWF version mismatch or an older Webkit engine that ignores the HTML object element's nested param elements: display alternative content instead of SWF
							displayAltContent(obj);
							if (cb) { cb(cbObj); }
						}
					}
				}
				else {	// if no Flash Player is installed or the fp version cannot be detected we let the HTML object element do its job (either show a SWF or alternative content)
					setVisibility(id, true);
					if (cb) {
						var o = getObjectById(id); // test whether there is an HTML object element or not
						if (o && typeof o.SetVariable != UNDEF) { 
							cbObj.success = true;
							cbObj.ref = o;
						}
						cb(cbObj);
					}
				}
			}
		}
	}
	
	function getObjectById(objectIdStr) {
		var r = null;
		var o = getElementById(objectIdStr);
		if (o && o.nodeName == "OBJECT") {
			if (typeof o.SetVariable != UNDEF) {
				r = o;
			}
			else {
				var n = o.getElementsByTagName(OBJECT)[0];
				if (n) {
					r = n;
				}
			}
		}
		return r;
	}
	
	/* Requirements for Adobe Express Install
		- only one instance can be active at a time
		- fp 6.0.65 or higher
		- Win/Mac OS only
		- no Webkit engines older than version 312
	*/
	function canExpressInstall() {
		return !isExpressInstallActive && hasPlayerVersion("6.0.65") && (ua.win || ua.mac) && !(ua.wk && ua.wk < 312);
	}
	
	/* Show the Adobe Express Install dialog
		- Reference: http://www.adobe.com/cfusion/knowledgebase/index.cfm?id=6a253b75
	*/
	function showExpressInstall(att, par, replaceElemIdStr, callbackFn) {
		isExpressInstallActive = true;
		storedCallbackFn = callbackFn || null;
		storedCallbackObj = {success:false, id:replaceElemIdStr};
		var obj = getElementById(replaceElemIdStr);
		if (obj) {
			if (obj.nodeName == "OBJECT") { // static publishing
				storedAltContent = abstractAltContent(obj);
				storedAltContentId = null;
			}
			else { // dynamic publishing
				storedAltContent = obj;
				storedAltContentId = replaceElemIdStr;
			}
			att.id = EXPRESS_INSTALL_ID;
			if (typeof att.width == UNDEF || (!/%$/.test(att.width) && parseInt(att.width, 10) < 310)) { att.width = "310"; }
			if (typeof att.height == UNDEF || (!/%$/.test(att.height) && parseInt(att.height, 10) < 137)) { att.height = "137"; }
			doc.title = doc.title.slice(0, 47) + " - Flash Player Installation";
			var pt = ua.ie && ua.win ? "ActiveX" : "PlugIn",
				fv = "MMredirectURL=" + win.location.toString().replace(/&/g,"%26") + "&MMplayerType=" + pt + "&MMdoctitle=" + doc.title;
			if (typeof par.flashvars != UNDEF) {
				par.flashvars += "&" + fv;
			}
			else {
				par.flashvars = fv;
			}
			// IE only: when a SWF is loading (AND: not available in cache) wait for the readyState of the object element to become 4 before removing it,
			// because you cannot properly cancel a loading SWF file without breaking browser load references, also obj.onreadystatechange doesn't work
			if (ua.ie && ua.win && obj.readyState != 4) {
				var newObj = createElement("div");
				replaceElemIdStr += "SWFObjectNew";
				newObj.setAttribute("id", replaceElemIdStr);
				obj.parentNode.insertBefore(newObj, obj); // insert placeholder div that will be replaced by the object element that loads expressinstall.swf
				obj.style.display = "none";
				(function(){
					if (obj.readyState == 4) {
						obj.parentNode.removeChild(obj);
					}
					else {
						setTimeout(arguments.callee, 10);
					}
				})();
			}
			createSWF(att, par, replaceElemIdStr);
		}
	}
	
	/* Functions to abstract and display alternative content
	*/
	function displayAltContent(obj) {
		if (ua.ie && ua.win && obj.readyState != 4) {
			// IE only: when a SWF is loading (AND: not available in cache) wait for the readyState of the object element to become 4 before removing it,
			// because you cannot properly cancel a loading SWF file without breaking browser load references, also obj.onreadystatechange doesn't work
			var el = createElement("div");
			obj.parentNode.insertBefore(el, obj); // insert placeholder div that will be replaced by the alternative content
			el.parentNode.replaceChild(abstractAltContent(obj), el);
			obj.style.display = "none";
			(function(){
				if (obj.readyState == 4) {
					obj.parentNode.removeChild(obj);
				}
				else {
					setTimeout(arguments.callee, 10);
				}
			})();
		}
		else {
			obj.parentNode.replaceChild(abstractAltContent(obj), obj);
		}
	} 

	function abstractAltContent(obj) {
		var ac = createElement("div");
		if (ua.win && ua.ie) {
			ac.innerHTML = obj.innerHTML;
		}
		else {
			var nestedObj = obj.getElementsByTagName(OBJECT)[0];
			if (nestedObj) {
				var c = nestedObj.childNodes;
				if (c) {
					var cl = c.length;
					for (var i = 0; i < cl; i++) {
						if (!(c[i].nodeType == 1 && c[i].nodeName == "PARAM") && !(c[i].nodeType == 8)) {
							ac.appendChild(c[i].cloneNode(true));
						}
					}
				}
			}
		}
		return ac;
	}
	
	/* Cross-browser dynamic SWF creation
	*/
	function createSWF(attObj, parObj, id) {
		var r, el = getElementById(id);
		if (ua.wk && ua.wk < 312) { return r; }
		if (el) {
			if (typeof attObj.id == UNDEF) { // if no 'id' is defined for the object element, it will inherit the 'id' from the alternative content
				attObj.id = id;
			}
			if (ua.ie && ua.win) { // Internet Explorer + the HTML object element + W3C DOM methods do not combine: fall back to outerHTML
				var att = "";
				for (var i in attObj) {
					if (attObj[i] != Object.prototype[i]) { // filter out prototype additions from other potential libraries
						if (i.toLowerCase() == "data") {
							parObj.movie = attObj[i];
						}
						else if (i.toLowerCase() == "styleclass") { // 'class' is an ECMA4 reserved keyword
							att += ' class="' + attObj[i] + '"';
						}
						else if (i.toLowerCase() != "classid") {
							att += ' ' + i + '="' + attObj[i] + '"';
						}
					}
				}
				var par = "";
				for (var j in parObj) {
					if (parObj[j] != Object.prototype[j]) { // filter out prototype additions from other potential libraries
						par += '<param name="' + j + '" value="' + parObj[j] + '" />';
					}
				}
				el.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + att + '>' + par + '</object>';
				objIdArr[objIdArr.length] = attObj.id; // stored to fix object 'leaks' on unload (dynamic publishing only)
				r = getElementById(attObj.id);	
			}
			else { // well-behaving browsers
				var o = createElement(OBJECT);
				o.setAttribute("type", FLASH_MIME_TYPE);
				for (var m in attObj) {
					if (attObj[m] != Object.prototype[m]) { // filter out prototype additions from other potential libraries
						if (m.toLowerCase() == "styleclass") { // 'class' is an ECMA4 reserved keyword
							o.setAttribute("class", attObj[m]);
						}
						else if (m.toLowerCase() != "classid") { // filter out IE specific attribute
							o.setAttribute(m, attObj[m]);
						}
					}
				}
				for (var n in parObj) {
					if (parObj[n] != Object.prototype[n] && n.toLowerCase() != "movie") { // filter out prototype additions from other potential libraries and IE specific param element
						createObjParam(o, n, parObj[n]);
					}
				}
				el.parentNode.replaceChild(o, el);
				r = o;
			}
		}
		return r;
	}
	
	function createObjParam(el, pName, pValue) {
		var p = createElement("param");
		p.setAttribute("name", pName);	
		p.setAttribute("value", pValue);
		el.appendChild(p);
	}
	
	/* Cross-browser SWF removal
		- Especially needed to safely and completely remove a SWF in Internet Explorer
	*/
	function removeSWF(id) {
		var obj = getElementById(id);
		if (obj && obj.nodeName == "OBJECT") {
			if (ua.ie && ua.win) {
				obj.style.display = "none";
				(function(){
					if (obj.readyState == 4) {
						removeObjectInIE(id);
					}
					else {
						setTimeout(arguments.callee, 10);
					}
				})();
			}
			else {
				obj.parentNode.removeChild(obj);
			}
		}
	}
	
	function removeObjectInIE(id) {
		var obj = getElementById(id);
		if (obj) {
			for (var i in obj) {
				if (typeof obj[i] == "function") {
					obj[i] = null;
				}
			}
			obj.parentNode.removeChild(obj);
		}
	}
	
	/* Functions to optimize JavaScript compression
	*/
	function getElementById(id) {
		var el = null;
		try {
			el = doc.getElementById(id);
		}
		catch (e) {}
		return el;
	}
	
	function createElement(el) {
		return doc.createElement(el);
	}
	
	/* Updated attachEvent function for Internet Explorer
		- Stores attachEvent information in an Array, so on unload the detachEvent functions can be called to avoid memory leaks
	*/	
	function addListener(target, eventType, fn) {
		target.attachEvent(eventType, fn);
		listenersArr[listenersArr.length] = [target, eventType, fn];
	}
	
	/* Flash Player and SWF content version matching
	*/
	function hasPlayerVersion(rv) {
		var pv = ua.pv, v = rv.split(".");
		v[0] = parseInt(v[0], 10);
		v[1] = parseInt(v[1], 10) || 0; // supports short notation, e.g. "9" instead of "9.0.0"
		v[2] = parseInt(v[2], 10) || 0;
		return (pv[0] > v[0] || (pv[0] == v[0] && pv[1] > v[1]) || (pv[0] == v[0] && pv[1] == v[1] && pv[2] >= v[2])) ? true : false;
	}
	
	/* Cross-browser dynamic CSS creation
		- Based on Bobby van der Sluis' solution: http://www.bobbyvandersluis.com/articles/dynamicCSS.php
	*/	
	function createCSS(sel, decl, media, newStyle) {
		if (ua.ie && ua.mac) { return; }
		var h = doc.getElementsByTagName("head")[0];
		if (!h) { return; } // to also support badly authored HTML pages that lack a head element
		var m = (media && typeof media == "string") ? media : "screen";
		if (newStyle) {
			dynamicStylesheet = null;
			dynamicStylesheetMedia = null;
		}
		if (!dynamicStylesheet || dynamicStylesheetMedia != m) { 
			// create dynamic stylesheet + get a global reference to it
			var s = createElement("style");
			s.setAttribute("type", "text/css");
			s.setAttribute("media", m);
			dynamicStylesheet = h.appendChild(s);
			if (ua.ie && ua.win && typeof doc.styleSheets != UNDEF && doc.styleSheets.length > 0) {
				dynamicStylesheet = doc.styleSheets[doc.styleSheets.length - 1];
			}
			dynamicStylesheetMedia = m;
		}
		// add style rule
		if (ua.ie && ua.win) {
			if (dynamicStylesheet && typeof dynamicStylesheet.addRule == OBJECT) {
				dynamicStylesheet.addRule(sel, decl);
			}
		}
		else {
			if (dynamicStylesheet && typeof doc.createTextNode != UNDEF) {
				dynamicStylesheet.appendChild(doc.createTextNode(sel + " {" + decl + "}"));
			}
		}
	}
	
	function setVisibility(id, isVisible) {
		if (!autoHideShow) { return; }
		var v = isVisible ? "visible" : "hidden";
		if (isDomLoaded && getElementById(id)) {
			getElementById(id).style.visibility = v;
		}
		else {
			createCSS("#" + id, "visibility:" + v);
		}
	}

	/* Filter to avoid XSS attacks
	*/
	function urlEncodeIfNecessary(s) {
		var regex = /[\\\"<>\.;]/;
		var hasBadChars = regex.exec(s) != null;
		return hasBadChars && typeof encodeURIComponent != UNDEF ? encodeURIComponent(s) : s;
	}
	
	/* Release memory to avoid memory leaks caused by closures, fix hanging audio/video threads and force open sockets/NetConnections to disconnect (Internet Explorer only)
	*/
	var cleanup = function() {
		if (ua.ie && ua.win) {
			window.attachEvent("onunload", function() {
				// remove listeners to avoid memory leaks
				var ll = listenersArr.length;
				for (var i = 0; i < ll; i++) {
					listenersArr[i][0].detachEvent(listenersArr[i][1], listenersArr[i][2]);
				}
				// cleanup dynamically embedded objects to fix audio/video threads and force open sockets and NetConnections to disconnect
				var il = objIdArr.length;
				for (var j = 0; j < il; j++) {
					removeSWF(objIdArr[j]);
				}
				// cleanup library's main closures to avoid memory leaks
				for (var k in ua) {
					ua[k] = null;
				}
				ua = null;
				for (var l in swfobject) {
					swfobject[l] = null;
				}
				swfobject = null;
			});
		}
	}();
	
	return {
		/* Public API
			- Reference: http://code.google.com/p/swfobject/wiki/documentation
		*/ 
		registerObject: function(objectIdStr, swfVersionStr, xiSwfUrlStr, callbackFn) {
			if (ua.w3 && objectIdStr && swfVersionStr) {
				var regObj = {};
				regObj.id = objectIdStr;
				regObj.swfVersion = swfVersionStr;
				regObj.expressInstall = xiSwfUrlStr;
				regObj.callbackFn = callbackFn;
				regObjArr[regObjArr.length] = regObj;
				setVisibility(objectIdStr, false);
			}
			else if (callbackFn) {
				callbackFn({success:false, id:objectIdStr});
			}
		},
		
		getObjectById: function(objectIdStr) {
			if (ua.w3) {
				return getObjectById(objectIdStr);
			}
		},
		
		embedSWF: function(swfUrlStr, replaceElemIdStr, widthStr, heightStr, swfVersionStr, xiSwfUrlStr, flashvarsObj, parObj, attObj, callbackFn) {
			var callbackObj = {success:false, id:replaceElemIdStr};
			if (ua.w3 && !(ua.wk && ua.wk < 312) && swfUrlStr && replaceElemIdStr && widthStr && heightStr && swfVersionStr) {
				setVisibility(replaceElemIdStr, false);
				addDomLoadEvent(function() {
					widthStr += ""; // auto-convert to string
					heightStr += "";
					var att = {};
					if (attObj && typeof attObj === OBJECT) {
						for (var i in attObj) { // copy object to avoid the use of references, because web authors often reuse attObj for multiple SWFs
							att[i] = attObj[i];
						}
					}
					att.data = swfUrlStr;
					att.width = widthStr;
					att.height = heightStr;
					var par = {}; 
					if (parObj && typeof parObj === OBJECT) {
						for (var j in parObj) { // copy object to avoid the use of references, because web authors often reuse parObj for multiple SWFs
							par[j] = parObj[j];
						}
					}
					if (flashvarsObj && typeof flashvarsObj === OBJECT) {
						for (var k in flashvarsObj) { // copy object to avoid the use of references, because web authors often reuse flashvarsObj for multiple SWFs
							if (typeof par.flashvars != UNDEF) {
								par.flashvars += "&" + k + "=" + flashvarsObj[k];
							}
							else {
								par.flashvars = k + "=" + flashvarsObj[k];
							}
						}
					}
					if (hasPlayerVersion(swfVersionStr)) { // create SWF
						var obj = createSWF(att, par, replaceElemIdStr);
						if (att.id == replaceElemIdStr) {
							setVisibility(replaceElemIdStr, true);
						}
						callbackObj.success = true;
						callbackObj.ref = obj;
					}
					else if (xiSwfUrlStr && canExpressInstall()) { // show Adobe Express Install
						att.data = xiSwfUrlStr;
						showExpressInstall(att, par, replaceElemIdStr, callbackFn);
						return;
					}
					else { // show alternative content
						setVisibility(replaceElemIdStr, true);
					}
					if (callbackFn) { callbackFn(callbackObj); }
				});
			}
			else if (callbackFn) { callbackFn(callbackObj);	}
		},
		
		switchOffAutoHideShow: function() {
			autoHideShow = false;
		},
		
		ua: ua,
		
		getFlashPlayerVersion: function() {
			return { major:ua.pv[0], minor:ua.pv[1], release:ua.pv[2] };
		},
		
		hasFlashPlayerVersion: hasPlayerVersion,
		
		createSWF: function(attObj, parObj, replaceElemIdStr) {
			if (ua.w3) {
				return createSWF(attObj, parObj, replaceElemIdStr);
			}
			else {
				return undefined;
			}
		},
		
		showExpressInstall: function(att, par, replaceElemIdStr, callbackFn) {
			if (ua.w3 && canExpressInstall()) {
				showExpressInstall(att, par, replaceElemIdStr, callbackFn);
			}
		},
		
		removeSWF: function(objElemIdStr) {
			if (ua.w3) {
				removeSWF(objElemIdStr);
			}
		},
		
		createCSS: function(selStr, declStr, mediaStr, newStyleBoolean) {
			if (ua.w3) {
				createCSS(selStr, declStr, mediaStr, newStyleBoolean);
			}
		},
		
		addDomLoadEvent: addDomLoadEvent,
		
		addLoadEvent: addLoadEvent,
		
		getQueryParamValue: function(param) {
			var q = doc.location.search || doc.location.hash;
			if (q) {
				if (/\?/.test(q)) { q = q.split("?")[1]; } // strip question mark
				if (param == null) {
					return urlEncodeIfNecessary(q);
				}
				var pairs = q.split("&");
				for (var i = 0; i < pairs.length; i++) {
					if (pairs[i].substring(0, pairs[i].indexOf("=")) == param) {
						return urlEncodeIfNecessary(pairs[i].substring((pairs[i].indexOf("=") + 1)));
					}
				}
			}
			return "";
		},
		
		// For internal usage only
		expressInstallCallback: function() {
			if (isExpressInstallActive) {
				var obj = getElementById(EXPRESS_INSTALL_ID);
				if (obj && storedAltContent) {
					obj.parentNode.replaceChild(storedAltContent, obj);
					if (storedAltContentId) {
						setVisibility(storedAltContentId, true);
						if (ua.ie && ua.win) { storedAltContent.style.display = "block"; }
					}
					if (storedCallbackFn) { storedCallbackFn(storedCallbackObj); }
				}
				isExpressInstallActive = false;
			} 
		}
	};
}();
/**
 * @fileoverview  
 * Trex 정의
 */

/** @namespace */
var Trex = {
	__PAGE_PATH: "http://editor.daum.net/pages/",
	__KEY: {
		ENTER: '13',
		DELETE: '46',
		SPACE: '32',
		BACKSPACE: '8',
		PASTE: '86', //NOTE: + ctrl
		CUT: '88' //NOTE: + ctrl
	},
	I: {},
	X: {},
	define: function(destination, properties) {
		return Object.extend(destination, properties);
	},
	available: function(config, name) {
		if(!$tx("tx_" + name)){
			console.log("Warning: JsObject is existed but element 'tx_" + name + "' is not found.");
			return false;
		}
		if(!config){
			console.log("Warning: no config for" + name);
			return false;
		}
		if(config.use == false) {
			console.log("Warning: config.use == false");
			return false;
		}
		return true;
	},
	getSWF: window.getSWF
};

//oop
(function(Trex){

	function $$reference($instance) {
		var _$ref = $instance;
		while(_$ref.$reference) {
			_$ref = _$ref.$reference;
		}
		return _$ref;
	}
	
	function $$super($instance) {
		var _$superclass = $instance.constructor.superclass;
		if(_$superclass) {
			var _$initbak = _$superclass.prototype.initialize;
			_$superclass.prototype.initialize = function() {
				this.$reference = $instance;
			}; //fake initialize
			var _$superobj = new _$superclass();
			_$superclass.prototype.initialize = _$initbak;
			
			var _wrapFunc = function(name) {
				if(!_$superobj[name]) return null;
				return function() {
					var _arguments = arguments;
					var _$reference = $$reference($instance);
					var _$superbak = _$reference.$super;
					_$reference.$super = _$superobj.$super;
					var _returns = _$superobj[name].apply(_$reference, _arguments);
					_$reference.$super = _$superbak;
					return _returns;
				};
			}
			
			var _$wrapobj = {};
			for(var _name in _$superobj) {
				if(_name.charAt(0) != '$') {
					if (typeof(_$superobj[_name]) == 'function') {
						_$wrapobj[_name] = _wrapFunc(_name);
					}
				}
			}
			$instance.$super = _$wrapobj;
		}
	}
	
	/**
	 * @namespace
	 * @name Trex.Class
	 */
	Trex.Class = /** @lends Trex.Class */ {
		/**
		 * creates class 
		 * @param {Object} properties
		 */
		create: function(properties) {
			var _class = function() {
				var _proto = this.constructor.prototype; //NOTE: Cuz properties must not share
				for(var _name in _proto) {
					if(_proto[_name] && typeof(_proto[_name]) === 'object') {
						if(_proto[_name].constructor == Array) { //Array
							this[_name] = [].concat(_proto[_name]);
						} else {
							this[_name] = Object.extend({}, _proto[_name]);
						}
					}
				}
				$$super(this);
				var _arguments = arguments;
				this.initialize.apply(this, _arguments);
			};
			return Trex.Class.draft(properties, _class);
		},
		draft: function(properties, aClass) {
			var _class = aClass ? 
				aClass : 
				function() {
					$$super(this);
				}; 
			
			if(properties.$const) {
				Object.extend(_class, properties.$const);
			}
			
			if(properties.$extend) {
				Object.extend(_class.prototype, properties.$extend.prototype);
				_class.superclass = properties.$extend;
			}
			
			if(properties.$mixins) {
				var sources = $A(properties.$mixins);
				sources.each(function(source) {
					Object.extend(_class.prototype, source);
				});
			}
			for(var _name in properties) {
				if(_name.charAt(0) != '$') {
					_class.prototype[_name] = properties[_name];
				}
			}
			return _class;
		},
		overwrite: function(source, properties) {
			var _class = source;
			if(_class.prototype) {
				Object.extend(_class.prototype, properties);
			}
			return _class;
		}
	};
	
	/**
	 * @namespace
	 * @name Trex.Faculty, Trex.Mixin
	 */
	Trex.Mixin = Trex.Faculty = /** @lends Trex.Mixin */ {
		/**
		 * Creates  
		 * @param {Object} properties
		 */
		create: function(properties) {
			var _class = {};
			for(var _name in properties) {
				if(properties[_name] && typeof(properties[_name]) === 'object') {
					if(properties[_name].constructor == Array) { //Array
						_class[_name] = [].concat(properties[_name]);
					} else {
						_class[_name] = Object.extend({}, properties[_name]);
					}
				} else {
					_class[_name] = properties[_name];
				}
			}
			return _class;
		},
		toClass: function(properties, initializeFunc) {
			return Trex.Class.create(
				Object.extend({
					initialize: initializeFunc? initializeFunc: function() {}
				}, properties)
			);
		}
	};
})(Trex);

//module
(function(Trex){
	Object.extend(Trex, /** @lends Trex */ {
		installs: [],
		registers: [],
		modules: [],
		modulesX: [],
		/**
		 * Installs component
		 * @param {Object} description
		 * @param {Object} fn
		 */
		install: function(description, fn){
			fn.desc = '[install] ' + description;
			Trex.installs.push(fn);	
		},
		register: function(description, fn){
			fn.desc = '[register] ' + description;
			Trex.registers.push(fn);	
		},
		module: function(description, fn){
			//console.log(' >>> ' + description);
			fn.desc = '[module] ' + description;
			Trex.modules.push(fn);
		},
		moduleX: function(description, fn){
			fn.desc = '[moduleX] ' + description;
			Trex.modulesX.push(fn);
		},
		invoke: function(fns, editor, toolbar, sidebar, canvas, config){
			for(var i=0,len=fns.length; i<len; i++){
				var fn = fns[i];
				if (fn.desc) {
					StopWatch.lap(fn.desc);
				}
				fn(editor, toolbar, sidebar, canvas, config);		
			}
		},
		invokeInstallation: function(editor, toolbar, sidebar, canvas, config){
			Trex.invoke(Trex.installs, editor, toolbar, sidebar, canvas, config);
		},
		invokeRegisters: function(editor, toolbar, sidebar, canvas, config){
			Trex.invoke(Trex.registers, editor, toolbar, sidebar, canvas, config);
		},
		invokeModules: function(editor, toolbar, sidebar, canvas, config){
			Trex.invoke(Trex.modules, editor, toolbar, sidebar, canvas, config);
		},
		group: function(name){
			try{
				console.groupEnd();
				console.group("modules in " + name);
			}catch(e){ }
		},
		groupEnd: function(){
			try{
				console.groupEnd();
			}catch(e){ }
		}
	});
})(Trex);

Trex.MarkupTemplate = {};

(function() {
	var __TEMPLATES = {};
	Trex.define(Trex.MarkupTemplate, {
		add: function(name, template) {
			__TEMPLATES[name] = template;
		},
		get: function(name) {
			if(!__TEMPLATES[name]) {
				return {
					evaluate: function() { return ""; },
					evaluateToDom: function() { return ""; }
				};
			}
			if(typeof(__TEMPLATES[name]) == 'string') {
				var _template = __TEMPLATES[name].replace(/@[\w\.]+/g, function(full) {
					return TXMSG(full);
				});
				__TEMPLATES[name] = new Template(_template);
			}
			return __TEMPLATES[name];
		},
		splitList: function(rows, cols, items){
			var _matrix = { 'row': [] };
			var _total = items.length;
			var _matrix_row = _matrix.row; 
			for(var row=0; row<rows; row++) {
				_matrix_row.push({ 'col': [] });
				var _matrix_col = _matrix_row.last().col;
				for(var col=0; col<cols; col++) {
					var _item = {
						'image': '',
						'data': '&nbsp;',
						'klass': ''
					};
					if(row * cols + col < _total) {
						if(typeof(items[row * cols + col]) == 'string') {
							_item.data = items[row * cols + col];
						} else {
							_item = Object.extend(_item ,items[row * cols + col]);
						}
					}
					_matrix_col.push(_item);
				}
			};
			return _matrix;
		}
	});
})();
/** @namespace */
var $tom = {};

(function() {
	var __TRANSLATIONS = {
		'%body': ['body'],
		'%text': ['#text', 'br'],
		'%element': ['#element'],
		'%control': ['img','object','hr','table','button'], //['input','select','textarea','label','br'],
		'%inline': ['span','font','u','i','b','em','strong','big','small','a','sub','sup','span'],//['tt','dfn','code','samp','kbd','var','cite','abbr','acronym','img','object','br','script','map','q','bdo','input','select','textarea','label','button'], 
		'%block': ['p','div','ul','ol','h1','h2','h3','h4','h5','h6','pre','dl','hr','table','button'], //['noscript','blockquote','form','fieldset','address'], !button
		'%paragraph': ['p','li','dd','dt','h1','h2','h3','h4','h5','h6','td','th','div','caption'], //!button
		'%wrapper': ['div','ul','ol','dl','pre','xmp','table','button'],
		'%innergroup': ['li','dd','dt','td', 'th'],
		'%outergroup': ['ul','ol','dl','tr','tbody','thead','tfoot','table'],
		'%tablegroup': ['td', 'th','tr','tbody','thead','tfoot','table'],
		'%listgroup': ['li','ul','ol'],
		'%datagroup': ['dd','dt','dl'],
		'%listhead': ['ul','ol']
	};
	
	var __TRANSLATIONS_MAP = {}; //for caching
	for(var _ptrn in __TRANSLATIONS) {
		__TRANSLATIONS_MAP[_ptrn] = {};
		if (__TRANSLATIONS[_ptrn]) {
			$A(__TRANSLATIONS[_ptrn]).each(function(tag){
				__TRANSLATIONS_MAP[_ptrn][tag] = true;
			});
		}
	}
	
	function createMap(patterns) {
		var _map = {};
		var _patterns = patterns.split(",");
		_patterns.each(function(pattern) {
			if(__TRANSLATIONS_MAP[pattern]) {
				for(var _part in __TRANSLATIONS_MAP[pattern]) {
					_map[_part] = true;
				}
			} else {
				_map[pattern] = true;
			}
		});
		return _map;
	}
	
	var Translator = Trex.Class.create({
		initialize: function(patterns) {
			this.patterns = patterns;
			this.map = createMap(patterns);
		},
		hasParts: function() {
			return (this.patterns.length > 0);
		},
		include: function(partPtrn) {
			var _partMap = createMap(partPtrn);
			for(var _part in _partMap) {
				if(this.map[_part]) {
					return true;
				}
			}
			return false;
		},
		memberOf: function(wholePtrn) {
			var _wholeMap = createMap(wholePtrn);
			for(var _part in this.map) {
				if(_wholeMap[_part]) {
					return true;
				}
			}
			return false;
		},
		extract: function(wholePtrn) {
			var _wholeMap = createMap(wholePtrn);
			var _matches = [];
			for(var _part in this.map) {
				if(_wholeMap[_part]) {
					_matches.push(_part);
				}
			}
			return $tom.translate(_matches.join(","));
		},
		getExpression: function() {
			if(!this.exprs) {
				var _exprs = [];
				for(var _part in this.map) {
					_exprs.push(_part);
				}
				this.exprs = _exprs.join(",");
			}
			return this.exprs;
		}
	});
	
	var __TRANSLATOR_CACHES = {}; //for caching	
	Object.extend($tom, {
		translate: function(pattern) {
			if(!__TRANSLATOR_CACHES[pattern]) {
				__TRANSLATOR_CACHES[pattern] = new Translator(pattern);
			}
			return __TRANSLATOR_CACHES[pattern];
		}
	});
	
})();

Object.extend($tom, {
	__POSITION: {
		__START_OF_TEXT: -1,
		__MIDDLE_OF_TEXT: 0,
		__END_OF_TEXT: 1
	}
});
	
Object.extend($tom, /** @lends $tom */{
	/**
	 * node가 HTMLElement이면 true를 아니면 false를 반환한다.
	 * @function
	 */
	isElement: function(node) {
		return $tom.kindOf(node, '%element');
	},
	/**
	 * node가 <body> 요소이면 true를 반환한다.
	 * @function
	 */
	isBody: function(node) {
		return $tom.kindOf(node, '%body');
	},
	/**
	 * node가 아래에 나열된 block 요소이면 true 를 반환한다.
	 * 'p','div','ul','ol','h1','h2','h3','h4','h5','h6','pre','dl','hr','table','button'
	 * @function
	 */
	isBlock: function(node) {
		return $tom.kindOf(node, '%block');
	},
	/**
	 * node가 아래에 나열된 요소이면 true 를 반환한다.
	 * 'p','li','dd','dt','h1','h2','h3','h4','h5','h6','td','th','div','caption'
	 * @function
	 */
	isParagraph: function(node) {
		return $tom.kindOf(node, '%paragraph');
	},
	/**
	 * node가 아래에 나열된 inline 요소이면 true 를 반환한다.
	 * 'span','font','u','i','b','em','strong','big','small','a','sub','sup','span'
	 * @function
	 */
	isInline: function(node) {
		if(this.isText(node)) {
			return true;
		}
		return $tom.kindOf(node, '%inline');
	},
	/**
	 * node가 텍스트이거나 <br> 요소이면 true 를 반환한다.
	 * @function
	 */
	isText: function(node) {
		return $tom.kindOf(node, '%text');
	},
	/**
	 * node가 아래에 나열된 요소이면 true를 반환한다.
	 * 'img','object','hr','table','button'
	 * @function
	 */
	isControl: function(node) {
		return $tom.kindOf(node, '%control');
	},
	/**
	 * node의 이름을 반환한다.
	 * @function
	 */
	getName: function(node) {
		return ((node && node.nodeType == 1)? node.nodeName.toLowerCase(): "");
	},
	/**
	 * node의 text content 를 반환한다.
	 * @function
	 */
	getText: function(node) {
		
		return node.textContent || node.text || node.innerText || "";	
	},
	/**
	 * 요소의 nodeType 1이면 child 노드의 길이를, nodeType 3이면 nodeValue의 길이를 반환한다.  
	 * @function
	 */
	getLength: function(node) {
		if(!node) {
			return 0;
		}
		if(node.nodeType == 1) {
			return node.childNodes.length;
		} else if(node.nodeType == 3) {
			return node.nodeValue.length;
		}
		return 0; 
	},
	/**
	 * node가 같은 레벨의 요소 중 몇 번째인지 인덱스값을 반환한다.
	 * @function
	 */
	indexOf: function(node){
		if(!node) {
			return -1;
		}
		var _inx = -1;
		var _pNode = node.parentNode;
		var _cNode = _pNode.firstChild;
		while(_cNode) {
			_inx++;
			if(_cNode == node) {
				break;
			}
			_cNode = _cNode.nextSibling;
		}
		return _inx;
	},
	/**
	 * node가 textNode이면 공백을 제거한 nodeValue의 내용이 존재하면 true를 반환한다.
	 * @function
	 */
	hasContent: function(node, ignoreZWNBS) {
		if(!node || node.nodeType != 3) {
			return true;
		}

		var _text = $tom.removeMeaninglessSpace( node.nodeValue );
		if(ignoreZWNBS) {
			_text = _text.replace(/\ufeff/g, "");
		}
		return (_text != "");
	},
	/**
	 * node의 child가 있으면 true를 반환한다.
	 * @function
	 */
	hasChildren: function(node, ignoreZWNBS) {
		if(!node) {
			return false;
		}
		var _inner = $tom.removeMeaninglessSpace( node.innerHTML );
		if(ignoreZWNBS) {
			_inner = _inner.replace(/\ufeff/g, "");
		}
		if(!_inner) {
			return false;
		}
		if(_inner.stripTags()) {
			return true;
		}
		if(_inner.search(/<br\s?\/?>/i) > -1) {
			return true;
		}
		if(_inner.search(/<span\sid="?tx_(start|end)_marker"?><\/span>/i) > -1) {
			return true;
		}
		return false;
	},
	/**
	 * node에 의미있는 데이터가 있는지 확인한다.
	 * @function
	 */
	hasData: function(node, ignoreStuff) {
		if(!node) {
			return false;
		}
		
		var _inner = '';
		if(node.nodeType == 1) {
			_inner = node.innerHTML;
		} else {
			_inner = node.nodeValue;
		}
		_inner = $tom.removeMeaninglessSpace( _inner );
		if(_inner == '') {
			return false;
		}
		if(_inner.stripTags() != '') {
			return true;
		}
		if(ignoreStuff) {
			return false;
		}
		if(_inner.search(/<br\s?\/?>/i) > -1) {
			return true;
		}
		return false;
	},
	/**
	 * 주어진 스트링에서 의미없는 스페이스를 제거하는 함수.
	 * @function
	 */
	removeMeaninglessSpace: function(str){
		/* /\s/ == /[\f\n\r\t\v\u2028\u2029\u00a0]/ */
		return str.replace(/(^[\f\n\r\t\v\u2028\u2029]*)|([\f\n\r\t\v\u2028\u2029]*$)/g, "");
	}
});	

Object.extend($tom, /** @lends $tom */{
	/**
	 * css selector 로 요소를 찾아서 반환하는데 인자 node의 상위에 있는 요소를 찾는다.
	 * @function
	 * @example
	 *  var _elNode = $tom.find(node, "table.txc-layout-wz");
	 */
	find: function() {
		var _context, _pattern;
		if(arguments.length == 1) {
			if(typeof (arguments[0]) === "string") {
				_context = document;
				_pattern = arguments[0];
			}
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				_context = arguments[0];
				_pattern = arguments[1];
			}
		}
		if(!_pattern) {
			return null;
		}
		var _translator = $tom.translate(_pattern);
		return dFindy(_context, _translator.getExpression());
	},
	/**
	 * css selector 로 요소를 찾아서 반환하는데 인자 node의 하위에 있는 요소를 찾는다.
	 * @function
	 * @example
	 *  var _elInput = $tom.collect(this.elMenu, 'textarea');
	 */
	collect: function() {
		var _context, _pattern;
		if(arguments.length == 1) {
			if(typeof (arguments[0]) === "string") {
				_context = document;
				_pattern = arguments[0];
			}
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				_context = arguments[0];
				_pattern = arguments[1];
			}
		}
		if(!_pattern) {
			return null;
		}
		var _translator = $tom.translate(_pattern);
		return dGetty(_context, _translator.getExpression());
	},
	/**
	 * css selector로 요소를 찾아서 반환하는데 인자 node의 하위에 있는 요소를 찾고 모든 요소를 배열에 담아서 반환한다.
	 * @function
	 * @example
	 *  var _elItemList = $tom.collectAll(this.elMenu, "li a");  
	 */
	collectAll: function() {
		var _context, _pattern;
		if(arguments.length == 1) {
			if(typeof (arguments[0]) === "string") {
				_context = document;
				_pattern = arguments[0];
			}
		} else if(arguments.length == 2) {
			if(arguments[0].nodeType && typeof (arguments[1]) === "string") {
				_context = arguments[0];
				_pattern = arguments[1];
			}
		}
		if(!_pattern) {
			return [];
		}
		var _translator = $tom.translate(_pattern);
		return dGetties(_context, _translator.getExpression());
	}
});	

(function() {
	function makeFilter(pattern) {
		if(pattern) {
			if(typeof(pattern) === 'function') {
				return pattern;
			} else {
				var _translator = $tom.translate(pattern);
				return function(node) {
					if(node.nodeType == 1) {
						if (_translator.include('#element')) {
							return true;
						} else {
							return dChecky(node, _translator.getExpression());
						}
					} else {
						return _translator.include('#text');
					}
				};
			}
		} else {
			return null;
		}
	}
	
	Object.extend($tom, /** @lends $tom */{
		/**
		 * node가 pattern에 맞는 요소이면 true를 반환한다. 
		 * @function
		 * @param node
		 * @param pattern css selector rule
		 * @example
		 *  $tom.kindOf(node, "img.txc-image") // node가 txc-image라는 이름의 class속성을 가진 img 요소이면 true
		 */
		kindOf: function(node, pattern) {
			if(!node || !pattern) {
				return false;
			}
			return makeFilter(pattern)(node);
		},
		/* has filter */
		/**
		 * pattern에 맞는 descendant의 상위요소를 찾아서 반환한다.
		 * @function
		 */
		ancestor: function(descendant, pattern) {
			if(!descendant || !descendant.parentNode) {
				return null;
			}
			var _filter = makeFilter(pattern);
			var _node = descendant.parentNode;
			while(_node) {
				if($tom.isBody(_node)) {
					return null;
				}
				if(!_filter || _filter(_node)) {
					break;
				}
				_node = _node.parentNode;
			}
			return _node;
		}, 
		/**
		 * pattern에 맞는 descendant의 하위요소를 찾아서 반환한다.
		 * @function
		 */
		descendant: function(ancestor, pattern) {
			var _nodes = $tom.descendants(ancestor, pattern, true);
			if(_nodes.length == 0) {
				return null;
			}
			return _nodes[0];
		}, 
		/**
		 * pattern에 맞는 descendant의 모든 하위요소를 찾아서 반환한다.
		 * @function
		 */
		descendants: function(ancestor, pattern, single) {
			single = single || false;
			if(!ancestor || !ancestor.firstChild) {
				return [];
			}
			var _found = false;
			var _filter = makeFilter(pattern);
			var _nodes = [];
			var _gets = function(parent) {
				if(single && _found) {
					return;
				}
				if(!$tom.first(parent)) {
					return;
				}
				var _chilren = $tom.children(parent);
				for(var i=0,len=_chilren.length;i<len;i++) {
					if (!_filter || _filter(_chilren[i])) {
						_nodes.push(_chilren[i]);
						_found = true;
					} else {
						_gets(_chilren[i]);
					}
				}
			}
			_gets(ancestor);
			return _nodes;
		}, 
		/**
		 * node의 자식요소 중 pattern에 맞는 모든 요소를 찾아서 반환한다.
		 * @function
		 */
		children: function(node, pattern) {
			var _nodes = [];
			if(!node || !node.firstChild) {
				return _nodes;
			}
			var _filter = makeFilter(pattern);
			var _node = $tom.first(node);
			while(_node) {
				if (!_filter || _filter(_node)) {
					_nodes.push(_node);
				}
				_node = _node.nextSibling;
			}
			return _nodes;
		},
		/**
		 * node의 nextSibling 요소 중 pattern에 맞는 요소를 찾아서 반환한다.
		 * @function
		 */
		next: function(node, pattern) {
			if(!node || !node.nextSibling) {
				return null;
			}
			var _filter = makeFilter(pattern);
			var _node = node.nextSibling;
			while(_node) {
				if($tom.hasContent(_node)) {
					if(!_filter || _filter(_node)) {
						break;
					}
				}
				_node = _node.nextSibling;
			}
			return _node;
		},
		/**
		 * node의 previousSibling 요소 중 pattern에 맞는 요소를 찾아서 반환한다.
		 * @function
		 */
		previous: function(node, pattern) {
			if(!node || !node.previousSibling) {
				return null;
			}
			var _filter = makeFilter(pattern);
			var _node = node.previousSibling;
			while(_node) {
				if($tom.hasContent(_node)) {
					if(!_filter || _filter(_node)) {
						break;
					}
				}
				_node = _node.previousSibling;
			}
			return _node;
		},
		/**
		 * pattern에 맞는 node의 첫번째 자식요소를 찾아서 반환한다.
		 * @function
		 */
		first: function(node, pattern) {
			if(!node || !node.firstChild) {
				return null;
			}
			var _filter = makeFilter(pattern);
			var _node = node.firstChild;
			while(_node) {
				if($tom.hasContent(_node)) {
					if(!_filter || _filter(_node)) {
						break;
					}
				}
				_node = _node.nextSibling;
			}
			return _node;
		},
		/**
		 * pattern에 맞는 node의 마지막 자식요소를 찾아서 반환한다.
		 * @function
		 */
		last: function(node, pattern) {
			if(!node || !node.lastChild) {
				return null;
			}
			var _filter = makeFilter(pattern);
			var _node = node.lastChild;
			while(_node) {
				if($tom.hasContent(_node)) {
					if(!_filter || _filter(_node)) {
						break;
					}
				}
				_node = _node.previousSibling;
			}
			return _node;
		},
		/**
		 * 
		 * @function
		 */
		extract: function(parent, child, pattern) {
			var _nodes = [];
			if(!parent || !child) {
				return _nodes;
			}
			var _filter = makeFilter(pattern);
			var _found = false;
			var _node = parent.firstChild;
			while(_node) {
				if($tom.include(_node, child)) {
					_found = true;
				}
				if(_filter && _filter(_node)) {
					_nodes.push(_node);
				} else {
					if(_found) {
						break;
					} else {
						_nodes = [];
					}
				}
				_node = _node.nextSibling;
			}
			return _nodes;
		}, 
		/* has no filter */
		/**
		 * node의 parent node를 반환한다.
		 * @function
		 */
		parent: function(node) {
			if(!node || !node.parentNode) {
				return null;
			}
			return node.parentNode;
		}, 
		/**
		 * node를 포함하고 있는 body 요소를 반환한다.
		 * @function
		 */
		body: function(node) {
			if(!node || !node.parentNode) {
				return null;
			}
			var _node = node.parentNode;
			while(_node) {
				if($tom.isBody(_node)) {
					return _node;
				}
				_node = _node.parentNode;
			}
			return null;
		}, 
		/**
		 * ancestor의 하위에서 처음 나오는 텍스트 노드를 찾아서 반환한다. 
		 * @function
		 */
		top: function(ancestor, all) {
			all = all || false;
			var _node = ancestor;
			
			while($tom.first(_node)) {
				_node = $tom.first(_node);
			}
			if(all) {
				return _node;
			} else {
				if ($tom.kindOf(_node, "#tx_start_marker,#tx_end_marker")) {
					_node = _node.nextSibling || _node.parentNode;
				} else if($tom.kindOf(_node, '%control')) {
					_node = _node.parentNode;
				}
				return _node;
			}
		}, 
		/**
		 * ancestor의 하위에서 마지막에 나오는 텍스트 노드를 찾아서 반환한다. 
		 * @function
		 */
		bottom: function(ancestor, all) {
			all = all || false;
			var _node = ancestor;
			while($tom.last(_node)) {
				_node = $tom.last(_node);
			}
			if (all) {
				return _node;
			} else {
				if ($tom.kindOf(_node, "#tx_start_marker,#tx_end_marker")) {
					_node = _node.previousSibling || _node.parentNode;
				} else if ($tom.kindOf(_node, '%control')) {
					_node = _node.parentNode;
				}
				return _node;
			}
		},
		/**
		 * child가 parent에 포함되어 있는 요소이면 true를 반환한다.
		 * @function
		 */
		include: function(parent, child) {
			if(!parent || !child) {
				return false;
			}
			if(parent == child) {
				return true;
			}
			var _node = child;
			while (_node) {
				if ($tom.isBody(_node)) {
					return false;
				} else if (_node == parent) {
					return true;
				}
				_node = _node.parentNode;
			}
			return false;
		}
	});
	
})();



Object.extend($tom, /** @lends $tom */{
	/**
	 * parent요소의 첫번째 자식노드로 child를 삽입한다.
	 * @function
	 */
	insertFirst: function(parent, child) {
		if(!parent || !child) {
			return;
		}
		if (parent.firstChild) {
			parent.insertBefore(child, parent.firstChild);
		} else {
			parent.appendChild(child);
		}
		return child;
	},
	/**
	 * target 요소 전 위치에 source 요소를 삽입한고 source 요소를 반환한다.
	 * @function
	 */
	insertAt: function(source, target) {
		if(!source || !target) {
			return;
		}
		target.parentNode.insertBefore(source, target);
		return source;
	},
	/**
	 * target 요소 다음 위치에 source 요소를 삽입한고 source 요소를 반환한다.
	 * @function
	 */
	insertNext: function(source, target) {
		if(!source || !target) {
			return;
		}
		if (target.nextSibling) {
			target.parentNode.insertBefore(source, target.nextSibling);
		} else {
			target.parentNode.appendChild(source);
		}
		return source;
	},
	/**
	 * parent 요소에 child 요소를 붙인 후 child 요소를 반환한다.
	 * @function
	 */
	append: function(parent, child) {
		if(!parent || !child) {
			return;
		}
		parent.appendChild(child);
		return child;
	},
	/**
	 * node 를 제거한다.
	 * @function
	 */
	remove: function(node) {
		if(!node) {
			return;
		}
		if(node.parentNode) {
			node.parentNode.removeChild(node);
		}
		node = null;
	},
	/**
	 * node의 innerHTML로 html를 넣고 node를 반환한다.
	 * @function
	 */
	html: function(node, html) {
		if(!node) {
			return;
		}
		node.innerHTML = html || "";
		return node;
	},
	/**
	 * node의 내용을 지운다.
	 * @function
	 */
	clean: function(node) {
		return $tom.html(node);
	},
	/**
	 * node안에 해당 html를 채워넣고 node를 반환한다.
	 * @function
	 */
	stuff: function(node, html) {
		if(!node) {
			return node;
		}
		if($tom.hasChildren(node, true)) {
			return node;
		}
		if(node.lastChild) {
			var _node = node;
			while (_node.lastChild) {
				_node = _node.lastChild;
			}
			$tom.insertNext(html, _node);
		} else {
			$tom.append(node, html);
		}
		return node;
	}
});	

Object.extend($tom, /** @lends $tom */{	
	/**
	 * sNode의 자식노드들을 dNode의 child로 삽입 하는데 sInx, eInx는 자식노드의 시작, 끝 인덱스번호다.
	 * @function
	 * @param 
	 */
	moveChild: function(sNode, dNode, sInx, eInx) {
		if(!sNode || !dNode) {
			return;
		}
		sInx = Math.min(Math.max(sInx || 0), sNode.childNodes.length);
		eInx = Math.min(Math.max(eInx || sNode.childNodes.length), sNode.childNodes.length);
		if(sInx >= eInx) {
			return;
		}
		
		var _inx = sInx;
		while (_inx++ < eInx) {
			dNode.appendChild(sNode.childNodes[sInx]);
		}
	},
	/**
	 * node의 자식노드를 node의 부모노드에 붙인다.
	 * @function
	 */
	moveChildToParent: function(node) {
		if(!node) {
			return;
		}
		while (node.firstChild) {
			node.parentNode.insertBefore(node.firstChild, node);
		}
	}
});

/*
 * Create, Destroy, Change
 */
Object.extend($tom, /** @lends $tom */{
	/**
	 * srcNode를 destNode로 교체하고 destNode를 반환한다.
	 * @function
	 */
	replace: function(srcNode, destNode) {
		if (!srcNode || !destNode) {
			return null;
		}
		if ($tom.getName(srcNode) == $tom.getName(destNode)) {
			$tom.remove(destNode);
			return srcNode;
		} else {
			$tom.insertAt(destNode, srcNode);
			$tom.moveChild(srcNode, destNode);
			$tom.remove(srcNode);
			return destNode;
		}
	},
	/**
	 * node를 복사 후 반환한다.
	 * @function
	 */
	clone: function(node, deep) {
		return node.cloneNode(!!deep);
	}
});
	
/*
 * Wrap, Unwrap
 */
Object.extend($tom, /** @lends $tom */{
	/**
	 * wNode 아래에 pNodes를 붙여서 pNodes를 wNode로 감싼다.
	 * @function
	 * @return wNode
	 */
	wrap: function(wNode, pNodes) { //NOTE: quote, quotenodesign, textbox actually using 'div', 'blockquote'
		if (!wNode || !pNodes) {
			return null;
		}
		if(!pNodes.length) {
			pNodes = [].concat(pNodes);
		}
		
		$tom.insertAt(wNode, pNodes[0]);
		pNodes.each((function(pNode){
			$tom.append(wNode, pNode);
		}));
		return wNode;
	},
	/**
	 * node를 제거하고 node의 자식노드는 node의 상위에 붙인다.
	 * @function
	 */
	unwrap: function(node) { 
		if (!node) {
			return null;
		}
		var _nNode = $tom.first(node);
		$tom.moveChildToParent(node);
		$tom.remove(node);
		return _nNode;
	}
});

	
Object.extend($tom, /** @lends $tom */{
	/**
	 * @private
	 * @function
	 */
	divideText: function(node, offset) {
		if(!$tom.isText(node)) {
			return node;
		}
		if(offset <= 0 || offset >= node.length) { //나눌필요가 있을까?
			return node;
		}
		var _newNode = node.cloneNode(false);
		node.deleteData(offset, node.length);
		_newNode.deleteData(0, offset);
		$tom.insertNext(_newNode, node);
		return _newNode;
	},
	/**
	 * @private
	 * @function
	 */
	divideNode: function(node, offset) {
		if(!$tom.isElement(node)) {
			return null;
		}
		/*if(offset <= 0 || offset >= node.childNodes.length) { //나눌필요가 있을까?
			return node;
		}*/
		var _lastOffset = node.childNodes.length - offset;
		var _newNode = node.cloneNode(false);
		for(var i=0;i<_lastOffset;i++) {
			$tom.insertFirst(_newNode, node.lastChild);
		}
		$tom.insertNext(_newNode, node);
		return _newNode;
	},
	/**
	 * @private
	 * @function
	 */
	divideParagraph: function(node) {
		var _node = node;
		var _offset = $tom.indexOf(node);
		
		var _divided = _node;
		while (_node) {
			if ($tom.isBody(_node)) {
				break;
			} else if ($tom.kindOf(_node, 'td,th,%wrapper,%outergroup')) {
				break;
			} else if ($tom.kindOf(_node, "#tx_start_marker,#tx_end_marker")) {
				_offset = $tom.indexOf(_node);
			} else if($tom.isControl(_node)) {
				_offset = $tom.indexOf(_node);
			} else if ($tom.isText(_node)) { //text
				_node = $tom.divideText(_node, _offset);
				_offset = $tom.indexOf(_node);
			} else { //%inline, %paragraph
				_node = $tom.divideNode(_node, _offset);
				_offset = $tom.indexOf(_node);
				_divided = _node;
				if ($tom.kindOf(_node, 'p,li,dd,dt,h1,h2,h3,h4,h5,h6')) {
					break;
				}
			}
			_node = _node.parentNode;
		}
		return _divided;
	},
	/**
	 * @private
	 * @function
	 */
	split: function(node, tag) {
		if(!node) {
			return null;
		}
		var _node = node;
		var _nodes = [_node];
		$A(node.getElementsByTagName(tag)).each(function(separator) {
			if($tom.last(_node) != separator) {
				_node = $tom.divideNode(_node, $tom.indexOf(separator) + 1);
				_nodes.push(_node);
			}
		});
		return _nodes;
	}
});

Object.extend($tom, /** @lends $tom */{
	/**
	 * name의 하위요소로 들어올 요소이름 반환
	 * @function
	 * @example
	 *  $tom.paragraphOf("table") // 'td'를 반환한다.
	 */
	paragraphOf: function(name) {
		if(!name) {
			return 'p';
		}
		var _translator = $tom.translate(name);
		if (_translator.memberOf('ul,ol')) {
			return 'li';
		} else if (_translator.memberOf('dl')) {
			return 'dd';
		} else if (_translator.memberOf('tr,tbody,thead,tfoot,table')) {
			return 'td';
		} else {
			return 'p';
		}
	},
	/**
	 * 'span' 을 반환한다.
	 * @function
	 */
	inlineOf: function() {
		return 'span';
	},
	/**
	 * 요소의 name을 받아서 상위요소가 되는 요소이름을 반환한다.
	 * @function
	 * @example
	 *  $tom.outerOf("td") // "table"을 반환한다.
	 */
	outerOf: function(name) {
		if(!name) {
			return 'span';
		}
		var _translator = $tom.translate(name);
		if (_translator.memberOf('li')) {
			return 'ol';
		} else if (_translator.memberOf('dd,dt')) {
			return 'dl';
		} else if (_translator.memberOf('td,th,tr')) {
			return 'table';
		} else {
			return 'p';
		}
	}
});
	
(function() {
	var __IGNORE_NAME_FLAG = 0;

	var UnitCalculate = Trex.Class.create({
		$const: {
			__FONT_SIZE_BASIS: 9,
			__REG_EXT_NUMBER: new RegExp("[0-9\.]+"),
			__REG_EXT_UNIT: new RegExp("px|pt|em")
		},
		initialize: function() {
			this.unitConverter = { //NOTE: 1em = 9pt
				"px2em": 1 / 12,
				"px2pt": 9 / 12,
				"em2px": 12 / 1,
				"em2pt": 9 / 1,
				"pt2px": 12 / 9,
				"pt2em": 1 / 9
			};
		},
		calculate: function(strA, strB) {
			if (strA == null || strA.length == 0) {
				strA = "0em";
			}
			if (strB == null || strB.length == 0) {
				strB = "0em";
			}
	
			var _sign = this.extractSign(strB);
			
			var _unitA = this.extractUnit(strA);
			var _unitB = this.extractUnit(strB); //NOTE: basis unit
			
			var _numA = this.extractNumber(strA).toNumber();
			var _numB = this.extractNumber(strB).toNumber();
			if(_unitA != _unitB) { //NOTE: different unit
				if(this.unitConverter[_unitA+"2"+_unitB]) {
					_numA *= this.unitConverter[_unitA+"2"+_unitB];
				}
			}
			var _result = 0;
			if(_sign == "-") {
				_result = Math.max(_numA - _numB, 0);
			} else {
				_result = (_numA + _numB);
			} 
			_result = (Math.round(_result*10)/10);
			if (_result == 0) {
				return null;
			} else {
				return _result + _unitB;
			}
		},
		needCalculation: function(str) {
			if(str == null) {
				return false;
			} else {
				return (str.charAt(0) == '+' || str.charAt(0) == '-');
			}
		},
		extractSign: function(str) {
			var _sign = "+";
			var _match;
			if(str.charAt(0) == '+' || str.charAt(0) == '-') {
				_sign = str.charAt(0);
			}
			return _sign;
		},
		extractNumber: function(str) {
			var _num = 0;
			var _match;
			if((_match = str.match(UnitCalculate.__REG_EXT_NUMBER)) != null) {
				_num = _match[0];
			}
			if(str.indexOf("%") > -1) { //NOTE: %
				_num = _num / 100;
			}
			return _num;
		},
		extractUnit: function(str) {
			var _unit = "em";
			var _match;
			if((_match = str.match(UnitCalculate.__REG_EXT_UNIT)) != null) {
				_unit = _match[0];
			}
			return _unit;
		}
	});
	var _unitCalculator = new UnitCalculate();
	
	var __ATTRIBUTE_TRANSLATIONS = {
	    colspan:   "colSpan",
	    rowspan:   "rowSpan",
	    valign:    "vAlign",
	    datetime:  "dateTime",
	    accesskey: "accessKey",
	    tabindex:  "tabIndex",
	    enctype:   "encType",
	    maxlength: "maxLength",
	    readonly:  "readOnly",
	    longdesc:  "longDesc"
	};
	
	Object.extend($tom, /** @lends $tom */{ //TODO:
		/**
		 * node에 인자로 받은 attributes 속성을 세팅한다.
		 * @function
		 * @param {Element} node
		 * @param {JSON} attributes
		 * @example
		 *  $tom.applyAttributes(inNode, {
		 *		'style': { 'fontSize': null },
		 *		'size': null
		 *	});
		 */
		applyAttributes: function(node, attributes) {
			if(!$tom.isElement(node)) {
				return;
			}
			for(var _name in attributes) {
				if(_name == "style") {
					$tom.applyStyles(node, attributes[_name]);
				} else {
					$tom.setAttribute(node, _name, attributes[_name]);
				}
			}
		},
		/**
		 * node에 인자로 받은 attributes 속성을 제거한다.
		 * @function
		 */
		removeAttributes: function(node, attributes) {
			if(!$tom.isElement(node)) {
				return;
			}
			for(var _name in attributes) {
				if(_name == "style") {
					$tom.removeStyles(attributes[_name])
				} else {
					node.removeAttribute(_name, __IGNORE_NAME_FLAG);
				}
			}
		},
		/**
		 * node에 인자로 받은 attributes 속성이 존재하면 true를 반환한다.
		 * @function
		 */
		existAttributes: function(node, attributes) {
			if(!$tom.isElement(node)) {
				return false;
			}
			var _attrValue;
			for(var _name in attributes) {
				if(_name == "style") {
					for(var _style in attributes[_name]) {
						_attrValue = node.style[_style];
						return (_attrValue != null && _attrValue.length > 0);
					}
				} else {
					_attrValue = node[_name];
					return (_attrValue != null && _attrValue.length > 0);
				}
			}
			return false;
		},
		/**
		 * node에서 attrName을 이름으로 갖는 속성의 값을 반환
		 * @function
		 * @example
		 *  $tx("tx_image").getAttribute("class") // class속성의 값 반환
		 */
		getAttribute: function(node, attrName) {
			if(!$tom.isElement(node)) {
				return null;
			}
			if(node && node.getAttribute) {
				return node.getAttribute(__ATTRIBUTE_TRANSLATIONS[attrName] || attrName);
			} else {
				return null;
			}
		},
		/**
		 * node에 attrName를 이름으로, attrValue를 값으로 갖는 속성을 세팅한다.
		 * @function
		 */
		setAttribute: function(node, attrName, attrValue) {
			if(!$tom.isElement(node)) {
				return;
			}
			if(attrValue == null || attrValue.length == 0 || attrValue == 0) {
				node.removeAttribute(attrName, __IGNORE_NAME_FLAG);
			} else {
				try {
					node[attrName] = attrValue;
				} catch(e) {
					node.setAttribute(__ATTRIBUTE_TRANSLATIONS[attrName] || attrName, attrValue);
				}
			}
		},
		/**
		 * node에 styles에서 지정한 스타일을 적용한다.
		 * @function
		 * @example
		 *  $tom.applyStyles(node, {
		 * 		'width': width
		 *  });
		 */
		applyStyles: function(node, styles) {
			var _styleValue;
			for(var _name in styles) {
				if(_unitCalculator.needCalculation(styles[_name])) {
					_styleValue = _unitCalculator.calculate(node.style[_name], styles[_name]);
				} else {
					_styleValue = styles[_name];
				}
				if(_styleValue == null || _styleValue.length == 0) {
					_styleValue = null;
				}
				node.style[((_name == 'float')? ((node.style.styleFloat === undefined)? 'cssFloat': 'styleFloat'): _name)] = _styleValue;
			}
			var _attrValue = $tom.getAttribute(node, "style");
			if(_attrValue == null) { //NOTE: remove needless style 
				node.removeAttribute("style", __IGNORE_NAME_FLAG);
			}
		},
		/**
		 * node에서 styles인자에서 지정한 스타일 속성값을 제거한다. 
		 * @function
		 */
		removeStyles: function(node, styles) {
			for(var _name in styles) {
				node.style[((_name == 'float')? ((node.style.styleFloat === undefined)? 'cssFloat': 'styleFloat'): _name)] = null;
			}
			var _attrValue = $tom.getAttribute(node, "style");
			if(_attrValue == null) { //NOTE: remove needless style 
				node.removeAttribute("style", __IGNORE_NAME_FLAG);
			}
		},
		/**
		 * node에서 style 속성값 텍스트를 모두 반환한다.
		 * @function
		 */
		getStyleText: function(node) {
			return $tom.getAttribute(node, "style");
		},
		/**
		 * node의 style 속성값을 value로 넣는다. 기존에 있는 값은 덮어쓰여진다.
		 * @function
		 * @param {Element} node
		 * @param {String} value style 속성에 바로 세팅할 텍스트 값을 넣어야 함
		 * @example
		 *  $tom.setStyleText($tx("tx_article_category"), "width:50px;height:10px")
		 */
		setStyleText: function(node, value) {
			return $tom.setAttribute(node, "style", value);
		}
	});
})();


Object.extend($tom, /** @lends $tom */{ 
	/**
	 * @private
	 * @function
	 */
	goInto: function(node, toTop) {
		if(!node || !node.scrollIntoView) {
			return;
		}
		node.scrollIntoView(toTop);
	},
	/**
	 * 수직 스크롤 위치값을 반환한다.
	 * @function
	 * @example
	 *  $tom.getScrollTop(document)
	 */
	getScrollTop: function(doc) {
		if(!doc) {
			return 0;
		}
		return (doc.documentElement.scrollTop || doc.body.scrollTop);
	},
	/**
	 * 수직 스크롤 값을 셋팅한다.
	 * @function
	 * @param {Element} doc
	 * @param {Number} scrollTop 수직 스크롤 값
	 */
	setScrollTop: function(doc, scrollTop) {
		if(!doc) {
			return;
		}
		if(doc.documentElement.scrollTop) {
			doc.documentElement.scrollTop = scrollTop;
		} else {
			doc.body.scrollTop = scrollTop;
		}
	},
	/**
	 * 수평 스크롤 위치값을 반환한다.
	 * @function
	 */
	getScrollLeft: function(doc) {
		if(!doc) {
			return 0;
		}
		return (doc.documentElement.scrollLeft || doc.body.scrollLeft);
	},
	/**
	 * 수평 스크롤 값을 셋팅한다.
	 * @function
	 * @param {Element} doc
	 * @param {Number} scrollLeft 수평 스크롤 값
	 */
	setScrollLeft: function(doc, scrollLeft) {
		if(!doc) {
			return;
		}
		if(doc.documentElement.scrollLeft) {
			doc.documentElement.scrollLeft = scrollLeft;
		} else {
			doc.body.scrollLeft = scrollLeft;
		}
	},
	/**
	 * element요소의 left, top, width, height 값을 계산하여 반환한다.
	 * @function
	 * @return {
	 * 		x: 0,
	 * 		y: 0,
	 * 		width: 0,
	 * 		height: 0
	 * 	}
	 */
	getPosition: function(element, cumulative) {
		if(!element) {
			return {
				x: 0,
				y: 0,
				width: 0,
				height: 0
			};
		}
		cumulative = !!cumulative;
		element = $tx(element);
		var pos = (cumulative)? $tx.cumulativeOffset(element): $tx.positionedOffset(element);
		var dim;
		var display = element.style.display;
		if (display != 'none' && display != null) { // Safari bug
			dim = {
				width: element.offsetWidth,
				height: element.offsetHeight
			};
		} else {
			var els = element.style;
			var originalVisibility = els.visibility;
			var originalPosition = els.position;
			var originalDisplay = els.display;
			els.visibility = 'hidden';
			els.position = 'absolute';
			els.display = 'block';
			var originalWidth = element.clientWidth;
			var originalHeight = element.clientHeight;
			els.display = originalDisplay;
			els.position = originalPosition;
			els.visibility = originalVisibility;
			dim = {
				width: originalWidth,
				height: originalHeight
			};
		}
		return {
			x: pos[0],
			y: pos[1],
			width: dim.width,
			height: dim.height
		};
	},
	/**
	 * node 요소의 width값을 반환한다.
	 * @function
	 */
	getWidth: function(node) {
		return (node.style["width"] || node.offsetWidth).parsePx();
	},
	/**
	 * node 요소 스타일속성의 width 값을 세팅한다.
	 * @function
	 */
	setWidth: function(node, width) {
		$tom.applyStyles(node, {
			'width': width
		});
	},
	/**
	 * node 요소의 height값을 반환한다.
	 * @function
	 */
	getHeight: function(node) {
		return (node.style["height"] || node.offsetHeight).parsePx();
	},
	/**
	 * node 요소 스타일속성의 height 값을 세팅한다.
	 * @function
	 */
	setHeight: function(node, height) {
		$tom.applyStyles(node, {
			'height': height
		});
	},
	/**
	 * @private
	 * @function
	 */
	replacePngPath: function(node) {
		if ($tx.msie && $tx.msie_ver < 7) {
			if(document.location.href.indexOf("http://") > -1) {
				return;
			}
			try {
				var _orgFilter = $tx.getStyle(node, 'filter');
				var _orgSrc = /src='([^']+)'/.exec(_orgFilter)[1];
				if(!_orgSrc || _orgSrc == 'none') {
					return;
				} else if(_orgSrc.indexOf("http://") > -1) {
					return;
				}
				
				var _docPathSlices = document.location.href.split("/");
				_docPathSlices.push("css");
				_docPathSlices.pop();
				_orgSrc = _orgSrc.replace(/\.\.\//g, function(full) {
					_docPathSlices.pop();
					return "";
				});
				
				var _newSrc = _docPathSlices.join("/") + "/" + _orgSrc;
				node.style.filter = _orgFilter.replace(/src='([^']+)'/, "src='" + _newSrc + "'");
			} catch(e) {alert(e)}
		}
	}
});
(function utils(Trex){
	/**
	 * @namespace
	 * @name Trex.Util
	 */
	Trex.Util = /** @lends Trex.Util */ {
		_dispElIds: [],
		getDispElId: function() {
			var _genId;
			do {
				_genId = "tx_entry_" + Math.floor(Math.random() * 10000);
			} while(Trex.Util._dispElIds.include(_genId));
			Trex.Util._dispElIds.push(_genId);
			return _genId;
		},
		generateKey: function() {
			return parseInt(Math.random() * 100000000);
		},
		toStyleString: function(styles) {
			var _str = [];
			for(var _name in styles) {
				if(styles[_name]) {
					_str.push(_name.replace(/([A-Z])/g, "-$1").toLowerCase());
					_str.push(":");
					_str.push(styles[_name]);
					_str.push(";");
				}
			}
			return _str.join("");
		},
		toAttrString: function(attrs) {
			var _str = [];
			for(var _name in attrs) {
				if(attrs[_name]) {
					_str.push(" " + _name + "=\"" + attrs[_name] + "\"");
				}
			}
			return _str.join("");
		},
		getMatchValue: function(reg, html, inx) {
			var _matchs;
			if((_matchs = reg.exec(html)) != null) {
				return _matchs[inx];
			} else {
				return null;
			}
		},
		getAttachmentType: function(value){
			value = (value || "").toLowerCase();
			switch(value){
				case 'image/jpg':
				case 'image/jpeg':
				case 'image/png':
				case 'image/tiff':
				case 'image/gif':
				case 'image/bmp':
				case 'image/x-jg':
				case 'image/ief':
				case 'image/pict':
				case 'jpg':
				case 'bmp':
				case 'gif':
				case 'png':
					return 'image';
				default :
					return 'file';
			}
		},
		/**
		 * 확장자에 따는 thumbnail 이미지 url을 가져온다.  
		 * @param {Object} ext
		 */
		thumburl: function(ext) {
			ext = (ext || "").toLowerCase();
			switch (ext) {
				case "doc":
				case "docx":
					return TrexConfig.getIconPath("#iconpath/pn_word.gif?rv=1.0.1");
				case "xls":
				case "xlsx":
					return TrexConfig.getIconPath("#iconpath/pn_xls.gif?rv=1.0.1");
				case "ppt":
				case "pptx":
					return TrexConfig.getIconPath("#iconpath/pn_ppt.gif?rv=1.0.1");
				case "pdf":
					return TrexConfig.getIconPath("#iconpath/pn_pdf.gif?rv=1.0.1");
				case "txt":
					return TrexConfig.getIconPath("#iconpath/pn_txt.gif?rv=1.0.1");
				case "hwp":
					return TrexConfig.getIconPath("#iconpath/pn_hwp.gif?rv=1.0.1");
				case "zip":
				case "alz":
					return TrexConfig.getIconPath("#iconpath/pn_zip.gif?rv=1.0.1");
				case "mp3":
				case "wav":
				case "ogg":
				case "wma":
				case "mp4":
				case "ape":
				case "ra":
				case "ram":
					return TrexConfig.getIconPath("#iconpath/pn_mp3.gif?rv=1.0.1");
				case "avi":
				case "mpeg":
				case "wmv":
				case "asf":
					return TrexConfig.getIconPath("#iconpath/pn_movie.gif?rv=1.0.1");
				case "swf":
					return TrexConfig.getIconPath("#iconpath/pn_swf.gif?rv=1.0.1");
				case "htm" :
				case "html":
					return TrexConfig.getIconPath("#iconpath/pn_html.gif?rv=1.0.1");
				case "jpg":
				case "gif":
				case "png":
				case "bmp":
					TrexConfig.getIconPath("#iconpath/pn_etc.gif?rv=1.0.1");	
				default:
					return TrexConfig.getIconPath("#iconpath/pn_etc.gif?rv=1.0.1");
			}
		},
		/**
		 * 확장자에 따는 preview 이미지 url을 가져온다.  
		 * @param {Object} ext
		 */
		prevurl: function(ext) {
			ext = (ext || "").toLowerCase();
			switch (ext) {
				case "doc":
				case "docx":
					return TrexConfig.getIconPath("#iconpath/p_word_s.gif?rv=1.0.1");
				case "xls":
				case "xlsx":
					return TrexConfig.getIconPath("#iconpath/p_xls_s.gif?rv=1.0.1");
				case "ppt":
				case "pptx":
					return TrexConfig.getIconPath("#iconpath/p_ppt_s.gif?rv=1.0.1");
				case "pdf":
					return TrexConfig.getIconPath("#iconpath/p_pdf_s.gif?rv=1.0.1");
				case "txt":
					return TrexConfig.getIconPath("#iconpath/p_txt_s.gif?rv=1.0.1");
				case "hwp":
					return TrexConfig.getIconPath("#iconpath/p_hwp_s.gif?rv=1.0.1");
				case "zip":
				case "alz":
					return TrexConfig.getIconPath("#iconpath/p_zip_s.gif?rv=1.0.1");
				case "mp3":
				case "wav":
				case "ogg":
				case "wma":
				case "mp4":
				case "ape":
				case "ra":
				case "ram":
					return TrexConfig.getIconPath("#iconpath/p_mp3_s.gif?rv=1.0.1");
				case "avi":
				case "mpeg":
				case "wmv":
				case "asf":
					return TrexConfig.getIconPath("#iconpath/p_movie_s.gif?rv=1.0.1");
				case "swf":
					return TrexConfig.getIconPath("#iconpath/p_swf_s.gif?rv=1.0.1");
				case "htm" :
				case "html":
					return TrexConfig.getIconPath("#iconpath/p_html_s.gif?rv=1.0.1");
				case "jpg":
					return TrexConfig.getIconPath("#iconpath/p_jpg_s.gif?rv=1.0.1");
				case "gif":
					return TrexConfig.getIconPath("#iconpath/p_gif_s.gif?rv=1.0.1");
				case "png":
				case "bmp":
					return TrexConfig.getIconPath("#iconpath/p_png_s.gif?rv=1.0.1");
				default:
					return TrexConfig.getIconPath("#iconpath/p_etc_s.gif?rv=1.0.1");
			}
		},
		getMatchedClassName: function(element, classes){
			var matched = false;
			var _class = "";
			for(var i = 0; i < classes.length; i++){
				_class = classes[i];
				if($tx.hasClassName(element, _class)){
					matched = _class;
					break;
				}
			}
			return matched;
		},	
		getAllAttributesFromEmbed: function(embedSrc){
			var map = {};
			embedSrc = embedSrc.replace(/<embed|>/ig,"");
			try {
				var regSplit = /(\w+)=((?:\")[^\"]+(?:\"|$)|(?:')[^']+(?:'|$)|(?:[^\"'][^ \n]+($| |\n)))/ig;
				while( (result = regSplit.exec(embedSrc)) != null ){
					map[result[1].trim().toLowerCase()] = result[2].replace(/^(\"|')/i,"").replace(/(\"|')$/i,"").trim();
				}
			}catch(e){ }
			
			return map;
		},	
		getAllAttributes: function(source){
			var _map = {};
			var _matchsAttr;
	
			var _reg = new RegExp("style=\"[^\"]*(?:width|WIDTH)\\s*:\\s*([0-9]+)px[^\"]*\"", "g");
			while ((_matchsAttr = _reg.exec(source)) != null) {
				_map["width"] = _matchsAttr[1];
			}
			_reg = new RegExp("style=\"[^\"]*(?:height|HEIGHT)\\s*:\\s*([0-9]+)px[^\"]*\"", "g");
			while ((_matchsAttr = _reg.exec(source)) != null) {
				_map["height"] = _matchsAttr[1];
			}
			_reg = new RegExp("\\s+([a-zA-Z]+)=\"([^\"]*)\"", "g");
			while ((_matchsAttr = _reg.exec(source)) != null) {
				if (!_map[_matchsAttr[1].toLowerCase()]) {
					_map[_matchsAttr[1].toLowerCase()] = _matchsAttr[2];
				}
			}
			_reg = new RegExp("\\s+([a-zA-Z]+)='([^']*)'", "g");
			while ((_matchsAttr = _reg.exec(source)) != null) {
				if (!_map[_matchsAttr[1].toLowerCase()]) {
					_map[_matchsAttr[1].toLowerCase()] = _matchsAttr[2];
				}
			}
			_reg = new RegExp("\\s+([a-zA-Z]+)=([^\\s>]*)", "g");
			while ((_matchsAttr = _reg.exec(source)) != null) {
				if (!_map[_matchsAttr[1].toLowerCase()]) {
					_map[_matchsAttr[1].toLowerCase()] = _matchsAttr[2];
				}
			}
			return _map;
		}
	};
	
	/**
	 * @namespace
	 * @name Trex.HtmlCreator
	 */
	Trex.HtmlCreator = {
		/**
		 * Create Table Markup String
		 * 
		 *  @example
		 *  var items =[ 
		 *  		{
		 *  			klass: 'klassName',
		 *  			image: 'image url', // can be omitted
		 *  			data: 'data'
		 *  		}
		 *  	]
		 *  
		 *	var tableMarkup = Trex.HtmlCreator.createTableMarkup(row, col, item);
		 *   
		 * @param {int} rows
		 * @param {int} cols
		 * @param {Object} items 
		 * 	  
		 */
		createTableMarkup: function(rows, cols, items){
			var _html = [];
			_html.push("<table unselectable=\"on\">");
			_html.push("<tbody>");
			
			var _total = items.length;
			var _item;
			for(var row=0; row<rows; row++) {
				_html.push("<tr>");
				for(var col=0; col<cols; col++) {
					if(row * cols + col < _total) {
						_item = items[row * cols + col];
						if(_item.image) {
							_html.push("<td class=\"tx-menu-list-item\"><a href=\"javascript:;\"><span class=\"" + ((_item.klass)? _item.klass: "") + "\"><img src=\"" + _item.image + "\" data=\"" + _item.data + "\"/></span></a></td>");
						} else {
							_html.push("<td class=\"tx-menu-list-item\"><a href=\"javascript:;\"><span class=\"" + ((_item.klass)? _item.klass: "") + "\">" + _item.data + "</span></a></td>");
						}
					} else {
						_html.push("<td class=\"tx-menu-list-item\"><a href=\"javascript:;\"><span class=\"\">&nbsp;</span></a></td>");
					}
				}
				_html.push("</tr>");
			};
			_html.push("</tbody>");
			_html.push("</table>");
			return _html.join("\n");
		}
	};
	
	Trex.String = {
		escapeQuot: function(str) {
			return str.replace(new RegExp('"', "g"), "&quot;").replace(new RegExp("'", "g"), "&#39;");
		},
		unescapeQuot: function(str) {
			return str.replace(new RegExp("&quot;", "gi"), '"').replace(new RegExp("&#39;", "g"), "'");
		},
		htmlspecialchars: function(str) {
			return Trex.String.escapeQuot(str.replace(new RegExp("&", "g"), "&amp;").replace(new RegExp("<", "g"), "&lt;").replace(new RegExp(">", "g"), "&gt;"));
		},
		unHtmlspecialchars: function(str) {
			return Trex.String.unescapeQuot(str.replace(new RegExp("&amp;", "gi"), "&").replace(new RegExp("&lt;", "gi"), "<").replace(new RegExp("&gt;", "gi"), ">"));
		},	
		parseAttribute: function(elStr, attrName){
			var regAttribute1 = new RegExp("(^|\\W)" + attrName + '="([^"]*)"', "gi");
			var regAttribute2 = new RegExp("(^|\\W)" + attrName + "='([^']*)'", "gi");
			var regAttribute3 = new RegExp("(^|\\W)" + attrName + "=([^\\s>]*)", "gi");
			if (result = regAttribute1.exec(elStr)) {
				return result[2];
			}else if (result = regAttribute2.exec(elStr)) {
				return result[2];
			}else if (result = regAttribute3.exec(elStr)) {
				return result[2];
			}else {
				return "";
			}
		},	
		changeAttribute: function(elStr, attrName, toAttr){
			var regAttribute1 = new RegExp("(^|\\W)" + attrName + '="([^"]*)"', "gi");
			var regAttribute2 = new RegExp("(^|\\W)" + attrName + "='([^']*)'", "gi");
			var regAttribute3 = new RegExp("(^|\\W)" + attrName + "=([^\\s>]*)", "gi");
			var regAttribute4 = new RegExp("<([\\w]+\\s*)", "gi");
			var _exists = false;
			if (elStr.search(regAttribute1) > -1) {
				_exists = true;
				elStr = elStr.replace(regAttribute1, toAttr);
			} 
			if (elStr.search(regAttribute2) > -1) {
				_exists = true;
				elStr = elStr.replace(regAttribute2, toAttr);
			} 
			if (elStr.search(regAttribute3) > -1) {
				_exists = true;
				elStr = elStr.replace(regAttribute3, toAttr);
			} 
			if(!_exists) {
				elStr = elStr.replace(regAttribute4, "<$1" + toAttr + " ");
			}
			return elStr;
		}
	};
	
	/*---- Trex.Validator ------------------------------------------------------*/
	Trex.Validator = Trex.Class.create({
		initialize: function() { },
		strip: function(content) {
			return content.stripTags().replace(/&nbsp;/g, "").replace(/\ufeff/g, "").trim();
		},
		exists: function(content) {
			if(!content) {
				return false;
			}
			if(this.strip(content) == "") {
				if(content.search(/<(img|iframe|embed|table|hr|script|TXDB)/i) < 0) {
					return false;
				}
			}
			return true;
		},
		equals: function(content, text) {
			if(!content || !text) {
				return false;
			}
			if(content.search(/<(img|iframe|embed|table|hr|script|TXDB)/i) < 0) {
				if(this.strip(content) == this.strip(text)) {
					return true;
				}
			}
			return false;
		}
	});
	
	/*---- Trex.Repeater ------------------------------------------------------*/
	Trex.Repeater = Trex.Class.create({
		initialize: function(execHandler) {
			this.execHandler = execHandler;
		},
		start: function(term) {
			if(this.tItv) {
				this.clear();
			}
			this.tItv = window.setInterval(this.onTimer.bind(this), term);
		},
		clear: function() {
			window.clearInterval(this.tItv);
			this.tItv = null;
		},
		onTimer: function() {
			if(this.execHandler != null) {
				this.execHandler();
			}
		}
	});
	
	/*---- Trex.Timer ------------------------------------------------------*/
	Trex.Timer = Trex.Class.create({
		initialize: function(execHandler) {
			this.execHandler = execHandler;
		},
		start: function(term) {
			window.setTimeout(this.onTimer.bind(this), term);
		},
		onTimer: function() {
			if(this.execHandler != null) {
				this.execHandler();
			}
		}
	});
	
	/**
	 * Trex.Paging Class
	 * paging을 위한 class. Ajax나 fileter 등을 통한 dynamic data바인딩은 고려되지 않음. static array로만 사용이 가능 
	 * @class
	 * @param {Array} data
	 * @param {Object} config 
	  */
	Trex.Paging = Trex.Class.create({
		$const:{
			DEFAULT_PAGE_SIZE: 5,
			DEFAULT_BLOCK_SIZE:10
		},
		initialize: function(data, config ){
			this.data = data;
			this.currentpage = config.initPage || 1;
			this.totalrow = config.totalrow || this.getTotalRow();
			this.pagesize = config.pagesize || Trex.Paging.DEFAULT_PAGE_SIZE;
			this.blocksize = config.blocksize || Trex.Paging.DEFAULT_PAGE_SIZE;
			this.totalpage = Math.ceil( this.totalrow / this.pagesize );
			this.totalblock = Math.ceil( this.totalpage / this.blocksize );
		},
		getNextPage: function(){
			return (this.currentpage < this.totalpage)?this.currentpage+1:0;
		},
		getPrevPage: function(){
			return (this.currentpage > 1)?this.currentpage-1:0;
		},
		getNextBlock: function(){
			var _currentblock = Math.ceil(this.currentpage/this.blocksize);
			return ( _currentblock < this.totalblock)?_currentblock * this.blocksize + 1:0
		},
		getPrevBlock: function(){
			var _currentblock = Math.ceil(this.currentpage/this.blocksize);
			return (_currentblock > 1)?(_currentblock-2) * this.blocksize + 1:0;
		},
		getPageList: function(){
			var pages = [];
			var _startBlock = Math.ceil( this.currentpage / this.blocksize ) - 1;
			var _startPage = ( _startBlock * this.blocksize + 1 );
			var _endPage = Math.min( this.totalpage, (_startPage + this.blocksize - 1) );
			for ( var i = _startPage; i <= _endPage; i++ ){
				pages.push(i);
			}
	
			return pages;
		},
		movePage: function( page ){
			this.currentpage = page || this.currentpage;
		},
		getOnePageData: function(){
			var result = [];
			var _start = (this.currentpage-1) * this.pagesize;
			var _end = Math.min( this.currentpage * this.pagesize, this.totalrow ) ;
			for( var i = _start; i < _end; i++ ){
				result.push( this.data[i] ); 
			}
			
			return result;
		},
		getTotalRow: function(){
			return this.data.length;
		}
	});
	
	/**
	 * Trex.Slidebar Class
	 * slidebar 위젯. 마크업, CSS에 의존성이 있다. 
	 * @class
	 * @param {Object} config	 
	  */
	Trex.Slidebar = Trex.Class.create({
		initialize: function(config){
			/* config = { 
			 * 		handler: function, 슬라이드가 동작할때 실행될 함수
			 * 		elContext: 슬라이드가 제어될 영역, div등의 element
			 * 		knoWidth: knob element의 크기
			 * 		barSize: 슬라이드 element의 크기
			 * 		min: 최소값(논리적인 값, default 0)
			 *  	max :최대값(논리적인 값, default 100)
			 *  	interval: 한번 클릭이나 마우스 드래그로 이동하는 값(논리적인 값, default 5)
			 * 		defaultValue: 초기 knob이 위치할 값
			 * }
			 */		
			this.elContext = config.el;
			this.knobWidth =  config.knobWidth;
			this.isDisabled = false;
			this.handler = function(value){
				if (!this.isDisabled && typeof config.handler == "function") {
					config.handler(value);
				}
			}

			config.defaultValue = config.defaultValue || 0;
			this.logicObj = {
				interval: config.interval || 5 ,
				min: config.min || 0,
				max: config.max || 100
			};
			this.physicObj = {
				min:0,
				width: config.barSize || 100	
			};
			this.physicObj.max = this.physicObj.width - this.knobWidth;  
			this.physicObj.interval = this.logicObj.interval * this.physicObj.max / this.logicObj.max;
			
			this.startPos = 0;
			this.startX = 0;
			this.isDrag = false;
			this.result = 0;
			
			var elMenu = $tom.collect( this.elContext, "dd.tx-slide" );
			// 양끝단에 min값과 max값이 표시 될 수도 있다. 
			$tom.collect( elMenu, "span.tx-slide-min" ).innerHTML = ""; 
			$tom.collect( elMenu, "span.tx-slide-max" ).innerHTML = "";
							
			/* default 값 셋팅하는 부분이 필요하다? */
			this.bindEvent();
			this.setKnobPosition(config.defaultValue);
		},
		regenerate: function( value ){
			value = parseInt(value * this.physicObj.width / this.logicObj.max);
			this.setKnobPosition(value);
		},
		bindEvent: function(){
			var elMenu = $tom.collect( this.elContext, "dd.tx-slide" );
			var elPrev = $tom.collect( elMenu, "a.tx-slide-prev" )
			var elNext = $tom.collect( elMenu, "a.tx-slide-next" );
			var elBar = $tom.collect( elMenu, "div.tx-slide-bar" );
			var elKnob = this.elKnob = $tom.collect( elMenu, "div.tx-slide-knob" );
			
			$tx.observe( elKnob, "mousedown", function(ev){
				this.isDrag = true;
				this.startPos = this.getKnobPosition();
				this.startX = ev.clientX;
				$tx.stop(ev);
			}.bind(this));
			
			$tx.observe( elKnob, "mouseup", function(ev){
				this.isDrag = false;
			}.bind(this));
			
			$tx.observe( this.elContext, "mousemove", function(ev){
				if ( this.isDrag ){
					this.setKnobPosition( this.startPos +  ev.clientX - this.startX);
					$tx.stop(ev);
					this.handler( this.result );
				}
			}.bind(this));
			
			$tx.observe( elPrev, "click", function(ev){
				var count = Math.round(this.physicObj.interval) - 1;
				var that = this;
				var moveLeft = function(){
					var pos = that .getKnobPosition();
					that.setKnobPosition( pos - 1);
					if ( count-- > 0 ) {
						setTimeout(moveLeft, 10 );
					}else{
						that.handler(that.result);
					}
				};
				moveLeft();
				$tx.stop(ev);
			}.bind(this));
			
			$tx.observe( elNext, "click", function(ev){
				var count = Math.round(this.physicObj.interval);
				var that = this;
				var moveRight = function(){
					var pos = that.getKnobPosition();
					that.setKnobPosition( pos + 1);
					if ( --count > 0 ) {
						setTimeout(moveRight, 10 );
					}else{
						that.handler(that.result);
					}
				};
				moveRight();
				$tx.stop(ev);
			}.bind(this));
			
			$tx.observe( this.elContext, "mouseup", function(ev){
				if ( this.isDrag ) {
					this.isDrag = false;
				}
			}.bind(this));
			$tx.observe( elKnob, "click", function(ev){
				$tx.stop(ev);
			}.bind(this));
			
			$tx.observe( elBar, "click", function(ev){
				if ( !this.isDrag ) {
					var x = ev.layerX || ev.x;
					this.setKnobPosition( x - this.knobWidth / 2);
					this.handler( this.result );
				}
			}.bind(this));
		},	
		getKnobPosition: function(){
			var pos = $tx.getStyle( this.elKnob, "left");
			return pos.parsePx();
		},
		setKnobPosition: function(value){
			if ( this.isDisabled ){
				return;
			}
			value = (value < this.physicObj.max)?value:this.physicObj.max;
			value = (value > this.physicObj.min)?value:this.physicObj.min;
			$tx.setStyle( this.elKnob, {left: value.toPx()});
			
			this.result = Math.round( value * this.logicObj.interval / this.physicObj.interval );
		},
		setDisable: function(){
			this.isDisabled = true;
		},
		setEnable: function(){
			this.isDisabled = false;
		},
		getDisabled: function(){
			return this.isDisabled;
		}
	});
	
	
	/**
	 * Trex.DynamicSizer Class
	 * table의 가로세로 사이즈를 마우로 제어할 수 있는 위젯. 
	 * @class
	 * @param {Object} config	 
	  */
	Trex.DynamicSizer = Trex.Class.create({
		initialize: function(config){
			/* config = { 
			 * 		el: //다이나믹 사이저가 실릴 영역
			 * 		clickHandler : 클릭됐을때
			 * 		moveHandler: 사이즈가 변경됐을 때
			 */ 
			this.config = config;
			this.wrapper = config.el;
			this.elEventContext = tx.div({className:"tx-dynamic-sizer-context"});
			this.currentSize = {row:0, col:0}
			this.dynamicSizingEnabled = true;
			
			if( !config.moveHandler ){
				config.moveHandler = function(){}
			}
			if( !config.clickHandler ){
				config.clickHandler = function(){}
			}
			
			this.wrapper.appendChild( this.elEventContext );
			this.previewTable = new Trex.DynamicSizer.PreviewTable({
				parentEl: this.elEventContext,
				mouseOverHandler: this.changeSize.bind(this),
				mouseClickHandler: this.selectSize.bind(this)
			});
		},
		clear: function(){
			this.dynamicSizingEnabled = true;
			this.changeSize(0,0);
		},
		changeSize: function(row, col){
			if (this.dynamicSizingEnabled) {
				this.currentSize.row = row;
				this.currentSize.col = col;

				this._changeSelectionSize(row, col);
				this.config.moveHandler(row, col);
			}
		},
		_changeSelectionSize: function(row, col){
			this.previewTable.moveSelectionPos(row, col);
		},
		toggleDynamicSizing: function(){
			this.dynamicSizingEnabled = !this.dynamicSizingEnabled;
			if ( this.dynamicSizingEnabled ){
				this.selection.enableResize();
			}else{
				this.selection.disableResize();
			}
		},
		selectSize:function(ev){
			this.config.clickHandler( ev, this.currentSize);
		},
		getCurruentSize: function(){
			return this.currentSize;
		}
	});
		Trex.DynamicSizer.PreviewTable = Trex.Class.create({
			$const:{
				DEFAULT_TD_STYLE:{
				},
				DEFAULT_TABLE_PROPERTY:{
					cellpadding: "0",
					cellspacing: "1"
				},
				MAX_SIZE: { COL:10, ROW:10 }
			},
			initialize: function(config){
				this.config = config;
				this.elTable = null;
				
				this.elTable = this.generateTable("tx-event");
				this.elSelection = tx.div( {className:"tx-selection"}, this.generateTable("tx-selection") );
				var tablePanel = this.generateTable("tx-panel"); 
				
				this.eventBinding();
				config.parentEl.appendChild( this.elTable );
				config.parentEl.appendChild( this.elSelection );
				config.parentEl.appendChild( tablePanel );
				
				var pos = $tom.getPosition( this.elTable );
				var PROPERTY = Trex.DynamicSizer.PreviewTable.MAX_SIZE;
				this.cellSize = { width: Math.round((pos.width - pos.x) / PROPERTY.COL), 
									height: (pos.height - pos.y) / PROPERTY.ROW }
			},
			generateTable: function(className){
				var tbody = tx.tbody();
				var PROPERTY = Trex.DynamicSizer.PreviewTable;
				for (var i = 0; i < PROPERTY.MAX_SIZE.ROW; i++) {
					var tr = tx.tr();
					for (var j = 0; j < PROPERTY.MAX_SIZE.COL; j++) {
						var td = tx.td(tx.div( {
							style: PROPERTY.DEFAULT_TD_STYLE
						}));
						td = this.setCoordToAttr(td, j+1, i+1);
						tr.appendChild(td);
					}
					tbody.appendChild(tr);
				}
				var table = tx.table(PROPERTY.DEFAULT_TABLE_PROPERTY);
				$tx.addClassName( table, className || "" );
				table.appendChild( tbody );
				return table;
			},
			moveSelectionPos: function(row,col){
				var width = ( col * this.cellSize.width).toPx();
				var height = ( row * this.cellSize.height).toPx();
				$tx.setStyle( this.elSelection, { width: width, height:height } );
			},
			setCoordToAttr: function(element, col, row){
				element.setAttribute("col", col);
				element.setAttribute("row", row);
				return element;
			},
			getCoordFromAttr: function(element){
				return {
					col: element.getAttribute("col") || 0,
					row: element.getAttribute("row") || 0
				}
			},
			eventBinding: function(){
				// 외부에서 받은 event핸들러들로 binding시킴
				this.mouseOverHandler = this.config.mouseOverHandler;
				this.mouseClickHandler = this.config.mouseClickHandler;
				var self = this;
				var _mouseOverHandler = function(ev){
					var element = $tx.element(ev) || {};
					var tagName = (element.tagName || "").toUpperCase();
					if (element && tagName == "TD" ) {
						var coord = self.getCoordFromAttr(element);
						self.mouseOverHandler(coord.row, coord.col);
					}
					$tx.stop(ev);
				}  
				var _mouseClickHandler = function(ev){
					self.mouseClickHandler(ev);
				}
				$tx.observe(this.elTable, "mouseover", _mouseOverHandler);
				$tx.observe(this.elTable, "click", _mouseClickHandler);
			}
		});
})(Trex);

/*---- Trex.ImageScale ------------------------------------------------------*/
Trex.ImageScale = Trex.Class.create({
	initialize: function(data, handler) {
		if(!data.imageurl) {
			return;
		}
		if(data.actualwidth) {
			return;
		}
		var _loadHandler = function(width, height) {
			data.actualwidth = width;
			data.actualheight = height;
			if(handler) {
				handler(width, height);
			}
		};

		setTimeout(function() {
			var _tmpImage = new Image();
			_tmpImage.onerror = function() {
				_tmpImage = null;
			};
			if( _tmpImage.onreadystatechange ) { //IE
				_tmpImage.onreadystatechange = function() {
					if(this.readyState == "complete") {
						_loadHandler(this.width, this.height);
						_tmpImage = null;
					}
				};
			} else {
				_tmpImage.onload = function() {
					_loadHandler(this.width, this.height);
					_tmpImage = null;
				};
			}
			_tmpImage.src = data.imageurl;
		}, 10);
	}
});/**
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
});window.$stop = {};
window.$propagate = {};
/**
 * 에디터에 정의된 custom 이벤트들을 발생시키고 등록된 이벤트 핸들러들을 실행시킨다.
 * custom 이벤트를 발생시키거나 혹은 custom 이벤트 발생시 핸들러를 실행시키기 위해서는 이 클래스를 minxin 받아야 한다. 
 * @class
 */
Trex.I.JobObservable = Trex.Faculty.create(/** @lends Trex.I.JobObservable */{
	/**
	 * @private
	 */
	jobObservers: {},
	/**
	 * custom 이벤트가 발생하는지를 관찰하는 observer를 등록한다.
	 * @param {String} name - custom 이벤트의 이름 
	 * @param {Function} observer - custom 이벤트 발생시 실행될 handler
	 * @example
	 * canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(){alert('canvas의 크기가 변했네요')}) 
	 * cinema.observeJob("cinema_on_paste", function(){alert('영화가 첨부되었네요')}) 
	 */
	observeJob: function(name, observer) {
		if(!this.jobObservers[name]) {
			this.jobObservers[name] = [];
		}
		this.jobObservers[name].push(observer);
	},
	reserveJob: function(name, observer, delay) {
		delay = delay || 500;
		if(!this.jobObservers[name]) {
			this.jobObservers[name] = [];
		}
		var _self = this;
		this.jobObservers[name].push(function() {
			var args = $A(arguments);
			setTimeout(function() {
				observer.apply(_self, args);
			}, delay);
		});
	},
	/**
	 * custom 이벤트를 발생시킨다. 이때 발생시킨 이벤트는 observerJob를 통해 등록된 observer들에게 전파된다.
	 * @param {String} name - custom 이벤트의 이름 
	 * @example
	 * canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(){alert('canvas의 크기가 변했네요')}) 
	 * cinema.observeJob("cinema_on_paste", function(){alert('영화가 첨부되었네요')}) 
	 */
	fireJobs: function(name) {
		var _self = this;
		var args = $A(arguments).slice(1);
		if(!this.jobObservers[name]) {
			return;
		}
		try {
			this.jobObservers[name].each(function(observer) {
				observer.apply(_self, args);
			});
		} catch (e) {
			if(e != $stop) { throw e; }
		}
	}
});

/**
 * 에디터에서 custom key이벤트들을 발생시키고 등록된 이벤트 핸들러들을 실행시킨다.
 * custom key 이벤트를 발생시키거나 혹은 custom key 이벤트 발생시 핸들러를 실행시키기 위해서는 이 클래스를 minxin 받아야 한다. 
 * @class
 */
Trex.I.KeyObservable = Trex.Faculty.create(/** @lends Trex.I.KeyObservable */{
	/**
	 * @private
	 */
	keyObservers: {},
	/**
	 * custom 이벤트가 발생하는지를 관찰하는 observer를 등록한다.
	 * @param {Object} keys - 이벤트가 발생하길 원하는 키의 조합 {ctrlKey:T, altKey:F, shiftKey:T, keyCode:17} 
	 * @param {Function} observer - 해당 이벤트 발생시 실행될 handler
	 * @example
	 * canvas.observeKey({ctrlKey:'T', altKey:'F', keyCode:32}, function(){alert('ctrl + 32키가 눌렸네요.')}) 
	 */
	observeKey: function(keys, observer) {
		var _name = function(keys) {
			return (keys.ctrlKey? 'T': 'F') + (keys.altKey? 'T': 'F') + (keys.shiftKey? 'T': 'F') + "_" + keys.keyCode;
		}(keys);
		if(!this.keyObservers[_name]) {
			this.keyObservers[_name] = [];
		}
		this.keyObservers[_name].push(observer);
	},
	/**
	 * 사용자가 정의한 custom key event를 발생시킨다. 이때 발생시킨 이벤트는 observerKey를 통해 등록된 observer들에게 전파된다.
	 * @param {Object} ev - 사용자가 정의한 key의 pushed 상태 객체
	 * @example
	 * canvas.fireKyes({ctrlKey:'T', altKey:'F', keyCode:32}), function(){alert('영화가 첨부되었네요')}) 
	 */
	fireKeys: function(ev) {
		var _name = function(ev) {
			return (ev.ctrlKey? 'T': 'F') + (ev.altKey? 'T': 'F') + (ev.shiftKey? 'T': 'F') + "_" + ev.keyCode;
		}(ev);
		if(!this.keyObservers[_name]) {
			return;
		}
		var _self = this;
		var _propagation = false;
		try {
			this.keyObservers[_name].each(function(observer) {
				try {
					observer.apply(_self, [ev]);
				} catch (e1) {
					if(e1 == $propagate) { _propagation = true; }
				} 
			});
		} catch (e) {
			if(e != $stop) { throw e; }
		}
		if(!_propagation) {
			try {
				$tx.stop(ev);
			} catch(e){}
		}
	},
	registerKeyEvent: function(el) {
		try {
			$tx.observe(el, 'keydown', this.fireKeys.bind(this), true);
		} catch(e) {}
	}
});

/**
 * 마우스클릭이나 방향키를 이용해 특정 엘리먼트에 포커스가 갔을 경우 등록된 handler를 실행시킨다.  
 * @class
 */
Trex.I.ElementObservable = Trex.Faculty.create(/** @lends Trex.I.ElementObservable */{
	elementObservers: {},
	/**
	 * 선택되길 원하는 element를 등록한다 .
	 * @param {Object} layer - 관찰하기를 원하는 element의 tag name과 class name {tag: 'div', klass: 'txc-textbox'}
	 * @param {Function} observer - 원하는 엘리먼트가 선택되었을때 실행되길 원하는 handler  
	 * @example
	 * canvas.observeElement({tag:'div', klass: 'txc-textbox'}), function(){alert("div.txc-textbox가 선택되었네요.")})
	 */
	observeElement: function(layer, observer) {
		if(layer == null) { //all
			this.observeElement({ tag: "*tx-final-body*"}, observer);
		} else if (layer.length) {
			for (var i = 0; i < layer.length; i++) {
				var item = layer[i];
				this.observeElement(item, observer);
			}
		} else {
			if (!this.elementObservers[layer.tag]) {
				this.elementObservers[layer.tag] = {};
			}
			if (!layer.klass) {
				layer.klass = "*tx-all-class*";
			}
			if (!this.elementObservers[layer.tag][layer.klass]) {
				this.elementObservers[layer.tag][layer.klass] = [];
			}
			this.elementObservers[layer.tag][layer.klass].push(observer);
		}
	},
	/**
	 * 특정 element가 선택되었을때 그 element가 선택되길 기다린 observer들에게 알려준다. 
	 * 해당하는 observer들은 handler를 실행시킨다.
	 * @param {Element} node - 선택된 node
	 * @example
	 * canvas.fireElements(document.body)
	 */
	fireElements: function(node) {
		if(!node) {
			return;
		} 
		var _node = node;
		var args = $A(arguments).slice(1);
		
		var _self = this;
		try {
			if($tom.kindOf(_node, 'img,hr,table,button,iframe')) {
				var _observers = this.collectObserverByElement(_node.nodeName.toLowerCase(), _node.className);
				if(_observers) {
					_observers.each(function(observer) {
						observer.apply(_self, [_node].concat(args));
					});	
				}
			} else {
				while (_node) {
					var _observers = this.collectObserverByElement(_node.nodeName.toLowerCase(), _node.className);
					if(_observers) {
						_observers.each(function(observer) {
							observer.apply(_self, [_node].concat(args));
						});	
					}
					if($tom.isBody(_node)) {
						break;
					}
					_node = $tom.parent(_node);
				}
			}
			
		} catch (e) {
			if(e != $stop) { throw e; }
		}
		this.fireFinally();
	},
	fireFinally: function() {
		var _self = this;
		var args = $A(arguments).slice(1);
		var _observers = this.collectObserverByElement("*tx-final-body*");
		if(_observers) {
			_observers.each(function(observer) {
				observer.apply(_self, [null].concat(args));
			});	
		}
	},
	collectObserverByElement: function(tag, klass) {
		if(!this.elementObservers[tag]) {
			return null;
		}

		var _observers = [];
		klass = klass || "";
		if(klass != "") {
			var _classes = klass.split(" ");
			for(var _klass in this.elementObservers[tag]) {
				if(_classes.include(_klass)) {
					_observers.push(this.elementObservers[tag][_klass]);
				}
			}
		}
		if (this.elementObservers[tag]["*tx-all-class*"]) {
			_observers.push(this.elementObservers[tag]["*tx-all-class*"]);
		}
		return _observers.flatten();
	}
});

Trex.I.MouseoverObservable = Trex.Faculty.create(/** @lends Trex.I.MouseoverObservable */{
	mouseoverObservers: {},
	/**
	 * 선택되길 원하는 element를 등록한다 .
	 * @param {Object} layer - 관찰하기를 원하는 element의 tag name과 class name {tag: 'div', klass: 'txc-textbox'}
	 * @param {Function} observer - 원하는 엘리먼트가 선택되었을때 실행되길 원하는 handler  
	 * @param {Function} observer - 원하는 엘리먼트가 선택되었을때 실행되길 원하는 handler  
	 * @example
	 * canvas.observeElement({tag:'div', klass: 'txc-textbox'}), function(){alert("div.txc-textbox가 선택되었네요.")})
	 */
	observeMouseover: function(selector, successObserver, failObserver) {
		if (!this.mouseoverObservers[selector]) {
			this.mouseoverObservers[selector] = {
				'success': [],
				'fail': [],
				'flag': false
			}	
		}
		this.mouseoverObservers[selector]['success'].push(successObserver);
		if ( failObserver ){
			this.mouseoverObservers[selector]['fail'].push(failObserver);
		}
	},
	fireMouseover: function(node) {
		if(!node) { return;	} 
		var _node = node;
		var _self = this;
		
		try {
			for (var i in this.mouseoverObservers){
				this.mouseoverObservers[i].flag = false;
			}
			while (_node) {
				var _observers = this.collectMouseoverObserver(_node);
				if(_observers.length > 0) {
					var _nodePos = this.getPositionByNode(_node);
					_observers.each(function(observer) {
						observer.apply(_self, [_node, _nodePos]);
					});	
				}
				if($tom.isBody(_node)) {
					break;
				}
				_node = $tom.parent(_node);
			}
		} catch (e) {
			if(e != $stop) { throw e; }
		}
		this.runMouseoverFailHandler();	
	},
	runMouseoverFailHandler: function(){
		var _failHandlers = [];
		for (var i in this.mouseoverObservers){
			if ( !this.mouseoverObservers[i].flag ){
				_failHandlers.push( this.mouseoverObservers[i]['fail'] );
			}
		}
		
		_failHandlers.flatten().each( function(handler){
			handler();
		});
	},
	collectMouseoverObserver: function(node) {
		var _observers = [];
		var klass = node.className || "";
		var tag = node.tagName;
		
		if ( tag ){
			tag = tag.toLowerCase();
			if ( this.mouseoverObservers[tag] ){
				_observers.push( this.mouseoverObservers[tag]['success'] );
				this.mouseoverObservers[tag]['flag'] = true;
			}
		}
		
		if(klass != "") {
			var _classes = klass.split(" ");
			for(var i = 0, len = _classes.length; i < len; i++ ){
				var key = tag + "." + _classes[i];
				if ( this.mouseoverObservers[key] ) {
					_observers.push(this.mouseoverObservers[key]['success']);
					this.mouseoverObservers[key]['flag'] = true;
				}
			}
			
		}
		return _observers.flatten();
	}
});

/*---- Trex.I.Runnable ------------------------------------------------------*/
Trex.I.Runnable = Trex.Faculty.create({
	isRunning: false,
	repeater: null,
	threads: [],
	startThread: function(term) {
		if (this.repeater) {
			this.repeater.clear();
		} else {
			this.repeater = new Trex.Repeater(this.runThread.bind(this));
		}
		this.repeater.start(term);
	},
	stopThread: function() {
		this.repeater.clear();
	},
	runThread: function() {
		if(this.isRunning) {
			return;
		}
		if(this.threads.length > 0) {
			this.isRunning = true;
			(this.threads.shift())();
			this.isRunning = false;
		}
	},
	putThread: function(thread, important) {
		if(important) {
			this.threads.unshift(thread);
		} else {
			this.threads.push(thread);
		}
	}
});Trex.MarkupTemplate.add("blackbox",
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

// Height auto resizing 
function autoResizeHeight( fixedWidth, heightOffset){
	if (typeof fixedWidth == 'number') {
		//fixedWidth += $tx.gecko ? 16 : 0;  
		var __STATUSBAR_SIZE = 50;
		var __SCROLLBAR_SIZE = 30;
		var __ASSUMPTION_MIN_HEIGHT = 300;
		if ( !heightOffset ) heightOffset = 0;
	
		var win = window.top;
		var dl = self.document.documentElement;
	
		var diff = {}, pos = {x:0, y:0};
		var left = (win.screenLeft)?win.screenLeft:win.screenX;
		var top = (win.screenTop)?win.screenTop:win.screenY;
		
		win.resizeTo( fixedWidth, __ASSUMPTION_MIN_HEIGHT);
	
		var contentScreentHeight = (dl.clientHeight == dl.scrollHeight && dl.scrollHeight != dl.offsetHeight )?dl.offsetHeight:dl.scrollHeight;
		var contentScreentWidth = (dl.clientWidth == dl.scrollWidth && dl.scrollWidth != dl.offsetWidth )?dl.offsetWidth:dl.scrollWidth;
		if(contentScreentHeight > dl.clientHeight){
			diff.height = contentScreentHeight - dl.clientHeight;
		}else{ // for chrome -_-
			diff.width = 8;
			diff.height = dl.clientHeight - contentScreentHeight + 35;
		}
		pos.y = Math.min(screen.availHeight - contentScreentHeight - top - __STATUSBAR_SIZE,0) ;
		pos.x = Math.min(screen.availWidth - contentScreentWidth - left - __SCROLLBAR_SIZE,0);
		
		if ( pos.x || pos.y ) {
			if (!$tx.chrome) {
				win.moveBy(pos.x, pos.y);
			} 
			win.resizeTo( fixedWidth, __ASSUMPTION_MIN_HEIGHT );
		}
		setTimeout(function(){
			win.resizeBy(0, diff.height + heightOffset);
		},20)
	} else {
		setTimeout(function(){
			var obj = fixedWidth;
			if(!obj)obj = document.getElementsByTagName('HTML')[0];
			var doc = document.getElementsByTagName('HTML')[0];
			var clientW = doc.clientWidth||doc.scrollWidth;
			var clientH = doc.clientHeight||doc.scrollHeight;
			var offsetW = obj.offsetWidth||obj.scrollWidth;
			var offsetH = obj.offsetHeight||obj.scrollHeight;
			//alert( clientW + " : " + clientH + " / " + offsetW + " : " + offsetH )   
		    var gapWidth = offsetW - clientW ;
		    var gapHeight = offsetH - clientH;
		    if(gapWidth || gapHeight){
		        window.resizeBy(gapWidth,gapHeight);
		    }
		}, 100);
	}
}

function Querystring(query){
	
	this.params = new Object();
	this.get = function(key, defaultValue){
		if (defaultValue == null) {
			defaultValue = null;
		}
		var value = this.params[key];
		if (value == null) {
			value = defaultValue;
		}
		return value;
	};
	this.getUTF8 = function(key, defaultValue){
		if (defaultValue == null) {
			defaultValue = null;
		}
		var value = unescape(this.params[key]);
		if (value == null) {
			value = defaultValue;
		}
	return value;
	};
	
	var qs;
	if (query) {
		qs = query;
	}else {
		qs = location.search.substring(1, location.search.length)
	}
	
	if (qs.length == 0) {
		return;
	}
	
	qs = qs.replace(/\+/g, ' ');
	var args = qs.split('&');
	
	for (var i = 0; i < args.length; i++) {
		var value;
		var pair = args[i].split('=');
		var name = unescape(pair[0]);
		
		if (pair.length == 2) {
			value = pair[1];
		} else {
			value = name;
		}
		this.params[name] = value;
	}
}

var qs = new Querystring();

function closeWindow(){
	completeAttach();
	
	top.opener = self;
	top.close();
	
	var _opener;
	if (opener && !opener.closed) {
		_opener = opener;
	}else{
		_opener = parent.opener;
	}
	if(_opener.Editor) {
		_opener.Editor.focus();	
	} else {
		_opener.focus();
	}
}

function stripTags(str){
	return str.replace(/<\/?[^>]+>/gi, '');
}

function getAttacher(name) {
	return PopupUtil.getOpener().Editor.getSidebar().getAttacher(name);
}

function getEmbeder(name) {
	return PopupUtil.getOpener().Editor.getSidebar().getEmbeder(name);
}

function registerAction(attacher) {
	if(!attacher) {
		return; 
	}
	window.execAttach = attacher.attachHandler;
}

function registerSearch(searcher) {
	if(!searcher) {
		return; 
	}
	window.execSearch = searcher.insertHandler;	
}

function registerEmded(embeder) {
	if(!embeder) {
		return; 
	}
	window.execEmbed = embeder.embedHandler;
}

function modifyResult() {} //For Theme
function completeAttach() {} //For Theme

function existEntry(attacher) {
	if(!attacher) {
		return false; 
	}
	return attacher.existEntry();
}

function getFirstEntryData(attacher) {
	if(!attacher) {
		return false; 
	}
	return attacher.getFirstEntryData();
}
function getAttrOfElement( elementStr, attrName ){
	var regExp = new RegExp(attrName+"=['\"]?([^\"'>]*)[\"' ]","i");
	var result = regExp.exec( elementStr );
	
	if ( result){ 
		return result[1];
	}else{
		return null;
	}
}
function getParamValOfObjectTag( objectStr, paramName ){
	var regExp = new RegExp("<param([^>]*)name=['\"]"+paramName+"['\"]([^>]*)>","gi");
	var result = regExp.exec(objectStr, "gi");
	var value = null;
	
	if ( result ){
		regExp = new RegExp("value=['\"]([^>'\"]*)['\"]", "gi");
		value = regExp.exec( result[0] );
		if ( value ){
			return value[1];
		}
	}
	
	return null;
}
var PopupUtil = {
	getOpener : function(){
		var _opener;
		if(opener && opener.Editor){
			_opener = opener;
		} else if(parent.opener && parent.opener.Editor){
			_opener = parent.opener;
		} else if(opener.opener && opener.opener.Editor){
			_opener = opener.opener;
		}
		return _opener;
	}		
};

function getDateFormat(date, format) {
	date = date ? date.trim() : '';
	if ((date.length != 8) || (date.indexOf('0') == 0)) return '';
	var year = date.substr(0, 4) + (format || '년 ');
	var _m = (date.substr(4, 2).indexOf('0') == 0) ? date.substr(5, 1) : date.substr(4, 2);
	var _d = (date.substr(6, 2).indexOf('0') == 0) ? date.substr(7, 1) : date.substr(6, 2);
	var month = (_m != '0') ? _m + (format || '월 ') : '';
	var day = ( _d != '0') ? (_d + (format ? '' : '일')) : '';
	return year + month + day;
}

function getDashedDateFormat(date) {
	date = date.trim();
	if (date.length != 8 || date.indexOf('00') == 0) return '';
	var yy = removeZero(date.substr(0, 4), '');
	var mm = removeZero(date.substr(4, 2), '-');
	var dd = removeZero(date.substr(6, 2), '-');
	return yy + mm + dd;
}

function removeZero(number, fmt) {
	return (number.indexOf('00') == 0) ? '' : fmt + number;
}

function getYearFormat(date) {
	date = date.trim() || '';
	if (date.length != 8) return "";
	return date.substr(0, 4) + '년 ';
}

function getDayFormat(date) {
	try {
		date = date.trim();
		if (date.length != 8) return date;
		var d = new Date(date.substr(0, 4), date.substr(4, 2) - 1, date.substr(6, 2));
		var dayFormat = ['일', '월', '화', '수', '목', '금', '토'];
		return dayFormat[d.getDay()];
	} catch(e) {}
	return '';
}

function stripBracket(text) {
	var splitText = text.trim().split(',');
	var result = [];
	splitText.each(function(txt) {
		result.push(txt.replace(/\[\[[\w]*\]\]/, ''));
	});
	return result.join(', ');
}

function getFieldJson(name, value) {
	if (value)
		return {name: name, value: value.stripTags()};
	return null;
}
