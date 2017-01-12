
var app = angular.module("discourse");

app.controller("SearchController", ["$scope", "$http", SearchController]);

function SearchController($scope, $http)
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

    $scope.search = function()
    {
        $http({
            method: 'POST',
            url: 'http://134.129.210.126/diy_dfeist/php/test.php',
            data: "test",
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            console.log(response);
            $scope.gridOptions.data = response.data;
        }, function (response) {
            console.log(response);
        });
    };

    $scope.gridOptions =
        {
            columnDefs: [
                {
                    displayName: "ID",
                    name: "id"
                },
                {
                    displayName: "Author",
                    name: "author"
                },
                {
                    displayName: "Ups",
                    name: "ups"
                },
                {
                    displayName: "Downs",
                    name: "downs"
                },
                {
                    displayName: "Score",
                    name: "score"
                },
                {
                    displayName: "Body",
                    name: "body"
                }
            ],
            data: [

            ]
        }

}