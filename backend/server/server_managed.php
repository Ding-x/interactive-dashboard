<?php
include("../connection.php");

$query = "SELECT COUNT( managed ) as count , managed
FROM server
GROUP BY managed";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerManaged{
    public $bool;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverManaged = new ServerManaged();
    $serverManaged->bool = $row['managed'];
    $serverManaged->counts = $row['count'];
    $data[] = $serverManaged;
}

mysqli_close($conn);

echo json_encode($data);
?>