var app = angular.module('app');

app.factory('sessionFactory', function (
    $cookies
    ) {

    var sessionFactory = {};

    //User
    sessionFactory.getUser = function () {
        var user = $cookies.getObject('user');
        if (user) {
            return user;
        } else {
            return null;
        }
    };

    sessionFactory.setUser = function (user) {
        $cookies.putObject('user', user);
    };

    //Company
    sessionFactory.getCompany = function () {
        var company = $cookies.getObject('company', { secure: true });
        if (company) {
            return company;
        } else {
            return null;
        }
    };

    sessionFactory.setCompany = function (company) {
        return $cookies.putObject('company', company, { secure: true });
    };

    return sessionFactory;
});