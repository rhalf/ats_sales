var app = angular.module('app');

app.run(function (
    $interval,
    $rootScope,
    $location,

    alertFactory,
    loaderFactory,
    sessionFactory,

    UserOnline

    ) {


    $rootScope.$on("$routeChangeStart", function (event, next, current) {


        //console.log(event);
        //console.log(next);
        //console.log(current);

        //If route is authenticated, then the user should have access
        if (next.$$route.authenticated) {


            var user = sessionFactory.getUser();

            if (!user) {
                console.log('Not authenticated...');
                $location.path('/');
            } else {
                console.log('Authenticated...');
                console.log(user);
                var uo = new UserOnline();
                uo.user = user;

                UserOnline.save(uo);
                $interval(() => {
                    UserOnline.save(uo);
                }, 
                60000 * 5); 
                //3000);

                $location.path('/main');
            }

        }
    });
});


