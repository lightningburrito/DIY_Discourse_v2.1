/**
 * Created by D-Beatz on 10/1/16.
 */
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


var app = angular.module("discourse", ["ui.grid", "ui.grid.edit"]);

app.controller("searchController", ["$scope", SearchController]);

/*app.config(function($routeProvide, $locationProvider) {
	$routeProvider
		.when("/",{
			templateUrl : "views/home.html"
		})
        .when("/search",{
            templateUrl : "views/search.html",
            controller : "SearchController"
        })
		.when("/about", {
			templateUrl : "views/about.html",
			controller : "AboutController"
		})
        .otherwise({redirectTo: '/'});

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
});*/

function SearchController($scope)
{
    $scope.openMain = false;
    $scope.openSpecialized = false;
    $scope.openNumerical = false;

    $scope.editMain = function()
    {
        $scope.openMain = true;
    };
    $scope.editSpecialized = function ()
    {
        $scope.openSpecialized = true;
    };
    $scope.editNumerical = function ()
    {
        $scope.openNumerical = true;
    };
    $scope.gridOptions =
    {
        columnDefs: [
            {
                name: "id"
            }
        ],
        data: [
            {
                "id": "42"
            }
        ]
    }

}