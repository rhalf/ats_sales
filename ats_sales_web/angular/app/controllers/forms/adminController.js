var app = angular.module('app');

app.controller('adminController', function (
    $q,
    $scope,
    $timeout,
    $uibModal,

    loaderFactory,
    paginationFactory,
    modalFactory,
    sessionFactory,

    User,
    UserOnline


    ) {

    $scope.init = function () {

        $scope.paginationFactory = paginationFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.users = User.query();
        $scope.usersOnline = UserOnline.query();
    };

    $scope.reload = function (userOnline) {
        userOnline = UserOnline.get({ id: userOnline.id });
    };


    $scope.addUser = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/user_insert.html',
            controller: 'userInsertController',
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.deleteUser = function (user) {

        if (sessionFactory.getUser().privilege.value > user.privilege.value) {
            modalFactory.show('error', 'The user you like to access is superior than your privilege.');
            return;
        }

        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/user_delete.html',
            controller: 'userDeleteController',
            size: 'md',
            resolve: {
                parent: $scope,
                user: user
            }
        });
    };

    $scope.editUser = function (user) {

        if (sessionFactory.getUser().privilege.value > user.privilege.value) {
            modalFactory.show('error', 'The user you like to access is superior than your privilege.');
            return;
        }

        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/user_update.html',
            controller: 'userUpdateController',
            size: 'md',
            resolve: {
                parent: $scope,
                user: user
            }
        });
    };

    $scope.changeUserPassword = function (user) {

        if (sessionFactory.getUser().privilege.value > user.privilege.value) {
            modalFactory.show('error', 'The user you like to access is superior than your privilege.');
            return;
        }

        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/user_change_password.html',
            controller: 'userChangePasswordController',
            size: 'md',
            resolve: {
                parent: $scope,
                user: user
            }
        });
    };

    $scope.init();
});



