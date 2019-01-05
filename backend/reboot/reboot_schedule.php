<?php
include("../connection.php");

$query = "SELECT COUNT( schedule ) as counts , schedule
FROM reboot
GROUP BY schedule";

$data = array();
$resultset= mysqli_query($conn, $query);
class Reboot{
    public $schedule;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $reboot = new Reboot();
    $reboot->schedule = $row['schedule'];
    $reboot->counts = $row['counts'];
    $data[] = $reboot;
}

mysqli_close($conn);

echo json_encode($data);
?>