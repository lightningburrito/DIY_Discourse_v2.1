
/*
* Accesses the discourse module for the application
*/
var app = angular.module("discourse");

/*
* Defines the Controller for the Search View, including the dependencies and the controller function to use
*/
app.controller("SearchController", ["$scope", "$mdDialog", "$http", SearchController]);

/*
* Function that gets attached to the SearchController. Takes in the $scope and $http angular variables,
* as well as the $mdDialog material design variable for making dialog boxes
*/
function SearchController($scope, $mdDialog, $http)
{
    //Defining the search parameters object that will be used to make the query client side
    $scope.searchParams = {
        request_number: 0, //used server side for determining for retrieving chunks of data at a time
        main_data: {
            //array of objects used to search for keywords
            string_params: [

            ],
            //array of objects to search for words/sentences of various sizes
            num_params: [

            ],
            edited: "",
            archived: "",
            distinguished: "",
            score_hidden: ""
        },
        numerical_data: {
            retrieved_on: "", //date
            created_utc: "", //date
            up_votes: "",
            down_votes: "",
            score: "",
            gilded: "",
            controversiality: ""
        },
        special_data: {
            subreddit: "",
            author: "",
            comment_id: "",
            subreddit_id: "",
            parent_id: "",
            link_id: "",
            name: "",
            author_flair_text: "",
            author_flair_class: ""
        }
    };
    /*
    * Runs the first search for a new query. Gets called when the Search button is pressed.
    * Sets request_number to 0 because calling this method means that you are starting a new
    * sequence of data retrievals
    */
    $scope.firstSearch = function () {
        $scope.searchParams.request_number = 0;
        $scope.search();
    };

    /*
    * Sends the http request to make the search
    *
    */
    $scope.search = function()
    {
        $http({
            method: 'POST',
            url: '/diy_dfeist/php/search.php',
            data: JSON.stringify($scope.searchParams),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            console.log(response);
            if($scope.searchParams.request_number==0)
            {
                //If the request number is 0, then assign the data to the ui-grid data variable
                $scope.gridOptions.data = response.data;
                console.log($scope.gridOptions.data);
            }
            else{
                //If the request number is not 0, concatenate the response data to the ui-grid data variable
                $scope.gridOptions.data = $scope.gridOptions.data.concat(response.data);
                console.log($scope.gridOptions.data);
            }
            $scope.searchParams.request_number++;
        }, function (response) {
            console.log(response);
            $mdDialog.show(
                $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('Search Failed')
                    .textContent(row.entity.body)
                    .ariaLabel("Ya done messed up A. Aron. Try again!")
                    .ok('Got it!')
                    .targetEvent(ev)
            );
        });
    };

    /*
    * Defines the grid options
    */
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
            enableRowSelection: true,
            enableSelectAll: true,
            selectionRowHeaderWidth: 35,
            enableGridMenu: true,
            exporterCsvFilename: 'data.txt',
            exporterSuppressColumns: ["id", "author", "ups", "downs", "score"], //sets it so the comment body is the only data exported
            data: [],
            rowTemplate: '<div ng-click="grid.appScope.gridRowClick($event, row)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>'
        };
    $scope.gridOptions.onRegisterApi = function(gridApi){
        //set gridApi on scope
        $scope.gridApi = gridApi;
    };

    /*
    * Defines the controller used by the dialog to edit parameters
    * Takes in the variables $scope, $mdDialog, and the variable p.
    * P is the local variable name for $scope.search_params (passed by reference).
    * */
    function ParametersDialogCtl($scope, p, $mdDialog) {

        //Initializes the local $scope.params variable
        function Init()
        {
            $scope.params = p;
            console.log($scope.params);
        }
        //Adds a limiter object to the num_params array
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
        //Removes a limiter object from the num_params array
        $scope.removeLimit = function()
        {
            $scope.params.main_data.num_params.pop();
            console.log($scope.params.main_data.num_params);
        };
        //Removes a keyword object from the string_params array
        $scope.removeKeyword = function()
        {
            $scope.params.main_data.string_params.pop();
            console.log($scope.params.main_data.string_params);
        };
        //Adds a keyword object to the string_params array
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

        //Function used to hide the dialog
        $scope.hide = function()
        {
            $mdDialog.hide();
        };

        //Function used to cancel the dialog
        $scope.cancel = function()
        {
            $mdDialog.cancel();
        };

        Init();
    }

    function TagDialogCtl($scope, $mdDialog) {

        function Init()
        {
            $scope.tag = {
                keywords: "",
                description: ""
            };
        }

        //Function used to hide the dialog
        $scope.hide = function()
        {
            $mdDialog.hide();
        };

        //Function used to cancel the dialog
        $scope.cancel = function()
        {
            $mdDialog.cancel();
        };

        Init();
    }

    $scope.openTagDialog = function (ev) {
        $mdDialog.show({
            controller: TagDialogCtl,
            //locals: {p: $scope.searchParams},
            templateUrl: 'views/dialogs/insert_tag_dialog.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true
        })
    };

    $scope.gridRowClick = function (ev, row) {
        $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('Comment Body')
                .textContent(row.entity.body)
                .ariaLabel('Alert Dialog Demo')
                .ok('Got it!')
                .targetEvent(ev)
        );
        console.log(row.entity.body);
    };
    //Opens up the Parameters Dialog
    $scope.openParametersDialog = function(ev) {
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