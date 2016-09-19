<?php
$root = $_SERVER['DOCUMENT_ROOT'];

//Framework
require_once('/asset/library/flight/flight/Flight.php');

//System Interfaces
require_once('/app/model/interface/iquery.php');

//System Classes
require_once('/app/model/class/database.php');
// require_once('/app/model/class/url.php');
require_once('/app/model/class/result.php');

//Database Enumeration Classes
require_once('/app/model/class/nation.php');
require_once('/app/model/class/privilege.php');
require_once('/app/model/class/field.php');
require_once('/app/model/class/status.php');

require_once('/app/model/class/product.php');
require_once('/app/model/class/contact.php');
require_once('/app/model/class/clientresponse.php');
require_once('/app/model/class/logtype.php');
require_once('/app/model/class/log.php');
require_once('/app/model/class/productoffered.php');
require_once('/app/model/class/offeredstatus.php');


//Database Classes
require_once('/app/model/class/company.php');
require_once('/app/model/class/user.php');

require_once('/app/model/class/companyaddress.php');




require_once('/app/model/class/useronline.php');










//require_once('app/model/class/appdatabase.php');
// require_once('app/model/class/appsetting.php');



//
//require_once('app/model/class/unitdata.php');

//Session
require_once('app/model/session/session.php');


//System Functions
// require_once('app/controller/method/get.php');
// require_once('app/controller/method/post.php');
// require_once('app/controller/method/put.php');
// require_once('app/controller/method/delete.php');
// require_once('app/controller/method/options.php');
// require_once('app/controller/method/patch.php');


require_once('app/controller/system/function.php');
require_once 'app/controller/system/statuscode.php';
require_once 'app/controller/system/setting.php';





?>