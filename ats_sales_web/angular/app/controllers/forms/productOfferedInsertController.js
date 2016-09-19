var app = angular.module('app');

app.controller('productOfferedInsertController', function (
    $scope,
    $uibModalInstance,

    paginationFactory,
    loaderFactory,
    modalFactory,
    sessionFactory,
    logFactory,

    ProductOffered,
    ClientResponse,
    Contact,
    Company,
    OfferedStatus,
    Product,

    parent

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.companies = Company.query();
        $scope.products = Product.getByCompany({ company : 1});
        $scope.clientResponses = ClientResponse.query();
        $scope.offeredStatuses = OfferedStatus.query();
        $scope.productOffered = new ProductOffered();
    };

    $scope.load = function () {
        $scope.contacts = Contact.getByCompany({ company: $scope.company.id });
    };
    
    $scope.save = function () {

        loaderFactory.isLoading = true;

        $scope.productOffered.user = sessionFactory.getUser();

        ProductOffered.save(
            $scope.productOffered,
            function (result) {
                modalFactory.show('success', '1 productOffered added successfully');
                logFactory.write('insert', $scope.productOffered.contact.name, '1 productOffered added successfully');

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



