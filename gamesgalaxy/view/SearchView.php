<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";

class SearchView extends View
{
	public static function show(array $games)
	{
		echo '<div id="platform-title" class="platform-title">Suchergebnisse</div>';

		echo <<<SEARCH

		SEARCH;
		if (empty($games)) {
			echo '<p>Keine Spiele gefunden.</p>';
		} else {
			foreach ($games as $game) {
				echo '<div class="games-grid-item" data-game-id="' . htmlspecialchars($game['game_id']) . '">';
				echo '<h2>' . htmlspecialchars($game['game_name']) . '</h2>';
				echo '<p>Plattform: ' . htmlspecialchars($game['game_platform']) . '</p>';
				echo '<p>' . htmlspecialchars($game['game_price']) . '€</p>';
				echo '<p>' . htmlspecialchars($game['game_description']) . '</p>';
				echo '</div>';
			}
		}

		echo '</div><script src="/dwp_ws2324_rkt/gamesgalaxy/js/spiel.js"></script></body></html>';
	}
}
