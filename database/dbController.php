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
	 * Method to get all restaurants from the database
	 *
	 * @return mixed
	 */
	public function getAll() {
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
	 * @param $keyword
	 */
	public function search($keyword) {
		$searchForLike = "%$keyword%";
		$query = "SELECT * FROM restaurant_details WHERE concat(name, description, address) LIKE ?";
		$stmt = $this->conn->prepare($query);

		if(!$stmt) {
			exit("Prepare failed: " . $this->conn->error);
		}

		$stmt->bind_param("s", $searchForLike);
		$stmt->execute();

		$result = $stmt->get_result();

		$result_set = $result->fetch_all(MYSQLI_ASSOC);

		return $result_set;
	}

	/**
	 * Method to write errors to a log file
	 * @param $error
	 */
	public function logError($error) {
		error_log("SQL error: $error".PHP_EOL,3,"logs/error-log.log");
	}
}