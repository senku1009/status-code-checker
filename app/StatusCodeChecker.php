<?php
$shortopts = "";
$shortopts .= "f:";// URLリストファイル（必須）
$shortopts .= "e:";// エクスポート形式（必須）
$shortopts .= "b::";// BASIC認証（オプション）
$longopts = array();
$opt = getopt($shortopts, $longopts);

if (isset($opt['f'])) {
    $file = dirname(__FILE__) . '/' . $opt['f'];
    $url_array = @file($file, FILE_IGNORE_NEW_LINES);
}

if (!isset($opt['f'])) {
    echo <<<EOT
    Status Code Checker

    Options:
        -f  URLリストファイルを指定

        -e  エクスポート形式を指定
            debug(default)
            tsv
            html
            json
            backlog

        -b  BASIC認証

    ex.> $ php this.php -f sample_url.list -e json -b USER:PASSWORD

EOT;
    exit;
}

require_once 'class/stream.class.inc.php';
require_once 'class/output.class.inc.php';

$stream = new stream;

if (isset($opt['b'])) $stream->isAuthParam($opt['b']);

$stream->makeStreamOption();

for ($i = 0; $i < count($url_array); $i++) {
    $row = array();
    $url = $url_array[$i];

    $response_header = $stream->getStatus($url);
    $status = explode(' ', $response_header[0]);
    $row[$i][0] = array($url, $status[1]);

    $j = 1;
    while (isset($response_header[$j])) {
        $status = explode(' ', $response_header[$j]);
        $location = (is_array($response_header['Location'])) ?
            $response_header['Location'][$j - 1]: $response_header['Location'];
        $row[$i][$j] = array($location, $status[1]);
        $j++;
    }

    $data[] = $row[$i];
}

$output = new output($data);
switch ($opt['e']) {
    case 'tsv':
        echo $output->tsvFormat();
        break;
    case 'html':
        echo $output->htmlFormat();
        break;
    case 'json':
        echo $output->jsonFormat();
        break;
    case 'backlog':
        echo $output->backlogFormat();
        break;
    case 'debug':
    default:
        echo $output->debug();
        break;
}
