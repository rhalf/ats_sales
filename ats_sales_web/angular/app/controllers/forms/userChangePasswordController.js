var app = angular.module('app');

app.controller('userChangePasswordController', function (
    $scope,
    $filter,
    $uibModalInstance,

    paginationFactory,
    loaderFactory,
    modalFactory,
    sessionFactory,
    logFactory,


    UserCredential,

    parent,
    user
    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;
        $scope.user = user;

        $scope.password1 = "";
        $scope.password2 = "";
 

    };

    $scope.update = function () {

        loaderFactory.isLoading = true;
        //=====================================================================
        //Validation
        //=====================================================================
        if ($scope.password1 != $scope.password2) {
            modalFactory.show('error', 'Password did not match.');
            loaderFactory.isLoading = false;
            return;
        }
        if ($scope.password1.length < 6) {
            modalFactory.show('error', 'Password length must be 6 letters or more.');
            loaderFactory.isLoading = false;
            return;
        }

        $scope.user.password = $scope.password1;

        UserCredential.update(
            { id: $scope.user.id },
            $scope.user,
            function (result) {
                modalFactory.show('success', '1 user password updated successfully');
                logFactory.write('update', $scope.user.name, '1 user password updated successfully');

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



