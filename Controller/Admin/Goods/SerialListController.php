<?php

namespace Controller\Admin\Goods;

use App;
use Request;
use Component\Vincent\Serial;
use Framework\Debug\Exception\AlertBackException;

class SerialListController extends \Controller\Admin\Controller {
    public function index() {
        $this->callMenu('goods', 'goods', 'serial_list');


        try {

            $getValue = Request::get()->toArray();


            $serial = App::load(Serial::class);

            if(!$getValue['page']) $getValue['page'] = 1;
            if(!$getValue['pageNum']) $getValue['pageNum'] = 10;

            $getData = $serial->getSerialList($getValue, $getValue['page'], $getValue['pageNum']);


            $page = \App::load("\Component\Page\Page", $getValue['page'], $getData['total'], $getData['amount'], $getValue['pageNum']);


            $data = $getData['data'];
            $this->setData('search', $getValue);
            $this->setData('data', $data);
            $this->setData('page', $page);

        } catch(AlertBackException $e) {
            throw $e;
        }
    }
}