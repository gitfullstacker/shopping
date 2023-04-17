Trex.I.AlignExecution = Trex.Mixin.create(/** @lends Trex.I.AlignExecution */{
	executeAlignImageMode: function(processor) {
		var _imageAlignProps = this.constructor.__ImageModeProps['image'];
		var _node = processor.getControl();
		if(!_node) {
			return;
		}
		processor.apply(_node, _imageAlignProps);

		var _textAlignProps = this.constructor.__ImageModeProps['paragraph'];
		if (_textAlignProps) {
			var _wNode = $tom.find(_node, "%paragraph");
			processor.apply(_wNode, _textAlignProps);
		}
	},
	executeAlignTextMode: function(processor) {
		var _textAlignProps = this.constructor.__TextModeProps['paragraph'];
		var _node = processor.getControl();
		if(_node) {
			processor.apply(_node, {
				'align': _textAlignProps['style']['textAlign']
			});
			if($tom.kindOf(_node, 'button')) {
				var _wNode = $tom.find(_node, '%paragraph');
				if (_wNode) {
					processor.apply(_wNode, _textAlignProps);
				}
				var _tNode = $tom.collect(_node, 'table');
				if(_tNode) {
					processor.apply(_tNode, {
						'align': _textAlignProps['style']['textAlign']
					});
				}
			}
		} else {
			var _nodes = processor.blocks(function(){
				return '%paragraph';
			});
			processor.apply(_nodes, _textAlignProps);
			_nodes = processor.controls(function(){
				return 'hr,table';
			});
			processor.apply(_nodes, {
				'align': _textAlignProps['style']['textAlign']		
			});
		}
	},
	queryImageFloat: function(processor) {
		var _node = processor.getControl();
		if (_node) {
			return processor.queryStyle(_node, 'float');
		} else {
			return null;
		}
	},
	queryTextAlign: function(processor) {
		var _node = processor.findNode('%paragraph');
		var _value = processor.queryStyle(_node, 'textAlign');
		if(!_value) {
			_value = processor.queryAttr(_node, 'align');
		}
		if(!_value || _value == "start") {
			_value = 'left';
		}
		return _value;
	},
	queryControlAlign: function(processor) {
		var _node = processor.getControl();
		if (_node) {
			_value = processor.queryAttr(_node, 'align');
			return _value || "left";
		} else {
			return null;
		}
	}
});