/**
 * Created by D-Beatz on 10/1/16.
 */
$.widget("ui.dialog", $.ui.dialog,
    {
        _allowInteraction: function(event)
        {
            return !!$(event.target).closest(".cke_dialog").length
                || this._super(event);
        }
    });

// Don't automatically focus the first tabbable element when opening a dialog
$.ui.dialog.prototype._focusTabbable = $.noop;


var app = angular.module("discourse", ["ui.grid", "ui.grid.edit"]);

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
            {
                "id": "42",
                "author": "Butters",
                "ups" : "561",
                "downs": "11",
                "score" : "550",
                "body" : "This comment is really intellijent"
            }
        ]
    }

}