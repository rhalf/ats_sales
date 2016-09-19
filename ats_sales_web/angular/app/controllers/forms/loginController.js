var app = angular.module('app');

app.controller('loginController', function (
    $scope,
    $location,

    modalFactory,
    loaderFactory,
    logFactory,
    

    sessionFactory,

    Session
    ) {

    $scope.init = function () {

        $scope.user = sessionFactory.getUser();
    };

    $scope.login = function () {

        loaderFactory.isLoading = true;

        if (!$scope.user) {
            modalFactory.show('error',"Username or Password is not set.");
            loaderFactory.isLoading = false;
            return;
        }

        Session.login(
       { name: $scope.user.name, password: $scope.user.password },
       function (result) {
           var user = result;
           //==================================================================
           //Validation
           //==================================================================
           //Privilege
           if (user.privilege.value == 1) {

           } else {
               //Status
               if (user.status.value == 0) {
                   moda.add('error', "User is disabled");
                   loaderFactory.isLoading = false;
                   return;
               }
               if (user.status.value == 2) {
                   modalFactory.show('error', "User is suspended");
                   loaderFactory.isLoading = false;
                   return;
               }
               //DateTime Expiration
               var date1 = new Date(user.dtExpired);
               var date2 = new Date();
               console.log(date1);
               console.log(date2);

               if (date1.getTime() < date2.getTime()) {
                   modalFactory.show('error', "User is expired.");
                   loaderFactory.isLoading = false;
                   return;
               }
           }
           //==================================================================
           //Validation
           //==================================================================

           user.password = $scope.user.password;
           sessionFactory.setUser(user);
           logFactory.write('login', 'login', 'logging in.');
           $location.path('/main');
           loaderFactory.isLoading = false;
       },
       function (result) {
           modalFactory.show('error', result.data.message);
           loaderFactory.isLoading = false;
       });
    };

    $scope.init();
});



