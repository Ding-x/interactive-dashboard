<?php
include("../connection.php");

$query = "SELECT COUNT( type ) as count , type
FROM server
GROUP BY type";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerType{
    public $typeName;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverType = new ServerType();
    $serverType->typeName = $row['type'];
    $serverType->counts = $row['count'];
    $data[] = $serverType;
}

mysqli_close($conn);

echo json_encode($data);
?>