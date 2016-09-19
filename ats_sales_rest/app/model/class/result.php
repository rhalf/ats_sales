<?php

class Result {

	public $status = null;		//State Error or Success
	public $id = null;			//Affected Id
	public $message = null;		//Details
	


	const SUCCESS = 'SUCCESS';
	const ERROR = 'ERROR';

	const INSERTED = 'INSERTED';
	const UPDATED = 'UPDATED';
	const DELETED = 'DELETED';

	const NOTFOUND = 'NOTFOUND';
	const BADREQUEST = 'BADREQUEST';
	const UNAUTHORIZED = 'UNAUTHORIZED';
	const FORBIDDEN = 'FORBIDDEN';

	public function __construct(){

	}


}

?>