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
            $db_host = getenv('GG_DB_HOST') ?: 'localhost';
            $db_user = getenv('GG_DB_USER') ?: 'root';
            $db_password = getenv('GG_DB_PASSWORD') ?: '';
            $db_name = getenv('GG_DB_NAME') ?: 'gg_dbms';

            self::$instance = new mysqli($db_host, $db_user, $db_password, $db_name);
        }

        return self::$instance;
    }

}
