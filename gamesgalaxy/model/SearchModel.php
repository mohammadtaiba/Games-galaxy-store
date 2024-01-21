<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class SearchModel extends Model
{
	private $db;

	public function __construct()
	{
		$this->db = DatabaseConnection::get_instance();
	}


	function create()
	{
		// TODO: Implement create() method.
	}

	function read()
	{
		// TODO: Implement read() method.
	}

	public function match_and_read(string $search_string)
	{
		$search_string = '%'.$this->db->real_escape_string($search_string).'%';
		$query = "SELECT * FROM game WHERE 
                  game_name LIKE ? OR 
                  game_description LIKE ? OR 
                  game_platform LIKE ?";

		$stmt = $this->db->prepare($query);
		if ($stmt) {
			$stmt->bind_param("sss", $search_string, $search_string, $search_string);
			$stmt->execute();
			$result = $stmt->get_result();
			$games = [];
			while ($row = $result->fetch_assoc()) {
				$games[] = $row;
			}
			$stmt->close();
			return $games;
		} else {
			error_log('SearchModel: prepare failed: ' . $this->db->error);
			return [];
		}
	}

	function read_all()
	{
		// TODO: Implement read_all() method.
	}

	function update()
	{
		// TODO: Implement update() method.
	}

	function delete()
	{
		// TODO: Implement delete() method.
	}

	function delete_all()
	{
		// TODO: Implement delete_all() method.
	}
}