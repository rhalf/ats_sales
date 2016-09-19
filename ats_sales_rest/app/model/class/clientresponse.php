<?php 

class ClientResponse implements IQuery {

	public $id;
	public $name;
	public $desc;

	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM client_response;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$clientresponse = new ClientResponse();
				$clientresponse->id = (int) $row['id'];
				$clientresponse->name = $row['response_name'];
				$clientresponse->desc = $row['response_desc'];
				
				array_push($result, $clientresponse);
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
			$sql = "SELECT * FROM client_response WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			    $clientresponse = new ClientResponse();
				$clientresponse->id = (int) $row['id'];
				$clientresponse->name = $row['response_name'];
				$clientresponse->desc = $row['response_desc'];
		
			return $clientresponse;

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

			$clientresponse = json_decode(file_get_contents("php://input"));

			if ($clientresponse == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO client_response 
			(response_name, response_desc)
			VALUES
			(:response_name, :response_desc);";

			$query = $connection->prepare($sql);

			$query->bindParam(':response_name', $clientresponse->name, PDO::PARAM_STR);
			$query->bindParam(':response_desc', $clientresponse->desc, PDO::PARAM_STR);
			
			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->id = $connection->lastInsertId();
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

			$clientresponse = json_decode(file_get_contents("php://input"));

			if ($clientresponse == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE client_response 
			SET 
			response_name = :response_name,
			response_desc = :response_desc
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':response_name', $clientresponse->name, PDO::PARAM_STR);
			$query->bindParam(':response_desc', $clientresponse->desc, PDO::PARAM_STR);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->id = $id;
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
			DELETE FROM client_response 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
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