<?php

namespace Controller\Admin\Goods;

use App;
use Request;
use Component\Vincent\Serial;


class SerialRegisterController extends \Controller\Admin\Controller {
    public function index() {
        $this->callMenu('goods', 'goods', 'serial_reg');


        $this->getView()->setDefine('layout', 'layout_blank.php');

        $requestValue =  Request::get()->toArray();

        if($requestValue['serialNumber']) {
            $serial = App::load(Serial::class);

            $data = $serial->getSerialNumberData($requestValue['serialNumber']);

            $this->setData('data', $data);
            $this->setData('mode', 'update');

        }
    }
}