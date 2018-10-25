<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new Zend\Soap\Client('https://aircon-select1-server.herokuapp.com/server.php?wsdl');

    $roomErr = $tempErr = $humidityErr = "";
    $room = $temp = $humidity = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["room"])) {
            $roomErr = "Room is required";
        } else {
            $room = test_input($_POST["room"]);
        }
        
        if (empty($_POST["temp"])) {
            $tempErr = "Temperature is required";
        } else {
            $temp = test_input($_POST["temp"]);
            if (!preg_match("/^[1-9.]*$/", $temp)) {
                $tempErr = "Only number allowed"; 
            }
        }
            
        if (empty($_POST["humidity"])) {
            $humidityErr = "Humidity is required";
        } else {
            $humidity = test_input($_POST["humidity"]);
            if (!preg_match("/^[1-9.]*$/", $temp)) {
                $humidityErr = "Only number allowed"; 
            }
        }
    }

    function test_input($data) {
        $data = trim($data);
        return $data;
    }
?>