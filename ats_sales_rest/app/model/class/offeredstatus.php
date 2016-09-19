<?php 

class OfferedStatus implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $value;
	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM e_offered_status;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$offeredStatus = new OfferedStatus();
				$offeredStatus->id = (int) $row['id'];
				$offeredStatus->name = $row['status_name'];
				$offeredStatus->desc = $row['status_desc'];
				$offeredStatus->value = (int)$row['status_value'];
				
				array_push($result, $offeredStatus);
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
			$sql = "SELECT * FROM e_offered_status WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$offeredStatus = new OfferedStatus();
			$offeredStatus->id = (int) $row['id'];
			$offeredStatus->name = $row['status_name'];
			$offeredStatus->desc = $row['status_desc'];
			$offeredStatus->value = (int)$row['status_value'];

			return $offeredStatus;

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

			$offeredStatus = json_decode(file_get_contents("php://input"));

			if ($offeredStatus == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO e_offered_status 
			(status_name, status_desc, status_value)
			VALUES
			(:status_name, :status_desc, :status_value);";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $offeredStatus->name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $offeredStatus->desc, PDO::PARAM_STR);
			$query->bindParam(':status_value',$offeredStatus->value, PDO::PARAM_INT);
			
			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertId();
			$result->message = 'Done';

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

			$offeredStatus = json_decode(file_get_contents("php://input"));

			if ($offeredStatus == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE e_offered_status 
			SET 
			status_name = :status_name,
			status_desc = :status_desc, 
			status_value = :status_value
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $offeredStatus->name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $offeredStatus->desc, PDO::PARAM_STR);
			$query->bindParam(':status_value', $offeredStatus->value, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
			$result->message = 'Done.';

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
			DELETE FROM e_offered_status 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

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