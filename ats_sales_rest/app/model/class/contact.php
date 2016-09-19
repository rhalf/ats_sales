<?php 

class Contact implements IQuery {

	public $id;
	public $name;
	public $position;
	public $email;
	public $mobile;
	public $fax;
	public $telephone;
	public $company;
	public $nation;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM contact;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$contact = new Contact();
				$contact->id = (int) $row['id'];
				$contact->name = $row['contact_name'];
				$contact->position = $row['contact_position'];
				$contact->email = $row['contact_email'];
				$contact->mobile = $row['contact_mobile'];
				$contact->fax = $row['contact_fax'];
				$contact->telephone = $row['contact_telephone'];
				$contact->company = Company::select($row['company_id']);
				$contact->nation = Nation::select($row['nation_id']);

				array_push($result, $contact);
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

			$sql = "SELECT * FROM contact WHERE id = :id;";
			$query = $connection->prepare($sql);
			
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			    $contact = new Contact();
				$contact->id = (int) $row['id'];
				$contact->name = $row['contact_name'];
				$contact->position = $row['contact_position'];
				$contact->email = $row['contact_email'];
				$contact->mobile = $row['contact_mobile'];
				$contact->fax = $row['contact_fax'];
				$contact->telephone = $row['contact_telephone'];
				$contact->company = Company::select($row['company_id']);
				$contact->nation = Nation::select($row['nation_id']);



			return $contact;

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

			$sql = "SELECT * FROM contact WHERE company_id = :company_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$contact = new Contact();
				$contact->id = (int) $row['id'];
				$contact->name = $row['contact_name'];
				$contact->position = $row['contact_position'];
				$contact->email = $row['contact_email'];
				$contact->mobile = $row['contact_mobile'];
				$contact->fax = $row['contact_fax'];
				$contact->telephone = $row['contact_telephone'];
				$contact->company = Company::select($row['company_id']);
				$contact->nation = Nation::select($row['nation_id']);

				array_push($result, $contact);
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

			$contact = json_decode(file_get_contents("php://input"));

			if ($contact == null) {
				throw new Exception(json_get_error());
			}

          /* $contact = new Contact();
				$contact->Id = (int) $row['id'];
				$contact->Name = $row['contact_name'];
				$contact->Position = $row['contact_position'];
				$contact->Email = $row['contact_email'];
				$contact->Mobile = $row['contact_mobile'];
				$contact->Fax = $row['contact_fax'];
				$contact->Telephone = $row['contact_telephone'];
				$contact->Company = Company::select($row['company_id']);
				$contact->Nation = Nation::select($row['nation_id']);*/


			$sql = "
			INSERT INTO contact 
			(contact_name, contact_position, contact_email, contact_mobile,contact_fax,contact_telephone,company_id,nation_id)
			VALUES
			(:contact_name, :contact_position, :contact_email, :contact_mobile, :contact_fax, :contact_telephone, :company_id, :nation_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':contact_name', $contact->name, PDO::PARAM_STR);
			$query->bindParam(':contact_position', $contact->position, PDO::PARAM_STR);
			$query->bindParam(':contact_email', $contact->email, PDO::PARAM_STR);
			$query->bindParam(':contact_mobile', $contact->mobile, PDO::PARAM_STR);;
			$query->bindParam(':contact_fax', $contact->fax, PDO::PARAM_STR);
			$query->bindParam(':contact_telephone', $contact->telephone, PDO::PARAM_STR);
			$query->bindParam(':company_id', $contact->company->id, PDO::PARAM_INT);
			$query->bindParam(':nation_id', $contact->nation->id, PDO::PARAM_INT);

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

			$contact = json_decode(file_get_contents("php://input"));

			if ($contact == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE contact 
			SET 
			contact_name = :contact_name,
			contact_position = :contact_position, 
			contact_email = :contact_email,
			contact_mobile = :contact_mobile,
			contact_fax = :contact_fax,
			contact_telephone = :contact_telephone,
			company_id = :company_id,
			nation_id = :nation_id
			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':contact_name', $contact->name, PDO::PARAM_STR);
			$query->bindParam(':contact_position', $contact->position, PDO::PARAM_STR);
			$query->bindParam(':contact_email', $contact->email, PDO::PARAM_STR);
			$query->bindParam(':contact_mobile', $contact->mobile, PDO::PARAM_STR);;
			$query->bindParam(':contact_fax', $contact->fax, PDO::PARAM_STR);
			$query->bindParam(':contact_telephone', $contact->telephone, PDO::PARAM_STR);
			$query->bindParam(':company_id', $contact->company->id, PDO::PARAM_INT);
			$query->bindParam(':nation_id', $contact->nation->id, PDO::PARAM_INT);
			
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
			DELETE FROM contact 
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