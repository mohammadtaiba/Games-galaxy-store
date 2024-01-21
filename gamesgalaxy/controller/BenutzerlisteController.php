<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BenutzerlisteView.php";
require_once __DIR__."/../model/BenutzerlisteModel.php";
require_once __DIR__."/../model/PermissionsTrait.php";

use gamesgalaxy\Model\BenutzerlisteModel;
use gamesgalaxy\View\BenutzerlisteView;
use gamesgalaxy\Model\PermissionsTrait;

class BenutzerlisteController extends Controller
{
	use PermissionsTrait;

	private $benutzerlisteModel;

	public function __construct() {
		$this->benutzerlisteModel = new BenutzerlisteModel();
		$this->initDBConnection();
	}

	public function actionShow()
	{
		if (!$this->isUserAuthenticated()) {
			header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
			exit();
		}

		$currentUserId = $_SESSION['user_id'] ?? null;

		if ($this->hasPermission($currentUserId, 'change_user')) {
			$users = $this->benutzerlisteModel->get_all_users_except_current($currentUserId);

			$benutzerliste_view = new BenutzerlisteView();
			$benutzerliste_view->title = "Benutzerliste";
			$benutzerliste_view->render_html('show', $users);
		} else {
			echo "<script>alert('Sie haben keine Berechtigung, die Benutzerliste anzusehen oder zu bearbeiten.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
			exit;
		}

	}

	public function actionDeleteUser()
	{
		if (!$this->isUserAuthenticated()) {
			header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
			exit();
		}

		$currentUserId = $_SESSION['user_id'] ?? null;
		if ($this->hasPermission($currentUserId, 'delete_user')) {
			$userId = $_POST['user_id'];

			$this->benutzerlisteModel->delete_user($userId);
			header("Location: /dwp_ws2324_rkt/gamesgalaxy/Benutzerliste/Show");
			exit();
		} else {
			echo "Sie sind nicht berechtigt, Benutzer zu löschen.";
			exit();
		}

	}

}
