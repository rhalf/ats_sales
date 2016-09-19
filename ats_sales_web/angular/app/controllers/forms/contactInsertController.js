var app = angular.module('app');

app.controller('contactInsertController', function (
    $scope,
    $uibModalInstance,

   paginationFactory,
   loaderFactory,
   modalFactory,
   sessionFactory,
   logFactory,

   Contact,
   Nation,

   company,
   parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.nations = Nation.query();
        $scope.contact = new Contact();
    };

    $scope.save = function () {

        $scope.contact.company = company;

        loaderFactory.isLoading = true;

        Contact.save(
            $scope.contact,
            function (result) {
                modalFactory.show('success', '1 contact added successfully');
                logFactory.write('insert', $scope.contact.name, '1 contact added successfully');

                loaderFactory.isLoading = false;
                parent.load();
                $scope.cancel();
            },
            function (result) {
                modalFactory.show('error', result.data.message);
                loaderFactory.isLoading = false;
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});



