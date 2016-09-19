<?php 

class ProductOffered implements IQuery {

	public $id;
	public $dtCreated;
	public $desc;
	public $contact;
	public $clientResponse;
    Public $product;
    Public $offeredStatus;
    Public $user;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM product_offered;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$productoffered = new ProductOffered();
				$productoffered->id = (int) $row['id'];
				$productoffered->dtCreated = $row['offered_dt_created'];
				$productoffered->desc = $row['offered_desc'];
				$productoffered->contact = Contact::select($row['contact_id']);
				$productoffered->clientResponse = ClientResponse::select($row['client_response_id']);
				$productoffered->product = Product::select($row['product_id']);
				$productoffered->offeredStatus = OfferedStatus::select($row['e_offered_status_id']);
				$productoffered->user = User::select($row['user_id']);

				array_push($result, $productoffered);
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

			$sql = "SELECT * FROM product_offered WHERE id = :id;";
			$query = $connection->prepare($sql);
			
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			    $productoffered = new ProductOffered();
				$productoffered->id = (int) $row['id'];
				$productoffered->dtCreated = $row['offered_dt_created'];
				$productoffered->desc = $row['offered_desc'];
				$productoffered->contact = Contact::select($row['contact_id']);
				$productoffered->clientResponse = ClientResponse::select($row['client_response_id']);
				$productoffered->product = Product::select($row['product_id']);
				$productoffered->offeredStatus = OfferedStatus::select($row['e_offered_status_id']);
				$productoffered->user = User::select($row['user_id']);


			return $productoffered;

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

			$productoffered = json_decode(file_get_contents("php://input"));

			if ($productoffered == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO product_offered 
			(offered_dt_created, offered_desc, contact_id, client_response_id, product_id, e_offered_status_id, user_id)
			VALUES
			(:offered_dt_created, :offered_desc, :contact_id, :client_response_id, :product_id, :e_offered_status_id, :user_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':offered_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':offered_desc', $productoffered->desc, PDO::PARAM_STR);
			$query->bindParam(':contact_id', $productoffered->contact->id, PDO::PARAM_INT);
			$query->bindParam(':client_response_id', $productoffered->clientResponse->id, PDO::PARAM_INT);
			$query->bindParam(':product_id', $productoffered->product->id, PDO::PARAM_INT);
			$query->bindParam(':e_offered_status_id', $productoffered->offeredStatus->id, PDO::PARAM_INT);
			$query->bindParam(':user_id', $productoffered->user->id, PDO::PARAM_INT);


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

			$productoffered = json_decode(file_get_contents("php://input"));

			if ($productoffered == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE product_offered 
			SET 
			offered_desc = :offered_desc, 
			contact_id = :contact_id,
			client_response_id = :client_response_id,
			product_id =:product_id,
			e_offered_status_id = :e_offered_status_id,
			user_id = :user_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);



			$query->bindParam(':offered_desc', $productoffered->desc, PDO::PARAM_STR);
			$query->bindParam(':contact_id', $productoffered->contact->id, PDO::PARAM_INT);
			$query->bindParam(':client_response_id', $productoffered->clientResponse->id, PDO::PARAM_INT);
			$query->bindParam(':product_id', $productoffered->product->id, PDO::PARAM_INT);
			$query->bindParam(':e_offered_status_id', $productoffered->offeredStatus->id, PDO::PARAM_INT);
			$query->bindParam(':user_id', $productoffered->user->id, PDO::PARAM_INT);
			$query->bindParam(':id', $id, PDO::PARAM_INT);


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

	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM product_offered 
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