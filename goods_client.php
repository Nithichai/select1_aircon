<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new Zend\Soap\Client('https://aircon-select1-server.herokuapp.com/server.php?wsdl');

    header('Content-Type: text/xml');
    $name = 'Nopy';
    $addr = 'Namek';
    $weight = '0.1';
    $data_str = $name . ',' . $addr . ',' . $weight;
    try {
        $result = $client->post_goods(['data_packet' => $data_str]);
        echo $result->post_goodsResult;
    } catch (SoapFault $e) {
        echo '<?xml version="1.0" encoding="UTF-8"?>' . 
            '<error>' . $e->getMessage() . '</error>';
    }
?>