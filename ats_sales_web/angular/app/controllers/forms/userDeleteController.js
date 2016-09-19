var app = angular.module('app');

app.controller('userDeleteController', function (
    $scope,
    $uibModalInstance,

    modalFactory,
    loaderFactory,
    logFactory,

    User,
    user,
    parent

    ) {

    $scope.init = function () {
        $scope.user = user;
    };

    $scope.delete = function () {
        loaderFactory.isLoading = true;

        User.delete(
            { id: $scope.user.id },
            function (result) {
                modalFactory.show('success', '1 user deleted successfully');
                logFactory.write('delete', $scope.user.name, '1 user deleted successfully');

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



