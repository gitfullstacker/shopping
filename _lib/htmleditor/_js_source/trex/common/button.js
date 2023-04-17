/**
 * @fileoverview
 * 에디터에서 사용되는 button의 모음 
 * 
 */

Trex.MarkupTemplate.add(
	'button.itsnew', '<em class="tx-itsnew" title="new">new</em>'
);

Trex.MarkupTemplate.add(
	'button.select.text', '<span>#{data}</span>'
);

/**
 * 일반적인 동작의 버튼 객체로, 특화된 버튼은 이 클래스를 상속받아 사용한다.<br/>
 * 해당 엘리먼트는 미리 DOM에 있어야 하며, __borderClasses에 지정된 클래스이름을 가져야한다. 
 * 
 * @class
 * @param {Object} config
 * 
 * @example
 *	<div id="tx_example" class="tx-example tx-btn-lrbg" unselectable="on">
 *		<a title="예제" class="tx-icon" href="javascript:;">예제</a>
 *	</div>
 * 
 * 	new Trex.Button({
 * 		id: 'tx_example',
 * 		wysiwygonly: true,
 * 		sync: false,
 * 		status: false
 * 	});
 */
Trex.Button = Trex.Class.create(/** @lends Trex.Button.prototype */{
	/** @ignore */
	$const: {
		__borderClasses: {	
			'tx-btn-trans': true,
			'tx-btn-lbg': true, 
			'tx-btn-bg': true, 
			'tx-btn-rbg': true,
			'tx-btn-lrbg': true,
			'tx-slt-tlbg': true, 
			'tx-slt-tbg': true, 
			'tx-slt-trbg': true, 
			'tx-slt-blbg': true, 
			'tx-slt-bbg': true, 
			'tx-slt-brbg': true, 
			'tx-slt-31bg': true,
			'tx-slt-31lbg': true, 
			'tx-slt-31rbg': true, 
			'tx-slt-70bg': true, 
			'tx-slt-59bg': true, 
			'tx-slt-42bg': true, 
			'tx-btn-nlrbg': true,
			'tx-btn-43lrbg': true,
			'tx-btn-52lrbg': true,
			'tx-btn-57lrbg': true,
			'tx-btn-71lrbg': true,
			'tx-btn-48lbg': true, 
			'tx-btn-48rbg': true, 
			'tx-btn-30lrbg': true, 
			'tx-btn-46lrbg': true,
			'tx-btn-67lrbg': true,
			'tx-btn-49lbg': true,
			'tx-btn-58bg': true,
			'tx-btn-46bg': true,
			'tx-btn-49rbg': true,
			'tx-btn-widget': true,
			'tx-btn-widget-tbg': true,
			'tx-btn-widget-brbg': true
		},
		addBorderClass: function(className){
			Trex.Button.__borderClasses[className] = true;
		},
		getBorderClass: function(el){
			var _classes = $tx.classNames(el);
			for(var i =0; i < _classes.length; i++){
				var _class = _classes[i];
				var _matched = Trex.Button.__borderClasses[_class];
				if(_matched){
					return _class;
				}
			}
		}
	},
	/**
	 * 상태가 있는지 여부
	 */
	hasState: null,
	/**
	 * 라디오 버튼인지 여부
	 */
	isRadioButton: null,
	/**
	 * disabled 상태인지 여부
	 */
	isDisabled: null,
	/**
	 * 메뉴가 있는 버튼의 경우 선택된 값 (ex: font-family tool에서 '궁서'를 선택하면 lastValue는 'Gungsuh,궁서'이다.)
	 */
	lastValue: null,
	/**
	 * 메뉴가 있는 버튼의 경우 선택된 메뉴항목의 레이블
	 */
	lastText: null,
	/**
	 * 버튼 dom element
	 */
	elButton: null,
	/**
	 * 버튼의 아이콘 dom element
	 */
	elIcon: null,
	/**
	 * 버튼의 배경 이미지 클래스이름
	 */
	borderClass: null,
	/**
	 * 버튼의 실행 command function
	 * @function
	 */
	_command: function(){},
	/**
	 * 버튼을 실행하면 호출 될 command function을 지정한다. 
	 * @private
	 * @function
	 */
	setCommand: function(cmd){
		this._command = cmd;
	},
	initialize: function(config) { //only superclass
		var _config = this.config = config;
		if (_config.borderClass) {
			Trex.Button.addBorderClass(_config.borderClass);
		}
		
		this.itsNew = !!_config.itsnew;
		this.useSync = !!_config.sync; //NOTE: sync font property
		this.hasState = !!_config.status; //NOTE: pushed status
		this.isRadioButton = !!_config.radio;
		this.isDisabled = false;
		this.lastValue = _config.selectedValue || null;
		
		if ( config.el ){
			this.elButton = config.el;
		}else{
			var _elementId = _config.id || "tx_" + _config.identity;
			this.elButton = $must(_elementId + (_config.initializedId || ""));
		}
		var _elButton = this.elButton
		
		var _elIcon = this.elIcon = $tom.collect(_elButton, "a");
		if (!_elIcon) {
			throw new Error("[Exception]Trex.Button : can't find elIcon for button '"+ _elementId +"'");
		}
		this.borderClass = Trex.Button.getBorderClass(_elButton);
		
		if(this.oninitialized){
			this.oninitialized.bind(this)(_config);	
		}
		this.generate();
		
		if(this.itsNew) {
			$tom.append(_elIcon, Trex.MarkupTemplate.get('button.itsnew').evaluateAsDom({}));
		}
		
		if (_config.selectedValue && this.setValue) {
			this.setValue(_config.selectedValue);
		}
		if (_config.selectedText && this.setText) {
			this.setText(_config.selectedText);
		}
		if ( _config.selectedState && this.setState ){
			this.setState( _config.selectedState );
		}
	},
	/**
	 * 버튼의 이벤트에 handler function 을 걸어준다.
	 * @function
	 */
	generate: function() {
		var _elIcon = this.elIcon;
		$tx.observe(_elIcon, 'mousedown', this.onMouseDown.bindAsEventListener(this));
		$tx.observe(_elIcon, 'mouseover', this.onMouseOver.bindAsEventListener(this));
		$tx.observe(_elIcon, 'mouseout', this.onMouseOut.bindAsEventListener(this));
		$tx.observe(_elIcon, 'keydown', this.onKeyDown.bindAsEventListener(this));
		$tx.observe(_elIcon, 'click', this.onClick.bindAsEventListener(this));

		if (this.ongenerated) {
			this.ongenerated.bind(this)(this.config);
		}
	},
	/**
	 * 버튼의 border class 이름을 가져온다.
	 * @function
	 * @returns {String} css class name 또는 'undefined'
	 */
	getCurrentBorderClass: function(el){
		var _classes = $tx.classNames(el);
		
		for(var i =0; i < _classes.length; i++){
			var _class = _classes[i];
			if(_class.indexOf(this.borderClass) != -1){
				return _class; 
			}
		}
		return "undefined";
	},
	/**
	 * 버튼의 css class 를 초기상태로 변경한다.
	 * @function
	 */
	normalState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		$tx.removeClassName(this.elButton, _currBorderClass);
		$tx.addClassName(this.elButton, this.borderClass);
	},
	/**
	 * 버튼의 css class 를 mouse over 상태로 변경한다.
	 * @function
	 */
	hoveredState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		$tx.removeClassName(this.elButton, _currBorderClass);
		$tx.addClassName(this.elButton, this.borderClass + '-hovered');
	},
	/**
	 * 버튼의 css class 를 눌려있는 상태로 변경한다.
	 * @function
	 */
	pushedState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		$tx.removeClassName(this.elButton, _currBorderClass);
		$tx.addClassName(this.elButton, this.borderClass + '-pushed');
	},
	/**
	 * 버튼의 현재 상태를 반환한다.
	 * @function
	 * @return {String} 'normal', 'pushed', 'hovered'
	 */
	currentState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		var cs = "normal";
		if(_currBorderClass.indexOf('-pushed') != -1){
			cs = "pushed";
		}else if(_currBorderClass.indexOf('-hovered') != -1){
			cs = "hovered";
		}
		return cs;
	},
	/**
	 * 버튼이 눌린 상태인지 아닌지 판단한다.
	 * @function
	 * @return {boolean} 눌린 상태(pushed)이면 true, 아니면 false
	 */
	isPushed: function(){
		return ("pushed" == this.currentState());
	},
	/**
	 * 메뉴가 있는 버튼인지 판단한다.
	 * @function
	 * @return {boolean} 메뉴가 있으면 true, 아니면 false
	 */
	hasMenu: function(){
		return this.tool ? !!(this.tool.menu) : false;
	},
	/**
	 * 버튼을 누르면 normal state 또는 pushed state로 변경한다.
	 * @function
	 */
	onMouseDown: function(ev) {
		if(ev){
			$tx.stop(ev);
		}
		if(this.isDisabled) {
			return;
		}
		if(this.hasMenu() || this.hasState){
			if (this._command() === false) {
				return;
			}
		}else{
			this.evsessionstarted = true;
		}
		if (this.isPushed()) {
			this.normalState();
		} else {
			this.pushedState();
		}
	},
	/**
	 * 마우스 커서를 버튼영역 위에 올리면 hovered state로 변경한다.
	 * @function
	 */
	onMouseOver: function() {
		if(this.isDisabled || this.isPushed()) {
			return;
		}
		this.hoveredState();
	},
	/**
	 * 마우스 커서가 버튼영역 바깥으로 나가면 normal state로 변경한다.
	 * @function
	 */
	onMouseOut: function() {
		if(this.evsessionstarted){
			this.normalState();
			this.evsessionstarted = false;
		}
		if(this.isDisabled || this.isPushed()){
			return;
		}
		this.normalState();
	},
	/**
	 * 버튼을 클릭하면 command function을 실행하고 normal state로 변경한다.
	 * @function
	 */
	onClick: function(ev) {
		if(ev){
			$tx.stop(ev);
		}
		if(this.isDisabled) {
			return;
		}	
		if(!this.hasState){
			this._command();
			this.normalState();
			this.evsessionstarted = false;
		}
	},
	/**
	 * event keyCode가 13이면 onMouseDown(), onClick() 을 실행한다.
	 * @function
	 */
	onKeyDown: function(ev){
		if(ev.keyCode === 13){
			this.onMouseDown(ev);
			this.onClick(ev);
		}
	},
	/**
	 * command function 실행 후 lastValue, lastText의 값을 업데이트 한다.
	 * @function
	 */
	updateAfterCommand: function(value, text){
		this.setValueAndText(value, text);
		this.normalState();
	},
	/**
	 * lastValue, lastText의 값을 설정한다.
	 * @function
	 */
	setValueAndText: function(value, text){
		this.setValue(value);
		this.setText(text);
	},
	/**
	 * lastValue 값을 설정한다.
	 * @function
	 */
	setValue: function(value) {
		if(value) {
			this.lastValue = value;
		}
	},
	/**
	 * lastText 값을 설정한다.
	 * @function
	 */
	setText: function(text) {
		this.lastText = text;
	},
	/**
	 * lastValue 값을 가져온다.
	 * @function
	 * @return {String}
	 */
	getValue: function() {
		return this.lastValue;
	},
	/**
	 * lastText 값을 가져온다.
	 * @function
	 * @return {String}
	 */
	getText: function() {
		return this.lastText;
	},
	/**
	 * pushed에서 normal state로 또는 그 반대로 상태를 변경한다.
	 * @function
	 */
	setState: function(push) {
		if (push) {
			this.pushedState();
		} else {
			this.normalState();
		}
	},
	/**
	 * 아이콘 element 의 css class 를 설정한다.
	 * @function
	 */
	setClassName: function(className) {
		this.elIcon.className = className;
	},
	/**
	 * 버튼을 사용불가 상태로 변경한다.
	 * @function
	 */
	disable: function() {
		if(this.elButton) {
			this.isDisabled = true;
			$tx.addClassName(this.elButton, "tx-disable");
		}
	},
	/**
	 * 버튼을 사용가능 상태로 변경한다.
	 * @function
	 */
	enable: function() {
		if(this.elButton) {
			this.isDisabled = false;
			$tx.removeClassName(this.elButton, "tx-disable");
		}
	},
	/**
	 * 버튼을 normal state로 변경한다.
	 * @function
	 */
	release: function() {
		if(this.isDisabled) {
			return;
		}
		if(this.hasMenu() || !this.hasState){
			this.normalState();	
		}
	}
});

/**
 * Trex.Button.Select
 * 
 * @extends Trex.Button
 * @class
 */
Trex.Button.Select = Trex.Class.create(/** @lends Trex.Button.Select.prototype */{
	/** @ignore */
	$extend: Trex.Button,
	/**
	 * 버튼에 화살표 버튼이 더 붙어 있을 경우 화살표 버튼에 event handler function 을 걸어준다.
	 * @function
	 */
	ongenerated: function(){
		Trex.MarkupTemplate.get('button.select.text').evaluateToDom({
			'data': $tom.getText(this.elIcon)
		}, this.elIcon);
		this.elText = $tom.collect(this.elIcon, 'span');
		
		var _elArrow = $tom.collect(this.elButton, "a.tx-arrow");
		if(_elArrow) {
			$tx.observe(_elArrow, 'mousedown', this.onMouseDown.bindAsEventListener(this));
			$tx.observe(_elArrow, 'mouseover', this.onArrowMouseOver.bindAsEventListener(this));
			$tx.observe(_elArrow, 'mouseout', this.onArrowMouseOut.bindAsEventListener(this));
			$tx.observe(_elArrow, 'click', this.onClick.bindAsEventListener(this));	
		}
	},
	/**
	 * 메뉴에서 선택된 값의 레이블을 설정한다.
	 * @function
	 */
	setText: function(text) {
		this.elText.innerText = text;
	},
	/**
	 * 마우스 커서를 버튼영역 위에 올리면 hovered state로 변경한다.
	 * @function
	 */
	onArrowMouseOver: function() {
		if(this.isDisabled || this.isPushed()) {
			return;
		}
		this.hoveredState();
	},
	/**
	 * 마우스 커서가 버튼영역 바깥으로 나가면 normal state로 변경한다.
	 * @function
	 */
	onArrowMouseOut: function() {
		if(this.isDisabled || this.isPushed()) {
			return;
		}
		this.normalState();
	}
});

/**
 * Trex.Button.Splits
 * 
 * @extends Trex.Button
 * @class
 */
Trex.Button.Splits = Trex.Class.create(/** @lends Trex.Button.Splits.prototype */{
	/** @ignore */
	$extend: Trex.Button,
	ongenerated: function(){
		var _elButton = this.elButton;
		var _elArrow = this.elArrow = $tom.collect(_elButton, "a.tx-arrow");
		if(!_elArrow) {
			throw new Error("[Exception]Trex.Button.Splits : not exist element(a.tx-arrow)");
		}
		$tx.observe(_elArrow, 'mousedown', this.onArrowMouseDown.bindAsEventListener(this));
		$tx.observe(_elArrow, 'mouseover', this.onArrowMouseOver.bindAsEventListener(this));
		$tx.observe(_elArrow, 'mouseout', this.onArrowMouseOut.bindAsEventListener(this));
		$tx.observe(_elArrow, 'click', this.onArrowClick.bindAsEventListener(this));
	},
	/**
	 * 화살표 버튼의 css class 를 mouse over 상태로 변경한다.
	 * @function
	 */
	arrowHoveredState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		$tx.removeClassName(this.elButton, _currBorderClass);
		$tx.addClassName(this.elButton, this.borderClass + '-arrow-hovered');
	},
	/**
	 * 화살표 버튼의 css class 를 pushed 상태로 변경한다.
	 * @function
	 */
	arrowPushedState: function(){
		var _currBorderClass = this.getCurrentBorderClass(this.elButton);
		$tx.removeClassName(this.elButton, _currBorderClass);
		$tx.addClassName(this.elButton, this.borderClass + '-arrow-pushed');
	},
	/**
	 * 버튼을 누르면 상태를 변경하고 command를 실행한다. 버튼 옆에 있는 화살표의 상태를 본다.  
	 * @function
	 */
	onMouseDown: function(ev) {
		if(this.isDisabled) {
			return;
		}
		if(this.isPushed()){
			this.normalState();
			this._command();
			this.commandexecuted = true;
		}else{
			this.pushedState();
			this.commandexecuted = false;
			this.evsessionstarted = true;
		}
	},
	/**
	 * tool의 execute를 실행하고 normal state로 변경한다.
	 * @function
	 */
	onClick: function(ev) {
		if(this.isDisabled) {
			return;
		}
		if(!this.commandexecuted){
			this.tool.execute(this.lastValue, this.lastText);
			this.evsessionstarted = false;
		}else{
			this.commandexecuted = false;
		}
		this.normalState();
		if(ev){
			$tx.stop(ev);	
		}
	},
	/**
	 * 화살표를 pushed state 로 변경하거나 normal state로 변경한다. 
	 * @function
	 */
	onArrowMouseDown: function() {
		if(this.isDisabled) {
			return;
		}
		if (this._command() === false) {
			return;
		}
		if(this.isPushed()){
			this.normalState();
		}else{
			this.arrowPushedState();
		}
	},
	/**
	 * @function
	 */
	onArrowClick: function(ev) {
		if(this.isDisabled) {
			return;
		}	
		if(ev){
			$tx.stop(ev);	
		}
	}, 
	/**
	 * 화살표 버튼의 css class 를 mouse over 상태로 변경한다.
	 * @function
	 */
	onArrowMouseOver: function() {
		if(this.isDisabled || this.isPushed()) {
			return;
		}
		this.arrowHoveredState();
	},
	/**
	 * 화살표 버튼의 css class 를 normal 상태로 변경한다.
	 * @function
	 */
	onArrowMouseOut: function() {
		if(this.isDisabled || this.isPushed()) {
			return;
		}
		if(this.commandexecuted){
			this.commandexecuted = false;
		}
		this.normalState();
	}
});

/** 
 * Trex.Button.Toggle 
 * 
 * @extends Trex.Button
 * @class
 */
Trex.Button.Toggle = Trex.Class.create(/** @lends Trex.Button.Toggle.prototype */{
	/** @ignore */
	$extend: Trex.Button,
	/**
	 * pushed 또는 normal state로 변경한다.
	 * @function
	 */
	setValue: function(selected) {
		if (selected) {
			this.pushedState();
		} else {
			this.normalState();
		}
	}
});

/** 
 * Trex.Button.Widget 
 * 
 * @extends Trex.Button.Select
 * @class
 */
Trex.Button.Widget = Trex.Class.create(/** @lends Trex.Button.Widget.prototype */{
	/** @ignore */
	$extend: Trex.Button.Select,
	/**
	 * lastText 값을 설정한다.
	 * @function
	 */
	setText: function(text) {
		this.elIcon.innerText = text;
		if ( this.lastText ){
			$tx.removeClassName( this.elIcon, this.lastText );
		}
		
		$tx.addClassName( this.elIcon, text );
		this.lastText = text;
	},
	/**
	 * 버튼에 menu와 menu handler를 설정한다.
	 * @function
	 */
	setMenu: function(menu, handler) {
		this.hasState = true;
		var _button = this;
		
		menu.setCommand(function() { 
			var success = handler.apply(this, arguments);
			_button.updateAfterCommand.apply(_button, arguments);
			return success;
		});
		
		_button.setCommand(
			function() {
				if(!_button.isPushed()) {
					var _lastvalue = _button.getValue();
					menu.show(_lastvalue);
				} else {
					menu.hide();
				}
				return true;
			}
		);
	}
});

/** 
 * Trex.Button.ColorWidget 
 * 
 * @extends Trex.Button.Widget
 * @class
 */
Trex.Button.ColorWidget = Trex.Class.create(/** @lends Trex.Button.ColorWidget.prototype */{
	/** @ignore */
	$extend: Trex.Button.Widget,
	/**
	 * lastValue 값을 설정한다.
	 * @function
	 */
	setValue: function(value){
		$tx.setStyle( this.elIcon.parentNode, {'backgroundColor': value});
		this.lastValue = value;
	},
	/**
	 * do nothing
	 * @function
	 */
	setText: function(){
		// do Nothing
	}
});

