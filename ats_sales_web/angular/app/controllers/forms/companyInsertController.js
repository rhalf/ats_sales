var app = angular.module('app');

app.controller('companyInsertController', function (
    $scope,
    $uibModalInstance,

   paginationFactory,
   loaderFactory,
   modalFactory,
   sessionFactory,
   logFactory,

   Company,
   Status,
   Field,


   parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.fields = Field.query();
        $scope.statuses = Status.query();
        $scope.company = new Company();
    };

    $scope.save = function () {

        $scope.company.user = sessionFactory.getUser();

        loaderFactory.isLoading = true;

        Company.save(
            $scope.company,
            function (result) {
                modalFactory.show('success', '1 company added successfully');
                logFactory.write('insert', $scope.company.name, '1 company added successfully');
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



