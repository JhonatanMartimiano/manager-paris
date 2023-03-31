<?php

namespace Source\Models;

use Source\Core\Model;

class AppState extends Model
{
    public function __construct()
    {
        parent::__construct("app_states", ["id"], []);
    }
}