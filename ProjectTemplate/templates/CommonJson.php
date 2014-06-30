<?php

$echoData = json_encode($data);

header("Content-Type: application/json; charset=utf-8");
header("Content-Length: " . strlen($echoData));
echo $echoData;


