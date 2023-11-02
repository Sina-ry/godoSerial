<?php

namespace Controller\Admin\Goods;

use App;
use Request;

class SerialExcelDownController extends \Controller\Admin\Controller {

    protected $db;

    protected $excelHeader;
    protected $excelFooter;

    public function pre()
    {
        $this->initHeader();
        $this->initFooter();

    }

    public function index() {
        $this->db = App::load("DB");

        $getValue = Request::get()->toArray();

        gd_Debug($getValue);

        $strWhere = "";

        if($getValue['key'] && $getValue['keyword']) $strWhere = " WHERE " . $getValue['key'] . " LIKE '%" . $getValue['keyword'] . "%'";


        $sql = "SELECT * FROM vv_serialList " . $strWhere;
        $result = $this->db->query_fetch($sql);


        $Title = date("Y-m-d").".xls";

        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename={$Title}");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);

        echo $this->excelHeader;

        ?>
		<table border='1'>
			<tr>
				<?php  //if($getValue['mode']!="none"){?>
				<!--<td class="title">장바구니키</td>-->
				<?php //}?>
				<td class="title">일련번호</td>
				<td class="title">모델명</td>
				<!--<td class="title">수량</td>-->
				<td class="title">공급사</td>
				<td class="title">고객사</td>
				<td class="title">구매일자</td>
				<td class="title">설치기사이름</td>
<!--				<td class="title">전화번호</td>-->
			</tr>
		<?php

		foreach($result as $key => $value){
			?>

			<tr>
				<td><?= $value['serialNumber'] ?></td>
				<td><?= $value['model'] ?></td>
				<!--<td><?php /*= $value['quantity'] */?></td>-->
				<td><?= $value['scmName'] ?></td>
				<td><?= $value['companyName'] ?></td>
				<td><?= $value['buyDate'] != '0000-00-00 00:00:00' ? substr($value['buyDate'], 0, 10) : '' ?></td>
				<td><?= $value['agentName'] ?></td>
<!--				<td>--><?php //= $value['cellPhone'] ?><!--</td>-->
			</tr>
		<?php

		}///END Foreach


		echo"</table>";
		echo $this->excelFooter;
		exit();
        
    }

    private function initHeader()
    {

        $this->excelHeader = '<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">' . chr(10);
        $this->excelHeader .= '<head>' . chr(10);
        $this->excelHeader .= '<title>일련번호 리스트</title>' . chr(10);
        $this->excelHeader .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . chr(10);
        $this->excelHeader .= '<style>' . chr(10);
        $this->excelHeader .= 'br{mso-data-placement:same-cell;}' . chr(10);
        $this->excelHeader .= '.xl31{mso-number-format:"0_\)\;\\\(0\\\)";}' . chr(10);
        $this->excelHeader .= '.xl24{mso-number-format:"\@";} ' . chr(10);
        $this->excelHeader .= '.title{font-weight:bold; background-color:#c6f5c7; text-align:center;height:40px;} ' . chr(10);
        $this->excelHeader .= '.od{color:red;} ' . chr(10);
        $this->excelHeader .= '.blue{color:#1ad6f5;} ' . chr(10);
        $this->excelHeader .= '.or{color:#e1e892;} ' . chr(10);
        $this->excelHeader .= '.adr{width:500px;} ' . chr(10);
        $this->excelHeader .= '.vertical{vertical-align:top;} ' . chr(10);
        $this->excelHeader .= '</style>' . chr(10);
        $this->excelHeader .= '</head>' . chr(10);
        $this->excelHeader .= '<body>' . chr(10);
    }

    private function initFooter()
    {
        $this->excelFooter = '</body>' . chr(10);
        $this->excelFooter .= '</html>' . chr(10);
    }
}
