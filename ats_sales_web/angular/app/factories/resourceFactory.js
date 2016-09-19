var app = angular.module('app');

app.factory('Session', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/session/login/', {}, {
        'login': {
            method: 'POST',
            data: {
                name: '@name',
                password: '@password'
            }
        }
    });
});

app.factory('User', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/user/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});
app.factory('UserCredential', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/usercredential/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('UserOnline', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/useronline/:id', {}, {
        'update': {
            method: 'PUT'
        },
        getByTime: {
            method: 'GET',
            params: {
                time: '@time'
            },
            isArray: true
        }
    });
});

app.factory('Company', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/company/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});
app.factory('CompanyAddress', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/companyaddress/:id', {}, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: false
        }
    });
});

app.factory('Log', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/log/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Contact', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/contact/:id', {}, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('Product', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/product/:id', {}, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('ProductOffered', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/productoffered/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

//
app.factory('Status', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/status/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});
app.factory('Privilege', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/privilege/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Field', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/field/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Nation', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/nation/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('ClientResponse', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/clientresponse/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('OfferedStatus', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/offeredstatus/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});


app.factory('Log', function ($resource, apiFactory) {
    return $resource('http://' + apiFactory.ip + '/v1/main/log/:id', {}, {
        'update': {
            method: 'PUT'
        }
    });
});





app.factory('Geocode', function ($resource, apiFactory) {
    return $resource('https://maps.googleapis.com/maps/api/geocode/json', {}, {
        'update': {
            method: 'PUT'
        },
        getDetail: {
            params: {
                latlng: '@latlng',
                key: 'AIzaSyBuSdI-7vzlCQG_acArGShqXje_RANEnwc'
            },
            isArray: false
        }

    });
});
