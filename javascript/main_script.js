/**
 * Created by D-Beatz on 10/1/16.
 */

var app = angular.module("discourse",["ngRoute"]);

app.config(function($routeProvider) {
	$routeProvider
		.when("/", {
			templateUrl : "views/home.html",
			controller : "homeController"
		})
		.when("/search",{
			templateUrl : "views/search.html",
			controller : "searchController"
		})
		.when("/about", {
			templateUrl : "views/about.html",
			controller : "aboutController"
		});
});