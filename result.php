<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new Zend\Soap\Client('https://aircon-select1-server.herokuapp.com/server.php?wsdl');

    $room = $temp = $humidity = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $room = test_input($_POST["room"]);
        $temp = test_input($_POST["temp"]);
        $humidity = test_input($_POST["humidity"]);

        try {
            header("Content-Type: text/xml");
            $result = $client->post_aircon([
                'data_packet' => $room . ',' . $temp . ',' . $humidity
            ]);
            echo $result->post_airconResult;
        } catch (SoapFault $e) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . 
                '<error>' . $e->getMessage() . '</error>';
        }
    }

    function test_input($data) {
        $data = trim($data);
        return $data;
    }
?>