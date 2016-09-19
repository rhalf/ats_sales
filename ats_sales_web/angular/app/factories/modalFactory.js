var app = angular.module('app');

app.factory('modalFactory', function (

    alertFactory,

    $uibModal

    ) {

    var modalFactory = {};

    modalFactory.show = function (type, message){

        var modal = {};
        modal.message = message;
        modal.type = type;

        $uibModal.open({
            templateUrl: '/app/views/directives/modal.html',
            controller: 'modalController',
            size: 'md',
            resolve: {
                modal: modal
            }
        });
    };

    return modalFactory;
});