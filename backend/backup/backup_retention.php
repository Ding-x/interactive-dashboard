<?php
include("../connection.php");

$query = "SELECT retention,count(retention) as counts FROM backup group by retention ";

$data = array();
$resultset= mysqli_query($conn, $query);
class Backup{
    public $name;
    public $retention;
}

while($row = mysqli_fetch_array($resultset)) {
    $backup = new Backup();
    $backup->name = $row['retention'];
    $backup->retention = $row['counts'];
    $data[] = $backup;
}

mysqli_close($conn);

echo json_encode($data);
?>