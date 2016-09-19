<?php 

class Session implements IQuery {


	public function __construct() {
	}

	public static function login() {

		$connection = Flight::dbMain();

		try {

			$session = json_decode(file_get_contents("php://input"));

			if ($session == null) {
				throw new Exception(json_get_error());
			}


			$sql = "SELECT * FROM user WHERE user.user_name = :name AND user.user_password = :password;";
			$query = $connection->prepare($sql);

			$password = hash('sha256', $session->password);

			$query->bindParam(':name', $session->name, PDO::PARAM_STR);
			$query->bindParam(':password', $password , PDO::PARAM_STR);

			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);


			if ($query->rowCount() < 1) {
				throw new Exception("Username or Password is not exist");
			}

			$user = new User();
			$user->id = (int) $row['id'];
			$user->name = $row['user_name'];
			$user->password = $row['user_password'];
			$user->dtCreated = $row['user_dt_created'];
			$user->dtRenewed = $row['user_dt_renewed'];
			$user->dtExpired = $row['user_dt_expired'];
			$user->hash = $row['user_hash'];
			$user->email= $row['user_email'];
			$user->status = Status::select($row['e_status_id']);
			$user->privilege = Privilege::select($row['e_privilege_id']);
			
			return $user;

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function logout() {

		$connection = Flight::dbMain();

		try {

			// $sql = "
			// DELETE FROM user 
			// WHERE
			// id = :id";

			// $query = $connection->prepare($sql);

			// $query->bindParam(':id', $id, PDO::PARAM_INT);

			// $query->execute();

			$result = new Result();
			$result->status = Result::SUCCESS;
			$result->message = 'Done';
			//$result->Id = $id;

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}

	}
}

?>