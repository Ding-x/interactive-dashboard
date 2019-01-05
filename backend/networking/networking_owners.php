<?php

include("../connection.php");

 class Owner{
    public $names;
    public $counts;
}


$query="SELECT team.name as name, COUNT( team.name ) as counts
FROM team, subnet
WHERE subnet.owner_idx = team.team_idx
GROUP BY team.name";

$data = array();
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $owner = new Owner();
    $owner->names = $row['name'];
    $owner->counts = $row['counts'];
    $data[] = $owner;
}

mysqli_close($conn);

echo json_encode($data);




?>