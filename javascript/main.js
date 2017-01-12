/**
 * Created by D-Beatz on 10/1/16.
 */

var app = angular.module("discourse", ["ngMaterial", "ngRoute", "ui.grid", "ui.grid.edit"]);

app.controller("NavCtrl", ["$scope", "$http", NavCtrl]);

function NavCtrl($scope, $http)
{
    $scope.openMenu = function($mdOpenMenu, ev) {
        originatorEv = ev;
        $mdOpenMenu(ev);
    };
}

app.config(function($routeProvider, $locationProvider) {
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
app.config(function($mdThemingProvider) {

    $mdThemingProvider.theme('default')
        .primaryPalette('light-blue');

});