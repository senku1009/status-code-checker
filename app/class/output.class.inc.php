<?php
class output
{
    private $data = array();

    function __construct($data)
    {
        $this->data = $data;
    }

    public function tsvFormat()
    {
        $rows = '';
        for ($i = 0; $i < count($this->data); $i++) {
            $row = '';
            for ($j = 0; $j < count($this->data[$i]); $j++) {
                $row .= $this->data[$i][$j][0] . "\t" . $this->data[$i][$j][1] . "\t";
            }
            $rows .= $row . "\n";
        }
        return $rows;
    }

    public function htmlFormat()
    {
        $rows = '';
        for ($i = 0; $i < count($this->data); $i++) {
            $row = '';
            for ($j = 0; $j < count($this->data[$i]); $j++) {
                $row .= '<td>' . $this->data[$i][$j][0] . '</td><td>' . $this->data[$i][$j][1] . '</td>' . PHP_EOL;
            }

            global $redirectCount;
            $forCnt = intval($redirectCount) - count($this->data[$i]);

            $blank = '';
            for ($j = 0; $j < $forCnt; $j++) {
                $blank .= '<td></td>' . PHP_EOL;
            }

            $rows .= '<tr>' . PHP_EOL . $row . $blank . '</tr>' . PHP_EOL;
        }
        return '<table>' . PHP_EOL . $rows . '</table>' . PHP_EOL;
    }

    public function jsonFormat()
    {
        return json_encode($this->data);
    }

    public function backlogFormat()
    {
        $rows = '|開始URL|ステータス|リダイレクト先（チェーンの場合は行追加）|ステータス|h' . PHP_EOL;
        for ($i = 0; $i < count($this->data); $i++) {
            $_ = array();
            $_[] = (isset($this->data[$i][0][0])) ? $this->data[$i][0][0] : 'none';
            $_[] = (isset($this->data[$i][0][1])) ? $this->data[$i][0][1] : 'none';
            $_[] = (isset($this->data[$i][1][0])) ? $this->data[$i][1][0] : 'none';
            $_[] = (isset($this->data[$i][1][1])) ? $this->data[$i][1][1] : 'none';
            $rows .= '|' . implode('|', $_) . '|' . PHP_EOL;

            if (isset($this->data[$i][2])) {
                for ($j = 2; $j < count($this->data[$i]); $j++) {
                    $rows .= '|||' . $this->data[$i][$j][0] . '|' . $this->data[$i][$j][1]} . '|' . PHP_EOL;
                }
            }
        }
        return $rows;
    }

    public function debug()
    {
        $tmp_dump = print_r($this->data);
        return $tmp_dump;
    }

}