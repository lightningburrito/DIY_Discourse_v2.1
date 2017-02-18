
var app = angular.module("discourse");

app.controller("SearchController", ["$scope", "$mdDialog", "$http", SearchController]);

function SearchController($scope, $mdDialog, $http)
{
    $scope.searchParams = {
        main_data: {
            string_params: [
                {
                    not: false,
                    keyword: "Search",
                    type: "keyword"
                }
            ],
            num_params: [
                {
                    operator: ">",
                    number: "",
                    type: ""
                }
            ],
            edited: "",
            archived: "",
            distinguished: "",
            score_hidden: ""
        },
        numerical_data: {
            retrieved_on: "",
            created_utc: "",
            up_votes: "",
            down_votes: "",
            score: "",
            gilded: "",
            controversiality: ""
        },
        special_data: {
            subreddit: "",
            author: "YoungModern",
            comment_id: "",
            subreddit_id: "",
            parent_id: "",
            link_id: "",
            name: "",
            author_flair_text: "",
            author_flair_class: ""
        }
    };


    $scope.search = function()
    {
        console.log($scope.searchParams.numerical_data.retrieved_on);
        console.log($scope.searchParams.numerical_data.created_utc);
        $http({
            method: 'POST',
            url: '/diy_aolson/php/test.php',
            data: JSON.stringify($scope.searchParams),
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
                    name: "id",
                    width: "100"
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
            exporterSuppressColumns: ["id", "author", "ups", "downs", "score"],
            data: [

            ]
        };

    function ParametersDialogCtl($scope, p, $mdDialog, $mdToast) {
        function Init()
        {
            $scope.params = p;
            console.log($scope.params);
        }
        $scope.addLimit = function()
        {
            $scope.params.main_data.num_params.push(
                {
                    operator: ">",
                    number: "",
                    type: ""
                }
            );
            console.log($scope.params.main_data.num_params);
        };

        $scope.removeLimit = function()
        {
            $scope.params.main_data.num_params.pop();
            console.log($scope.params.main_data.num_params);
        };

        $scope.removeKeyword = function()
        {
            $scope.params.main_data.string_params.pop();
            console.log($scope.params.main_data.string_params);
        };

        $scope.addKeyword = function ()
        {
            $scope.params.main_data.string_params.push(
                {
                    not: false,
                    keyword: "new thing",
                    type: "keyword"
                }
            );
            console.log($scope.params.main_data.string_params);
        };

        $scope.hide = function()
        {
            $mdDialog.hide();
        };

        $scope.cancel = function()
        {
            $mdDialog.cancel();
        };

        Init();
    }
    $scope.openParametersDialog = function(ev)
    {
        $mdDialog.show({
            controller: ParametersDialogCtl,
            locals: {p: $scope.searchParams},
            templateUrl: 'views/dialogs/input_dialog.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true
        })
    };
}