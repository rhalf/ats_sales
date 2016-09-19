var app = angular.module('app');

app.controller('productUpdateController', function (
    $scope,
    $uibModalInstance,

    paginationFactory,
    loaderFactory,
    modalFactory,
    sessionFactory,
    logFactory,

    Product,

    company,
    product,
    parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.product = product;
    };

    $scope.save = function () {

        $scope.product.company = company;

        loaderFactory.isLoading = true;

        Product.update(
            {id :  $scope.product.id},
            $scope.product,
            function (result) {
                modalFactory.show('success', '1 product updated successfully');
                logFactory.write('update', $scope.product.name, '1 product updated successfully');

                loaderFactory.isLoading = false;
                parent.load();
                $scope.cancel();
            },
            function (result) {
                modalFactory.show('error', result.data.message);
                loaderFactory.isLoading = false;
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});



