<?php

namespace Controller\Front;

class TestController extends \Controller\Front\Controller {
    public function index() {
        gd_debug('iii');

        $db = \App::load('DB');




        $insertSql = "INSERT INTO es_adminMenu 
    (adminMenuNo,
     adminMenuType,
     adminMenuProductCode,
     adminMenuPlusCode,
     adminMenuCode,
     adminMenuDepth,
     adminMenuParentNo,
     adminMenuSort,
     adminMenuName,
     adminMenuUrl, 
     adminMenuDisplayType, 
     adminMenuDisplayNo, 
     adminMenuSettingType, 
     adminMenuEcKind, 
     adminMenuHideVersion,
     regDt,
     modDt
     )
VALUES (
    'vv00001',
    'd',
    'godomall',
    null,
    'serial_register',
    3,
    'godo00052',
    1000,
    '일련번호 등록',
    'serial_register.php',
    'y',
    'godo00000',
    'd',
    'a',
    null,
    NOW(),
    null
);";

        gd_Debug($insertSql);


//        $db->fetch($insertSql);


        gd_Debug($db->query_fetch("DESC es_adminMenu"));

        $result = $db->query_fetch("SELECT * FROM es_adminMenu WHERE adminMenuName = '삭제 상품 관리'");
        gd_debug($result);
    }
}