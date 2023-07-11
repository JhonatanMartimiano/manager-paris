<?php

namespace Source\App\Admin;

use Source\Core\Connect;
use Source\Models\Auth;
use Source\Models\Client;
use Source\Models\Message;
use Source\Models\Negotiation;

/**
 * Class Dash
 * @package Source\App\Admin
 */
class Dash extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     *
     */
    public function dash(): void
    {
        redirect("/admin/dash/home");
    }
    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        $seller_id = user()->seller_id;
        $negotiations = new Negotiation();

        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");

        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $query = null;
        (user()->level >= 3) ? $query = Connect::getInstance()->query("SELECT C.name AS cliente, V.first_name AS vendedor, 
        MAX(N.id) AS id_neg,
        MAX(CASE WHEN N.funnel_id = 1 THEN N.contact_type END) AS etapa1,
        MAX(CASE WHEN N.funnel_id = 1 THEN N.updated_at END) AS data1,
        MAX(CASE WHEN N.funnel_id = 1 THEN N.next_contact END) AS data11,
        MAX(CASE WHEN N.funnel_id = 1 THEN N.description END) AS obs1,
        MAX(CASE WHEN N.funnel_id = 2 THEN N.contact_type END) AS etapa2,
        MAX(CASE WHEN N.funnel_id = 2 THEN N.updated_at END) AS data2,
        MAX(CASE WHEN N.funnel_id = 2 THEN N.next_contact END) AS data22,
        MAX(CASE WHEN N.funnel_id = 2 THEN N.description END) AS obs2,
        MAX(CASE WHEN N.funnel_id = 3 THEN N.contact_type END) AS etapa3,
        MAX(CASE WHEN N.funnel_id = 3 THEN N.updated_at END) AS data3,
        MAX(CASE WHEN N.funnel_id = 3 THEN N.next_contact END) AS data33,
        MAX(CASE WHEN N.client_id = C.id THEN N.description END) AS obs
    FROM clients AS C 
        INNER JOIN negotiations AS N ON N.client_id = C.id 
        INNER JOIN sellers AS V ON N.seller_id = V.id 
    WHERE 
        N.id IN (
        SELECT 
            MAX(N2.id) 
        FROM negotiations AS N2 
        GROUP BY N2.client_id, N2.funnel_id
        )
    GROUP BY 
        C.id, 
        V.id 
    ORDER BY 
        id_neg DESC,
        C.name, 
        V.first_name
    LIMIT 20")->fetchAll() : $query = Connect::getInstance()->query("SELECT C.name AS cliente, V.first_name AS vendedor, 
    MAX(N.id) AS id_neg,
    MAX(CASE WHEN N.funnel_id = 1 THEN N.contact_type END) AS etapa1,
    MAX(CASE WHEN N.funnel_id = 1 THEN N.updated_at END) AS data1,
    MAX(CASE WHEN N.funnel_id = 1 THEN N.next_contact END) AS data11,
    MAX(CASE WHEN N.funnel_id = 1 THEN N.description END) AS obs1,
    MAX(CASE WHEN N.funnel_id = 2 THEN N.contact_type END) AS etapa2,
    MAX(CASE WHEN N.funnel_id = 2 THEN N.updated_at END) AS data2,
    MAX(CASE WHEN N.funnel_id = 2 THEN N.next_contact END) AS data22,
    MAX(CASE WHEN N.funnel_id = 2 THEN N.description END) AS obs2,
    MAX(CASE WHEN N.funnel_id = 3 THEN N.contact_type END) AS etapa3,
    MAX(CASE WHEN N.funnel_id = 3 THEN N.updated_at END) AS data3,
    MAX(CASE WHEN N.funnel_id = 3 THEN N.next_contact END) AS data33,
    MAX(CASE WHEN N.client_id = C.id THEN N.description END) AS obs
    FROM clients AS C 
        INNER JOIN negotiations AS N ON N.client_id = C.id 
        INNER JOIN sellers AS V ON N.seller_id = V.id 
    WHERE 
        N.id IN (
        SELECT 
            MAX(N2.id) 
        FROM negotiations AS N2 
        GROUP BY N2.client_id, N2.funnel_id
        )
        AND N.seller_id = {$seller_id}
    GROUP BY 
        C.id, 
        V.id 
    ORDER BY 
        id_neg DESC,
        C.name, 
        V.first_name
    LIMIT 20
    ")->fetchAll();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $userID = user()->id;
        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "post24hour" => ($post24hour) ?? 0 + $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "allNegotiations" => $query,
            "negotiation" => (new Negotiation()),
            "newClients" => (user()->level >= 3) ? (new Client())->find("funnel_id IS NULL  AND YEAR(registration_date) >= 2023")->order("id DESC")->limit(10)->fetch(true) : (new Client())->find("funnel_id IS NULL AND YEAR(registration_date) >= 2023 AND seller_id = :sid", "sid={$seller_id}")->order("id DESC")->limit(10)->fetch(true),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }
    /**
     *
     */
    public
    function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->first_name}.")->flash();
        Auth::logout();
        redirect("/admin/login");
    }
    public
    function late(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $post24hour30 = (user()->level >= 3) ? Connect::getInstance()->query(
            "SELECT N1.*
            FROM negotiations N1
            INNER JOIN clients c ON N1.client_id = c.id
            LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
            WHERE N2.id IS NULL
            AND N1.next_contact BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 1 DAY
            AND N1.contact_type != 'PFinalizado'
            AND c.status != 'Concluído'
            ORDER BY N1.client_id, N1.id DESC LIMIT 20"
        )->fetchAll() : Connect::getInstance()->query(
            "SELECT N1.*
                FROM negotiations N1
                INNER JOIN clients c ON N1.client_id = c.id
                LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                WHERE N2.id IS NULL
                AND N1.seller_id = {$seller_id}
                AND N1.next_contact BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 1 DAY
                AND N1.contact_type != 'PFinalizado'
                AND c.status != 'Concluído'
                ORDER BY N1.client_id, N1.id DESC LIMIT 20"
        )->fetchAll();

        $post24hourF = null;
        if (!empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $post24hourF = (user()->level >= 3) ? $negotiations->find("next_contact - CURDATE() < -1 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}'")->group("client_id")->order('id DESC')->fetch(true) : $negotiations->find("next_contact - CURDATE() < -1 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->group("client_id")->order('id DESC')->fetch(true);
        }


        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/late', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "post24hourArr" => (!empty($data)) ? $post24hourF : $post24hour30,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "date" => $data
        ]);
    }
    public
    function completed(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $completedOrders30 = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.*
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll() : Connect::getInstance()->query("SELECT N1.*
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll();

        $completedOrdersF = null;
        if (!empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $completedOrdersF = (user()->level >= 3) ? $negotiations->find("contact_type = 'PFinalizado' AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}'")->group("client_id")->fetch(true) : $negotiations->find("contact_type = 'PFinalizado' AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->group("client_id")->fetch(true);
        }

        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/completed', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "completedOrdersArr" => (!empty($data)) ? $completedOrdersF : $completedOrders30,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "date" => $data
        ]);
    }
    public
    function waiting(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $waiting30 = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll() : Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll();

        $waitF = null;
        if (!empty($data)) {
            $waitF = (user()->level >= 3) ? $negotiations->find("contact_type != 'PFinalizado' AND reason_loss = '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}'")->order('id DESC')->group("client_id")->limit(20)->fetch(true) : $negotiations->find("contact_type != 'PFinalizado' AND reason_loss = '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->order('id DESC')->group("client_id")->limit(20)->fetch(true);
        }
        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/waiting', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "waitingArr" => (!empty($data)) ? $waitF : $waiting30,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "date" => $data
        ]);
    }
    public
    function inNegotiations(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $inNegotiations30 = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll() : Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll();

        $inNegotiationF = null;
        if (!empty($data)) {
            $inNegotiationF = (user()->level >= 3) ? $negotiations->find("contact_type != 'PFinalizado' AND reason_loss = '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}'")->group("client_id")->limit(20)->fetch(true) : $negotiations->find("contact_type != 'PFinalizado' AND reason_loss = '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->group("client_id")->limit(20)->fetch(true);
        }
        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/inNegotiations', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "inNegotiationsArr" => (!empty($data)) ? $inNegotiationF : $inNegotiations30,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "date" => $data
        ]);
    }
    public
    function loss(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss30 = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.*
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll() : Connect::getInstance()->query("SELECT N1.*
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll();

        $lossNF = null;
        if (!empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $lossNF = (user()->level >= 3) ? $negotiations->find("reason_loss != '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->order('id DESC')->group("client_id")->limit(20)->fetch(true) : $negotiations->find("reason_loss != '' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->order('id DESC')->group("client_id")->limit(20)->fetch(true);
        }
        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/loss', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "waitingArr" => $waiting,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "lossArr" => (!empty($data)) ? $lossNF : $loss30,
            "date" => $data
        ]);
    }

    public
    function future(?array $data)
    {
        $seller_id = \user()->seller_id;
        $monthNow = date("m");
        $yearNow = date("Y");
        $start_date = "{$yearNow}-{$monthNow}-01";
        $end_date = date("Y-m-d");
        $negotiations = new Negotiation();
        $post24hour = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.next_contact - CURDATE() < -1
        AND N1.contact_type != 'PFinalizado'
        AND c.status != 'Concluído'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $completedOrders = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount() :
            Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.contact_type = 'PFinalizado'
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $waiting = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.seller_id = {$seller_id}
        AND (N1.contact_type = 'APagamento'
        OR N1.contact_type = 'Orçamento'
        OR N1.contact_type = 'Cotação')
        AND N1.contact_type != 'PFinalizado'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $inNegotiations = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type != 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $loss = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.seller_id = {$seller_id}
        AND N1.reason_loss != ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount();

        $future = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
        AND N1.next_contact - CURDATE() >= 0
        AND N1.contact_type != 'APagamento'
        AND N1.contact_type != 'NRespondeu'
        AND N1.contact_type != 'Orçamento'
        AND N1.contact_type != 'Cotação'
        AND N1.contact_type != 'PFinalizado'
        AND N1.contact_type = 'PFuturo'
        AND N1.reason_loss = ''
        ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
        FROM negotiations N1
        INNER JOIN clients c ON N1.client_id = c.id
        LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
        WHERE N2.id IS NULL
        AND N1.created_at BETWEEN '$start_date' AND '$end_date'
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

        $inNegotiations30 = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll() : Connect::getInstance()->query("SELECT N1.*
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
        ORDER BY N1.client_id, N1.id DESC LIMIT 20")->fetchAll();

        $inNegotiationF = null;
        if (!empty($data)) {
            $inNegotiationF = (user()->level >= 3) ? $negotiations->find("contact_type = 'PFuturo' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}'")->group("client_id")->limit(20)->fetch(true) : $negotiations->find("contact_type != 'PFuturo' AND updated_at - CURDATE() >= -30 AND updated_at BETWEEN '{$data['first_date']}' AND '{$data['second_date']}' AND seller_id = :sid", "sid={$seller_id}")->group("client_id")->limit(20)->fetch(true);
        }

        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );
        echo $this->view->render('widgets/dash/future', [
            'app' => 'dash',
            'head' => $head,
            "post24hour" => ($post24hour) ?? $registrationDate,
            "completedOrders" => ($completedOrders) ?? 0,
            "waiting" => ($waiting) ?? 0,
            "inNegotiations" => ($inNegotiations) ?? 0,
            "waitingArr" => $waiting,
            "loss" => ($loss) ?? 0,
            "future" => ($future) ?? 0,
            "futureArr" => (!empty($data)) ? $inNegotiationF : $inNegotiations30,
            "date" => $data
        ]);
    }

    public function contactTypeAjax()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $seller_id = user()->seller_id;
            switch ($data["contact_type"]) {
                case 'late':
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.next_contact - CURDATE() < -1
                    AND N1.contact_type != 'PFinalizado'
                    AND c.status != 'Concluído'
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.seller_id = {$seller_id}
                    AND N1.next_contact - CURDATE() < -1
                    AND N1.contact_type != 'PFinalizado'
                    AND c.status != 'Concluído'
                    ORDER BY N1.client_id, N1.id DESC")->rowCount();
                    break;

                case "completed":
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.contact_type = 'PFinalizado'
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() :
                        Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.seller_id = {$seller_id}
                    AND N1.contact_type = 'PFinalizado'
                    ORDER BY N1.client_id, N1.id DESC")->rowCount();
                    break;
                
                case "waiting":
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
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
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
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
                    break;

                case "inNegotiation":
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
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
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
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
                    break;

                case "loss":
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.reason_loss != ''
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
                    FROM negotiations N1
                    INNER JOIN clients c ON N1.client_id = c.id
                    LEFT JOIN negotiations N2 ON N2.client_id = N1.client_id AND N2.id > N1.id
                    WHERE N2.id IS NULL
                    AND N1.seller_id = {$seller_id}
                    AND N1.reason_loss != ''
                    ORDER BY N1.client_id, N1.id DESC")->rowCount();
                    break;

                case "future":
                    $result = (user()->level >= 3) ? Connect::getInstance()->query("SELECT N1.id
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
                    ORDER BY N1.client_id, N1.id DESC")->rowCount() : Connect::getInstance()->query("SELECT N1.id
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
                    break;

            }
            $json["result"] = $result;
            echo json_encode($json);
        }
    }
}
