<?php
include("../connection.php");

$query = "SELECT frequency,count(frequency) as counts FROM backup group by frequency";

$data = array();
$resultset= mysqli_query($conn, $query);
class Backup{
    public $name;
    public $frequency;
}

while($row = mysqli_fetch_array($resultset)) {
    $backup = new Backup();
    $backup->name = $row['frequency'];
    $backup->frequency = $row['counts'];
    $data[] = $backup;
}

mysqli_close($conn);

echo json_encode($data);
?>