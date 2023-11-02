<?php

namespace Controller\Front\Mypage;

use App;
use Request;
use Component\Vincent\Serial;
use Framework\Debug\Exception\AlertBackException;
use Framework\Debug\Exception\AlertRedirectException;

class SerialSearchController extends \Controller\Front\Controller {
    public function index() {

        $requestValue = Request::request()->all();
        $serial = App::load(Serial::class);

        try {

            if($requestValue['keyword']) {
                $result = $serial->getSerialNumberData($requestValue['keyword']);

                    if($result) {
                        //$result['scmName'] = preg_replace('/(?<=.{1})./u','*', $result['scmName']);
//                        $result['scmName'] = mb_substr($result['scmName'], 0, -2).'**';
                        $result['companyName'] = mb_substr($result['companyName'], 0, -2).'**';
                        $result['agentName'] = mb_substr($result['agentName'], 0, -2).'**';
                    }

                $this->setData('serialData', $result);
                $this->setData('serialNumber', $requestValue['keyword']);
            }


        } catch(AlertRedirectException $e) {
            throw $e;
        }


    }
}