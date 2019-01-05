<?php
include("../connection.php");

$query = "SELECT COUNT( enabled ) as counts , enabled
FROM reboot
GROUP BY enabled";

$data = array();
$resultset= mysqli_query($conn, $query);
class Reboot{
    public $enabled;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $reboot = new Reboot();
    $reboot->enabled = $row['enabled'];
    $reboot->counts = $row['counts'];
    $data[] = $reboot;
}

mysqli_close($conn);

echo json_encode($data);
?>