<?php

$echoData = Utils::arrayToXml($data);

header("Content-Type: text/xml; charset=utf-8"); 
header("Content-Length: " . strlen($echoData));
echo $echoData;







