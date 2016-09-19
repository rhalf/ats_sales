var app = angular.module('app');

app.controller('productOfferedDeleteController', function (
    $scope,
    $uibModalInstance,

    modalFactory,
    loaderFactory,
    logFactory,

    ProductOffered,
    productOffered,
    parent

    ) {

    $scope.init = function () {
        $scope.productOffered = productOffered;
    };

    $scope.delete = function () {
        loaderFactory.isLoading = true;

        ProductOffered.delete(
            { id: $scope.productOffered.id },
            function (result) {
                modalFactory.show('success', '1 productOffered deleted successfully');
                logFactory.write('delete', $scope.productOffered.contact.name, '1 productOffered deleted successfully');

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



