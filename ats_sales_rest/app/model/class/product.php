<?php 

class Product implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $company;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM product;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$product = new Product();
				$product->id = (int) $row['id'];
				$product->name = $row['product_name'];
				$product->desc = $row['product_desc'];
				$product->company = Company::select($row['company_id']);

				array_push($result, $product);
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

			$sql = "SELECT * FROM product WHERE id = :id;";
			$query = $connection->prepare($sql);
			
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$product = new Product();
			$product->id = (int) $row['id'];
			$product->name = $row['product_name'];
			$product->desc = $row['product_desc'];			
			$product->company = Company::select($row['company_id']);

			return $product;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}


	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM product WHERE company_id = :company_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$product = new Product();
				$product->id = (int) $row['id'];
				$product->name = $row['product_name'];
				$product->desc = $row['product_desc'];
				$product->company = Company::select($row['company_id']);

				array_push($result, $product);
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

	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$product = json_decode(file_get_contents("php://input"));

			if ($product == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO product 
			(product_name, product_desc, company_id)
			VALUES
			(:product_name, :product_desc, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':product_name', $product->name, PDO::PARAM_STR);
			$query->bindParam(':product_desc', $product->desc, PDO::PARAM_STR);
			$query->bindParam(':company_id', $product->company->id, PDO::PARAM_INT);

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

			$product = json_decode(file_get_contents("php://input"));

			if ($product == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE product 
			SET 
			product_name = :product_name,
			product_desc = :product_desc, 
			company_id = :company_id
			WHERE
			id = :id;";


			$query = $connection->prepare($sql);
			$query->bindParam(':product_name', $product->name, PDO::PARAM_STR);
			$query->bindParam(':product_desc', $product->desc, PDO::PARAM_STR);
			$query->bindParam(':company_id', $product->company->id, PDO::PARAM_INT);
			
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
			DELETE FROM product 
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