<?php

namespace gamesgalaxy\lib\DatabaseConnection;

use mysqli;

class DatabaseConnection
{

    private static \mysqli $instance;

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function get_instance(): \mysqli
    {
        if (!isset(self::$instance)) {
            self::$instance = new mysqli("localhost", "root", "", "gg_dbms");
        }

        return self::$instance;
    }

}