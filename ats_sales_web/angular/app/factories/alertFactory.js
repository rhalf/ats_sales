var app = angular.module('app');

app.factory('alertFactory', function () {

    var alertFactory = [];

    alertFactory.items = [];
    alertFactory.timeout = 3000;
    alertFactory.isAccumulating = false;

    alertFactory.add = function (message, type) {
        var alert = { message: message, type: type };

        if (alertFactory.isAccumulating) {
            alertFactory.items.push(alert);
        } else {
            alertFactory.items = [];
            alertFactory.items.push(alert);
        }
    };

    alertFactory.remove = function (index) {
        alertFactory.items.splice(index, 1);
    }
    
    return alertFactory;
});