<?php

namespace Source\App\Admin;

use Source\Core\Connect;
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
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Relatórios",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $start_date = null;
        $end_date = null;

        $start_date = date_fmt_back($_SESSION["start_date"]);
        $end_date = date_fmt_back($_SESSION["end_date"]);

        unset($_SESSION["start_date"]);
        unset($_SESSION["end_date"]);

        $negotiations = new Negotiation();

        $post24hour = null;
        if ($start_date && $end_date) {
            $post24hour = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.next_contact - CURDATE() < -1
            AND N1.contact_type != 'PFinalizado'
            AND c.status != 'Concluído'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $post24hour = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() < -1
            AND N1.contact_type != 'PFinalizado'
            AND c.status != 'Concluído'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $completedOrders = null;
        if ($start_date && $end_date) {
            $completedOrders = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type = 'PFinalizado'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $completedOrders = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.contact_type = 'PFinalizado'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $waiting = null;
        if ($start_date && $end_date) {
            $waiting = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND (N1.contact_type = 'APagamento'
            OR N1.contact_type = 'Orçamento'
            OR N1.contact_type = 'Cotação')
            AND N1.contact_type != 'PFinalizado'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $waiting = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND (N1.contact_type = 'APagamento'
            OR N1.contact_type = 'Orçamento'
            OR N1.contact_type = 'Cotação')
            AND N1.contact_type != 'PFinalizado'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $inNegotiations = null;
        if ($start_date && $end_date) {
            $inNegotiations = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type != 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $inNegotiations = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type != 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $loss = null;
        if ($start_date && $end_date) {
            $loss = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.reason_loss != ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $loss = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.reason_loss != ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $future = null;
        if ($start_date && $end_date) {
            $future = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type = 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $future = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type = 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        if ($data["filter"] == "goFilter") {
            $_SESSION["start_date"] = $data["start_date"];
            $_SESSION["end_date"] = $data["end_date"];
            $start_date = date_fmt_back($_SESSION["start_date"]);
            $end_date = date_fmt_back($_SESSION["end_date"]);
            $json["redirect"] = url("/admin/reports/sellers");
            echo json_encode($json);
            return;
        }

        $lastNegotiations = $negotiations->find()->group("client_id")->count();

        $userID = user()->id;

        echo $this->view->render("widgets/reports/sellers", [
            "app" => "reports/sellers",
            "head" => $head,
            "sellers" => (new Seller())->find()->fetch(true),
            "lastNegotiations" => ($lastNegotiations) ?? "0",
            "post24hour" => ($post24hour) ?? "0",
            "completedOrders" => $completedOrders,
            "waiting" => $waiting,
            "inNegotiations" => ($inNegotiations) ?? "0",
            "loss" => ($loss) ?? "0",
            "future" => ($future) ?? "0",
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true),
            "start_date" => $start_date ? date_fmt($start_date, "d/m/Y") : null,
            "end_date" => $end_date ? date_fmt($end_date, "d/m/Y") : null
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

        $seller_id = $data["seller_id"];
        $negotiations = new Negotiation();
        $lastNegotiations = $negotiations->find("seller_id = :sid", "sid={$seller_id}")->group("client_id")->count();
        $start_date = null;
        $end_date = null;

        $start_date = date_fmt_back($_SESSION["start_date"]);
        $end_date = date_fmt_back($_SESSION["end_date"]);

        unset($_SESSION["start_date"]);
        unset($_SESSION["end_date"]);

        $post24hour = null;
        if ($start_date && $end_date) {
            $post24hour = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.next_contact - CURDATE() < -1
            AND N1.contact_type != 'PFinalizado'
            AND c.status != 'Concluído'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $post24hour = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact - CURDATE() < -1
            AND N1.contact_type != 'PFinalizado'
            AND c.status != 'Concluído'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $completedOrders = null;
        if ($start_date && $end_date) {
            $completedOrders = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type = 'PFinalizado'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $completedOrders = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.contact_type = 'PFinalizado'
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $waiting = null;
        if ($start_date && $end_date) {
            $waiting = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND (N1.contact_type = 'APagamento'
            OR N1.contact_type = 'Orçamento'
            OR N1.contact_type = 'Cotação')
            AND N1.contact_type != 'PFinalizado'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $waiting = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND (N1.contact_type = 'APagamento'
            OR N1.contact_type = 'Orçamento'
            OR N1.contact_type = 'Cotação')
            AND N1.contact_type != 'PFinalizado'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $inNegotiations = null;
        if ($start_date && $end_date) {
            $inNegotiations = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type != 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $inNegotiations = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type != 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $loss = null;
        if ($start_date && $end_date) {
            $loss = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.reason_loss != ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $loss = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.seller_id = {$seller_id}
            AND N1.reason_loss != ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        $future = null;
        if ($start_date && $end_date) {
            $future = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND N1.next_contact BETWEEN '$start_date' AND '$end_date'
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type = 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        } else {
            $future = Connect::getInstance()->query("SELECT N1.id
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact - CURDATE() >= 0
            AND N1.seller_id = {$seller_id}
            AND N1.contact_type != 'APagamento'
            AND N1.contact_type != 'NRespondeu'
            AND N1.contact_type != 'Orçamento'
            AND N1.contact_type != 'Cotação'
            AND N1.contact_type != 'PFinalizado'
            AND N1.contact_type = 'PFuturo'
            AND N1.reason_loss = ''
            ORDER BY N1.client_id, N1.id DESC")->rowCount();
        }

        if ($data["filter"] == "goFilter") {
            $_SESSION["start_date"] = $data["start_date"];
            $_SESSION["end_date"] = $data["end_date"];
            $start_date = date_fmt_back($_SESSION["start_date"]);
            $end_date = date_fmt_back($_SESSION["end_date"]);
            $json["redirect"] = url("/admin/reports/seller/{$seller_id}");
            echo json_encode($json);
            return;
        }

        $userID = user()->id;

        echo $this->view->render("widgets/reports/seller", [
            "app" => "reports/sellers",
            "head" => $head,
            "lastNegotiations" => ($lastNegotiations) ?? "0",
            "post24hour" => ($post24hour) ?? "0",
            "completedOrders" => $completedOrders,
            "waiting" => $waiting,
            "inNegotiations" => ($inNegotiations) ?? "0",
            "loss" => ($loss) ?? "0",
            "future" => ($future) ?? "0",
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true),
            "seller_id" => $seller_id,
            "start_date" => $start_date ? date_fmt($start_date, "d/m/Y") : null,
            "end_date" => $end_date ? date_fmt($end_date, "d/m/Y") : null
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
                    $lastNegotiations[] = (new Negotiation())->find(
                        "client_id = :cid",
                        "cid={$client->id}"
                    )->fetch(true)[$count];
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
