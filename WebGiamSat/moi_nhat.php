<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
$db = mysqli_connect("localhost","root","root","do_an"); 
$sql = "SELECT * FROM image WHERE Time LIKE (SELECT MAX(Time) FROM image) AND ID LIKE (SELECT MAX(ID) FROM image)";
$result = $db->query($sql);


while($row = mysqli_fetch_array($result)){   

    echo "<img src='",$row['Url'],"' height='50%' width='100%'/>";
    echo $row['Time'];
    echo"<br>";
}
echo header("refresh: 4");
?>
</body>
</html>
