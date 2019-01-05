<?php
include("../connection.php");

$query = "SELECT COUNT( time ) AS counts, time
FROM reboot
GROUP BY time";

$data = array();
$resultset= mysqli_query($conn, $query);
class Reboot{
    public $time;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $reboot = new Reboot();
    $reboot->time = $row['time'];
    $reboot->counts = $row['counts'];
    $data[] = $reboot;
}

mysqli_close($conn);

echo json_encode($data);
?>