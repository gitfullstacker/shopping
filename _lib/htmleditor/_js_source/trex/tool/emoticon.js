/**
 * @fileoverview 
 * emoticon을 입력 할 수 있는 메뉴를 포함하는 tool인 'Emoticon' Icon을 위한 source로 
 * 필요한 configuration과 Class Trex.Tool.Emoticon을/를 포함
 *     
 */

TrexMessage.addMsg({
	'@emoticon.subtitle.person': "사람",
	'@emoticon.subtitle.animal': "동식물",
	'@emoticon.subtitle.thing': "사물",
	'@emoticon.subtitle.etc': "기타"
});

TrexConfig.addTool(
	"emoticon",
	{
		sync: false,
		status: true,
		rows: 5,
		cols: 7,
		matrices: [{
			title: TXMSG("@emoticon.subtitle.person"),
			klass: "tx-menu-matrix-per",
			options: [
				'#decopath/per_01.gif?rv=1.0.1',
				'#decopath/per_02.gif?rv=1.0.1',
				'#decopath/per_03.gif?rv=1.0.1',
				'#decopath/per_04.gif?rv=1.0.1',
				'#decopath/per_05.gif?rv=1.0.1',
				'#decopath/per_06.gif?rv=1.0.1',
				'#decopath/per_07.gif?rv=1.0.1',
				'#decopath/per_08.gif?rv=1.0.1',
				'#decopath/per_09.gif?rv=1.0.1',
				'#decopath/per_10.gif?rv=1.0.1',
				'#decopath/per_11.gif?rv=1.0.1',
				'#decopath/per_12.gif?rv=1.0.1',
				'#decopath/per_13.gif?rv=1.0.1',
				'#decopath/per_14.gif?rv=1.0.1',
				'#decopath/per_15.gif?rv=1.0.1',
				'#decopath/per_16.gif?rv=1.0.1',
				'#decopath/per_17.gif?rv=1.0.1',
				'#decopath/per_18.gif?rv=1.0.1',
				'#decopath/per_19.gif?rv=1.0.1',
				'#decopath/per_20.gif?rv=1.0.1',
				'#decopath/per_21.gif?rv=1.0.1',
				'#decopath/per_22.gif?rv=1.0.1',
				'#decopath/per_23.gif?rv=1.0.1',
				'#decopath/per_24.gif?rv=1.0.1',
				'#decopath/per_25.gif?rv=1.0.1',
				'#decopath/per_26.gif?rv=1.0.1',
				'#decopath/per_27.gif?rv=1.0.1',
				'#decopath/per_28.gif?rv=1.0.1',
				'#decopath/per_29.gif?rv=1.0.1'
			]
		},{
			title: TXMSG("@emoticon.subtitle.animal"),
			klass: "tx-menu-matrix-ani",
			options: [
				'#decopath/ani_01.gif?rv=1.0.1',
				'#decopath/ani_02.gif?rv=1.0.1',
				'#decopath/ani_03.gif?rv=1.0.1',
				'#decopath/ani_04.gif?rv=1.0.1',
				'#decopath/ani_05.gif?rv=1.0.1',
				'#decopath/ani_06.gif?rv=1.0.1',
				'#decopath/ani_07.gif?rv=1.0.1',
				'#decopath/ani_08.gif?rv=1.0.1',
				'#decopath/ani_09.gif?rv=1.0.1',
				'#decopath/ani_10.gif?rv=1.0.1',
				'#decopath/ani_11.gif?rv=1.0.1',
				'#decopath/ani_12.gif?rv=1.0.1',
				'#decopath/ani_13.gif?rv=1.0.1',
				'#decopath/ani_14.gif?rv=1.0.1',
				'#decopath/ani_15.gif?rv=1.0.1',
				'#decopath/ani_16.gif?rv=1.0.1',
				'#decopath/ani_17.gif?rv=1.0.1',
				'#decopath/ani_18.gif?rv=1.0.1',
				'#decopath/ani_19.gif?rv=1.0.1',
				'#decopath/ani_20.gif?rv=1.0.1',
				'#decopath/ani_21.gif?rv=1.0.1',
				'#decopath/ani_22.gif?rv=1.0.1',
				'#decopath/ani_23.gif?rv=1.0.1',
				'#decopath/ani_24.gif?rv=1.0.1',
				'#decopath/ani_25.gif?rv=1.0.1',
				'#decopath/ani_26.gif?rv=1.0.1',
				'#decopath/ani_27.gif?rv=1.0.1',
				'#decopath/ani_28.gif?rv=1.0.1'
			]
		},{
			title: TXMSG("@emoticon.subtitle.thing"),
			klass: "tx-menu-matrix-things",
			options: [
				'#decopath/things_01.gif?rv=1.0.1',
				'#decopath/things_02.gif?rv=1.0.1',
				'#decopath/things_03.gif?rv=1.0.1',
				'#decopath/things_04.gif?rv=1.0.1',
				'#decopath/things_05.gif?rv=1.0.1',
				'#decopath/things_06.gif?rv=1.0.1',
				'#decopath/things_07.gif?rv=1.0.1',
				'#decopath/things_08.gif?rv=1.0.1',
				'#decopath/things_09.gif?rv=1.0.1',
				'#decopath/things_10.gif?rv=1.0.1',
				'#decopath/things_11.gif?rv=1.0.1',
				'#decopath/things_12.gif?rv=1.0.1',
				'#decopath/things_13.gif?rv=1.0.1',
				'#decopath/things_14.gif?rv=1.0.1',
				'#decopath/things_15.gif?rv=1.0.1',
				'#decopath/things_16.gif?rv=1.0.1',
				'#decopath/things_17.gif?rv=1.0.1',
				'#decopath/things_18.gif?rv=1.0.1',
				'#decopath/things_19.gif?rv=1.0.1',
				'#decopath/things_20.gif?rv=1.0.1',
				'#decopath/things_21.gif?rv=1.0.1',
				'#decopath/things_22.gif?rv=1.0.1',
				'#decopath/things_23.gif?rv=1.0.1',
				'#decopath/things_24.gif?rv=1.0.1',
				'#decopath/things_25.gif?rv=1.0.1',
				'#decopath/things_26.gif?rv=1.0.1',
				'#decopath/things_27.gif?rv=1.0.1',
				'#decopath/things_28.gif?rv=1.0.1',
				'#decopath/things_29.gif?rv=1.0.1',  
				'#decopath/things_30.gif?rv=1.0.1',  
				'#decopath/things_31.gif?rv=1.0.1',  
				'#decopath/things_32.gif?rv=1.0.1',  
				'#decopath/things_33.gif?rv=1.0.1',  
				'#decopath/things_34.gif?rv=1.0.1',  
				'#decopath/things_35.gif?rv=1.0.1'
			]
		},{
			title: TXMSG("@emoticon.subtitle.etc"),
			klass: "tx-menu-matrix-etc",
			options: [
				'#decopath/etc_01.gif?rv=1.0.1',
				'#decopath/etc_02.gif?rv=1.0.1',
				'#decopath/etc_03.gif?rv=1.0.1',
				'#decopath/etc_04.gif?rv=1.0.1',
				'#decopath/etc_05.gif?rv=1.0.1',
				'#decopath/etc_06.gif?rv=1.0.1',
				'#decopath/etc_07.gif?rv=1.0.1',
				'#decopath/etc_08.gif?rv=1.0.1',
				'#decopath/etc_09.gif?rv=1.0.1',
				'#decopath/etc_10.gif?rv=1.0.1',
				'#decopath/etc_11.gif?rv=1.0.1',
				'#decopath/etc_12.gif?rv=1.0.1',
				'#decopath/etc_13.gif?rv=1.0.1',
				'#decopath/etc_14.gif?rv=1.0.1',
				'#decopath/etc_15.gif?rv=1.0.1',
				'#decopath/etc_16.gif?rv=1.0.1',
				'#decopath/etc_17.gif?rv=1.0.1',
				'#decopath/etc_18.gif?rv=1.0.1',
				'#decopath/etc_19.gif?rv=1.0.1',
				'#decopath/etc_20.gif?rv=1.0.1',
				'#decopath/etc_21.gif?rv=1.0.1',
				'#decopath/etc_22.gif?rv=1.0.1',
				'#decopath/etc_23.gif?rv=1.0.1',
				'#decopath/etc_24.gif?rv=1.0.1',
				'#decopath/etc_25.gif?rv=1.0.1',
				'#decopath/etc_26.gif?rv=1.0.1',
				'#decopath/etc_27.gif?rv=1.0.1',
				'#decopath/etc_28.gif?rv=1.0.1',
				'#decopath/etc_29.gif?rv=1.0.1'
			]
		}]
	},
	function(root){
		var _config = TrexConfig.getTool("emoticon", root);
		_config.matrices.each(function(matrix) {
			for(var i=0,len=matrix.options.length;i<len;i++) {
				matrix.options[i] = TrexConfig.getDecoPath(matrix.options[i], "emoticon");
			}
		});
	}
);

Trex.Tool.Emoticon = Trex.Class.create({
	$const: {
		__Identity: 'emoticon'
	},
	$extend: Trex.Tool,
	oninitialized: function(config) {
			var _canvas = this.canvas;

			var _toolHandler = function(value) {
				if(!value || value.trim().length == 0) {
					return;
				}
				_canvas.execute(function(processor) {
					var _node = processor.win.img({ 'src': value, 'border': "0", 'className' : 'txc-emo' });
					processor.pasteNode(_node, false);
				});
			};

			/* button & menu weave */
			this.weave.bind(this)(
				/* button */
				new Trex.Button(this.buttonCfg),
				/* menu */
				new Trex.Menu.Matrix(this.menuCfg),
				/* handler */
				_toolHandler
			);
		}
	
});
