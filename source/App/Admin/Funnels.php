<?php

namespace Source\App\Admin;

use Source\Models\Funnel;
use Source\Models\Message;
use Source\Support\Pager;
use Source\Support\Thumb;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Funnels extends Admin
{
    /**
     * Funnels Constructor.
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
            echo json_encode(["redirect" => url("/admin/funnels/home/{$s}/1")]);
            return;
        }

        $search = null;
        $funnels = (new Funnel())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $funnels = (new Funnel())->find("title LIKE CONCAT('%', :s, '%')", "s={$search}");
            if (!$funnels->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/funnels/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/funnels/home/{$all}/"));
        $pager->pager($funnels->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Funis",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $userID = user()->id;

        echo $this->view->render("widgets/funnels/home", [
            "app" => "funnels/home",
            "head" => $head,
            "search" => $search,
            "funnels" => $funnels->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function funnel(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $funnelCreate = new Funnel();
            $funnelCreate->title = $data["title"];
            $funnelCreate->description = $data["description"];
            $funnelCreate->sequence = $data["sequence"];

            if (!$funnelCreate->save()) {
                $json["message"] = $funnelCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Funil cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/funnels/funnel/{$funnelCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $funnelUpdate = (new Funnel())->findById($data["funnel_id"]);

            if (!$funnelUpdate) {
                $this->message->error("Você tentou gerenciar um funil que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/funnels/home")]);
                return;
            }

            $funnelUpdate->title = $data["title"];
            $funnelUpdate->description = $data["description"];
            $funnelUpdate->sequence = $data["sequence"];

            if (!$funnelUpdate->save()) {
                $json["message"] = $funnelUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Funil atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $funnelDelete = (new Funnel())->findById($data["funnel_id"]);

            if (!$funnelDelete) {
                $this->message->error("Você tentnou deletar um funil que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/funnels/home")]);
                return;
            }

            if ($funnelDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$funnelDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$funnelDelete->photo}");
                (new Thumb())->flush($funnelDelete->photo);
            }

            $funnelDelete->destroy();

            $this->message->success("O funil foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/funnels/home")]);

            return;
        }

        $funnelEdit = null;
        if (!empty($data["funnel_id"])) {
            $funnelId = filter_var($data["funnel_id"], FILTER_VALIDATE_INT);
            $funnelEdit = (new Funnel())->findById($funnelId);
        }

        $userID = user()->id;

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($funnelEdit ? "Perfil de {$funnelEdit->name}" : "Novo Funil"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/funnels/funnel", [
            "app" => "clients/home",
            "head" => $head,
            "funnel" => $funnelEdit,
            "notification" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->count(),
            "notifications" => (new Message())->find("sender != {$userID} AND recipient = {$userID} AND status = 'closed'")->fetch(true)
        ]);
    }
}