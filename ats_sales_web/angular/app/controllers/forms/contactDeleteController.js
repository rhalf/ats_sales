var app = angular.module('app');

app.controller('contactDeleteController', function (
    $scope,
    $uibModalInstance,

    modalFactory,
    loaderFactory,
    logFactory,

   Contact,
   contact,
   parent

    ) {

    $scope.init = function () {
        $scope.contact = contact;
    };

    $scope.delete = function () {
        loaderFactory.isLoading = true;

        Contact.delete(
            { id: $scope.contact.id },
            function (result) {
                modalFactory.show('success', '1 contact deleted successfully');
                logFactory.write('delete', $scope.contact.name, '1 contact deleted successfully');

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



