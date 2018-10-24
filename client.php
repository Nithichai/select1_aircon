<<!DOCTYPE html>
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
    try {
        $
        $result = $client->post_aircon([
            'data_packet' => '81-506,30.1,68.4'
        ]);
        echo $result->post_airconResult;
    } catch (SoapFault $e) {
        echo "Can't insert value.";
    }
    ?>
</body>
</html>>