<?php

namespace Component\Vincent;

use App;


class Serial {

    protected $db;

    public function __construct() {
        $this->db = App::load('DB');
    }


    public function insertSerialData($data) {

        $bind = [
            "serialNumber",
            "companyName",
            "quantity",
            "buyDate",
            "agentName",
            "cellPhone",
            "model"
    ];

        $param = [
            "ssissss",
            $data['serialNumber'],
            $data['companyName'],
            $data['quantity'],
            $data['buyDate'],
            $data['agentName'],
            $data['cellPhone'],
            $data['model']
        ];

        $this->db->set_insert_db("vv_serialList", $bind, $param, 'y');
    }
}
