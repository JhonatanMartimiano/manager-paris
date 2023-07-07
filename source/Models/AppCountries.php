<?php

namespace Source\Models;

use Source\Core\Model;

class AppCountries extends Model
{
    public function __construct()
    {
        parent::__construct("app_countries", ["id"], []);
    }
}