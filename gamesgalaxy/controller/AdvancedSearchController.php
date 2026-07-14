<?php

namespace gamesgalaxy\Controller;

require_once __DIR__ . "/../view/AdvancedSearchView.php";
require_once __DIR__ . "/../model/AdvancedSearchModel.php";
require_once __DIR__ . "/../lib/exception/SearchIndexException.php";

use gamesgalaxy\lib\exception\SearchIndexException;
use gamesgalaxy\Model\AdvancedSearchModel;
use gamesgalaxy\View\AdvancedSearchView;

class AdvancedSearchController extends Controller
{
    private AdvancedSearchModel $_advanced_search_model;

    public function __construct()
    {
        $this->_advanced_search_model = new AdvancedSearchModel();
    }

    public function actionShow()
    {
        $query = trim($_GET['q'] ?? '');

        if ($query !== '')
        {
            error_log('AdvancedSearchController: Erweiterte Suche gestartet.');
            $result = $this->_advanced_search_model->advanced_search($query);
        }
        else
        {
            $result = [
                'games' => [],
                'meta' => [
                    'raw_query' => '',
                    'semantic_query' => '',
                    'filters' => [],
                    'fallback_used' => false,
                    'fallback_reason' => '',
                    'source' => 'none'
                ]
            ];
        }

        $advanced_search_view = new AdvancedSearchView();
        $advanced_search_view->title = "Erweiterte KI-Suche";
        $advanced_search_view->render_html('show', $result);
    }

    public function actionIndex()
    {
        if (!$this->_is_index_request_allowed())
        {
            error_log('AdvancedSearchController: Indexierung ohne gültiges Token abgelehnt.');
            header("HTTP/1.0 403 Forbidden");
            echo "Indexierung nicht erlaubt.";
            return;
        }

        try
        {
            $reset_index = ($_GET['reset'] ?? '') === '1';
            $indexed_count = $this->_advanced_search_model->index_all_games($reset_index);
            echo "Indexierung abgeschlossen. Spiele indexiert: " . $indexed_count;
        }
        catch (SearchIndexException $exception)
        {
            error_log('AdvancedSearchController: Indexierung fehlgeschlagen: ' . $exception->getMessage());
            header("HTTP/1.0 500 Internal Server Error");
            echo "Indexierung fehlgeschlagen.";
        }
    }

    private function _is_index_request_allowed(): bool
    {
        $token = getenv('GG_ADVANCED_SEARCH_INDEX_TOKEN');

        if ($token === false || $token === '')
        {
            return false;
        }

        return hash_equals($token, $_GET['token'] ?? '');
    }
}
