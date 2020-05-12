<?php
require_once 'class/stream.cls.php';

if ( !isset($_POST['url']) ) {
    die();
}

$stream = new stream;
$row = array();

$response_header = $stream->getStatus($_POST['url']);
$status = explode(' ', $response_header[0]);

$row[0] = array($url, $status[1]);

$j = 1;
while (isset($response_header[$j])) {
    $status = explode(' ', $response_header[$j]);

    $location = (is_array($response_header['Location'])) ?
        $response_header['Location'][$j - 1] : $response_header['Location'];

    $row[$j] = array($location, $status[1]);
    $j++;
}
header('Content-type: text/plain; charset=UTF-8');
echo json_encode($row);
exit();
