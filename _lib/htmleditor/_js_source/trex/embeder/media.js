TrexConfig.addTool(
	"media",
	{
		wysiwygonly: true,
		sync: false,
		status: false
	}
);

TrexMessage.addMsg({
	'@media.title': "멀티미디어",
	'@media.prev.url': "#iconpath/spacer2.gif?rv=1.0.1",
	'@media.prev.url.tvpot': "#iconpath/img_multi_tvpot.gif?rv=1.0.1",
	'@media.prev.url.wmp': "#iconpath/spacer2.gif?rv=1.0.1"
});
	
Trex.Tool.Media = Trex.Class.create({
	$const: {
		__Identity: 'media'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _editor = this.editor;
		this.weave.bind(this)(
			new Trex.Button(this.buttonCfg), 
			null,
			function() {
				_editor.getSidebar().getEmbeder("media").execute();
			}
		);
	}
});

TrexConfig.addEmbeder(
	"media",
	{
		wysiwygonly: true,
		useCC: false,
		features: { left:250, top:65, width:440, height:258 },
		popPageUrl: "#host#path/pages/popup/multimedia.html"
	},
	function(root) {
		var _config = root.sidebar.embeder.media; 
		_config.popPageUrl = TrexConfig.getUrl(_config.popPageUrl);
		_config.features = TrexConfig.getPopFeatures(_config.features);
	}
);

(function() {

	Trex.Embeder.Media = Trex.Class.create({
		$const: {
			__Identity: 'media'
		},
		$extend: Trex.Embeder,
		name: 'media',
		title: TXMSG("@media.title"),
		canResized: true,
		getCreatedHtml: function(data, kind){
			var _source = data.code || makeSourceByUrl(data.url);
			return convertToHtml(_source);
		},
		getDataForEntry: function(data, kind){
			//This function is not needed anymore but absence may generate initializing error. So remained...
		}
	});
	
	Trex.register("filter > media ", function(editor, toolbar, sidebar, canvas, config){
	
		editor.getDocParser().registerFilter('filter/embeder/media', {
			'text@load': function(contents){
				return contents;
			},
			'source@load': function(contents){
				return convertToHtml(contents);
			},
			'html@load': function(contents){
				return convertToHtml(contents);
			},
			'text4save': function(contents){
				return contents;
			},
			'source4save': function(contents){
				return convertFromHtml(contents);
			},
			'html4save': function(contents){
				return convertFromHtml(contents);
			},
			'text2source': function(contents){
				return contents;
			},
			'text2html': function(contents){
				return contents;
			},
			'source2text': function(contents){
				return contents;
			},
			'source2html': function(contents){
				return convertToHtml(contents);
			},
			'html2text': function(contents){
				return convertFromHtml(contents);
			},
			'html2source': function(contents){
				return convertFromHtml(contents);
			}
		});
	});
	
	function convertFromHtml(content){
		var _matchs;
		var _regLoad = new RegExp("<(?:img|IMG)[^>]*txc-media[^>]*\/?>", "gim");
		var tempContent = content;
		
		while ((_matchs = _regLoad.exec(tempContent)) != null) {
			var _html = _matchs[0];
			var _source = getSourceByExt(_html);
			if (!$tx.msie && _source.indexOf("$") > -1) {
				_source = _source.replace(/\$/g, "$$$$");
			}
			content = content.replace(_html, _source);
		}
		
		return content;
	}
		
	function convertToHtml(content) {
		if ($tx.msie) { //FTDUEDTR-366 + FTDUEDTR-372 -> FTDUEDTR-403
			content = content.replace(/(<object[^>]*>)((?:\n|.)*?)(<\/object>)/gi, function(match, start, param, end) {
				param = param.replace(/<param[^>]*=[^\w]*wmode[^\w]+[^>]*>/i, "");
				param = param.replace(/<param[^>]*=[^\w]*play[^\w]+[^>]*>/i, "");
				param = '<param name="wmode" value="transparent" />'.concat(param);
				return start + param + end;
			});
			content = content.replace(/(<embed)([^>]*)(><\/embed>|\/>)/gi, function(match, start, attr, end) {
				attr = attr.replace(/\s+wmode=["']?(widnow|opaque|transparent)["']?/i, "").concat(' wmode="transparent"');
				return start + attr + end;
			});
			return content;
		} else {
			var _matchs;
			var tempContent = content;
			
			/* Substitue <embed tag within script to <xxembed */
			var _regScript = new RegExp("<(?:script)[^>]*>[\\S\\s]*?(<(?:embed|EMBED)[^>]*src=[^>]*>)[\\S\\s]*?<\/(?:script)>", "gim");
			while ((_matchs = _regScript.exec(tempContent)) != null) {
				var _source = _matchs[0];
				var _embed = _matchs[1];
				var _html = _source.replace(/<embed/i, "<xxembed");
				content = content.replace(_source, _html);
			}
			var _regLoad = new RegExp("<(?:object|OBJECT)[^>]*>[\\S\\s]*?(<(?:embed|EMBED)[^>]*src=[^>]*>)[\\S\\s]*?<\/(?:object|OBJECT)>", "gim");
			while ((_matchs = _regLoad.exec(tempContent)) != null) {
				var _source = _matchs[0];
				var _embed = _matchs[1];
				var _html = getHtmlByExt(_source, _embed);
				content = content.replace(_source, _html);
			}
			
			_regLoad = new RegExp("<(?:embed|EMBED)[^>]*src=[^>]*(?:\/?>|><\/(?:embed|EMBED)>)", "gim");
			while ((_matchs = _regLoad.exec(tempContent)) != null) {
				var _source = _matchs[0];
				var _embed = _matchs[0];
				var _html = getHtmlByExt(_source, _embed);
				content = content.replace(_source, _html);
			}
			
			content = content.replace(/<xxembed/i, "<embed");
			return content;
		}
	}
	
	function getHtmlByExt(source, embed) {
		var _attrs = Trex.Util.getAllAttributesFromEmbed(embed);
		var _url = _attrs['src'];
		var _width = (_attrs['width'] || " ").parsePx();
		var _height = (_attrs['height'] || " ").parsePx();
		if(isNaN(_width) || isNaN(_height)) {
			var _size = getDefaultSizeByUrl(_url);
			_width = _size.width;
			_height = _size.height;
		}
		
		/* make new embed source */
		var _newEmbedSrc = "<embed";
		for( var name in _attrs ){
			_newEmbedSrc += " " + name + "=\""+_attrs[name]+"\"";
		}
		_newEmbedSrc += ">";
		
		/* If source has 'object' then it is needed to add 'object' TAG */
		var arr = source.split(embed);
		source = arr[0] + _newEmbedSrc;
		for( var i = 1; i < arr.length; i++){
			source += arr[i];
		} 
		
		var _prev = getPreviewByUrl(_url);
		return "<img src=\"" + _prev.imageSrc + "\" width=\"" + _width + "\" height=\"" + _height + "\" border=\"0\" class=\"tx-entry-embed txc-media" + _prev.className + "\" ld=\"" + encodeURIComponent(source) + "\"/>";
	}
	
	function getSourceByExt(html) {
		var _attrs = Trex.Util.getAllAttributes(html);
		var _longdesc = _attrs['ld'];
		if(!_longdesc || _longdesc.length == 0) {
			return "";
		}
		var _width = _attrs['width'];
		var _height = _attrs['height'];
		var _source = decodeURIComponent(_longdesc);
		
		var _embed = _source;
		if(_source.indexOf("object") > -1 || _source.indexOf("OBJECT") > -1) {
			var _matchs;
			var _regLoad = new RegExp("<(?:embed|EMBED)[^>]*src=[^>]*(?:\/?>|><\/(?:embed|EMBED)>)", "gim");
			while ((_matchs = _regLoad.exec(_source)) != null) {
				_embed = _matchs[0];
			}
		}
		
		_attrs = Trex.Util.getAllAttributes(_embed);
		var _url = _attrs['src'];
		var _size = getDefaultSizeByUrl(_url);
		if(isNaN(_width)) {
			_source = Trex.String.changeAttribute(_source, "width", " width=\"" + _size.width + "\"");
		} else {
			_source = Trex.String.changeAttribute(_source, "width", " width=\"" + _width + "\"");
		}
		if(isNaN(_height)) {
			_source = Trex.String.changeAttribute(_source, "height", " height=\"" + _size.height + "\"");
		} else {
			_source = Trex.String.changeAttribute(_source, "height", " height=\"" + _height + "\"");
		}
		return _source;
	}
	
	function makeSourceByUrl(url) {
		var _ext = url.split(".").pop().split("?")[0].toLowerCase();
		var _size = getDefaultSizeByUrl(url);
		switch (_ext) {
			case "swf":
				return "<embed src=\"" + url + "\" quality='high' type='application/x-shockwave-flash' allowfullscreen='true' pluginspage='http://www.macromedia.com/go/getflashplayer' width='"+_size.width+"' height='"+_size.height+"'></embed>";
			case "mp3":
			case "wma":
			case "asf":
			case "asx":
			case "mpg":
			case "mpeg":
			case "wmv":
			case "avi":
				return "<embed src=\"" + url + "\" type=\"application/x-mplayer2\" pluginspage=\"http://www.microsoft.com/Windows/MediaPlayer/\" width='"+_size.width+"' height='"+_size.height+"'></embed>";
			case "mov":
				return "<embed src=\"" + url + "\" type=\"video/quicktime\" pluginspage=\"http://www.apple.com/quicktime/download/indext.html\" width='"+_size.width+"' height='"+_size.height+"'></embed>";
			case 'jpg':
			case 'bmp':
			case 'gif':
			case 'png':	
				return "<img src=\"" + url + "\" border=\"0\"/>";
			default:
				return "<embed src=\"" + url + "\" width='"+_size.width+"' height='"+_size.height+"'></embed>";
		}
	}
	
	function getDefaultSizeByUrl(url) {
		var _width, _height;
		if(url.indexOf("api.bloggernews.media.daum.net/static/recombox1") > -1) {
			_width = 400;
			_height = 80;
		} else if(url.indexOf("flvs.daum.net/flvPlayer") > -1) {
			_width = 502;
			_height = 399;
		} else {
			var _ext = url.split(".").pop().split("?")[0].toLowerCase();
			switch (_ext) {
				case "mp3":
				case "wma":
				case "asf":
				case "asx":
					_width = 280;
					_height = 45;
					break;
				case "mpg":
				case "mpeg":
				case "wmv":
				case "avi":
					_width = 320;
					_height = 285;
					break;
				default:
					_width = 400;
					_height = 300;
					break;
			}
		}
		return {
			width: _width,
			height: _height
		};
	}
	
	function getPreviewByUrl(url) {
		var _class = "";
		var _image = "";
		if(url.indexOf("api.bloggernews.media.daum.net/static/recombox1") > -1) {
			_class = "";
			_image = TXMSG("@media.prev.url");
		} else if(url.indexOf("flvs.daum.net/flvPlayer") > -1) {
			_class = " txc-media-tvpot";
			_image = TXMSG("@media.prev.url.tvpot");
		} else {
			var _ext = url.split(".").pop().split("?")[0].toLowerCase();
			switch (_ext) {
				case "mp3":
				case "wma":
				case "asf":
				case "asx":
					_class = " txc-media-wmp";
					_image = TXMSG("@media.prev.url.wmp");
					break;
				case "mpg":
				case "mpeg":
				case "wmv":
				case "avi":
					_class = " txc-media-wmp";
					_image = TXMSG("@media.prev.url.wmp");
					break;
				default:
					_class = "";
					_image = TXMSG("@media.prev.url");
					break;
			}
		}
		return {
			className: _class,
			imageSrc: _image
		};
	};
	
})();
