<?php
include("../connection.php");

$query = "SELECT COUNT( status ) as count , status
FROM server
GROUP BY status";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerStatus{
    public $status;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverStatus = new ServerStatus();
    $serverStatus->status = $row['status'];
    $serverStatus->counts = $row['count'];
    $data[] = $serverStatus;
}

mysqli_close($conn);

echo json_encode($data);
?>