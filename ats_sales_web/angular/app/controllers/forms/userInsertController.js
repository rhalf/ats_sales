var app = angular.module('app');

app.controller('userInsertController', function (
    $scope,
    $filter,
    $uibModalInstance,

    paginationFactory,
    loaderFactory,
    modalFactory,
    sessionFactory,
    logFactory,


    User,
    Privilege,
    Status,

    parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.statuses = Status.query();
        $scope.privileges = Privilege.query();
        $scope.user = new User();

        $scope.password1 = "";
        $scope.password2 = "";
        $scope.user.dtRenewed = $filter('dateFilter')(new Date(), null);
        $scope.user.dtExpired = $filter('dateFilter')(new Date(), null);

    };

    $scope.save = function () {

        loaderFactory.isLoading = true;
        //=====================================================================
        //Validation
        //=====================================================================
        if ($scope.password1 != $scope.password2) {
            modalFactory.show('error', 'Password did not match.');
            return;
        }
        if ($scope.password1.length < 6) {
            modalFactory.show('error', 'Password length must be 6 letters or more.');
            return;
        }

        $scope.user.password = $scope.password1;

        User.save(
            $scope.user,
            function (result) {
                modalFactory.show('success', '1 user added successfully');
                logFactory.write('insert', $scope.user.name, '1 user added successfully');

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



