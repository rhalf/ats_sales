<?php 

class Log implements IQuery {

	public $Id;
	public $Dt;
	public $Name;
	public $Desc;
	public $LogClass;
	public $Item;
	public $LogType;

	

	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM log;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$log = new Log();
				$log->Id = (int) $row['id'];
				$log->Dt = $row['log_dt'];
				$log->Name = $row['log_name'];
				$log->Desc = $row['log_desc'];
				$log->LogClass = $row['log_class'];
				$log->Item = $row['log_item'];
				$log->LogType = LogType::select($row['e_log_type']);
				

				array_push($result, $log);
			}

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}                            

	public static function select($id) {

		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM log WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			    $log = new Log();
			    $log->Id = (int) $row['id'];
				$log->Dt = $row['log_dt'];
				$log->Name = $row['log_name'];
				$log->Desc = $row['log_desc'];
				$log->LogClass = $row['log_class'];
				$log->Item = $row['log_item'];
				$log->LogType = LogType::select($row['e_log_type']);

			return $log;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	/*
	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM sim WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	

				$sim = new Sim();
				$sim->Id = (int) $row['id'];
				$sim->Imei =  $row['sim_imei'];
				$sim->Number = $row['sim_number'];
				$sim->Roaming = (bool) $row['sim_roaming'];
				$sim->SimVendor = SimVendor::select($row['e_sim_vendor_id']);
				$sim->DtCreated = $row['sim_dt_created'];

				$sim->Status = Status::select($row['e_status_id']);
				$sim->Company = Company::select($row['company_id']);


				array_push($result, $sim);
			}

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	*/

	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$log = json_decode(file_get_contents("php://input"));

			if ($log == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO log 
			(log_dt, log_name, log_desc,  log_class, log_item, e_log_type)
			VALUES
			(:log_dt, :log_name, :log_desc, :log_class, :log_item, :e_log_type);";


			$query = $connection->prepare($sql);

			$query->bindParam(':log_dt', $log->Dt, PDO::PARAM_STR);
			$query->bindParam(':log_name', $log->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $log->Desc, PDO::PARAM_STR);
			$query->bindParam(':log_class', $log->LogClass, PDO::PARAM_STR);
			$query->bindParam(':log_item', $log->Item, PDO::PARAM_STR);
			$query->bindParam(':e_log_type', $log->LogType->Id, PDO::PARAM_INT);



			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = (int)$connection->lastInsertId();
			$result->Message = 'Done';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	
	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$log = json_decode(file_get_contents("php://input"));

			if ($log == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE log 
			SET
			log_dt = :log_dt,
			log_name = :log_name,
			log_desc = :log_desc,
			log_class = :log_class,
			log_item = :log_item,
			e_log_type = :e_log_type

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':log_dt', $log->Dt, PDO::PARAM_STR);
			$query->bindParam(':log_name', $log->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $log->Desc, PDO::PARAM_STR);
			$query->bindParam(':log_class', $log->LogClass, PDO::PARAM_STR);
			$query->bindParam(':log_item', $log->Item, PDO::PARAM_STR);
			$query->bindParam(':e_log_type', $log->LogType->Id, PDO::PARAM_INT);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = (int)$id;
			$result->Message = 'Done.';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM log 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = (int)$id;

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
}
?>