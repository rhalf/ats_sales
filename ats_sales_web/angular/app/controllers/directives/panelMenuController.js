var app = angular.module('app');

app.controller('panelMenuController', function (
    $scope,
    $location,

    contentFactory,
    sessionFactory
    ) {

    $scope.init = function () {
        $scope.sessionUser = sessionFactory.getUser();
    };

    $scope.init();

    $scope.showCompanies = function () {
        contentFactory.path = '/app/views/forms/companies.html';
    };
    $scope.showProductsOffered = function () {
        contentFactory.path = '/app/views/forms/products_offered.html';
    };
    $scope.showLogs = function () {
        contentFactory.path = '/app/views/forms/logs.html';
    };
    $scope.showMaps = function () {
        contentFactory.path = '/app/views/forms/map.html';
    };
    $scope.showAdmin = function () {
        contentFactory.path = '/app/views/forms/admin.html';
    };
    $scope.logout = function () {
        sessionFactory.setUser(null);
        $location.path('/');
    };

    $scope.init();
});