var app = angular.module('app');

app.controller('logsController', function (
    $scope,

    loaderFactory,
    paginationFactory,

    Log

    ) {

    $scope.init = function () {
        loaderFactory.isLoading = true;

        $scope.paginationFactory = paginationFactory;
        $scope.logs = Log.query(
            function (result) {
                loaderFactory.isLoading = false;
            },
            function (result) {
                loaderFactory.isLoading = false;
            });
    };

    $scope.init();
});



