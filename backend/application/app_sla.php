<?php

include("../connection.php");

 class App{
    public $sla;
    public $count;
}


$query="SELECT sla, COUNT( sla ) as counts
FROM  `application` 
GROUP BY sla";

$data = array();
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $app = new App();
    $app->sla = $row['sla'];
    $app->count = $row['counts'];
    $data[] = $app;
}

mysqli_close($conn);

echo json_encode($data);




?>