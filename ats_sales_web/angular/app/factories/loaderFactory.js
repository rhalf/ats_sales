var app = angular.module('app');

app.factory('loaderFactory', function () {

    var loaderFactory = [];

    loaderFactory.isLoading = false;

    return loaderFactory;
});