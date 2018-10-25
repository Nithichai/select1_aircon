<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    Air Condition<br><br>
    <form method="post" action="/result.php">
        Room: <input type="text" name="room" value="<?php echo $room;?>" require><br>
        Tempurature: <input type="text" name="temp" value="<?php echo $temp;?>" require><br>
        Humidity: <input type="text" name="humidity" value="<?php echo $humidity;?>" require><br>
        <input type="submit">
    </form>
</body>
</html>