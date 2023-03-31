<?php

namespace Source\App\Admin;

use Source\Models\Client;
use Source\Models\Message;
use Source\Models\Negotiation;
use Source\Models\Seller;
use Source\Support\Pager;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Reports extends Admin
{
    /**
     * Reports Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function sellers(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/reports/sellers/{$s}/1")]);
            return;
        }

        $search = null;
        $sellers = (new Seller())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $sellers = (new Seller())->find("first_name LIKE CONCAT('%', :s, '%') OR last_name LIKE CONCAT('%', :s, '%') OR email LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$sellers->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/reports/sellers");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/reports/sellers/{$all}/"));
        $pager->pager($sellers->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatórios",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $clients = (new Client())->find()->fetch(true);

        if ($clients) {
            foreach ($clients as $client) {
                if ((new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count()) {
                    $count = (new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count() - 1;
                    $lastNegotiations[] = (new Negotiation())->find("client_id = :cid",
                        "cid={$client->id}")->fetch(true)[$count];
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) < -1) {
                        $post24hour[] = $lastNegotiations[$i];
                    }
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0) {
                        if ($lastNegotiations[$i]->infoClient()->status != "Concluído" && $lastNegotiations[$i]->infoClient()->reason_loss == "") {
                            $inNegotiations[] = $lastNegotiations[$i];
                        }
                    }
                }
            }
        }

        $userID = user()->id;

        echo $this->view->render("widgets/reports/sellers", [
            "app" => "reports/sellers",
            "head" => $head,
            "search" => $search,
            "sellers" => $sellers->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "lastNegotiations" => ($lastNegotiations) ? count($lastNegotiations) : "0",
            "post24hour" => ($post24hour) ? count($post24hour) : "0",
            "completedOrders" => (new Client())->find("status = 'Concluído'")->count(),
            "waiting" => (new Negotiation())->find("contact_type = 'APagamento' OR contact_type = 'NRespondeu'")->count(),
            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : "0",
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function seller(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatórios",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $clients = (new Client())->find("seller_id = :sid", "sid={$data['seller_id']}")->fetch(true);

        if ($clients) {
            foreach ($clients as $client) {
                if ((new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count()) {
                    $count = (new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count() - 1;
                    $lastNegotiations[] = (new Negotiation())->find("client_id = :cid",
                        "cid={$client->id}")->fetch(true)[$count];
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) < -1) {
                        $post24hour[] = $lastNegotiations[$i];
                    }
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0) {
                        if ($lastNegotiations[$i]->infoClient()->status != "Concluído" && $lastNegotiations[$i]->infoClient()->reason_loss == "") {
                            $inNegotiations[] = $lastNegotiations[$i];
                        }
                    }
                }
            }
        }

        $userID = user()->id;

        echo $this->view->render("widgets/reports/seller", [
            "app" => "reports/sellers",
            "head" => $head,
            "lastNegotiations" => ($lastNegotiations) ? count($lastNegotiations) : "0",
            "post24hour" => ($post24hour) ? count($post24hour) : "0",
            "completedOrders" => (new Client())->find("status = 'Concluído'")->count(),
            "waiting" => (new Negotiation())->find("contact_type = 'APagamento' OR contact_type = 'NRespondeu'")->count(),
            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : "0",
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function steps(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/reports/steps/{$s}/1")]);
            return;
        }

        $search = null;
        $sellers = (new Seller())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $sellers = (new Seller())->find("first_name LIKE CONCAT('%', :s, '%') OR last_name LIKE CONCAT('%', :s, '%') OR email LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$sellers->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/reports/steps");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/reports/steps/{$all}/"));
        $pager->pager($sellers->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatórios",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        echo $this->view->render("widgets/reports/steps", [
            "app" => "reports/steps",
            "head" => $head,
            "search" => $search,
            "sellers" => $sellers->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "negotiations" => (new Negotiation())->find()->count(),
            "presentation" => (new Negotiation())->find("contact_type = 'Apresentação'")->count(),
            "table" => (new Negotiation())->find("contact_type = 'Tabela'")->count(),
            "price" => (new Negotiation())->find("contact_type = 'Cotação'")->count(),
            "apayment" => (new Negotiation())->find("contact_type = 'APagamento'")->count(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function step(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatórios",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $clients = (new Client())->find("seller_id = :sid", "sid={$data['seller_id']}")->fetch(true);

        if ($clients) {
            foreach ($clients as $client) {
                if ((new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count()) {
                    $count = (new Negotiation())->find("client_id = :cid", "cid={$client->id}")->count() - 1;
                    $lastNegotiations[] = (new Negotiation())->find("client_id = :cid",
                        "cid={$client->id}")->fetch(true)[$count];
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) < -1) {
                        $post24hour[] = $lastNegotiations[$i];
                    }
                }
            }

            if ($lastNegotiations) {
                for ($i = 0; $i < count($lastNegotiations); $i++) {
                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0) {
                        if ($lastNegotiations[$i]->infoClient()->status != "Concluído" && $lastNegotiations[$i]->infoClient()->reason_loss == "") {
                            $inNegotiations[] = $lastNegotiations[$i];
                        }
                    }
                }
            }
        }

        $userID = user()->id;

        echo $this->view->render("widgets/reports/step", [
            "app" => "reports/steps",
            "head" => $head,
            "negotiations" => (new Negotiation())->find("seller_id = :sid", "sid={$data['seller_id']}")->count(),
            "presentation" => (new Negotiation())->find("seller_id = :sid AND contact_type = 'Apresentação'", "sid={$data['seller_id']}")->count(),
            "table" => (new Negotiation())->find("seller_id = :sid AND contact_type = 'Tabela'", "sid={$data['seller_id']}")->count(),
            "price" => (new Negotiation())->find("seller_id = :sid AND contact_type = 'Cotação'", "sid={$data['seller_id']}")->count(),
            "apayment" => (new Negotiation())->find("seller_id = :sid AND contact_type = 'APagamento'", "sid={$data['seller_id']}")->count(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }
}