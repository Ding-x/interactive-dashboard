<?php
include("../connection.php");

$query = "SELECT count(team.name) as count, team.name as name
FROM server,team
WHERE server.owner_idx=team.team_idx
GROUP BY team.name";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerOwner{
    public $owner;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverOwner = new ServerOwner();
    $serverOwner->owner = $row['name'];
    $serverOwner->counts = $row['count'];
    $data[] = $serverOwner;
}

mysqli_close($conn);

echo json_encode($data);
?>