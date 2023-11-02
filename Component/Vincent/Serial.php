<?php

namespace Component\Vincent;

use App;


class Serial {

    protected $db;

    public function __construct() {
        $this->db = App::load('DB');
    }


    public function insertSerialData($data) {

        $checkSerialNumberCount = $this->getSerialNumber($data['serialNumber']);

        if($checkSerialNumberCount['cnt'] > 0) return ['error' => 1, 'msg' => '이미 존재하는 일련번호 입니다.'];

        $bind = [
            "serialNumber",
            "companyName",
            "scmName",
            "quantity",
            "buyDate",
            "agentName",
            "model"
    ];

        $param = [
            "sssisss",
            $data['serialNumber'],
            $data['companyName'],
            $data['scmName'],
            $data['quantity'],
            $data['buyDate'],
            $data['agentName'],
            $data['model']
        ];


        $this->db->set_insert_db("vv_serialList", $bind, $param, 'y');
        return $this->db->insert_id();
    }


    public function updateSerialData($data) {
        $bind = [
            "serialNumber = ?",
            "companyName = ?",
            "scmName = ?",
            "quantity = ?",
            "buyDate = ?",
            "agentName = ?",
            "model = ?"
        ];

        $param = [
            "sssissss",
            $data['serialNumber'],
            $data['companyName'],
            $data['scmName'],
            $data['quantity'],
            $data['buyDate'],
            $data['agentName'],
            $data['model'],
            $data['serialNumber']
        ];

        $result = $this->db->set_update_db("vv_serialList", $bind, 'serialNumber = ?', $param);
        return $result;
    }

    public function getSerialNumber($serialNumber) {
        $arrBind = [];

        $this->db->strField = "COUNT(serialNumber) as cnt";
        $this->db->strWhere = "serialNumber = ?";

        $this->db->bind_param_push($arrBind, 's', $serialNumber);

        $query = $this->db->query_complete();

        $sql = "SELECT " . array_shift($query) . " FROM vv_serialList " . implode(" ", $query);
        $result = $this->db->query_fetch($sql, $arrBind, false);

        return $result;
    }
    
    public function getSerialList($in, $page = 1, $pageNum = 10) {
        $page = ($page - 1) * $pageNum;

        //검색어가 존재하는 경우 검색 필드명과 겸색값을 조합해서 쿼리 작성
        if($in['key'] && $in['keyword']) {
            $arrWhere[] = $in['key'] . " LIKE '%" . $in['keyword'] . "%'";
        }


        if($in['sort']) $arrOrder[] = $in['sort'];
        
        


        $this->db->strWhere = implode(' AND ', $arrWhere);

//        $this->db->strJoin = "LEFT JOIN wm_eventLocation AS el ON e.eventZoneSno = el.sno LEFT JOIN wm_eventType AS et ON e.eventTypeSno = et.sno";
        $this->db->strLimit = $page .",". $pageNum;
        $this->db->strOrder = implode(', ', $arrOrder);

        $query = $this->db->query_complete();

        $sql = "SELECT " . array_shift($query) . " FROM vv_serialList " . implode(' ', $query);
        $list = $this->db->query_fetch($sql);

        $this->db->strField = "COUNT(*) as cnt";

        $query = $this->db->query_complete();
        $sql = "SELECT " . array_shift($query) . " FROM vv_serialList " . implode(' ', $query);
        $tmp = $this->db->query_fetch($sql);

        // 전체개수
        $amount = $tmp[0]['cnt'];


        $this->db->strWhere = implode(' AND ', $arrWhere);

        $query = $this->db->query_complete();

        $sql = "SELECT " . array_shift($query) . " FROM vv_serialList " . implode(' ', $query);
        $tmp = $this->db->query_fetch($sql);


        // 검색된 개수
        $total = COUNT($tmp);

        $arrData['data'] = $list;
        $arrData['amount'] = $amount;
        $arrData['total'] = $total;

        return $arrData;
    }


    public function deleteSerialNumber($postValue) {
        foreach($postValue['sno'] as $key => $val) {
            $this->db->set_delete_db("vv_serialList",'sno = ?', ['i', $val] );
        }
    }

    public function getSerialNumberData($serialNumber) {
        $arrBind = [];

        $this->db->strWhere = "serialNumber = ?";
        $this->db->bind_param_push($arrBind, 's', $serialNumber);

        $query = $this->db->query_complete();

        $sql = "SELECT " . array_shift($query) . " FROM vv_serialList " . implode(' ', $query);
        $result = $this->db->query_fetch($sql, $arrBind, false);

        return $result;
    }
}
