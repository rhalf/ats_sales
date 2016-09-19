<?php 

class User implements IQuery {

	public $id;
	public $name;
	public $password;
	public $dtCreated;
	public $dtRenewed;
	public $dtExpired;
	public $hash;
	public $email;
	public $status;
	public $privilege;



	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$user = new User();
				$user->id = (int) $row['id'];
				$user->name = $row['user_name'];
				// $user->password = $row['user_password'];
				$user->dtCreated = $row['user_dt_created'];
				$user->dtRenewed = $row['user_dt_renewed'];
				$user->dtExpired = $row['user_dt_expired'];
				// $user->hash = $row['user_hash'];
				$user->email= $row['user_email'];
				$user->status = Status::select($row['e_status_id']);
				$user->privilege = Privilege::select($row['e_privilege_id']);

				array_push($result, $user);
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
			
			$sql = "SELECT * FROM user WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$user = new User();
			$user->id = (int) $row['id'];
			$user->name = $row['user_name'];
			// $user->password = $row['user_password'];
			$user->dtCreated = $row['user_dt_created'];
			$user->dtRenewed = $row['user_dt_renewed'];
			$user->dtExpired = $row['user_dt_expired'];
			// $user->hash = $row['user_hash'];
			$user->email= $row['user_email'];
			$user->status = Status::select($row['e_status_id']);
			$user->privilege = Privilege::select($row['e_privilege_id']);
			return $user;

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
		$dateTime = Flight::dateTime();

		try {

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user 
			(user_name, user_password, user_dt_created,user_dt_renewed,user_dt_expired, user_hash, user_email, e_status_id, e_privilege_id)
			VALUES
			(:user_name, :user_password, :user_dt_created, :user_dt_renewed, :user_dt_expired, :user_hash, :user_email, :e_status_id, :e_privilege_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->name, PDO::PARAM_STR);

			$password = hash('sha256', $user->password);
			$query->bindParam(':user_password', $user->password, PDO::PARAM_STR);
			$query->bindParam(':user_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':user_dt_renewed', $user->dtRenewed, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->dtExpired, PDO::PARAM_STR);			
			$query->bindParam(':user_hash', $user->hash, PDO::PARAM_STR);
			$query->bindParam(':user_email', $user->email, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $user->status->id, PDO::PARAM_INT);
			$query->bindParam(':e_privilege_id', $user->privilege->id, PDO::PARAM_INT); 
			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = (int)$connection->lastInsertid();
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

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user 
			SET 
			user_name = :user_name,
			user_dt_renewed = :user_dt_renewed,
			user_dt_expired = :user_dt_expired,
			user_email = :user_email,
			e_status_id = :e_status_id,
			e_privilege_id = :e_privilege_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':user_name', $user->name, PDO::PARAM_STR);
			$query->bindParam(':user_dt_renewed', $user->dtRenewed, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->dtExpired, PDO::PARAM_STR);
			$query->bindParam(':user_email', $user->email, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $user->status->id, PDO::PARAM_INT);
			$query->bindParam(':e_privilege_id', $user->privilege->id, PDO::PARAM_INT);			
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->execute();
			
			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = (int)$id;
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
	public static function updateCredential($id) {

		$connection = Flight::dbMain();

		try {

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user 
			SET 
			user_password = :user_password
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':user_name', $user->name, PDO::PARAM_STR);
			$password = hash('sha256', $user->password);
			$query->bindParam(':user_password', $password, PDO::PARAM_STR);
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->execute();
			
			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = (int)$id;
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
			DELETE FROM user 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = (int)$id;

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