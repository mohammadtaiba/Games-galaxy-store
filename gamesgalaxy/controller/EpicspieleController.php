<?php
namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/EpicspieleView.php";
require_once __DIR__ . "/../model/EpicspieleModel.php";

use gamesgalaxy\View\EpicspieleView;
use gamesgalaxy\Model\EpicspieleModel;

class EpicspieleController extends Controller
{
    public function actionShow()
    {
        $sortOption = $_POST['sortby'] ?? 'default-sort';
        $filterOption = $_POST['filterby'] ?? 'all';

        $spiele_model = new EpicspieleModel();
        $epic_games = $spiele_model->getAllGamesWithCategories($sortOption, $filterOption);

        $epic_games = array_filter($epic_games, function ($game) use ($filterOption) {
            return isset($game['game_platform']) && $game['game_platform'] === 'Epic Games';
        });

        $epicspiele_view = new EpicspieleView();
        $epicspiele_view->title = "Epic Games";

        $filtered_games = array_filter($epic_games, function ($game) use ($filterOption) {
            return $filterOption === 'all' || in_array(strtolower($filterOption), array_map('strtolower', $game['category_names']));
        });

        $epic_games = $filtered_games;

        $epicspiele_view->render_html('show', ['games' => $epic_games]);
    }

}

