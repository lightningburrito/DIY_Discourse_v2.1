/**
 * Created by D-Beatz on 10/1/16.
 */

var app = angular.module("discourse", ["ngRoute"]);

app.controller("searchController", ["$scope", SearchController]);

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
		data: [

		]
	}

}