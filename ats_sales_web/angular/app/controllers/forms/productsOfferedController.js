var app = angular.module('app');

app.controller('productsOfferedController', function (
    $scope,
    $uibModal,
    loaderFactory,
   paginationFactory,

   ProductOffered

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;
        $scope.load();
    };


    $scope.load = function () {
        loaderFactory.isLoading = true;
        $scope.productsOffered = ProductOffered.query(
            function (result) {
                loaderFactory.isLoading = false;
            },
            function (result) {
                loaderFactory.isLoading = false;
            });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_offered_insert.html',
            controller: 'productOfferedInsertController',
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.edit = function (productOffered) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_offered_update.html',
            controller: 'productOfferedUpdateController',
            size: 'md',
            resolve: {
                parent: $scope,
                productOffered: productOffered
            }
        });
    };
    $scope.delete = function (productOffered) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_offered_delete.html',
            controller: 'productOfferedDeleteController',
            size: 'md',
            resolve: {
                parent: $scope,
                productOffered: productOffered
            }
        });
    };

    $scope.init();
});



