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
	 * @param $imageUrl
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
	 * @param $query
	 */
	public function getAll($query) {
		$raw_results = $this->conn->query($query);
		$formatted_results = [];

		while($row = $raw_results->fetch_assoc()) {
			array_push($formatted_results, $row);
		}

		return $raw_results;
	}

	/**
	 * Method to get a single restaurant from the database
	 * @param $query
	 */
	public function getSingle($query) {

	}

	/**
	 * Method to get search results from the database
	 * @param $query
	 */
	public function search($query) {

	}

	/**
	 * Method to write errors to a log file
	 * @param $error
	 */
	public function logError($error) {
		error_log("SQL error: $error".PHP_EOL,3,"logs/error-log.log");
	}
}