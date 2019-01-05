<?php
include("../connection.php");

$query = "SELECT name, frequency, retention
FROM backup";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerBackup{
    public $name;
    public $frequency;
    public $retention;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverBackup = new ServerBackup();
    $serverBackup->name = $row['name'];
    $serverBackup->frequency = $row['frequency'];
    $serverBackup->retention = $row['retention'];
    $data[] = $serverBackup;
}

mysqli_close($conn);

echo json_encode($data);
?>