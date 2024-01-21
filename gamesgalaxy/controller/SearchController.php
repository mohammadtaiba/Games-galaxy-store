<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/SearchView.php";
require_once __DIR__."/../model/SearchModel.php";

use gamesgalaxy\Controller\Controller;

use gamesgalaxy\View\SearchView;
use gamesgalaxy\Model\SearchModel;

class SearchController extends Controller
{
	private $searchModel;

	public function __construct()
	{
		$this->searchModel = new SearchModel();
	}

	public function actionShow()
	{
		if (isset($_GET['q'])) {
			$searchString = $_GET['q'];
			$results = $this->searchModel->match_and_read($searchString);
			SearchView::show($results);
		} else {
			SearchView::show([]);
		}
	}

}