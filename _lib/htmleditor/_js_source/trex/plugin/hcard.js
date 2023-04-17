TrexConfig.addTool(
	"hcard", 
	{
		wysiwygonly: false,
		status: true
	}
);
Trex.Tool.Hcard = Trex.Class.create({
	$const: {
		__Identity: 'hcard'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
		var _canvas = this.canvas;
		var _toolHandler = function(hcardHtml) {
			
			_canvas.pasteContent( hcardHtml,true );
		};
		this.weave.bind(this)(
			new Trex.Button(this.buttonCfg), 
			new Trex.Menu.Hcard(this.menuCfg),
			_toolHandler
		);
	}
});

Trex.MarkupTemplate.add(
	'menu.hcard.inputform', [
		'<p><label>이름<label><input type="text" name="tx-givenName"/></p>',
		'<p><label>소속</label><input type="text" name="tx-org"/></p>',
		'<p><label>주소</label><input type="text" name="tx-street"/></p>',
		'<p><label>전화번호</label><input type="text" name="tx-tel"/></p>',
		'<p><label>email</label><input type="text" name="tx-email"/></p>',
		'<p><input type="button" value="입력" class="tx-input"></p>',
	].join("")
);
Trex.Menu.Hcard = Trex.Class.create({
	$extend: Trex.Menu,
	ongenerated: function(){
		Trex.MarkupTemplate.get("menu.hcard.inputform").evaluateToDom({}, this.elMenu) ;
	
		var _this = this;
		$tx.observe( $tom.collect( this.elMenu, "input.tx-input"), "click", function(ev){
			_this.clickInput(ev);
		});
	},
	onregenerated: function(){
	},
	clickInput: function(ev){
		var inputFields = $tom.collectAll( this.elMenu, "input" );
		var data = {
			givenName: inputFields[0].value,
			org: inputFields[1].value,
			street: inputFields[2].value,
			tel: inputFields[3].value,
			email: inputFields[4].value,
		}
		var template = new Template(this.getHcardMarkup());
		var result = template.evaluate(data);
		this.onSelect(ev, result );		
	},
	getHcardMarkup: function(){
		return 	'<div id="hcard-#{giveName}" class="vcard" style="border:1px solid;width:200px;color:#000;>\
			<span class="fn n">\
				<span class="given-name">#{givenName}</span>\
			</span>\
			<div class="org">#{org}</div>\
			<a class="email" href="mailto:#{email}">#{email}</a>\
			<div class="tel">#{tel}</div>\
			<p style="font-size:smaller;">\
			This\
			<a href="http://microformats.org/wiki/hcard">hCard</a> created with the<a href="http://microformats.org/code/hcard/creator">hCard creator</a>.\
			</p>\
		</div>';
	}
});