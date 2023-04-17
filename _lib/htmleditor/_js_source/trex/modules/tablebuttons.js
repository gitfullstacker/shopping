Trex.MarkupTemplate.add(
	'table.hover.button', 
	'<div class="tx-table-btn-layer"><a href="javascript:;" class="tx-table-edit-layout">표편집</a><a href="javascript:;" class="tx-table-edit-template">표서식</a><a href="javascript:;" class="tx-table-remove">삭제</a></div>'
);
Trex.module("show button for action of table object", 
	function(editor, toolbar, sidebar, canvas, config) {
		var _BUTTON_OFFSET = 20;
		var _hoverdTableNode = null;
		var _elBtn = Trex.MarkupTemplate.get("table.hover.button").evaluateAsDom({});
		$tom.insertFirst( canvas.wysiwygEl, _elBtn );
		
		var _eventBinding = function(){
			var elALayout = $tom.collect( _elBtn, "a.tx-table-edit-layout");
			$tx.observe( elALayout, "click", function(ev){
				if (_hoverdTableNode) {
					new Trex.Menu.Table.TableEdit({
						editor: editor,
						table: _hoverdTableNode
					});
				}
				return false;
			});
			
			var elATemplate = $tom.collect( _elBtn, "a.tx-table-edit-template");
			$tx.observe( elATemplate, "click", function(ev){
				if (_hoverdTableNode) {
					var tableEdit = new Trex.Menu.Table.TableEdit({
						editor: editor,
						table: _hoverdTableNode
					});
					tableEdit.showMenu(2);
				}
				return false;
			});
			
			var elADelete = $tom.collect( _elBtn, "a.tx-table-remove");
			$tx.observe( elADelete, "click", function(ev){
				if (_hoverdTableNode) {
					if (!confirm("테이블을 삭제하시겠습니까?")) {
						return false;
					}
					$tom.remove(_hoverdTableNode);
					canvas.history.saveHistory();
				}
				return false;
			});
		}
		var _showButton = function(nodePos){
			if (nodePos.width > 0 && nodePos.height > 0 && nodePos.y > 0 && canvas.getIframeHeight() - nodePos.y) {
				var top = nodePos.y  + canvas.getIframeTop() - _BUTTON_OFFSET;
				if ( top < 0 ){
					top = -6; 
				}
				$tx.setStyle(_elBtn, { 
					top: top.toPx(), 
					left: (nodePos.x).toPx()
				});
				$tx.show(_elBtn);
			}else{
				$tx.hide(_elBtn);	
			}
		}
		
		toolbar.tools['table'].availableButton = function(node){
			var klass = node.className; 
			if(klass.indexOf("txc-table") > -1) {
				return true;
			}
			if (klass.indexOf("txc-") > -1 || klass.indexOf("tx-") > -1)  {
				return false;
			}
			return true;
		}
		canvas.observeMouseover("table", 
			function(node, nodePos){
				if ( !node ){
					return;
				}
				if ( toolbar.tools['table'].availableButton(node) ){
					_hoverdTableNode = node;
					_showButton(nodePos);
				} else{
					_hoverdTableNode = null;
					$tx.hide(_elBtn);
				}
				throw $stop;
			},
			function(){
				_hoverdTableNode = null;
				$tx.hide(_elBtn);
			}
		);
		
		canvas.observeJob(Trex.Ev.__CANVAS_PANEL_SCROLLING, function(ev) {
			if(_hoverdTableNode) {
				var _nodePos = this.getPositionByNode(_hoverdTableNode);
				_showButton(_nodePos);
			}
		});
		_eventBinding();
	}
);