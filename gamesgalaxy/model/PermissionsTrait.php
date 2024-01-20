<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
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
		$this->dbConnection = DatabaseConnection::getInstance();
	}

	protected function hasPermission($userId, $permission) {
		if (!in_array($permission, $this->validPermissions)) {
			throw new \InvalidArgumentException("Ungültige Berechtigung: $permission");
		}

		$sql = "SELECT $permission FROM user_authority WHERE user_id = ?";
		$stmt = $this->dbConnection->prepare($sql);
		$stmt->execute([$userId]);
		return (bool) $stmt->fetchColumn();
	}
}
