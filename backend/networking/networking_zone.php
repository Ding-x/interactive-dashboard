<?php

include("../connection.php");

 class Zone{
    public $names;
    public $counts;
}



$query="SELECT zone.name, COUNT( zone.name ) AS counts
FROM zone, subnet
WHERE zone.zone_idx = subnet.zone_idx
GROUP BY zone.name";
$data = array();
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $zone = new Zone();
    $zone->names = $row['name'];
    $zone->counts = $row['counts'];
    $data[] = $zone;
}

mysqli_close($conn);

echo json_encode($data);




?>