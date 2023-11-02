<?php

namespace Controller\Admin\Goods;

use App;
use Request;
use Component\Vincent\Serial;

class SerialPsController extends \Controller\Admin\Controller {
    
    
    public function index() {
        $postValue = Request::request()->all();
        $serial = App::load(Serial::class);
        
        switch($postValue['mode']) {
            case 'insertSerialData':

                $params = array();
                parse_str($postValue['data'], $params);

                $returnData = $serial->insertSerialData($params);

                if($returnData['error']) $this->json(['insertId' => false, 'msg' => $returnData['msg']]);
                else $this->json(['insertId' => $returnData]);

                break;

            case 'updateSerialData' :
                $params = array();
                parse_str($postValue['data'], $params);

                $returnData = $serial->updateSerialData($params);

                if($returnData['error']) $this->json(['insertId' => false, 'msg' => $returnData['msg']]);
                else $this->json(['insertId' => $returnData]);
                break;

            case 'deleteSerialNumber':
                gd_Debug($postValue);

                $serial->deleteSerialNumber($postValue);
                $this->layer('완료 되었습니다.');
                break;
        }
        
    }
    
    
}