<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
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

            try {
                $result = $client->post_aircon([
                    'data_packet' => $room . ',' . $temp . ',' . $humidity
                ]);
                echo $result->post_airconResult;
            } catch (SoapFault $e) {
                echo '<?xml version="1.0" encoding="UTF-8"?>' . 
                    '<error>Can\'t insert data</error>';
            }
        }

        function test_input($data) {
            $data = trim($data);
            return $data;
        }
    ?>

    Air Condition<br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Room: <input type="text" name="room" value="<?php echo $room;?>" require><br>
        Tempurature: <input type="text" name="temp" value="<?php echo $temp;?>" require><br>
        Humidity: <input type="text" name="humidity" value="<?php echo $humidity;?>" require><br>
        <input type="submit">
    </form>
</body>
</html>