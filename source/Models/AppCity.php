<?php

namespace Source\Models;

use Source\Core\Model;

class AppCity extends Model
{
    public function __construct()
    {
        parent::__construct("app_cities", ["id"], []);
    }
}