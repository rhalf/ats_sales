<?php 

class CompanyAddress implements IQuery {

	public $id;
	public $latitude;
	public $longitude;
	public $detail;
	public $company;
	
	public function __construct() {
	}


	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM company_address;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$companyAddress = new CompanyAddress();
				$companyAddress->id = (int) $row['id'];
				$companyAddress->latitude = $row['address_latitude'];
				$companyAddress->longitude = $row['address_longitude'];
				$companyAddress->detail = $row['address_detail'];
				$companyAddress->company = Company::select($row['company_id']);

				array_push($result, $companyAddress);
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
			$sql = "SELECT * FROM company_address WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$companyAddress = new CompanyAddress();
			$companyAddress->id = (int) $row['id'];
			$companyAddress->latitude = $row['address_latitude'];
			$companyAddress->longitude = $row['address_longitude'];
			$companyAddress->detail = $row['address_detail'];
			$companyAddress->company = Company::select($row['company_id']);
			

			return $companyAddress;

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
			$sql = "SELECT * FROM company_address WHERE company_id = :company_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$companyAddress = new CompanyAddress();
			$companyAddress->id = (int) $row['id'];
			$companyAddress->latitude = $row['address_latitude'];
			$companyAddress->longitude = $row['address_longitude'];
			$companyAddress->detail = $row['address_detail'];
			$companyAddress->company = Company::select($row['company_id']);
			

			return $companyAddress;

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

			$companyAddress = json_decode(file_get_contents("php://input"));

			if ($companyAddress == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO company_address 
			( address_latitude, address_longitude, address_detail, company_id)
			VALUES
			(:address_latitude, :address_longitude, :address_detail, :company_id);";


			$query = $connection->prepare($sql);
			$query->bindParam(':address_latitude', $companyAddress->latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $companyAddress->longitude, PDO::PARAM_STR);
			$query->bindParam(':address_detail', $companyAddress->detail, PDO::PARAM_STR);
			$query->bindParam(':company_id', $companyAddress->company->id, PDO::PARAM_INT);


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

			$companyAddress = json_decode(file_get_contents("php://input"));

			if ($companyAddress == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE company_address 
			SET 
			address_latitude = :address_latitude, 
			address_longitude = :address_longitude, 
			address_detail = :address_detail, 
			company_id = :company_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':address_latitude', $companyAddress->latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $companyAddress->longitude, PDO::PARAM_STR);
			$query->bindParam(':address_detail', $companyAddress->detail, PDO::PARAM_STR);
			$query->bindParam(':company_id', $companyAddress->company->id, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
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
			DELETE FROM company_address 
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