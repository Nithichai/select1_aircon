<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new Zend\Soap\Client('https://aircon-select1-server.herokuapp.com/server.php?wsdl');

    header('Content-Type: text/xml');
    $id = $_GET['id'];
    if (is_numeric($id)) {
        try {
            $result = $client->update_goods(['id' => $id]);
            echo $result->update_goodsResult;
        } catch (SoapFault $e) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . 
                '<error>' . $e->getMessage() . '</error>';
        }
    } else {
        echo '<?xml version="1.0" encoding="UTF-8"?>' . 
                '<error>Please search in number</error>';
    }
    
?>