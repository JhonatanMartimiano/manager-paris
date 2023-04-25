<?php

namespace Source\App\Admin;

use Source\Models\Notification;
use Source\Models\Seller;

/**
 * Class Notifications
 * @package Source\App\Admin
 */
class Notifications extends Admin
{
    /**
     * Notifications Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function notification(?array $data)
    {
        if ($data) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $seller = (new Seller())->findById($data["seller_id"]);
            $json = [
                "full_name" => $seller->fullName(),
                "content" => ($seller->notification()->content) ?? null,
                "status" => ($seller->notification()->status) ?? 'inactive'
            ];
            echo json_encode($json);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $seller = (new Seller())->findById($data["seller_id"]);
            if ($seller->notification()) {
                $notification = (new Notification())->findById($seller->notification()->id);
                $notification->content = $data["content"];
                $notification->status = $data["status"];
                $notification->seller_id = $data["seller_id"];
                if (!$notification->save()) {
                    $json["message"] = $notification->message()->render();
                    echo json_encode($json);
                    return;
                }
                $json["status"] = "success";
                echo json_encode($json);
            } else {
                $notification = new Notification();
                $notification->content = $data["content"];
                $notification->status = $data["status"];
                $notification->seller_id = $data["seller_id"];
                if (!$notification->save()) {
                    $json["message"] = $notification->message()->render();
                    echo json_encode($json);
                    return;
                }
                $json["status"] = "success";
                echo json_encode($json);
            }
        }
    }
}