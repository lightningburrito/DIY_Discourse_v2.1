
var app = angular.module("discourse");

app.controller("TagController", ["$scope", "$http", TagController]);

function TagController($scope, $http)
{
    function Init()
    {
        $scope.selected_tag = null;
        $scope.tag = null;
        $scope.tags = [];
        $scope.getPrevTags();
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
    $scope.getPrevTags = function () {
        $http({
            method: 'POST',
            url: '/diy_dfeist/php/get_tags.php',
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            console.log(response);
            $scope.tags = response.data;
        }, function (response) {
            console.log(response);
            $mdDialog.show(
                $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('Keyword Retrieval Failed')
                    .textContent('Keyword Retrieval Failed')
                    .ariaLabel("Ya done messed up A. Aron. Try again!")
                    .ok('Got it!')
                    .targetEvent(ev)
            );
            $scope.loading = false;
        });
    };
    $scope.getTaggedComments = function () {
        console.log($scope.selected_tag);
        $http({
            method: 'POST',
            url: '/diy_dfeist/php/get_tags_comments.php',
            data: JSON.stringify($scope.selected_tag),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            console.log(response);
            $scope.gridOptions.data = response.data;
        }, function (response) {
            console.log(response);
            $mdDialog.show(
                $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('Comment Retrieval Failed')
                    .textContent('Comment Retrieval Failed')
                    .ariaLabel("Ya done messed up A. Aron. Try again!")
                    .ok('Got it!')
                    .targetEvent(ev)
            );
            $scope.loading = false;
        });
    };

    Init();

    $scope.$watch("selected_tag", function () {
        $scope.new_tag_name = "";
    });
    $scope.$watch("new_tag_name", function () {
        $scope.selected_tag = null;
    });
}