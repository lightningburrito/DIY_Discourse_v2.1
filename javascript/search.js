
var app = angular.module("discourse");

app.controller("SearchController", ["$scope", "$mdDialog", "$http", SearchController]);

function SearchController($scope, $mdDialog, $http)
{
    $scope.searchParams = {
        main_data: {},
        numerical_data: {},
        special_data: {}
    };


    $scope.search = function()
    {
        $http({
            method: 'POST',
            url: '/diy_dfeist/php/test.php',
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
        };

    function ParametersDialogCtl($scope, params, $mdDialog, $mdToast) {
        function Init()
        {
            $scope.params = params;
            console.log(params);
        }
        $scope.hide = function() {
            $mdDialog.hide();
        };

        $scope.cancel = function() {
            $mdDialog.cancel();
        };

        Init();
    }
    $scope.openParametersDialog = function(ev)
    {
        $mdDialog.show({
            controller: ParametersDialogCtl,
            locals: {params: $scope.searchParams},
            templateUrl: 'views/dialogs/input_dialog.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true
        })
    };
}