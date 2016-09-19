var app = angular.module('app');

app.factory('apiFactory', function () {

    var apiFactory = [];

    apiFactory.ip = '72.55.132.43';
    apiFactory.version = 'v1';
    apiFactory.group = 'main';

    return apiFactory;
});