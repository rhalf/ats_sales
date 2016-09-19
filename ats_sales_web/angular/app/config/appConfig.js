var app = angular.module('app');

app.config(
    function (
        $routeProvider,
        $locationProvider,
        $httpProvider,
        $logProvider
        ) {

        $routeProvider
         .when('/main', {
             templateUrl: 'app/views/directives/panelContainer.html',
             controller: 'panelContainerController',
             authenticated: true
         })
        .when('/', {
            templateUrl: 'app/views/forms/login.html',
            controller: 'loginController',
            authenticated: false
        })
        .otherwise({
            redirectTo: '/'
        });


        $logProvider.debugEnabled(false);
    });
