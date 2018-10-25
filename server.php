<?php
  require_once __DIR__ . '/vendor/autoload.php';

  class AirCon {
    /**
     * Post air-condition value. ('room,temp,humiduty')
     *
     * @param string $data_packet
     * @return string $callback
     */
    public function post_aircon($data_packet) {
      list($room, $temp, $humidity, $time) = explode(",", $data_packet);

      $servername = "u28rhuskh0x5paau.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
      $username = "rfxtlqff1b3jpllv";
      $password = "qnzetmryuh5jowk0";
      $database = "z1jc6gd9aiwp5m5c";
      $conn = new mysqli($servername, $username, $password, $database);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "INSERT INTO aircon (room, temp, humidity) VALUES (?, ?, ?)";
      if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sss', $room, $temp, $humidity);
        $stmt->execute();
        $stmt->close();
        return '<payload><room>' . $room . '</room><temperature>' . $temp . 
          '</temperature><humidity>' . $humidity . '</humidity></payload>';
      } else {
        return '<error>CAN\'T INSERT DATA</error>';
      }
    }

    /**
     * Get personal data
     *
     * @return string $callback
     */
    public function get_personal_data() {
      $name = "Nithichai Thepmong";
      $id = "5801012620046";
      $hobbies =  array('Play video games', 'Watch movies');
      $sports = array('esports', 'running');

      $xml_str = '<payload><name>Nithichai Thepmong</name><id>5801012620046</id>';

      # hobbies
      $xml_str = $xml_str . '<hobbies>';
      foreach($hobbies as $hobby) {
        $xml_str = $xml_str . '<hobby>' . $hobby . '</hobby>';
      }
      $xml_str = $xml_str . '</hobbies>';

      # sports
      $xml_str = $xml_str . '<sports>';
      foreach($sports as $sport) {
        $xml_str = $xml_str . '<sport>' . $sport . '</sport>';
      }
      $xml_str = $xml_str . '</sports>';
      $xml_str = $xml_str . '</payload>';
      return $xml_str;
    }

    /**
     * Post goods ('name,addr,weight')
     *
     * @param string $data_packet
     * @return string $callback
     */
    public function post_goods($data_packet) {
      list($name, $addr, $weight) = explode(",", $data_packet);

      $servername = "u28rhuskh0x5paau.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
      $username = "rfxtlqff1b3jpllv";
      $password = "qnzetmryuh5jowk0";
      $database = "z1jc6gd9aiwp5m5c";
      $conn = new mysqli($servername, $username, $password, $database);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "INSERT INTO goods (goods_name, goods_addr, goods_weight, goods_sent) VALUES (?, ?, ?, ?)";
      if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssdi', $name, $addr, $weight, 0);
        $stmt->execute();
        $stmt->close();
        $xml_str = '<payload>' . 
          '<name>' . $name . '</name>' . 
          '<addr>' . $addr . '</addr>' . 
          '<weight>' . $weight . '</weight>' . 
          '<status>Not sent</status>' .
        '</payload>';
        return $xml_str;
      } else {
        $xml_str = '<payload>' . 
          '<error>Cannot post data</error>' .
        '</payload>';
        return $xml_str;
      }
    }
  } 

  $serverUrl = "https://" . $_SERVER['HTTP_HOST'] . "/server.php";
  $options = [
      'uri' => $serverUrl,
  ];
  $server = new Zend\Soap\Server(null, $options);

  if (isset($_GET['wsdl'])) {
      $soapAutoDiscover = new \Zend\Soap\AutoDiscover(
        new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence());
      $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
      $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
      $soapAutoDiscover->setClass('AirCon');
      $soapAutoDiscover->setUri($serverUrl);
    
      header("Content-Type: text/xml");
      echo $soapAutoDiscover->generate()->toXml();
  } else {
      $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
      $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new AirCon()));
      $soap->handle();
  }
?>