var app = angular.module('app');

app.directive('alertDirective', function () {
    return {
        templateUrl: '/app/views/directives/alert.html',
        controller : 'alertController'
    }
});

app.directive('loaderDirective', function () {
    return {
        templateUrl: '/app/views/directives/loader.html',
        controller: 'loaderController'
    }
});

//============================================================

app.directive('panelContentDirective', function () {
    return {
        templateUrl: '/app/views/directives/panelContent.html',
        controller: 'panelContentController'
    }
});

app.directive('panelMenuDirective', function () {
    return {
        templateUrl: '/app/views/directives/panelMenu.html',
        controller: 'panelMenuController'
    }
});