<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

trait PermissionsTrait
{
	protected $dbConnection;

	protected $validPermissions = [
		'create_user',
		'change_user',
		'delete_user',
		'create_game',
		'change_game',
		'delete_game'
	];

	protected function initDBConnection() {
		$this->dbConnection = DatabaseConnection::get_instance();
		if ($this->dbConnection === null) {
			throw new \Exception("Datenbankverbindung konnte nicht initialisiert werden.");
		}
	}

	protected function hasPermission($userId, $permission) {
		$this->initDBConnection();

		if (!in_array($permission, $this->validPermissions)) {
			throw new \InvalidArgumentException("Ungültige Berechtigung: $permission");
		}

		$sql = "SELECT $permission FROM user_authority WHERE user_id = ?";
		$stmt = $this->dbConnection->prepare($sql);
		if (!$stmt) {
			throw new \Exception("Vorbereitung des SQL-Statements fehlgeschlagen: " . $this->dbConnection->error);
		}

		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result === false) {
			throw new \Exception("Ausführung des SQL-Statements fehlgeschlagen: " . $stmt->error);
		}

		$row = $result->fetch_assoc();
		return isset($row[$permission]) ? (bool) $row[$permission] : false;
	}

}
