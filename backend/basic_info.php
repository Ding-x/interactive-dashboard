<?php

include("./connection.php");

 class BasicData{
    public $server_count;
    public $app_count;
    public $team_count;
    public $ip_count;
}

$basicData = new BasicData();
$query="select COUNT(server.server_idx) as server_count FROM server";
$resultset= mysqli_query($conn, $query);
while($row = mysqli_fetch_array($resultset)) {
    $basicData->server_count = $row['server_count'];
}

$query="select COUNT(application.application_idx) as app_count FROM application";
$resultset= mysqli_query($conn, $query);
while($row = mysqli_fetch_array($resultset)) {
    $basicData->app_count = $row['app_count'];
}

$query="select COUNT(team.team_idx) as team_count FROM team";
$resultset= mysqli_query($conn, $query);
while($row = mysqli_fetch_array($resultset)) {
    $basicData->team_count = $row['team_count'];
}

$query="select COUNT(ip.address) as ip_count FROM ip";
$resultset= mysqli_query($conn, $query);
while($row = mysqli_fetch_array($resultset)) {
    $basicData->ip_count = $row['ip_count'];
}

mysqli_close($conn);

echo json_encode($basicData);



?>