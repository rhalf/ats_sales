var app = angular.module('app');

app.controller('companyDeleteController', function (
    $scope,
    $uibModalInstance,

    modalFactory,
    loaderFactory,
    logFactory,

   Company,
   company,
   parent

    ) {

    $scope.init = function () {

    };

    $scope.delete = function () {
        loaderFactory.isLoading = true;

        Company.delete(
            { id : company.id },
            function (result) {

                modalFactory.show('success', '1 company deleted successfully');
                logFactory.write('delete', company.name, '1 company deleted successfully');

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



