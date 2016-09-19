var app = angular.module('app');

app.controller('companiesController', function (
    $scope,
    $uibModal,

   paginationFactory,
   loaderFactory,
   modalFactory,

   Company

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.load();
    };

    $scope.load = function () {
        loaderFactory.isLoading = true;
        $scope.companies = Company.query(
            function (result) {
                loaderFactory.isLoading = false;
            },
            function (result) {
                loaderFactory.isLoading = false;
            });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/company_insert.html',
            controller: 'companyInsertController',
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };
    $scope.select = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/company_select.html',
            controller: 'companySelectController',
            size: 'lg',
            resolve: {
                company: company
            }
        });
    };

    $scope.edit = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/company_update.html',
            controller: 'companyUpdateController',
            size: 'md',
            resolve: {
                parent: $scope,
                company: company
            }
        });
    };
    $scope.delete = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/company_delete.html',
            controller: 'companyDeleteController',
            size: 'md',
            resolve: {
                parent: $scope,
                company: company
            }
        });
    };

    $scope.init();
});



