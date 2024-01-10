<?php
namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/SteamspieleView.php";
require_once __DIR__ . "/../model/SteamspieleModel.php";

use gamesgalaxy\View\SteamspieleView;
use gamesgalaxy\Model\SteamspieleModel;

class SteamspieleController extends Controller
{
    public function actionShow()
    {
        $sortOption = $_POST['sortby'] ?? 'default-sort';
        $filterOption = $_POST['filterby'] ?? 'all';

        $spiele_model = new SteamspieleModel();
        $steam_games = $spiele_model->getAllGamesWithCategories($sortOption, $filterOption);

        $steam_games = array_filter($steam_games, function ($game) use ($filterOption) {
            return isset($game['game_platform']) && $game['game_platform'] === 'Steam';
        });

        $steamspiele_view = new SteamspieleView();
        $steamspiele_view->title = "Steam";

        $filtered_games = array_filter($steam_games, function ($game) use ($filterOption) {
            return $filterOption === 'all' || in_array(strtolower($filterOption), array_map('strtolower', $game['category_names']));
        });

        $steam_games = $filtered_games;

        $steamspiele_view->render_html('show', ['games' => $steam_games]);
    }

}

