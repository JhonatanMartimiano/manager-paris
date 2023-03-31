<?php

namespace Source\App\Admin;

use Source\Models\Client;
use Source\Models\Funnel;
use Source\Models\Message;
use Source\Models\Negotiation;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Negotiations extends Admin
{
    /**
     * Negotiations Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Negociações",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        echo $this->view->render("widgets/negotiations/home", [
            "app" => "negotiations/home",
            "head" => $head,
            "funnels" => (new Funnel())->find()->fetch(true),
            "clients" => (new Client()),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function negotiation(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $client = (new Client())->findById($data["client_id"]);

            $negotiationCreate = new Negotiation();
            $negotiationCreate->client_id = $client->id;
            $negotiationCreate->seller_id = $client->seller_id;
            $negotiationCreate->met_us = $data["met_us"];
            $negotiationCreate->branch = $data["branch"];
            $negotiationCreate->contact_type = $data["contact_type"];
            $negotiationCreate->reason_loss = $data["reason_loss"];
            $negotiationCreate->next_contact = ($data["next_contact"]) ? date_fmt_back($data["next_contact"]) : date("Y-m-d");
            $negotiationCreate->funnel_id = $data["funnel_id"];
            $negotiationCreate->description = $data["description"];

            if (!$negotiationCreate->save()) {
                $json["message"] = $negotiationCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $client->funnel_id = $data["funnel_id"];
            $client->status = $data["status"];

            if (!$client->save()) {
                $json["message"] = $negotiationCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Negociação salva com sucesso...")->flash();
            $json["redirect"] = url("/admin/negotiations/home");

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Negociação",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $client = (new Client())->findById($data["client_id"]);

        echo $this->view->render("widgets/negotiations/negotiation", [
            "app" => "clients/home",
            "head" => $head,
            "client" => $client,
            "funnels" => (new Funnel())->find()->fetch(true),
            "funnelSelected" => $client->funnel_id,
            "negotiations" => (new Negotiation())->find("client_id = :cid", "cid={$client->id}")->fetch(true),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }
}