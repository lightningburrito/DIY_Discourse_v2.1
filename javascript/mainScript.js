/**
 * Created by D-Beatz on 10/1/16.
 */

var app = angular.module("discourse", ["ngRoute"]);

app.config(function($routeProvider) {
	$routeProvider
		.when("/",{
			templateUrl : "../views/search.html",
			controller : "searchController"
		})
		.when("/about", {
			templateUrl : "../views/about.html",
			controller : "aboutController"
		});
});

$.widget("ui.dialog", $.ui.dialog,
	{
		_allowInteraction: function(event)
		{
			return !!$(event.target).closest(".cke_dialog").length
				|| this._super(event);
		}
	});

// Don't automatically focus the first tabbable element when opening a dialog
$.ui.dialog.prototype._focusTabbable = $.noop;
