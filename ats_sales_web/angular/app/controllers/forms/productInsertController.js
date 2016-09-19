var app = angular.module('app');

app.controller('productInsertController', function (
    $scope,
    $uibModalInstance,

   paginationFactory,
   loaderFactory,
   modalFactory,
   sessionFactory,
   logFactory,

   Product,

   company,
   parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.product = new Product();
    };

    $scope.save = function () {

        $scope.product.company = company;

        loaderFactory.isLoading = true;

        Product.save(
            $scope.product,
            function (result) {
                modalFactory.show('success', '1 product added successfully');
                logFactory.write('insert', $scope.product.name, '1 product added successfully');

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



