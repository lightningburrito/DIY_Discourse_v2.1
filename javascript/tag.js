
var app = angular.module("discourse");

app.controller("TagController", ["$scope", "$http", TagController]);

function TagController($scope, $http)
{
    function Init()
    {
        $scope.tag = null;
        $scope.tags = [
            {
                id: 1,
                name: "space"
            },
            {
                id: 2,
                name: "earth"
            }
        ];
    }

    $scope.gridOptions =
        {
            columnDefs: [
                {
                    displayName: "ID",
                    name: "id",
                    width: "100"
                },
                {
                    displayName: "Subreddit",
                    name: "subreddit",
                    width: "140"
                },
                {
                    displayName: "Author",
                    name: "author",
                    width: "120"
                },
                {
                    displayName: "Ups",
                    name: "ups",
                    width: "80"
                },
                {
                    displayName: "Downs",
                    name: "downs",
                    width: "80"
                },
                {
                    displayName: "Score",
                    name: "score",
                    width: "80"
                },
                {
                    displayName: "Body",
                    name: "body"
                }
            ],
            enableRowSelection: true,
            enableSelectAll: true,
            selectionRowHeaderWidth: 35,
            enableGridMenu: true,
            exporterCsvFilename: 'data.txt',
            exporterSuppressColumns: ["id", "subreddit", "author", "ups", "downs", "score"], //sets it so the comment body is the only data exported
            data: [],
            rowTemplate: '<div ng-click="grid.appScope.gridRowClick($event, row)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>'
        };
    $scope.gridOptions.onRegisterApi = function(gridApi){
        //set gridApi on scope
        $scope.gridApi = gridApi;
    };

    Init();
}