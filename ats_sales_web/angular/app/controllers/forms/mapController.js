var app = angular.module('app');

app.controller('mapController', function (
    $q,
    $scope,
    $timeout,

    loaderFactory,
    paginationFactory,

    Company,
    CompanyAddress

    ) {

    $scope.init = function () {
        loaderFactory.isLoading = true;

        $scope.paginationFactory = paginationFactory;

        $scope.load();
    };

    $scope.load = function () {
        loaderFactory.isLoading = true;
        $scope.companyAddresses = CompanyAddress.query(
            function (result) {
                loaderFactory.isLoading = false;
                $scope.initMap();
            },
            function (result) {
                modalFactory.show('error', result.data.message);
                loaderFactory.isLoading = false;
            }
        );
    };

    $scope.initMap = function () {

        var openCycle = new L.tileLayer("http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png");
        var openStreet = new L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png");

        var mapsLayers = {
            "OpenCycleMap": openCycle,
            "OpenStreetMap": openStreet
        };

        var map = L.map('map', { layers: [openCycle, openStreet] });

        L.control.layers(mapsLayers).addTo(map);

        map.setView([25.2610366823, 51.492925286293], 11);

        var marker = null;

        angular.forEach($scope.companyAddresses, function (companyAddress, index) {
            var company = companyAddress.company;

            if (companyAddress.latitude && companyAddress.latitude) {
                marker = L.marker([companyAddress.latitude, companyAddress.longitude], { riseOnHover: true });
                marker.bindLabel(company.name,
                    {
                        noHide: true,
                        offset: [12, -15],
                        direction: 'auto'
                    });
                marker.addTo(map);
            }
        });
    };

    $scope.init();
});



