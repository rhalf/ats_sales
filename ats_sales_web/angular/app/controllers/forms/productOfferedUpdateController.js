var app = angular.module('app');

app.controller('productOfferedUpdateController', function (
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

    parent,
    productOffered

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;

        $scope.companies = Company.query();
        $scope.products = Product.getByCompany({ company: 1 });
        $scope.clientResponses = ClientResponse.query();
        $scope.offeredStatuses = OfferedStatus.query();

        $scope.productOffered = productOffered;
        $scope.company = $scope.productOffered.contact.company;
        $scope.load();


    };

    $scope.load = function () {
        $scope.contacts = Contact.getByCompany({ company: $scope.company.id });
    };

    $scope.update = function () {

        loaderFactory.isLoading = true;

        $scope.productOffered.user = sessionFactory.getUser();

        ProductOffered.update(
            {id : $scope.productOffered.id},
            $scope.productOffered,
            function (result) {
                modalFactory.show('success', '1 productOffered updated successfully');
                logFactory.write('update', $scope.productOffered.contact.name, '1 productOffered updated successfully');

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



