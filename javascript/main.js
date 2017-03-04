/**
 * Created by D-Beatz on 10/1/16.
 */
/*
* Defines the angular application and all the dependencies
*/
var app = angular.module("discourse",
    ["ngMaterial", "ngRoute", "ui.grid", "ui.grid.edit", 'ui.grid.exporter', 'ui.grid.selection']);

/*
* Defines the NavCtrl controler for navigating tabs
*/
app.controller("NavCtrl", ["$scope", "$http", NavCtrl]);

/*
* Function that defines the controller function for NavCtrl
* Takes in the $scope and $http angular variables
*/
function NavCtrl($scope, $http)
{
    $scope.openMenu = function($mdOpenMenu, ev)
    {
        originatorEv = ev;
        $mdOpenMenu(ev);
    };
}

/*
* Defines the paths used for client side routing, as well as the views and controllers to use
*/
app.config(function($routeProvider, $locationProvider)
{
    $routeProvider
        .when("/search", {
            templateUrl : "views/search.html",
            controller : "SearchController"
        })
        .when("/tag", {
            templateUrl : "views/tag.html",
            controller : "TagController"
        })
        .otherwise({
            redirectTo: "/search"
        });
    //$locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('');
});

/*
* Defines the theme used for the application
*/
app.config(function($mdThemingProvider)
{
    $mdThemingProvider.theme('default')
        .primaryPalette('light-blue');
});