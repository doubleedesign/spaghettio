<?php
class dbController {
	private $conn;
	private $user;
	private $host;
	private $pass;
	private $db;

	/**
	 * Method to create the database connection using supplied credentials
	 * @param $host
	 * @param $user
	 * @param $pass
	 * @param $db
	 *
	 * @return mysqli
	 */
	public function dbConnect($host, $user, $pass, $db): mysqli {
		$this->conn = new mysqli(
			$this->host = $host,
			$this->user = $user,
			$this->pass = $pass,
			$this->db = $db
		);

		return $this->conn;
	}

	/**
	 * Method to run a provided query to save data to the current database
	 * @param $name
	 * @param $address
	 * @param $description
	 * @param $imagePath
	 * @param $imageCreator
	 * @param $imageSourceURL
	 *
	 * @return int|bool - Did we successfully insert the record into the database? If so, return the ID.
	 */
	public function insert($name, $address, $description, $imagePath, $imageCreator, $imageSourceURL) {
		$query = "INSERT INTO `restaurant_details` (`name`, `address`, `description`, `imagePath`, `imageCreator`, `imageSourceURL`) VALUES (?,?,?,?,?,?);";

		if($this->conn->error) {
			$this->logError($this->conn->error);
			return false;
		}

		$statement = $this->conn->prepare($query);

		if(!$statement) {
			$this->logError("Prepare failed");
			return false;
		}

		$statement->bind_param("ssssss", $name, $address, $description, $imagePath, $imageCreator, $imageSourceURL);
		$statement->execute();

		$this->logError(print_r($statement));

		if($statement->affected_rows) {
			$raw_results = $this->conn->query("SELECT ID FROM restaurant_details WHERE name='$name'");
			$formatted_results = [];

			while($row = $raw_results->fetch_assoc()) {
				array_push($formatted_results, $row);
			}

			return $formatted_results[0];
		}
		else {
			return false;
		}
	}

	/**
	 * Method to run a provided query to update data in the database
	 *
	 * @param $id
	 * @param $post
	 *
	 * @return bool|int
	 */
	public function update($id, $post) {
		$changes = 0;

		if($this->conn->error) {
			$this->logError($this->conn->error);
			return false;
		}

		// Remove the ID from the passed-in array because we don't want to change that
		// and doing so may break things because it's a different data type
		unset($post['ID']);

		// Loop through each field and value sent through, and run an update for each one
		foreach($post as $fieldname => $value) {
			$query = "UPDATE `restaurant_details` SET `$fieldname`=? WHERE ID=?";
			$this->logError($query);
			$statement = $this->conn->prepare($query);

			if(!$statement) {
				$this->logError("Prepare failed");
				return false; // only want to return if there's an error, otherwise it will exit after the first field
			}

			$statement->bind_param("si", $value, $id);
			$statement->execute();

			if($statement->affected_rows) {
				$changes++;
			}
		}

		if($changes > 0) {
			return $id;
		}
		else {
			return false;
		}
	}

	/**
	 * Method to delete a restaurant from the database using its ID
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	function delete($id): bool {
		$sql = 'DELETE FROM restaurant_details WHERE ID=?';

		// Get the image URL and delete the image
		$restaurant = $this->getRestaurantById($id);
		$imageURL = $restaurant['imagePath'];
		$imageDeleted = unlink($imageURL);

		// Check whether it worked and log an error if not
		if(!$imageDeleted) {
			$this->logError("Problem deleting the image");
		}

		// Delete the database row
		$stmt = $this->conn->prepare($sql);
		if(!$stmt) {
			$this->logError("Prepare failed in delete method");
			exit("Prepare failed");
		}
		$stmt->bind_param('i', $id);
		$stmt->execute();

		// Return whether a row was deleted
		if($stmt->affected_rows) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Method to get all restaurants from the database
	 *
	 * @return array
	 */
	public function getAll(): array {
		$query = 'SELECT * from restaurant_details';
		$raw_results = $this->conn->query($query);
		$formatted_results = [];

		while($row = $raw_results->fetch_assoc()) {
			array_push($formatted_results, $row);
		}

		return $formatted_results;
	}

	/**
	 * Method to get a single restaurant from the database by its ID
	 *
	 * @param $id
	 *
	 * @return array|false
	 */
	public function getRestaurantById($id) {
		$raw_results = $this->conn->query("SELECT * FROM restaurant_details WHERE ID='$id'");
		$formatted_results = [];

		while($row = $raw_results->fetch_assoc()) {
			array_push($formatted_results, $row);
		}

		// Because we're searching by ID, we expect an array of only one item
		// So let's return just the first (only) one
		if(isset($formatted_results[0])) {
			return $formatted_results[0];
		}
		else {
			return false;
		}
	}

	/**
	 * Method to get search results from the database
	 * using prepared statements
	 * @param $keyword
	 *
	 * @return array
	 */
	public function search($keyword): array {
		$searchForLike = "%$keyword%";
		$query = "SELECT * FROM restaurant_details WHERE concat(name, description, address) LIKE ?";
		$stmt = $this->conn->prepare($query);

		if(!$stmt) {
			exit("Prepare failed: " . $this->conn->error);
		}

		$stmt->bind_param("s", $searchForLike);
		$stmt->execute();

		$result = $stmt->get_result();

		return $result->fetch_all(MYSQLI_ASSOC);
	}

	/**
	 * Method to write errors to a log file
	 * @param $error
	 */
	public function logError($error) {
		error_log("SQL error: $error".PHP_EOL,3,"logs/error-log.log");
	}
}