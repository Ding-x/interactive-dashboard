<?php
include("../connection.php");

$query = "SELECT baremetal, count( baremetal) as counts FROM backup group by baremetal";

$data = array();
$resultset= mysqli_query($conn, $query);
class Backup{
    public $baremetal;
    public $count;
}

while($row = mysqli_fetch_array($resultset)) {
    $backup = new Backup();
    $backup->baremetal = $row['baremetal'];
    $backup->count = $row['counts'];
    $data[] = $backup;
}

mysqli_close($conn);

echo json_encode($data);
?>