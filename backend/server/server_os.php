<?php
include("../connection.php");

$query = "SELECT COUNT( os ) as count , os
FROM server
GROUP BY os";

$data = array();
$resultset= mysqli_query($conn, $query);
class OSType{
    public $osName;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $osType = new OSType();
    $osType->osName = $row['os'];
    $osType->counts = $row['count'];
    $data[] = $osType;
}

mysqli_close($conn);

echo json_encode($data);
?>