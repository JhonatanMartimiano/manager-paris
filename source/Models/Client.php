<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class Client extends Model
{
    /**
     * Client constructor.
     */
    public function __construct()
    {
        parent::__construct("clients", ["id"],
            ["name","city", "state", "phone", "seller_id", "registration_date"]);
    }

    /**
     * @return array|mixed|Model|null
     */
    public function sellerName(): string
    {
        $find = (new Seller())->findById($this->seller_id);
        return "{$find->first_name} {$find->last_name}";
    }

    public function stepTitle()
    {
        return (new Funnel())->findById($this->funnel_id);
    }

    public function lastNegotiationInfo()
    {
        $find = (new Negotiation())->find("client_id = :cid", "cid={$this->id}");
        $count = $find->count() - 1;
        return $find->fetch(true)[$count];
    }

    public function funnelNewClients()
    {
        if (user()->level >= 3) {
            $find = (new Client())->find("funnel_id IS NULL");
            return $find->fetch(true);
        } else {
            $seller_id = user()->seller_id;
            $find = (new Client())->find("seller_id = :sid AND funnel_id IS NULL", "sid={$seller_id}");
            return $find->fetch(true);
        }
    }

    public function cityName()
    {
        return (new AppCity())->findById($this->city)->name;
    }

    public function stateName()
    {
        return (new AppState())->findById($this->state)->name;
    }
}