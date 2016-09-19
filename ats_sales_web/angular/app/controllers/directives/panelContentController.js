var app = angular.module('app');

app.controller('panelContentController', function (
    $scope,
    contentFactory
    ) {
    $scope.init = function () {
        $scope.contentFactory = contentFactory;
    };

    $scope.init();
});