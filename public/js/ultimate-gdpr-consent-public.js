(function($) {
	'use strict';

	var pluginName = 'ultimate_gdpr_consent';
	var defaults = { hello: 'World' };

	// Plugin Constructor
	function Plugin(element, options) {
		this.element = element;
		this.options = $.extend({}, defaults, options);
		this._defaults = defaults;

		this._name = pluginName;
		this.init();
	}

	$.extend(Plugin.prototype, {
		init: function() {
			this.elements = {};
			this.elements.body = $('body');
			this.elements.cookie_bar = $('#ugc-cookie-bar');
			this.elements.cookie_bar_height = this.elements.cookie_bar.outerHeight();
			this.elements.cookie_toggle = $('#ugc-cookie-toggle');
			this.elements.acceptButton = $('#ugc-button-accept');
			this.elements.declineButton = $('#ugc-button-decline');

			this.initCookieBar();

			this.checkCookiesOptions();
			this.onScroll();
			this.onAccept();
			this.onDecline();
			this.onToggle();
		},
		checkCookiesOptions: function() {
			var self = this;
			$.ajax({
				type: 'post',
				url: self.options.ajax_url,
				dataType: 'json',
				data: {
					action: 'ultimate_gdpr_consent_check_cookies_options'
				}
			});
		},
		initCookieBar: function() {
			var self = this;
			if (self.elements.body.hasClass('ugc-padded-top')) {
				self.elements.body.css('padding-top', self.elements.cookie_bar.outerHeight() + 'px');
			}
			if (
				self.elements.cookie_bar.hasClass('ugc-auto-hide') &&
				!self.elements.cookie_bar.hasClass('ugc-allowed') &&
				!self.elements.cookie_bar.hasClass('ugc-declined')
			) {
				setTimeout(function() {
					self.elements.cookie_bar.addClass('ugc-hidden');
				}, parseInt(this.options.auto_hide_delay));
			}
		},
		onScroll: function() {
			var self = this;
			$(document).scroll(function() {
				var y = $(this).scrollTop();
				if (
					self.elements.cookie_bar.hasClass('ugc-show-scroll') &&
					self.elements.cookie_bar.hasClass('ugc-hidden') &&
					!self.elements.cookie_bar.hasClass('ugc-allowed') &&
					!self.elements.cookie_bar.hasClass('ugc-declined')
				) {
					if (y > parseInt(self.options.scroll_offset) || $(window).scrollTop() == $(document).height() - $(window).height()) {
						self.elements.cookie_bar.removeClass('ugc-hidden').addClass('ugc-scroll-show');
					}
				}
			});
		},
		onDecline: function() {
			var self = this;
			self.elements.declineButton.on('click', function(e) {
				if (!self.elements.declineButton.hasClass('ugc-button-url')) {
					e.preventDefault();
					self.hideCookieBar();
				}
				$.ajax({
					type: 'post',
					url: self.options.ajax_url,
					dataType: 'json',
					data: {
						action: 'ultimate_gdpr_consent_decline_cookies'
					},
					success: function() {
						self.elements.cookie_bar.addClass('ugc-force-hide ugc-hidden');
						self.hideCookieBar();
					}
				});
			});
		},
		onAccept: function() {
			var self = this;
			self.elements.acceptButton.on('click', function(e) {
				e.preventDefault();
				self.hideCookieBar();
				$.ajax({
					type: 'post',
					url: self.options.ajax_url,
					dataType: 'json',
					data: {
						action: 'ultimate_gdpr_consent_allow_cookies'
					},
					success: function() {
						self.elements.cookie_bar.addClass('ugc-force-hide ugc-hidden');
					}
				});
			});
		},
		onToggle: function() {
			var self = this;
			self.elements.acceptButton.on('click', function() {
				self.elements.cookie_toggle.toggleClass('ugc-toggle-hide ugc-hidden');
			});
			self.elements.declineButton.on('click', function() {
				self.elements.cookie_toggle.toggleClass('ugc-toggle-hide ugc-hidden');
			});
			self.elements.cookie_toggle.on('click', function() {
				self.elements.cookie_toggle.toggleClass('ugc-toggle-hide');
				self.elements.cookie_bar.removeClass('ugc-allowed ugc-declined ugc-hidden ugc-force-hide');
				self.showCookieBar();
			});
		},
		showCookieBar: function() {
			var self = this;
			self.elements.cookie_bar.css({
				'-webkit-transform': 'translateY(0px)',
				'-moz-transform': 'translateY(0px)',
				'-ms-transform': 'translateY(0px)',
				'-o-transform': 'translateY(0px)',
				transform: 'translateY(0px)'
			});
		},
		hideCookieBar: function() {
			var self = this;
			if (self.elements.cookie_bar.hasClass('ugc-fixed-top')) {
				self.elements.cookie_bar.css({
					'-webkit-transform': 'translateY(-' + self.elements.cookie_bar_height + 'px)',
					'-moz-transform': 'translateY(-' + self.elements.cookie_bar_height + 'px)',
					'-ms-transform': 'translateY(-' + self.elements.cookie_bar_height + 'px)',
					'-o-transform': 'translateY(-' + self.elements.cookie_bar_height + 'px)',
					transform: 'translateY(-' + self.elements.cookie_bar_height + 'px)'
				});
			} else if (self.elements.cookie_bar.hasClass('ugc-fixed-bottom')) {
				self.elements.cookie_bar.css({
					'-webkit-transform': 'translateY(' + self.elements.cookie_bar_height + 'px)',
					'-moz-transform': 'translateY(' + self.elements.cookie_bar_height + 'px)',
					'-ms-transform': 'translateY(' + self.elements.cookie_bar_height + 'px)',
					'-o-transform': 'translateY(' + self.elements.cookie_bar_height + 'px)',
					transform: 'translateY(' + self.elements.cookie_bar_height + 'px)'
				});
			}
		}
	});

	// Constructor wrapper
	$.fn[pluginName] = function(options) {
		return this.each(function() {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
		});
	};

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function() {
		$('body').ultimate_gdpr_consent(ultimate_gdrp_content_options);
	});
})(jQuery);
