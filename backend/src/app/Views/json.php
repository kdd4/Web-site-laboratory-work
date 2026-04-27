<?php
header('Content-Type: application/json; charset=utf-8');

$jsonData = json_encode($data);

echo $jsonData;