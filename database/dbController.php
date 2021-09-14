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
	 * @return bool - Did we successfully insert the record into the database?
	 */
	public function insert($query, $name, $imageUrl): bool {

		if($this->conn->error) {
			$this->logError($this->conn->error);
			return false;
		}

		$statement = $this->conn->prepare($query);

		if(!$statement) {
			$this->logError("Prepare failed");
			return false;
		}

		$statement->bind_param("ssssss", $name, $imageUrl);
		$statement->execute();

		$this->logError($statement->affected_rows);

		if($statement->affected_rows) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Method to write errors to a log file
	 * @param $error
	 */
	public function logError($error) {
		error_log("SQL error: $error".PHP_EOL,3,"logs/error-log.log");
	}
}