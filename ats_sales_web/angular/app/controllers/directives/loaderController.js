var app = angular.module('app');

app.controller('loaderController', function (
    $scope,
    loaderFactory
    ) {

    $scope.isLoading = function () {
        return loaderFactory.isLoading;
    };
});