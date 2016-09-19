var app = angular.module('app');

app.controller('companyUpdateController', function (
    $scope,
    $uibModalInstance,

   loaderFactory,
   modalFactory,
   sessionFactory,
   logFactory,

   Company,
   Status,
   Field,


   parent,
   company

    ) {

    $scope.init = function () {
        $scope.fields = Field.query();
        $scope.statuses = Status.query();
        $scope.company = company;
    };

    $scope.save = function () {


        loaderFactory.isLoading = true;

        Company.update(
            { id: $scope.company.id },
            $scope.company,
            function (result) {
                modalFactory.show('success', '1 company updated successfully');
                logFactory.write('update', $scope.company.name, '1 company updated successfully');

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



