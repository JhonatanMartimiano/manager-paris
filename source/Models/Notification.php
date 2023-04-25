<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class Notification extends Model
{
    /**
     * Notification constructor.
     */
    public function __construct()
    {
        parent::__construct("notifications", ["id"], ["content", "status", "seller_id"]);
    }
}