var app = angular.module('app');

app.factory('paginationFactory', function () {

    var paginationFactory = [];

    paginationFactory.currentPage = 1;
    paginationFactory.pageSize = 20;

    return paginationFactory;
});