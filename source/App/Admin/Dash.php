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

        $seller_id = \user()->seller_id;

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $query = Connect::getInstance()->query("SELECT C.name as cliente, V.first_name as vendedor,



        (SELECT N2.id FROM negotiations as N2 WHERE N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as id_neg,

        

        (SELECT N2.contact_type FROM negotiations as N2 WHERE N2.funnel_id = 1 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as etapa1,

        

        (SELECT N2.updated_at FROM negotiations as N2 WHERE N2.funnel_id = 1 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data1,

        (SELECT N2.next_contact FROM negotiations as N2 WHERE N2.funnel_id = 1 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data11,

        

        (SELECT N2.description FROM negotiations as N2 WHERE N2.funnel_id = 1 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as obs1,

        

        (SELECT N2.contact_type FROM negotiations as N2 WHERE N2.funnel_id = 2 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as etapa2,

        

        (SELECT N2.updated_at FROM negotiations as N2 WHERE N2.funnel_id = 2 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data2,

        (SELECT N2.next_contact FROM negotiations as N2 WHERE N2.funnel_id = 2 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data22,

        

        (SELECT N2.description FROM negotiations as N2 WHERE N2.funnel_id = 2 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as obs2,

        

        (SELECT N2.contact_type FROM negotiations as N2 WHERE N2.funnel_id = 3 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as etapa3,

        (SELECT N2.next_contact FROM negotiations as N2 WHERE N2.funnel_id = 3 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data33,

        

        (SELECT N2.updated_at FROM negotiations as N2 WHERE N2.funnel_id = 3 AND N2.client_id = N.client_id ORDER BY N2.id DESC LIMIT 1) as data3,

        

        (SELECT N2.description FROM negotiations as N2 WHERE N2.client_id = N.client_id ORDER BY N2.id DESC  LIMIT 1) as obs

        

        

        

        FROM negotiations as N INNER JOIN clients as C 

        ON N.client_id = C.id INNER JOIN sellers as V

        ON N.seller_id = V.id

        WHERE 1=1

        GROUP BY N.client_id")->fetchAll();



        $head = $this->seo->render(

            CONF_SITE_NAME . " | Dashboard",

            CONF_SITE_DESC,

            url("/admin"),

            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),

            false

        );



        $registrationDate = (user()->level >= 3) ? (new Client())->find("registration_date - CURDATE() < -1 AND status AND status != 'Negociação'")->count() : (new Client())->find("registration_date - CURDATE() < -1 AND seller_id = :sid AND status != 'Negociação' AND status != 'Concluído'", "sid={$seller_id}")->count();



        $userID = user()->id;



        echo $this->view->render("widgets/dash/home", [

            "app" => "dash",

            "head" => $head,

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "loss" => ($loss) ? count($loss) : 0,

            "allNegotiations" => $query,

            "negotiation" => (new Negotiation()),

            "newClients" => (\user()->level >= 3) ? (new Client())->find("funnel_id IS NULL")->fetch(true) : (new Client())->find("seller_id = :sid AND funnel_id IS NULL", "sid={$seller_id}")->fetch(true),

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

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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



                    if (date_diff_panel($lastNegotiations[$i]->next_contact) < -1 && date_diff_system($lastNegotiations[$i]->updated_at) >= -30) {

                        $post24hour30[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $post24hourF = null;

        if (!empty($data)) {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            foreach ($post24hour as $post24h) {

                if (date_diff_system(date_fmt($post24h->updated_at, 'Y-m-d'), $data['first_date']) >= 0 && date_diff_system(date_fmt($post24h->updated_at, 'Y-m-d'), $data['second_date']) <= 0) {

                    $post24hourF[] = $post24h;

                }

            }

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

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "post24hourArr" => (!empty($data)) ? $post24hourF : $post24hour30,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "loss" => ($loss) ? count($loss) : 0,

            "date" => $data

        ]);

    }



    public

    function completed(?array $data)

    {

        $seller_id = \user()->seller_id;

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }



                    if ($lastNegotiations[$i]->contact_type == "PFinalizado" && date_diff_system($lastNegotiations[$i]->updated_at) >= -30) {

                        $completedOrders30[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $completedOrdersF = null;

        if (!empty($data)) {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            foreach ($completedOrders as $completedOrder) {

                if (date_diff_system(date_fmt($completedOrder->updated_at, 'Y-m-d'), $data['first_date']) >= 0 && date_diff_system(date_fmt($completedOrder->updated_at, 'Y-m-d'), $data['second_date']) <= 0) {

                    $completedOrdersF[] = $completedOrder;

                }

            }

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

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "completedOrdersArr" => (!empty($data)) ? $completedOrdersF : $completedOrders30,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "loss" => ($loss) ? count($loss) : 0,

            "date" => $data

        ]);

    }



    public

    function waiting(?array $data)

    {

        $seller_id = \user()->seller_id;

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }



                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "" && date_diff_system($lastNegotiations[$i]->updated_at) >= -30) {

                            $waiting30[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $waitF = null;

        if (!empty($data)) {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            foreach ($waiting as $wait) {

                if (date_diff_system(date_fmt($wait->updated_at, 'Y-m-d'), $data['first_date']) >= 0 && date_diff_system(date_fmt($wait->updated_at, 'Y-m-d'), $data['second_date']) <= 0) {

                    $waitF[] = $wait;

                }

            }

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

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "waitingArr" => (!empty($data)) ? $waitF : $waiting30,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "loss" => ($loss) ? count($loss) : 0,

            "date" => $data

        ]);

    }



    public

    function inNegotiations(?array $data)

    {

        $seller_id = \user()->seller_id;

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }



                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "" && date_diff_system($lastNegotiations[$i]->updated_at) >= -30) {

                            $inNegotiations30[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $inNegotiationF = null;

        if (!empty($data)) {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            foreach ($inNegotiations as $inNegotiation) {

                if (date_diff_system(date_fmt($inNegotiation->updated_at, 'Y-m-d'), $data['first_date']) >= 0 && date_diff_system(date_fmt($inNegotiation->updated_at, 'Y-m-d'), $data['second_date']) <= 0) {

                    $inNegotiationF[] = $inNegotiation;

                }

            }

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

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "inNegotiationsArr" => (!empty($data)) ? $inNegotiationF : $inNegotiations30,

            "loss" => ($loss) ? count($loss) : 0,

            "date" => $data

        ]);

    }



    public

    function loss(?array $data)

    {

        $seller_id = \user()->seller_id;

        (\user()->level >= 3) ? $clients = (new Client())->find()->fetch(true) : $clients = (new Client())->find("seller_id = :sid", "sid={$seller_id}")->fetch(true);;



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

                    if ($lastNegotiations[$i]->contact_type == "PFinalizado") {

                        $completedOrders[] = $lastNegotiations[$i];

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type == 'APagamento' || $lastNegotiations[$i]->contact_type == 'Orçamento' || $lastNegotiations[$i]->contact_type == 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $waiting[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if (date_diff_panel($lastNegotiations[$i]->next_contact) >= 0 && $lastNegotiations[$i]->contact_type != 'APagamento' && $lastNegotiations[$i]->contact_type != 'NRespondeu' && $lastNegotiations[$i]->contact_type != 'Orçamento' && $lastNegotiations[$i]->contact_type != 'Cotação') {

                        if ($lastNegotiations[$i]->contact_type != "PFinalizado" && $lastNegotiations[$i]->reason_loss == "") {

                            $inNegotiations[] = $lastNegotiations[$i];

                        }

                    }

                }

            }



            if ($lastNegotiations) {

                for ($i = 0; $i < count($lastNegotiations); $i++) {

                    if ($lastNegotiations[$i]->reason_loss != "") {

                        $loss[] = $lastNegotiations[$i];

                    }



                    if ($lastNegotiations[$i]->reason_loss != "" && date_diff_system($lastNegotiations[$i]->updated_at) >= -30) {

                        $loss30[] = $lastNegotiations[$i];

                    }

                }

            }

        }



        $lossNF = null;

        if (!empty($data)) {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            foreach ($loss as $lossN) {

                if (date_diff_system(date_fmt($lossN->updated_at, 'Y-m-d'), $data['first_date']) >= 0 && date_diff_system(date_fmt($lossN->updated_at, 'Y-m-d'), $data['second_date']) <= 0) {

                    $lossNF[] = $lossN;

                }

            }

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

            "post24hour" => ($post24hour) ? count($post24hour) : 0 + $registrationDate,

            "completedOrders" => ($completedOrders) ? count($completedOrders) : 0,

            "waiting" => ($waiting) ? count($waiting) : 0,

            "inNegotiations" => ($inNegotiations) ? count($inNegotiations) : 0,

            "waitingArr" => $waiting,

            "loss" => ($loss) ? count($loss) : 0,

            "lossArr" => (!empty($data)) ? $lossNF : $loss30,

            "date" => $data

        ]);

    }

}