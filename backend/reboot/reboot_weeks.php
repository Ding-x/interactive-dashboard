<?php
include("../connection.php");

$query = "SELECT COUNT( weeks ) as counts , weeks
FROM reboot
GROUP BY weeks";

$data = array();
$resultset= mysqli_query($conn, $query);
class Reboot{
    public $weeks;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $reboot = new Reboot();
    $reboot->weeks = $row['weeks'];
    $reboot->counts = $row['counts'];
    $data[] = $reboot;
}

mysqli_close($conn);

echo json_encode($data);
?>