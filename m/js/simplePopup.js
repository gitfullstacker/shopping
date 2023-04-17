/*
 *  Project: Vivre
 *  Description: Simple modal/popup for inline elements based on CSS
 *  Author: Adrian Florescu
 *  License: No
 */


/*
 * ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 * How to use this plugin
 * ______________________
 *
 *
 * 1. Create markup (Inline)
 * div.modal__wrapper.is-hidden (Add any custom class for themes e.g. .modal__wrapper--default-theme)
 * 	div.modal__double.js-modal__double
 *
 *
 * 2. Inside of the two div you can do your magic.
 * div.modal__content (This can be any class)
 *
 *
 * 3. Place the close button if needed
 * a.modal__close.js-modal__close
 *
 *
 * 4. Add custom class for the main wrapper to attach the plugin too
 * .js-example-modal
 *
 *
 * 5. Call the plugin when needed
 * $('.js-example-modal').simplePop();
 *
 *
 * How to customize
 * In the SCSS file you can find examples for custom show/hide animations
 *
 * ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 * Api
 * ______________________
 *
 * 1. Class names
 * You can customise the following classes when instantiating the plugin
 * 	classHidden: 'is-hidden'
 * 	classVisible: 'is-visible'
 * 	classInvisible: 'is-invisible'
 * 	classTall: 'is-tall'
 * 	classBellow: 'is-bellow',
 * 	classCloseButton: 'js-modal__close'
 * 	classBackground: 'js-modal__double'

 *
 * 2. Callbacks
 * You have callbacks onClose, onIntentClose, onMistakeClose
 * 	onClose: when the modal is closed
 * 	onIntentClose: when the user clicks on the close button
 * 	onMistakeClose: when the user closes the modal by clicking on the background
 *
 * 3. Example with defaults
 * $('.js-example-modal').simplePop({
 * 	classHidden: 'is-hidden',
 * 	classVisible: 'is-visible',
 *  classInvisible: 'is-invisible',
 *  classTall: 'is-tall',
 *  classBellow: 'is-bellow',
 *  classCloseButton: 'js-modal__close',
 *  classBackground: 'js-modal__double',
 *  closeOthers: true,
 *	closeOthersDelay: 200, //Miliseconds
 *  onOpen: function(element){
 *  	console.log('I am open');
 *  	//'element' is the parent of the modal
 *  }
 *  onClose: function(element){
 *  	console.log('I am closed');
 *  },
 *  onIntentClose: function(element){
 *  	console.log('I am closed from the X')
 *  },
 *  onMistakeClose: function(){
 *  	console.log('I am closed from the background')
 *  }
 * })
 *
 */

;(function ( $, window, document, undefined ) {

	"use strict";

	// Create the defaults once
	var pluginName = "simplePop",
		defaults = {
			classHidden: 'is-hidden',
			classVisible: 'is-visible',
			classInvisible: 'is-invisible',
			classTall: 'is-tall',
			classBellow: 'is-bellow',
			classCloseButton: 'js-modal__close',
			classBackground: 'js-modal__double',
			closeOthers: true,
			closeOthersDelay: 200, //Miliseconds (Use with caution)
			onOpen: function(){
				console.log('I am open');
			},
			onClose: function(){
				console.log('I am closed');
			},
			onIntentClose: function(){
				console.log('I am closed from the X');
			},
			onMistakeClose: function(){
				console.log('I am closed from the background');
			}
		};

	// Private functions can access the plugin
	function _showModal(plugin) {

		console.log('_showModal');

		//Is there any other modals?
		var otherItems = $('.' + pluginName + '__active').not(plugin.element);


		//Should I Kill any?
		if( otherItems.length > 0 && plugin.settings.closeOthers) {
			otherItems.each(function(){
				$(this).data('plugin_' + pluginName).close();
			});
		}


		//Added timeout if closeOthers is true and there are multiple modals here
		setTimeout(function(){

			//Remove classes if any and add the visible class
			$(plugin.element)
				.removeClass(plugin.settings.classBellow + ' ' + plugin.settings.classHidden + ' ' + plugin.settings.classInvisible)
				.addClass(plugin.settings.classVisible)
                .addClass(pluginName + '__active');


			//Add class for all modals behind
			if(otherItems.length > 0) {
				otherItems.each(function(){
					$(this).addClass(plugin.settings.classBellow);
				});
			}

			plugin.settings.onOpen(plugin.element);


			if($(plugin.element).height() > $(window).height()) {
				$(plugin.element).addClass(plugin.settings.classTall);
			}


			//Attach click events to close button and background
			$(plugin.element).on('click', '.' + plugin.settings.classCloseButton + ', .' + plugin.settings.classBackground + '', function(e) {

				//If click inside the modal return
				if (e.target != this && $(e.target).hasClass(plugin.settings.classBackground) !== true) {
					return;
				}

				//If this is the close button
				if ($(this).hasClass(plugin.settings.classCloseButton)) {

					e.preventDefault();

					//Trigger callback
					plugin.settings.onIntentClose(plugin.element);

				} else {

					//Trigger callback
					plugin.settings.onMistakeClose(plugin.element);

				}

				//Close the modal
				plugin.close();

			});

		}, otherItems.length && plugin.settings.closeOthers ? plugin.settings.closeOthersDelay : 0);


	}

	// The actual plugin constructor
	function Plugin ( element, options ) {
		this.element = element;

		// future instances of the plugin
		this.settings = $.extend( {}, defaults, options );
		this._name = pluginName;
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Plugin.prototype, {
		init: function () {

			// Calling a private function that dont have access to "this",
			// you need to pass the plugin
			_showModal(this);

		},
		close: function () {
			//Unbind events and hide
			$(this.element)
				.off()
				.addClass(this.settings.classInvisible)
				.removeClass(this.settings.classVisible)
                .removeClass(pluginName + '__active');

			//Allow another instance now that it's all safe
			$.data(this.element, 'plugin_' + pluginName, null);

			//Trigger callback
			this.settings.onClose(this.element);
		}
	});

	$.fn[pluginName] = function ( options ) {
		var args = arguments;
		// Is the first parameter an object (options), or was omitted,
		// instantiate a new instance of the plugin.
		if (options === undefined || typeof options === 'object') {
			console.log('If 1');
			return this.each(function () {

				// Only allow the plugin to be instantiated once,
				// so we check that the element has no plugin instantiation yet
				if (!$.data(this, 'plugin_' + pluginName)) {

					// if it has no instance, create a new one,
					// pass options to our plugin constructor,
					// and store the plugin instance
					// in the elements jQuery data object.
					$.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
				} else {
					console.log('Already instantiated and not properly closed?');
					_showModal($.data(this, 'plugin_' + pluginName));
				}
			});

			// If the first parameter is a string and it doesn't start
			// with an underscore or "contains" the `init`-function,
			// treat this as a call to a public method.
		} else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
			console.log('else If 1');
			// Cache the method call
			// to make it possible
			// to return a value
			var returns;

			this.each(function () {
				var instance = $.data(this, 'plugin_' + pluginName);

				// Tests that there's already a plugin-instance
				// and checks that the requested public method exists
				if (instance instanceof Plugin && typeof instance[options] === 'function') {

					// Call the method of our plugin instance,
					// and pass it the supplied arguments.
					returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
				}

				// Allow instances to be destroyed via the 'destroy' method
				if (options === 'close') {
					$.data(this, 'plugin_' + pluginName)[options]();
				}
			});

			// If the earlier cached method
			// gives a value back return the value,
			// otherwise return this to preserve chainability.
			return returns !== undefined ? returns : this;
		}
	};

})( jQuery, window, document );

