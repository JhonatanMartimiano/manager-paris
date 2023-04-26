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

    /**
     * @return boolean
     */
    public function deleteAllNegotiations(): bool
    {
        $negotiations = (new Negotiation())->find("client_id = :cid", "cid={$this->id}")->fetch(true);
        if ($negotiations) {
            foreach ($negotiations as $negotiation) {
                $negotiation->destroy();
                return true;
            }
        }
        return false;
    }

    public function funnelNewClients()
    {
        if (user()->level >= 3) {
            $find = (new Client())->find("funnel_id IS NULL")->limit(10);
            return $find->fetch(true);
        } else {
            $seller_id = user()->seller_id;
            $find = (new Client())->find("seller_id = :sid AND funnel_id IS NULL", "sid={$seller_id}")->limit(10);
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

    /**
     * @param string $phone
     * @return boolean
     */
    public function phoneExist(string $phone): bool
    {
        $find = (new Client())->find("phone = :p", "p={$phone}")->count();
        if ($find) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $phoneInt
     * @return boolean
     */
    public function phoneIntExist(string $phoneInt): bool
    {
        $find = (new Client())->find("phone_int = :pi", "pi={$phoneInt}")->count();
        if ($find) {
            return true;
        } else {
            return false;
        }
    }
}