var app = angular.module('app');

app.controller('alertController', function ($scope, alertFactory) {
    $scope.alertFactory = alertFactory;
});