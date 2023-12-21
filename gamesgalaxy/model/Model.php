<?php

namespace gamesgalaxy\Model;

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

abstract class Model
{

    abstract function create();

    abstract function read();

    abstract function match_and_read(string $search_string);

    abstract function read_all();

    abstract function update();

    abstract function delete();

    abstract function delete_all();
}