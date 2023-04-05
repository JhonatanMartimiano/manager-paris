<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class Negotiation extends Model
{
    /**
     * Negotiation constructor.
     */
    public function __construct()
    {
        parent::__construct("negotiations", ["id"], [
            "client_id",
            "seller_id",
            "met_us",
            "branch",
            "contact_type",
            "next_contact",
            "funnel_id"
        ]);
    }

    public function infoFunnel()
    {
        return (new Funnel())->findById($this->funnel_id);
    }

    public function infoClient()
    {
        return (new Client())->findById($this->client_id);
    }

    public function infoSeller()
    {
        return (new Seller())->findById($this->seller_id);
    }

    public function getClientIDNeg($id_neg)
    {
        return $this->findById($id_neg);
    }

    public function infoClientID($client_id)
    {
        return (new Client())->findById($client_id);
    }

    public function infoSellerID($seller_id)
    {
        return (new Seller())->findById($seller_id);
    }

    public function infoFunnelID($funnel_id)
    {
        return (new Funnel())->findById($funnel_id);
    }
}