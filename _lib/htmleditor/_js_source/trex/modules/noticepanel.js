/**
 * @noticepanel
 * 에디터에서 편집하기 전에 에디터 위에 레이어를 깔아서 서비스가 원하는 메세지를 출력해주는 모듈
 * 
 * @author rockmkd@daumcorp.com
 * @version 1.1 
 */
// #FTDUEDTR-18
Trex.module("Add layer to display notice message on editor area before editing",
	function(editor, toolbar, sidebar, canvas, config){
		if ( config.initializedMessage ) {
			canvas.observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE,  function(ev){
				var _noticeDiv = tx.div({ id: "tx-canvas-notice", className: "tx-canvas-notice"}, config.initializedMessage);
				$tx("tx_canvas").insertBefore( _noticeDiv, $tx("tx_loading") );
				
				var _noticeDivHandler = function(){
					if ($tx("tx-canvas-notice")) {
						$tx("tx_canvas").removeChild(_noticeDiv);
						if (editor.focus) {
							editor.focus();
						}
					}
				};
				
				$tx.observe(_noticeDiv, "click", _noticeDivHandler);
				canvas.observeJob(Trex.Ev.__CANVAS_DATA_INITIALIZE, _noticeDivHandler);
				toolbar.observeJob(Trex.Ev.__TOOL_CLICK,  _noticeDivHandler);
			});
		
		}
		
	}
);
