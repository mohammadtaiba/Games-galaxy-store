<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class HinzufuegenModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    function read()
    {

    }

    function create()
    {

    }

    function update()
    {

    }

    function delete()
    {

    }

    function read_all()
    {

    }

    function match_and_read(string $search_string)
    {

    }

    function delete_all()
    {

    }
}
