/**
 * Created by D-Beatz on 10/1/16.
 */

var app = angular.module("discourse");

app.controller("searchController", ["$scope", SearchController]);

function SearchController($scope)
{
	$scope.openSpecialized = true;
	$scope.openNumerical = false;

}