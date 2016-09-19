var app = angular.module('app');

app.controller('companySelectController', function (
    $scope,
     $timeout,
    $uibModal,
    $uibModalInstance,

    paginationFactory,
   loaderFactory,
   modalFactory,
   sessionFactory,
   logFactory,

   Company,
   Product,
   Contact,
   Nation,
   Geocode,

   CompanyAddress,


   company

    ) {

    $scope.init = function () {
        $scope.paginationFactory = paginationFactory;
        $scope.company = company;
        $scope.load();
    };

    $scope.load = function () {
        $scope.contacts = Contact.getByCompany({ company: $scope.company.id });
        $scope.products = Product.getByCompany({ company: $scope.company.id });
        $scope.companyAddress = CompanyAddress.getByCompany({ company: $scope.company.id });

        $scope.nations = Nation.query();
    };

    $scope.addContact = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/contact_insert.html',
            controller: 'contactInsertController',
            size: 'md',
            resolve: {
                parent: $scope,
                company: $scope.company
            }
        });
    };
    $scope.editContact = function (contact) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/contact_update.html',
            controller: 'contactUpdateController',
            size: 'md',
            resolve: {
                parent: $scope,
                contact: contact,
                company: $scope.company
            }
        });
    };
    $scope.deleteContact = function (contact) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/contact_delete.html',
            controller: 'contactDeleteController',
            size: 'md',
            resolve: {
                parent: $scope,
                contact: contact,
                company: $scope.company
            }
        });
    };

    $scope.addProduct = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_insert.html',
            controller: 'productInsertController',
            size: 'md',
            resolve: {
                parent: $scope,
                company: $scope.company
            }
        });
    };
    $scope.editProduct = function (product) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_update.html',
            controller: 'productUpdateController',
            size: 'md',
            resolve: {
                parent: $scope,
                product: product,
                company: $scope.company
            }
        });
    };
    $scope.deleteProduct = function (product) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/views/forms/product_delete.html',
            controller: 'productDeleteController',
            size: 'md',
            resolve: {
                parent: $scope,
                product: product,
                company: $scope.company
            }
        });
    };

    $scope.saveCompanyAddress = function () {
        loaderFactory.isLoading = true;

        if (!$scope.companyAddress.latitude && !$scope.companyAddress.longitude) {
            loaderFactory.isLoading = false;
            return;
        }

        $scope.companyAddress.company = company;

        CompanyAddress.save(
          $scope.companyAddress,
          function (result) {
              logFactory.write('update', company.name, 'Updated companyAddess.');
              loaderFactory.isLoading = false;
          },
          function (result) {
              loaderFactory.isLoading = false;
          });
    };


    $scope.initMap = function () {
        $timeout(function () {


            var openCycle = new L.tileLayer("http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png");
            var openStreet = new L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png");


            var map = L.map('minimap', {
                layers: [openCycle, openStreet]
            });

            var mapsLayers = {
                "OpenCycleMap": openCycle,
                "OpenStreetMap": openStreet
            };

            var layer = L.control.layers(mapsLayers).addTo(map);

            var marker = null;


            if ($scope.companyAddress.latitude && $scope.companyAddress.longitude) {
                map.setView([$scope.companyAddress.latitude, $scope.companyAddress.longitude], 12);


                marker = L.marker(
                    [$scope.companyAddress.latitude, $scope.companyAddress.longitude]
                    ).addTo(map)
                    .bindPopup($scope.company.name)
                    .openPopup();

                map.panTo(new L.LatLng($scope.companyAddress.latitude, $scope.companyAddress.longitude));

            } else {
                map.setView([25.2610366823, 51.492925286293], 12);
            }

            map.on('click', function (e) {

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = new L.marker(e.latlng).addTo(map);

                $scope.companyAddress.latitude = e.latlng.lat;
                $scope.companyAddress.longitude = e.latlng.lng;
                Geocode.getDetail({
                    latlng: e.latlng.lat + ',' + e.latlng.lng
                },
                 function (result) {
                     $scope.companyAddress.detail = result.results[0].formatted_address;
                 });

            });


        }, 500);
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
    $scope.initMap();
});



