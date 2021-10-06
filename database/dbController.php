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
	 * @param $query
	 * @param $name
	 * @param $address
	 * @param $description
	 * @param $imagePath
	 * @param $imageCreator
	 * @param $imageSourceURL
	 *
	 * @return int|bool - Did we successfully insert the record into the database? If so, return the ID.
	 */
	public function insert($query, $name, $address, $description, $imagePath, $imageCreator, $imageSourceURL) {

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

		if($statement->affected_rows) {
			// TODO: Use this code as the basis for the search method and then use the search method here
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
	 * @param $query
	 * @param $name
	 * @param $address
	 * @param $description
	 * @param $imagePath
	 * @param $imageCreator
	 * @param $imageSourceURL
	 */
	public function update($query, $name, $address, $description, $imagePath, $imageCreator, $imageSourceURL) {
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
	 * @param $id
	 *
	 * @return array
	 */
	public function getRestaurantById($id): array {
		$raw_results = $this->conn->query("SELECT * FROM restaurant_details WHERE ID='$id'");
		$formatted_results = [];

		while($row = $raw_results->fetch_assoc()) {
			array_push($formatted_results, $row);
		}

		// Because we're searching by ID, we expect an array of only one item
		// So let's return just the first (only) one
		return $formatted_results[0];
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