<?php
namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BattlenetspieleView.php";
require_once __DIR__ . "/../model/BattlenetspieleModel.php";

use gamesgalaxy\View\BattlenetspieleView;
use gamesgalaxy\Model\BattlenetspieleModel;

class BattlenetspieleController extends Controller
{
    public function actionShow()
    {
        $sortOption = $_POST['sortby'] ?? 'default-sort';
        $filterOption = $_POST['filterby'] ?? 'all';

        $spiele_model = new BattlenetspieleModel();
        $battlenet_games = $spiele_model->getAllGamesWithCategories($sortOption, $filterOption);

        $battlenet_games = array_filter($battlenet_games, function ($game) use ($filterOption) {
            return isset($game['game_platform']) && $game['game_platform'] === 'Battle.net';
        });

        $battlenet_view = new BattlenetspieleView();
        $battlenet_view->title = "Battle.net";

        $filtered_games = array_filter($battlenet_games, function ($game) use ($filterOption) {
            return $filterOption === 'all' || in_array(strtolower($filterOption), array_map('strtolower', $game['category_names']));
        });

        $battlenet_games = $filtered_games;

        $battlenet_view->render_html('show', ['games' => $battlenet_games]);
    }

}
