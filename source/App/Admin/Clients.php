<?php

namespace Source\App\Admin;

use Source\Models\AppCity;
use Source\Models\AppState;
use Source\Models\Client;
use Source\Models\Funnel;
use Source\Models\Message;
use Source\Models\Seller;
use Source\Support\Pager;
use Source\Support\Thumb;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Clients extends Admin
{
    /**
     * Clients Constructor.
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
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/clients/home/{$s}/1")]);
            return;
        }

        $search = null;
        $clients = (new Client())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $clients = (new Client())->find("name LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$clients->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/clients/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/clients/home/{$all}/"));
        $pager->pager($clients->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        echo $this->view->render("widgets/clients/home", [
            "app" => "clients/home",
            "head" => $head,
            "search" => $search,
            "clients" => $clients->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function client(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $clientCreate = new Client();
            $clientCreate->name = $data["name"];
            $clientCreate->city = $data["city"];
            $clientCreate->state = $data["state"];
            $clientCreate->phone = $data["phone"] ? preg_replace("/[^0-9]/", "", $data["phone"]) : null;
            $clientCreate->phone_int = $data["phone_int"] ? preg_replace("/[^0-9]/", "", $data["phone_int"]) : null;
            $clientCreate->seller_id = $data["seller_id"];
            $clientCreate->registration_date = date_fmt_back($data["registration_date"]);
            $clientCreate->reason_loss = "";
            $clientCreate->status = "Negociação";
            $clientCreate->observation = $data["observation"];

            if (!$data["phone"] && !$data["phone_int"]) {
                $json["message"] = $clientCreate->message()->warning("É preciso preencher um dos campos de contato")->render();
                echo json_encode($json);
                return;
            }

            if ($clientCreate->phoneExist(preg_replace("/[^0-9]/", "", $data["phone"]))) {
                $json["message"] = $clientCreate->message()->warning("Este telefone já está cadastrado")->render();
                echo json_encode($json);
                return;
            }

            if ($clientCreate->phoneIntExist(preg_replace("/[^0-9]/", "", $data["phone_int"]))) {
                $json["message"] = $clientCreate->message()->warning("Este telefone já está cadastrado")->render();
                echo json_encode($json);
                return;
            }

            if (!$clientCreate->save()) {
                $json["message"] = $clientCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cliente cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/clients/client/{$clientCreate->id}");

            echo json_encode($json);
            return;
        }

        if ($data['client_id']) {
            if (user()->level < 5) {
                redirect("/admin/clients/home");
            }
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientUpdate = (new Client())->findById($data["client_id"]);

            if (!$clientUpdate) {
                $this->message->error("Você tentou gerenciar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/clients/home")]);
                return;
            }

            $clientUpdate->name = $data["name"];
            $clientUpdate->city = $data["city"];
            $clientUpdate->state = $data["state"];
            $clientUpdate->phone = $data["phone"] ? preg_replace("/[^0-9]/", "", $data["phone"]) : null;
            $clientUpdate->phone_int = $data["phone_int"] ? preg_replace("/[^0-9]/", "", $data["phone_int"]) : null;
            $clientUpdate->seller_id = $data["seller_id"];
            $clientUpdate->funnel_id = $data["funnel_id"];
            $clientUpdate->registration_date = date_fmt_back($data["registration_date"]);
            $clientUpdate->observation = $data["observation"];

            if (!$data["phone"] && !$data["phone_int"]) {
                $json["message"] = $clientUpdate->message()->warning("É preciso preencher um dos campos de contato")->render();
                echo json_encode($json);
                return;
            }


            if (!$clientUpdate->save()) {
                $json["message"] = $clientUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cliente atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientDelete = (new Client())->findById($data["client_id"]);

            if (!$clientDelete) {
                $this->message->error("Você tentnou deletar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/clients/home")]);
                return;
            }

            if ($clientDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientDelete->photo}");
                (new Thumb())->flush($clientDelete->photo);
            }

            $clientDelete->destroy();

            $this->message->success("O cliente foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/clients/home")]);

            return;
        }

        $clientEdit = null;
        if (!empty($data["client_id"])) {
            $clientId = filter_var($data["client_id"], FILTER_VALIDATE_INT);
            $clientEdit = (new Client())->findById($clientId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($clientEdit ? "Perfil de {$clientEdit->name}" : "Novo Cliente"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        echo $this->view->render("widgets/clients/client", [
            "app" => "clients/home",
            "head" => $head,
            "client" => $clientEdit,
            "sellers" => (new Seller())->find()->fetch(true),
            "funnels" => (new Funnel())->find()->fetch(true),
            "states" => (new AppState())->find()->fetch(true),
            "sellerSelected" => $clientEdit->seller_id,
            "funnelSelected" => $clientEdit->funnel_id,
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function address(array $data): void
    {
        if (!empty($data["state_id"])) {
            $state_id = filter_var($data["state_id"], FILTER_VALIDATE_INT);
            $cities = (new AppCity())->find("state_id = :stid", "stid={$state_id}")->fetch(true);
            foreach ($cities as $city) {
                $result[] = $city->data();
            }
            $json["cities"] = $result;
            echo json_encode($json);
        }
    }

    public function delete(?array $data)
    {
        if ($data && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientDelete = (new Client())->findById($data["client_id"]);

            if (!$clientDelete) {
                $this->message->error("Você tentou deletar os dados de um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/clients/home")]);
                return;
            }

            $clientDelete->deleteAllNegotiations();

            $this->message->success("A negociaçãp referente esse cliente foi excluída com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/dash/home")]);

            return;
        }
    }
}