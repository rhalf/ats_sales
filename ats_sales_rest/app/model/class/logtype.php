<?php 

class LogType implements IQuery {

	public $Id;
	public $TypeName;
	public $Desc;

	public function __construct() {
	}
	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_log_type;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$logtype = new LogType();
				$logtype->Id = (int) $row['id'];
				$logtype->TypeName =$row['log_type_name'];
				$logtype->Desc = $row['log_type_desc'];

				array_push($result, $logtype);
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

			$sql = "SELECT * FROM e_log_type WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			    $logtype = new LogType();
				$logtype->Id = (int) $row['id'];
				$logtype->TypeName =$row['log_type_name'];
				$logtype->Desc = $row['log_type_desc'];


			return $logtype;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function insert() {
		
		$connection = Flight::dbMain();

		try {

			$logtype = json_decode(file_get_contents("php://input"));

			if ($logtype == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO e_log_type 
			(log_type_name, log_type_desc)
			VALUES
			(:log_type_name, :log_type_desc);";

			$query = $connection->prepare($sql);
			$query->bindParam(':log_type_name', $logtype->TypeName, PDO::PARAM_STR);
			$query->bindParam(':log_type_desc', $logtype->Desc, PDO::PARAM_STR);
			
			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
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

			$logtype = json_decode(file_get_contents("php://input"));

			if ($logtype == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_log_type 
			SET 
			log_type_name = :log_type_name,
			log_type_desc = :log_type_desc
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':log_type_name', $logtype->TypeName, PDO::PARAM_STR);
			$query->bindParam(':log_type_desc', $logtype->Desc, PDO::PARAM_STR);
			
			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
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
			DELETE FROM e_log_type 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

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