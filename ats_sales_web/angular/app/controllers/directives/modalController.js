var app = angular.module('app');

app.controller('modalController', function (
    $scope,
    $uibModalInstance,

    modal

    ) {

    $scope.init = function () {

        $scope.modal = modal;

        switch ($scope.modal.type) {
            case 'success':
                $scope.modal.type = 'Success';
                break;
            case 'error':
                $scope.modal.type = 'Error';
                break;
            case 'warning':
                $scope.modal.type = 'Warning';
                break;
        }
      
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});