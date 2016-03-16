<?php

namespace Com;

class Export {

    public $outPutFileName;
    public $outPutData;
    public $headTitle;

    function __construct($outPutPara) {

        $this->outPutFileName = $outPutPara['outPutFileName'];
        $this->outPutData = $outPutPara['outPutData'];
        $this->headTitle = $outPutPara['headTitle'];
    }

    public function __destruct() {
        
    }

    function outPutToCsv() {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->outPutFileName . '.csv"');
        header('Cache-Control: max-age=0');

        //$result = mysql_query($this->outPutData);
        $fp = fopen('php://output', 'a');
        foreach ($this->headTitle as $i => $v) {
            $this->headTitle[$i] = $v;
        }
        fputcsv($fp, $this->headTitle);

        $cnt = 0;
        $limit = 100000;
        //while ($row = mysql_fetch_row($result)) {
        foreach ($this->outPutData as $key => $row) {
            $cnt++;
            if ($limit == $cnt) {
                ob_flush();
                flush();
                $cnt = 0;
            }
            foreach ($row as $i => $v) {
                $row[$i] = $v;
            }
            fputcsv($fp, $row);
        }
    }

    public function __set($propertyName, $propertyValue) {
        $this->$propertyName = $propertyValue;
    }

    public function __get($propertyName) {
        if (isset($this->$propertyName)) {
            return $this->$propertyName;
        } else {
            return null;
        }
    }

}

?>