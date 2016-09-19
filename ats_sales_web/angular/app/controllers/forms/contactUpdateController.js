var app = angular.module('app');

app.controller('contactUpdateController', function (
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
   contact,
   parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.nations = Nation.query();
        $scope.contact = contact;
    };

    $scope.save = function () {

        $scope.contact.company = company;

        loaderFactory.isLoading = true;

        Contact.update(
            {id :  $scope.contact.id},
            $scope.contact,
            function (result) {
                modalFactory.show('success', '1 contact updated successfully');
                logFactory.write('update', $scope.contact.name, '1 contact updated successfully');

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



