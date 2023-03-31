<?php

namespace Source\Models;

use Source\Core\Model;

class Message extends Model
{
    public function __construct()
    {
        parent::__construct("messages", ["id"], ["subject", "content", "sender", "recipient"]);
    }

    public function recipientFullName(): string
    {
        $find = (new User())->findById($this->recipient);
        return "{$find->first_name} {$find->last_name}";
    }

    public function senderFullName(): string
    {
        $find = (new User())->findById($this->sender);
        return "{$find->first_name} {$find->last_name}";
    }
}