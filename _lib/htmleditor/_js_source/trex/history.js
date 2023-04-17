/**
 * @fileoverview default history class for redo/undo 
 *  
 * @author iamdanielkim
 */


/**
 * @namespace
 */
(function(){
	var __UNDO_COUNT = 20;
	
	/**
	 * @class
	 */
	Trex.History = Trex.Class.create({});
	Trex.History.prototype = {
		canvas: null,
		initialContent: null,
		undoTaskList: null,
		redoTaskList: null,
		currentTask: null,
		snapshotData: {},
		inithandlers: [],
		isNewTypingForUndo: false,
		/**
		 * initialize 
		 * @param {Object} canvas
		 * @param {Object} config
		 */
		initialize: function(canvas, config){
			var self = this;
			var _canvas = this.canvas = canvas;
						 		
			this.currentTask = new Trex.History.Task({
					'content': config.bogus_html,
					'scrollTop': 0
				},
				function(data) {
					self.inithandlers.each(function(inithandler) {
						inithandler(data);
					});
				}
			);
			this.currentTask.makeSnapshot(this.snapshotData);

			this.undoTaskList = [];
			this.redoTaskList = [];
			
			_canvas.observeJob('canvas.panel.undo', function(){
				var _processor = _canvas.getProcessor();
				if (!_processor) {
					return;
				}
				if (self.undoTaskList.length == 0) {
					return;
				}
				
				if(self.isNewTypingForUndo) {
					var _data = self.getTextData();
					var _handler = self.getTextHandler();
					var _task = new Trex.History.Task(_data, _handler);
					_task.makeBackup(self.snapshotData);
					self.redoTaskList = [_task];
					
					_task.undo();
					self.isNewTypingForUndo = false;
				} else {
					var _task = self.currentTask;
					if (self.redoTaskList.length > __UNDO_COUNT - 1) { //max size
						self.redoTaskList.shift();
					}
					self.redoTaskList.push(_task);
					
					_task.undo();
					_task.makeSnapshot(self.snapshotData);
					
					var _undoTask = self.undoTaskList.last();
					if (self.undoTaskList.length > 0) {
						self.undoTaskList.pop();
					}
					self.currentTask = _undoTask;
				}
			});
			
			_canvas.observeJob('canvas.panel.redo', function(){
				var _processor = _canvas.getProcessor();
				if (!_processor) {
					return;
				}
				if (self.redoTaskList.length == 0) {
					return;
				}
				
				var _task = self.currentTask;
				if (self.undoTaskList.length > __UNDO_COUNT - 1) { //max size
					self.undoTaskList.shift();
				}
				self.undoTaskList.push(_task);
				
				var _redoTask = self.redoTaskList.last();
				if (self.redoTaskList.length > 0) {
					self.redoTaskList.pop();
				}
				self.currentTask = _redoTask;
				
				_redoTask.redo();
				_redoTask.makeSnapshot(self.snapshotData);
			});
		},
		/**
		 * initHistory
		 * 
		 * @type 
		 * @param {Object} content
		 */	
		initHistory: function(data){
			Object.extend(this.snapshotData, data);
			this.isNewTypingForUndo = true;
			//this.initialContent = content;
			/*this.undoTaskList = [{
				content: content,
				scrollTop: 0
			}];*///TODO
		},
		addInitHandler: function(data, handler) {
			Object.extend(this.current.current, data);
			this.inithandlers.push(handler);
			Object.extend(this.snapshotData, data);
		},
		/**
		 * saveHistory
		 *  
		 * @param {boolean} force
		 */
		saveHistory: function(data, handler){
			if (this.undoTaskList.length > __UNDO_COUNT - 1) {
				this.undoTaskList.shift();
			}
			
			this.undoTaskList.push(this.currentTask);
			this.redoTaskList = [];
						
			if(!data) {
				data = this.getTextData();
				handler = this.getTextHandler();
			}
			
			var _task = new Trex.History.Task(data, handler);
			_task.swapData(this.snapshotData);
			this.currentTask = _task;
			//this.snapshot = Object.extend( this.snapshot, data );

			this.isNewTypingForUndo = false;
		},
		saveHistoryByKey: function(key){
			if ( key.code == 229 ){				// ignore mouse click.
				return;
			}
			
			if (key.code == Trex.__KEY.ENTER || key.code == Trex.__KEY.SPACE) {
				if (this.isNewTypingForUndo) {
					this.saveHistory();
				}
			} else if(key.code == Trex.__KEY.DELETE || key.code == Trex.__KEY.BACKSPACE) {
				this.saveHistory();
			} else if((key.code == Trex.__KEY.PASTE || key.code == Trex.__KEY.CUT) && key.ctrl) {
				this.saveHistory(true);
			} else if (((key.code > 32 && key.code < 41) && key.shift) || (key.code == 65 && key.ctrl)) {
				if (this.isNewTypingForUndo) {
					this.saveHistory();
				}
			} else if (key.ctrl || key.shift || key.alt) {
			} else {
				this.isNewTypingForUndo = true;
			}
		},
		injectHistory: function(data, handler){
			this.currentTask.injectHandler( handler );
			this.currentTask.injectData(data, this.snapshotData);
		},
		getTextHandler: function() {
			var _canvas = this.canvas;
			return function(data) {
				_canvas.setContent(data.content);
				_canvas.setScrollTop(data.scrollTop);
			}
		},
		getTextData:function(){
			var _canvas = this.canvas;
			return {	
				'content': _canvas.getContent(),
				'scrollTop': _canvas.getScrollTop()
			}
		}
	};
	
	Trex.History.Task = Trex.Class.create({
		/**
		 * initialize
		 * @param {Object} data
		 * @param {Function} config
		 */
		initialize: function(data, handler){
			this.handler = [];
			this.previous = {};
			this.current = Object.extend({}, data);
			this.handler.push(handler);
		},
		swapData: function(snapshotData) {
			this.makeBackup(snapshotData);
			this.makeSnapshot(snapshotData);
		},
		makeBackup: function(snapshotData){					// 현재의 상태를 받아서 task에 과거의 데이터로 저장해둔다.
			for(var _name in this.current) {
				if ( typeof snapshotData[_name] == "string" || typeof snapshotData[_name] == "number"){
					this.previous[_name] = snapshotData[_name];
				} else {
					this.previous[_name] = Object.extend( {}, snapshotData[_name] );
				}
			}
		},
		makeSnapshot: function(snapshotData) {
			for(var _name in this.current) {
				snapshotData[_name] = this.current[_name]; //reference copy
			}
		},
		injectHandler: function(handler){
			this.handler.push( handler );		
		},
		injectData: function(data, snapshotData){
			Object.extend( this.current, data );
			// make backup과 mak snapshot를 수행한다.
			for( var _name in data ){
				if ( typeof snapshotData[_name] == "string" || typeof snapshotData[_name] == "number"){
					this.previous[_name] = snapshotData[_name];
				}else{
					this.previous[_name] = Object.extend( {}, snapshotData[_name] );
				}
			}
			
			for(var _name in this.current) {
				snapshotData[_name] = this.current[_name]; //reference copy
			}
		},
		redo: function() {
			for( var i = 0; i < this.handler.length; i++ ){
				this.handler[i](this.current);	
			}
		},
		undo: function() {
			for( var i = 0; i < this.handler.length; i++ ){
				this.handler[i](this.previous);	
			}
		}
	});
	
})();


