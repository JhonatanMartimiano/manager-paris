<?php

namespace Source\App\Admin;

use Source\Models\Message;
use Source\Models\Seller;
use Source\Models\User;
use Source\Support\Pager;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Messages extends Admin
{
    /**
     * Funnel Constructor.
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
            echo json_encode(["redirect" => url("/admin/messages/home/{$s}/1")]);
            return;
        }

        $search = null;
        $user = \user()->id;
        $messages = (new Message())->find("recipient = :rcpt", "rcpt={$user}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $messages = (new Message())->find("title LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$messages->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/messages/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/messages/home/{$all}/"));
        $pager->pager($messages->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Mensagens",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = \user()->id;

        echo $this->view->render("widgets/messages/home", [
            "app" => "messages/home",
            "head" => $head,
            "search" => $search,
            "messages" => $messages->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function message(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $messageCreate = new Message();
            $messageCreate->recipient = $data["recipient"];
            $messageCreate->sender = \user()->id;
            $messageCreate->subject = $data["subject"];
            $messageCreate->content = $data["content"];

            if (!$messageCreate->save()) {
                $json["message"] = $messageCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Mensagem enviada com sucesso...")->flash();
            $json["redirect"] = url("/admin/messages/home");

            echo json_encode($json);
            return;
        }

        if ($data["message_id"]) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $message = (new Message())->findById($data["message_id"]);
            if ($message->sender != \user()->id) {
                $message->status = "open";
                $message->save();
            }
        }


        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $funnelDelete = (new Message())->findById($data["message_id"]);

            if (!$funnelDelete) {
                $this->message->error("Você tentnou deletar uma mensagem que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/messages/sends")]);
                return;
            }

            $funnelDelete->destroy();

            $this->message->success("A mensagem foi excluída com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/messages/sends")]);

            return;
        }

        $messageEdit = null;
        if (!empty($data["message_id"])) {
            $messageId = filter_var($data["message_id"], FILTER_VALIDATE_INT);
            $messageEdit = (new Message())->findById($messageId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($messageEdit ? "Perfil de {$messageEdit->name}" : "Nova Mensagem"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = \user()->id;

        echo $this->view->render("widgets/messages/message", [
            "app" => "messages/message",
            "head" => $head,
            "message" => $messageEdit,
            "recipients" => (\user()->level < 5) ? (new User())->find("level >= 5")->fetch(true) : (new User())->find("level < 5")->fetch(true),
            "recipientSelected" => (\user()->level >= 5) ? $messageEdit->recipient : $messageEdit->sender,
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function response(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $message = (new Message())->findById($data["message_id"]);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . "Responder",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = \user()->id;

        echo $this->view->render("widgets/messages/response", [
            "app" => "messages/message",
            "head" => $head,
            "message" => $message,
            "recipients" => (\user()->level < 5) ? (new User())->find("level >= 5")->fetch(true) : (new User())->find("level < 5")->fetch(true),
            "recipientSelected" => (\user()->level >= 5) ? $message->recipient : $message->sender,
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    public function sends(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/messages/sends/{$s}/1")]);
            return;
        }

        $user = \user()->id;
        $search = null;
        $messages = (new Message())->find("sender = :snd", "snd={$user}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $messages = (new Message())->find("title LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$messages->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/messages/sends");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/messages/sends/{$all}/"));
        $pager->pager($messages->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Mensagens",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = \user()->id;

        echo $this->view->render("widgets/messages/sends", [
            "app" => "messages/sends",
            "head" => $head,
            "search" => $search,
            "sends" => $messages->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }
}