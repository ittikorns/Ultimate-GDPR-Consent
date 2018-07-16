(function($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	var pluginName = 'ultimate_gdpr_consent';
	var defaults = { hello: 'World' };

	function Plugin(element, options) {
		this.element = element;
		this.options = $.extend({}, defaults, options);
		this._defaults = defaults;

		this._name = pluginName;
		this.init();
	}

	$.extend(Plugin.prototype, {
		init: function() {
			var self = this;
			this.elements = {};
			this.elements.navTabWrapper = $('#ugc-nav-tab-wrapper.nav-tab-wrapper');
			this.elements.navTab = $('.ugc-nav-tab.nav-tab');
			this.elements.tabs = $('.ugc-tab');

			this.enableNavTabs();
		},
		enableNavTabs: function() {
			var self = this;
			self.elements.navTab.on('click', function(e) {
				e.preventDefault();
				var target_tab = $(this).attr('href');
				// Set Tab as Active
				self.elements.navTab.removeClass('nav-tab-active');
				$(this).addClass('nav-tab-active');
				// Hide other tabs and show the clicked tab
				self.elements.tabs.removeClass('ugc-tab-active');
				$(target_tab).addClass('ugc-tab-active');
				console.log('test');
			});
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

	$(document).ready(function() {
		$('body').ultimate_gdpr_consent();
	});

	// Define the `phonecatApp` module
	var ugcApp = angular.module('ugcApp', ['color.picker']);

	// Define the `PhoneListController` controller on the `ugcApp` module
	ugcApp.controller('GeneralSetting', [
		'$scope',
		'$timeout',
		'$http',
		'ugcFactory',
		function($scope, $timeout, $http, ugcFactory) {
			$scope.form = {};
			$scope.colorPickerOptions = {
				format: 'rgb',
				allowEmpty: true
			};
			ugcFactory.getSetting($scope).then(
				function(response) {
					$scope.form = response.data;
				},
				function(error) {
					console.error(error);
				}
			);
			$scope.saveChanges = function() {
				ugcFactory.saveSetting($scope).then(
					function(response) {
						ugcFactory.showAlert({ result: true, title: 'Saved' });
					},
					function(error) {
						console.error(error);
					}
				);
			};
			$scope.sendPolicyUpdates = function($event) {
				$($event.currentTarget)
					.val('Sending...')
					.attr('disabled', true)
					.removeClass('button-primary');
				ugcFactory.sendPolicyUpdates($scope).then(function(response) {
					$($event.currentTarget)
						.val('All done!')
						.attr('disabled', false)
						.addClass('button-primary');
				});
			};
		}
	]);

	ugcApp.factory('ugcFactory', [
		'$http',
		function($http) {
			var factory = {};

			factory.showAlert = function(result) {
				if (result.result) {
					if (typeof result.title === 'undefined') {
						result.title = 'Good job!';
					}
					swal({
						title: result.title,
						text: result.message,
						timer: 1200,
						type: 'success'
					});
				} else {
					if (typeof result.title === 'undefined') {
						result.title = 'Oops...';
					}
					swal({
						title: result.title,
						text: result.message,
						timer: 1200,
						type: 'error'
					});
				}
			};

			factory.getSetting = function($scope) {
				console.log('querying setting');
				$scope.post_data = {
					action: 'ugc_get_settings'
				};
				return factory.doPostAjaxHttpRequest($scope);
			};

			factory.saveSetting = function($scope) {
				$scope.post_data = {
					action: 'update',
					option_page: plugin_name,
					_wpnonce: $('input#_wpnonce').val(),
					'ultimate-gdpr-consent': $scope.form
				};
				return factory.doPostOptionsHttpRequest($scope);
			};

			factory.sendPolicyUpdates = function($scope) {
				$scope.post_data = {
					action: 'ugc_send_policy_updates'
				};
				return factory.doPostAjaxHttpRequest($scope);
			};

			factory.doPostOptionsHttpRequest = function($scope) {
				return $http({
					url: admin_url + 'options.php',
					method: 'POST',
					data: $.param($scope.post_data),
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				});
			};

			factory.doPostAjaxHttpRequest = function($scope) {
				return $http({
					url: ajaxurl,
					method: 'POST',
					data: $.param($scope.post_data),
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				});
			};

			return factory;
		}
	]);
})(jQuery);
