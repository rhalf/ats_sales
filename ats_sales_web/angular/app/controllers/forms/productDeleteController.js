var app = angular.module('app');

app.controller('productDeleteController', function (
    $scope,
    $uibModalInstance,

    modalFactory,
    loaderFactory,
    logFactory,


   Product,
   product,
   parent

    ) {

    $scope.init = function () {
        $scope.product = product;
    };

    $scope.delete = function () {
        loaderFactory.isLoading = true;

        Product.delete(
            { id: $scope.product.id },
            function (result) {
                modalFactory.show('success', '1 product deleted successfully');
                logFactory.write('delete', $scope.product.name, '1 product deleted successfully');

                loaderFactory.isLoading = false;
                parent.load();
                $scope.cancel();
            },
            function (result) {
                modalFactory.show('error', result.data.message);
                loaderFactory.isLoading = false;
                $uibModalInstance.close();
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});



