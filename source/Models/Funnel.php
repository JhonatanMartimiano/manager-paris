<?php

namespace Source\Models;

use Source\Core\Model;

class Funnel extends Model
{
    public function __construct()
    {
        parent::__construct("funnels", ["id"], ["title", "sequence"]);
    }

    public function funnelClients()
    {
        if (user()->level >= 3) {
            $find = (new Client())->find("funnel_id = :fid AND status = 'Negociação' AND reason_loss = ''", "fid={$this->id}");
            return $find->fetch(true);
        } else {
            $seller_id = user()->seller_id;
            $find = (new Client())->find("seller_id = :sid AND funnel_id = :fid AND status = 'Negociação' AND reason_loss = ''", "sid={$seller_id}&fid={$this->id}");
            return $find->fetch(true);
        }
    }
}