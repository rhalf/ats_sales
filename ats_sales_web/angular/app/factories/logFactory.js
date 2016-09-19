var app = angular.module('app');

app.factory('logFactory', function (
    sessionFactory,

    Log

    ) {

    var logFactory = {};

    logFactory.write = function (logType, name, desc) {

        var log = new Log();
        log.user = sessionFactory.getUser();
        log.name = name;
        log.desc = desc;

        switch (logType) {
            case 'select':
                log.logType = { id: 1 };
                break;
            case 'insert':
                log.logType = { id: 2 };
                break;
            case 'update':
                log.logType = { id: 3 };
                break;
            case 'delete':
                log.logType = { id: 4 };
                break;
            case 'login':
                log.logType = { id: 5 };
                break;
     
        }

        Log.save(log);

    };

    return logFactory;
});